<?php

function authenticateUser()
{
    $userData = authenticate($_POST);
    if ($userData['userId'] & $userData['roleId'] === 1) {
        $_SESSION["logged-admin"] = $userData['userId'];
        insertAction(getActionData());
        header("Location: ?");
    } else {
        header("Location: ?error=login-error");
    }
    exit();
}
