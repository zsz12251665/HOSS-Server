<?php
	echo "系统仍在施工中！！！<br />";
	echo "StuName: " . $_POST["StuName"] . "<br />";
	echo "StuNumber: " . $_POST["StuNumber"] . "<br />";
	echo "WorkTitle: " . $_POST["WorkTitle"] . "<br />";
	require "sql.php";
	if (!isStudent($_POST["StuName"], $_POST["StuNumber"]))
		die($_POST["StuName"] . " (" . $_POST["StuNumber"] . ") is not our student! ");
	if($_FILES["WorkFile"]["error"])
	{
		echo "Error: " . $_FILES["WorkFile"]["error"];
	}
	else
	{
		echo "Upload: " . $_FILES["WorkFile"]["name"] . "<br />";
		echo "Size: " . $_FILES["WorkFile"]["size"] . " Byte(s)<br />";
		if (!file_exists("/home/homework/" . $_POST["WorkTitle"] . "/"))
		{
			mkdir("/home/homework/" . $_POST["WorkTitle"] . "/", 0777);
		}
		$savingLocation = "/home/homework/" . $_POST["WorkTitle"] . "/" . $_POST["StuName"] . "-" . $_POST["StuNumber"] . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
		move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation);
	}
?>
