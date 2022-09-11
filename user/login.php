<?php
    $account = $_POST["account"];
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

    $stmt = $conn->prepare("SELECT user_password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $account);
    $stmt->execute();
    $stmt->bind_result($query_pwd);

    if ($stmt->fetch() == 0) {
        echo 0;
    } else{
        if ($query_pwd == $pwd) {
            // 设置session
            ini_set("session.gc_maxlifetime", "31536000");  // 将session过期时间设置为1年
            ini_set("session.cookie_lifetime", "31536000");  // 将session对应的cookie过期时间设置为1年
            session_start();
            $_SESSION['user'] = $account;

            if ($account == "root") {
                echo 3;
            } else {
                echo 1;
            }
        } else {
            echo 2;
        }
    }

    $stmt->close();
    $conn->close();
?>