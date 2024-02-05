<?php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header-script.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); 
//se è già autenticato allora lo reindirizzo alla home
if (isset($_SESSION['loggedin'])) {
	header('Location: home');
	exit;
}

include($_SERVER['DOCUMENT_ROOT'].'/includes/menu.php'); 
// form per la registrazione
?>
<div class="container register">
    <?php // spazio dei messaggi
    if(isset($_GET['msg'])){ ?>
        <div class="alert alert-danger" role="alert">
            <?= $_GET['msg'] ?>
        </div>
    <?php } ?>
    <h1>Register</h1>
    <form action="/auth/check_registration.php" method="post" autocomplete="off">
        <label for="username">
            <i class="bi bi-person-fill"></i>
        </label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password">
            <i class="bi bi-lock-fill"></i>
        </label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <label for="email">
            <i class="bi bi-envelope-fill"></i>
        </label>
        <input type="email" name="email" placeholder="Email" id="email" required>
        <input type="submit" value="Register">
    </form>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>

