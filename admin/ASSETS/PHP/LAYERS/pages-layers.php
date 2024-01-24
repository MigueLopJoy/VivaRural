<?php
function renderPageEditor($pageInfo)
{
    echo '<main class="mb-5">';
    renderBanner($pageInfo);
    if (!empty($pageInfo['articles'])) {
        renderArticles($pageInfo['articles']);
    }
    echo '</main>';
    renderAddNewElementBtn();
    renderOffCanvasMenu();
    renderPageFooter();
}

function renderBanner($pageInfo)
{
    $banerImage = !empty($pageInfo['bannerImage']) ? $pageInfo['bannerImage'] : 'example-banner.png';
    echo '
        <section class="page-section page-banner mb-5">
            <form action="?page-editor&town=' . $_GET['town'] . '&table=town_pages&action=edit&id=' . $_SESSION['pageId'] . '" method="POST" enctype="multipart/form-data">
                <input type="file" id="bannerImage" name="bannerImage" accept="image/*" class="image-upload d-none">
                <label for="bannerImage" class="editable-image-label w-100 h-100">
                    <div class="banner-img-container w-100 h-100" style="background-image: url(./../LIB/MEDIA/IMGS/' . $banerImage . ');">
                        <div class="container-fluid page-header py-5">
                            <div class="container text-center py-5 h-auto">
                                <div class="page-title-container d-inline-block px-4 py-2">
                                    <h1 class="text-white fw-bold d-inline-block w-auto">
                                        ' . $pageInfo["town"] . '
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="save-content-btn">
                            <input type="submit" value="Save">
                        </div>
                    </div>
                </label>
            </form>
        </section>
        ';
}

function renderArticles($articles)
{
    echo '
        <section class="page-section articles-section mb-5">
            <div class="container">
        ';
    foreach ($articles as $article) {
        $articleElements = array();
        $elements = $article['elements'];
        if (empty($elements)) {
            $articleId = $article['id'];
            createArticleElements($articleId);
            $elements = getArticleElements($articleId);
        }
        foreach ($elements as $element) {
            $articleElements[] = array(
                'id' => $element['id'],
                $element['reference'] => $element['content']
            );
        }
        switch ($article['template']) {
            case '1':
                renderTemplate1($articleElements, $article['id']);
                break;
            case '2':
                renderTemplate2($articleElements, $article['id']);
                break;
        }
    }
    echo '
        </div>
    </section>
    ';
}

function renderTemplate1($elements, $articleId)
{
    $url = '?page-editor&town=' . $_GET['town'] . '&table=articles_elements&action=edit&';
    foreach ($elements as $key => $element) {
        $url .= '&element-' . $key + 1 . '=' . $element['id'];
    }
    echo '
        <article class="page-article template-1 mb-5">
            <form action="' . $url . '" method="POST" enctype="multipart/form-data">
                <div class="delete-article-btn"><a href="?page-editor&town=' . $_GET['town'] . '&table=articles&action=delete&id= ' . $articleId . '"><span>X</span></a></div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="img-container">
                            <input type="file" name="article-image" id="article-' . $articleId . '-image" 
                                accept="image/*" class="image-upload d-none">
                            <label for="article-' . $articleId . '-image" class="editable-image-label">
                                <img src="./../LIB/MEDIA/IMGS/' . $elements[0]['article-image'] . '" class="article-image editable-image img-fluid" 
                                    alt="Article town image">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="article-title-container text-center">
                            <h2 class="article-title d-inline-block">
                                <input type="text" name="article-title" value="' . $elements[1]['article-title'] . '">
                            </h2>
                        </div>
                        <div class="article-content-container">
                            <p class="article-content" >
                                <input type="text" name="article-content" value ="' . $elements[2]['article-content'] . '">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="save-content-btn">
                    <input type="submit" value="Save">
                </div>
            </form>
        </article>
        ';
}

function renderTemplate2($elements, $articleId)
{
    $url = '?page-editor&town=' . $_GET['town'] . '&table=articles_elements&action=edit&';
    foreach ($elements as $key => $element) {
        $url .= '&element-' . $key + 1 . '=' . $element['id'];
    }
    echo '
        <article class="page-article template-2 mb-5">
            <form action="' . $url . '" method="POST" enctype="multipart/form-data">
            <div class="delete-article-btn"><a href="?page-editor&town=' . $_GET['town'] . '&table=articles&action=delete&id= ' . $articleId . '"><span>X</span></a></div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="article-title-container text-center">
                            <h2 class="article-title d-inline-block">
                                <input type="text" name="article-title" value="' . $elements[1]['article-title'] . '">
                            </h2>
                        </div>
                        <div class="article-content-container">
                            <p class="article-content" >
                                <input type="text" name="article-content" value ="' . $elements[2]['article-content'] . '">
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="img-container">
                            <input type="file" name="article-image" id="article-' . $articleId . '-image" 
                                accept="image/*" class="image-upload d-none">
                            <label for="article-' . $articleId . '-image" class="editable-image-label">
                                <img src="./../LIB/MEDIA/IMGS/' . $elements[0]['article-image'] . '" class="editable-image img-fluid" 
                                    alt="Article town image">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="save-content-btn">
                    <input type="submit" name="" value="Save">
                </div>
            </form>
        </article>
        ';
}

function renderAddNewElementBtn()
{
    echo '
        <div class="row mb-4 p-0">
            <div class="col-12 text-center">
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

function renderOffCanvasMenu()
{
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
                        <li>
                            <form action="?page-editor&town=' . $_GET['town'] . '&table=articles&action=create" method="post" class="template-form">
                                <input type="hidden" name="page" value="' . $_SESSION['pageId'] . '">
                                <input type="hidden" name="template" value="1">
                                <button type="submit" class="btn text-dark bg-white text-start p-0">
                                    <h4 class="mb-0">Artículo 1</h4>
                                    <p>Texto a la derecha e imagen a la izquierda</p>
                                </button>
                            </form>
                            <form action="?page-editor&town=' . $_GET['town'] . '&table=articles&action=create" method="post" class="template-form">
                                <input type="hidden" name="page" value="' . $_SESSION['pageId'] . '">
                                <input type="hidden" name="template" value="2">
                                <button type="submit" class="btn text-dark bg-white text-start p-0">
                                    <h4 class="mb-0">Artículo 2</h4>
                                    <p>Texto a la izquierda e imagen a la derecha</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        ';
}

function renderPageFooter()
{
    echo '
        <footer class="page-footer position-relative bg-dark">
            <div class="container py-5">
                <div class="row">
                    <div class="col-12 py-5 text-center">
                        <p class="text-white"><span>&#169;</span> VIVARURAL. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
            <div class="skip-page-btn">
                <a href="?" class="d-flex justify-content-center">
                    <i class="bi bi-backspace me-1"></i>
                    <p class="mb-0">Skip page</p>
                </a>
            </div>
        </footer>
        ';
}
