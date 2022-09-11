<?php
    header('Content-Type:application/json');
    session_start();
    $user = $_SESSION['user'];

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

    $date = [];
    $speed = [];
    $accuracy = [];
    $sql = "SELECT `date`,`speed`,`accuracy` FROM grades
            WHERE `name` = '{$user}'";

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        array_push($date, $row["date"]);
        array_push($speed, $row["speed"]);
        array_push($accuracy, $row["accuracy"]);
    }

    $res = "{date:" . json_encode($date) . ",speed:" . json_encode($speed) . ",accuracy:" . json_encode($accuracy) . "}";
    echo json_encode($res, JSON_UNESCAPED_UNICODE);

    $conn->close();
?>