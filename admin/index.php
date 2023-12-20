<?php
    include "./ASSETS/PHP/LAYERS/rendering-methods.php";
    include "./ASSETS/PHP/SERVICES/dbConnection.php";
    include "./ASSETS/PHP/SERVICES/towns-service.php";
    include "./ASSETS/PHP/SERVICES/pages-service.php";
    include "./ASSETS/PHP/SERVICES/articles-service.php";
    
    renderHeader();
    if (isset($_GET['page-editor'])) {
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