<?php
    $title = $_GET["title"];
    $content = $_GET["content"];

    $filename = "../../acticle/" . $title . ".txt";
    $file = fopen($filename, "w") or die("Unable to open file!");

    fwrite($file, $content);

    fclose($file);
?>