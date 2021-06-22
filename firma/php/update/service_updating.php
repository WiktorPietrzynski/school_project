<?php
session_start();
if (!isset($_SESSION['user_email'])) {
	header('location: ../../index.php');
	exit();
}

if (!isset($_GET['id'])) {
	header("Location: ../../services.php");
	exit();
}

if (!isset($_POST['service_name'])) {
	header('location: ../../services_update.php?id=' . $_GET['id']);
	exit();
} else {
	$user_id = $_SESSION['user_id'];
	$service_name = $_POST['service_name'];
	$price = $_POST['price'];
	$date = $_POST['date'];
	$worker = $_POST['worker'];
	$contractor = $_POST['contractor'];

	$_SESSION['form_service_name'] = $service_name;
	$_SESSION['form_price'] = $price;
	$_SESSION['form_date'] = $date;
	$_SESSION['form_worker'] = $worker;
	$_SESSION['form_contractor'] = $contractor;
}
require_once "../validations.php";
validate_space_name($service_name, "service_name");
validate_value_min($price, "price", 0.01);
validate_date($date, "date");
validate_value_min($worker, "worker", 1);
validate_value_min($contractor, "contractor", 0);
validate_form("../services_update.php");
if ($contractor != "0") {
	$contractor_id = $contractor;
	require_once "../connect.php";
} else {
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

	validate_form("../services_update.php?id=" . $_GET['id']);

	require_once "../connect.php";
	$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_pesel=?");
	$stmt->bind_param('s', $pesel);
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		$count = $result->num_rows;
		if ($count > 0) {
			$_SESSION['form_valid_info'] = "Kontrahent z podanym nr. pesel jest już zapisany.";
			header("location: ../../services_update.php?id=" . $_GET['id']);
			$connection->close();
			exit();
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
				$last_id = mysqli_insert_id($connection);
				$contractor_id = $last_id;
			} else {
				$_SESSION['form_valid_info'] = "Błąd dodawania kontrahenta. Spróbuj ponownie później.";
				header("location: ../../services_update.php?id=" . $_GET['id']);
				$connection->close();
				exit();
			}
		}
	} else {
		$_SESSION['form_valid_info'] = "Błąd dodawania kontrahenta. Spróbuj ponownie później.";
		header("location: ../../services_update.php?id=" . $_GET['id']);
		$connection->close();
		exit();
	}
}
$stmt = $connection->prepare("UPDATE services SET service_name = ?, service_price = ?, service_date=?, service_worker=?, service_contractor=? WHERE service_id=? ");
$stmt->bind_param('sssiii', $service_name, $price, $date, $worker, $contractor_id, $_GET['id']);
if ($stmt->execute()) {
	unset($_SESSION['form_service_name']);
	unset($_SESSION['form_price']);
	unset($_SESSION['form_date']);
	unset($_SESSION['form_worker']);
	unset($_SESSION['form_contractor']);
	$_SESSION['form_success_info'] = "Edytowano usługę.";
	header('location: ../../services_update.php?id=' . $_GET['id']);
} else {
	$_SESSION['form_valid_info'] = "Błąd edytowania usługi. Spróbuj ponownie później.";
	header("location: ../../services_update.php?id=" . $_GET['id']);
}
$connection->close();
