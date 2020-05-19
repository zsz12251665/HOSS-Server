<?php
	require "local.php";
	if ($_POST["ModifyAdmin"] != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	require "sql.php";
	$entry = array();
	switch ($_POST["Target"])
	{
		case 'homeworks':
			if (!$_POST["First"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty homework title! ");
			}
			$entry = array("title" => $_POST["First"], "directory" => $_POST["Second"]);
			break;
		case 'students':
			if (!$_POST["First"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty student name! ");
			}
			if (!$_POST["Second"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty student number! ");
			}
			$entry = array("name" => $_POST["First"], "number" => $_POST["Second"]);
			break;
		default:
			header("HTTP/1.1 400 Bad Request");
			die("Unable to understand target: " . $_POST["Target"]);
	}
	switch ($_POST["Mode"])
	{
		case "Insert":
			if (matchingEntry($_POST["Target"], $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry exists: (" . $_POST["First"] . ", " . $_POST["Second"] . ") in " . $_POST["Target"]);
			}
			$status = insertIntoMysql($_POST["Target"], $entry);
			$errorMessage = "Failed to insert (" . $_POST["First"] . ", " . $_POST["Second"] . ") into " . $_POST["Target"];
			break;
		case "Delete":
			if (!matchingEntry($_POST["Target"], $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry doesn't exist: (" . $_POST["First"] . ", " . $_POST["Second"] . ") in " . $_POST["Target"]);
			}
			$status = deleteFromMysql($_POST["Target"], $entry);
			$errorMessage = "Failed to delete (" . $_POST["First"] . ", " . $_POST["Second"] . ") from " . $_POST["Target"];
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
