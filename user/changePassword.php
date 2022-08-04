<?php
    $account = $_POST["account"];
    $pwd = $_POST["password"];

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

    $sql = "UPDATE users
            SET user_password = '{$pwd}'
            WHERE user_name = '{$account}'";

    mysqli_query($conn, $sql);

    $conn->close();
?>