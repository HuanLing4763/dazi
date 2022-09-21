<?php
    session_start();
    $user = $_SESSION['user'];
    if ($user == 'root') echo 1;
    else echo $user;
?>