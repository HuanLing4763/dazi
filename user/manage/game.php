<?php
    $acticle = $_GET['Acticle'];
    $code = (int)$_GET['code'];
    $time = $_GET['time'];
    $timeLimitMode = $_GET["timeLimitMode"];
    $timeLimit = (int)$_GET['timeLimit'];
    
    $pattern = "/^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))T([0-1]\d|2[0-3]):([0-5]\d)$/";
    
    if (!$acticle) {
        echo "<p style='color: red;'>请选择文章</p>";
        exit(0);
    }
    if (!$code) {
        echo "<p style='color: red;'>请生成邀请码</p>";
        exit(0);
    }
    if (!preg_match($pattern, $time) && $time != null) {
        echo "<p style='color: red;'>时间格式错误！正确格式应为</p>";
        echo "<p style='color: red;'>2022-07-12T19:12</p>";
        exit(0);
    }
    if (!$time) {
        echo "<p style='color: red;'>请选择时间</p>";
        exit(0);
    }
    if ($timeLimitMode == "on") {
        if (!$timeLimit) {
            echo "<p style='color: red;'>请填写限时时间</p>";
            exit(0);
        }
    }


    //将0转换为null
    if ($timeLimit == 0) $timeLimit = "NULL";

    // 将时间格式转换为MySQL datetime类型
    $date_time = explode("T", $time);
    $date = explode("-", $date_time[0]);
    $time = explode(":", $date_time[1]);

    $year = $date[0];
    $mouth = $date[1];
    $day = $date[2];
    $hour = $time[0];
    $minute = $time[1];
    
    $res_date = $year . $mouth . $day . $hour . $minute . "00";

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

     // 判断邀请码是否重复
    $result = mysqli_query($conn, "SELECT * FROM contest WHERE id = {$code}");
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color: red;'>邀请码重复，请重新生成！</p>";
        exit(0);
    }

    // 将竞赛信息插入数据库
    $sql = "INSERT INTO contest VALUE({$code}, '{$acticle}', {$res_date}, {$timeLimit})";
    $error = mysqli_query($conn, $sql);

    echo "<p style='color: red;'>发布成功</p>";

    $conn->close();
?>