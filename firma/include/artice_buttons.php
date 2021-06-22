	let url = window.location.href;
	url = url.split("/");
	url = url.reverse();
	let site = url[0];
	site = site.split(".");
	site = site[0];
	const delete_buttons = document.querySelectorAll(".button--delete");
	for (let delete_button of delete_buttons) {
	delete_button.addEventListener("click", function() {
	const submit = confirm("Czy napewno chcesz usunąć tego pracownika?");
	if (submit) {
	const id = delete_button.parentElement.id;
	const new_site = "php/" + site + "_delete.php?id=" + id;
	alert(new_site);

	window.location.href = new_site;
	}
	});
	}
	const update_buttons = document.querySelectorAll(".button--update");
	for (let update_button of update_buttons) {
	update_button.addEventListener("click", function() {
	const id = update_button.parentElement.id;
	const new_site = site + "_update.php?id=" + id;
	alert(new_site);

	window.location.href = new_site;
	});
	}