<?php
	$password = htmlspecialchars($_POST["Password"], ENT_QUOTES);
	$target = htmlspecialchars($_POST["Target"], ENT_QUOTES);
	$mode = htmlspecialchars($_POST["Mode"], ENT_QUOTES);
	$firstColumn = htmlspecialchars($_POST["First"], ENT_QUOTES);
	$secondColumn = htmlspecialchars($_POST["Second"], ENT_QUOTES);
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
			if (!$firstColumn)
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty homework title! ");
			}
			if (!$secondColumn)
			{
				$secondColumn = $firstColumn;
			}
			if (preg_match("/[\\\/:*?\"<>|]/", $secondColumn))
			{
				header("HTTP/1.1 400 Bad Request");
				die("invalid directory name: " . $secondColumn);
			}
			$entry = $secondColumn ? array("title" => $firstColumn, "directory" => $secondColumn) : array("title" => $firstColumn);
			break;
		case 'students':
			if (!$firstColumn || !$secondColumn)
			{
				header("HTTP/1.1 400 Bad Request");
				die("Empty student name or number! ");
			}
			$entry = array("name" => $firstColumn, "number" => $secondColumn);
			break;
		default:
			header("HTTP/1.1 400 Bad Request");
			die("Unable to understand target: " . $target);
	}
	switch ($mode)
	{
		case "Insert":
			if (selectInMysql($target, $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry exists: (" . $firstColumn . ", " . $secondColumn . ") in " . $target);
			}
			insertIntoMysql($target, $entry);
			break;
		case "Delete":
			if (!selectInMysql($target, $entry))
			{
				header("HTTP/1.1 400 Bad Request");
				die("Entry doesn't exist: (" . $firstColumn . ", " . $secondColumn . ") in " . $target);
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
