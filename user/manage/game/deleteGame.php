<?php
    $id = $_GET["id"];

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

    $sql = "DELETE FROM contest
            WHERE id = {$id}";

    mysqli_query($conn, $sql);

    $conn->close();
?>