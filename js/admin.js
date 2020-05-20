function displaySection(className, display)
{
	let sectionList = className ? document.querySelectorAll('section.' + className) : document.querySelectorAll('section[class]');
	for (let section of sectionList)
	{
		section.style.display = display;
	}
}
function displayMode(e)
{
	displaySection('', 'none');
	displaySection(e.target.value.toLowerCase(), 'block');
	for (let input of document.querySelectorAll('section.insert input'))
	{
		input.disabled = (e.target.value == 'Download');
	}
	if (e.target.value == 'Delete')
	{
		for (let input of document.querySelectorAll('input[name="Target"]'))
		{
			if (input.checked)
			{
				input.click();
			}
		}
	}
}
function displayTarget(e)
{
	if (!document.querySelector('input#Delete').checked)
		return;
	displaySection('delete', 'none');
	displaySection(e.target.value, 'block');
}
function SubmitForm(e)
{
	// The download event
	if (document.querySelector('input#Download').checked)
	{
		// Validate the select
		if (document.querySelector('option#Default').selected)
		{
			e.preventDefault();
			alert('请选择要下载的作业！');
		}
		if (homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].count == 0)
		{
			e.preventDefault();
			alert('暂时无人提交此作业，无法下载！');
		}
		// Submit the form
		return;
	}
	// The modify events
	e.preventDefault();
	// Validate the select
	if (document.querySelector('input#Delete').checked && document.querySelector('input#Homeworks').checked && document.querySelector('option#Default').selected)
	{
		alert('请选择要删除的作业！');
		return;
	}
	// Submit the form via AJAX
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'modify.php', true);
	// Fulfill the form
	let form = new FormData(document.querySelector('form'));
	form.delete('WorkTitle');
	if (form.get('Mode') == 'Delete' && form.get('Target') == 'homeworks')
	{
		form.set('First', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].title);
		form.set('Second', homeworkList[document.querySelector('select#WorkTitle').selectedIndex - 1].directory);
	}
	if (form.get('Mode') == 'Delete' && form.get('Target') == 'homeworks' && !form.get('Second'))
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
		// Reset the data
		document.querySelector('input#First').value = document.querySelector('input#Second').value = '';
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
for (let homework of homeworkList)
{
	document.querySelector('select#WorkTitle').innerHTML += '<option value="' + homework.directory + '">' + homework.title + ' (' + homework.count + ')</option>';
}
// Add event listeners
document.querySelector('form').addEventListener('submit', SubmitForm);
for (let input of document.querySelectorAll('input[name="Mode"]'))
{
	input.addEventListener('click', displayMode);
}
for (let input of document.querySelectorAll('input[name="Target"]'))
{
	input.addEventListener('click', displayTarget);
}
