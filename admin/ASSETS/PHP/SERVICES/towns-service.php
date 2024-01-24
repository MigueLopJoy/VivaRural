<?php

function getLastTowns()
{
    $sql = 'SELECT MAX(id) as id FROM towns;';
    return getSingleSearchResult($sql);
}

function getTowns($townData)
{
    $sql =
        '
        SELECT *
        FROM towns t
        WHERE 1
    ';
    if (!empty($townData['townName'])) {
        $sql .= ' AND t.townName = "' . $townData['townName'] . '"';
    }
    if (!empty($townData['postalCode'])) {
        $sql .= ' AND t.postalCode = "' . $townData['postalCode'] . '"';
    }
    if (!empty($townData['region'])) {
        $sql .= ' AND t.region = "' . $townData['region'] . '"';
    }
    if (!empty($townData['province'])) {
        $sql .= ' AND t.province = "' . $townData['province'] . '"';
    }
    if (!empty($townData['minRating'])) {
        $sql .= ' AND t.rating >= "' . $townData['minRating'] . '"';
    }
    if (!empty($townData['maxRating'])) {
        $sql .= ' AND t.rating <= "' . $townData['maxRating'] . '"';
    }
    $sql .= ';';
    return getMultipleSearchResult($sql);
}
