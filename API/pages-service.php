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
    if (isset($_GET['pageId'])) {
        $comments = getComments($_GET['pageId']);
        echo json_encode($comments);
    }
}


function saveComment()
{
    $json_data = file_get_contents("php://input");
    $commentData = json_decode($json_data, true);

    $userId = $commentData['userId'];
    $pageId = $commentData['pageId'];
    $rating = $commentData['rating'];
    $commentText = $commentData['commentText'];

    $connection = connect();
    $insertQuery = "insert into reviews(userId, rating, commentText, pageId) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("iisi", $userId, $rating, $commentText, $pageId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getComments($pageId)
{
    $sql = '
        SELECT u.firstname, u.lastname, r.commentText, r.rating 
        FROM reviews r
        INNER JOIN town_pages tp
        ON r.pageId = tp.pageId
        INNER JOIN users u
        ON r.userId = u.userId
        WHERE r.pageId = ' . $pageId . ';
    ';
    return getMultipleSearchResult($sql);
}
