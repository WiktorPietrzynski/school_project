<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header('location: ../index.php');
    exit();
}

if ((!isset($_POST['company_name'])) || (!isset($_POST['nip']))) {
    header('location: ../company_editor.php');
    exit();
} else {
    $company_name = $_POST['company_name'];
    $nip = $_POST['nip'];
    $_SESSION['form_company_name'] = $company_name;
    $_SESSION['form_nip'] = $nip;
}
require_once "validations.php";
validate_space_name($company_name, "company_name");
validate_number($nip, "nip", 10);
validate_form("company_editor.php");

require_once "connect.php";
$stmt = $connection->prepare("SELECT * FROM users WHERE user_nip=? and user_nip!=?");
$stmt->bind_param('ss', $nip, $SESSION['user_nip']);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $count_name = $result->num_rows;
    if ($count_name > 0) {
        $_SESSION['form_valid_info'] .= "Podany numer NIP jest już zajęty.<br>";
        header("location: ../company_editor.php");
    } else {
        $stmt = $connection->prepare("UPDATE users SET user_company_name = ?, user_nip=? WHERE user_id=? ;");
        $stmt->bind_param('ssi', $company_name, $nip, $_SESSION['user_id']);
        if ($stmt->execute()) {
            unset($_SESSION["form_company_name"]);
            unset($_SESSION["form_nip"]);
            $_SESSION['user_company_name'] = $company_name;
            $_SESSION['user_nip'] = $nip;
            $_SESSION["form_success_info"] = "Pomyślnie zaktualizowano dane kontrachenta.";
            header('location: ../company_editor.php');
        } else {
            $_SESSION['form_valid_info'] .= "Błąd aktualizacji danych. Spróbuj ponownie później.";
            header("location: ../company_editor.php");
        }
    }
} else {
    $_SESSION['form_valid_info'] .= "Błąd aktualizacji danych. Spróbuj ponownie później.";
    header("location: ../company_editor.php");
}
$connection->close();
