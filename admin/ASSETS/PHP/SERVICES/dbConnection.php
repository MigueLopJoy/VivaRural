<?php
    $host = "localhost:3306";
    $user = "root";
    $password = "";
    $database = "vivarural";

    function connect()
    {
        $connection = new mysqli($this->host, $this->user, $this->password, $this->database);

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
        $result = $this->executeSql($sql);
        if ($result !== null) {
            return $result->fetch_assoc();
        }
        return null;
    }

    function getMultipleSearchResult($sql)
    {
        $result = $this->executeSql($sql);
        if ($result !== null) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return array();
    }

    function executeSql($sql)
    {
        $connection = $this->connect();
        $result = $connection->query($sql);
        if ($result && $result->num_rows > 0) {
            $this->close($connection);
            return $result;
        }
        return null;
    }
?>