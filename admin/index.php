<?php
    include "./ASSETS/PHP/LAYERS/rendering-methods.php";
    include "./ASSETS/PHP/SERVICES/towns-service.php";
    
    renderHeader();
    if (isset($_GET['create-page'])) {
        renderNewPageEditor();
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