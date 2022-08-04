<?php
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

    $res = "";
    $i = 1;

    $result = mysqli_query($conn, "SELECT user_name FROM users");
    while($row = mysqli_fetch_assoc($result)) {
        $res .= "<tr>";
        $res .= "<td>" . $i++ . "</td><td>" . $row["user_name"] . "</td><td>******</td>";
        $res .= "<td onclick='deleteUser(this)'>删除用户</td></tr>";
    }

    echo $res;

    $conn->close();
?>