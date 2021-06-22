<?php
$host = "localhost";
$db_user = "root";
$db_pswd = "";
$db_name = "firma";
$connection = @new mysqli($host, $db_user, $db_pswd, $db_name) or die("Brak połączenia z serwerem");
$connection->set_charset("utf8");
