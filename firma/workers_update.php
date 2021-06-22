<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: workers.php");
    exit();
}

require_once "php/connect.php";
$stmt = $connection->prepare("SELECT * FROM workers WHERE worker_id=? and worker_user_id = ?;");
$stmt->bind_param('ii', $_GET['id'], $_SESSION['user_id']);
$stmt->execute();
$worker = $stmt->get_result();
$count = $worker->num_rows;
if ($count == 0) {
    header("location: workers.php");
    exit();
}
$worker = $worker->fetch_assoc();
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Edycja pracownika.</h1>
        </header>
        <div class="section__content section__content--column">
            <?php require_once "include/form_message.php" ?>
            <form class="form--double" action="php/update/worker_updating.php?id=<?php echo $_GET['id'] ?>" method="post">
                <div class="form__row">
                    <label class="form__label" for="first_name">Imię
                        <input class="form__input" type="text" name="first_name" value="<?php if (isset($_SESSION['form_first_name'])) {
                                                                                            echo $_SESSION['form_first_name'];
                                                                                            unset($_SESSION['form_first_name']);
                                                                                        } else {
                                                                                            echo $worker['worker_first_name'];
                                                                                        } ?>" /></label>
                    <label class="form__label" for="last_name">Nazwisko
                        <input class="form__input" type="text" name="last_name" value="<?php if (isset($_SESSION['form_last_name'])) {
                                                                                            echo $_SESSION['form_last_name'];
                                                                                            unset($_SESSION['form_last_name']);
                                                                                        } else {
                                                                                            echo $worker['worker_last_name'];
                                                                                        } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="pesel">Nr. pesel
                        <input class="form__input" type="text" name="pesel" maxlength="11" value="<?php if (isset($_SESSION['form_pesel'])) {
                                                                                                        echo $_SESSION['form_pesel'];
                                                                                                        unset($_SESSION['form_pesel']);
                                                                                                    } else {
                                                                                                        echo $worker['worker_pesel'];
                                                                                                    }  ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="postal_code">Kod pocztowy
                        <input class="form__input" type="text" name="postal_code" maxlength="6" value="<?php if (isset($_SESSION['form_postal_code'])) {
                                                                                                            echo $_SESSION['form_postal_code'];
                                                                                                            unset($_SESSION['form_postal_code']);
                                                                                                        } else {
                                                                                                            echo $worker['worker_postal_code'];
                                                                                                        } ?>" /></label>
                    <label class="form__label" for="city">Miasto
                        <input class="form__input" type="text" name="city" value="<?php if (isset($_SESSION['form_city'])) {
                                                                                        echo $_SESSION['form_city'];
                                                                                        unset($_SESSION['form_city']);
                                                                                    } else {
                                                                                        echo $worker['worker_city'];
                                                                                    }
                                                                                    ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="address">Ulica i nr. budynku
                        <input class="form__input" type="text" name="address" value="<?php if (isset($_SESSION['form_address'])) {
                                                                                            echo $_SESSION['form_address'];
                                                                                            unset($_SESSION['form_address']);
                                                                                        } else {
                                                                                            echo $worker['worker_address'];
                                                                                        } ?>" /></label>
                    <label class="form__label" for="apartment">Nr. mieszkania
                        <input class="form__input" type="text" name="apartment" value="<?php if (isset($_SESSION['form_apartment'])) {
                                                                                            echo $_SESSION['form_apartment'];
                                                                                            unset($_SESSION['form_apartment']);
                                                                                        } else {
                                                                                            echo $worker['worker_apartment'];
                                                                                        } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="tel">Telefon
                        <input class="form__input" type="text" name="tel" maxlength="9" value="<?php if (isset($_SESSION['form_tel'])) {
                                                                                                    echo $_SESSION['form_tel'];
                                                                                                    unset($_SESSION['form_tel']);
                                                                                                } else {
                                                                                                    echo $worker['worker_tel'];
                                                                                                } ?>" /></label>
                    <label class="form__label" for="email">E-mail
                        <input class="form__input" type="text" name="email" value="<?php if (isset($_SESSION['form_email'])) {
                                                                                        echo $_SESSION['form_email'];
                                                                                        unset($_SESSION['form_email']);
                                                                                    } else {
                                                                                        echo $worker['worker_email'];
                                                                                    } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="branch">Oddział
                        <select class="form__select" name="branch">
                            <?php
                            $question = $connection->prepare("SELECT * FROM branches WHERE branch_user_id=?");
                            $question->bind_param('i', $_SESSION['user_id']);
                            $question->execute();
                            $result = $question->get_result();
                            $connection->close();
                            while ($row = $result->fetch_assoc()) {
                                if (isset($_SESSION['form_branch']) && $_SESSION['form_branch'] == $row['branch_id']) {
                                    echo "<option class='form__option'  selected='selected' value='" . $row['branch_id'] . "' >" . $row['branch_name'] . "</option>";
                                } else {
                                    if ($worker['worker_branch'] == $row['branch_id']) {
                                        echo "<option class='form__option'  selected='selected' value='" . $row['branch_id'] . "' >" . $row['branch_name'] . "</option>";
                                    } else {
                                        echo "<option class='form__option' value='" . $row['branch_id'] . "' >" . $row['branch_name'] . "</option>";
                                    }
                                }
                            }

                            ?>

                        </select></label>
                </div>
                <button class="form__submit" type="submit">Edytuj</button>
            </form>
        </div>

    </section>
</main>
<?php
require_once "include/footer.php";
?>