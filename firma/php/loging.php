<?php
session_start();
if (isset($_SESSION['user_email'])) {
    header('location: ../index.php');
    exit();
}
$_SESSION['form_login'] = true;
if ((!isset($_POST['email_login'])) || (!isset($_POST['password_login']))) {
    header('location: ../index.php');
    exit();
} else {
    $email = $_POST['email_login'];
    $password = $_POST['password_login'];
    $_SESSION['form_email_login'] = $email;
    $_SESSION['form_password_login'] = $password;
}
require_once "validations.php";
validate_email($email, "email_login");
validate_password($password, "password_login");
validate_form("index.php");

require_once "connect.php";
$stmt = $connection->prepare("SELECT * FROM users WHERE user_email=?");
$stmt->bind_param('s', $email);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $count_email = $result->num_rows;
    if ($count_email == 0) {
        $_SESSION['form_valid_info'] = "Nieprawidłowy e-mail lub hasło.";
        header("location: ../index.php");
    } else {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['user_password'])) {
            //if($password==$user["user_password"]){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['user_password'] = $user['user_password'];
            $_SESSION["user_company_name"] = $user["user_company_name"];
            $_SESSION["user_nip"] = $user["user_nip"];

            $result->free_result();
            unset($_SESSION['form_email_login']);
            unset($_SESSION['form_password_login']);
            header("location:../index.php");
        } else {
            $_SESSION['form_valid_info'] = "Nieprawidłowy e-mail lub hasło.";
            header('Location: ../index.php');
        }
    }
} else {
    $_SESSION['form_valid_info'] = "Błąd logowania. Spróbuj ponownie później.";
    header("location: ../index.php");
}
$connection->close();
