<?php

function getLastUsers()
{
    $sql = 'SELECT MAX(id) as id FROM users;';
    return getSingleSearchResult($sql);
}

function getUsers($userData)
{
    $sql = '
        SELECT u.id, u.firstname, u.lastname, u.email, u.phoneNumber, u.userName, u.registrationDate, u.birthDate, r.name as role
        FROM users u
        INNER JOIN roles r
        ON u.role = r.id
        WHERE 1';

    if (!empty($userData['firstname'])) {
        $sql .= " AND u.firstname = '" . $userData['firstname'] . "'";
    }
    if (!empty($userData['lastname'])) {
        $sql .= " AND u.lastname = '" . $userData['lastname'] . "'";
    }
    if (!empty($userData['email'])) {
        $sql .= " AND u.email = '" . $userData['email'] . "'";
    }
    if (!empty($userData['phoneNumber'])) {
        $sql .= " AND u.phoneNumber = '" . $userData['phoneNumber'] . "'";
    }
    if (!empty($userData['userName'])) {
        $sql .= " AND u.userName = '" . $userData['userName'] . "'";
    }
    if (!empty($userData['minRegistrationDate'])) {
        $sql .= " AND u.registrationDate >= '" . $userData['minRegistrationDate'] . "'";
    }
    if (!empty($userData['maxRegistrationDate'])) {
        $sql .= " AND u.registrationDate <= '" . $userData['maxRegistrationDate'] . "'";
    }
    if (!empty($userData['minBirthDate'])) {
        $sql .= " AND u.birthDate >= '" . $userData['minBirthDate'] . "'";
    }
    if (!empty($userData['maxBirthDate'])) {
        $sql .= " AND u.birthDate <= '" . $userData['maxBirthDate'] . "'";
    }
    if (!empty($userData['role'])) {
        $sql .= " AND r.id = '" . $userData['role'] . "'";
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
