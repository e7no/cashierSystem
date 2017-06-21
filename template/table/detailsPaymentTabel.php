<?php
include('../../Common/check.php'); 
include_once('../../Common/function.php');
$url = $config_host . '/service/sto/manage/stoList';
if($_SESSION['stoType']==1){
	$datas=array('datas'=>array(
		'pid'=>$_SESSION['stoId']
	));
}else{
	$datas=array('datas'=>array(
		'stoId'=>$_SESSION['stoId']
	));
}
$json = http($url,$datas,1);
$store=$json['datas']['list'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-收支报表</title>
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
						<?php if ($_SESSION['stoType'] == 1) { ?>
					    <div class="layui-inline">
					    	<label class="layui-form-label">门店</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="stoId">
							    	<option value="">请选择...</option>
                                    <?php 
                                    foreach ($store as $info){
							    	?>
                                    <option value="<?php echo $info["stoId"];?>"><?php echo $info["name"];?></option>
                                    <?php }?>
                                </select>
					    	</div>
					    </div>
					    <?php }?>
					    <div class="layui-inline">
					    	<label class="layui-form-label">日期</label>
					    	<div class="layui-input-inline" style="width: 120px;">
					    		<input type="text" class="Wdate layui-input" id="logmin" ng-model="staDate" placeholder="请选择..."  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{\'%y-%M-%d\'}'})">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">收支</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="inOrOut">
							    	<option value="">请选择...</option>
                                    <option value="1">收入</option>
                                    <option value="-1">支出</option>
                                </select>
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>收支报表</h5>
					<div class="ibox-tools">
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="inconme-spending">
						<span>收入：<b class="c-green">{{financeStatement.inAmount}}</b></span>
						<span>支出：<b class="c-red">{{financeStatement.outAmount}}</b></span>
						<span>盈亏：<b class="c-blue">{{financeStatement.inAmount+financeStatement.outAmount}}</b></span>
					</div>
					<div class="con-table">
						<table  class="layui-table">
							<thead>
								<tr class="text-c">
									<th width="20%">项目/商品</th>
									<th width="12%">数量</th>
									<th width="18%">收支金额</th>
									<th class="text-l">备注</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td>{{item.name}}</td>
									<td>{{item.quantity}}</td>
									<td ng-if="item.amount>0" class="c-green">+{{item.amount}}</td>
									<td ng-if="item.amount<0" class="c-red">{{item.amount}}</td>
									<td ng-if="item.amount==0">{{item.amount}}</td>
									<td class="text-l">{{item.note}}</td>
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
        	$scope.inmoney = 0;
        	$scope.outmoney = 0;
        	$scope.invmoney = 0;
            var postData = {
                type: 'paymentlist',
                stoId: $scope.stoId,
                inOrOut: $scope.inOrOut,
                staDate: $scope.staDate,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/detailsPaymentTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.financeStatement = result.data.financeStatement;
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
        $scope.resetSearch = function () {
            $scope.staDate = undefined;
            $scope.inOrOut = undefined;
            $scope.stoId = undefined;
    	}
        $scope.reExcel = function (){
        	var datas = new Array();
        	datas = {};
            datas["type"] = 'excel';
            datas["stoId"] = $scope.stoId,
            datas["inOrOut"] = $scope.inOrOut,
            datas["staDate"] = $scope.staDate ? $scope.staDate : null,
            datas["currentPage"] = 1,
            datas["itemsPerPage"] = 10000,
            postData = angular.toJson(datas);
            window.location.href="../../Controller/table/detailsPaymentTabelAction.php?postData="+postData;
        }
    });
</script>
</body>
</html>