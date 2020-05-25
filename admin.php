<?php
	if (!file_exists("local.php"))
	{
		header("HTTP/1.1 302 Found");
		header("Location: install.php");
		die();
	}
?>
<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<title><?php require "local.php"; echo $website_title; ?></title>
	</head>
	<body>
		<main>
			<header>
				<h1><?php require "local.php"; echo $website_title; ?></h1>
			</header>
			<form action="download.php" method="post" enctype="multipart/form-data">
				<section style="text-align: center;">
					<input type="radio" name="Mode" id="Insert" value="insert" checked />
					<label for="Insert">新建</label>
					<input type="radio" name="Mode" id="Delete" value="delete" />
					<label for="Delete">删除</label>
					<input type="radio" name="Mode" id="Download" value="download" />
					<label for="Download">下载</label>
				</section>
				<section class="insert delete homeworks students" style="text-align: center;">
					<input type="radio" name="Target" id="Students" value="students" />
					<label for="Students">学生</label>
					<input type="radio" name="Target" id="Homeworks" value="homeworks" checked />
					<label for="Homeworks">作业</label>
				</section>
				<section class="insert homeworks">
					<label for="Title">作业内容：</label>
					<input type="text" name="Title" id="Title" />
				</section>
				<section class="insert homeworks">
					<label for="Directory">作业目录：</label>
					<input type="text" name="Directory" id="Directory" />
				</section>
				<section class="insert homeworks">
					<label for="Deadline">截止日期：</label>
					<input type="date" name="Deadline" id="Deadline" pattern="\d{4}-\d{2}-\d{2}" />
				</section>
				<section class="insert delete students" style="display: none;">
					<label for="Name">学生姓名：</label>
					<input type="text" name="Name" id="Name" />
				</section>
				<section class="insert delete students" style="display: none;">
					<label for="Number">学生学号：</label>
					<input type="text" name="Number" id="Number" />
				</section>
				<section class="delete download homeworks" style="display: none;">
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option id="Default" value="" selected>--请选择作业--</option>
					</select>
				</section>
				<section>
					<label for="Password">管理员密码：</label>
					<input type="password" name="Password" id="Password" required />
				</section>
				<section style="text-align: center;">
					<input type="submit" />
				</section>
			</form>
			<footer>&copy; 2020 <a href="https://github.com/whaohan">whaohan</a> &amp; <a href="https://github.com/zsz12251665">zsz12251665</a>. All rights reserved. </footer>
		</main>
		<script type="text/javascript" src="/js/admin.js"></script>
	</body>
</html>
