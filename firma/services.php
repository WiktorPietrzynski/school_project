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

    $stmt = $connection->prepare("SELECT * FROM services INNER JOIN workers ON worker_id = service_worker INNER JOIN contractors ON contractor_id = service_contractor INNER JOIN branches ON worker_branch = branch_id WHERE worker_user_id = ? and branch_id=?;");
    $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['branch']);
    $stmt->execute();
    $result = $stmt->get_result();
    $connection->close();
} else {
    require_once "php/connect.php";
    $stmt = $connection->prepare("SELECT * FROM services INNER JOIN workers ON worker_id = service_worker INNER JOIN contractors ON contractor_id = service_contractor WHERE worker_user_id = ?;");
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
            <h1 class="section__title">Usługi<?php if (isset($branch_name)) {
                                                    echo " - " . $branch_name;
                                                } ?></h1>
        </header>
        <div class="section__content section__content--column">
            <div class="buttons">
                <a href="service_creator.php" class="section__button" type="button">Dodaj nową usługę</a>
            </div>
            <?php require_once "include/form_message.php"; ?>
            <?php
            while ($service = $result->fetch_assoc()) {
                $service_id = $service['service_id'];
                $worker_first_name = $service['worker_first_name'];
                $worker_last_name = $service['worker_last_name'];
                $contractor_first_name = $service['contractor_first_name'];
                $contractor_last_name = $service['contractor_last_name'];
                $service_name = $service['service_name'];
                $service_price = $service['service_price'];
                $service_date = $service['service_date'];
                echo "<article class='article article--services' id='$service_id'>";
                echo "<header class='article__header'>";
                echo "<h2>$service_name</h2>";
                echo "<h3>Pracownik: $worker_first_name $worker_last_name</h3>";
                echo "<h3>Kontrahent: $contractor_first_name $contractor_last_name</h3>";
                echo "</header>";
                echo "<div class='article__content'>";
                echo "<p>";
                echo "<b>Cena:</b> $service_price zł";
                echo "<br>";
                echo "<b>Data wykonania:</b><br>$service_date ";
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