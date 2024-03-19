<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/router.php';
include($_SERVER['DOCUMENT_ROOT'].'/includes/header-script.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); 
if (isset($_SESSION['loggedin'])) {
    header('Location: /home');
    exit;
}

include($_SERVER['DOCUMENT_ROOT'].'/includes/menu.php'); 
// form per l'autenticazione
?>

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

        <div class="container">
            <?php if(isset($_GET['msg'])){ 
                if(isset($_GET['error']) && $_GET['error'] == 1){
                    echo '<div class="alert alert-danger" role="alert">';
                } else {
                    echo '<div class="alert alert-success" role="alert">';
                }
                echo $_GET['msg']."</div>"; 
            } ?>
            <div class="m-auto" style="max-width:500px;">
                <div class="card-body">
                    <h3 class="text-center mb-4">Accesso</h3>
                    <form class="form-login" name="login" action="/auth/authenticate.php" method="POST">
                        <div class="form-floating">
                            <input class="form-control" id="username" name="username" type="text">
                            <label class="form-label" for="username">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input class="form-control" id="password" name="password" type="password" size="20">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="form-check mb-4">
                            <a href="/auth/password_recovery.php">Password dimenticata?</a>
                        </div>
                        <?php set_csrf() ?>
                        <input class="w-100 btn btn-lg btn-primary mb-4" name="submit" type="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>

<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
