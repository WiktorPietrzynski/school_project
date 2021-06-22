<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

require_once "php/connect.php";
$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_user_id = ?;");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$branches_list = [];
$i = 0;
while ($row = $result->fetch_assoc()) {
    $branches_list[$i] = $row;
    $i++;
}

$stmt = $connection->prepare("SELECT * FROM branches WHERE branch_user_id = ?;");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$branches = $stmt->get_result();
$connection->close();
?>
<?php
require_once "include/header.php";
?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnHaj_eDoJ_qIc9ZY8rrf8wrT8Ngf78hY&callback=initMap&libraries=&v=weekly"></script>
<script>
    async function initMap() {
        const geocoder = new google.maps.Geocoder();

        //var latlng = new google.maps.LatLng(0, 0);
        var location = await address_coder("Polska");
        var mapOptions = {
            zoom: 6,
            center: location
        };

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        const branches_list = <?php echo json_encode($branches_list); ?>;
        console.log(branches_list);
        for (branch of branches_list) {
            const address = branch['branch_city'] + ", " + branch['branch_address'];
            let position = await address_coder(address);
            if (position === "false") {
                const new_address = branch['branch_city'];
                position = await address_coder(new_address);
                if (position === "false") {
                    const new_new_address = "Poland";
                    position = await address_coder(new_new_address);
                }
            }
            const id = branch['branch_id'];
            const name = branch['branch_name'];
            const marker = new google.maps.Marker({
                position: position,
                label: name
            });
            console.log(position);
            marker.setMap(map);
            marker.addListener("click", () => {
                select(id);
            });

        }

        async function address_coder(address) {
            return new Promise(await
                function(resolve) {
                    geocoder.geocode({
                        address: address
                    }, function(results, status) {
                        console.log(status);
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            const latlng = new google.maps.LatLng({
                                lat: lat,
                                lng: lng
                            });
                            setTimeout(function() {
                                resolve(latlng);
                            }, 250);
                        } else {
                            setTimeout(function() {
                                resolve("false");
                            }, 250);
                        }
                    });
                });
        }

    }
</script>
<style>
    .wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .wrapper>div {
        margin-top: 5%;
    }

    .buttons {
        margin-top: 3%;
    }

    #map {
        min-width: 350px;
        height: 500px;
        width: 35%;
    }

    #info {
        min-width: 350px;
        height: 500px;
        width: 35%;
        overflow: hidden;
        overflow-y: scroll;
    }
</style>
<main class="main">
    <section class="section">
        <header class="section__header">
            <h1 class="section__title">Oddziały</h1>
        </header>
        <div class="wrapper">
            <div id="map">

            </div>
            <div id="info" class="wrapper--index">
                <div class="buttons">
                    <a href="branch_creator.php" class="section__button">Dodaj nowy oddział</a>
                </div>
                <div id="form">
                    <?php require_once "include/form_message.php"; ?>
                    <?php
                    while ($branch = $branches->fetch_assoc()) {
                        $branch_id = $branch['branch_id'];
                        $branch_name = $branch['branch_name'];
                        $nip = $branch['branch_nip'];
                        $postal_code = $branch['branch_postal_code'];
                        $city = $branch['branch_city'];
                        $address = $branch['branch_address'];
                        $apartment = $branch['branch_apartment'];
                        $email = $branch['branch_email'];
                        $tel = $branch['branch_tel'];
                        echo "<article class='article article--branches' id='$branch_id'>";
                        echo "<header class='article__header'>";
                        echo "<h2>Oddział: $branch_name</h2>";
                        echo "<h3>Nip: $nip</h3>";
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
                        echo "<div class='article__button button--workers'>";
                        echo "<i class='article__icon fas fa-users fa-2x'></i>";
                        echo "</div>";
                        echo "<div class='article__button button--services'>";
                        echo "<i class='article__icon fas fa-handshake fa-2x'></i>";
                        echo "</div>";
                        echo "<div class='article__button button--raports'>";
                        echo "<i class='article__icon fas fa-file-contract fa-2x'></i>";
                        echo "</div>";
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

                <?php require_once "include/form_message.php"; ?>
            </div>
        </div>
    </section>
</main>
<script src="js/article_buttons.js"></script>
<script>
    const articles = document.querySelectorAll(".article");
    for (article of articles) {
        article.addEventListener("click", function() {
            select(this.id);
        });
    }

    function select(id) {
        const selected_article = document.getElementById(id);
        for (article of articles) {
            article.style.backgroundColor = "#333";
            article.style.border = "3px solid blue";
        }
        selected_article.style.backgroundColor = "#555";
        selected_article.style.border = "3px solid green";

        var myElement = document.getElementById(id);
        var topPos = myElement.offsetTop;
        document.getElementById('info').scrollTop = topPos - 250;
    }
</script>
<?php
require_once "include/footer.php";
?>