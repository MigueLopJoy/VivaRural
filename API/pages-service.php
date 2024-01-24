<?php
include "./../LIB/COMMON/PHP/dbConnection.php";
include "./../LIB/COMMON/PHP/towns-service.php";
include "./../LIB/COMMON/PHP/pages-service.php";
include "./../LIB/COMMON/PHP/articles-service.php";

if (isset($_GET['get-page'])) {
    $pageId = $_GET['get-page'];
    $pageContent = getPageContentFromPageId($pageId);
    echo json_encode($pageContent);
} else if (isset($_GET['save-comment'])) {
    if (saveComment()) {
        http_response_code(200);
        echo json_encode(array('responseCode' => 200, 'message' => 'Comentario enviado con éxito'));
    } else {
        http_response_code(400);
        echo json_encode(array('responseCode' => 400, 'message' => 'El comentario no pudo ser enviado'));
    }
} else if (isset($_GET['get-comments'])) {
    if (isset($_GET['id'])) {
        $comments = getComments($_GET['id']);
        echo json_encode($comments);
    }
} else if (isset($_GET['get-rating'])) {
    echo getRating($_GET['id'])['rating'];
}

function saveComment()
{
    $json_data = file_get_contents("php://input");
    $commentData = json_decode($json_data, true);

    $user = $commentData['user'];
    $page = $commentData['page'];
    $rating = $commentData['rating'];
    $text = $commentData['text'];

    $connection = connect();
    $insertQuery = "insert into reviews(user, rating, text, page) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("iisi", $user, $rating, $text, $page);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getComments($pageId)
{
    $sql = '
        SELECT u.firstname, u.lastname, r.text, r.rating 
        FROM reviews r
        INNER JOIN town_pages tp
        ON r.page = tp.id
        INNER JOIN users u
        ON r.user = u.id
        WHERE r.page = ' . $pageId . ';
    ';
    return getMultipleSearchResult($sql);
}

function getRating($pageId)
{
    $sql = '
        SELECT AVG(rating) as rating
        FROM reviews 
        WHERE page = ' . $pageId . ' 
    ';
    return getSingleSearchResult($sql);
}
