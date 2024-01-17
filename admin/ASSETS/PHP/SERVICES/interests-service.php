<?php

function createInterest($interestInfo)
{
    $interestName = $interestInfo['interestName'];
    $connection = connect();
    $insertQuery = "insert into interests(interestName) values(?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("s", $interestName);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getInterests($interestData)
{
    $sql = '
        SELECT *
        FROM interests
        WHERE 1
    ';
    if (isset($interestData) && !empty($interestData['interestName'])) {
        $sql .= ' AND interestName = "' . $interestData['interestName'] . '"';
    }
    $sql .= ';';
    return getMultipleSearchResult($sql);
}
