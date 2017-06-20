<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>忘记密码-汇汇生活-商家云后台管理系统</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/will.css" />
    <script src="js/angular.min.js"></script>
</head>
<body ng-app="myApp">
	<div class="forgotPassword-wrapper" ng-controller="listController">
		<div class="forgotPassword">
			<h2 class="fp-title">忘记密码</h2>
			<form class="forgot-pwd-form">
				<input type="tel" class="fp-input" placeholder="请输入登录的手机号码" ng-model="mobile">
				<div class="forgot-yzm">
					<input type="tel" class="fp-input" placeholder="请输入短信验证码" ng-model="verify">
					<input type="button" class="yzm-btn" ng-model="paracont" value="获取验证码" ng-click="getVerify()" />
				</div>
				<input type="password" class="fp-input" placeholder="请输入新登录密码" ng-model="newpassword">
				<p>密码长度为6位以上，可以使用字母、数字、符号</p>
				<!--密码输入错误时，将上面的提示去掉换成下面提示-->
				<!--
                <p class="fp-tips">请输入正确的密码！</p>
            	-->
            	<input type="hidden" ng-model="times"/>
				<input type="button" class="cp-btn" value="确认修改" ng-click="forgetPass()" />
			</form>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="js/jquery.min.js" ></script>
<script type="text/javascript" src="js/layer/layer.min.js" ></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http,$interval) {
    	$scope.times = "";
    	$scope.forgetPass = function () {
            var pass = {
            	type: "forgetpass",
            	mobile: $scope.mobile,
            	verify: $scope.verify,
            	newPassword: $scope.newpassword
            }
            if(!angular.isDefined($scope.mobile)){
            	layer.msg("请输入登录的手机号码", {time: 3000});
            	return false;
            }
            if(!angular.isDefined($scope.verify)){
            	layer.msg("请输入短信验证码", {time: 3000});
            	return false;
            }
            if(!angular.isDefined($scope.newpassword)){
            	layer.msg("请输入新登录密码", {time: 3000});
            	return false;
            }
            if($scope.times == "0"){
            	layer.msg("您输入的验证码已过期，请重新输入", {time: 3000});
            	return false;
            }
            $http.post("Controller/login/loginAction.php", pass).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.errMsg, {icon: 6, time: 1500});
                    window.location.href="login.php";
                } else {
                    layer.msg(result.data.errMsg, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 2000});
            });
        }
    	$scope.getVerify = function () {
            var pass = {
            	type: "getverify",
            	check: "1",
            	mobile: $scope.mobile
            }
            if(!angular.isDefined($scope.mobile)){
            	layer.msg("请输入登录的手机号码", {time: 3000});
            	return false;
            }
            var countdown=60; 
            var countdown1=300; 
        	$scope.timer = $interval(function(){
                if (countdown == 0) { 
        	    	$(".yzm-btn").removeAttr("disabled");    
        	    	$(".yzm-btn").val("重新获取验证码"); 
        	    	$(".yzm-btn").css("opacity","1");
        	    	countdown = 60; 
        	    	$interval.cancel($scope.timer);
        	    } else { 
        	    	$(".yzm-btn").attr("disabled", true); 
        	    	$(".yzm-btn").val(countdown); 
        	    	$(".yzm-btn").css("opacity","0.4");
        	    	countdown--; 
        	    }
    	    },1000);

            $scope.timer1 = $interval(function(){
                if (countdown1 == 0) { 
        	    	countdown1 = 0; 
        	    	$scope.times = countdown1;
        	    	$interval.cancel($scope.timer1);
        	    } else { 
        	    	countdown1--; 
        	    	$scope.times = countdown1;
        	    }
    	    },1000);
            $http.post("Controller/login/loginAction.php", pass).then(function (result) {  //正确请求成功时处理
                if (result.data.login) {
                    layer.msg(result.data.errMsg, {icon: 6, time: 1500});
                } else {
                    layer.msg(result.data.errMsg, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 2000});
            });
        }
    });
</script>