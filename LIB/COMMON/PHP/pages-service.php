<?php

function getPageContentFromPageId($pageId)
{
    $pageContent = array();
    $articles = array();
    $articlesInfo = findArticlesByPageId($pageId);
    foreach ($articlesInfo as $pageArticle) {
        $articleId = $pageArticle['id'];
        $article = array();
        $article['id'] = $articleId;
        $article['template'] = $pageArticle['template'];
        $article['elements'] = array();
        $articleElements = findArticleElementsByArticleId($articleId);
        foreach ($articleElements as $element) {
            $article['elements'][] =  array(
                'id' => $element['id'],
                'reference' => $element['reference'],
                'content' => $element['content']
            );
        }
        $articles[] = $article;
    }
    $pageContent['town'] = getTownNameFromPageId($pageId)['name'];
    $pageContent['bannerImage'] = getPageBannerImageFromPageId($pageId)['bannerImage'];
    $pageContent['articles'] = $articles;
    return $pageContent;
}

function getPageBannerImageFromPageId($pageId)
{
    $sql = '
        SELECT bannerImage FROM town_pages tp
        WHERE tp.id = ' . $pageId . ';
    ';
    return getSingleSearchResult($sql);
}
