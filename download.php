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
	$zipPath = $upload_directory . $_POST["WorkTitle"] . ".zip";
	$zip = new ZipArchive;
	if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE)
	{
		$fileList = scandir($upload_directory . $_POST["WorkTitle"] . "/");
		foreach ($fileList as $fileName)
		{
			$filePath = $upload_directory . $_POST["WorkTitle"] . "/" . $fileName;
			if ($fileName != "." && fileName!= ".." && !is_dir($filePath))
			{
				$zip->addFile($filePath, $fileName);
			}
		}
		$zip->close();
		header("Cache-Control: no-store");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . pathinfo($zipPath,PATHINFO_BASENAME));
		header("Content-Length: " . filesize($zipPath));
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: application/zip");
		readfile($zipPath);
	}
	else
	{
		die("Fail zip: ZipArchive failure! ");
	}
	unlink($zipPath);
?>
