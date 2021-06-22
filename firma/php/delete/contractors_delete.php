<?php
session_start();
if (!isset($_SESSION['user_email'])) {
  header("Location: ../../index.php");
  exit();
}
if (!isset($_GET["id"])) {
  header('location: ../../contractorers.php');
  exit();
} else {
  $id = $_GET["id"];
  require_once "../connect.php";
  $question = $connection->prepare("UPDATE contractors SET contractor_status = 0 WHERE contractor_id = ? and contractor_user_id=?");
  $question->bind_param('ii', $id, $_SESSION['user_id']);
  if ($question->execute()) {
    $_SESSION['form_success_info'] = "Pomyślnie usunięto wybranego kontrahenta.";
    header('location: ../../contractors.php');
  } else {
    $_SESSION['form_valid_info'] = "Nie usunięto wybranego kontrahenta.";
    header('location: ../../contractors.php');
  }

  $connection->close();
}
