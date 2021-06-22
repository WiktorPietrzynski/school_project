<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_POST['first_name'])) {
	header('location: ../../worker_creator.php');
	exit();
} else {
	$user_id = $_SESSION['user_id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$pesel = $_POST['pesel'];
	$postal_code = $_POST['postal_code'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$apartment = $_POST['apartment'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];
	$branch = $_POST['branch'];

	$_SESSION['form_first_name'] = $first_name;
	$_SESSION['form_last_name'] = $last_name;
	$_SESSION['form_pesel'] = $pesel;
	$_SESSION['form_postal_code'] = $postal_code;
	$_SESSION['form_city'] = $city;
	$_SESSION['form_address'] = $address;
	$_SESSION['form_apartment'] = $apartment;
	$_SESSION['form_tel'] = $tel;
	$_SESSION['form_email'] = $email;
	$_SESSION['form_branch'] = $branch;
}
require_once "../validations.php";
validate_name($first_name, "first_name");
validate_name($last_name, "last_name");
validate_number($pesel, "pesel", 11);
validate_postal_code($postal_code, "postal_code");
validate_space_name($city, "city");
validate_address($address, "address");
if ($apartment != "") {
	validate_apartment($apartment, "apartment");
}
validate_number($tel, "tel", 9);
validate_email($email, "email");
validate_value_min($branch, "branch", 1);

validate_form("../worker_creator.php");


require_once "../connect.php";
$stmt = $connection->prepare("SELECT * FROM workers WHERE worker_pesel=?");
$stmt->bind_param('s', $pesel);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count = $result->num_rows;
	if ($count > 0) {
		$_SESSION['form_valid_info'] = "Pracownik z podanym nr. pesel jest już zapisany.";
		header("location: ../../worker_creator.php");
	} else {
		$stmt = $connection->prepare("INSERT INTO workers VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssii', $first_name, $last_name, $pesel, $postal_code, $city, $address, $apartment, $tel, $email, $branch, $user_id);
		if ($stmt->execute()) {
			unset($_SESSION['form_first_name']);
			unset($_SESSION['form_last_name']);
			unset($_SESSION['form_pesel']);
			unset($_SESSION['form_postal_code']);
			unset($_SESSION['form_city']);
			unset($_SESSION['form_address']);
			unset($_SESSION['form_apartment']);
			unset($_SESSION['form_tel']);
			unset($_SESSION['form_email']);
			unset($_SESSION['form_branch']);
			$_SESSION['form_success_info'] = "Dodano nowego pracownika.";
			header('location: ../../worker_creator.php');
		} else {
			$_SESSION['form_valid_info'] = "Błąd dodawania pracownika. Spróbuj ponownie później.";
			header("location: ../../worker_creator.php");
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd dodawania pracownika. Spróbuj ponownie później.";
	header("location: ../../worker_creator.php");
}
$connection->close();
