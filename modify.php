<?php
	$password = htmlspecialchars($_POST["Password"], ENT_QUOTES);
	$target = htmlspecialchars($_POST["Target"], ENT_QUOTES);
	$mode = htmlspecialchars($_POST["Mode"], ENT_QUOTES);
	require "local.php";
	if ($password != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	require "sql.php";
	$entry = array();
	switch ($target)
	{
		case 'homeworks':
			$title = htmlspecialchars($_POST["Title"], ENT_QUOTES);
			$directory = htmlspecialchars($_POST["Directory"], ENT_QUOTES);
			$deadline = htmlspecialchars($_POST["Deadline"], ENT_QUOTES);
			if (!$title)
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty homework title! ");
			}
			if (!$directory)
			{
				$directory = $title;
			}
			if (preg_match("/[\\\/:*?\"<>|]/", $directory))
			{
				header("HTTP/1.1 400 Bad Request");
				die("invalid directory name: " . $directory);
			}
			if (!strtotime($deadline))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Invalid deadline: " . $deadline);
			}
			$entry = array("title" => $title, "directory" => $directory, "deadline" => $deadline);
			break;
		case 'students':
			$name = htmlspecialchars($_POST["Name"], ENT_QUOTES);
			$number = htmlspecialchars($_POST["Number"], ENT_QUOTES);
			if (!$name || !$number)
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty student name or number! ");
			}
			$entry = array("name" => $name, "number" => $number);
			break;
		default:
			header("HTTP/1.1 400 Bad Request");
			die("Unable to understand target: " . $target);
	}
	switch ($mode)
	{
		case "insert":
			if (selectInMysql($target, $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry exists: " . json_encode($entry) . " in " . $target);
			}
			insertIntoMysql($target, $entry);
			break;
		case "delete":
			if (!selectInMysql($target, $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry doesn't exist: " . json_encode($entry) . " in " . $target);
			}
			deleteFromMysql($target, $entry);
			break;
		default:
			header("HTTP/1.1 400 Bad Request");
			die("Unable to understand mode: " . $mode);
	}
	header("HTTP/1.1 200 OK");
	die("Modify Successful! ");
?>
