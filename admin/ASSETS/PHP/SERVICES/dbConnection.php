<?php

    function connect()
    {
        $host = "localhost:3306";
        $user = "root";
        $password = "";
        $database = "vivarural";

        $connection = new mysqli($host, $user, $password, $database);

        if ($connection->connect_error) {
            echo "$connection->connect_error";
            die("Connection Failed : " . $connection->connect_error);
        }
        return $connection;
    }

    function close($connenction)
    {
        $connenction->close();
    }

    function getSingleSearchResult($sql)
    {
        $result = executeSql($sql);
        if ($result !== null) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getMultipleSearchResult($sql)
    {
        $result = executeSql($sql);
        if ($result !== null) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();
    }

    function executeSql($sql)
    {
        $connection = connect();
        $result = $connection->query($sql);
        if ($result && $result->num_rows > 0) {
            close($connection);
            return $result;
        }
        return null;
    }
?>