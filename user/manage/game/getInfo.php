
<?php
    $id = $_GET["id"];

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