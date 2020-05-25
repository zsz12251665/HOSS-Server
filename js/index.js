function SubmitForm(e)
{
	e.preventDefault();
	// Reset the styles
	document.querySelectorAll('input[type="text"]').forEach(input => input.className = '');
	// Collect form data
	let form = new FormData(document.querySelector('form'));
	// Submit the form via AJAX
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'upload.php', true);
	// Set the event when uploading
	xhr.upload.onprogress = function (e)
	{
		if (e.lengthComputable)
		{
			let progress = 100 * e.loaded / e.total;
			// console.log(progress);
			// Update the progress bar
			document.querySelector('div#Progress div.strip').style.width = document.querySelector('div#Progress span.label').innerText = Math.floor(progress) + '%';
		}
	};
	// Set the event when the upload completed
	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState != 4)
		{
			return;
		}
		// console.log(xhr.status + ': ' xhr.responseText);
		// Invalid submit
		if (xhr.status == 403)
		{
			document.querySelectorAll('input[type="text"]').forEach(input => input.className = 'error');
		}
		if (xhr.status == 400)
		{
			document.querySelector('input[type=file]').className = 'error';
		}
		if (xhr.status == 409)
		{
			document.querySelector('select').className = 'error';
		}
		// Enable the inputs and hide the progress bar
		document.querySelectorAll('input, select').forEach(input => input.disabled = false);
		document.querySelector('input#Submit').style.display = 'inline-block';
		document.querySelector('div#Progress').style.display = 'none';
		// Show the result
		alert(xhr.responseText);
		// Reset the form
		document.querySelector('form').reset();
	};
	// Disable the inputs and show the progress bar
	document.querySelectorAll('input, select').forEach(input => input.disabled = true);
	document.querySelector('input#Submit').style.display = 'none';
	document.querySelector('div#Progress').style.display = 'block';
	document.querySelector('div#Progress div.strip').style.width = document.querySelector('div#Progress span.label').innerText = '0%';
	// Send the request
	xhr.send(form);
}
// Load the homework list
let xhr = new XMLHttpRequest();
xhr.open('GET', 'homework.php', false);
xhr.send();
JSON.parse(xhr.responseText).forEach(homework => document.querySelector('select#WorkTitle').innerHTML += Date.parse(homework.deadline) > Date.now() ? '<option value="' + homework.directory + '">' + homework.title + ' (' + homework.deadline + ')</option>': '');
// Add event listeners
document.querySelector('form').addEventListener('submit', SubmitForm);
document.querySelectorAll('input, select').forEach(input => input.addEventListener('focus', e => e.target.className = ''));
