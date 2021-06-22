<?php
session_start();
if (isset($_POST['name'])) {
	$name = $_POST['name'];
	require_once("connect.php");
	$question = $connection->prepare("SELECT * FROM branches WHERE branch_name=? and branch_user_id=?");
	$question->bind_param('si', $name, $_SESSION['user_id']);
	$question->execute();
	$result = $question->get_result();
	$num_row = $result->num_rows;
	if ($num_row > 1) {
		echo "<p style='color:red;'>Wystąpił błąd. Spróbuj ponownie później.</p>";
	} else {
		$branch = $result->fetch_assoc();
		$branch_id = $branch['branch_id'];
		$branch_name = $branch['branch_name'];
		$nip = $branch['branch_nip'];
		$postal_code = $branch['branch_postal_code'];
		$city = $branch['branch_city'];
		$address = $branch['branch_address'];
		$apartment = $branch['branch_apartment'];
		$email = $branch['branch_email'];
		$tel = $branch['branch_tel'];
		echo "<article class='article article--branches' id='$branch_id'>";
		echo "<header class='article__header'>";
		echo "<h2>Oddział: $branch_name</h2>";
		echo "<h3>Nip: $nip</h3>";
		echo "</header>";
		echo "<div class='article__content'>";
		echo "<p>";
		if ($apartment == "") {
			echo "<b>Adres:</b> $postal_code, $city, $address";
		} else {
			echo "<b>Adres:</b> $postal_code, $city, $address, $apartment";
		}
		echo "</p>";
		echo "<p>";
		echo "<b>E-mail:</b> $email";
		echo "<br>";
		echo "<b>Nr. telefonu:</b> $tel";
		echo "</p>";
		echo "</div>";
		echo "<div class='article__buttons'>";
		echo "<div class='article__button button--update'>";
		echo "<i class='article__icon fas fa-edit fa-2x'></i>";
		echo "</div>";
		echo "<div class='article__button button--delete'>";
		echo "<i class='article__icon fas fa-trash-alt fa-2x'></i>";
		echo "</div>";
		echo "</div>";
		echo "</article>";
		echo '<script src="js/article_buttons.js"></script>';
	}
	$connection->close();
}
