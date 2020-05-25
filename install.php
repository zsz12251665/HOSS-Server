<?php
	// Check if installed
	if (file_exists("local.php"))
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ./");
		die();
	}
	// The form Submitted
	if ($_POST["admin_password"] && $_POST["mysql_server"] && $_POST["mysql_database"] &&$_POST["mysql_username"] && $_POST["mysql_password"] && $_POST["upload_directory"] && $_POST["website_title"])
	{
		$admin_password = htmlspecialchars($_POST["admin_password"]);
		$mysql_server = htmlspecialchars($_POST["mysql_server"]);
		$mysql_database = htmlspecialchars($_POST["mysql_database"]);
		$mysql_username = htmlspecialchars($_POST["mysql_username"]);
		$mysql_password = htmlspecialchars($_POST["mysql_password"]);
		$upload_directory = htmlspecialchars($_POST["upload_directory"]);
		$website_title = htmlspecialchars($_POST["website_title"]);
		// Validate if the path is valid
		if (substr($upload_directory, -1) != "/")
		{
			$upload_directory = $upload_directory . "/";
		}
		if (!file_exists($upload_directory) || !is_dir($upload_directory))
		{
			header("HTTP/1.1 400 Bad Request");
			die("The upload directory does not exists or it is not a directory!\n Location: " . $upload_directory);
		}
		// Validate and initialize the MySQL database
		try
		{
			$mysqlConnection = new mysqli($mysql_server, $mysql_username, $mysql_password);
			if ($mysqlConnection->connect_error)
			{
				throw new Exception("Could not connect to MySQL server! \nError: " . $mysqlConnection->connect_error);
			}
			if (!$mysqlConnection->query("CREATE DATABASE " . $mysql_database) || $mysqlConnection->error)
			{
				throw new Exception("Could not create MySQL database! \nError: " . $mysqlConnection->error);
			}
			if (!$mysqlConnection->select_db($mysql_database) || $mysqlConnection->error)
			{
				throw new Exception("Could not select MySQL database! \nError: " . $mysqlConnection->error);
			}
			if (!$mysqlConnection->query("CREATE TABLE students (name VARCHAR(255), number VARCHAR(255))") || $mysqlConnection->error)
			{
				throw new Exception("Could not create data sheet \"students\"! \nError: " . $mysqlConnection->error);
			}
			if (!$mysqlConnection->query("CREATE TABLE homeworks (title VARCHAR(255), directory VARCHAR(255), deadline VARCHAR(255))") || $mysqlConnection->error)
			{
				throw new Exception("Could not create data sheet \"homeworks\"! \nError: " . $mysqlConnection->error);
			}
			$mysqlConnection->close();
		}
		catch (Exception $err)
		{
			header("HTTP/1.1 500 Internal Server Error");
			die($err->getMessage());
		}
		// Save the configuration into "local.php"
		$local = fopen("local.php", "w");
		fwrite($local, "<?php\n");
		fwrite($local, "\t\$admin_password = \"" . $admin_password . "\";\n");
		fwrite($local, "\t\$mysql_server = \"" . $mysql_server . "\";\n");
		fwrite($local, "\t\$mysql_database = \"" . $mysql_database . "\";\n");
		fwrite($local, "\t\$mysql_username = \"" . $mysql_username . "\";\n");
		fwrite($local, "\t\$mysql_password = \"" . $mysql_password . "\";\n");
		fwrite($local, "\t\$upload_directory = \"" . $upload_directory . "\";\n");
		fwrite($local, "\t\$website_title = \"" . $website_title . "\";\n");
		fwrite($local, "?>\n");
		fclose($local);
		// Jump to the home page
		header("HTTP/1.1 302 Found");
		header("Location: ./");
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
		<title>快速配置您的HOSS-Server</title>
	</head>
	<body>
		<main>
			<header>
				<h1>快速配置您的HOSS-Server</h1>
			</header>
			<p>欢迎使用HOSS-Server作业收集系统，请填写下方表单以快速配置并启用系统。</p>
			<form action="install.php" method="post" enctype="multipart/form-data">
				<section>
					<label for="admin_password">管理员密码（用于修改信息/下载作业等操作）：</label>
					<input type="password" name="admin_password" id="admin_password" placeholder="Admin Password" />
				</section>
				<section>
					<label for="mysql_server">MySQL服务器地址：</label>
					<input type="text" name="mysql_server" id="mysql_server" placeholder="MySQL Server" />
				</section>
				<section>
					<label for="mysql_database">MySQL数据库名（请提供一个空闲的数据库名）：</label>
					<input type="text" name="mysql_database" id="mysql_database" placeholder="MySQL Database" />
				</section>
				<section>
					<label for="mysql_username">MySQL服务器用户名：</label>
					<input type="text" name="mysql_username" id="mysql_username" placeholder="MySQL Username" />
				</section>
				<section>
					<label for="mysql_password">MySQL服务器密码：</label>
					<input type="password" name="mysql_password" id="mysql_password" placeholder="MySQL Password" />
				</section>
				<section>
					<label for="upload_directory">上传目录（暂不支持Windows路径，用于存放作业）：</label>
					<input type="text" name="upload_directory" id="upload_directory" placeholder="Upload Directory" />
				</section>
				<section>
					<label for="website_title">网站标题：</label>
					<input type="text" name="website_title" id="website_title" placeholder="Website Title" />
				</section>
				<section style="text-align: center;">
					<input type="submit" />
				</section>
			</form>
			<footer>&copy; 2020 <a href="https://github.com/whaohan">whaohan</a> &amp; <a href="https://github.com/zsz12251665">zsz12251665</a>. All rights reserved. </footer>
		</main>
	</body>
</html>
