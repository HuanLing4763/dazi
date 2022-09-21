<?php
    header('Content-Type:application/json');

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

    $sql = "SELECT * FROM contest ORDER BY end_time desc";
    $result = mysqli_query($conn, $sql);

    $now = date("Y-m-d H:i:s");
    $noEnd = "";
    $ended = "";

    while($row = mysqli_fetch_assoc($result)) {
        $timeLimit = $row["time_limit"] == 0 ? "无" : ($row["time_limit"] . "分钟");
        if (strtotime($now) < strtotime($row["end_time"])) {
            $noEnd .= '<tr><td>' . $row["id"] . '</td><td>' . $row["acticle"] . '</td><td>' . $row["end_time"] .'</td><td>' . $timeLimit . '</td><td><a style="padding: 3px;" href="view.html?id=' . $row["id"] . '">查看</a></td></tr>';
        } else {
            $ended .= '<tr><td>' . $row["id"] . '</td><td>' . $row["acticle"] . '</td><td>' . $row["end_time"] .'</td><td>' . $timeLimit . '</td><td><a style="padding: 3px;" href="view.html?id=' . $row["id"] . '">查看</a></td></tr>';
        }
    }

    $res = [$noEnd, $ended];
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
    
    $conn->close();
?>