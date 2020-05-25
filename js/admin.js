function setDisplay(e)
{
	document.querySelectorAll('section[class]').forEach(section => section.style.display = 'none');
	document.querySelectorAll('section.' + document.querySelector('input[name="Mode"]:checked').value + (document.querySelector('input#Download').checked ? '' : '.' + document.querySelector('input[name="Target"]:checked').value)).forEach(section => section.style.display = 'block');
	document.querySelectorAll('section.insert input').forEach(input => input.disabled = (e.target.value == 'Download'));
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
		return;
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
	if (form.get('Mode') == 'delete' && form.get('Target') == 'homeworks')
	{
		form.set('Title', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].title);
		form.set('Directory', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].directory);
		form.set('Deadline', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].deadline);
	}
	if (form.get('Mode') == 'insert' && form.get('Target') == 'homeworks' && !form.get('Directory'))
	{
		form.set('Directory', form.get('Title'));
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
		// Reload the page
		location.reload();
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
document.querySelectorAll('input[name="Mode"], input[name="Target"]').forEach(input => input.addEventListener('click', setDisplay));
