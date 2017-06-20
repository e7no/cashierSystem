<?php
/**
 * Created by PhpStorm.
 * User: Seven
 * Date: 2016/10/14
 * Time: 10:11
 */
session_start();
include_once ('config_host.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$time = time();
if(($time - $_SESSION['time']) > 99999){
    header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/Controller/login/logout.php");
    exit();
}else{
    $_SESSION['time'] = $time;
    if ($_SESSION["stoId"] == '' && $_SESSION['bUserId']=='') {
        header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php");
        return;
    }
}
?>