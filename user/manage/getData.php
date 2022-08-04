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