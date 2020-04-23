<?php
	require "local.php";
	if ($_POST["Admin"] != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	require "sql.php";
	if ($_POST["Mode"] == "NewWork")
	{
		if (isHomework($_POST["WorkTitle"], $_POST["WorkDirectory"]))
		{
			header("HTTP/1.1 400 Bad Request");
			die("Homework exists: " . $_POST["WorkTitle"] . " (" . $_POST["WorkDirectory"] . ")");
		}
		if (!$_POST["WorkTitle"])
		{
			header("HTTP/1.1 400 Bad Request");
			die("Empty homework title! ");
		}
		if (insertIntoMysql("homeworks", "title", "directory", $_POST["WorkTitle"], $_POST["WorkDirectory"]) === TRUE)
		{
			header("HTTP/1.1 200 OK");
			die("Modify Successful! ");
		}
		else
		{
			header("HTTP/1.1 500 Internal Server Error");
			die("Failed to insert (" . $_POST["WorkTitle"] . ", " . $_POST["WorkDirectory"] . ") into homeworks");
		}
	}
	if ($_POST["Mode"] == "DelWork")
	{
		if (!isHomework($_POST["WorkTitle"], $_POST["WorkDirectory"]))
		{
			header("HTTP/1.1 400 Bad Request");
			die("Homework doesn't exist: " . $_POST["WorkTitle"] . " (" . $_POST["WorkDirectory"] . ")");
		}
		if (deleteFromMysql("homeworks", "title", "directory", $_POST["WorkTitle"], $_POST["WorkDirectory"]) === TRUE)
		{
			header("HTTP/1.1 200 OK");
			die("Modify Successful! ");
		}
		else
		{
			header("HTTP/1.1 500 Internal Server Error");
			die("Failed to remove (" . $_POST["WorkTitle"] . ", " . $_POST["WorkDirectory"] . ") from homeworks");
		}
	}
	if ($_POST["Mode"] == "NewStu")
	{
		if (isStudent($_POST["StuName"], $_POST["StuNumber"]))
		{
			header("HTTP/1.1 400 Bad Request");
			die("Student exists: " . $_POST["StuName"] . " (" . $_POST["StuNumber"] . ")");
		}
		if (!$_POST["StuName"] || !$_POST["StuNumber"])
		{
			header("HTTP/1.1 400 Bad Request");
			die("Lack of student name or student number! ");
		}
		if (insertIntoMysql("students", "name", "number", $_POST["StuName"], $_POST["StuNumber"]) === TRUE)
		{
			header("HTTP/1.1 200 OK");
			die("Modify Successful! ");
		}
		else
		{
			header("HTTP/1.1 500 Internal Server Error");
			die("Failed to insert (" . $_POST["StuName"] . ", " . $_POST["StuNumber"] . ") into students");
		}
	}
	if ($_POST["Mode"] == "DelStu")
	{
		if (!isStudent($_POST["StuName"], $_POST["StuNumber"]))
		{
			header("HTTP/1.1 400 Bad Request");
			die("Student doesn't exist: " . $_POST["StuName"] . " (" . $_POST["StuNumber"] . ")");
		}
		if (deleteFromMysql("students", "name", "number", $_POST["StuName"], $_POST["StuNumber"]) === TRUE)
		{
			header("HTTP/1.1 200 OK");
			die("Modify Successful! ");
		}
		else
		{
			header("HTTP/1.1 500 Internal Server Error");
			die("Failed to remove (" . $_POST["StuName"] . ", " . $_POST["StuNumber"] . ") from students");
		}
	}
	header("HTTP/1.1 400 Bad Request");
	die("Unable to understand mode: " . $_POST["Mode"]);
?>
