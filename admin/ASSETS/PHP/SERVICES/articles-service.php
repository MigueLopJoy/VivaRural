<?php
function createArticleElements($id)
{
    $elements = array(
        array(
            'article' => $id,
            'reference' => 'article-image',
            'content' => 'section-example.png'
        ),
        array(
            'article' => $id,
            'reference' => 'article-title',
            'content' => 'Article Title'
        ),
        array(
            'article' => $id,
            'reference' => 'article-content',
            'content' => 'Write your text here'
        )
    );
    foreach ($elements as $element) {
        insertArticleElement($element);
    }
}

function insertArticleElement($element)
{
    $connection = connect();
    $insertQuery = "insert into articles_elements(article, reference, content) values(?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    $statement->bind_param("sss", $element['article'], $element['reference'], $element['content']);
    $statement->execute();
    close($connection);
    insertAction(getActionData());
}


function editArticleElements($elements)
{
    $i = 0;
    foreach ($elements as $key => $value) {
        $connection = connect();
        switch ($key) {
            case 'article-image':
                $id = $_GET['element-1'];
                break;
            case 'article-title':
                $id = $_GET['element-2'];
                break;
            case 'article-content':
                $id = $_GET['element-3'];
                break;
        }
        $query = 'UPDATE articles_elements
                  SET reference = "' . $key . '", content = "' . $value . '"
                  WHERE id = ' . $id . ';';
        $statement = $connection->prepare($query);
        $statement->execute();
        close($connection);
    }
    header('Location: ' . '?page-editor&town=' . $_GET['town']);
}

function deleteArticle()
{
    $connection = connect();
    $query = 'DELETE FROM articles_elements WHERE article = ' . $_GET['id'];
    $statement = $connection->prepare($query);
    $statement->execute();
    insertAction(getActionData());
    $query = 'DELETE FROM articles WHERE id = ' . $_GET['id'];
    $statement = $connection->prepare($query);
    $statement->execute();
    close($connection);
    insertAction(getActionData());
}

function getArticleElements($articleId)
{
    $sql = 'SELECT * FROM articles_elements WHERE article = "' . $articleId . '";';
    return getMultipleSearchResult($sql);
}

function getLastInsertedArticles()
{
    $sql = 'SELECT MAX(id) as id FROM articles;';
    return getSingleSearchResult($sql);
}

function getLastInsertedArticles_elements()
{
    $sql = 'SELECT MAX(id) as id FROM articles_elements;';
    return getSingleSearchResult($sql);
}
