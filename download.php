<?php
	require "local.php";
	if ($_POST["Admin"] != $admin_password)
	{
		die("Wrong Password! ");
	}
	if (!is_dir($upload_directory . $_POST["WorkTitle"] . "/"))
	{
		die("Wrong directory: " . $_POST["WorkTitle"]);
	}
	$zipName = $_POST["WorkTitle"] . ".zip";
	$zip = new ZipArchive;
	if ($zip->open($zipName, ZipArchive::CREATE) === TRUE)
	{
		$fileList = scandir($upload_directory . $_POST["WorkTitle"] . "/");
		foreach ($fileList as $fileName)
		{
			$filePath = $upload_directory . $_POST["WorkTitle"] . "/" . $fileName;
			if (!is_dir($filePath))
			{
				$zip->addFile($filePath, $fileName);
			}
		}
		$zip->close();
		header("Cache-Control: no-store");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . $zipName);
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: application/zip");
		header("Content-Length: " . filesize($zipName));
		readfile($zipName);
	}
	else
	{
		die("Fail zip: ZipArchive failure! ");
	}
	unlink($zipName);
?>
