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
$json = postData($url,$datas);
$store=$json['datas']['list']; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-商品销售排行</title>
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
					    	<label class="layui-form-label">销售渠道</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="saleChannl">
							    	<option value="">请选择...</option>
                                    <option value="1">门店</option>
                                    <option value="2">商城</option>
                                </select>
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">商品名称</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					    		<input type="text" class="layui-input" ng-model="productname" id="productname" placeholder="请输入商品名称">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" ng-model="logmin" id="logmin" placeholder="请选择开始时间"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" ng-model="logmin" id="logmax" placeholder="请选择结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>商品销售排行榜</h5>
					<div class="ibox-tools">
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table  class="layui-table" style="min-width: 800px;">
							<thead>
								<tr class="text-c">
									<th width="6%">排序</th>
									<th class="text-l" width="18%">商品名称</th>
									<th class="text-l">门店名称</th>
									<th width="10%">销售渠道</th>
									<th width="14%">销售金额</th>
									<th width="14%">金额占比</th>
									<th width="14%">销售数量</th>
									<th width="14%">数量占比</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td>{{$index+1}}</td>
									<td class="text-l">{{item.goodsName}}</td>
									<td class="text-l">{{item.storeName}}</td>
									<td ng-if="item.channel=='1'">门店</td>
									<td ng-if="item.channel=='2'">商城</td>
									<td ng-if="item.channel==''">门店</td>
									<td>{{item.realSum}}</td>
									<td ng-if="item.proportionAmount==''">0%</td>
									<td ng-if="item.proportionAmount!=''">{{item.proportionAmount}}%</td>
									<td>{{item.quantity}}</td>
									<td ng-if="item.proportionQuantity==''">0%</td>
									<td ng-if="item.proportionQuantity!=''">{{item.proportionQuantity}}%</td>
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
    	$scope.total = 0;
        var reSearch = function () {
            var postData = {
                type: 'SaleTablelist',
                stoId: $scope.stoId,
                orderType: $scope.saleChannl,
                goodsName: $("#productname").val(),
                createDateStart: $("#logmin").val(),
                createDateEnd: $("#logmax").val(),
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/goodsSaleTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        	$scope.saleChannl = "";
        	$scope.stoId = "";
        }
        $scope.reExcel = function (){
            var goodsName = $("#productname").val();
            var createDateStart = $("#logmin").val();
            var createDateEnd = $("#logmax").val();
            var stoId = $scope.stoId;
            var orderType = $scope.saleChannl;
            window.location.href="../../Controller/table/goodsSaleTabelAction.php?goodsName="+goodsName+"&createDateStart="+createDateStart+"&createDateEnd="+createDateEnd+"&stoId="+stoId+"&orderType="+orderType+"&type=excel";
        }
    });
</script>
</body>
</html>