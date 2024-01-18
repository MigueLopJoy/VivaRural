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
        $table = $table['Tables_in_vivarural'];
        if (array_key_exists($table, $tableTranslations)) {
            echo
            '
            <li>
                <a class="nav-link text-white" href="?table=' . $table . '&action=search">' . $tableTranslations[$table] . '</a>
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
    $action = ($_GET['form'] === 'create') ? 'create' : 'search';
    echo '
    <div class="towns-forms-container">
        <form method="POST" action="?table=' . $_GET['table'] . '&action=' . $action . '" class="form">
            <input type="text" name="name" placeholder="Town Name">
            <input type="text" name="region" placeholder="Region">
            <input type="text" name="province" placeholder="Province">
            <input type="text" name="postalCode" placeholder="Postal Code">
    ';
    if ($_GET['form'] === 'create') {
        echo '
        <input type="file" name="thumbnail" accept="image/*">
        <input type="submit" name="create-town" value="Crear">
        ';
    } else {
        echo '
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
    echo '</form></div></div>';
}

function renderUsersForm()
{
    $action = ($_GET['form'] === 'create') ? 'create' : 'search';
    echo '
    <div class="users-forms-container">
        <form method="POST" action="?table=' . $_GET['table'] . '&action=' . $action . '" class="form">
            <input type="text" name="firstname" placeholder="Nombre">
            <input type="text" name="lastname" placeholder="Apellidos">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="phoneNumber" placeholder="Número de teléfono">
            <input type="text" name="username" placeholder="Nombre de usuario">
    ';

    if ($_GET['form'] === 'search') {
        echo '
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
        echo '
        <div class="input-group">
            <input type="date" name="birthDate">
        </div>
        <input type="hidden" name="password" value="' . password_hash('1234', PASSWORD_BCRYPT) . '">
        <input type="hidden" name="registrationDate" value="' .  date("Y-m-d") . '">
        ';
    }
    echo '
    <input type="hidden" name="registrationDate" value="' . date("Y-m-d") . '">
    <div class="input-group">
        <select name="role">
            <option value="" disabled selected>Elegir Rol</option>
            <option value="1">Administrador</option>
            <option value="2">Usuario</option>
        </select>
    </div>
    ';
    if ($_GET['form'] === 'search') {
        echo '
        <div class="form-group">
            <input type="submit" value="Buscar">
        </div>        
        ';
    } else {
        echo '
        <div class="form-group">
            <input type="submit" value="Crear">
        </div>
        ';
    }
    echo '</form></div></div>';
}

function renderInterestsForm()
{
    $action = ($_GET['form'] === 'create') ? 'create' : 'search';
    echo '
        <div class="interest-forms-container">
            <div class="form-title text-center mb-3">
                <h2>Buscar Interés</h2>
            </div>   
            <form method="POST" action="?table=' . $_GET['table'] . '&action=' . $action . '" class="form">
                <input type="text" name="name" placeholder="Interés">
    ';
    if ($action === 'create') {
        echo '<input type="submit" value="Crear">';
    } else {
        echo '<input type="submit" value="Buscar">';
    }
    echo '</form></div></div>';
}

function renderAdmin_actionsForm()
{
    echo
    '
        <div class="actions-forms-container">
            <div class="form-title text-center mb-3">
                <h2>Buscar Acción de Administrador</h2>
            </div>   
            <form method="POST" action="?table=' . $_GET['table'] . '&action=search" class="form">
                <input type="text" name="adminEma" placeholder="Admin email">
                <input type="text" name="town" placeholder="Nombre de localidad">
                <select name="action">
                    <option value="" disabled selected>Acción</option>
                    <option value="login">Login</option>
                    <option value="create-town">Create Town and Town Page</option>
                    <option value="search-town">Search Town Page</option>
                    <option value="edit-banner">Edit Banner</option>
                    <option value="create-article">Create Article</option>
                    <option value="edit-article">Edit Article</option>
                    <option value="delete-article">Delete Article</option>
                    <option value="logout">Logout</option>
                </select>
                <div class="input-group">
                    <div class="col-6 pe-1">
                        <input type="date" name="minDateTime">
                    </div>
                    <div class="col-6 ps-1">
                        <input type="date" name="maxDateTime">
                    </div>
                </div>
                <input type="submit" value="Buscar">
            </form>
        </div>
    </div>
    ';
}

function renderResultsTable()
{
    echo '
    <div class="wrapper h-100 px-5">
        <div class="box m-auto position-relative shadow bg-white rounded p-5 py-4 h-75">
    ';
    renderActionResultMessage();
    renderTableBtns();
    if ($_GET['data'] !== 'W10=') {
        renderTableHead();
        renderTableBody();
    } else {
        echo '
        <div class="result-message-container text-center">
            <p class="text-danger fs-5 mb-1">No se encontraron resultados de búsqueda</p>
        </div>
        ';
    }
    echo '</div></div>';
}

function renderTableBtns()
{
    echo '<div class="results-btns-container">';
    if ($_GET['table'] !== 'admin_actions') {
        echo '
            <div class="d-inline-block add-btn-container mb-3">
                <a href="?table=' . $_GET['table'] . '&form=create"
                    class="custom-btn d-flex align-items-center justify-content-center border rounded fs-3 px-3 py-1">
                        <i class="bi bi-plus-circle"></i>
                </a>
            </div>
        ';
    }
    echo '
                <div class="d-inline-block search-btn-container mb-3">
                    <a href="?table=' . $_GET['table'] . '&form=search"
                        class="d-flex align-items-center justify-content-center border rounded fs-3 px-3 py-1">
                            <i class="bi bi-search"></i>
                    </a>
                </div>
                <div class="close-table-container d-inline-block border rounded float-end">
                    <a href="?" class="fs-3 px-3 py-1">X</a>
                </div>
            </div>
    ';
}

function renderTableHead()
{
    echo '
    <div class="table-container h-75 overflow-auto">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
    ';
    $tableFields = getTableFields();
    foreach ($tableFields as $th) {
        if ($th['Field'] !== 'id' && $th['Field'] !== 'password') {
            echo '<th class="text-center">' . $th['Field'] . '</th>';
        }
    }
    if ($_GET['table'] !== 'admin_actions') {
        echo '<th class="text-center">Acción</th>';
    }
    if ($_GET['table'] === 'towns') {
        echo '<th class="text-center">Ver página</th></tr></thead>';
    }
}

function renderTableBody()
{
    echo '<tbody>';
    $data = json_decode(base64_decode($_GET['data']));
    foreach ($data as $row) {
        $id = $row->id;
        echo '<tr>';
        foreach ($row as $field) {
            if ($field !== $id) {
                echo '<td class="text-center">' . $field . '</td>';
            }
        }
        if ($_GET['table'] !== 'admin_actions') {
            createActionBtns($id);
        }
        if ($_GET['table'] === 'towns') {
            renderViewPageBtn($id);
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

function createActionBtns($id)
{
    echo
    '
    <td class="d-flex justify-content-center">
        <div class="col-6 text-center me-1">
            <button class="btn btn-danger" type="button">
                <a href="?table=' . $_GET['table'] . '&action=delete&id=' . $id . '" class="text-white">Eliminar</a>
            </button>
        </div>
        <div class="col-6 text-center ms-1">
            <button class="btn btn-success" type="button">
                <a href="?table=' . $_GET['table'] . '&action=edit&id=' . $id . '" class="text-white">Editar</a>
            </button>
        </div>
    </td>
    ';
}

function renderViewPageBtn($id) {
    echo '
    <td class="text-center">
            <a href="?page-editor&id=' . $id . '" 
                class="class="d-flex align-items-center justify-content-center border rounded fs-3 px-3 py-1">
                <i class="bi bi-three-dots"></i>
            </a>
    </td>
    ';
}

function renderActionResultMessage()
{
    $message = '';
    $color = '';
    if (isset($_GET['operation']) && $_GET['operation'] === 'edit') {
        if (isset($_GET['result']) && $_GET['result'] === 'success') {
            $message = 'Registro editado con éxito';
            $color = 'text-success';
        } else if (isset($_GET['result']) && $_GET['result'] === 'error') {
            $message = 'Error al editar el registro';
            $color = 'text-danger';
        }
    } else if (isset($_GET['operation']) && $_GET['operation'] === 'delete') {
        if (isset($_GET['result']) && $_GET['result'] === 'success') {
            $color = 'text-success';
            $message = 'Registro eliminado con éxito';
        } else if (isset($_GET['result']) && $_GET['result'] === 'error') {
            $message = 'Error al eliminar el registro';
            $color = 'text-danger';
        }
    } else if (isset($_GET['operation']) && $_GET['operation'] === 'create') {
        if (isset($_GET['result']) && $_GET['result'] === 'success') {
            $color = 'text-success';
            $message = 'Registro creado con éxito';
        } else if (isset($_GET['result']) && $_GET['result'] === 'error') {
            $message = 'Error al crear el registro';
            $color = 'text-danger';
        }
    }
    echo '
        <div class="result-message-container text-center">
            <p class="' . $color . ' fs-5 mb-1">' . $message . '</p>
        </div>
    ';
}
