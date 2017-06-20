<?php
include('../../Common/check.php');
$id = $_GET['id'];
if ($id == '') {
	echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新查询！\',{icon: 5,time:2000});</script>';
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<title>汇汇生活商家后台-原料报废详情</title>
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
			<div class="wbox-title">
				<h5>报废原料</h5>
				<div class="ibox-tools">
					<a class="btn-green" id="excel">导出</a>
					<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
						<i class="iconfont will-shuaxin"></i>
					</a>
				</div>
			</div>
			<div class="wbox-content">
				<form>
					<div class="cprk-box">
						<span>单据编码：{{outStockInfo.no}}</span>
						<span>报废总量：{{outStockInfo.quantity}}</span>
						<span>报废总额：{{outStockInfo.amount}}</span>
						<span>报废时间：{{outStockInfo.scrapDate}}</span>
					</div>
					<div class="con-table">
						<table class="layui-table" style="min-width: 1300px;">
							<thead>
							<tr class="text-c">
								<th>原料编码</th>
								<th width="14%">原料名称</th>
								<th width="12%">原料类别</th>
								<th width="6%">单位</th>
								<th width="10%">规格</th>
								<th width="8%">原料标准价</th>
								<th width="8%">原料单价</th>
								<th width="7%">报废数量</th>
								<th width="10%">报废金额</th>
								<th width="10%">当前库存数量</th>
							</tr>
							</thead>
							<tbody>
							<tr class="text-c" ng-repeat="item in list">
								<td>{{item.code}}</td>
								<td>{{item.name}}</td>
								<td>{{item.typeName}}</td>
								<td>{{item.unit}}</td>
								<td>{{item.spec}}</td>
								<td>{{item.standardPrice}}</td>
								<td>{{item.scrapPrice}}</td>
								<td>{{item.scrapStock}}</td>
								<td>{{item.amount}}</td>
								<td>{{item.stockQty}}</td>
							</tr>
							</tbody>
						</table>
					</div>
					<tm-pagination conf="paginationConf"></tm-pagination>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js" ></script>
<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
<script type="text/javascript">
	var app = angular.module('myApp', ['tm.pagination']);
	app.controller('listController', function ($scope, $http) {
		var reSearch = function () {
			var postData = {
				type: 'details',
				id: '<?php echo $id;?>',
				currentPage: $scope.paginationConf.currentPage,
				itemsPerPage: $scope.paginationConf.itemsPerPage,
			};
			$http.post('../../Controller/psi/listMaterialScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
				$scope.paginationConf.totalItems = result.data.total;
				$scope.list = result.data.list;
				$scope.outStockInfo = result.data.outStockInfo;
			}).catch(function () { //捕捉错误处理
				layer.msg('服务端请求错误！', {time: 3000});
			});
		}
		$scope.reSearch = reSearch;
		$scope.paginationConf = {//配置分页基本参数
			currentPage: 1, //起始页
			itemsPerPage: 20, // 每页展示的数据条数
			perPageOptions: [20, 30, 50] //可选择显示条数的数组
		};
		$scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
		$('#excel').click(function () {
			var id = '<?php echo $id;?>';
			layer.msg('数据导出中，请耐心等待....！', {time: 2500});
			window.location.href = '../../Controller/Excel/detailsMaterialScrapExcel.php?id=' + id;
		});
	});
</script>
</body>
</html>