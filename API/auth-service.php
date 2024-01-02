<?php

include "./../LIB/COMMON/PHP/authentication-service.php";
include "./../LIB/COMMON/PHP/dbConnection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['register'])) {
        registerUser();
    } else if (isset($_GET['login'])) {
        authenticateUser();
    }
}

function authenticateUser()
{
    $userData = getInputData();
    $userId = authenticate($userData);
    if ($userId) {
        http_response_code(200);
        echo $userId;
    } else {
        http_response_code(400);
        echo json_encode(array('responseCode' => 400, 'message' => 'Bad Credentials'));
    }
}

function registerUser()
{
    $userData = getInputData();
    if (register($userData)) {
        http_response_code(200);
        echo json_encode(array('responseCode' => 200, 'message' => 'Usuario registrado con éxito'));
    } else {
        http_response_code(400);
        echo json_encode(array('responseCode' => 400, 'message' => 'Ocurrió un error durante el registro'));
    }
}

function getInputData()
{
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}
