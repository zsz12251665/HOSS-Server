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
			<form action="download.php" method="post" enctype="multipart/form-data">
				<section style="text-align: center;">
					<input type="radio" name="Mode" id="Insert" value="Insert" checked="checked" />
					<label for="Insert">新建</label>
					<input type="radio" name="Mode" id="Delete" value="Delete" />
					<label for="Delete">删除</label>
					<input type="radio" name="Mode" id="Download" value="Download" />
					<label for="Download">下载</label>
				</section>
				<section class="insert delete" style="text-align: center;">
					<input type="radio" name="Target" id="Students" value="students" />
					<label for="Students">学生</label>
					<input type="radio" name="Target" id="Homeworks" value="homeworks" checked="checked" />
					<label for="Homeworks">作业</label>
				</section>
				<section class="insert delete students">
					<label for="First">作业内容/学生姓名：</label>
					<input type="text" name="First" id="First" />
				</section>
				<section class="insert delete students">
					<label for="Second">作业目录/学生学号：</label>
					<input type="text" name="Second" id="Second" />
				</section>
				<section class="delete download homeworks" style="display: none;">
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option id="Default" value="Default" selected="selected">--请选择要下载的作业--</option>
					</select>
				</section>
				<section>
					<label for="Password">管理员密码：</label>
					<input type="password" name="Password" id="Password" />
				</section>
				<section style="text-align: center;">
					<input type="submit" />
				</section>
			</form>
		</main>
		<script type="text/javascript" src="/js/admin.js"></script>
	</body>
</html>
