let url = window.location.href;
url = url.split('/');
url = url.reverse();
let site = url[0];
site = site.split('.');
site = site[0];
const delete_buttons = document.querySelectorAll('.button--delete');
for (let delete_button of delete_buttons) {
	delete_button.addEventListener('click', function() {
		const submit = confirm('Czy napewno chcesz to usunąć?');
		if (submit) {
			const id = delete_button.parentElement.parentElement.id;
			const new_site = 'php/delete/' + site + '_delete.php?id=' + id;

			window.location.href = new_site;
		}
	});
}
const update_buttons = document.querySelectorAll('.button--update');
for (let update_button of update_buttons) {
	update_button.addEventListener('click', function() {
		const id = update_button.parentElement.parentElement.id;
		const new_site = site + '_update.php?id=' + id;

		window.location.href = new_site;
	});
}
const workers_buttons = document.querySelectorAll('.button--workers');
for (let worker_button of workers_buttons) {
	worker_button.addEventListener('click', function() {
		const id = worker_button.parentElement.parentElement.id;
		window.location.href = 'workers.php?branch=' + id;
	});
}

const services_buttons = document.querySelectorAll('.button--services');
for (let service_button of services_buttons) {
	service_button.addEventListener('click', function() {
		const id = service_button.parentElement.parentElement.id;
		window.location.href = 'services.php?branch=' + id;
	});
}

const raports_buttons = document.querySelectorAll('.button--raports');
for (let raport_button of raports_buttons) {
	raport_button.addEventListener('click', function() {
		const id = raport_button.parentElement.parentElement.id;
		window.location.href = 'raports.php?branch=' + id;
	});
}
