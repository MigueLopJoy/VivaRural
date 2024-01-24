<?php

function findArticlesByPageId($pageId)
{
    $sql =
        '
            SELECT * FROM articles a
            WHERE a.page = ' . $pageId . ';
        ';
    return getMultipleSearchResult($sql);
}

function findArticleElementsByArticleId($articleId)
{
    $sql =
        '
        SELECT * FROM articles_elements ae
        WHERE ae.article = ' . $articleId . ';
        ';
    return getMultipleSearchResult($sql);
}
