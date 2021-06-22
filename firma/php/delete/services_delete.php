<?php
session_start();
if (!isset($_SESSION['user_email'])) {
  header("Location: ../../index.php");
  exit();
}
if (!isset($_GET["id"])) {
  header('location: ../../services.php');
  exit();
} else {
  $id = $_GET["id"];
  require_once "../connect.php";
  $question = $connection->prepare("DELETE s FROM services AS s INNER JOIN contractors as c ON s.service_contractor = c.contractor_id WHERE service_id = ? and contractor_user_id=?");
  $question->bind_param('ii', $id, $_SESSION['user_id']);
  if ($question->execute()) {
    $_SESSION['form_success_info'] = "Pomyślnie usunięto wybraną usługę.";
    header('location: ../../services.php');
  } else {
    $_SESSION['form_valid_info'] = "Nie usunięto wybranej usługi.";
    header('location: ../../services.php');
  }

  $connection->close();
}
