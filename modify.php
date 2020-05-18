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
			if (isHomework($_POST["First"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Homework exists: " . $_POST["First"]);
			}
			if (!$_POST["First"])
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty homework title! ");
			}
			$status = insertIntoMysql("homeworks", "title", "directory", $_POST["First"], $_POST["First"]);
			$errorMessage = "Failed to insert (" . $_POST["First"] . ") into homeworks";
			break;
		case "DelWork":
			if (!isHomework($_POST["First"]))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Homework doesn't exist: " . $_POST["First"]);
			}
			$status = deleteFromMysql("homeworks", "title", "directory", $_POST["First"], $_POST["First"]);
			$errorMessage = "Failed to delete (" . $_POST["First"] .  ") from homeworks";
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
