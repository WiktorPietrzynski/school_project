<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['id'])) {
    header("Location: branches.php");
    exit();
}
require_once "php/connect.php";
$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_id = ? and branch_user_id = ?;");
$stmt->bind_param('ii', $_GET['id'], $_SESSION['user_id']);
$stmt->execute();
$branch = $stmt->get_result();
$branch = $branch->fetch_assoc();
$connection->close();
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Edycja oddziału.</h1>
        </header>
        <div class="section__content section__content--column">
            <?php require_once "include/form_message.php" ?>
            <form class="form--double" action="php/update/branch_updating.php?id=<?php echo $_GET['id'] ?>" method="post">
                <div class="form__row">
                    <label class="form__label" for="branch_name">Nazwa oddziału
                        <input class="form__input" type="text" name="branch_name" value="<?php if (isset($_SESSION['form_branch_name'])) {
                                                                                                echo $_SESSION['form_branch_name'];
                                                                                                unset($_SESSION['form_branch_name']);
                                                                                            } else {
                                                                                                echo $branch['branch_name'];
                                                                                            } ?>" /></label>
                    <label class="form__label" for="nip">NIP
                        <input readonly class="form__input" type="text" name="nip" maxlength="10" value="<?php echo $_SESSION['user_nip']; ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="postal_code">Kod pocztowy
                        <input class="form__input" type="text" name="postal_code" maxlength="6" value="<?php if (isset($_SESSION['form_postal_code'])) {
                                                                                                            echo $_SESSION['form_postal_code'];
                                                                                                            unset($_SESSION['form_postal_code']);
                                                                                                        } else {
                                                                                                            echo $branch['branch_postal_code'];
                                                                                                        } ?>" /></label>
                    <label class="form__label" for="city">Miasto
                        <input class="form__input" type="text" name="city" value="<?php if (isset($_SESSION['form_city'])) {
                                                                                        echo $_SESSION['form_city'];
                                                                                        unset($_SESSION['form_city']);
                                                                                    } else {
                                                                                        echo $branch['branch_city'];
                                                                                    } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="address">Ulica i nr. budynku
                        <input class="form__input" type="text" name="address" value="<?php if (isset($_SESSION['form_address'])) {
                                                                                            echo $_SESSION['form_address'];
                                                                                            unset($_SESSION['form_address']);
                                                                                        } else {
                                                                                            echo $branch['branch_address'];
                                                                                        } ?>" /></label>
                    <label class="form__label" for="apartment">Nr. mieszkania
                        <input class="form__input" type="text" name="apartment" value="<?php if (isset($_SESSION['form_apartment'])) {
                                                                                            echo $_SESSION['form_apartment'];
                                                                                            unset($_SESSION['form_apartment']);
                                                                                        } else {
                                                                                            echo $branch['branch_apartment'];
                                                                                        }
                                                                                        ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="tel">Telefon
                        <input class="form__input" type="text" name="tel" maxlength="9" value="<?php if (isset($_SESSION['form_tel'])) {
                                                                                                    echo $_SESSION['form_tel'];
                                                                                                    unset($_SESSION['form_tel']);
                                                                                                } else {
                                                                                                    echo $branch['branch_tel'];
                                                                                                } ?>" /></label>
                    <label class="form__label" for="email">E-mail
                        <input class="form__input" type="text" name="email" value="<?php if (isset($_SESSION['form_email'])) {
                                                                                        echo $_SESSION['form_email'];
                                                                                        unset($_SESSION['form_email']);
                                                                                    } else {
                                                                                        echo $branch['branch_email'];
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