<?php
    function handlePageInfo() {
        $pageInfo = null;
        $pageId = 0;
        
        if (isset($_GET['create-page'])) {
            insertTownInfo($_POST);
            createNewPage();
            $pageId = (getLastInsertedPageId())['pageId'];
        } else {
            if (!isset($_SESSION['pageId'])) {
                $townInfo = findTownByTownData($_POST);
                $townId = $townInfo['townId'];
                $pageId = getPageIdFromTownId($townId);
            } else {
                $pageId = $_SESSION['pageId'];
            }
            $pageInfo = getPageContentFromPageId($pageId);
        } 

        if (!isset($_SESSION['pageId'])) {
            $_SESSION['pageId'] = $pageId;
        }
        return $pageInfo;
    }

    function createNewPage() {
        $townId = getLastInsertedTownId()['townId'];
        $connection = connect();
        $insertQuery = "insert into town_pages(townId) values(?)";
        $statement = $connection->prepare($insertQuery);
        $statement->bind_param("i", $townId);
        $insertResult = $statement->execute();
        close($connection);
        return $insertResult;
    }

    function getLastInsertedPageId() {
        $sql = 'SELECT MAX(pageId) as pageId FROM town_pages;';
        return getSingleSearchResult($sql);
    }

    function getPageContentFromPageId($pageId) {
        $pageArticles = findArticlesByPageId($pageId);
        $articles = array();
        foreach ($pageArticles as $key => $article) {
            $articleId = $article['articleid'];
            $articleElements = findArticleElementsByArticleId($articleId);
            $articles[] = array(
                'articleId' => $articleId,
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
            SELECT pageId FROM `town_pages` tp
            WHERE tp.townId = '. $townId .';
            ';
        return getSingleSearchResult($sql);
    }

?>