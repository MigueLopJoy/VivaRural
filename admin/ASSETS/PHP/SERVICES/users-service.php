<?php

function getLastInsertedUser()
{
    $sql = '
        SELECT u.id, u.firstname, u.lastname, u.email, u.phoneNumber, u.userName, u.registrationDate, u.birthDate, r.roleName
        FROM users u
        INNER JOIN roles r
        ON u.roleid = r.roleid
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
        SELECT u.id, u.firstname, u.lastname, u.email, u.phoneNumber, u.userName, u.registrationDate, u.birthDate, r.name
        FROM users u
        INNER JOIN roles r
        ON u.role = r.id
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
        $sql .= " AND id = '" . $userData['roleId'] . "'";
    }
    return getMultipleSearchResult($sql);
}

function deleteUser($userData)
{
    $sql = '
        DELETE FROM users WHERE userid = ' . $userData['userId'] . ';
    ';
    executeSql($sql);
    header('Location: ?');
}
