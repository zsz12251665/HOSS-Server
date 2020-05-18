<?php
	// echo "StuName: " . $_POST["StuName"];
	// echo "StuNumber: " . $_POST["StuNumber"];
	// echo "WorkTitle: " . $_POST["WorkTitle"];
	require "sql.php";
	if (!isStudent($_POST["StuName"], $_POST["StuNumber"]))
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $_POST["StuName"] . " (" . $_POST["StuNumber"] . ") is not our student! ");
	}
	if(!$_FILES["WorkFile"] || $_FILES["WorkFile"]["error"])
	{
		header("HTTP/1.1 400 Bad Request");
		die("File Error: " . ($_FILES["WorkFile"] ? $_FILES["WorkFile"]["error"] : "No such file! "));
	}
	else
	{
		// echo "Upload: " . $_FILES["WorkFile"]["name"];
		// echo "Size: " . $_FILES["WorkFile"]["size"] . " Byte(s)";
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
			header("HTTP/1.1 200 OK");
			echo "Upload successfully! ";
		}
	}
?>
