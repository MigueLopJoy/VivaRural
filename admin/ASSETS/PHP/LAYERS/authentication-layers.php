<?php
function renderAuthenticationLayer()
{
    renderWrapper();
    if (isset($_GET['register'])) {
        renderRegisterForm();
    } else {
        renderLoginForm();
    }
    echo "</div>";
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

    echo '<input type="text" name="email" placeholder="Email" required>';

    echo
    '
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" name="login" value="SUBMIT">
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
