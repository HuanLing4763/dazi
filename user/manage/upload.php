<?php
    $title = $_POST["title"];
    $content = $_POST["content"];

    $filename = "../../acticle/" . $title . ".txt";
    $file = fopen($filename, "w") or die("Unable to open file!");

    fwrite($file, $content);

    fclose($file);
?>