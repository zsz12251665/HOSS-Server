<?php
	$studentName = htmlspecialchars($_POST["StuName"], ENT_QUOTES);
	$studentNumber = htmlspecialchars($_POST["StuNumber"], ENT_QUOTES);
	$workTitle = htmlspecialchars($_POST["WorkTitle"], ENT_QUOTES);
	require "sql.php";
	if (!selectInMysql("students", array("name" => $studentName, "number" => $studentNumber)))// If the student is in the database
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $studentName . " (" . $studentNumber . ") is not our student! ");
	}
	if (!$_FILES["WorkFile"] || $_FILES["WorkFile"]["error"])// If failed to receive the file
	{
		header("HTTP/1.1 400 Bad Request");
		die("File Error: " . ($_FILES["WorkFile"] ? $_FILES["WorkFile"]["error"] : "No such file! "));
	}
	if (strtotime(selectInMysql("homeworks", array("title" => $workTitle))[0].deadline) < time())// If the upload date is later than the deadline
	{
		header("HTTP/1.1 409 Conflict");
		die("The homework is out of date! Server date: " . date("Y-m-d"));
	}
	require "local.php";
	if (!file_exists($upload_directory . $workTitle . "/"))// Create the directory if haven't
	{
		mkdir($upload_directory . $workTitle . "/", 0777);
	}
	foreach (scandir($upload_directory . $workTitle . "/") as $fileName)// Remove the existing file
	{
		if (pathinfo($fileName, PATHINFO_FILENAME) == $studentNumber . "-" . $studentName)
		{
			unlink($upload_directory . $workTitle . "/" . $fileName);
		}
	}
	$savingLocation = $upload_directory . $workTitle . "/" . $studentNumber . "-" . $studentName . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation))// Save the file
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
