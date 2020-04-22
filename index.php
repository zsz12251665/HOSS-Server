<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<!-- <link rel="shortcut icon" href="/favicon.ico" /> -->
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<title>SCUT 2019计科全英联合班作业提交系统</title>
	</head>
	<body>
		<main>
			<h1>SCUT 2019计科全英联合班作业提交系统</h1>
			<form action="upload.php" method="post" enctype="multipart/form-data">
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
				</section>
			</form>
		</main>
	</body>
</html>
