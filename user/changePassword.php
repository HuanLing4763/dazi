<?php
    session_start();
    $account = $_SESSION['user'];
    $pwd = $_POST["password"];

    // 获取数据库配置
    $db_config_string = file_get_contents('../db_config.json');
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

    $stmt = $conn->prepare("UPDATE users
                            SET user_password = ?
                            WHERE user_name = ?");
    $stmt->bind_param("ss", $pwd, $account);
    $stmt->execute();

    $stmt->close();
    $conn->close();
?>