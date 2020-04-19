<?php
	echo "系统仍在施工中！！！<br />";
	echo "StuName: " . $_POST["StuName"] . "<br />";
	echo "StuNumber: " . $_POST["StuNumber"] . "<br />";
	echo "WorkTitle: " . $_POST["WorkTitle"] . "<br />";
	if($_FILES["WorkFile"]["error"]>0)
	{
		echo "Error: " . $_FILES["WorkFile"]["error"];
	}
	else
	{
		echo "Upload: " . $_FILES["WorkFile"]["name"] . "<br />";
		echo "Size: " . $_FILES["WorkFile"]["size"] . " Byte(s)<br />";
		echo "Stored in: " . $_FILES["WorkFile"]["tmp_name"] . "<br />";
		$savingLocation = $_SERVER["DOCUMENT_ROOT"] . "/upload/" . $_POST["WorkTitle"] . "/" . $_POST["StuName"] . "-" . $_POST["StuNumber"] . "." . strtolower(pathinfo($_FILES["WorkFile"]["name"], PATHINFO_EXTENSION));
		// move_uploaded_file($_FILES["WorkFile"]["tmp_name"], $savingLocation);
	}
?>
