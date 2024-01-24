<?php
function insertAction($actionData)
{
    $admin = $_SESSION['logged-admin'];
    $action = $actionData['action'];
    $table = $actionData['table'];
    $element = $actionData['element'];
    $date = date("Y-m-d h-i-s");

    $connection = connect();
    $insertQuery = "insert into admin_actions(admin, action, `table`, element, dateTime) values(?, ?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("issis", $admin, $action, $table, $element, $date);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getActionData()
{
    return array(
        'action' => isset($_GET['action']) ? $_GET['action'] : (isset($_GET['logout']) ? 'logout' : 'login'),
        'table' => isset($_GET['table']) ? $_GET['table'] : '',
        'element' => isset($_GET['id']) ?
            $_GET['id'] : (isset($_GET['action']) && $_GET['action'] === 'search'  ?
                '' : (isset($_GET['action']) && $_GET['action'] === 'create' ? call_user_func('getLast' . $_GET['table'])['id'] : ''))
    );
}

function logout()
{
    insertAction(getActionData());
    session_destroy();
    header("Location: ?");
}

function getadmin_actions($actionData)
{
    $sql = '
        SELECT a.id, u.email, a.action, a.table, a.element, a.dateTime
        FROM admin_actions a
        INNER JOIN users u 
        ON a.admin = u.id
    ';
    $sql .= ' WHERE 1';
    if (isset($_GET['id'])) {
        $sql .= " AND u.id = '" . $_GET['email'] . "'";
    }
    if (!empty($actionData['admin'])) {
        $sql .= " AND u.email = '" . $actionData['email'] . "'";
    }
    if (!empty($actionData['action'])) {
        $sql .= " AND a.action = '" . $actionData['action'] . "'";
    }
    if (!empty($actionData['town'])) {
        $sql .= " AND t.town = '" . $actionData['town'] . "'";
    }
    if (!empty($actionData['minDateTime'])) {
        $sql .= " AND a.dateTime >= '" . $actionData['minDateTime'] . "'";
    }
    if (!empty($actionData['maxDateTime'])) {
        $sql .= " AND a.dateTime <= '" . $actionData['maxDateTime'] . "'";
    }
    $sql .= ';';
    return getMultipleSearchResult($sql);
}
