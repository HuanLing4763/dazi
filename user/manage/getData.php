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

    $result = mysqli_query($conn, "SELECT * FROM grades");
    while($row = mysqli_fetch_assoc($result)) {
        $res .= "<tr>";
        $res .= "<td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["acticle"] .
                "</td><td>". $row["word_count"] . "</td><td>". $row["time"] . "</td><td>". $row["date"] .
                "</td><td>". $row["speed"] . "</td><td>". $row["accuracy"] . "</td>";
        $res .= "</tr>";
    }

    echo $res;

    $conn->close();
?>