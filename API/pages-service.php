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
    saveComment($_POST);
}


function saveComment($comment)
{
    $userId = $_POST['userId'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $pageId = 73;

    $connection = connect();
    $insertQuery = "insert into reviews(userId, rating, comment, pageId) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("iisi", $userId, $rating, $comment, $pageId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}
