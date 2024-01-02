<?php

function loadTownPage()
{
    $pageId = $_SESSION['pageId'];
    $pageInfo = getPageContentFromPageId($pageId);
    renderPageEditor($pageInfo);
}

function editPageBanner()
{
    editPageBannerInfo(
        $_FILES['banner-img-input']['name'],
        $_SESSION['pageId']
    );
    insertAdminAction(4);
    redirectToTownPage();
}

function createTownAndTownPage()
{
    insertTownInfo($_POST);
    insertNewPage();
    $pageId = (getLastInsertedPageId())['pageId'];
    $_SESSION['pageId'] = $pageId;
    insertAdminAction(2);
    redirectToTownPage();
}

function searchTownPage()
{
    $townInfo = findTownByTownData($_POST);
    $townId = $townInfo['townid'];
    $pageId = (getPageIdFromTownId($townId))['pageId'];
    $_SESSION['pageId'] = $pageId;
    insertAdminAction(3);
    redirectToTownPage();
}

function redirectToTownPage()
{
    header("Location: ?page-editor");
    exit();
}

function insertNewPage()
{
    $townId = getLastInsertedTownId()['townId'];
    $thumbnail = $_POST['thumbnail'];
    $connection = connect();
    $insertQuery = "insert into town_pages(townId, thumbnail) values(?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("is", $townId, $thumbnail);
    $insertResult = $statement->execute();
    close($connection);
    return $insertResult;
}

function editPageBannerInfo($newImage, $pageId)
{
    $sql = '
        UPDATE town_pages tp
        SET bannerImage = "' . $newImage . '"
        WHERE tp.pageId = ' . $pageId . '
    ';
    executeSql($sql);
}

function getLastInsertedPageId()
{
    $sql = 'SELECT MAX(pageId) as pageId FROM town_pages;';
    return getSingleSearchResult($sql);
}

function getPageIdFromTownId($townId)
{
    $sql =
        '
            SELECT pageId FROM `town_pages` tp
            WHERE tp.townId = ' . $townId . ';
        ';
    return getSingleSearchResult($sql);
}
