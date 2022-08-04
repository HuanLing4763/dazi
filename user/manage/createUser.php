<?php
    $account = $_POST["account"];

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

    // 检测用户是否存在
    $result = mysqli_query($conn, "SELECT * FROM users
                                    WHERE user_name = '{$account}'");
    if (mysqli_num_rows($result) > 0) {
        echo 1;
        exit(0);
    }

    $sql = "INSERT INTO users
            VALUES(0, '{$account}', '123456')";

    mysqli_query($conn, $sql);

    $conn->close();
?>