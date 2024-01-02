<?php

function createNewTemplate()
{
    $templateType = $_GET['new-template'];
    insertArticle($templateType);
    $articleId = getLastInsertedArticleId()['articleId'];
    insertArticleElementsIfDoesNotExist($articleId);
    insertAdminAction(5, $articleId);
    redirectToTownPage();
}

function editArticle()
{
    $articleId = $_GET['edit-article'];
    $newData = getArticleElementsInfo($articleId);
    editArticleElements($newData);
    insertAdminAction(6, $articleId);
    redirectToTownPage();
}

function handleArticleDeletion()
{
    $articleId = $_GET['delete-article'];
    insertAdminAction(7, $articleId);
    deleteArticleElements($articleId);
    deleteArticle($articleId);
    redirectToTownPage();
}

function insertArticle($templateType)
{
    $pageId = $_SESSION['pageId'];
    $connection = connect();
    $insertQuery = "insert into articles(pageId, templateType) values(?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("ii", $pageId, $templateType);
    $statement->execute();
    close($connection);
}

function insertArticleElementsIfDoesNotExist($articleId)
{
    $insertedArticleElements = getArticleElements($articleId);
    for ($i = count($insertedArticleElements); $i < 3; $i++) {
        insertArticleElement($articleId);
    }
}

function insertArticleElement($articleId)
{
    $connection = connect();
    $insertQuery = "insert into articles_elements(articleId) values(?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("i", $articleId);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function getArticleElements($articleId)
{
    $sql = 'SELECT * FROM articles_elements WHERE articleId = "' . $articleId . '";';
    return getMultipleSearchResult($sql);
}

function getArticleElementsId($articleId)
{
    $sql = 'SELECT articleElementId FROM articles_elements WHERE articleId = "' . $articleId . '";';
    return getMultipleSearchResult($sql);
}


function deleteArticle($articleId)
{
    $sql = 'DELETE FROM articles WHERE articleId = "' . $articleId . '";';
    return executeSql($sql);
}

function deleteArticleElements($articleId)
{
    $sql = 'DELETE FROM `articles_elements` WHERE articleId = "' . $articleId . '";';
    return executeSql($sql);
}

function editArticleElements($newData)
{
    $articleId = $newData['articleId'];
    $articleElements = $newData['elements'];
    $articleElementsId = getArticleElementsId($articleId);
    foreach ($articleElements as $key => $element) {
        $articleElementId = $articleElementsId[$key]['articleElementId'];
        $sql = '
            UPDATE articles_elements 
            SET elementReference = "' . $element['elementReference'] . '",
            elementContent = "' . $element['elementContent'] . '"
            WHERE articleId = "' . $articleId . '"
            AND articleElementId = "' . $articleElementId . '";
        ';
        executeSql($sql);
    }
}

function existsArticleElement($articleId)
{
    $sql = 'SELECT * FROM articles_elements WHERE articleId = "' . $articleId . '";';
    return getSingleSearchResult($sql);
}


function getLastInsertedArticleId()
{
    $sql = 'SELECT MAX(articleId) as articleId FROM articles;';
    return getSingleSearchResult($sql);
}

function getArticleElementsInfo($articleId)
{
    $newData = array();
    $newImage = array(
        "elementReference" => "article-image",
        "elementContent" => isset($_FILES['article-image']['name']) ?
            $_FILES['article-image']['name'] : ""
    );
    $newData['articleId'] = $articleId;
    $elements = array();
    $elements[] = $newImage;
    foreach ($_POST as $key => $value) {
        $newElement = array(
            "elementReference" => $key,
            "elementContent" => isset($value) ? $value : ""
        );
        $elements[] = $newElement;
    }
    $newData['elements'] = $elements;
    return $newData;
}
