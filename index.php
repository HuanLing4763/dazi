<script>
    <?php
        ini_set("session.gc_maxlifetime", "31536000");  // 将session过期时间设置为1年
        ini_set("session.cookie_lifetime", "31536000");  // 将session对应的cookie过期时间设置为1年
        session_start();
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user'] == 'root') {
                echo 'window.location.replace("user/manage/manage.html")';
            } else {
                echo 'window.location.replace("user/user.html")';
            }
        } else {
            echo 'window.location.replace("user/login.html")';
        }
    ?>
</script>