<?php
include "./ASSETS/PHP/LAYERS/common-layers.php";
include "./ASSETS/PHP/LAYERS/authentication-layers.php";
include "./ASSETS/PHP/LAYERS/admin-layers.php";
include "./ASSETS/PHP/LAYERS/pages-layers.php";

include "./../LIB/COMMON/PHP/dbConnection.php";
include "./../LIB/COMMON/PHP/towns-service.php";
include "./../LIB/COMMON/PHP/pages-service.php";
include "./../LIB/COMMON/PHP/articles-service.php";
include "./../LIB/COMMON/PHP/authentication-service.php";

include "./ASSETS/PHP/SERVICES/CRUD.php";
include "./ASSETS/PHP/SERVICES/auth-service.php";
include "./ASSETS/PHP/SERVICES/users-service.php";
include "./ASSETS/PHP/SERVICES/admin-service.php";
include "./ASSETS/PHP/SERVICES/towns-service.php";
include "./ASSETS/PHP/SERVICES/pages-service.php";
include "./ASSETS/PHP/SERVICES/articles-service.php";
include "./ASSETS/PHP/SERVICES/interests-service.php";

session_start();
renderHeader();
if (!isset($_SESSION['logged-admin'])) {
    handleNonAdmin();
} else {
    handleAdmin();
}
renderPageBottom();

function handleNonAdmin()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['register'])) {
            registerUser();
        } elseif (isset($_POST['login'])) {
            authenticateUser();
        }
    } else {
        renderAuthenticationLayer();
    }
}

function handleAdmin()
{
    if (isset($_GET['logout'])) {
        logout();
    }

    if (isset($_GET['page-editor'])) {
    } else {
        renderSideMenu();
    }

    if (isset($_GET['action'])) {
        handleCrudActions();
    } else {
        if (isset($_GET['table'])) {
            if (isset($_GET['form'])) {
                renderMenuForms();
            } else {
                renderResultsTable();
            }
        }
    }

    if (isset($_GET['page-editor'])) {
        handlePageEditor();
    } else {
        ob_start();
        ob_end_flush();
    }
}

function handleCrudActions()
{
    switch ($_GET['action']) {
        case 'create':
            createRegister($_POST);
            break;
        case 'search':
            searchRegisters($_POST);
            break;
        case 'update':
            updateRegister();
            break;
        case 'delete':
            deleteRegister();
            break;
    }
}

function handlePageEditor()
{
    if (isset($_GET['handle-article'])) {
        handleArticle();
    } elseif (isset($_GET['edit-page'])) {
        editPageBanner();
    } else {
        loadTownPage();
    }
}

function handleArticle()
{
    if (isset($_GET['new-template'])) {
        createNewTemplate();
    } elseif (isset($_GET['edit-article'])) {
        editArticle();
    } elseif (isset($_GET['delete-article'])) {
        handleArticleDeletion();
    }
}
