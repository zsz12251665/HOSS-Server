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
	try
	{
		// Validate and fulfill the entry according to the target
		$entry = array();
		switch ($target)
		{
			case 'homeworks':
				$title = htmlspecialchars($_POST["Title"], ENT_QUOTES);
				$directory = htmlspecialchars($_POST["Directory"], ENT_QUOTES);
				$deadline = htmlspecialchars($_POST["Deadline"], ENT_QUOTES);
				if (!$title)
				{
					throw new Exception("Empty homework title! ");
				}
				if (!$directory)
				{
					$directory = $title;
				}
				if (preg_match("/[\\\/:*?\"<>|]/", $directory))
				{
					throw new Exception("invalid directory name: " . $directory);
				}
				if (!strtotime($deadline))
				{
					throw new Exception("Invalid deadline: " . $deadline);
				}
				$entry = array("title" => $title, "directory" => $directory, "deadline" => $deadline);
				break;
			case 'students':
				$name = htmlspecialchars($_POST["Name"], ENT_QUOTES);
				$number = htmlspecialchars($_POST["Number"], ENT_QUOTES);
				if (!$name || !$number)
				{
					throw new Exception("Empty student name or number! ");
				}
				$entry = array("name" => $name, "number" => $number);
				break;
			default:
				throw new Exception("Unable to understand target: " . $target);
		}
		// Modify the database according to the mode
		switch ($mode)
		{
			case "insert":
				if (selectInMysql($target, $entry))
				{
					throw new Exception("Entry exists: " . json_encode($entry) . " in " . $target);
				}
				insertIntoMysql($target, $entry);
				break;
			case "delete":
				if (!selectInMysql($target, $entry))
				{
					throw new Exception("Entry doesn't exist: " . json_encode($entry) . " in " . $target);
				}
				deleteFromMysql($target, $entry);
				break;
			default:
				throw new Exception("Unable to understand mode: " . $mode);
		}
	}
	catch (Exception $err)
	{
		header("HTTP/1.1 400 Bad Request");
		die($err->getMessage());
	}
	header("HTTP/1.1 200 OK");
	die("Modify Successful! ");
?>
