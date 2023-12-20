<?php
    function handlePageInfo() {
        $pageInfo = null;
        $pageId = 0;
        if (isset($_GET['create-page'])) {
            insertTownInfo($_POST);
            createNewPage();
            $pageId = getLastInsertedPageId();
        } else if (isset($_GET['show-page'])) {
            $townInfo = findTownByTownData($_POST);
            $townId = $townInfo['townId'];
            $pageId = getPageIdFromTownId($townId);
            $pageInfo = findPageInfoByPageId($_POST);
        } else if (isset($_GET['new-template'])) {
            insertArticle($_GET['new-template']);
        }
        if (!isset($_SESSION['pageId'])) {
            $_SESSION['pageId'] = $pageId;
        }
        return $pageInfo;
    }

    function createNewPage() {
        $townId = getLastInsertedTownId();

        $connection = connect();
        $insertQuery = "insert into town_pages(townId) values(?)";
        $statement = $connection->prepare($insertQuery);
        $statement->bind_param("i", $townId);
        $insertResult = $statement->execute();
        close($connection);
        return $insertResult;
    }

    function getLastInsertedPageId() {
        $sql = 'SELECT MAX(pageId) FROM town_pages;';
        return getSingleSearchResult($sql);
    }

    function findPageByPageId($townInfo) {
        $pageArticles = findArticlesByPageId($pageId);
        $articles = array();
        foreach ($pageArticles as $key => $article) {
            $articleId = $article['articleId'];
            $articleElements = findArticleElementsByArticleId($articleId);
            $articles[] = array(
                'articleNumber' => $key,
                'templateType' => $article['templateType'],
                'elements' => $articleElements
            );
        }
        return $articles;
    }

    function getPageIdFromTownId($townId) {
        $sql = 
            '
            SELECT * FROM `town_pages` tp
            INNER JOIN towns t
            ON tp.townId = '. $townId .';
            ';
        return getSingleSearchResult($sql);
    }

?>