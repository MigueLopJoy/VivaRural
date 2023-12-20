<?php

    function insertArticle($templateType) {
        $pageId = $_SESSION['pageId'];

        $connection = connect();
        $insertQuery = "insert into articles(pageId, templateType) values(?, ?)";
        $statement = $connection->prepare($insertQuery);
        $statement->bind_param("ii", $pageId, $templateType);
        $insertResult = $statement->execute();
        close($connection);
        return $insertResult;
    }


    function insertArticleElements($articleElementsInfo) {
        $articleId = getLastInsertedArticleId();
        $elementType = $articleInfo['elemntType'];
        $elementContent = $articleInfo['elemntContent'];

        $connection = connect();
        $insertQuery = "insert into article_elements(articleId, elementType, elementContent) values(?, ?, ?)";
        $statement = $connection->prepare($insertQuery);
        $statement->bind_param("iss", $pageId, $elementType, $elementContent);
        $insertResult = $statement->execute();
        close($connection);
        return $insertResult;
    }

    function getLastInsertedArticleId() {
        $sql = 'SELECT MAX(articleId) FROM articles;';
        return getSingleSearchResult($sql);
    }

    function findArticlesByPageId($pageId) {
        $sql = 
            '
            SELECT * FROM articles a
            WHERE a.pageId = ' . $pageId . ';
            ';
        return getMultipleSearchResult($sql);
    }

    function findArticleElementsByArticleId($articleId) {
        $sql = 
        '
        SELECT * FROM article_elements ae
        WHERE ae.articleId = ' . $articleId . ';
        ';
        return getMultipleSearchResult($sql);
    }

?>