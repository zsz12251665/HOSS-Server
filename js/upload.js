function SubmitForm(e)
{
	e.preventDefault();
	// Validate and collect the form data
	let form = new FormData();
	for (let input of document.querySelectorAll('input[type="text"]'))
	{
		if (!input.value)
			input.className = 'error';
		else
			form.append(input.name, input.value);
	}
	if (!document.querySelector('input[type=file]').files.length)
		document.querySelector('input[type=file]').className = 'error';
	else
		form.append(document.querySelector('input[type=file]').name, document.querySelector('input[type=file]').files[0])
	if (document.querySelector('select').selectedIndex == 0)
		document.querySelector('select').className = 'error';
	else
		form.append(document.querySelector('select').name, document.querySelector('select').selectedOptions[0].value);
	if (document.querySelector('input.error, select.error'))
	{
		alert('请正确填写表单！');
		return;
	}
	// Submit the form via AJAX
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'upload.php', true);
	// Set the event when uploading
	xhr.onprogress = function (e)
	{
		if (e.lengthComputable)
		{
			let progress = 100 * e.loaded / e.total;
			// console.log(progress);
			// Update the progress bar
			document.querySelector('div#Progress div.strip').innerText = Math.floor(progress) + '%';
			document.querySelector('div#Progress div.strip').style.width = Math.floor(progress) + '%';
		}
	};
	// Set the event when the upload completed
	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState != 4)
			return;
		if (xhr.status == 403)
		{
			for (let input of document.querySelectorAll('input[type="text"]'))
				input.className = 'error';
		}
		if (xhr.status == 400)
		{
			document.querySelector('input[type=file]').className = 'error';
		}
		// console.log(xhr.status);
		for (let input of document.querySelectorAll('input, select'))
			input.disabled = false;
		document.querySelector('input#Submit').style.display = 'inline-block';
		document.querySelector('div#Progress').style.display = 'none';
		alert(xhr.responseText);
	};
	for (let input of document.querySelectorAll('input, select'))
		input.disabled = true;
	document.querySelector('input#Submit').style.display = 'none';
	document.querySelector('div#Progress').style.display = 'block';
	document.querySelector('div#Progress div.strip').innerText = '0%';
	document.querySelector('div#Progress div.strip').style.width = '0%';
	xhr.send(form);
}
// Add Event Listeners
document.querySelector('form').addEventListener('submit', SubmitForm);
for (let input of document.querySelectorAll('input, select'))
	input.addEventListener('focus', function () { input.className = ''; });
