<?php
	require "local.php";
	if ($_POST["ModifyAdmin"] != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	require "sql.php";
	switch ($_POST["Mode"]) {
		case "NewWork":
			if (isHomework($_POST["First"], $_POST["Second"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Homework exists: " . $_POST["First"] . " (" . $_POST["Second"] . ")");
			}
			if (!$_POST["First"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty homework title! ");
			}
			$status = insertIntoMysql("homeworks", "title", "directory", $_POST["First"], $_POST["Second"]);
			$errorMessage = "Failed to insert (" . $_POST["First"] . ", " . $_POST["Second"] . ") into homeworks";
			break;
		case "DelWork":
			if (!isHomework($_POST["First"], $_POST["Second"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Homework doesn't exist: " . $_POST["First"] . " (" . $_POST["Second"] . ")");
			}
			$status = deleteFromMysql("homeworks", "title", "directory", $_POST["First"], $_POST["Second"]);
			$errorMessage = "Failed to delete (" . $_POST["First"] . ", " . $_POST["Second"] . ") from homeworks";
			break;
		case "NewStu":
			if (isStudent($_POST["First"], $_POST["Second"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Student exists: " . $_POST["First"] . " (" . $_POST["Second"] . ")");
			}
			if (!$_POST["First"] || !$_POST["Second"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Lack of student name or student number! ");
			}
			$status = insertIntoMysql("students", "name", "number", $_POST["First"], $_POST["Second"]);
			$errorMessage = "Failed to insert (" . $_POST["First"] . ", " . $_POST["Second"] . ") into students";
			break;
		case "DelStu":
			if (!isStudent($_POST["First"], $_POST["Second"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Student doesn't exist: " . $_POST["First"] . " (" . $_POST["Second"] . ")");
			}
			$status = deleteFromMysql("students", "name", "number", $_POST["First"], $_POST["Second"]);
			$errorMessage = "Failed to remove (" . $_POST["First"] . ", " . $_POST["Second"] . ") from students";
			break;
		default:
			header("HTTP/1.1 400 Bad Request");
			die("Unable to understand mode: " . $_POST["Mode"]);
	}
	if ($status === TRUE)
	{
		header("HTTP/1.1 200 OK");
		die("Modify Successful! ");
	}
	else
	{
		header("HTTP/1.1 500 Internal Server Error");
		die($errorMessage);
	}
?>
