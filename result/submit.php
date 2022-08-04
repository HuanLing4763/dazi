<?php
    $acticle = $_GET["acticle"];
    $wordCount = $_GET["wordCount"];
    $time = $_GET["time"];
    $speed = $_GET["speed"];
    $accuracy = $_GET["accuracy"];
    $contestId = $_GET["contestId"];
    $date = $_GET["date"];
    $name = $_GET["name"];

    $servername = "localhost:3306";
    $username = "root";
    $password = "123456";
    $dbname = "user";

    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    if ($contestId) {
        $sql = "INSERT INTO contest_info VALUES(0, '{$name}', {$contestId}, '{$acticle}', {$wordCount}, '{$time}', '{$date}', {$speed}, {$accuracy})";
    } else {
        $sql = "INSERT INTO grades VALUES(0, '{$name}', '{$acticle}', {$wordCount}, '{$time}', '{$date}', {$speed}, {$accuracy})";
    }

    mysqli_query($conn, $sql);

    $conn->close();
?>