<?php
session_start();
require_once "include/header.php";
?>
<?php
if ($_SESSION['user_nip'] != "") {
    header("Location: index.php");
    exit();
}
?>

<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Zarządzaj swoją firmą w jednym miejscu.</h1>
        </header>
        <div class="section__content section__content--column">
            <?php require_once "include/form_message.php" ?>
            <form class="form" id="form-company-edit" action="php/company_edit.php" method="post">
                <label class="form__label" for="company_name">Nazwa firmy</label>
                <input class="form__input" type="text" name="company_name" />
                <label class="form__label" for="nip">Numer Nip</label>
                <input class="form__input" type="text" name="nip" maxlength="10" />
                <button class="form__submit" type="submit">Edytuj</button>

            </form>
        </div>

    </section>
</main>
<?php
require_once "include/footer.php";


if (isset($_SESSION['form_validation'])) {
    $names = $_SESSION['form_validation'];
    echo "<script>";
    echo "const names = " . json_encode($names) . ";";
    echo "for (let name of names){
            let elem = document.getElementsByName(name);
            elem = elem[0];
            elem.style.border = '2px solid rgba(242, 22, 26, 1)';
            elem.addEventListener('click', function(event) {
                elem.style.border = '2px solid rgba(242, 22, 26, 0)';
            });
    ";
    echo "}</script>";
    unset($_SESSION['form_validation']);
}
?>