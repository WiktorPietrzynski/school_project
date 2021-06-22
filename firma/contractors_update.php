<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: contractors.php");
    exit();
}

require_once "php/connect.php";
$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_id=? and contractor_user_id = ?;");
$stmt->bind_param('ii', $_GET['id'], $_SESSION['user_id']);
$stmt->execute();
$contractor = $stmt->get_result();
$count = $contractor->num_rows;
if ($count == 0) {
    echo "0";
    header("location: contractors.php");
}
$contractor = $contractor->fetch_assoc();
$connection->close();
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Edycja kontrahenta.</h1>
        </header>
        <div class="section__content section__content--column">
            <?php require_once "include/form_message.php" ?>
            <form class="form--double" action="php/update/contractor_updating.php?id=<?php echo $_GET['id'] ?>" method="post">
                <div class="form__row">
                    <label class="form__label" for="first_name">Imię
                        <input class="form__input" type="text" name="first_name" value="<?php if (isset($_SESSION['form_first_name'])) {
                                                                                            echo $_SESSION['form_first_name'];
                                                                                            unset($_SESSION['form_first_name']);
                                                                                        } else {
                                                                                            echo $contractor['contractor_first_name'];
                                                                                        } ?>" /></label>
                    <label class="form__label" for="last_name">Nazwisko
                        <input class="form__input" type="text" name="last_name" value="<?php if (isset($_SESSION['form_last_name'])) {
                                                                                            echo $_SESSION['form_last_name'];
                                                                                            unset($_SESSION['form_last_name']);
                                                                                        } else {
                                                                                            echo $contractor['contractor_last_name'];
                                                                                        } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="pesel">Nr. pesel
                        <input class="form__input" type="text" name="pesel" maxlength="11" value="<?php if (isset($_SESSION['form_pesel'])) {
                                                                                                        echo $_SESSION['form_pesel'];
                                                                                                        unset($_SESSION['form_pesel']);
                                                                                                    } else {
                                                                                                        echo $contractor['contractor_pesel'];
                                                                                                    }  ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="postal_code">Kod pocztowy
                        <input class="form__input" type="text" name="postal_code" maxlength="6" value="<?php if (isset($_SESSION['form_postal_code'])) {
                                                                                                            echo $_SESSION['form_postal_code'];
                                                                                                            unset($_SESSION['form_postal_code']);
                                                                                                        } else {
                                                                                                            echo $contractor['contractor_postal_code'];
                                                                                                        } ?>" /></label>
                    <label class="form__label" for="city">Miasto
                        <input class="form__input" type="text" name="city" value="<?php if (isset($_SESSION['form_city'])) {
                                                                                        echo $_SESSION['form_city'];
                                                                                        unset($_SESSION['form_city']);
                                                                                    } else {
                                                                                        echo $contractor['contractor_city'];
                                                                                    }
                                                                                    ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="address">Ulica i nr. budynku
                        <input class="form__input" type="text" name="address" value="<?php if (isset($_SESSION['form_address'])) {
                                                                                            echo $_SESSION['form_address'];
                                                                                            unset($_SESSION['form_address']);
                                                                                        } else {
                                                                                            echo $contractor['contractor_address'];
                                                                                        } ?>" /></label>
                    <label class="form__label" for="apartment">Nr. mieszkania
                        <input class="form__input" type="text" name="apartment" value="<?php if (isset($_SESSION['form_apartment'])) {
                                                                                            echo $_SESSION['form_apartment'];
                                                                                            unset($_SESSION['form_apartment']);
                                                                                        } else {
                                                                                            echo $contractor['contractor_apartment'];
                                                                                        } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="tel">Telefon
                        <input class="form__input" type="text" name="tel" maxlength="9" value="<?php if (isset($_SESSION['form_tel'])) {
                                                                                                    echo $_SESSION['form_tel'];
                                                                                                    unset($_SESSION['form_tel']);
                                                                                                } else {
                                                                                                    echo $contractor['contractor_tel'];
                                                                                                } ?>" /></label>
                    <label class="form__label" for="email">E-mail
                        <input class="form__input" type="text" name="email" value="<?php if (isset($_SESSION['form_email'])) {
                                                                                        echo $_SESSION['form_email'];
                                                                                        unset($_SESSION['form_email']);
                                                                                    } else {
                                                                                        echo $contractor['contractor_email'];
                                                                                    } ?>" /></label>
                </div>
                <button class="form__submit" type="submit">Edytuj</button>
            </form>
        </div>

    </section>
</main>
<?php
require_once "include/footer.php";
?>