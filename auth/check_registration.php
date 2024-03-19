<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/router.php';
include_once('../includes/config.php');
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/PHPMailer/src/SMTP.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/functions.php');



if( ! is_csrf_valid() ){
    header('Location: registrazione?msg=CSRF non valido');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	header('Location: /registrazione?msg=Email non valida!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    header('Location: /registrazione?msg=Password deve essere lunga tra 5 e 20 caratteri!');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    header('Location: /registrazione?msg=Username non valido!');

}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Could not get the data that should have been sent.
    header('Location: /registrazione?msg=Compila tutti i campi!');
}
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
        header('Location: /registrazione?msg=Username esiste già, scegline un altro!');
	} else {
		// Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO users (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
            $stmt->execute();
            //echo 'Registrazione effettuata con successo! Ora puoi fare il login!';
            $activate_link = $SITEURL.'/auth/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;

            // Send an email to the user with the activation link using PHPMAILER
            $output = '<p>Prego cliccare sul seguente link per attivare il tuo account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';

            $email_to = $_POST['email'];
        
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
            $mail->Sender = $MAILFROM; // indicates ReturnPath header
            $mail->Subject = 'Attivazione account richiesta';
            $mail->Body = $output;
            $mail->AddAddress($email_to);
            if (!$mail->Send()) {
                echo "Errore mailer: " . $mail->ErrorInfo;
            } else {
                header('Location: /registrazione?msg=È stata inviata un\'email al tuo indirizzo di posta, visita il link per attivare il tuo account!');
                
            }
           /* $subject = 'Attivazione account richiesta';
            $headers = 'From: ' . $MAILFROM . "\r\n" . 'Reply-To: ' . $MAILFROM . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
            // Update the activation variable below
            $activate_link = $SITEURL.'/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            $message = '<p>Prego cliccare sul seguente link per attivare il tuo account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
            mail($_POST['email'], $subject, $message, $headers);*/
            
        } else {
            // Something is wrong with the SQL statement, so you must check to make sure your users table exists with all three fields.
            header('Location: /registrazione?msg=Errore nella registrazione!');
        }
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your users table exists with all 3 fields.
	header('Location: /registrazione?msg=Errore nella registrazione!');
}
$con->close();
?>