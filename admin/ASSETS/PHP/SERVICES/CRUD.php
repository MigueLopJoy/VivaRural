<?php
function createRegister($data)
{
    $connection = connect();
    $table = $_GET['table'];
    $tableFields = getTableFields();
    $insertQuery = 'INSERT INTO ' . $table . ' (';
    $values = 'VALUES (';
    foreach ($tableFields as $field) {;
        if ($field['Field'] !== 'id') {
            $insertQuery .= $field['Field'] . ', ';
            $values .= '"' . $data[$field['Field']] . '",';
        }
    }
    $insertQuery = rtrim($insertQuery, ', ') . ') ';
    $values = rtrim($values, ', ') . ')';
    $insertQuery .= $values . ';';
    $statement = $connection->prepare($insertQuery);
    handleRedirection($connection, $statement);
}

function deleteRegister()
{
    $connection = connect();
    $query = 'DELETE FROM ' . $_GET['table'] . ' WHERE id = "' . $_GET['id'] . '";';
    $statement = $connection->prepare($query);
    handleRedirection($connection, $statement);
}

function searchRegisters($data = null)
{
    $table = $_GET['table'];
    $results = call_user_func('get' . $table, $data);
    $serializedData = base64_encode(json_encode($results));
    $url = '?table=' . $_GET['table'] . '&data=' . $serializedData;
    if (isset($_GET['operation'])) {
        $url .= '&operation=' . $_GET['operation'] . '&result=' . $_GET['result'];
    }
    header('Location: ' . $url);
}

function handleRedirection($connection, $statement, $id = null)
{
    $operation = $_GET['action'];
    try {
        $statement->execute();
        close($connection);
        $url = '?table=' . $_GET['table'] . '&action=search&operation=' . $operation . '&result=success';
    } catch (\Throwable $th) {
        close($connection);
        $url = '?table=' . $_GET['table'] . '&action=search&operation=' . $operation . '&result=error';
    }
    header('Location: ' . $url);
}

function getTableFields()
{
    $query = 'SHOW COLUMNS FROM ' . $_GET['table'] . ';';
    return getMultipleSearchResult($query);
}
