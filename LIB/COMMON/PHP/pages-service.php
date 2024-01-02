<?php

function getPageContentFromPageId($pageId)
{
    $pageContent = array();
    $articles = array();
    $articlesInfo = findArticlesByPageId($pageId);
    foreach ($articlesInfo as $pageArticle) {
        $articleId = $pageArticle['articleid'];
        $article = array();
        $article['articleId'] = $articleId;
        $article['templateType'] = $pageArticle['templateType'];
        $article['elements'] = array();
        $articleElements = findArticleElementsByArticleId($articleId);
        foreach ($articleElements as $element) {
            $article['elements'][] =  array(
                'articleElementId' => $element['articleElementId'],
                'elementReference' => $element['elementReference'],
                'elementContent' => $element['elementContent']
            );
        }
        $articles[] = $article;
    }
    $pageContent['townName'] = getTownNameFromPageId($pageId)['townName'];
    $pageContent['bannerImage'] = getPageBannerImageFromPageId($pageId)['bannerImage'];
    $pageContent['articles'] = $articles;
    return $pageContent;
}

function getPageBannerImageFromPageId($pageId)
{
    $sql = '
        SELECT bannerImage FROM town_pages tp
        WHERE tp.pageId = ' . $pageId . ';
    ';
    return getSingleSearchResult($sql);
}
