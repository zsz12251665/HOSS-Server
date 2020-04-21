<?php
	require "local.php";
	$mysqlConnection = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
	if (!$mysqlConnection)
	{
		die("Could not connect! " . mysqli_error($mysqlConnection));
	}
	mysqli_select_db($mysqlConnection, "homework");
	$mysqlResult = mysqli_query($mysqlConnection, "SELECT * FROM students");
	$GLOBALS["studentList"] = array();
	while ($row = mysqli_fetch_array($mysqlResult))
	{
		$GLOBALS["studentList"][] = $row;
	}
	// foreach ($GLOBALS["studentList"] as $student)
	// 	echo $student["name"] . $student["number"] . "<br />";
	$mysqlResult = mysqli_query($mysqlConnection, "SELECT * FROM homeworks");
	$GLOBALS["homeworkList"] = array();
	while ($row = mysqli_fetch_array($mysqlResult))
	{
		$GLOBALS["homeworkList"][] = $row;
	}
	// foreach ($GLOBALS["homeworkList"] as $homework)
	// 	echo $homework["title"] . " " . $homework["directory"] . "<br />";
	mysqli_close($mysqlConnection);
	function isStudent($name, $number)
	{
		foreach ($GLOBALS["studentList"] as $student)
		{
			if (($student["name"] == $name) && ($student["number"] == $number))
			{
				return true;
			}
		}
		return false;
	}
?>
