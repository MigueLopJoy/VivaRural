<?php

include "./../LIB/COMMON/PHP/authentication-service.php";
include "./../LIB/COMMON/PHP/dbConnection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['register'])) {
        echo registerUser();
    } else if (isset($_GET['login'])) {
        echo authenticateUser();
    }
}

function authenticateUser()
{
    $userData = json_decode(file_get_contents('php://input'), true);
    $userId = authenticate($userData);
    if ($userId) {
        http_response_code(200);
        return json_encode($userId);
    } else {
        http_response_code(400);
        return json_encode(array('responseCode' => 400, 'message' => 'Bad Credentials'));
    }
}

function registerUser()
{
    $userData = getInputData();
    $userData['role'] = 1;
    $userData['registrationDate'] = date("Y-m-d");
    if (register($userData)) {
        http_response_code(200);
        return json_encode(array('responseCode' => 200, 'message' => 'Usuario registrado con éxito'));
    } else {
        http_response_code(400);
        return json_encode(array('responseCode' => 400, 'message' => 'Ocurrió un error durante el registro'));
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
    $registrationDate = date("Y-m-d");
    $birthDate = $userData['birthDate'];
    $roleId = $userData['role'];

    $connection = connect();
    $insertQuery = "insert into users(firstname, lastname, email, phoneNumber, userName, password, registrationDate, birthDate, role) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("ssssssssi", $firstname, $lastname, $email, $phoneNumber, $userName, $hashedPassword, $registrationDate, $birthDate, $roleId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}


function getInputData()
{
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}
