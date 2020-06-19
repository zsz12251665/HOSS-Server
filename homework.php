<?php
	$name = htmlspecialchars($_POST["Name"], ENT_QUOTES);
	$number = htmlspecialchars($_POST["Number"], ENT_QUOTES);
	require "sql.php";
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
		$fileList = file_exists($localDirectory) && is_dir($localDirectory) ? scandir($localDirectory) : array(".", "..");
		$homework["count"] = count($fileList) - 2;
		$homework["checked"] = false;
		if ($name && $number && $homework["count"] > 0)
		{
			foreach ($fileList as $filename)
			{
				if (strpos($filename, $number . "-" . $name) === 0)
				{
					$homework["checked"] = true;
					break;
				}
			}
		}
	}
	// Output the information in JSON
	header("HTTP/1.1 200 OK");
	die(json_encode($homeworkList));
?>
