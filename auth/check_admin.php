<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['loggedin'])) {
    if($_SESSION['isAdmin']==1){
        $session_user = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $session_id = htmlspecialchars($_SESSION['id'] ?? '');
    } else {
        Header('Location:/profilo');
    }
} else {
    Header('Location:/auth/login.php');
}
?>