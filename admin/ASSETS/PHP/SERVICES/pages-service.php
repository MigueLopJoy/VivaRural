<?php

function loadTownPage()
{
    $townPageId = getPageIdFromTownId($_GET['town']);
    $pageId = isset($townPageId) ? $townPageId['id'] : null;
    if ($pageId !== null) {
        if (!isset($_SESSION['pageId'])) {
            $_SESSION['pageId'] = $pageId;
        }
        $pageId = $_SESSION['pageId'];
        $pageInfo = getPageContentFromPageId($pageId);
        renderPageEditor($pageInfo);
    } else {
        createTownPage();
    }
}

function createTownPage()
{
    $town = $_GET['town'];
    $url = '?page-editor&town=' . $town . '&table=town_pages&action=create&data=';
    $data = array(
        'town' => $town,
        'bannerImage' => 'example-banner.png'
    );
    $serializedData = base64_encode(json_encode($data));
    header('Location: ' . $url . $serializedData);
}

function getPageIdFromTownId($townId)
{
    $sql =
        '
            SELECT id FROM `town_pages` tp
            WHERE tp.town = ' . $townId . ';
        ';
    return getSingleSearchResult($sql);
}

function getLastTown_pages()
{
    $sql = 'SELECT MAX(id) as id FROM town_pages;';
    return getSingleSearchResult($sql);
}
