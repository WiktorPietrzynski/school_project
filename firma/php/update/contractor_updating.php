<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_GET['id'])) {
	header("Location: ../../contractors.php");
	exit();
}

if (!isset($_POST['first_name'])) {
	header('location: ../../contractors_update.php?id=' . $_GET['id']);
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

validate_form("../contractors_update.php?id=" . $_GET['id']);


require_once "../connect.php";
$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_id=? and contractor_user_id = ?;");
$stmt->bind_param('ii', $_GET['id'], $_SESSION['user_id']);
$stmt->execute();
$contractor = $stmt->get_result();
$contractor = $contractor->fetch_assoc();
$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_pesel=? and contractor_pesel!=? and contractor_user_id=? and contractor_status=1");
$stmt->bind_param('ssi', $pesel, $contractor['contractor_pesel'], $_SESSION['user_id']);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count = $result->num_rows;
	if ($count > 0) {
		$_SESSION['form_valid_info'] = "Kontrahent z podanym nr. pesel jest już zapisany.";
		header("location: ../../contractors_update.php?id=" . $_GET['id']);
	} else {
		$stmt = $connection->prepare("UPDATE contractors SET contractor_first_name = ?, contractor_last_name=? , contractor_pesel=?, contractor_postal_code=?, contractor_city=?, contractor_address=?, contractor_apartment=?, contractor_tel=?, contractor_email=? WHERE contractor_id=?;");
		$stmt->bind_param('sssssssssi', $first_name, $last_name, $pesel, $postal_code, $city, $address, $apartment, $tel, $email, $_GET['id']);
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
			$_SESSION['form_success_info'] = "Pomyślnie edytowano kontrahenta.";
			header('location: ../../contractors_update.php?id=' . $_GET['id']);
		} else {
			$_SESSION['form_valid_info'] = "Błąd edycji kontrahenta. Spróbuj ponownie później.";
			header("location: ../../contractors_update.php?id=" . $_GET['id']);
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd edycji kontrahenta. Spróbuj ponownie później.";
	header("location: ../../contractors_update.php?id=" . $_GET['id']);
}
$connection->close();
