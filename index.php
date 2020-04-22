<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<!-- <link rel="shortcut icon" href="/favicon.ico" /> -->
		<title>SCUT 2019计科全英联合班作业提交系统</title>
		<style type="text/css">
body
{
	height: 100vh;
	margin: 0;
	display: flex;
	flex-direction: column;
	align-items: center;
}
header, footer
{
	flex-grow: 1;
}
section
{
	margin: 0.5em;
}
input{
	border: 1px solid #ccc;
	padding: 7px 0px;
	border-radius: 3px;
	padding-left:5px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
	-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s
}
input:focus{
	border-color: #66afe9;
	outline: 0;
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)
}
		</style>
	</head>
	<body background="img/background.png">
		<header></header>
		<main>
			<h1 align="center">SCUT 2019计科全英联合班作业提交系统</h1>
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
		echo "<option value=\"" . htmlspecialchars($homework["directory"] ? $homework["directory"] : $homework["title"]) . "\">" . htmlspecialchars($homework["title"]) . "</option>";
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
		<footer></footer>
	</body>
</html>
