<?php
    header('Content-Type:application/json');
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

    $result = $conn->query("SELECT * FROM `grades` ORDER BY `date` DESC");
    $data = $result->fetch_all();

    $result = $conn->query("SELECT `user_id`, `user_name` FROM users ORDER BY `user_id`");
    $user = $result->fetch_all();

    echo json_encode([$user, $data], JSON_UNESCAPED_UNICODE);

    $conn->close();
?>