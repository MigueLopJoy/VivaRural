<?php
function createRegister($data) {
    $connection = connect();
    $table = $_GET['table'];
    $tableFields = getTableFields();
    $insertQuery = 'INSERT INTO ' . $table . '('; 
    $values = 'VALUES (';
    foreach($tableFields as $field) {
        var_dump($data);
        exit();
        $insertQuery .= $field['Field'] . ', ';
        $values .= $data[$field['Field']] . ', ';
    }
    $insertQuery = rtrim($insertQuery, ', ') . ')';
    $values = rtrim($values, ', ') . ')';
    $insertQuery .= $values . ';';
    $statement = $connection->prepare($insertQuery);
    $statement->execute();
    close($connection);
    $url = '?table=' . $_GET['table'] . '&action=search';
    header('Location: ' . $url);
}

function deleteRegister() {
    $connection = connect();
    $query = 'DELETE FROM ' . $_GET['table'] . ' WHERE id = "' .$_GET['id'] .'";';
    $statement = $connection->prepare($query);
    $statement->execute();
    close($connection);
    $url = '?table=' . $_GET['table'] . '&action=search';
    header('Location: ' . $url);
}

function searchRegisters($data = null) 
{
    $table = $_GET['table'];
    $results = call_user_func('get' . $table, $data);
    $serializedData = base64_encode(json_encode($results));
    $url = '?table=' . $_GET['table'] . '&data=' . $serializedData;
    header('Location: ' . $url);
}

function getTableFields() {
    $query = 'SHOW COLUMNS FROM ' . $_GET['table'] . ';';
    return getMultipleSearchResult($query);
} 