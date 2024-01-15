<?php

function authenticateUser()
{
    $userData = authenticate($_POST);
    if ($userData['userId'] & $userData['roleId'] === 1) {
        $_SESSION["logged-admin"] = $userData['userId'];
        insertAdminAction(1);
        header("Location: ?");
    } else {
        header("Location: ?error=login-error");
    }
    exit();
}

function registerUser()
{
    $userData = $_POST;
    $userData['roleId'] = 1;
    if (register($userData)) {
        header("Location: ?registration-success=true");
        exit();
    }
}
