<?php

function authenticate($userData)
{
    $email = $userData['email'];
    $password = $userData['password'];

    $connection = connect();
    $selectQuery = "SELECT userId, password, roleId FROM users WHERE email = ?";
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

function register($userData)
{
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];
    $email = $userData['email'];
    $phoneNumber = $userData['phoneNumber'];
    $userName = $userData['userName'];
    $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
    $registrationDate = date("d-m-Y");
    $birthDate = $userData['birthDate'];
    $roleId = $userData['roleId'];

    $connection = connect();
    $insertQuery = "insert into users(firstname, lastname, email, phoneNumber, userName, password, registrationDate, birthDate, roleId) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("ssssssssi", $firstname, $lastname, $email, $phoneNumber, $userName, $hashedPassword, $registrationDate, $birthDate, $roleId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}
