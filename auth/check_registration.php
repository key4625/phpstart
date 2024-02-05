<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/functions.php');

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

            // Send an email to the user with the activation link
            $subject = 'Attivazione account richiesta';
            $headers = 'From: ' . $mailFrom . "\r\n" . 'Reply-To: ' . $mailFrom . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
            // Update the activation variable below
            $activate_link = $urlSito.'/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
            $message = '<p>Prego cliccare sul seguente link per attivare il tuo account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
            mail($_POST['email'], $subject, $message, $headers);
            header('Location: /login?msg=Prego controllare la tua email per attivare il tuo account!');
            //echo 'Prego controllare la tua email per attivare il tuo account!';
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