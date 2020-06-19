<?php
	$name = htmlspecialchars($_POST["Name"], ENT_QUOTES);
	$number = htmlspecialchars($_POST["Number"], ENT_QUOTES);
	$directory = htmlspecialchars($_POST["Directory"], ENT_QUOTES);
	require "sql.php";
	// If the student is in the database
	if (!selectInMysql("students", array("name" => $name, "number" => $number)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $name . " (" . $number . ") is not our student! ");
	}
	// If there is no such homework
	if (!selectInMysql("homeworks", array("directory" => $directory)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("No such homework: " . $directory . "does not exists! ");
	}
	// If failed to receive the file
	if (!$_FILES["File"] || $_FILES["File"]["error"])
	{
		header("HTTP/1.1 400 Bad Request");
		die("File Error: " . ($_FILES["File"] ? $_FILES["File"]["error"] : "No such file! "));
	}
	// If the upload date is later than the deadline
	if (strtotime(selectInMysql("homeworks", array("directory" => $directory))[0]["deadline"] . " 23:59:59") < time())
	{
		header("HTTP/1.1 409 Conflict");
		die("The homework is out of date! Server date: " . date("Y-m-d"));
	}
	require "local.php";
	// Create the directory if haven't
	if (!file_exists($upload_directory . $directory . "/"))
	{
		mkdir($upload_directory . $directory . "/", 0777);
	}
	// Remove the existing file
	foreach (scandir($upload_directory . $directory . "/") as $fileName)
	{
		if (pathinfo($fileName, PATHINFO_FILENAME) == $number . "-" . $name)
		{
			unlink($upload_directory . $directory . "/" . $fileName);
		}
	}
	// Save the file
	$savingLocation = $upload_directory . $directory . "/" . $number . "-" . $name . "." . strtolower(pathinfo($_FILES["File"]["name"], PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["File"]["tmp_name"], $savingLocation))
	{
		header("HTTP/1.1 200 OK");
		die("Upload successfully! ");
	}
	else
	{
		header("HTTP/1.1 500 Internal Server Error");
		die("Failed to save " . $_FILES["File"]["name"] . "! Please try again! ");
	}
?>
