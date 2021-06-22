<div id="form_valid_info" class="form__message">
	<?php
	if (isset($_SESSION['form_valid_info'])) {
		echo "<p class='form__message--red'>" . $_SESSION['form_valid_info'] . "</p>";
		unset($_SESSION["form_valid_info"]);
	}
	if (isset($_SESSION['form_success_info'])) {
		echo "<p class='form__message--green'>" . $_SESSION['form_success_info'] . "</p>";
		unset($_SESSION["form_success_info"]);
	}
	?>
</div>