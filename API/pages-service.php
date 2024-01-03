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
    saveComment($_POST, $pageId);
} else if (isset($_GET['get-comments'])) {
    if (isset($_GET['pageId'])) {
        $comments = getComments($_GET['pageId']);
        echo json_encode($comments);
    }
}


function saveComment($comment, $pageId)
{
    $userId = $_POST['userId'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $connection = connect();
    $insertQuery = "insert into reviews(userId, rating, comment, pageId) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("iisi", $userId, $rating, $comment, $pageId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getComments($pageId)
{
    $sql = '
        SELECT u.firstname, u.lastname, r.comment, r.rating 
        FROM reviews r
        INNER JOIN town_pages tp
        ON r.pageId = tp.pageId
        INNER JOIN users u
        ON r.userId = u.userId
        WHERE r.pageId = ' . $pageId . ';
    ';
    return getMultipleSearchResult($sql);
}
