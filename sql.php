<?php
	function connectAndSelect()
	{
		require "local.php";
		$mysqlConnection = new mysqli($mysql_server, $mysql_username, $mysql_password, "homework");
		if ($mysqlConnection->connect_error)
		{
			header("HTTP/1.1 500 Internal Server Error");
			die("Could not connect! " . $mysqlConnection->connect_error);
		}
		return $mysqlConnection;
	}
	function insertIntoMysql($table, $entry = array())
	{
		$mysqlConnection = connectAndSelect();
		$keys = array();
		$values = array();
		if (!$entry)
		{
			return false;
		}
		foreach ($entry as $key => $value)
		{
			$keys[] = $key;
			$values[] = $value;
		}
		$queryString = "INSERT INTO " . $table . " (" . implode(", ", $keys) . ") VALUES (\"" . implode("\", \"", $values) . "\")";
		$answer = $mysqlConnection->query($queryString);
		$mysqlConnection->close();
		return $answer;
	}
	function deleteFromMysql($table, $entry = array())
	{
		$mysqlConnection = connectAndSelect();
		$queryString = "DELETE FROM " . $table . " WHERE TRUE";
		foreach ($entry as $key => $value)
		{
			$queryString = $queryString . " AND " . $key . " = " . $value;
		}
		$answer = $mysqlConnection->query($queryString);
		$mysqlConnection->close();
		return $answer;
	}
	function matchingEntry($table, $entry = array())
	{
		$mysqlConnection = connectAndSelect();
		$queryString = "SELECT * FROM " . $table . " WHERE TRUE";
		foreach ($entry as $key => $value)
		{
			$queryString = $queryString . " AND " . $key . " = " . $value;
		}
		$mysqlResult = $mysqlConnection->query($queryString);
		$answer = array();
		while ($row = $mysqlResult->fetch_array())
		{
			$answer[] = $row;
		}
		$mysqlResult->free();
		$mysqlConnection->close();
		return $answer;
	}
?>
