<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-打印内容</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
    <script src="../../js/angular.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
<body ng-app="myApp">
	<div class="wrapper" ng-controller="listController">
		<div class="content">
			<div class="wbox">
				<div class="wbox-content printer-content">
					<div class="printer-info">
						<p>打印机名称：{{name}}</p>
						<p>打印机IP：{{ipAddress}}</p>
						<p>打印机类型：{{printScene}}</p>
						<p>设备型号：{{printername}}</p>
						<p>打印规格：{{guige}}</p>
					</div>
					<fieldset class="layui-elem-field">
						<legend>模板设置</legend>
						<div class="layui-field-box">
							<span  ng-repeat="item in lists">
								<p>{{item.tempName}}：{{item.printNum}}份</p>
							</span>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
    	var postData = {type: 'printerList',id:'<?php echo $id;?>'};
        $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
        	$scope.list = result.data.goodsList;
        	$scope.lists = result.data.tempSetList;
        	$scope.printer = result.data.printerVO;
        	$scope.printercat = result.data.printerCatVO;
        	//赋值打印机基本信息
        	$scope.name = result.data.printerVO.name;
        	$scope.ipAddress = result.data.printerVO.ipAddress;
        	$scope.printScene = "";
			if(result.data.printerCatVO.type==1){
				$scope.printScene = "本地打印机";
           	}else if(result.data.printerCatVO.type==2){
           		$scope.printScene = "云打印机";
           	}
        	$scope.guige = result.data.printerVO.spec;
        	$scope.printername = result.data.printerCatVO.name;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
    });
</script>
</body>
</html>