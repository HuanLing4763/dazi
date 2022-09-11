<?php

    // 获取数据库配置
    $db_config_string = file_get_contents('../../db_config.json');
    $db_config = json_decode($db_config_string, true);

    // 创建连接
    $conn = new mysqli(
        $db_config["servername"],
        $db_config["username"],
        $db_config["password"],
        $db_config["dbname"]
    );
 
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $res = "";

    $result = mysqli_query($conn, "SELECT * FROM users");
    while($row = mysqli_fetch_assoc($result)) {
        $res .= "<tr>";
        $res .= "<td>" . $row["user_id"] . "</td><td>" . $row["user_name"];
        $res .= "<td onclick='deleteUser(this)'>删除用户</td></tr>";
    }

    echo $res;

    $conn->close();
?>