<?php

function renderSideMenu()
{
    $tables = getTablesFromDatabase();

    $tableTranslations = [
        'users' => 'Usuarios',
        'towns' => 'Localidades',
        'interests' => 'Intereses',
        'admin_actions' => 'Acciones'
    ];

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
                <div class="overflow-auto flex-fill">
                    <ul class="nav nav-pills flex-column mb-auto">
    ';

    foreach ($tables as $table) {
        $tableName = $table['Tables_in_vivarural'];
        if (array_key_exists($tableName, $tableTranslations)) {
            echo
            '
            <li>
                <button class="btn btn-toggle collapsed text-white" data-bs-toggle="collapse" data-bs-target=".' . $tableName . '-collapse" aria-expanded="false">
                    ' . $tableTranslations[$tableName] . '
                </button>
                <div class="collapse ' . $tableName . '-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
            ';

            if ($tableName !== 'admin_actions') {
                echo '<li><a href="?menu&table=' . $tableName . '&action=create" class="nav-link text-white">Crear ' . $tableTranslations[$tableName] . '</a></li>';
            }

            echo '
                        <li><a href="?menu&table=' . $tableName . '&action=search" class="nav-link text-white">Buscar ' . $tableTranslations[$tableName] . '</a></li>
                    </ul>
                </div>
            </li>
            ';
        }
    }

    echo '
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
        <main class="h-100">
    ';
}

function getTablesFromDatabase()
{
    $sql = 'SHOW TABLES;';
    return getMultipleSearchResult($sql);
}

function renderMenuForms()
{
    $table = $_GET['table'];
    echo '
        <div class="wrapper w-50 m-auto">
            <div class="box m-auto position-relative shadow bg-white rounded p-5 pb-4">
        ';
    call_user_func('render' . $table . 'Form');
}

function renderTownsForm()
{
    echo
    '
    <div class="towns-forms-container">
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

function renderUsersForm()
{
    echo
    '
    <div class="users-forms-container">
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

function renderInterestsForm()
{
    echo
    '
    <div class="interest-forms-container">
        <form method="POST" action="?" class="form search-form">
            <input type="text" name="interestName" placeholder="Interés">
    ';
    if ($_GET['action'] === 'create') {
        echo '<input type="submit" name="create-interest" value="Crear">';
    } else {
        echo '<input type="submit" name="search-interest" value="Buscar">';
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
    <div class="wrapper h-75 px-5">
        <div class="box m-auto position-relative shadow bg-white rounded p-5 pb-4 h-100 overflow-auto">
            <div class="close-table-container">
                <span class="position-absolute"><a href="?">X</a></span>
            </div>
            <table class="table">
                <thead>
                    <tr>
    ';
    renderTableHead();
    echo '<tbody>';
    renderTableBody();
    echo '</tbody></table></div></div>';
}

function renderTableHead()
{
    $sql = 'SHOW COLUMNS FROM ' . $_GET['table'] . ';';
    $tHead = getMultipleSearchResult($sql);
    foreach ($tHead as $th) {
        if ((!stripos($th['Field'], 'id') || (stripos($th['Field'], 'id') && $th['Field'] === 'roleid'))
            && $th['Field'] !== 'password'
        ) {
            echo '<th class="text-center">' . $th['Field'] . '</th>';
        }
    }
    echo '<th class="text-center">Acción</th></tr></thead>';
}

function renderTableBody()
{
    $data = json_decode(base64_decode($_GET['data']));
    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $field) {
            if ($field !== $row->id) {
                echo '<td class="text-center">' . $field . '</td>';
            }
        }
        createActionBtns($row);
        echo '</tr>';
    }
    echo '</tbody>';
}

function createActionBtns($row)
{
    echo
    '
    <td class="d-flex justify-content-center">
        <div class="col-6 text-center">
            <form action="?" method="post">
                <input type="hidden" name="id" value="' . $row->id . '">
                <button type="submit" name="delete-' . $_GET['table'] . '" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
        <div class="col-6 text-center">
            <form action="?" method="post">
                <input type="hidden" name="id" value="' . $row->id . '">
                <button type="submit" name="edit-' . $_GET['table'] . '" class="btn btn-success">Editar</button>
            </form>
        </div>
    </td>
    ';
}
