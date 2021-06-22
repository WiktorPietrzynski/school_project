<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8_polish_ci">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/css/main.css">
	<script src="https://kit.fontawesome.com/2df3d8c086.js" crossorigin="anonymous"></script>
	<title>Firma.pl</title>
</head>

<body>
	<header class="header">
		<input type='checkbox' id='toggle' style='display:none;' />
		<label class='toggle-btn toggle-btn__cross' for='toggle'>
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</label>
		<nav class="nav">
			<ul class="nav__list">
				<li class="nav__item">
					<a class="nav__link nav__link--underline" href="company.php"><?php echo $_SESSION['user_company_name']; ?></a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="branches.php"><i class="nav__icon fas fa-building fa-lg"></i>Oddziały</a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="workers.php"><i class="nav__icon fas fa-users fa-lg"></i>Pracownicy</a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="contractors.php"><i class="nav__icon fas fa-address-book fa-lg"></i>Kontrahenci</a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="services.php"><i class="nav__icon fas fa-handshake fa-lg"></i>Usługi</a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="raports.php"><i class="nav__icon fas fa-file-contract fa-lg"></i>Raporty</a>
				</li>
				<li class="nav__item">
					<a class="nav__link" href="php/logout.php"><i class="nav__icon fas fa-sign-out-alt fa-lg"></i>Wyloguj się</a>
				</li>
			</ul>
		</nav>
	</header>