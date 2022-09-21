<?php
    $id = $_GET["id"];

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

    $sql = "SELECT * FROM contest_info
            WHERE contest_id = {$id}
            ORDER BY `date` desc";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["word_count"] . "字</td>";
        echo "<td>" . $row["time"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . $row["speed"] . "字/分</td>";
        echo "<td>" . $row["accuracy"] . "%</td>";
        echo "</tr>";
    }
    
    $conn->close();
?>