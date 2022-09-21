<?php
    header('Content-Type:application/json');
    $id = (int)$_GET["id"];

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

    $stmt = $conn->prepare("SELECT `acticle`, `time_limit` FROM contest WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $acticle, $end_time, $time_limit);
    $stmt->fetch();

    $result = array("id"=>$id, "acticle"=>$acticle, "end_time"=>$end_time, "time_limit"=>$time_limit);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    
    $stmt->close();
    $conn->close();
?>