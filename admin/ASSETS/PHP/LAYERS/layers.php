<?php

    function renderSearchEngineLayer() {
        echo
        '
        <div class="search-engine-container">
            <form action="" class="form search-form">
                <input type="text" name="identifier" placeholder="Town Identifier">
                <input type="text" name="townName" placeholder="Town Name">
                <input type="submit" value="Search">
            </form>
        </div>
        ';
    }

    function renderCreateTownLayer() {
        echo
        '
        <div class="search-engine-container">
            <form action="" class="form search-form">
                <input type="text" name="townName" placeholder="Town Name">
                <input type="text" name="province" placeholder="Province">
                <input type="text" name="postalCode" placeholder="Postal Code">
                <input type="submit" value="Create">
            </form>
        </div>
        ';
    }

    function renderSearchResult($searchResult) {
        echo '
        <div class="search-results-container">
            <form class="search-result">
                <input type="text" name="townName" value="' . $searchResult['townName'] . '" readonly>
                <input type="text" name="region" value="' . $searchResult['region'] . '" readonly>
                <input type="text" name="province" value="' . $searchResult['province'] . '" readonly>
                <input type="text" name="postalCode" value="' . $searchResult['postalCode'] . '" readonly>
                <div class="action-btns-container">
                    <input type="submit" name="name" value="View Page">
                    <input type="submit" name="name" value="Edit Town">
                    <input type="submit" name="name" value="Delete Town">
                </div>
            </form>
        </div>';
    }

?>