<?php
function getTownNameFromPageId($pageId)
{
    $sql = '
        SELECT townName FROM towns t
        INNER JOIN town_pages tp
        ON t.townId = tp.townId
        WHERE tp.pageId = ' . $pageId . '
    ';
    return getSingleSearchResult($sql);
}
