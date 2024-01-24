<?php
function getTownNameFromPageId($pageId)
{
    $sql = '
        SELECT name FROM towns t
        INNER JOIN town_pages tp
        ON t.id = tp.town
        WHERE tp.id = ' . $pageId . '
    ';
    return getSingleSearchResult($sql);
}
