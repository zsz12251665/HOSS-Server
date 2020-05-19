<?php
	$password = htmlspecialchars($_POST["Password"], ENT_QUOTES);
	$title = htmlspecialchars($_POST["WorkTitle"], ENT_QUOTES);
	require "local.php";
	if ($password != $admin_password)
	{
		header("HTTP/1.1 403 Forbidden");
		die("Wrong Password! ");
	}
	$workDirectory = $upload_directory . $title . "/";
	if (!is_dir($workDirectory))
	{
		header("HTTP/1.1 400 Bad Request");
		die("Wrong directory: " . $title);
	}
	$zipPath = tempnam(sys_get_temp_dir(), $title);
	$zip = new ZipArchive;
	if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE)
	{
		$fileList = scandir($workDirectory);
		foreach ($fileList as $fileName)
		{
			if ($fileName != "." && fileName!= ".." && !is_dir($workDirectory . $fileName))
			{
				$zip->addFile($workDirectory . $fileName, $fileName);
			}
		}
		$zip->close();
		header("Cache-Control: no-store");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . $title . ".zip");
		header("Content-Length: " . filesize($zipPath));
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: application/zip");
		readfile($zipPath);
	}
	else
	{
		header("HTTP/1.1 500 Internal Server Error");
		die("Fail zip: ZipArchive failure! ");
	}
	unlink($zipPath);
	die();
?>
