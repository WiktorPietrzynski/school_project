<?php
session_start();
if (!isset($_SESSION['user_email'])) {
  header("Location: ../../index.php");
  exit();
}
if (!isset($_GET["id"])) {
  header('location: ../../branches.php');
  exit();
} else {
  $id = $_GET["id"];
  require_once "../connect.php";
  $question = $connection->prepare("DELETE FROM branches WHERE branch_id = ? and branch_user_id=?");
  $question->bind_param('ii', $id, $_SESSION['user_id']);
  if ($question->execute()) {
    $_SESSION['form_success_info'] = "Pomyślnie usunięto wybrany oddział.";
    header('location: ../../branches.php');
  } else {
    $_SESSION['form_valid_info'] = "Nie usunięto wybranego oddziału.";
    header('location: ../../branches.php');
  }

  $connection->close();
}
