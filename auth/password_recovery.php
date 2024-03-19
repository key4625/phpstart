<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once $_SERVER['DOCUMENT_ROOT'].'/router.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/SMTP.php';

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
    // form per l'autenticazione
    if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $error ="";
        if (!$email) {
            $error .= "<p>Indirizzo email non valido!</p>";
        } else {
            $stmt = $con->prepare("SELECT * FROM `users` WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $results = $stmt->get_result();
            $row = $results->num_rows;
            $stmt->close();
            if($row == 0) {
                $error .= "<p>Non esiste un account con questo indirizzo email!</p>";
            }
        }
        if ($error != "") {
            echo "<div class='alert alert-danger'>" . $error . "</div><br /><a href='javascript:history.go(-1)'>Torna Indietro</a>";
        } else {
            $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
            $expDate = date("Y-m-d H:i:s", $expFormat);
            //$key = md5(2418 * 2 + $email);
            //$addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
            //$key = $key . $addKey;
            $key = getRandomString(97);
            // Insert Temp Table

            $stmt = $con->prepare("INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $key, $expDate);
            $stmt->execute();
            $stmt->close();

            /* Send the email */
            $output = '<p>Gentile utente,</p>';
            $output .= '<p>Fare clic sul seguente link per reimpostare la tua password.</p>';
            $output .= '<p>-------------------------------------------------------------</p>';
            $output .= '<p><a href="'.$SITEURL.'/auth/check_pass_recovery.php?key='.$key.'&email='.$email.'&action=reset" target="_blank">
            '.$SITEURL.'/auth/check_pass_recovery.php?key='.$key.'&email='.$email.'&action=reset</a></p>';
            $output .= '<p>-------------------------------------------------------------</p>';
            $output .= '<p>Assicurati di copiare l\'intero link nel tuo browser.
            Il link scadrà dopo 1 giorno per motivi di sicurezza.</p>';
            $output .= '<p>Se non hai richiesto questa email di password dimenticata, non è necessaria alcuna azione.
            La tua password non verrà reimpostata. Tuttavia, potresti voler accedere al tuo account e cambiare la tua password di sicurezza poiché qualcuno potrebbe averla indovinata.</p>';
            $output .= '<p>Grazie,</p>';
            $output .= '<p>Il Team</p>';
           
         

            $email_to = $email;
        
            $mail = new PHPMailer();
            $mail->SMTPDebug = 0;  
            $mail->IsSMTP();
            $mail->SMTPAuth = true;                // enable SMTP authentication
            //$mail->SMTPSecure = "tls"; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Host = $MAILHOST; // Enter your host here
            $mail->Username = $MAILUSER ; // Enter your email here
            $mail->Password = $MAILPASS; //Enter your password here
            $mail->Port = $MAILPORT;
            $mail->IsHTML(true);
            $mail->From = $MAILFROM ;
            $mail->FromName = $MAILFROMNAME;
            $mail->Sender = $$MAILFROM; // indicates ReturnPath header
            $mail->Subject = "Recupero Password - ".$SITENAME;
            $mail->Body = $output;
            $mail->AddAddress($email_to);
            if (!$mail->Send()) {
                echo "Errore mailer: " . $mail->ErrorInfo;
            } else {
                echo "<div class='alert alert-danger'>È stata inviata un'email con istruzioni su come reimpostare la tua password. Controlla la tua casella di posta!</div>";
            }
            /* End of sending email */
        }
    } else {
    ?>
    <div class="m-auto" style="max-width:500px;">
        <form method="post" action="" name="reset"><br /><br />
            <div class="mb-4">
                <label class="form-label">Inserisci il tuo indirizzo email:</label>
                <input class="form-control" type="email" name="email" placeholder="username@email.com" />
            </div>
            <input class="w-100 btn btn-primary mb-4" type="submit" value="Reset Password" />
        </form>
    </div>
</div>
<?php } 
?>


<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>