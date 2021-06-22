<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_GET['id'])) {
	header("Location: ../../branches.php");
	exit();
}

if (!isset($_POST['branch_name'])) {
	header('location: ../../branches_update.php?id=' . $_GET['id']);
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

validate_form("../branches_update.php?id=" . $_GET['id']);


require_once "../connect.php";
$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_id = ? and branch_user_id = ?;");
$stmt->bind_param('ii', $_GET['id'], $_SESSION['user_id']);
$stmt->execute();
$branch = $stmt->get_result();
$branch = $branch->fetch_assoc();

$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_name=? and branch_name!=? and branch_user_id=?");
$stmt->bind_param('ssi', $branch_name, $branch['branch_name'], $user_id);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$count_email = $result->num_rows;
	if ($count_email > 0) {
		$_SESSION['form_valid_info'] = "Oddział z podaną nazwą już istnieje.";
		header("location: ../../branches_update.php?id=" . $_GET['id']);
	} else {
		$stmt = $connection->prepare("UPDATE branches SET branch_name = ?, branch_nip=?, branch_postal_code=?, branch_city=?, branch_address=?, branch_apartment=?, branch_tel=?, branch_email=? WHERE branch_id=?;");
		$stmt->bind_param('ssssssssi', $branch_name, $nip, $postal_code, $city, $address, $apartment, $tel, $email, $_GET['id']);
		if ($stmt->execute()) {
			unset($_SESSION['form_branch_name']);
			unset($_SESSION['form_nip']);
			unset($_SESSION['form_postal_code']);
			unset($_SESSION['form_city']);
			unset($_SESSION['form_address']);
			unset($_SESSION['form_apartment']);
			unset($_SESSION['form_tel']);
			unset($_SESSION['form_email']);
			$_SESSION['form_success_info'] = "Pomyślnie edytowano oddział.";
			header('location: ../../branches_update.php?id=' . $_GET['id']);
		} else {
			$_SESSION['form_valid_info'] = "Błąd edycji oddziału. Spróbuj ponownie później.";
			header("location: ../../branches_update.php?id=" . $_GET['id']);
		}
	}
} else {
	$_SESSION['form_valid_info'] = "Błąd edycji oddziału. Spróbuj ponownie później.";
	header("location: ../../branches_update.php?id=" . $_GET['id']);
}
$connection->close();
