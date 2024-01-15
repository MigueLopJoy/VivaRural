<?php

function insertTownInfo($townInfo)
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
    $townInfo = null;
    if (isset($townData['townName'])) {
        $townInfo = findTownByTownName(($townData['townName']));
    }
    return $townInfo;
}

function findTownByTownName($townData)
{
    $sql =
        '
        SELECT * FROM towns t
        WHERE
    ';
    if (isset($townData['townName'])) {
        echo
        '
            t.townName = "' . $townData['townName'] . '";
        AND
        ';
    }
    if (isset($townData['postalCode'])) {
        echo
        '
            t.postalCode = "' . $townData['postalCode'] . '";
        AND
        ';
    }
    if (isset($townData['region'])) {
        echo
        '
            t.region = "' . $townData['region'] . '";
        AND
        ';
    }
    if (isset($townData['province'])) {
        echo
        '
            t.province = "' . $townData['province'] . '";
        AND
        ';
    }
    if (isset($townData['rating'])) {
        echo
        '
                t.rating >= "' . $townData['minRating'] . '";
            AND
                t.rating >= "' . $townData['maxRating'] . '";
            ';
    }


    return getSingleSearchResult($sql);
}
