<?php
    $account = $_POST["account"];
    $pwd = $_POST["password"];

    $servername = "localhost:3306";
    $username = "root";
    $password = "123456";
    $dbname = "user";

    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users
            WHERE user_name = '{$account}'";
    
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo 0;
    } else{
        while($row = mysqli_fetch_assoc($result)) {
            if ($row["user_password"] == $pwd) {
                // 设置coockie
                setcookie("account", urlencode($account), time()+3600*24*365, "/");
                setcookie("isLogin", true, time()+3600*24*365, "/");
                if ($account == "root") {
                    echo 3;
                } else {
                    echo 1;
                }
            } else {
                echo 2;
            }
        }
    }

    $conn->close();
?>