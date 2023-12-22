<?php

    function renderHeader() {
        echo '
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Sites administration</title>
                <link rel="stylesheet" href="./ASSETS/CSS/general-styles.css">
        ';
                if (isset($_GET['page-editor'])) {
                    echo '
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                        <link rel="stylesheet" href="./ASSETS/CSS/admin-pages.css">
                        <link rel="stylesheet" href="./ASSETS/CSS/pages.css">
                    ';
                } else {
                    echo '
                        <link rel="stylesheet" href="./ASSETS/CSS/admin-layer.css">
                    ';
                }

        echo '
            </head>
        <body>
        ';
    }

    function renderWrapper() {
        echo '
        <div class="program-wrapper">
            <div class="admin-container box">
                <nav class="admin-menu">
                    <ul>
                        <a href="?"><li class="nav-link search-town">Search</li></a>
                        <a href="?create-town"><li class="nav-link create-town">Create</li></a> 
                    </ul>
                </nav>
                <div class="admin-window">
        ';
    }

    function renderSearchEngineLayer() {
        echo
        '
        <div class="search-engine-container">
            <form action="?page-editor&show-page" method="POST" class="form search-form">
                <input type="text" name="townName" placeholder="Town Name">
                <input type="submit" value="Search">
            </form>
        </div>
        ';
    }

    function renderCreateTownLayer() {
        echo
        '
        <div class="create-town-container">
            <form action="?page-editor&create-page" method="POST"  class="form search-form">
                <input type="text" name="townName" placeholder="Town Name">
                <input type="text" name="region" placeholder="Region">
                <input type="text" name="province" placeholder="Province">
                <input type="text" name="postalCode" placeholder="Postal Code">
                <input type="submit" value="Create">
            </form>
        </div>
        ';
    }

    function renderPageEditor($pageInfo) {
        echo '<main class="mb-5">';
        renderBanner($pageInfo);
        if ($pageInfo !== null) {
            renderArticles($pageInfo);
        }
        echo '</main>';
        renderAddNewElementBtn();
        renderOffCanvasMenu();
        renderPageFooter();
    }

    function renderBanner($pageInfo) {
        echo '
        <section class="page-section page-banner mb-5">
            <input type="file" id="banner-imageinput" accept="image/*" class="image-upload d-none">
            <label for="banner-image-input" class="editable-image-label w-100 h-100">
                <div class="banner-img-container w-100 h-100">
                    <div class="container-fluid page-header py-5">
                        <div class="container text-center py-5 h-auto">
                            <div class="page-title-container d-inline-block px-4 py-2">
                                <h1 class="text-white fw-bold" contenteditable="true">Town Name</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
        </section>
        ';
    }

    function renderArticles($articles) {
        echo '
        <section class="page-section articles-section mb-5">
            <div class="container">
        ';

        foreach ($articles as $key => $article) {
            $elements = $article['elements'];
            $articleElements = array(
                "image-url" => isset($elements['elementType']) && $elements['elementType'] === "image-url" 
                    ? $articleElements['elementType'] : "./ASSETS/MEDIA/IMGS/section-example.png",
                "article-title" => isset($elements['elementType']) && $elements['elementType'] === "article-title" 
                    ? $articleElements['article-title'] : "Article Title",
                "article-text" => isset($elements['elementType']) && $elements['elementType'] === "article-text" 
                    ? $articleElements['article-text'] : "Write Your Text Here"
            );
            switch ($article['templateType']) {
                case '1':
                    renderTemplate1($articleElements, $article['articleId']);
                    break;
                case '2':
                    renderTemplate2($articleElements, $article['articleId']);
                    break;
            }
        }
    }

    function renderTemplate1($articleElements, $articleId) {
        echo '
        <article class="page-article template-1 mb-5">
            <div class="delete-article-btn"><a href="?handle-article&delete-article= '.$articleId.'"><span>X</span></a></div>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="img-container">
                        <input type="file" id="article-'.$articleId.'-image-input" accept="image/*" class="image-upload d-none">
                        <label for="article-'.$articleId.'-image-input" class="editable-image-label">
                            <img src="'.$articleElements['image-url'].'" class="editable-image img-fluid"
                                alt="Article town image">
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="article-title-container text-center">
                        <h2 class="article-title d-inline-block" contenteditable="true">"'.$articleElements['article-title'].'"</h2>
                    </div>
                    <div class="article-text-container">
                        <p class="article-text" contenteditable="true">
                            "'.$articleElements['article-text'].'"
                        </p>
                    </div>
                </div>
            </div>
            <div class="save-content-btn">
                <button>Save</button>
            </div>
        </article>
        ';
    }

    function renderTemplate2($articleElements, $articleId) {
        echo '
        <article class="page-article template-2 mb-5">
            <div class="delete-article-btn"><a href="?handle-article&delete-article= '.$articleId.'"><span>X</span></a></div>
            <div class="row mb-2">
                <div class="col-6">
                    <div class="article-title-container text-center">
                        <h2 class="article-title d-inline-block" contenteditable="true">"'.$articleElements['article-title'].'"</h2>
                    </div>
                    <div class="article-text-container">
                        <p class="article-text" contenteditable="true">
                            "'.$articleElements['article-text'].'"
                        </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="img-container">
                        <input type="file" id="article-'.$articleId.'-image-input" accept="image/*" class="image-upload d-none">
                        <label for="article-'.$articleId.'-image-input" class="editable-image-label">
                            <img src="'.$articleElements['image-url'].'" class="editable-image img-fluid"
                                alt="Article town image">
                        </label>
                    </div>
                </div>
            </div>
            <div class="save-content-btn">
                <button articleId="'.$articleId.'">Save</button></a>
            </div>
        </article>
        ';
    }

    function renderAddNewElementBtn() {
        echo '
        <div class="row mb-4">
            <div class="col-12 text-center px-0">
                <div class="d-inline-block add-element-btn rounded-circle">
                    <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                        aria-controls="sidebar">
                        <span class="navbar-toggler-icon">+</span>
                    </button>
                </div>
            </div>
        </div>
        ';
    }

    function renderOffCanvasMenu() {
        echo '
        <aside class="elements-side-menu">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="sidebarLabel">Seleccionar nuevo elemento</h3>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="?handle-article&new-template=1">
                                <h4 class="mb-0">Artículo 1</h4>
                                <p>Imagen a la izquierda y texto a la derecha</p>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="?handle-article&new-template=2">
                                <h4 class="mb-0">Artículo 2</h4>
                                <p>Texto a la izquierda e imagen a la derecha</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        ';
    }

    function renderPageFooter() {
        echo '
        <footer class="page-footer bg-dark">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12 py-5 text-center">
                        <p class="text-white"><span>&#169;</span> VIVARURAL. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>
        ';
    }

?>