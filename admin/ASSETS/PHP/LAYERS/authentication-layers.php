<?php
function renderAuthenticationLayer()
{
    echo '
    <div class="col-12">
        <div class="wrapper w-100">
            <div class="box w-25 m-auto position-relative shadow bg-white rounded p-5 pb-4">   
            <div class="menu-container">    
                <nav class="box-menu position-absolute top-0 start-0 end-0">
                    <ul class="d-flex p-0 m-0">
                        <li>
                            <a href="?login"><li class="nav-link">Login</li></a>
                        </li>
                        <li>
                            <a href="?register"><li class="nav-link">Register</li></a>
                        </li>
                    </ul>
                </nav>
            </div>      
            <div class="box-window" style="padding-top:1.5rem;">
    ';
    if (isset($_GET['register'])) {
        renderRegisterForm();
    } else {
        renderLoginForm();
    }
    echo '
            </div>
        </div>
    ';
}


function renderLoginForm()
{
    echo
    '
        <div class="login-container">
            <h2>Login</h2>
        ';

    if (isset($_GET['registration-success']) && $_GET['registration-success'] === 'true') {
        echo '<p style="color: green !important;">New admin registered successfully. Please, login.</p>';
    }
    echo '<form method="POST" class="form login-form">';

    if (isset($_GET['error']) && $_GET['error'] === 'login-error') {
        echo '<p style="color: red;">Bad credentials</p>';
    }

    echo '
        <div class="form-group">
            <input type="text" name="email" placeholder="Email" required>
        </div>
    ';

    echo
    '
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="SUBMIT">
                    </div>
                </form>
            </div>
        </div>
    ';
}

function renderRegisterForm()
{
    echo
    '
            <div class="register-container">
                <h2>Register</h2>
                <form method="POST" class="form register-form">
                    <input type="text" name="firstname" placeholder="Firstname" required>
                    <input type="text" name="lastname" placeholder="Lastname" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phoneNumber" placeholder="Phone Number" required>
                    <input type="text" name="userName" placeholder="User Name" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="date" name="birthDate" required>
                    <input type="submit" name="register" value="REGISTER">
                </form>
            </div>
        </div>
        ';
}
