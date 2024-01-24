<?php

function authenticate($userData)
{
    $email = $userData['email'];
    $password = $userData['password'];

    $connection = connect();
    $selectQuery = "SELECT id, password, role FROM users WHERE email = ?";
    $statement = $connection->prepare($selectQuery);
    $statement->bind_param("s", $email);
    $statement->execute();
    $statement->bind_result($userId, $userPassword, $roleId);
    $statement->fetch();
    close($connection);

    if (password_verify($password, $userPassword)) {
        return array('userId' => $userId, 'roleId' => $roleId);
    } else {
        return false;
    }
}
