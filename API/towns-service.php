<?php
include "./../LIB/COMMON/PHP/dbConnection.php";

if (isset($_GET['get-destinations'])) {
    $response = getHighlightedDestinations();
    echo json_encode($response);
}

function getHighlightedDestinations()
{
    $sql = '
        SELECT t.townName, tp.pageId, tp.thumbnail
        FROM towns t 
        INNER JOIN town_pages tp
        ON t.townId = tp.townId
    ';
    return getMultipleSearchResult($sql);
}
