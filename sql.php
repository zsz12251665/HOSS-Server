<?php
	$mysqlConnection = connectAndSelect();
	$GLOBALS["studentList"] = queryToArray($mysqlConnection, "SELECT * FROM students");
	// foreach ($GLOBALS["studentList"] as $student)
	// 	echo "<p>" . $student["name"] . $student["number"] . "</p>";
	$GLOBALS["homeworkList"] = queryToArray($mysqlConnection, "SELECT * FROM homeworks");
	// foreach ($GLOBALS["homeworkList"] as $homework)
	// 	echo "<p>" . $homework["title"] . " " . $homework["directory"] . "</p>";
	$mysqlConnection->close();
	function connectAndSelect()
	{
		require "local.php";
		$mysqlConnection = new mysqli($mysql_server, $mysql_username, $mysql_password, "homework");
		if ($mysqlConnection->connect_error)
		{
			die("<p>Could not connect! " . $mysqlConnection->connect_error . "</p>");
		}
		return $mysqlConnection;
	}
	function queryToArray($mysqlConnection, $queryString)
	{
		$mysqlResult = $mysqlConnection->query($queryString);
		$answer = array();
		while ($row = $mysqlResult->fetch_array())
		{
			$answer[] = $row;
		}
		$mysqlResult->free();
		return $answer;
	}
	function insertIntoMysql($table, $title1, $title2, $value1, $value2)
	{
		$mysqlConnection = connectAndSelect();
		$answer = $mysqlConnection->query("INSERT INTO $table ($title1, $title2) VALUES (\"$value1\",\"$value2\")");
		$mysqlConnection->close();
		return $answer;
	}
	function deleteFromMysql($table, $title1, $title2, $value1, $value2)
	{
		$mysqlConnection = connectAndSelect();
		$answer = $mysqlConnection->query("DELETE FROM $table WHERE $title1 = \"$value1\" AND $title2 = \"$value2\"");
		$mysqlConnection->close();
		return $answer;
	}
	function isHomework($title, $directory)
	{
		foreach ($GLOBALS["homeworkList"] as $homework)
		{
			if (($homework["title"] == $title))
				return true;
		}
		return false;
	}
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
