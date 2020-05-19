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
			<h4>下载作业</h4>
			<form action="download.php" method="post" enctype="multipart/form-data">
				<section>
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option value="Default" selected="selected">--请选择要下载的作业--</option>
<?php
	require "sql.php";
	foreach (array_reverse(matchingEntry("homeworks")) as $homework)
	{
		require "local.php";
		$localDirectory = $upload_directory . ($homework["directory"] ? $homework["directory"] : $homework["title"]) . "/";
		$count = (file_exists($localDirectory) && is_dir($localDirectory)) ? count(scandir($localDirectory)) - 2 : 0;
		$directory = htmlspecialchars($homework["directory"] ? $homework["directory"] : $homework["title"]);
		$title = htmlspecialchars($homework["title"]);
		echo "<option value=\"" . $directory . "\">" . $title . " (" . $count . ")</option>";
	}
?>
					</select>
				</section>
				<section>
					<label for="DownloadAdmin">管理员密码：</label>
					<input type="password" name="DownloadAdmin" id="DownloadAdmin" />
				</section>
				<section style="text-align: center;">
					<input type="submit" />
				</section>
			</form>
			<h4>修改信息</h4>
			<form action="modify.php" method="post" enctype="multipart/form-data">
				<section style="text-align: center;">
					<input type="radio" name="Mode" id="Insert" value="Insert" />
					<label for="insert">新建</label>
					<input type="radio" name="Mode" id="Delete" value="Delete" />
					<label for="Dele">删除</label>
					<br />
					<input type="radio" name="Target" id="Students" value="students" />
					<label for="Students">学生</label>
					<input type="radio" name="Target" id="Homeworks" value="homeworks" />
					<label for="Homeworks">作业</label>
				</section>
				<section>
					<label for="First">作业内容/学生姓名：</label>
					<input type="text" name="First" id="First" />
				</section>
				<section>
					<label for="Second">作业目录/学生学号：</label>
					<input type="text" name="Second" id="Second" />
				</section>
				<section>
					<label for="ModifyAdmin">管理员密码：</label>
					<input type="password" name="ModifyAdmin" id="ModifyAdmin" />
				</section>
				<section style="text-align: center;">
					<input type="submit" />
				</section>
			</form>
		</main>
	</body>
</html>
