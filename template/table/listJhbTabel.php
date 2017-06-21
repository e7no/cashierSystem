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
    <title>汇汇生活商家后台-交换班记录</title>
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
			<div class="wboxform">
				<form class="layui-form">
					<div class="layui-form-item">
					    <div class="layui-inline">
					    	<label class="layui-form-label">收银员</label>
					    	<div class="layui-input-inline">
							    <input type="text" class="layui-input" ng-model="cashierName" id="cashierName" placeholder="请输入操作员">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">交换班时间</label>
					    	<div class="layui-input-inline" style="width: 120px;">
					    		<input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 120px;">
					    		<input type="text" class="Wdate layui-input" ng-model="createDateEnd" id="logmax" placeholder="请选择" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>交换班记录</h5>
					<div class="ibox-tools">
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table  class="layui-table" style="min-width: 1200px;">
							<thead>
								<tr class="text-c">
									<th width="6%">收银员</th>
									<th>交换班时间</th>
									<th width="6%">客单数</th>
									<th width="8%">现金盘点</th>
									<th width="8%">现金收银</th>
									<th width="8%">上交金额</th>
									<th width="8%">扫码收银</th>
									<th width="8%">POS收银</th>
									<th width="8%">会员卡收银</th>
									<th width="8%">会员卡现金充值</th>
									<th width="9%">营业总额</th>
									<th width="7%">上次备用金</th>
									<th width="7%">本次备用金</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td>{{item.cashierName}}</td>
									<td>{{item.createDate}}</td>
									<td>{{item.orderNum}}</td>
									<td>{{item.cashCheckAmount ? item.cashCheckAmount : 0}}</td>
									<td>{{item.cashPayAmount ? item.cashPayAmount : 0}}</td>
									<td>{{item.submitAmount ? item.submitAmount : 0}}</td>
									<td>{{item.scanPayAmount ? item.scanPayAmount : 0}}</td>
									<td>{{item.posPayAmount ? item.posPayAmount : 0}}</td>
									<td>{{item.memPayAmount ? item.memPayAmount : 0}}</td>
									<td>{{item.memRechargeAmount ? item.memRechargeAmount : 0}}</td>
									<td>{{item.totalAmount ? item.totalAmount : 0}}</td>
									<td>{{item.backupCash ? item.backupCash: 0}}</td>
									<td>{{item.residueBackupCash ? item.residueBackupCash : 0}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<tm-pagination conf="paginationConf"></tm-pagination>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'jhblist',
                cashierName: $("#cashierName").val(),
                createDateStart: $("#logmin").val(),
                createDateEnd: $("#logmax").val(),
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/listJhbTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
            	if($scope.total==0){
                	layer.msg('暂无数据', {time: 3000});
                }else{
                	layer.msg('服务端请求错误！', {time: 3000});
                }
            });
        }
        $scope.reSearch = reSearch;
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
			perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.resetSearch = function (){
            $scope.cashierName = "";
            $scope.createDateStart = "";
            $scope.createDateEnd = "";
        }
        $scope.reExcel = function (){
            var cashierName = $("#cashierName").val();
            var createDateStart = $("#logmin").val();
            var createDateEnd = $("#logmax").val();
            window.location.href="../../Controller/table/listJhbTabelAction.php?cashierName="+cashierName+"&createDateStart="+createDateStart+"&createDateEnd="+createDateEnd+"&type=excel";
        }
    });
</script>
</body>
</html>