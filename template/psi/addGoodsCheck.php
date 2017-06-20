<?php
include('../../Common/check.php');
session_start();
if (isset($_SESSION['checked'])) {
	$checked = implode(',', array_filter($_SESSION['checked']));
} else {
	$checked = '';
}
if (isset($_SESSION['skuId'])) {
	$skuId = implode(',', array_filter($_SESSION['skuId']));
} else {
	$skuId = '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-选择商品</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
	<script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper ags-wrapper" ng-controller="listController">
		<div class="content">
			<div class="wbox">
				<div class="wbox-content">
					<div class="ags-left">
						<h2>商品分类</h2>
						<ul class="ags-category">
							<li ng-repeat="itemCat in cat" ng-click="li_click(itemCat.catId)"><a href="">{{itemCat.name}}</a></li>
						</ul>
					</div>
					<div class="con-table ags-right">
						<table class="layui-table" style="min-width: 600px;">
							<thead>
								<tr class="text-c">
									<th><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
									<th>商品编码</th>
									<th width="22%" class="text-l">商品名称</th>
									<th width="18%">规格</th>
									<th width="10%">单位</th>
									<th width="18%">当前库存</th>
								</tr>
							</thead>
							<tbody>
							<tr class="text-c" ng-repeat="good in goods">
								<td><input type="checkbox" ng-model="$parent.conf[good.goodsId+good.skuId]" ng-change="selectOne(good.skuId)"/></td>
								<td>{{good.no}}</td>
								<td>{{good.name}}</td>
								<td>{{good.skuName}}</td>
								<td>{{good.unit}}</td>
								<td>{{good.storeNum}}</td>
							</tr>
							</tbody>
						</table>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" value="添加" ng-click="addGood()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetaddGood()"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/layui.js"></script>
<script type="text/javascript">
	var app = angular.module('myApp', []);
	app.controller('listController', function ($scope, $http) {
		var c = '<?php echo $checked;?>'
		var s = '<?php echo $skuId;?>'
		$scope.checked = c.split(",");
		$scope.skuId = s.split(",");
		$scope.conf = [];
		var postData = {
			type: 'cat',
		};
		$http.post('../../Controller/psi/listGoodsCheckAction.php', postData).then(function (result) {  //正确请求成功时处理
			$scope.cat = result.data.list;
		}).catch(function () { //捕捉错误处理
			layer.msg('服务端请求错误！', {time: 3000});
		});
		$scope.li_click = function (i) {
			$scope.selAllId = i;
			$scope.select_all = false;
			var postData = {
				type: 'goods',
				catId: i,
			};
			$http.post('../../Controller/psi/listGoodsCheckAction.php', postData).then(function (result) {  //正确请求成功时处理
				$scope.goods = result.data.list;
				angular.forEach(result.data.list, function (item) {
					if ($scope.checked[0] != '') {
						angular.forEach($scope.checked, function (items) {
							if (item.goodsId == items) {
								$scope.conf[item.goodsId] = true;
							}
						})
					}
					if ($scope.skuId[0] != '') {
						angular.forEach($scope.skuId, function (skus) {
							if (item.skuId == skus) {
								$scope.conf[item.goodsId + item.skuId] = true;
							}
						})
					}
				})
			}).catch(function () { //捕捉错误处理
				layer.msg('服务端请求错误！', {time: 3000});
			});
		}
		$scope.selectAll = function () {
			if ($scope.select_all) {
				angular.forEach($scope.goods, function (item) {
					if (item.catId == $scope.selAllId) {
						$scope.conf[item.goodsId + item.skuId] = true;
						if (item.skuId == '') {
							$scope.checked.push(item.goodsId);
						} else {
							$scope.skuId.push(item.skuId);
						}
					}
				})
			} else {
				angular.forEach($scope.goods, function (item) {
					if (item.catId == $scope.selAllId) {
						$scope.conf[item.goodsId + item.skuId] = false;
						$scope.checked = [];
						$scope.skuId = [];
					}
				})
			}
		};
		$scope.selectOne = function (id) {
			if (id == '') {
				angular.forEach($scope.goods, function (item) {
					var index = $scope.checked.indexOf(item.goodsId);
					if ($scope.conf[item.goodsId] && index === -1) {
						$scope.checked.push(item.goodsId);
					} else if (!$scope.conf[item.goodsId] && index !== -1) {
						$scope.checked.splice(index, 1);
					}
				})
			} else {
				angular.forEach($scope.goods, function (item) {
					var index = $scope.skuId.indexOf(item.skuId);
					if ($scope.conf[item.goodsId + item.skuId] && index === -1) {
						$scope.skuId.push(id);
					} else if (!$scope.conf[item.goodsId + item.skuId] && index !== -1) {
						$scope.skuId.splice(index, 1);
					}
				})
			}
		}
		$scope.addGood = function () {
			var postData = {
				type: 'session',
				checked: $scope.checked,
				skuId: $scope.skuId,
			};
			$http.post('../../Controller/psi/listGoodsCheckAction.php', postData).then(function (result) {  //正确请求成功时处理
				if (result.data.success) {
					var index = parent.layer.getFrameIndex(window.name);
					parent.layer.close(index);
					parent.location.reload();
				} else {
					layer.msg('服务端请求错误！', {time: 3000});
				}
			}).catch(function () { //捕捉错误处理
				layer.msg('服务端请求错误！', {time: 3000});
			});
		}
		$scope.resetaddGood = function () {
			angular.forEach($scope.goods, function (item) {
				$scope.conf[item.goodsId + item.skuId] = false;
				$scope.select_all = false;
				$scope.checked = [];
				$scope.skuId = [];
			})
		}
	})
	;
</script>
</body>
</html>