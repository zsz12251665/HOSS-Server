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
	// If there is no such homework
	if (!selectInMysql("homeworks", array("directory" => $workTitle)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("No such homework: \"" . $workTitle . "\" does not exists! ");
	}
	require "local.php";
	$localDirectory = $upload_directory . $workTitle . "/";
	$fileList = (file_exists($localDirectory) && is_dir($localDirectory)) ? scandir($localDirectory) : array();
	$filename = $studentNumber . "-" . $studentName;
	foreach ($fileList as $file)
	{
		if (strpos($file, $filename) === 0)
		{
			header("HTTP/1.1 200 OK");
			die($studentName . " (" . $studentNumber . ") has submit the homework \"" . $workTitle . "\": " . $file);
		}
	}
	header("HTTP/1.1 500 Internal Server Error");
	die($studentName . " (" . $studentNumber . ") has not submit the homework \"" . $workTitle . "\" yet. ");
?>
