<?php

    function insertTownInfo($townInfo) {
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

    function getLastInsertedTownId() {
        $sql = 'SELECT MAX(townId) FROM towns;';
        return getSingleSearchResult($sql);
    }

    function findTownByTownData($townData) {
        $townInfo = null;
        if (isset($townData['townName'])) {
            $townInfo = findTownByIdentifier(($townInfo['townName']));
        }
        return $townInfo;
    }

    function findTownByTownName($townName) {
        $sql =
        '
        SELECT * FROM towns t
        WHERE t.townName = ' . $townName . ';
        ';
        return getSingleSearchResult($sql);
    }
?>