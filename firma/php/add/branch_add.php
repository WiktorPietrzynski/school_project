<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_POST['branch_name'])) {
	header('location: ../../branch_creator.php');
	exit();
} else {
	$user_id = $_SESSION['user_id'];
	$branch_name = $_POST['branch_name'];
	$nip = $_POST['nip'];
	$postal_code = $_POST['postal_code'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$apartment = $_POST['apartment'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];

	$_SESSION['form_branch_name'] = $branch_name;
	$_SESSION['form_nip'] = $nip;
	$_SESSION['form_postal_code'] = $postal_code;
	$_SESSION['form_city'] = $city;
	$_SESSION['form_address'] = $address;
	$_SESSION['form_apartment'] = $apartment;
	$_SESSION['form_tel'] = $tel;
	$_SESSION['form_email'] = $email;
}
require_once "../validations.php";
validate_space_name($branch_name, "branch_name");
validate_similar($nip, [$_SESSION['user_nip']], "nip");
validate_postal_code($postal_code, "postal_code");
validate_space_name($city, "city");
validate_address($address, "address");
if ($apartment != "") {
	validate_apartment($apartment, "apartment");
}
validate_number($tel, "tel", 9);
validate_email($email, "email");

validate_form("../branch_creator.php");


require_once "../connect.php";
$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_name=? and branch_user_id=?");
$stmt->bind_param('si', $branch_name, $user_id);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count_email = $result->num_rows;
	if ($count_email > 0) {
		$_SESSION['form_valid_info'] = "Oddział z podaną nazwą już istnieje.";
		header("location: ../../branch_creator.php");
	} else {
		$stmt = $connection->prepare("INSERT INTO branches VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssssi', $branch_name, $nip, $postal_code, $city, $address, $apartment, $tel, $email, $user_id);
		if ($stmt->execute()) {
			unset($_SESSION['form_branch_name']);
			unset($_SESSION['form_nip']);
			unset($_SESSION['form_postal_code']);
			unset($_SESSION['form_city']);
			unset($_SESSION['form_address']);
			unset($_SESSION['form_apartment']);
			unset($_SESSION['form_tel']);
			unset($_SESSION['form_email']);
			$_SESSION['form_success_info'] = "Dodano nowy oddział.";
			header('location: ../../branch_creator.php');
		} else {
			$_SESSION['form_valid_info'] = "Błąd dodawania oddziału. Spróbuj ponownie później.";
			header("location: ../../branch_creator.php");
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd dodawania oddziału. Spróbuj ponownie później.";
	header("location: ../../branch_creator.php");
}
$connection->close();
