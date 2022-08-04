<?php
    header('Content-Type:application/json');
    $user = $_GET["user"];

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