<?php

function createInterest($interestInfo)
{
    $interestName = $interestInfo['interestName'];
    $connection = connect();
    $insertQuery = "insert into interests(interestName) values(?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("ssss", $interestName);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function searchInterest($interestData)
{
    $interests = getInterests($interestData);
    $serializedData = base64_encode(json_encode($interests));
    $url = '?table=interests&data=' . $serializedData;
    header('Location: ' . $url);
}

function getInterests($interestData)
{
    $sql = '
    SELECT interestId as id, interestName
    FROM interests r
    WHERE 1
    ';
    if (!empty($interestData['interestName'])) {
        $sql .= ' AND r.interestName = "' . $interestData['interestName'] . '"';
    }
    $sql .= ';';
    return getMultipleSearchResult($sql);
}
