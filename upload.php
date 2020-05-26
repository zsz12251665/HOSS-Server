<?php
	$studentName = htmlspecialchars($_POST["StuName"], ENT_QUOTES);
	$studentNumber = htmlspecialchars($_POST["StuNumber"], ENT_QUOTES);
	$workTitle = htmlspecialchars($_POST["WorkTitle"], ENT_QUOTES);
	require "sql.php";
	// If the student is in the database
	if (!selectInMysql("students", array("name" => $studentName, "number" => $studentNumber)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $studentName . " (" . $studentNumber . ") is not our student! ");
	}
	// If failed to receive the file
	if (!$_FILES["WorkFile"] || $_FILES["WorkFile"]["error"])
	{
		header("HTTP/1.1 400 Bad Request");
		die("File Error: " . ($_FILES["WorkFile"] ? $_FILES["WorkFile"]["error"] : "No such file! "));
	}
	// If the upload date is later than the deadline
	if (strtotime(selectInMysql("homeworks", array("directory" => $workTitle))[0]["deadline"] . " 23:59:59") < time())
	{
		header("HTTP/1.1 409 Conflict");
		die("The homework is out of date! Server date: " . date("Y-m-d"));
	}
	require "local.php";
	// Create the directory if haven't
	if (!file_exists($upload_directory . $workTitle . "/"))
	{
		mkdir($upload_directory . $workTitle . "/", 0777);
	}
	// Remove the existing file
	foreach (scandir($upload_directory . $workTitle . "/") as $fileName)
	{
		if (pathinfo($fileName, PATHINFO_FILENAME) == $studentNumber . "-" . $studentName)
		{
			unlink($upload_directory . $workTitle . "/" . $fileName);
		}
	}
	// Save the file
	$savingLocation = $upload_directory . $workTitle . "/" . $studentNumber . "-" . $studentName . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation))
	{
		header("HTTP/1.1 200 OK");
		echo "Upload successfully! ";
	}
	else
	{
		header("HTTP/1.1 500 Internal Server Error");
		die("Failed to save " . $_FILES["WorkFile"]["name"] . "! Please try again! ");
	}
?>
