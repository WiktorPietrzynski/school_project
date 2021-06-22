<?php
session_start();
if (isset($_SESSION['user_email'])) {
	header('location: ../index.php');
	exit();
}

if (!isset($_POST['email_register'])) {
	header('location: ../index.php');
	exit();
} else {
	$email = $_POST['email_register'];
	$password = $_POST['password_register'];
	$password_repeat = $_POST['password_repeat_register'];

	$_SESSION['form_email_register'] = $email;
	$_SESSION['form_password_register'] = $password;
	$_SESSION['form_password_repeat_register'] = $password_repeat;
}
require_once "validations.php";
validate_email($email, "email_register");
validate_password($password, "password_register");
validate_password($password_repeat, "password_repeat_register");
validate_similar($password_repeat, [$password], "password_repeat_register");
validate_form("index.php");


$password_hash = password_hash($password, PASSWORD_DEFAULT);
require_once "connect.php";
$stmt = $connection->prepare("SELECT * FROM users WHERE user_email=?");
$stmt->bind_param('s', $email);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count_email = $result->num_rows;
	if ($count_email > 0) {
		$_SESSION['form_valid_info'] = "Konto z podanym e-mail'em już istnieje.";
		header("location: ../index.php");
	} else {
		$stmt = $connection->prepare("INSERT INTO users VALUES (NULL, ?, ?, NULL, NULL)");
		$stmt->bind_param('ss', $email, $password_hash);
		if ($stmt->execute()) {
			unset($_SESSION['form_email_register']);
			unset($_SESSION['form_password_register']);
			unset($_SESSION['form_password_repeat_register']);
			$_SESSION['form_success_info'] = "Udana rejestracja. Teraz możesz się zalogować.";
			header('location: ../index.php');
		} else {
			$_SESSION['form_valid_info'] = "Błąd rejestracji. Spróbuj ponownie później.";
			header("location: ../index.php");
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd rejestracji. Spróbuj ponownie później.";
	header("location: ../index.php");
}
$connection->close();
