<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: branches.php");
    exit();
} else {
    $branch_id = $_GET['id'];
    require_once "php/connect.php";
    $stmt = $connection->prepare("SELECT * FROM branches WHERE branch_id=? and branch_user_id=?;");
    $stmt->bind_param('ii', $branch_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $connection->close();
    $count = $result->num_rows;
    if ($count == 0) {
        header("location: branches.php");
        exit();
    }
    $result = $result->fetch_assoc();
    $branch_name = $result['branch_name'];
    $nip = $result['branch_nip'];
    $postal_code = $result['branch_postal_code'];
    $city = $result['branch_city'];
    $address = $result['branch_address'];
    $apartment = $result['branch_apartment'];
    $tel = $result['branch_tel'];
    $email = $result['branch_email'];
}
?>
<?php
require_once "include/header.php";
?>
<style>
    #branch {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 32px;
    }

    img {
        width: 50%;
        height: 50%;
    }
</style>

<main class="main">
    <section class="section">
        <div id="branch">
            <?php
            echo $branch_name;
            echo "<br>";
            echo $nip;
            echo "<br>";
            echo $postal_code;
            echo "<br>";
            echo $city;
            echo "<br>";
            echo $address;
            echo "<br>";
            echo $apartment;
            echo "<br>";
            echo $tel;
            echo "<br>";
            echo $email;
            ?>
        </div>
    </section>
</main>

<?php
require_once "include/footer.php";


?>