<?php
include('../../Common/check.php');
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-原料入库详情</title>
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
					<h5>入库原料</h5>
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
							<span>入库数量：{{quantity}}</span>
							<span>入库总额：{{sum}}</span>
							<span>入库时间：{{inDate}}</span>
							<!-- <span>入库类型：采购入库</span> -->
							<span>入库员：{{personName}}</span>
						</div>
						<div class="con-table">
							<table class="layui-table" style="min-width: 1300px;">
								<thead>
									<tr class="text-c">
										<th>原料编码</th>
										<th width="14%" class="text-l">原料名称</th>
										<th width="12%">原料类别</th>
										<th width="6%">单位</th>
										<th width="10%">规格</th>
										<th width="8%">原料标准价</th>
										<th width="8%">入库单价</th>
										<th width="7%">入库数量</th>
										<th width="10%">入库金额</th>										
										<th width="10%">当前库存</th>
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
										<td>{{item.inPrice ? item.inPrice : 0}}</td>
										<td>{{item.inStock ? item.inStock : 0}}</td>
										<td>{{item.amount ? item.amount : 0}}</td>
										<td>{{item.stockQty ? item.stockQty : 0}}</td>
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
            $http.post('../../Controller/psi/listMaterialStorageAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.no = result.data.inStockInfo.no;
                $scope.quantity = result.data.inStockInfo.quantity;
                $scope.sum = result.data.inStockInfo.sum;
                $scope.inDate = result.data.inStockInfo.inDate;
                $scope.personName = result.data.inStockInfo.personName;
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
            window.location.href="../../Controller/psi/listMaterialStorageAction.php?id="+id+"&type=indetailsexcel";
        }
    });
</script>
</body>
</html>