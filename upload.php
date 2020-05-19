<?php
	$studentName = htmlspecialchars($_POST["StuName"], ENT_QUOTES);
	$studentNumber = htmlspecialchars($_POST["StuNumber"], ENT_QUOTES);
	$workTitle = htmlspecialchars($_POST["WorkTitle"], ENT_QUOTES);
	// echo "StuName: " . $studentName;
	// echo "StuNumber: " . $studentNumber;
	// echo "WorkTitle: " . $workTitle;
	require "sql.php";
	if (!selectInMysql("students", array("name" => $studentName, "number" => $studentNumber)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $studentName . " (" . $studentNumber . ") is not our student! ");
	}
	if (!$_FILES["WorkFile"] || $_FILES["WorkFile"]["error"])
	{
		header("HTTP/1.1 400 Bad Request");
		die("File Error: " . ($_FILES["WorkFile"] ? $_FILES["WorkFile"]["error"] : "No such file! "));
	}
	else
	{
		// echo "Upload: " . $_FILES["WorkFile"]["name"];
		// echo "Size: " . $_FILES["WorkFile"]["size"] . " Byte(s)";
		require "local.php";
		if (!file_exists($upload_directory . $workTitle . "/"))
		{
			mkdir($upload_directory . $workTitle . "/", 0777);
		}
		$fileList = scandir($upload_directory . $workTitle . "/");
		foreach ($fileList as $fileName)// Remove the existing file
		{
			if (pathinfo($fileName, PATHINFO_FILENAME) == $studentNumber . "-" . $studentName)
			{
				unlink($upload_directory . $workTitle . "/" . $fileName);
			}
		}
		$savingLocation = $upload_directory . $workTitle . "/" . $studentNumber . "-" . $studentName . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
		if (move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation))
		{
			header("HTTP/1.1 200 OK");
			echo "Upload successfully! ";
		}
	}
?>
