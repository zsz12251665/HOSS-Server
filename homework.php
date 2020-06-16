<?php
	$studentName = htmlspecialchars($_POST["StuName"], ENT_QUOTES);
	$studentNumber = htmlspecialchars($_POST["StuNumber"], ENT_QUOTES);
	require "sql.php";
	// If the student is in the database
	if ($studentName && $studentNumber && !selectInMysql("students", array("name" => $studentName, "number" => $studentNumber)))
	{
		header("HTTP/1.1 403 Forbidden");
		die("Authorization Error: " . $studentName . " (" . $studentNumber . ") is not our student! ");
	}
	// Get the list from MySQL database
	$homeworkList = array_reverse(selectInMysql("homeworks"));
	// Get the number of homeworks submitted
	foreach ($homeworkList as &$homework)
	{
		require "local.php";
		if (!$homework["directory"])
		{
			$homework["directory"] = $homework["title"];
		}
		$localDirectory = $upload_directory . $homework["directory"] . "/";
		$fileList = (file_exists($localDirectory) && is_dir($localDirectory)) ? scandir($localDirectory) : array(".", "..");
		$homework["count"] = count($fileList) - 2;
		if ($studentName && $studentNumber)
		{
			$filename = $studentNumber . "-" . $studentName;
			$homework["isSubmitted"] = false;
			foreach ($fileList as $file)
			{
				if (strpos($file, $filename) === 0)
				{
					$homework["isSubmitted"] = true;
					break;
				}
			}
		}
	}
	// Output the information in JSON
	if ($studentName && $studentNumber)
	{
		header("HTTP/1.1 200 OK");
	}
	else
	{
		header("HTTP/1.1 203 Non-Authoritative Information");
	}
	die(json_encode($homeworkList));
?>
