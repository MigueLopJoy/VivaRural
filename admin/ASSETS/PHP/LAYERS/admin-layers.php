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
                <div class="overflow-hidden flex-fill">
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
                </div>
                <hr>
                <div class="logout-icon text-center mt-auto">
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
    echo '
        <div class="wrapper w-50 m-auto">
            <div class="box m-auto position-relative shadow bg-white rounded p-5 pb-4">
        ';
    call_user_func('render' . $object . 'Form');
}

function renderDestinationForm()
{
    echo
    '
            <div class="create-town-container">
                <form method="POST" action="?" class="form search-form">
                    <input type="text" name="townName" placeholder="Town Name">
                    <input type="text" name="region" placeholder="Region">
                    <input type="text" name="province" placeholder="Province">
                    <input type="text" name="postalCode" placeholder="Postal Code">
    ';
    if ($_GET['action'] === 'create') {
        echo
        '
                    <input type="file" name="thumbnail" accept="image/*">
                    <input type="submit" name="create-town" value="Crear">
        ';
    } else {
        echo
        '
                    <div class="input-group">
                        <div class="col-6 pe-1">
                            <input type="text" name="minRating" placeholder="Min. Rating">
                        </div>
                        <div class="col-6 ps-1">
                            <input type="text" name="maxRating" placeholder="Max Rating">
                        </div>
                    </div>        
                    <input type="submit" name="search-town" value="Buscar">
                    
        ';
    }
    echo
    '
                </form>
            </div>
        </div>
    ';
}

function renderUserForm()
{
    echo
    '
        <div class="search-user-container">
            <form method="POST" action="?" class="form search-form">
                <input type="text" name="firstname" placeholder="Nombre">
                <input type="text" name="lastname" placeholder="Apellidos">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="phoneNumber" placeholder="Número de teléfono">
                <input type="text" name="userName" placeholder="Nombre de usuario">
    ';

    if ($_GET['action'] === 'search') {
        echo
        '
                    <div class="input-group">
                        <div class="col-6 pe-1">
                            <input type="date" name="minBirthDate" placeholder="Fec. Nac. Min.">
                        </div>
                        <div class="col-6 ps-1">
                            <input type="date" name="maxBirthDate" placeholder="Fec. Nac. Max">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="col-6 pe-1">
                            <input type="date" name="minRegistrationDate" placeholder="Fec. Reg. Min.">
                        </div>
                        <div class="col-6 ps-1">
                            <input type="date" name="maxRegistrationDate" placeholder="Fec. Reg. Max">
                        </div>
                    </div>
        ';
    } else {
        echo
        '
                    <div class="input-group">
                        <input type="date" name="birthDate">
                    </div>
        ';
    }

    echo
    '
                    <div class="input-group">
                        <select name="roleId">
                            <option value="" disabled selected>Elegir Rol</option>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
    ';

    if ($_GET['action'] === 'search') {
        echo
        '
                    <div class="form-group">
                        <input type="submit" name="search-user" value="Buscar">
                    </div>        
        ';
    } else {
        echo
        '
                    <div class="form-group">
                        <input type="submit" name="create-user" value="Crear">
                    </div>
        ';
    }
    echo
    '
                </form>
            </div>
        </div>
    ';
}

function renderResultsTable()
{
    echo
    '
    <div class="wrapper px-5">
        <div class="box m-auto position-relative shadow bg-white rounded p-5 pb-4">
            <div class="close-table-container">
                <span class="position-absolute"><a href="?">X</a></span>
            </div>
            <table class="table">
                <thead>
                    <tr>
    ';

    $sql = 'SHOW COLUMNS FROM ' . $_GET['table'] . ';';
    $tHead = getMultipleSearchResult($sql);
    foreach ($tHead as $th) {
        if ($th['Field'] !== 'userid' && $th['Field'] !== 'password' && $th['Field'] !== 'townid') {
            echo '<th class="text-center">' . $th['Field'] . '</th>';
        }
    }
    echo
    '
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
        <tbody>
    ';

    $data = json_decode(base64_decode($_GET['data']));
    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $field) {
            if ((isset($row->townid) && $field !== $row->townid) 
                || (isset($row->userid) && $field !== $row->userid)
            ) {
                echo '<td class="text-center">' . $field . '</td>';
            }
        }
        echo '<td class="d-flex justify-content-center">
                <div class="col-6 text-center">
                    <form action="?" method="post">
                        <input type="hidden" name="' . (isset($row->townid) ? 'townid' : 'userid') . '" value="' . (isset($row->townid) ? $row->townid : $row->userid) . '">
                        <button type="submit" name="delete-' . (isset($row->townid) ? 'town' : 'user') . '" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
                <div class="col-6 text-center">
                    <form action="?" method="post">
                        <input type="hidden" name="' . (isset($row->townid) ? 'townid' : 'userid') . '" value="' . (isset($row->townid) ? $row->townid : $row->userid) . '">
                        <button type="submit" name="edit-' . (isset($row->townid) ? 'town' : 'user') . '" class="btn btn-success">Editar</button>
                    </form>
                </div>
            </td>
        </tr>';
    }

    echo '</tbody></table></div></div>';
}
