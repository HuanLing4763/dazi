<?php
    session_start();
    $res = $_SESSION['user'] == 'root' ? 1 : 0;
    echo $res;
?>