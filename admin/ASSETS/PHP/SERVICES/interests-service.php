<?php

function getInterests($interestData)
{
    $sql = '
        SELECT *
        FROM interests
        WHERE 1
    ';
    if (isset($interestData) && !empty($interestData['name'])) {
        $sql .= ' AND name = "' . $interestData['name'] . '"';
    }
    $sql .= ';';
    return getMultipleSearchResult($sql);
}

function getLastInterests()
{
    $sql = 'SELECT MAX(id) as id FROM interests;';
    return getSingleSearchResult($sql);
}
