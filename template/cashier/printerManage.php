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
    <title>汇汇生活商家后台-打印机管理</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
    <script src="../../js/angular.min.js"></script>
	<script src="../../js/angular-cookies.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
	<body ng-app="myApp">
		<div class="wrapper" ng-controller="listController">
			<div class="wbox">
				<div class="wbox-title">
					<h5>打印机列表</h5>
					<div class="ibox-tools">
						<a class="btn-blue news-btn" ng-click="addPrinterModal()">添加打印机</a>
						<a class="btn-red del-btn" ng-click="delPrinterModal()">删除</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table class="layui-table" style="min-width: 1000px;">
							<thead>
								<tr class="text-c">
									<th width="3%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
									<th width="16%">打印机编号</th>
									<th class="text-l" width="20%">打印机名称</th>
									<th width="18%">打印机IP</th>
									<th width="12%">打印规格</th>
									<th width="10%">打印内容</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list">
									<td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"></td>
									<td>{{item.catId}}</td>
									<td class="text-l">{{item.name}}</td>
									<td>{{item.ipAddress}}</td>
									<td>{{item.spec}}</td>
									<td><a ng-click="SearchPrinterModal(item.id)" class="view-btn">查看</a></td>
									<td>
										<a class="btn-green news-btn" ng-click="modifyPrinterModal(item.id)">修改</a>
										<a class="btn-red del-btn" ng-click="delPrinterModal(item.id)">删除</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<tm-pagination conf="paginationConf"></tm-pagination>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination', 'ngCookies']);
    app.controller('listController', function ($scope, $http,$cookies) {
		if ($cookies.get("currentPage") != '') {
			$scope.currentPage = $cookies.get("currentPage");
		}
        var reSearch = function () {
            var postData = {
                type: 'priterlist',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.paginationConf = {//配置分页基本参数
            currentPage: $scope.currentPage?$scope.currentPage:1, //起始页
            itemsPerPage: 2, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addPrinterModal=function(){//添加打印机
        	layer.open({
        		type: 2,
        		title: "新增打印机",//标题
        		area: ['100%', '100%'],//宽高
    			shadeClose: true, //点击遮罩关闭
    			resize: false, //禁止拉伸
    			offset: ['0', '0'],
    			content: 'addPrinter.php',//也可将html写在此处
    		});
        }
        $scope.checked = [];
        $scope.selectAll = function () {
            if ($scope.select_all) {
                $scope.checked = [];
                angular.forEach($scope.list, function (item) {
                    item.checked = true;
                    $scope.checked.push(item.id);
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    item.checked = false;
                    $scope.checked = [];
                })
            }
        };
        $scope.selectOne = function () {
            angular.forEach($scope.list, function (item) {
                var index = $scope.checked.indexOf(item.id);
                if (item.checked && index === -1) {
                    $scope.checked.push(item.id);
                } else if (!item.checked && index !== -1) {
                    $scope.checked.splice(index, 1);
                }
                ;
            })
            if ($scope.list.length === $scope.checked.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.delPrinterModal = function (id) { //桌台删除
        	if (angular.isUndefined(id)) {var ids = $scope.checked;} else {var ids = id;}
            var postData = {type: 'Printerdel', id: ids};
            layer.alert('亲，您确定删除选中的打印机吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/cashier/viceScreenAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        $scope.modifyPrinterModal = function (id) {//修改打印机信息
			var currentPage= $scope.paginationConf.currentPage;
			if (currentPage != '') {
				$cookies.put("currentPage", currentPage, {expires: new Date(new Date().getTime() + 36000)});
			}
        	layer.open({
        		type: 2,
        		title: "修改打印机",//标题
        		area: ['100%', '100%'],//宽高
    			shadeClose: true, //点击遮罩关闭
    			resize: false, //禁止拉伸
    			offset: ['0', '0'],
    			content: 'editPrinter.php?id='+id,//也可将html写在此处
    		});
    	}
    	$scope.SearchPrinterModal = function (id) {//修改打印机信息
    		/*查看打印内容*/
    		layer.open({
    			type: 2,
    			title: '打印内容',
    			area : ['100%' , '100%'],
    			anim: '2',
    			resize: false,
    			move: false,
    			shadeClose: true,
    			offset: ['0', '0'],
    			content: 'printerContent.php?id='+id,
    		});
    	}
    });
</script>
</body>
</html>