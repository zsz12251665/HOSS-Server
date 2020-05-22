function setDisplay(filter, display)
{
	document.querySelectorAll(filter).forEach(section => section.style.display = display);
}
function displayMode(e)
{
	setDisplay('section[class]', 'none');
	setDisplay('section.' + e.target.value.toLowerCase(), 'block');
	document.querySelectorAll('section.insert input').forEach(input => input.disabled = (e.target.value == 'Download'));
	if (e.target.value == 'Delete')
	{
		document.querySelector(document.querySelector('input#Students').checked ? 'input#Students' : 'input#Homeworks').click();
	}
}
function displayTarget(e)
{
	if (document.querySelector('input#Delete').checked)
	{
		setDisplay('section.delete', 'none');
		setDisplay('section.' + e.target.value, 'block');
	}
}
function SubmitForm(e)
{
	e.preventDefault();
	// The download event
	if (document.querySelector('input#Download').checked)
	{
		// Validate the select
		if (document.querySelector('option#Default').selected)
		{
			alert('请选择要下载的作业！');
		}
		if (homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].count == 0)
		{
			alert('暂时无人提交此作业，无法下载！');
		}
		// Submit the form
		document.querySelector('form').submit();
		// Reset the form
		document.querySelector('input#Password').value = '';
		document.querySelector('option#Default').selected = true;
	}
	// The modify events
	// Validate the select
	if (document.querySelector('input#Delete').checked && document.querySelector('input#Homeworks').checked && document.querySelector('option#Default').selected)
	{
		alert('请选择要删除的作业！');
		return;
	}
	// Submit the form via AJAX
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'modify.php', true);
	// Fulfill the form data
	let form = new FormData(document.querySelector('form'));
	form.delete('WorkTitle');
	if (form.get('Mode') == 'Delete' && form.get('Target') == 'homeworks')
	{
		form.set('First', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].title);
		form.set('Second', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].directory);
	}
	if (form.get('Mode') == 'Insert' && form.get('Target') == 'homeworks' && !form.get('Second'))
	{
		form.set('Second', form.get('First'));
	}
	// Set the event when the upload completed
	xhr.onreadystatechange = function ()
	{
		if (xhr.readyState != 4)
		{
			return;
		}
		// console.log(xhr.status + ': ' xhr.responseText);
		// Show the result
		alert(xhr.responseText);
		// Reset the form
		document.querySelector('input#First').value = document.querySelector('input#Second').value = document.querySelector('input#Password').value = '';
		document.querySelector('option#Default').selected = true;
	};
	// Send the request
	xhr.send(form);
}
// Load the homework list
let xhr = new XMLHttpRequest();
xhr.open('GET', 'homework.php', false);
xhr.send();
var homeworkList = JSON.parse(xhr.responseText);
homeworkList.forEach(homework => document.querySelector('select#WorkTitle').innerHTML += '<option value="' + homework.directory + '">' + homework.title + ' (' + homework.count + ')</option>');
// Add event listeners
document.querySelector('form').addEventListener('submit', SubmitForm);
document.querySelectorAll('input[name="Mode"]').forEach(input => input.addEventListener('click', displayMode));
document.querySelectorAll('input[name="Target"]').forEach(input => input.addEventListener('click', displayTarget));
