<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<title>SCUT 2019计科全英联合班作业提交系统</title>
	</head>
	<body>
		<main>
			<h1>SCUT 2019计科全英联合班作业提交系统</h1>
			<form action="modify_form.php" method="post" enctype="multipart/form-data">
				<section style="text-align: center;">
					<input type="radio" name="Mode" id="NewWork" value="NewWork" />
					<label for="NewWork">新建作业</label>
					<input type="radio" name="Mode" id="DelWork" value="DelWork" />
					<label for="DelWork">删除作业</label>
					<br />
					<input type="radio" name="Mode" id="NewStu" value="NewStu" />
					<label for="NewStu">新建学生</label>
					<input type="radio" name="Mode" id="DelStu" value="DelStu" />
					<label for="DelStu">删除学生</label>
				</section>
				<section>
					<label for="WorkTitle">作业内容：</label>
					<input type="text" name="WorkTitle" id="WorkTitle" />
				</section>
				<section>
					<label for="WorkDirectory">作业目录：</label>
					<input type="text" name="WorkDirectory" id="WorkDirectory" />
				</section>
				<section>
					<label for="StuName">学生姓名：</label>
					<input type="text" name="StuName" id="StuName" />
				</section>
				<section>
					<label for="StuNumber">学生学号：</label>
					<input type="text" name="StuNumber" id="StuNumber" />
				</section>
				<section>
					<label for="Admin">管理员密码：</label>
					<input type="password" name="Admin" id="Admin" />
				</section>
				<section style="text-align: center;">
					<input type="submit" name="Submit" id="Submit" />
				</section>
			</form>
		</main>
	</body>
</html>
