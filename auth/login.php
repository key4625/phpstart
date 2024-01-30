<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/functions.php');

if (isset($_SESSION['loggedin'])) {
    header('Location: /home');
    exit;
}

include('../includes/header.php'); 
include('../includes/menu.php'); 
// form per l'autenticazione
?>
<html>
    <style>
        .form-login input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .form-login input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        
    </style>
    <body>
        <div class="container">
            <div class="m-auto" style="max-width:500px;">
                <div class="card-body">
                    <h3 class="text-center mb-4">Accesso</h3>
                    <form class="form-login" name="login" action="authenticate.php" method="POST">
                        <div class="form-floating">
                            <input class="form-control" id="username" name="username" type="text">
                            <label class="form-label" for="username">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input class="form-control" id="password" name="password" type="password" size="20">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <input class="w-100 btn btn-lg btn-primary mb-4" name="submit" type="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
