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
        if (isset($_POST['login'])) {
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
    if (isset($_GET['action'])) {
        handleCrudActions();
    }
    if (isset($_GET['page-editor'])) {
        loadTownPage();
    } else {
        renderSideMenu();
        if (isset($_GET['table'])) {
            if (isset($_GET['form'])) {
                renderMenuForms();
            } else {
                renderResultsTable();
            }
        }
    }
}

function handleCrudActions()
{
    $data = getCrudData();
    switch ($_GET['action']) {
        case 'create':
            createRegister($data);
            break;
        case 'search':
            searchRegisters($data);
            break;
        case 'edit':
            editRegister($data);
            break;
        case 'delete':
            deleteRegister();
            break;
    }
}

function getCrudData()
{
    $data = null;
    if (isset($_GET['data'])) {
        $data = json_decode(base64_decode($_GET['data']), true);
    } else {
        if (!empty($_FILES)) {
            if (isset($_FILES['article-image'])) {
                if (!empty($_FILES['article-image']['name'])) {
                    $data['article-image'] = $_FILES['article-image']['name'];
                }
                $data['article-title'] = $_POST['article-title'];
                $data['article-content'] = $_POST['article-content'];
            } else if (isset($_FILES['bannerImage'])) {
                $data = $_FILES['bannerImage']['name'];
            }
        } else {
            $data = $_POST;
        }
    }
    return $data;
}
