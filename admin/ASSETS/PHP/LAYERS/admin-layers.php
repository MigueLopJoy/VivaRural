<?php
function renderSideMenu()
{
    echo '
    <div class="col-3 h-100">
        <aside class="side-menu h-100">
            <div class="d-flex flex-column h-100 p-3 text-bg-dark">
                <div class=" page-logo-container">
                    <a href="/" class="page-logo-link d-flex align-items-center mb-3">
                        <img src="./../LIB/MEDIA/IMGS/logo.png" alt="page logo" class="img-fluid">
                    </a>
                </div>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="navaction-item">
                        <button class="btn btn-toggle collapsed text-white" data-bs-toggle="collapse" data-bs-target=".destinations-collapse" aria-expanded="false">
                            Destinos
                        </button>
                        <div class="collapse destinations-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                                <li><a href="?menu&object=destination&action=create" class="nav-link text-white">Crear destino</a></li>
                                <li><a href="?menu&object=destination&action=search" class="nav-link text-white">Buscar destino</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-toggle collapsed text-white" data-bs-toggle="collapse" data-bs-target=".pages-collapse" aria-expanded="false">
                            Páginas
                        </button>
                        <div class="collapse pages-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                                <li><a href="?menu&object=page&action=create" class="nav-link text-white">Crear página de destino</a></li>
                                <li><a href="?menu&object=page&action=search" class="nav-link text-white">Buscar página de destino</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button class="btn btn-toggle collapsed text-white" data-bs-toggle="collapse" data-bs-target=".users-collapse" aria-expanded="false">
                            Usuarios  
                        </button>
                        <div class="collapse users-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                                <li><a href="?menu&object=user&action=create" class="nav-link text-white">Crear usuario</a></li>
                                <li><a href="?menu&object=user&action=search" class="nav-link text-white">Buscar usuario</a></li>
                            </ul>
                        </div>
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
    </div>
    <div class="col-9">
        <main>
    ';
}

function renderMenuForms()
{
    $object = $_GET['object'];
    $action = $_GET['action'];
    echo '
        <div class="wrapper w-50 m-auto">
            <div class="box m-auto position-relative shadow bg-white rounded p-5 pb-4">
        ';
    call_user_func('render' . $action . $object . 'Form');
}

function renderCreateDestinationForm()
{
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

function renderSearchDestinationForm()
{
    echo
    '
            <div class="search-destination-container">
                <form method="POST" class="form search-form">
                    <input type="text" name="townName" placeholder="Town Name">
                    <input type="submit" name="search-destination" value="Search">
                </form>
            </div>
        </div>
        ';
}

function renderCreatePageForm()
{
}

function renderSearchPagesForm()
{
    echo
    '
            <div class="search-page-container">
                <form method="POST" class="form search-form">
                    <input type="text" name="townName" placeholder="Town Name">
                    <input type="submit" name="search-page" value="Search">
                </form>
            </div>
        </div>
        ';
}

function renderCreateUserForm()
{
}


function renderSearchUserForm()
{
    echo
    '
            <div class="search-user-container">
                <form method="POST" class="form search-form">
                    <input type="text" name="townName" placeholder="Nombre">
                    <input type="text" name="townName" placeholder="Apellidos">
                    <input type="text" name="townName" placeholder="Email">
                    <input type="text" name="townName" placeholder="Número de teléfono">
                    <input type="text" name="townName" placeholder="Nombre de usuario">
                    <div class="form-group">
                        <div class="col-6">
                            <input type="text" name="townName" placeholder="">
                        </div>
                        <div class="col-6">
                            <input type="text" name="townName" placeholder="Town Name">
                        </div>
                    </div>
                    <input type="submit" name="search-user" value="Search">
                </form>
            </div>
        </div>
        ';
}
