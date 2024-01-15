<?php

function createUser($userData)
{
    $userData['password'] = isset($userData['password']) ? $userData['password'] : '1234';
    if (register($userData)) {
        $insertedUser = getLastInsertedUser();
        $users = array($insertedUser);
        $serializedData = base64_encode(json_encode($users));
        $url = '?table=users&data=' . $serializedData;
        header('Location: ' . $url);
    }
}

function searchUsers($userData)
{
    $users = getUsers($userData);
    $serializedData = base64_encode(json_encode($users));
    $url = '?table=users&data=' . $serializedData;
    header('Location: ' . $url);
}

function getLastInsertedUser()
{
    $sql = '
        SELECT firstname, lastname, email, phoneNumber, userName, registrationDate, birthDate, roleId 
        FROM users
        WHERE userId = (
            SELECT MAX(userId) 
            FROM users
        );
    ';
    return getSingleSearchResult($sql);
}


function getUsers($userData)
{
    $sql = '
        SELECT firstname, lastname, email, phoneNumber, userName, registrationDate, birthDate, roleId 
        FROM users   
        WHERE 1';

    if (!empty($userData['firstname'])) {
        $sql .= " AND firstname = '" . $userData['firstname'] . "'";
    }
    if (!empty($userData['lastname'])) {
        $sql .= " AND lastname = '" . $userData['lastname'] . "'";
    }
    if (!empty($userData['email'])) {
        $sql .= " AND email = '" . $userData['email'] . "'";
    }
    if (!empty($userData['phoneNumber'])) {
        $sql .= " AND phoneNumber = '" . $userData['phoneNumber'] . "'";
    }
    if (!empty($userData['userName'])) {
        $sql .= " AND userName = '" . $userData['userName'] . "'";
    }
    if (!empty($userData['minRegistrationDate'])) {
        $sql .= " AND registrationDate >= '" . $userData['minRegistrationDate'] . "'";
    }
    if (!empty($userData['maxRegistrationDate'])) {
        $sql .= " AND registrationDate <= '" . $userData['maxRegistrationDate'] . "'";
    }
    if (!empty($userData['minBirthDate'])) {
        $sql .= " AND birthDate >= '" . $userData['minBirthDate'] . "'";
    }
    if (!empty($userData['maxBirthDate'])) {
        $sql .= " AND birthDate <= '" . $userData['maxBirthDate'] . "'";
    }
    if (!empty($userData['roleId'])) {
        $sql .= " AND roleId = '" . $userData['roleId'] . "'";
    }

    return getMultipleSearchResult($sql);
}
