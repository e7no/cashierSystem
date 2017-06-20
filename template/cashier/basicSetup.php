<?php
include('../../Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-基本设置</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
	<div class="wrapper" ng-controller="listController">
		<div class="content" ng-init="reSearch()">
			<div class="wbox">
				<div class="wbox-title">
					<h5>基本设置</h5>
					<div class="ibox-tools">
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<fieldset class="layui-elem-field">
						<legend style="font-size: 16px;">基本设置</legend>
						<div class="layui-field-box">
							<div class="layui-form-item">
								<label class="layui-form-label">是否抹零</label>
								<div class="layui-input-inline" style="width: 150px; padding: 4px 0;">
									<div class="will-check">
										<input type="checkbox" ng-model="payRound" value="" id="payRound"/>
										<i class="iconfont"></i>
									</div>
								</div>
							</div>
							<div class="layui-form-item" style="margin-top: 10px;">
								<label class="layui-form-label">&#12288;初始备用金</label>
								<div class="layui-input-inline" style="width: 150px;">
									<input ng-disabled="disabled" type="text" class="layui-input" placeholder="请输入初始备用金" ng-model="backupCash" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
								</div>
							</div>
							<div class="layui-form-item" style="margin-top: 10px;">
								<label class="layui-form-label">&#12288;餐纸费</label>
								<div class="layui-input-inline" style="width: 150px;">
									<input type="text" class="layui-input" placeholder="请输入餐纸费" ng-model="paperFee" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
								</div>
							</div>
						</div>
					</fieldset>
					<div class="layui-form-item" style="margin-top: 15px;">
						<input ng-model="id" type="hidden" />
						<input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="setData()" value="确认">
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
	$(function(){
		/*开关*/
		$(".will-check input").click(function(){
			if ($(this).is(":checked")) {
				$(this).parent("div").addClass("active");
				$("#payRound").val("1");
			}else {
				$(this).parent("div").removeClass("active");
				$("#payRound").val("0");
			}
		})
	})
</script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {type: 'basic',};
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
            	$scope.backupCash=result.data.backupCash;
            	$scope.paperFee=result.data.paperFee;
            	$scope.payRound=result.data.payRound;
            	$scope.id=result.data.id;
                if ($scope.backupCash != '') {
                    $scope.disabled = true;
                } else {
                    $scope.disabled = false;
                }
                if(result.data.payRound==0){
                	$(".will-check").removeClass("active");
                	$(".will-check input").attr("checked", false);
                }else{
                	$(".will-check").addClass("active");
                	$(".will-check input").attr("checked", true);
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.setData = function () {
            var postData = {
            	type: 'basicset',
            	id: $scope.id,
            	backupCash: $scope.backupCash,
            	paperFee: $scope.paperFee,
            	payRound: $("#payRound").val(),
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });
</script>
</body>
</html>