<?php
function renderHeader()
{
    echo '
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Sites administration</title>
                <link rel="stylesheet" href="./../LIB/COMMON/CSS/general-styles.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  
        ';
    if (isset($_SESSION['logged-admin'])) {
        echo '
            <link rel="stylesheet" href="./ASSETS/CSS/admin-pages.css">
            <link rel="stylesheet" href="./../LIB/COMMON/CSS/pages.css">
        ';
    }
    echo '<link rel="stylesheet" href="./ASSETS/CSS/admin-layer.css">';
    echo '
        </head>
        <body>
            <row class="h-100 d-flex">
        ';
}

function renderPageBottom()
{
    echo '
                    </main> 
                </div>   
            </row>
            <script src="./ASSETS/JS/scripts.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        </body>
    </html>
    ';
}
