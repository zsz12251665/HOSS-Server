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
<?php
	echo "<p>系统仍在施工中！！！</p>";
	// echo "<p>StuName: " . $_POST["StuName"] . "</p>";
	// echo "<p>StuNumber: " . $_POST["StuNumber"] . "</p>";
	// echo "<p>WorkTitle: " . $_POST["WorkTitle"] . "</p>";
	require "sql.php";
	if (!isStudent($_POST["StuName"], $_POST["StuNumber"]))
	{
		die("<p>" . $_POST["StuName"] . " (" . $_POST["StuNumber"] . ") is not our student! </p>");
	}
	if($_FILES["WorkFile"]["error"])
	{
		die("<p>Error: " . $_FILES["WorkFile"]["error"] . "</p>");
	}
	else
	{
		// echo "<p>Upload: " . $_FILES["WorkFile"]["name"] . "</p>";
		// echo "<p>Size: " . $_FILES["WorkFile"]["size"] . " Byte(s)</p>";
		require "local.php";
		if (!file_exists($upload_directory . $_POST["WorkTitle"] . "/"))
		{
			mkdir($upload_directory . $_POST["WorkTitle"] . "/", 0777);
		}
		$fileList = scandir($upload_directory . $_POST["WorkTitle"] . "/");
		foreach ($fileList as $fileName)// Remove the existing file
		{
			if (pathinfo($fileName, PATHINFO_FILENAME) == $_POST["StuNumber"] . "-" . $_POST["StuName"])
			{
				unlink($upload_directory . $_POST["WorkTitle"] . "/" . $fileName);
			}
		}
		$savingLocation = $upload_directory . $_POST["WorkTitle"] . "/" . $_POST["StuNumber"] . "-" . $_POST["StuName"] . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
		if(move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation))
		{
			echo "<p>Upload successfully! </p>";
		}
	}
?>
		</main>
	</body>
</html>
