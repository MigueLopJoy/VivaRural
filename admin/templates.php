<?php

public function renderSearchResult() {
    return 
    `
    <div class="search-results-container">
        <form class="search-result">
            <input type="text" name="name" readonly>
            <input type="text" name="region" readonly>
            <input type="text" name="province" readonly>
            <input type="text" name="psotal code" readonly>
            <div class="action-btns-container">
                <input type="submit" name="name" value="View Page">
                <input type="submit" name="name" value="Edit Town">
                <input type="submit" name="name" value="Delete Town">
            </div>
        </form>
    </div>
    `;
}

?>