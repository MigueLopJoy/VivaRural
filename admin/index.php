<?php
    include "./ASSETS/PHP/LAYERS/layers.php";
    
    include "./ASSETS/PHP/LAYERS/header.php";

    if (isset($_GET['create-town'])) {
        renderCreateTownLayer();
    } else {
        renderSearchEngineLayer();
    }

    include "./ASSETS/PHP/LAYERS/footer.php";
?>