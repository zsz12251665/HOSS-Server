<?php
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
		$homework["count"] = (file_exists($localDirectory) && is_dir($localDirectory)) ? count(scandir($localDirectory)) - 2 : 0;
	}
	// Output the information in JSON
	echo json_encode($homeworkList);
?>
