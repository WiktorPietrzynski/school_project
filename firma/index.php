<?php
session_start();
if (isset($_SESSION['user_email'])) {
    header("Location: company.php");
    exit();
}
?>
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
    <style>
        .index-box__buttons {
            display: flex;
            justify-content: space-between;
        }

        .index-box {
            width: 250px;
            height: auto;
        }

        .index-box__forms {
            display: flex;
        }
    </style>

    <main class="main">
        <section class="section">
            <header class="section__header">
                <h1 class="section__title title--big">Zarządzaj swoją firmą w jednym miejscu.</h1>
            </header>
            <div class="section__content">
                <picture class="picture">
                    <img class="picture__img float" src="assets/images/desktop.png" />
                </picture>
                <div class="wrapper--index">
                    <div class="buttons">
                        <button class="button" id="button_register">Rejestracja</button>
                        <button class="button" id="button_login">Logowanie</button>
                    </div>
                    <div class="forms" id="forms">
                        <form class="form" id="form_register" action="php/registration.php" method="post">
                            <label class="form__label" for="email_register">E-mail</label>
                            <input class="form__input" value="<?php if (isset($_SESSION['form_email_register'])) {
                                                                    echo $_SESSION['form_email_register'];
                                                                    unset($_SESSION['form_email_register']);
                                                                } ?>" type="email" name="email_register" />
                            <label class="form__label" for="password_register">Hasło</label>
                            <input class="form__input" value="<?php if (isset($_SESSION['form_password_register'])) {
                                                                    echo $_SESSION['form_password_register'];
                                                                    unset($_SESSION['form_password_register']);
                                                                } ?>" type="password" name="password_register" />
                            <label class="form__label" for="password_repeat_register">Powtórz hasło</label>
                            <input class="form__input" value="<?php if (isset($_SESSION['form_password_repeat_register'])) {
                                                                    echo $_SESSION['form_password_repeat_register'];
                                                                    unset($_SESSION['form_password_repeat_register']);
                                                                } ?>" type="password" name="password_repeat_register" />
                            <button class="form__submit" type="submit">Zarejestruj się</button>

                        </form>
                        <form class="form" id="form_login" action="php/loging.php" method="post">
                            <label class="form__label" for="email_login">E-mail</label>
                            <input class="form__input" value="<?php if (isset($_SESSION['form_email_login'])) {
                                                                    echo $_SESSION['form_email_login'];
                                                                    unset($_SESSION['form_email_login']);
                                                                } ?>" type="email" name="email_login" />
                            <label class="form__label" for="password_login">Hasło</label>
                            <input class="form__input" value="<?php if (isset($_SESSION['form_password_login'])) {
                                                                    echo $_SESSION['form_password_login'];
                                                                    unset($_SESSION['form_password_login']);
                                                                } ?>" type="password" name="password_login" />
                            <button class="form__submit" type="submit">Zaloguj się</button>

                        </form>
                    </div>
                    <?php require_once "include/form_message.php" ?>
                </div>
            </div>

        </section>
    </main>
    <script>
        const button_register = document.querySelector("#button_register");
        const button_login = document.querySelector("#button_login");
        const forms = document.querySelector("#forms");

        button_register.onclick = show_register;
        button_login.onclick = show_login;

        function show_register() {
            forms.style.transform = "translate(0px,0px)";
            button_register.classList.add("button--clicked");
            button_login.classList.remove("button--clicked");
        }

        function show_login() {
            forms.style.transform = "translate(-50%,0px)";
            button_login.classList.add("button--clicked");
            button_register.classList.remove("button--clicked");
        }
    </script>
    <?php
    echo "<script>";
    if (isset($_SESSION['form_login'])) {
        echo "show_login();";
    } else {
        echo "show_register();";
    }
    echo "</script>";
    unset($_SESSION['form_login']);
    ?>
    <?php
    require_once "include/footer.php";


    ?>