<?php
session_start();
date_default_timezone_set("Africa/Cairo");
setcookie("username",$_COOKIE['username'],time(),'/');
setcookie("logtype",$_POST['type'],time(),"/");
session_destroy();
header("location:index.php");
?>