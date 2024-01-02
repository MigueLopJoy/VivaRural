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
include "./ASSETS/PHP/SERVICES/auth-service.php";
include "./ASSETS/PHP/SERVICES/admin-service.php";
include "./ASSETS/PHP/SERVICES/towns-service.php";
include "./ASSETS/PHP/SERVICES/pages-service.php";
include "./ASSETS/PHP/SERVICES/articles-service.php";

session_start();
renderHeader();

if (isset($_GET['logout'])) {
    logout();
}

if (!isset($_SESSION['logged-admin'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['register'])) {
            registerUser();
        } else if (isset($_POST['login'])) {
            authenticateUser();
        }
    } else {
        renderAuthenticationLayer();
    }
} else {
    if (isset($_GET['page-editor'])) {
        if (isset($_GET['handle-article'])) {
            if (isset($_GET['new-template'])) {
                createNewTemplate();
            } else if (isset($_GET['edit-article'])) {
                editArticle();
            } else if (isset($_GET['delete-article'])) {
                handleArticleDeletion();
            }
        } else if (isset($_GET['edit-page'])) {
            editPageBanner();
        } else {
            loadTownPage();
        }
    } else {
        renderSideMenu();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create-town'])) {
            createTownAndTownPage();
        } else if (isset($_POST['search-town'])) {
            searchTownPage();
        }
    }

    if (isset($_GET['create-town'])) {
        renderCreateTownLayer();
    } else if (isset($_GET['search-town'])) {
        renderSearchEngineLayer();
    }
}
renderPageBottom();
