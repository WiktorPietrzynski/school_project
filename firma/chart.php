<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$year = date("Y");
$data_od = $year . "-01-01";
$data_do = $year . "-12-31";
include "php/connect.php";
$rezultat_rok = $connection->query("SELECT MONTH(service_date) as month,SUM(service_price) AS sum FROM services AS s INNER JOIN contractors AS c ON s.service_contractor = c.contractor_id WHERE contractor_user_id=$user_id AND (service_date BETWEEN '$data_od' AND '$data_do') GROUP BY MONTH(service_date)");
$values = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
while ($wiersz = $rezultat_rok->fetch_assoc()) {
    for ($i = 1; $i <= 12; $i++) {
        if ($wiersz['month'] == $i) {
            $values[$i - 1] = round($wiersz["sum"], 2);
        }
    }
}
$connection->close();
?>
<?php
require_once "include/header.php";
?>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Roczna sprzedaż <?php echo $_SESSION['user_company_name']; ?>.</h1>
        </header>
        <div class="section__content section__content--column">
            <div id="chartContainer" style="margin-top:5%; height: 370px; width: 75%; transition: all 1s ease-in-out;">
            </div>
        </div>

    </section>
</main>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">
    window.onload = function() {
        let type = "column";
        const values = <?php echo json_encode($values); ?>;
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "dark1", // "light2", "dark1", "dark2"
            animationEnabled: true, // change to true
            title: {
                text: "Roczna sprzedaż <?php echo $_SESSION['user_company_name']; ?>"
            },
            data: [{
                // Change type to "bar", "area", "spline", "pie",etc.
                type: type,
                dataPoints: [{
                        label: "Styczeń",
                        y: values[0]
                    },
                    {
                        label: "Luty",
                        y: values[1]
                    },
                    {
                        label: "Marzec",
                        y: values[2]
                    },
                    {
                        label: "Kwiecień",
                        y: values[3]
                    },
                    {
                        label: "Maj",
                        y: values[4]
                    },
                    {
                        label: "Czerwiec",
                        y: values[5]
                    },
                    {
                        label: "Lipiec",
                        y: values[6]
                    },
                    {
                        label: "Sierpień",
                        y: values[7]
                    },
                    {
                        label: "Wrzesień",
                        y: values[8]
                    },
                    {
                        label: "Pażdziernik",
                        y: values[9]
                    },
                    {
                        label: "Listopad",
                        y: values[10]
                    },
                    {
                        label: "Grudzień",
                        y: values[11]
                    }
                ]
            }]
        });
        chart.render();
    }
</script>
<?php
require_once "include/footer.php";
?>