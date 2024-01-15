<?php
function insertAdminAction($actionType, $articleId = null)
{
    $adminId = $_SESSION['logged-admin'];
    $pageId = isset($_SESSION['pageId']) ? $_SESSION['pageId'] : null;
    $action = getAction($actionType);

    $connection = connect();
    $insertQuery = "insert into admin_actions(adminid, actionType, pageId, articleId) values(?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("isii", $adminId, $action, $pageId, $articleId);
    $statement->execute();
    close($connection);
}

function logout()
{
    insertAdminAction(8);
    session_destroy();
    header("Location: ?");
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
