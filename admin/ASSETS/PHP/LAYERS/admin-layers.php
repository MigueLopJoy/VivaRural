<?php
function renderSideMenu()
{
    echo '
    <aside class="side-menu h-100 position-fixed" style="width: 20%;">
        <div class="d-flex flex-column h-100 p-3 text-bg-dark">
            <div class=" page-logo-container">
                <a href="/" class="page-logo-link d-flex align-items-center mb-3">
                    <img src="./../LIB/MEDIA/IMGS/logo.png" alt="page logo" class="img-fluid">
                </a>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="?search-town" class="nav-link text-white">
                        Buscar pueblo
                    </a>
                </li>
                <li>
                    <a href="?create-town" class="nav-link text-white">
                        Crear Pueblo
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        Crear administrador
                    </a>
                </li>
            </ul>
            <hr>
            <div class="logout-icon text-center">
                <a href="?logout">
                    <i class="bi bi-box-arrow-left"></i>
                </a>
            </div>
        </div>
    </aside>
    </main style="flex: 1;">
    ';
}

function renderSearchEngineLayer()
{
    renderWrapper();
    echo
    '
            <div class="search-engine-container">
                <form method="POST" class="form search-form">
                    <input type="text" name="townName" placeholder="Town Name">
                    <input type="submit" name="search-town" value="Search">
                </form>
            </div>
        </div>
        ';
}

function renderCreateTownLayer()
{
    renderWrapper();
    echo
    '
            <div class="create-town-container">
                <form method="POST"  class="form search-form">
                    <input type="text" name="townName" placeholder="Town Name">
                    <input type="text" name="region" placeholder="Region">
                    <input type="text" name="province" placeholder="Province">
                    <input type="text" name="postalCode" placeholder="Postal Code">
                    <input type="file" name="thumbnail" accept="image/*">
                    <input type="submit" name="create-town" value="Create">
                </form>
            </div>
        </div>
        ';
}
