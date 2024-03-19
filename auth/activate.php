<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/router.php';
include_once('../includes/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions/functions.php');

if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $con->prepare('SELECT * FROM users WHERE email = ? AND activation_code = ?')) {
		$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
		$stmt->execute();
		// Store the result so we can check if the account exists in the database.
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			// Account exists with the requested email and code.
			if ($stmt = $con->prepare('UPDATE users SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
				// Set the new activation code to 'activated', this is how we can check if the user has activated their account.
				$newcode = 'activated';
				$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
				$stmt->execute();
				header('Location: /login?msg=Il tuo account è stato attivato! Ora puoi fare il login!');
				//exit;
			}
		} else {
			header('Location: /login?err=1&&msg=Il tuo account è già attivato o non esiste!');
		}
	}
}
?>