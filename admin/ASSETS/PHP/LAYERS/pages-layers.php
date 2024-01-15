<?php
function renderPageEditor($pageInfo)
{
    echo '<main class="mb-5">';
    renderBanner($pageInfo);
    if ($pageInfo !== null) {
        renderArticles($pageInfo['articles']);
    }
    echo '</main>';
    renderAddNewElementBtn();
    renderOffCanvasMenu();
    renderPageFooter();
}

function renderBanner($pageInfo)
{
    $banerImage = isset($pageInfo['bannerImage']) ? $pageInfo['bannerImage'] : 'example-banner.png';
    echo '
        <section class="page-section page-banner mb-5">
            <form action="?page-editor&edit-page" method="POST" enctype="multipart/form-data">
                <input type="file" id="banner-img-input" name="banner-img-input" accept="image/*" class="image-upload d-none">
                <label for="banner-img-input" class="editable-image-label w-100 h-100">
                    <div class="banner-img-container w-100 h-100" style="background-image: url(./../LIB/MEDIA/IMGS/' . $banerImage . ');">
                        <div class="container-fluid page-header py-5">
                            <div class="container text-center py-5 h-auto">
                                <div class="page-title-container d-inline-block px-4 py-2">
                                    <h1 class="text-white fw-bold d-inline-block w-auto">
                                        ' . $pageInfo["townName"] . '
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
        $elements = $article['elements'];
        $articleElements = array();
        $continueExecution = true;
        foreach ($elements as $element) {
            if (isset($element['elementReference'])) {
                switch ($element['elementReference']) {
                    case 'article-image':
                        $url = "./../LIB/MEDIA/IMGS/";
                        $imageContent = $element['elementContent'] !== "" ? $element['elementContent'] :  "section-example.png";
                        $articleElements['article-image'] = $url . $imageContent;
                        break;
                    case 'article-title':
                        $articleElements['article-title'] = $element['elementContent'];
                        break;
                    case 'article-text':
                        $articleElements['article-text'] = $element['elementContent'];
                        break;
                }
            } else {
                $articleElements = getDefaultArticleElementsInfo($articleElements);
                $continueExecution = false;
            }
            if (!$continueExecution) {
                continue;
            }
        }
        switch ($article['templateType']) {
            case '1':
                renderTemplate1($articleElements, $article['articleId']);
                break;
            case '2':
                renderTemplate2($articleElements, $article['articleId']);
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
    echo '
        <article class="page-article template-1 mb-5">
            <form action="?page-editor&handle-article&edit-article=' . $articleId . '" method="POST" enctype="multipart/form-data">
                <div class="delete-article-btn"><a href="?page-editor&handle-article&delete-article= ' . $articleId . '"><span>X</span></a></div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="img-container">
                            <input type="file" name="article-image" id="article-' . $articleId . '-image" 
                                accept="image/*" class="image-upload d-none">
                            <label for="article-' . $articleId . '-image" class="editable-image-label">
                                <img src="' . $elements['article-image'] . '" class="article-image editable-image img-fluid" 
                                    alt="Article town image">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="article-title-container text-center">
                            <h2 class="article-title d-inline-block">
                                <input type="text" name="article-title" value="' . $elements['article-title'] . '">
                            </h2>
                        </div>
                        <div class="article-text-container">
                            <p class="article-text" >
                                <input type="text" name="article-text" value ="' . $elements['article-text'] . '">
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
    echo '
        <article class="page-article template-2 mb-5">
            <form action="?page-editor&handle-article&edit-article=' . $articleId . '" method="POST" enctype="multipart/form-data">
            <div class="delete-article-btn"><a href="?page-editor&handle-article&delete-article= ' . $articleId . '"><span>X</span></a></div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="article-title-container text-center">
                            <h2 class="article-title d-inline-block">
                                <input type="text" name="article-title" value="' . $elements['article-title'] . '">
                            </h2>
                        </div>
                        <div class="article-text-container">
                            <p class="article-text" >
                                <input type="text" name="article-text" value ="' . $elements['article-text'] . '">
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="img-container">
                            <input type="file" name="article-image" id="article-' . $articleId . '-image" 
                                accept="image/*" class="image-upload d-none">
                            <label for="article-' . $articleId . '-image" class="editable-image-label">
                                <img src="' . $elements['article-image'] . '" class="editable-image img-fluid" 
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
                        <li class="mb-3">
                            <a href="?page-editor&handle-article&new-template=1">
                                <h4 class="mb-0">Artículo 1</h4>
                                <p>Imagen a la izquierda y texto a la derecha</p>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="?page-editor&handle-article&new-template=2">
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

function getDefaultArticleElementsInfo()
{
    $articleElements = array();
    $articleElements['article-image'] = "./../LIB/MEDIA/IMGS/section-example.png";
    $articleElements['article-title'] = "Article Title";
    $articleElements['article-text'] = "Write your text here";
    return $articleElements;
}
