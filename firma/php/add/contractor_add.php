<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_POST['first_name'])) {
	header('location: ../../contractor_creator.php');
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

	$_SESSION['form_first_name'] = $first_name;
	$_SESSION['form_last_name'] = $last_name;
	$_SESSION['form_pesel'] = $pesel;
	$_SESSION['form_postal_code'] = $postal_code;
	$_SESSION['form_city'] = $city;
	$_SESSION['form_address'] = $address;
	$_SESSION['form_apartment'] = $apartment;
	$_SESSION['form_tel'] = $tel;
	$_SESSION['form_email'] = $email;
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

validate_form("../contractor_creator.php");


require_once "../connect.php";
$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_pesel=? and contractor_user_id=? and contractor_status=1");
$stmt->bind_param('si', $pesel, $_SESSION['user_id']);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count = $result->num_rows;
	if ($count > 0) {
		$_SESSION['form_valid_info'] = "Kontrahent z podanym nr. pesel jest już zapisany.";
		header("location: ../../contractor_creator.php");
	} else {
		$stmt = $connection->prepare("INSERT INTO contractors VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
		$stmt->bind_param('sssssssssi', $first_name, $last_name, $pesel, $postal_code, $city, $address, $apartment, $tel, $email, $user_id);
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
			$_SESSION['form_success_info'] = "Dodano nowego kontrahenta.";
			header('location: ../../contractor_creator.php');
		} else {
			$_SESSION['form_valid_info'] = "Błąd dodawania kontrahenta. Spróbuj ponownie później.";
			header("location: ../../contractor_creator.php");
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd dodawania kontrahenta. Spróbuj ponownie później.";
	header("location: ../../contractor_creator.php");
}
$connection->close();
