<?php
	require "mysql_loginfo.php";// $mysqlConnection = mysqli_connect("localhost", [mysql_username], [mysql_password]);
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
