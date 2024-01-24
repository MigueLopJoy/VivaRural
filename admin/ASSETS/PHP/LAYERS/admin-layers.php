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
            echo '
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
        <div class="wrapper w-100 h-100 d-flex align-items-center justify-content-center">
            <div class="box w-50 position-relative shadow bg-white rounded p-5 pb-4">
        ';
    call_user_func('render' . $table . 'Form');
}

function renderTownsForm()
{
    $form = $_GET['form'];
    $parameters = getFormParameters();
    if (isset($_GET['data'])) {
        $data = json_decode(base64_decode($_GET['data']), true);
        $name = $data['name'];
        $region = $data['region'];
        $province = $data['province'];
        $postalCode = $data['postalCode'];
    }
    echo '
    <div class="towns-forms-container">
        <div class="form-title text-center mb-3">
            <h2>' . $parameters['title'] . '</h2>
        </div>  
        <form method="POST" action="' . $parameters['url'] . '" class="form">
            <input type="text" name="name" placeholder="Nombre" value="' . (isset($name) ? $name : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="region" placeholder="Región" value="' . (isset($region) ? $region : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="province" placeholder="Provincia" value="' . (isset($province) ? $province : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="postalCode" placeholder="Código Postal" value="' . (isset($postalCode) ? $postalCode : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
    ';
    if ($form !== 'search') {
        if ($form === 'create') {
            echo '<input type="hidden" name="rating" value="">';
        }
        echo '<input type="file" name="thumbnail" accept="image/*">';
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
        ';
    }
    echo '
        <input type="submit" value="' . $parameters['btn'] . '">             
    </form></div></div>';
}

function renderUsersForm()
{
    $form = $_GET['form'];
    $parameters = getFormParameters();
    if (isset($_GET['data'])) {
        $data = json_decode(base64_decode($_GET['data']), true);
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $phoneNumber = $data['phoneNumber'];
        $userName = $data['userName'];
        $role = $data['role'];
    }
    echo '
    <div class="users-forms-container">
        <div class="form-title text-center mb-3">
            <h2>' . $parameters['title'] . '</h2>
        </div>  
        <form method="POST" action="' . $parameters['url'] . '" class="form">
            <input type="text" name="firstname" placeholder="Nombre" value="' . (isset($firstname) ? $firstname : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="lastname" placeholder="Apellidos" value="' . (isset($lastname) ? $lastname : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="email" placeholder="email" value="' . (isset($email) ? $email : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="phoneNumber" placeholder="Número de teléfono" value="' . (isset($phoneNumber) ? $phoneNumber : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="text" name="username" placeholder="Nombre de usuario" value="' . (isset($userName) ? $userName : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>        
    ';
    if ($parameters['action'] === 'search') {
        echo '
        <div class="input-group">
            <div class="w-100">
                <label>Rango de fecha de nacimiento:</label>
            </div>
            <div class="row w-100">
                <div class="col-6 ps-0 pe-1">
                    <input type="date" name="minBirthDate" placeholder="Fec. Nac. Min.">
                </div>
                <div class="col-6 ps-1 pe-0">
                    <input type="date" name="maxBirthDate" placeholder="Fec. Nac. Max">
                </div>
            </div>
        </div>
        <div class="input-group">
            <div class="w-100">
                <label>Rango de fecha de registro:</label>
            </div>
            <div class="row w-100">
                <div class="col-6 pe-1 ps-0">
                    <input type="date" name="minRegistrationDate" placeholder="Fec. Reg. Min.">
                </div>
                <div class="col-6 ps-1 pe-0">
                    <input type="date" name="maxRegistrationDate" placeholder="Fec. Reg. Max">
                </div>
            </div>
        </div>
        ';
    } else {
        echo '
        <div class="input-group">
            <label for="birthDate">Fecha de nacimiento:</label>
            <input type="date" name="birthDate" value="' . (isset($data) ? date('Y-m-d', strtotime($data['birthDate'])) : '') . '">
        </div>
        <input type="hidden" name="password" value="' . password_hash('1234', PASSWORD_BCRYPT) . '">
        ';
    }
    echo '
    <input type="hidden" name="registrationDate" value="' . date("Y-m-d") . '">
    <div class="input-group">
        <select name="role" value="' . (isset($role) ? $role : '') . '"  ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <option value="" disabled selected>Elegir rol</option>
            <option value="1">Administrador</option>
            <option value="2">Usuario</option>
        </select>
    </div>
    <input type="submit" value="' . $parameters['btn'] . '">
    </form></div></div>
    ';
}

function renderInterestsForm()
{
    $form = $_GET['form'];
    $parameters = getFormParameters();
    if (isset($_GET['data'])) {
        $data = json_decode(base64_decode($_GET['data']), true);
        $name = $data['name'];
    }
    echo '
    <div class="interest-forms-container">
        <div class="form-title text-center mb-3">
            <h2>' . $parameters['title'] . '</h2>
        </div>   
        <form method="POST" action="' . $parameters['url'] . '" class="form">
            <input type="text" name="name" placeholder="Interés" value="' . (isset($name) ? $name : '') . '" ' . ($form !== 'search' ? 'required="true"' : '') . '>
            <input type="submit" value="' . $parameters['btn'] . '">
        </form>
    </div></div>';
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

function getFormParameters()
{
    $parameters = array();
    $action = '';
    $title = '';
    $btn = '';
    $url = '?table=' . $_GET['table'];
    switch ($_GET['form']) {
        case 'create':
            $action = 'create';
            $title = 'Crear ' . $_GET['table'];
            $btn = 'Crear';
            $url .= '&action=' . $action;
            break;
        case 'edit':
            $action = 'edit';
            $title = 'Editar ' . $_GET['table'];
            $btn = 'Editar';
            $url .= '&action=' . $action . '&id=' . $_GET['id'];
            break;
        case 'search':
            $action = 'search';
            $title = 'Buscar ' . $_GET['table'];
            $btn = 'Buscar';
            $url .= '&action=' . $action;
            break;
    }
    $parameters['action'] = $action;
    $parameters['title'] = $title;
    $parameters['btn'] = $btn;
    $parameters['url'] = $url;
    return $parameters;
}


function renderResultsTable()
{
    echo '
    <div class="wrapper w-100 h-100 d-flex align-items-center justify-content-center">
        <div class="box results-box w-75 position-relative shadow bg-white rounded p-5 py-4">
    ';
    renderActionResultMessage();
    renderTableBtns();
    if ($_SESSION['data'] !== 'W10=') {
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
    $data = json_decode(base64_decode($_SESSION['data']), true);
    foreach ($data as $row) {
        $id = $row['id'];
        echo '<tr>';
        foreach ($row as $field) {
            if ($field !== $id) {
                echo '<td class="text-center">' . $field . '</td>';
            }
        }
        if ($_GET['table'] !== 'admin_actions') {
            renderActionBtns($id, base64_encode(json_encode($row)));
        }
        if ($_GET['table'] === 'towns') {
            renderViewPageBtn($id);
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

function renderActionBtns($id, $data)
{
    echo
    '
    <td class="d-flex justify-content-center">
        <div class="d-inline-block text-center me-1">
            <button class="btn btn-danger" type="button">
                <a href="?table=' . $_GET['table'] . '&action=delete&id=' . $id . '" class="text-white">Eliminar</a>
            </button>
        </div>
        <div class="d-inline-block text-center ms-1">
            <button class="btn btn-success" type="button">
                <a href="?table=' . $_GET['table'] . '&form=edit&id=' . $id . '&data=' . $data . '" class="text-white">Editar</a>
            </button>
        </div>
    </td>
    ';
}

function renderViewPageBtn($id)
{
    echo '
    <td class="text-center">
        <a href="?page-editor&town=' . $id . '" 
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
