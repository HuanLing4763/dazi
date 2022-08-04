
<?php
    header('Content-Type:application/json');
    $id = (int)$_GET["id"];

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
            WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row, JSON_UNESCAPED_UNICODE);
    }
    
    $conn->close();
?>