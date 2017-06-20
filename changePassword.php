<?php
include('Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>修改密码-汇汇生活-商家云后台管理系统</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="css/will.css" />
    <link rel="stylesheet" href="css/common.css" />
    <script src="js/angular.min.js"></script>
</head>
<body ng-app="myApp">
	<div class="changePassword-wrapper" ng-controller="listController">
		<div class="changePassword">
			<h2 class="cp-title">修改密码</h2>
			<form class="change-pwd-form">
				<input type="password" class="cp-input" ng-model="password" placeholder="请输入原登录密码">
				<input type="password" class="cp-input" ng-model="newpassword" placeholder="请输入新登录密码">
				<input type="password" class="cp-input" ng-model="surepassword" placeholder="请再次输入新登录密码">
				<p>密码长度为6位以上，可以使用字母、数字、符号</p>
				<!--密码输入错误时，将上面的提示去掉换成下面提示-->
				<!--
                <p class="cp-tips">请输入正确的密码！</p>
            	-->
				<input type="button" class="cp-btn" ng-click="passModify()" value="确认修改" />
			</form>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="js/jquery.min.js" ></script>
<script type="text/javascript" src="js/layer/layer.min.js" ></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http, $interval) {
    	$scope.passModify = function () {
            var pass = {
            	type: "modifypass",
            	password: $scope.password,
                newpassword: $scope.newpassword,
                surepassword: $scope.surepassword
            }
            if(!angular.isDefined($scope.password)){
            	layer.msg("请输入原登录密码", {time: 3000});
            	return false;
            }
            if(!angular.isDefined($scope.newpassword)){
            	layer.msg("请输入新登录密码", {time: 3000});
            	return false;
            }
            if(!angular.isDefined($scope.surepassword)){
            	layer.msg("请确认新登录密码", {time: 3000});
            	return false;
            }
            if($scope.newpassword!=$scope.surepassword){
            	layer.msg("两次输入的登录密码不一致，请重新输入", {time: 3000});
            	return false;
            }
            $http.post("Controller/login/loginAction.php", pass).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                	var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    layer.msg('恭喜你，密码已经重置', {icon: 6, time: 1500});
                    var countdown=3; 
                    $scope.timer = $interval(function(){
                        if (countdown == 0) { 
                        	parent.location.reload();
                	    } else { 
                	    	countdown--; 
                	    }
            	    },1000);
                } else {
                    layer.msg(result.data.errMsg, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 2000});
            });
        }
    });
</script>
    