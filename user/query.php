<?php
    $id = $_GET["id"];
    $now = date("Y-m-d H:i:s");

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

    $sql = "SELECT * FROM contest
            WHERE id = '{$id}'";
    
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo 0;
    } else{
        while($row = mysqli_fetch_assoc($result)) {
            if (strtotime($now) > strtotime($row["end_time"])) {
                echo 1;
                exit(0);
            }
            echo $row["id"];
        }
    }

    $conn->close();
?>