<?php
function insertAdminAction($actionType, $articleId = null)
{
    $adminId = $_SESSION['logged-admin'];
    $pageId = isset($_SESSION['pageId']) ? $_SESSION['pageId'] : null;
    $action = getAction($actionType);
    $actionDate = date("Y-m-d h-m-s");

    $connection = connect();
    $insertQuery = "insert into admin_actions(adminid, actionType, pageId, articleId, dateTime) values(?, ?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("isiis", $adminId, $action, $pageId, $articleId, $actionDate);
    $statement->execute();
    close($connection);
}

function logout()
{
    insertAdminAction(8);
    session_destroy();
    header("Location: ?");
}

function getadmin_actions($actionData)
{
    $sql = '
        SELECT a.id, u.email, a.action, t.name, a.article, a.dateTime
        FROM admin_actions a
        INNER JOIN users u ON a.admin = u.id
        LEFT JOIN town_pages tp ON a.page = tp.id
        LEFT JOIN towns t ON tp.town = t.id
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


function getAction($actionType)
{
    switch ($actionType) {
        case 1:
            return "login";
        case 2:
            return "create town and town page";
        case 3:
            return "search town page";
        case 4:
            return "edit banner";
        case 5:
            return "create article";
        case 6:
            return "edit article";
        case 7:
            return "delete article";
        case 8:
            return "logout";
    }
}
