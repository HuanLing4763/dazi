<?php
    $acticle = $_POST['acticle'];
    $code = (int)$_POST['code'];
    $time = $_POST['date'];
    $timeLimitMode = array_key_exists("switch", $_POST) ? true : false;
    $timeLimit = (int)$_POST['limitTime'];

    if ($timeLimitMode) {
        if (!$timeLimit) {
            echo "<p style='color: red;'>请填写限时时间</p>";
            exit(0);
        }
    } else {
        $timeLimit = 0;
    }

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

    // 判断邀请码是否重复
    $stmt = $conn->prepare("SELECT * FROM contest WHERE id = ?");
    $stmt->bind_param("i", $code);
    $stmt->execute();
    if ($stmt->fetch() > 0) {
        echo "<p style='color: red;'>邀请码重复，请重新生成！</p>";
    } else {
        // 将竞赛信息插入数据库
        $stmt = $conn->prepare("INSERT INTO contest VALUE(?, ?, ?, ?)");
        $stmt->bind_param("issi", $code, $acticle, $time, $timeLimit);
        $stmt->execute();
        echo "<p style='color: red;'>发布成功</p>";
    }

    $stmt->close();
    $conn->close();
?>