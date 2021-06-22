<?php
session_start();

require_once "php/connect.php";
$stmt = $connection->prepare("SELECT * FROM contractors WHERE contractor_user_id = ? and contractor_status = 1 ;");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$connection->close();
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Kontrahenci</h1>
        </header>
        <div class="section__content section__content--column">
            <div class="buttons">
                <a href="contractor_creator.php" class="section__button" type="button">Dodaj nowego kontrahenta</a>
            </div>
            <?php require_once "include/form_message.php"; ?>
            <?php
            while ($contractor = $result->fetch_assoc()) {
                $contractor_id = $contractor['contractor_id'];
                $first_name = $contractor['contractor_first_name'];
                $last_name = $contractor['contractor_last_name'];
                $pesel = $contractor['contractor_pesel'];
                $postal_code = $contractor['contractor_postal_code'];
                $city = $contractor['contractor_city'];
                $address = $contractor['contractor_address'];
                $apartment = $contractor['contractor_apartment'];
                $tel = $contractor['contractor_tel'];
                $email = $contractor['contractor_email'];
                echo "<article class='article article--contractors' id='$contractor_id'>";
                echo "<header class='article__header'>";
                echo "<h2>$first_name $last_name</h2>";
                echo "<h3>Pesel: $pesel</h3>";
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
            }

            ?>
        </div>
    </section>
</main>
<script src="js/article_buttons.js"></script>
<?php
require_once "include/footer.php";
?>