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
    <title>汇汇生活商家后台-订单明细</title>
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
					    	<label class="layui-form-label">单号</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					    		<input type="text" class="layui-input" ng-model="no" placeholder="请输入订单号">
					    	</div>
					    </div>
					    <?php if ($_SESSION['stoType'] == 1) { ?>
						<div class="layui-inline">
					    	<label class="layui-form-label">门店</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="stoId">
							    	<option value="">请选择...</option>
                                    <?php 
                                    foreach ($store as $info){
							    	?>
                                    <option value="<?php echo $info["stoId"];?>,<?php echo $info["stoType"];?>"><?php echo $info["name"];?></option>
                                    <?php }?>
                                </select>
					    	</div>
					    </div>
					    <?php }?>
					    <div class="layui-inline">
					    	<label class="layui-form-label">订单类型</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="listType">
							    	<option value="">请选择...</option>
                                    <option value="1">当面付订单</option>
                                    <option value="2">门店订单</option>
                                    <option value="3">商城订单</option>
                                </select>
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input class="Wdate layui-input" id="logmin" placeholder="请选择..." onchange="" ng-model="createDateStart" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" type="text">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" id="logmax" ng-model="createDateEnd" placeholder="请选择..." onchange="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>订单明细</h5>
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
									<th width="15%">单号</th>
									<th width="10%">订单类型</th>
									<th class="text-l">门店名称</th>
									<th width="15%">时间</th>
									<th width="9%">消费金额</th>
									<th width="9%">优惠金额</th>
									<th width="9%">实付金额</th>
									<th width="8%">支付方式</th>
									<th width="6%">详情</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td>{{item.no}}</td>
									<td ng-if="item.orderType==1 || item.orderType==4">当面付订单</td>
									<td ng-if="item.orderType==2">门店订单</td>
									<td ng-if="item.orderType==3 || item.orderType==5">商城订单</td>
									<td class="text-l">{{item.storeName}}</td>
									<td>{{item.createDate}}</td>
									<td>{{item.total ? item.total : 0}}</td>
									<td>{{item.offSum ? item.offSum : 0}}</td>
									<td>{{item.realSum ? item.realSum : 0}}</td>
									<!-- 支付方式：1-钱包，2-微信，3-支付宝，4-汇币，5-现金，6-刷卡，7-会员余额，8-会员积分，9-复合支付 -->
									<td ng-if="item.payType==1">钱包支付</td>
									<td ng-if="item.payType==2">微信支付</td>
									<td ng-if="item.payType==3">支付宝支付</td>
									<td ng-if="item.payType==4">汇币支付</td>
									<td ng-if="item.payType==5">现金支付</td>
									<td ng-if="item.payType==6">刷卡支付</td>
									<td ng-if="item.payType==7">会员卡支付</td>
									<td ng-if="item.payType==8">积分支付</td>
									<td ng-if="item.payType==9">复合支付</td>
									<td ng-if="item.payType==0"></td>
									<td><a class="check-btn" ng-click="details(item.ordId)">查看</a></td>
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
        	var arr = [];
        	if(angular.isDefined($scope.stoId)){
        		arr = $scope.stoId.split(",");
            }
            var postData = {
                type: 'orderSumlist',
                stoId: arr[0],
                stoType: arr[1],
                listType: $scope.listType,
                createDateStart: $scope.createDateStart,
                createDateEnd: $scope.createDateEnd,
                no: $scope.no,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/orderSumTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        $scope.resetSearch = function () {
            $scope.stoId = undefined;
            $scope.listType = undefined;
            $scope.no = undefined;
            $scope.createDateStart = undefined;
            $scope.createDateEnd = undefined;
    	}
    	$scope.details = function (id) {
    		layer.open({
    			type: 2,
    			title: '订单详情',
    			area : ['460px' , '100%'],
    			anim: '0',
    			resize: false,
    			move: false,
    			shadeClose: true,
    			offset: 't',
    			offset: 'l',
    			content: 'detailsOrder.php?id='+id,
    		});
    	}
        $scope.reExcel = function (){
            var arr = [];
        	if(angular.isDefined($scope.stoId)){
        		arr = $scope.stoId.split(",");
            }
        	var datas = new Array();
        	datas = {};
            datas["type"] = 'excel';
            datas["stoId"] = arr[0];
            datas["stoType"] = arr[1],
            datas["listType"] = $scope.listType,
            datas["createDateStart"] = $scope.createDateStart ? $scope.createDateStart : null,
            datas["createDateEnd"] = $scope.createDateEnd ? $scope.createDateEnd : null,
            datas["no"] = $scope.no,
            datas["currentPage"] = 1,
            datas["itemsPerPage"] = 10000,
            postData = angular.toJson(datas);
            window.location.href="../../Controller/table/orderSumTabelAction.php?postData="+postData;
        }
    });
</script>
</body>
</html>