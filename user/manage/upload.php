<?php
    $title = $_POST["title"];
    $content = $_POST["content"];

    $filename = "../../acticle/" . $title . ".txt";
    if (file_exists($filename)) {
        echo "<script>alert('该文章已存在，请勿重复添加！');close();</script>;";
        die();
    }
    $file = fopen($filename, "x") or die("Unable to open file!");

    fwrite($file, $content);

    fclose($file);
    echo "<script>alert('添加成功！');close();</script>;";
?>