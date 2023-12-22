<?php
    include "./ASSETS/PHP/LAYERS/rendering-methods.php";
    include "./ASSETS/PHP/SERVICES/dbConnection.php";
    include "./ASSETS/PHP/SERVICES/towns-service.php";
    include "./ASSETS/PHP/SERVICES/pages-service.php";
    include "./ASSETS/PHP/SERVICES/articles-service.php";
    
    session_start();
    renderHeader();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "imagen cargada";
        exit();
    }

    if (isset($_GET['handle-article'])) {
        handleArticles();
    } else if (isset($_GET['page-editor'])) {
        $pageInfo = handlePageInfo();
        renderPageEditor($pageInfo);
    } else {
        renderWrapper();
        if (isset($_GET['create-town'])) {
            renderCreateTownLayer();
        } else {
            renderSearchEngineLayer();
        }
    }

    include "./ASSETS/PHP/LAYERS/footer.php";
?>