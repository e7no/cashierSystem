<?php
include('../../Common/check.php');
$id=$_GET["id"]; 
$klbName=$_GET["klbName"];
$klbSn=$_GET["klbSn"];
$klbApiKey=$_GET["klbApiKey"];
$klbShopCode=$_GET["klbShopCode"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-客流宝编辑</title>
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
				<div class="wbox-content details-klb">
					<form class="layui-form layui-form-pane">
						<div class="layui-form-item">
							<label class="layui-form-label"><b>*</b>客流宝名称</label>
								<div class="layui-input-inline" style="width: 260px;">
								<input type="text" class="layui-input" placeholder="请输入客流宝名称" ng-model="klbName" value="<?php echo $klbName;?>">
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<label class="layui-form-label"><b>*</b>客流宝ID</label>
							<div class="layui-input-inline" style="width: 260px;">
								<input type="text" class="layui-input" placeholder="请输入客流宝ID" ng-model="klbSn" value="<?php echo $klbSn;?>">
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<label class="layui-form-label"><b>*</b>客流宝秘钥</label>
							<div class="layui-input-inline" style="width: 260px;">
								<input type="text" class="layui-input" placeholder="请输入客流宝秘钥" ng-model="klbApiKey" value="<?php echo $klbApiKey;?>">
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<div class="layui-inline">
								<label class="layui-form-label"><b>*</b>客流宝code</label>
								<div class="layui-input-inline" style="width: 260px;">
									<input type="text" class="layui-input" placeholder="请输入客流宝code" ng-model="klbShopCode" value="<?php echo $klbShopCode;?>">
								</div>
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 12px;padding-left: 125px;">
							<input type="button" class="layui-btn layui-btn-small layui-btn-normal details-btn" value="保存" ng-click="saveModel()" />
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
    	$scope.klbName = '<?php echo $klbName;?>';
    	$scope.klbSn = '<?php echo $klbSn;?>';
    	$scope.klbApiKey = '<?php echo $klbApiKey;?>';
    	$scope.klbShopCode = '<?php echo $klbShopCode;?>';
        $scope.resetSearch = function (){
        	$scope.klbName = "";
        	$scope.klbSn = "";
        	$scope.klbApiKey = "";
        	$scope.klbShopCode = "";
        }
        $scope.saveModel = function () {
            var id = '<?php echo $id;?>';
            if(id==""){//添加客流宝信息
            	var postData = {
                    type: 'addKlb',
                    klbName: $scope.klbName,
                    klbSn: $scope.klbSn,
                    klbApiKey: $scope.klbApiKey,
                    klbShopCode: $scope.klbShopCode
                };
            	$http.post('../../Controller/cashier/listKlbAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                        parent.location.reload();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                }); 
            }else{//修改客流宝信息
            	var postData = {
                     type: 'modifyKlb',
                     klbName: $scope.klbName,
                     klbSn: $scope.klbSn,
                     klbApiKey: $scope.klbApiKey,
                     klbShopCode: $scope.klbShopCode,
                     id: id
                 };
            	$http.post('../../Controller/cashier/listKlbAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layer.msg('恭喜你，修改成功！', {icon: 6, time: 1500});
                        parent.location.reload();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                }); 
            }
        };
    });
</script>
</body>
</html>