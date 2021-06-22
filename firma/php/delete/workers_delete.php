<?php
session_start();
if (!isset($_SESSION['user_email'])) {
  header("Location: ../../index.php");
  exit();
}
if (!isset($_GET["id"])) {
  header('location: ../../workers.php');
  exit();
} else {
  $id = $_GET["id"];
  require_once "../connect.php";
  $question = $connection->prepare("UPDATE workers SET worker_branch = NULL WHERE worker_id = ? and worker_user_id=?");
  $question->bind_param('ii', $id, $_SESSION['user_id']);
  if ($question->execute()) {
    $_SESSION['form_success_info'] = "Pomyślnie usunięto wybranego pracownika.";
    header('location: ../../workers.php');
  } else {
    $_SESSION['form_valid_info'] = "Nie usunięto wybranego pracownika.";
    header('location: ../../workers.php');
  }

  $connection->close();
}
