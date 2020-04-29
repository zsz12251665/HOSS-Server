<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<title>SCUT 2019计科全英联合班作业提交系统</title>
	</head>
	<body>
		<main>
			<h1>SCUT 2019计科全英联合班作业提交系统</h1>
			<h4>注意事项</h4>
			<ul>
				<li>每人每份作业只能提交一个文件；</li>
				<li>提交新文件会覆盖掉旧文件；</li>
				<li>如果要提交多个文件，请打包后再提交；</li>
				<li><del>请不要尝试输入稀奇古怪的东西</del>{{{(&gt;_&lt;)}}}</li>
			</ul>
			<form action="javascript:void(0)" method="post" enctype="multipart/form-data">
				<section>
					<label for="StuName">学生姓名：</label>
					<input type="text" name="StuName" id="StuName" />
				</section>
				<section>
					<label for="StuNumber">学生学号：</label>
					<input type="text" name="StuNumber" id="StuNumber" />
				</section>
				<section>
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option value="Default" selected="selected">--请选择要提交的作业--</option>
<?php
	require "sql.php";
	foreach (array_reverse($GLOBALS["homeworkList"]) as $homework)
	{
		$directory = htmlspecialchars($homework["directory"] ? $homework["directory"] : $homework["title"]);
		$title = htmlspecialchars($homework["title"]);
		echo "<option value=\"" . $directory . "\">" . $title . "</option>";
	}
?>
					</select>
				</section>
				<section>
					<label for="WorkFile">作业文件：</label>
					<input type="file" name="WorkFile" id="WorkFile" />
				</section>
				<section style="text-align: center;">
					<input type="submit" name="Submit" id="Submit" />
					<span id="Uploading" style="display: none;">上传中……</span>
				</section>
			</form>
		</main>
		<script type="text/javascript">
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
		for(let input of document.querySelectorAll('input, select'))
			input.disabled = false;
		document.querySelector('input#Submit').style.display = 'inline-block';
		document.querySelector('span#Uploading').style.display = 'none';
		alert(xhr.responseText);
	};
	for(let input of document.querySelectorAll('input, select'))
		input.disabled = true;
	document.querySelector('input#Submit').style.display = 'none';
	document.querySelector('span#Uploading').style.display = 'inline';
	xhr.send(form);
}
// Add Event Listeners
document.querySelector('form').addEventListener('submit', SubmitForm);
for (let input of document.querySelectorAll('input, select'))
	input.addEventListener('focus', function () { input.className = ''; });
		</script>
	</body>
</html>
