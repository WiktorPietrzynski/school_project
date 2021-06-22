<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}
$date_time = new DateTime();
$today = ($date_time->format('Y-m-d'));
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Dodawanie nowej usługi.</h1>
        </header>
        <div class="section__content section__content--column">
            <?php require_once "include/form_message.php" ?>
            <form class="form--double" action="php/add/service_add.php" method="post" id="form_service">
                <div class="form__row">
                    <label class="form__label" for="service_name">Nazwa usługi
                        <input class="form__input" type="text" name="service_name" value="<?php if (isset($_SESSION['form_service_name'])) {
                                                                                                echo $_SESSION['form_service_name'];
                                                                                                unset($_SESSION['form_service_name']);
                                                                                            } ?>" /></label>

                    <label class="form__label" for="price">Cena usługi
                        <input class="form__input" type="number" step="0.01" name="price" value="<?php if (isset($_SESSION['form_price'])) {
                                                                                                        echo $_SESSION['form_price'];
                                                                                                        unset($_SESSION['form_price']);
                                                                                                    } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="date">Data wykonania usługi
                        <input class="form__input" type="date" name="date" value="<?php if (isset($_SESSION['form_date'])) {
                                                                                        echo $_SESSION['form_date'];
                                                                                    } else {
                                                                                        echo $today;
                                                                                    } ?>" /></label>
                </div>
                <div class="form__row">
                    <label class="form__label" for="worker">Pracownik
                        <select class="form__select" name="worker">
                            <?php
                            if (isset($_GET['branch']) && $_GET['branch'] > 0) {
                                echo '<option class="form__option" disabled value="" selected="selected"></option>';
                                require_once "php/connect.php";
                                $question = $connection->prepare("SELECT * FROM workers WHERE worker_user_id=? and worker_branch= ?");
                                $question->bind_param('ii', $_SESSION['user_id'], $_GET['branch']);
                                $question->execute();
                                $result = $question->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    if (isset($_SESSION['form_worker']) && $_SESSION['form_worker'] == $row['worker_id']) {
                                        echo "<option class='form__option'  selected='selected' value='" . $row['worker_id'] . "' >" . $row['worker_first_name'] . " " . $row['worker_last_name'] . "</option>";
                                    } else {
                                        echo "<option class='form__option' value='" . $row['worker_id'] . "' >" . $row['worker_first_name'] . " " . $row['worker_last_name'] . "</option>";
                                    }
                                }
                            } else {
                                echo '<option class="form__option" disabled value="" selected="selected"></option>';
                                require_once "php/connect.php";
                                $question = $connection->prepare("SELECT * FROM workers WHERE worker_user_id=?");
                                $question->bind_param('i', $_SESSION['user_id']);
                                $question->execute();
                                $result = $question->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    if (isset($_SESSION['form_worker']) && $_SESSION['form_worker'] == $row['worker_id']) {
                                        echo "<option class='form__option'  selected='selected' value='" . $row['worker_id'] . "' >" . $row['worker_first_name'] . " " . $row['worker_last_name'] . "</option>";
                                    } else {
                                        echo "<option class='form__option' value='" . $row['worker_id'] . "' >" . $row['worker_first_name'] . " " . $row['worker_last_name'] . "</option>";
                                    }
                                }
                            }
                            ?>

                        </select></label>
                    <label class="form__label" for="contractor">Kontrahent
                        <select class="form__select" id="contractor" name="contractor">
                            <?php
                            echo '<option class="form__option" value="0" selected="selected">Nowy kontrahent</option>';
                            require_once "php/connect.php";
                            $question = $connection->prepare("SELECT * FROM contractors WHERE contractor_user_id=?");
                            $question->bind_param('i', $_SESSION['user_id']);
                            $question->execute();
                            $result = $question->get_result();
                            $connection->close();
                            while ($row = $result->fetch_assoc()) {
                                if (isset($_SESSION['form_contractor']) && $_SESSION['form_contractor'] == $row['contractor_id']) {
                                    echo "<option class='form__option'  selected='selected' value='" . $row['contractor_id'] . "' >" . $row['contractor_first_name'] . " " . $row['contractor_last_name'] .  "</option>";
                                } else {
                                    echo "<option class='form__option' value='" . $row['contractor_id'] . "' >" . $row['contractor_first_name'] . " " . $row['contractor_last_name'] . "</option>";
                                }
                            }

                            ?>

                        </select></label>
                </div>
                <button class="form__submit" id="button_service" type="button">Stwórz</button>
            </form>
        </div>
    </section>
    <div class="additional-form" id="form_contractor_wrapper">
        <?php require_once "include/form_message.php" ?>
        <form class="form--double" action="php/add/service_add.php" id="form_contractor" method="post">
            <div class="form__row">
                <label class="form__label" for="first_name">Imię
                    <input class="form__input" type="text" name="first_name" value="<?php if (isset($_SESSION['form_first_name'])) {
                                                                                        echo $_SESSION['form_first_name'];
                                                                                        unset($_SESSION['form_first_name']);
                                                                                    } ?>" /></label>
                <label class="form__label" for="last_name">Nazwisko
                    <input class="form__input" type="text" name="last_name" value="<?php if (isset($_SESSION['form_last_name'])) {
                                                                                        echo $_SESSION['form_last_name'];
                                                                                        unset($_SESSION['form_last_name']);
                                                                                    } ?>" /></label>
            </div>
            <div class="form__row">
                <label class="form__label" for="pesel">Nr. pesel
                    <input class="form__input" type="text" name="pesel" maxlength="11" value="<?php if (isset($_SESSION['form_pesel'])) {
                                                                                                    echo $_SESSION['form_pesel'];
                                                                                                    unset($_SESSION['form_pesel']);
                                                                                                } ?>" /></label>
            </div>
            <div class="form__row">
                <label class="form__label" for="postal_code">Kod pocztowy
                    <input class="form__input" type="text" name="postal_code" maxlength="6" value="<?php if (isset($_SESSION['form_postal_code'])) {
                                                                                                        echo $_SESSION['form_postal_code'];
                                                                                                        unset($_SESSION['form_postal_code']);
                                                                                                    } ?>" /></label>
                <label class="form__label" for="city">Miasto
                    <input class="form__input" type="text" name="city" value="<?php if (isset($_SESSION['form_city'])) {
                                                                                    echo $_SESSION['form_city'];
                                                                                    unset($_SESSION['form_city']);
                                                                                } ?>" /></label>
            </div>
            <div class="form__row">
                <label class="form__label" for="address">Ulica i nr. budynku
                    <input class="form__input" type="text" name="address" value="<?php if (isset($_SESSION['form_address'])) {
                                                                                        echo $_SESSION['form_address'];
                                                                                        unset($_SESSION['form_address']);
                                                                                    } ?>" /></label>
                <label class="form__label" for="apartment">Nr. mieszkania
                    <input class="form__input" type="text" name="apartment" value="<?php if (isset($_SESSION['form_apartment'])) {
                                                                                        echo $_SESSION['form_apartment'];
                                                                                        unset($_SESSION['form_apartment']);
                                                                                    } ?>" /></label>
            </div>
            <div class="form__row">
                <label class="form__label" for="tel">Telefon
                    <input class="form__input" type="text" name="tel" maxlength="9" value="<?php if (isset($_SESSION['form_tel'])) {
                                                                                                echo $_SESSION['form_tel'];
                                                                                                unset($_SESSION['form_tel']);
                                                                                            } ?>" /></label>
                <label class="form__label" for="email">E-mail
                    <input class="form__input" type="text" name="email" value="<?php if (isset($_SESSION['form_email'])) {
                                                                                    echo $_SESSION['form_email'];
                                                                                    unset($_SESSION['form_email']);
                                                                                } ?>" /></label>
            </div>
            <button class="form__submit" type="submit">Stwórz</button><button class="form__submit" id="button_cancel" type="button">Anuluj</button>
        </form>
    </div>
</main>
<style>
    .additional-form {
        position: absolute;
        top: 0;
        margin: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        background-color: #0c0f15;
        transition: all 0.5s ease-in-out;
    }
</style>

<script>
    const form = document.querySelector("#form_service");
    const input_service_name = form['service_name'];
    const input_price = form['price'];
    const input_date = form['date'];
    const input_worker = form['worker'];
    const input_contractor = form['contractor'];
    const button_service = document.querySelector("#button_service");
    const form_contractor_wrapper = document.querySelector("#form_contractor_wrapper");
    const form_contractor = document.querySelector("#form_contractor");
    const button_cancel = document.querySelector("#button_cancel");

    button_cancel.addEventListener("click", function() {
        form_contractor_wrapper.style.opacity = "0";
        form_contractor_wrapper.style.visibility = "hidden";
    })
    button_service.onclick = validation;

    function validation() {
        const id = contractor.value;
        if (id === "0") {
            form_contractor_wrapper.style.visibility = "visible";
            form_contractor_wrapper.style.opacity = "1";
            const service_name = document.createElement("input");
            service_name.setAttribute('name', 'service_name');
            service_name.setAttribute('value', input_service_name.value);
            service_name.setAttribute("hidden", true);
            form_contractor.append(service_name);
            const service_price = document.createElement("input");
            service_price.setAttribute('name', 'price');
            service_price.setAttribute('value', input_price.value);
            service_price.setAttribute("hidden", true);
            form_contractor.append(service_price);
            const service_date = document.createElement("input");
            service_date.setAttribute('name', 'date');
            service_date.setAttribute('value', input_date.value);
            service_date.setAttribute("hidden", true);
            form_contractor.append(service_date);
            const service_worker = document.createElement("input");
            service_worker.setAttribute('name', 'worker');
            service_worker.setAttribute('value', input_worker.value);
            service_worker.setAttribute("hidden", true);
            form_contractor.append(service_worker);
            const service_contractor = document.createElement("input");
            service_contractor.setAttribute('name', 'contractor');
            service_contractor.setAttribute('value', input_contractor.value);
            service_contractor.setAttribute("hidden", true);
            form_contractor.append(service_contractor);
        } else {
            form.submit();
        }
    }
</script>

<?php
require_once "include/footer.php";
?>