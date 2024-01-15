<?php

function createTown($townInfo)
{
    $townName = $townInfo['townName'];
    $region = $townInfo['region'];
    $province = $townInfo['province'];
    $postalCode = $townInfo['postalCode'];

    $connection = connect();
    $insertQuery = "insert into towns(townName, region, province, postalCode) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("ssss", $townName, $region, $province, $postalCode);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getLastInsertedTownId()
{
    $sql = 'SELECT MAX(townId) as townId FROM towns;';
    return getSingleSearchResult($sql);
}

function searchTown($townData)
{
    $towns = getTowns($townData);
    $serializedData = base64_encode(json_encode($towns));
    $url = '?table=towns&data=' . $serializedData;
    header('Location: ' . $url);
}

function getTowns($townData)
{
    $sql =
        '
        SELECT * FROM towns t
        WHERE 1
    ';
    if (!empty($townData['townName'])) {
        $sql .= ' AND t.townName = "' . $townData['townName'] . '"';
    }
    if (!empty($townData['postalCode'])) {
        $sql .= ' AND t.postalCode = "' . $townData['postalCode'] . '"';
    }
    if (!empty($townData['region'])) {
        $sql .= ' AND t.region = "' . $townData['region'] .'"';
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
