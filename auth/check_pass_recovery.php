<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header-script.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
if (isset($_SESSION['loggedin'])) {
    header('Location: /home');
    exit;
}
include($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
?>
<div class="container">
<?php
$error = "";
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
    $key = $_GET["key"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s");
    $stmt = $con->prepare("SELECT * FROM `password_reset_temp` WHERE `key`=? and `email`=?");
    $stmt->bind_param("ss", $key, $email);
    $stmt->execute();
    $results = $stmt->get_result();
    $num_row = $results->num_rows;
    //var_dump($num_row);
    //exit;
    $stmt->close();
    
    if ($num_row == 0) {
        $error .= '<h2>Link non valido</h2>
            <p>Il link non è valido o scaduto. Potresti non aver copiato correttamente il link dall\'email o hai già utilizzato la chiave, che è stata disattivata.</p>
            <p><a href="/auth/password_recovery.php">
            Clicca quì</a> per resettare la password.</p>';
    } else {
        $row = $results->fetch_assoc();
        $expDate = $row['expDate'];
        if ($expDate >= $curDate) {
            ?>
            <div class="m-auto" style="max-width:500px;">
                <form method="post" action="" name="update">
                    <input type="hidden" name="action" value="update" />
                    <br /><br />
                    <label class="form-label">Nuova password:</label><br />
                    <input class="form-control" type="password" name="pass1" maxlength="15" required />
                    <br /><br />
                    <label class="form-label">Re-inserisci nuova password:</label><br />
                    <input class="form-control"  type="password" name="pass2" maxlength="15" required />
                    <br /><br />
                    <input type="hidden" name="email" value="<?php echo $email; ?>" />
                    <input class="w-100 btn btn-primary mb-" type="submit" value="Reset Password" />
                </form>
            </div>
            <?php
        } else {
            $error .= "<h2>Link scaduto</h2>
            <p>Il link è scaduto. Stai cercando di utilizzare un link scaduto che è valido solo per 24 ore (1 giorno dopo la richiesta).</p>";
        }
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    }
} // isset email key validate end


if (
    isset($_POST["email"]) && isset($_POST["action"]) &&
    ($_POST["action"] == "update")
) {
    $error = "";
    $pass1 = mysqli_real_escape_string($con, $_POST["pass1"]);
    $pass2 = mysqli_real_escape_string($con, $_POST["pass2"]);
    $email = $_POST["email"];
    $curDate = date("Y-m-d H:i:s");
    if ($pass1 != $pass2) {
        $error .= "<p>Password do not match, both password should be same.<br /><br /></p>";
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div><br />";
    } else {
        $pass1 = md5($pass1);
        $stmt = $con->prepare("UPDATE `users` SET `password`=?, `trn_date`=? WHERE `email`=?");
        $stmt->bind_param("sss", $pass1, $curDate, $email);
        $stmt->execute();

        $stmt = $con->prepare("DELETE FROM `password_reset_temp` WHERE `email`=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt->close();

        echo '<div class="alert alert-success"><p>La password è stata cambiata con successo!</p>
                <p><a href="/login">
                Ora fai il Login</a></p></div><br />';
    }
}
?>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>