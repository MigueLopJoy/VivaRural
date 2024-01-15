<?php

function findArticlesByPageId($pageId)
{
    $sql =
        '
            SELECT * FROM articles a
            WHERE a.pageId = ' . $pageId . ';
        ';
    return getMultipleSearchResult($sql);
}

function findArticleElementsByArticleId($articleId)
{
    $sql =
        '
        SELECT * FROM articles_elements ae
        WHERE ae.articleId = ' . $articleId . ';
        ';
    return getMultipleSearchResult($sql);
}
