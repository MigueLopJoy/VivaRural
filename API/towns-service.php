<?php
include "./../LIB/COMMON/PHP/dbConnection.php";

if (isset($_GET['get-destinations'])) {
    $response = getDestinations();
    echo json_encode($response);
}

function getDestinations()
{
    $sql = '
        SELECT t.name, tp.id, t.thumbnail
        FROM towns t 
        INNER JOIN town_pages tp
        ON t.id = tp.town
    ';
    return getMultipleSearchResult($sql);
}
