<?php
function renderAuthenticationLayer()
{
    echo '
    <div class="col-12">
        <div class="wrapper w-100">
            <div class="box w-25 m-auto position-relative shadow bg-white rounded p-5 pb-4 mt-5">      
                <div class="login-container">
                    <h2 class="text-center">Login</h2>
    ';
    if (isset($_GET['registration-success']) && $_GET['registration-success'] === 'true') {
        echo '<p style="color: green !important;">New admin registered successfully. Please, login.</p>';
    }
    echo '<form method="POST" class="form login-form">';

    if (isset($_GET['error']) && $_GET['error'] === 'login-error') {
        echo '<p style="color: red;">Bad credentials</p>';
    }
    echo '
        <div class="input-group">
            <input type="text" name="email" placeholder="Email" required>
        </div>
    ';

    echo
    '
                        <div class="input-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-group">
                            <input type="submit" name="login" value="SUBMIT">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    ';
}


function renderLoginForm()
{
}
