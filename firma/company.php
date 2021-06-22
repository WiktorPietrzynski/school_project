<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['user_company_name'] == "" || $_SESSION['user_nip'] == "") {
    header("Location: company_editor.php");
    exit();
}
?>
<?php
require_once "include/header.php";
?>
<style>
    img {
        width: 300px;
        height: auto;
    }

    .form {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
    }

    .form__input {
        width: 200px;
    }

    .index-box__buttons {
        display: flex;
        justify-content: space-between;
    }

    .index-box {
        width: 250px;
        height: auto;
    }

    section {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /*hex*/
    .wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-wrap: wrap;
    }

    .row {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    a {
        color: inherit;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    a:hover,
    a:focus {
        color: #ababab;
        text-decoration: none;
        outline: 0 none;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: #1e2530;
        font-family: "Open Sans", sans-serif;
        margin: 0;
        line-height: 1.3;
    }

    /* End of container */
</style>
<main class="main">
    <section class="section section--index">
        <div class="wrapper">
            <div class="row">
                <h1 class="section__title">Witaj <?php echo $_SESSION['user_company_name']; ?></h1>
            </div>
            <div class="row">
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a href="branches.php" class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fas fa-building"></i>
                            </span>
                            <span class="title">Wszystkie oddziały</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a a href="workers.php" class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="title">Wszyscy pracownicy</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a a href="contractors.php" class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fas fa-address-book"></i>
                            </span>
                            <span class="title">Wszyscy kontrahenci</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>

            </div>
            <div class="row">
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a a href="services.php" class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fas fa-handshake"></i>
                            </span>
                            <span class="title">Wszystkie usługi</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a a href="raports.php" class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fas fa-file-contract"></i>
                            </span>
                            <span class="title">Wszystkie raporty</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z" fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<?php
require_once "include/footer.php";
?>