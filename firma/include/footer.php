<footer class="footer">
	<p class="footer__text">Wszystkie prawa zastrzeżone. Firma.pl Copyright &copy; 2020.</p>
	<a class="footer__link" href="kontakt.php">Kontakt</a>
</footer>
<?php
if (isset($_SESSION['alert'])) {
	echo "<script>";
	echo "window.onload = () => alert('" . $_SESSION['alert'] . "');";
	echo "</script>";
	unset($_SESSION['alert']);
}
?>
<?php
if (isset($_SESSION['form_validation'])) {
	$names = $_SESSION['form_validation'];
	echo "<script>";
	echo "const names = " . json_encode($names) . ";";
	echo "for (let name of names){
            let elem = document.getElementsByName(name);
            elem = elem[0];
            elem.style.border = '2px solid rgba(242, 22, 26)';
            elem.addEventListener('click', function(event) {
                elem.style.border = 'solid 3px black';
            });
    ";
	echo "}</script>";
	unset($_SESSION['form_validation']);
}
?>
</body>

</html>