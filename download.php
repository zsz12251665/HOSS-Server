<?php
	$password = htmlspecialchars($_POST["Password"], ENT_QUOTES);
	$title = htmlspecialchars($_POST["WorkTitle"], ENT_QUOTES);
	require "local.php";
	if ($password != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	// Validate the target path
	$workDirectory = $upload_directory . $title . "/";
	if (!is_dir($workDirectory))
	{
		header("HTTP/1.1 400 Bad Request");
		die("Not directory: " . $title);
	}
	// Zip the homework files
	$zipPath = tempnam(sys_get_temp_dir(), $title);
	$zip = new ZipArchive;
	if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE)
	{
		header("HTTP/1.1 500 Internal Server Error");
		die("Fail zip: ZipArchive failure! ");
	}
	foreach (scandir($workDirectory) as $fileName)
	{
		if ($fileName != "." && fileName!= ".." && !is_dir($workDirectory . $fileName))
		{
			$zip->addFile($workDirectory . $fileName, $fileName);
		}
	}
	$zip->close();
	// Output the zip file
	header("Cache-Control: no-store");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=" . $title . ".zip");
	header("Content-Length: " . filesize($zipPath));
	header("Content-Transfer-Encoding: binary");
	header("Content-Type: application/zip");
	readfile($zipPath);
	unlink($zipPath);
	die();
?>
