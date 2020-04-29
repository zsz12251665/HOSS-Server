<?php
    session_start();
    $key = ini_get("session.upload_progress.prefix") . $_GET[ini_get("session.upload_progress.name")];
    if (!empty($_SESSION[$key]))
    {
        $current = $_SESSION[$key]["bytes_processed"];
        $total = $_SESSION[$key]["content_length"];
        echo $current < $total ? ceil($current * 100.0 / $total) : 100;
    }
    else
    {
        echo 100;
    }
?>
