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
                <link rel="stylesheet" href="./ASSETS/CSS/pages.css">
                <link rel="stylesheet" href="./ASSETS/CSS/admin-pages.css">
                <link rel="stylesheet" href="./ASSETS/CSS/admin-layer.css">
        ';
                if (isset($_GET['create-page'])) {
                    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">';
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
            <form action="" class="form search-form">
                <input type="text" name="identifier" placeholder="Town Identifier">
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
            <form action="?create-page" method="POST"  class="form search-form">
                <input type="text" name="townName" placeholder="Town Name">
                <input type="text" name="province" placeholder="Province">
                <input type="text" name="postalCode" placeholder="Postal Code">
                <input type="submit" value="Create">
            </form>
        </div>
        ';
    }

    function renderNewPageEditor() {
        echo '
        <main class="mb-5">
            <section class="page-section page-banner mb-5">
                <input type="file" id="imageInput" accept="image/*" class="image-upload d-none">
                <label for="imageInput" class="editable-image-label w-100 h-100">
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

            <section class="page-section articles-section mb-5">
                <div class="container">

                    <article class="page-article mb-5">
                        <div class="row">
                            <div class="col-6">
                                <div class="img-container">
                                    <input type="file" id="imageInput" accept="image/*" class="image-upload d-none">
                                    <label for="imageInput" class="editable-image-label">
                                        <img src="./ASSETS/MEDIA/IMGS/section-example.png" class="editable-image img-fluid"
                                            alt="Article town image">
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="article-title-container">
                                    <h2 contenteditable="true">Article title</h2>
                                </div>
                                <div class="article-text-container">
                                    <p contenteditable="true">
                                        Write your text here.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article class="page-article mb-5">
                        <div class="row">
                            <div class="col-6">
                                <div class="article-title-container">
                                    <h2 contenteditable="true">Article title</h2>
                                </div>
                                <div class="article-text-container">
                                    <p contenteditable="true">
                                        Write your text here.
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="img-container">
                                    <input type="file" id="imageInput" accept="image/*" class="image-upload d-none">
                                    <label for="imageInput" class="editable-image-label">
                                        <img src="./ASSETS/MEDIA/IMGS/section-example.png" class="editable-image img-fluid"
                                            alt="Article town image">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </article>

                </div>
            </section>

            <div class="row">
                <div class="col-12 text-center">
                    <div class="d-inline-block add-element-btn rounded-circle">
                        <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                            aria-controls="sidebar">
                            <span class="navbar-toggler-icon">+</span>
                        </button>
                    </div>
                </div>
            </div>
        </main>

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
                            <a href="?">
                                <h4 class="mb-0">Artículo 1</h4>
                                <p>Imagen a la izquierda y texto a la derecha</p>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="?">
                                <h4 class="mb-0">Artículo 2</h4>
                                <p>Texto a la izquierda e imagen a la derecha</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

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