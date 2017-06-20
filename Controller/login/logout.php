<?php
//删除当前用户对应的session文件以及释放session
session_start();
session_destroy();
if (session_destroy()) {
	echo "<script>window.parent.location.href='http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php';</script>";
    //header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php");
    exit();
} else {
    unset($_SESSION);
    echo "<script>window.parent.location.href='http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php';</script>";
    //header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php");
    exit();
}
?>