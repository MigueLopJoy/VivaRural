<?php

    function handleArticles() {
        if (isset($_GET['new-template'])) {
            insertArticle($_GET['new-template']);
        } else if(isset($_GET['delete-article'])) {
            $articleId = $_GET['delete-article'];
            deleteArticleElements($articleId);
            deleteArticle($articleId);
        } else if (isset($_GET['edit-article'])) {
            $articleId = $_GET['edit-article'];
            
        }
        header("Location: ?page-editor");
        exit();
    }

    function insertArticle($templateType) {
        $pageId = $_SESSION['pageId'];
        echo $pageId;

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

    function deleteArticle($articleId) {
        $sql = 'DELETE FROM articles WHERE articleId = "' . $articleId . '";';
        return executeSql($sql);
    }

    function deleteArticleElements($articleId) {
        $sql = 'DELETE FROM `article_elements` WHERE articleId = "' . $articleId . '";';
        return executeSql($sql);
    }

    function editArticleElements($articleId, $newData) {
        $sql = 'UPDATE article_elements SET ';
        foreach ($newData as $key => $newValue) {
            $sql .= $key . ' = "' . $newValue .'", ';
        }
        $sql = rtrim($sql, ', ') . ' WHERE articleId = "' . $articleId . '";';
        return $sql;
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