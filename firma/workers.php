<?php
session_start();
if (isset($_GET['branch']) && $_GET['branch'] > 0) {
    require_once "php/connect.php";
    $stmt = $connection->prepare("SELECT * FROM branches WHERE branch_user_id = ? and branch_id=?;");
    $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['branch']);
    $stmt->execute();
    $branch_result = $stmt->get_result();
    $branch = $branch_result->fetch_assoc();
    $branch_name = $branch['branch_name'];

    $stmt = $connection->prepare("SELECT * FROM workers LEFT JOIN branches ON worker_branch = branch_id WHERE worker_user_id = ? and branch_id = ?;");
    $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['branch']);
    $stmt->execute();
    $result = $stmt->get_result();
    $connection->close();
} else {
    require_once "php/connect.php";
    $stmt = $connection->prepare("SELECT * FROM workers LEFT JOIN branches ON worker_branch = branch_id WHERE worker_user_id = ? ORDER BY branch_name DESC;");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $connection->close();
}
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Pracownicy<?php if (isset($branch_name)) {
                                                        echo " - " . $branch_name;
                                                    } ?></h1>
        </header>
        <div class="section__content section__content--column">
            <div class="buttons">
                <a href="worker_creator.php" class="section__button" type="button">Dodaj nowego pracownika</a>
            </div>
            <?php require_once "include/form_message.php"; ?>
            <?php
            while ($worker = $result->fetch_assoc()) {
                $worker_id = $worker['worker_id'];
                $first_name = $worker['worker_first_name'];
                $last_name = $worker['worker_last_name'];
                $pesel = $worker['worker_pesel'];
                $postal_code = $worker['worker_postal_code'];
                $city = $worker['worker_city'];
                $address = $worker['worker_address'];
                $apartment = $worker['worker_apartment'];
                $tel = $worker['worker_tel'];
                $email = $worker['worker_email'];
                $branch_name = $worker['branch_name'];
                echo "<article class='article article--workers' id='$worker_id'>";
                echo "<header class='article__header'>";
                echo "<h2>$first_name $last_name</h2>";
                echo "<h3>Pesel: $pesel</h3>";
                echo "<h3>Oddział: $branch_name</h3>";
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