<?php
	require "sql.php";
	$homeworkList = array_reverse(selectInMysql("homeworks"));
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
	echo json_encode($homeworkList);
?>
