<?php

if (isset($_GET['insert-action'])) {
    $data = json_decode(base64_decode($_GET['data']), true);
    createRegister($data);
}

function createRegister($data)
{
    $connection = connect();
    $table = $_GET['table'];
    $tableFields = getTableFields();
    $insertQuery = 'INSERT INTO ' . $table . ' (';
    $values = 'VALUES (';
    foreach ($tableFields as $field) {
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

function editRegister($data)
{
    $table = $_GET['table'];
    if ($table !== 'articles_elements') {
        $connection = connect();
        $editQuery = 'UPDATE ' . $table . ' SET ';
        foreach ($data as $field => $newValue) {;
            $editQuery .= $field . ' = "' . $newValue . '",';
        }
        $editQuery = rtrim($editQuery, ', ') . ' WHERE id = ' . $_GET['id'] . ';';
        $statement = $connection->prepare($editQuery);
        handleRedirection($connection, $statement);
    } else {
        editArticleElements($data);
    }
}

function deleteRegister()
{
    if ($_GET['table'] !== 'articles') {
        $connection = connect();
        $query = 'DELETE FROM ' . $_GET['table'] . ' WHERE id = "' . $_GET['id'] . '";';
        $statement = $connection->prepare($query);
        handleRedirection($connection, $statement);
    } else {
        deleteArticle();
    }
}

function searchRegisters($data = null)
{
    $table = $_GET['table'];
    $results = call_user_func('get' . $table, $data);
    $serializedData = base64_encode(json_encode($results));
    $url = '?table=' . $_GET['table'];
    if (isset($_GET['operation'])) {
        $url .= '&operation=' . $_GET['operation'] . '&result=' . $_GET['result'];
    }
    insertAction(getActionData());
    $_SESSION['data'] = $serializedData;
    header('Location: ' . $url);
}

function handleRedirection($connection, $statement)
{
    $operation = $_GET['action'];
    $url = isset($_GET['page-editor']) ? '?page-editor&town=' . $_GET['town'] : '';
    try {
        $statement->execute();
        close($connection);
        $url = isset($_GET['page-editor']) ?
            $url :
            '?table=' . $_GET['table'] . '&action=search&operation=' . $operation . '&result=success';
    } catch (\Throwable $th) {
        close($connection);
        $url = isset($_GET['page-editor']) ?
            $url :
            '?table=' . $_GET['table'] . '&action=search&operation=' . $operation . '&result=error';
    }
    insertAction(getActionData());
    if (!isset($_GET['no-redir'])) {
        header('Location: ' . $url);
    }
}

function getTableFields()
{
    $query = 'SHOW COLUMNS FROM ' . $_GET['table'] . ';';
    return getMultipleSearchResult($query);
}
