<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/router.php';
include_once('../includes/config.php');
include('../includes/functions/connection.php');
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    header('Location: login.php?error=1&msg=Prego compilare entrambi i campi!');
}
if( ! is_csrf_valid() ){
    header('Location: login.php?error=1&msg=CSRF non valido');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, isAdmin, activation_code FROM users WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
}
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password, $isAdmin, $activation_code);
    $stmt->fetch();
    if(($ENABLE_ACTIVATION_CODE == 0)||($activation_code == 'activated')){
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['isAdmin'] = $isAdmin;

             // Generate a secure token
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION['token'] = $token;

            header('Location: /home ');
        } else {
            // Incorrect password
            header('Location: login.php?error=1&msg=Username o password errati!');
        }
    } else {
        header('Location: login.php?error=1&msg=Il tuo account non è attivo! Controlla la tua email per attivarlo!');
    }
} else {
    // Incorrect username
    header('Location: login.php?error=1&msg=Username o password errati!');
}
$stmt->close();
