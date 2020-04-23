<?php
	if (!$_POST["Admin"] && !$_POST["WorkTitle"])
		return;
	require "local.php";
	if ($_POST["Admin"] != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	if (!is_dir($upload_directory . $_POST["WorkTitle"] . "/"))
	{
		header("HTTP/1.1 400 Bad Request");
		die("Wrong directory: " . $_POST["WorkTitle"]);
	}
	$zipPath = $upload_directory . $_POST["WorkTitle"] . ".zip";
	$zip = new ZipArchive;
	if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE)
	{
		$fileList = scandir($upload_directory . $_POST["WorkTitle"] . "/");
		foreach ($fileList as $fileName)
		{
			$filePath = $upload_directory . $_POST["WorkTitle"] . "/" . $fileName;
			if ($fileName != "." && fileName!= ".." && !is_dir($filePath))
			{
				$zip->addFile($filePath, $fileName);
			}
		}
		$zip->close();
		header("Cache-Control: no-store");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . pathinfo($zipPath,PATHINFO_BASENAME));
		header("Content-Length: " . filesize($zipPath));
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: application/zip");
		readfile($zipPath);
	}
	else
	{
		header("HTTP/1.1 500 Internal Server Error");
		die("Fail zip: ZipArchive failure! ");
	}
	unlink($zipPath);
	die();
?>
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
			<form action="download.php" method="post" enctype="multipart/form-data">
				<section>
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option value="Default" selected="selected">--请选择要下载的作业--</option>
<?php
	require "sql.php";
	foreach (array_reverse($GLOBALS["homeworkList"]) as $homework)
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
