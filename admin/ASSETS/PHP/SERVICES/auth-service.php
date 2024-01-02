<?php

function authenticateUser()
{
    $userId = authenticate($_POST);
    if ($userId) {
        $_SESSION["logged-admin"] = $userId;
        insertAdminAction(1);
        header("Location: ?");
    } else {
        header("Location: ?error=login-error");
    }
    exit();
}

function registerUser()
{
    if (register($_POST)) {
        header("Location: ?registration-success=true");
        exit();
    }
}
