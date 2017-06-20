<?php
include('../../Common/check.php');
$no = $_GET["no"];
$id = $_GET["id"];
$invDate = $_GET["invDate"];
$amount = sprintf("%.2f", $_GET["amount"]);
$stock = $_GET["stock"];
$invAmount = sprintf("%.2f", $_GET["invAmount"]);
$invQty = $_GET["invQty"];
$minusAmount = sprintf("%.2f", $_GET["minusAmount"]);
$minusQty = $_GET["minusQty"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-原料盘点详情</title>
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
					<h5>盘点原料</h5>
					<div class="ibox-tools">
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<form>
						<div class="cprk-box">
							<span>单据编码：{{no}}</span>
							<span>库存总量：{{stock}}</span>
							<span>库存总额：{{amount}}</span>
							<span>盘点总量：{{invQty}}</span>
							<span>盘点总额：{{invAmount}}</span>
							<span>盈亏总量：{{minusQty}}</span>
							<span>盈亏总额：{{minusAmount}}</span>
							<span>盘点时间：{{invDate}}</span>
						</div>
						<div class="con-table">
							<table class="layui-table" style="min-width: 1600px;">
								<thead>
									<tr class="text-c">
										<th>原料编码</th>
										<th class="text-l" width="12%">原料名称</th>
										<th width="10%">原料类别</th>
										<th width="5%">单位</th>
										<th width="8%">规格</th>
										<th width="6%">原料标准价</th>
										<th width="6%">原料单价</th>
										<th width="6%">库存</th>
										<th width="8%">库存金额</th>
										<th width="6%">盘点数量</th>
										<th width="8%">盘点金额</th>
										<th width="5%">盈亏数量</th>
										<th width="7%">盈亏金额</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-c" ng-repeat="item in list" ng-cloak>
										<td>{{item.code}}</td>
										<td class="text-l">{{item.name}}</td>
										<td>{{item.typeName}}</td>
										<td>{{item.unit}}</td>
										<td>{{item.spec}}</td>
										<td>{{item.standardPrice ? item.standardPrice : 0}}</td>
										<td>{{item.invPrice}}</td>
										<td>{{item.stock ? item.stock : 0}}</td>
										<td>{{item.amount}}</td>
										<td>{{item.invQty ? item.invQty : 0}}</td>
										<td>{{item.invAmount ? item.invAmount : 0}}</td>
										<td>{{item.minusQty ? item.minusQty : 0}}</td>
										<td>{{item.minusAmount ? item.minusAmount : 0}}</td>
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
                type: 'inlistdetails',
                id: '<?php echo $id;?>',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/psi/listMaterialCheckAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.no = result.data.vo.no;
                $scope.stock = result.data.vo.stock;
                $scope.amount = result.data.vo.amount;
                $scope.invQty = result.data.vo.invQty;
                $scope.invAmount = result.data.vo.invAmount;
                $scope.minusQty = result.data.vo.minusQty;
                $scope.minusAmount = result.data.vo.minusAmount;
                $scope.invDate = result.data.vo.invDate;
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
        $scope.reExcel = function (){
            var id = '<?php echo $id;?>';
            window.location.href="../../Controller/psi/listMaterialCheckAction.php?id="+id+"&type=indetailsexcel";
        }
    });
</script>
</body>
</html>