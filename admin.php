<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set("PRC");
header("Content-type:text/html;charset=utf-8");
if ($_SESSION["stoId"] != '' && $_SESSION['bUserId'] != '') {
    header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/index.php");
    return;
} else {
    $user = $_GET['user'];
    $code = $_GET['code'];
    $pwd = $_GET['pwd'];
    if ($user == '' || $code == '' || $pwd == '') {
        header("Location:http://" . $_SERVER['HTTP_HOST'] . "/busadmin/login.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>商家云后台管理系统</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="css/will.css?v=1.1"/>
    <link rel="stylesheet" href="css/login.css?v=1.1"/>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-cookies.min.js"></script>
</head>
<body ng-app="myApp" ng-controller="myCtrl" ng-init="login()">
<div id="browser_ie">
    <div class="brower_info">
        <div class="notice_info">
            <p>你的浏览器版本过低，可能导致网站不能正常访问！<BR>为了你能正常使用网站功能，请使用这些浏览器。</p>
        </div>
        <div class="browser_list">
				<span>
					<a href="http://www.google.cn/intl/zh-CN/chrome/browser/" target="_blank">
						<img src="img/Chrome.png"/>Chrome
					</a>
				</span>
            <span>
					<a href="http://www.firefox.com.cn/" target="_blank">
						<img src="img/Firefox.png"/>Firefox
					</a>
				</span>
            <span>
					<a href="https://www.apple.com/cn/safari/" target="_blank">
						<img src="img/Safari.png"/>Safari
					</a>
				</span>
            <span>
					<a href="http://rj.baidu.com/soft/detail/23360.html?ald" target="_blank">
						<img src="img/IE.png"/>IE10及以上
					</a>
				</span>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/layer/layer.min.js"></script>
</body>
<script type="text/javascript">
    angular.module('myApp', ['ngCookies']).controller('myCtrl', function ($scope, $http, $cookies) {
        $scope.code = '<?php echo $code;?>';
        $scope.name = '<?php echo $user;?>';
        $scope.pwd = '<?php echo $pwd;?>';
        if ($scope.code == '') {
            layer.msg('店铺编码错误，请重新登录！', {time: 2000});
            var host = window.location.href;
            parent.location.reload(host + '/busadmin/login.php');
        }
        if ($scope.name == '') {
            layer.msg('账号不正确，请重新登录！', {time: 2000});
            var host = window.location.href;
            parent.location.reload(host + '/busadmin/login.php');
        }
        if ($scope.pwd == '') {
            layer.msg('密码错误，请重新登录！', {time: 2000});
            var host = window.location.href;
            parent.location.reload(host + '/busadmin/login.php');
        }

        $scope.login = function () {
            $cookies.put("code_ck", $scope.code, {expires: new Date(new Date().getTime() + 609638400)});
            $cookies.put("name_ck", $scope.name, {expires: new Date(new Date().getTime() + 609638400)});
            var user = {
                type: "login",
                code: $scope.code,
                name: $scope.name,
                pwd: $scope.pwd
            }
            $http.post("Controller/login/loginAction.php", user).then(function (result) {  //正确请求成功时处理
                if (result.data.login) {
                    var host = window.location.href;
                    parent.location.reload(host + '/busadmin/index.php');
                } else {
                    layer.msg(result.data.errMsg, {time: 2000});
                    var host = window.location.href;
                    parent.location.reload(host + '/busadmin/login.php?pwd=' + $scope.pwd);
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 2000});
                var host = window.location.href;
                parent.location.reload(host + '/busadmin/login.php?pwd=' + $scope.pwd);
            });
        }
    });
</script>
<script>
    if (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion.split(";")[1].replace(/[ ]/g, "").replace("MSIE", "")) < 10) {
        $("#browser_ie").show();
        $("#header").hide();
        $("#content").hide();
    }
</script>
</html>