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
    <title>汇汇生活商家后台-客流宝管理</title>
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
					<h5>客流宝管理</h5>
					<div class="ibox-tools">
						<a class="btn-blue details-btn" ng-click="modifyModal()">添加设备</a>
						<a class="btn-red del-btn" ng-click="delModal()">删除</a>
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
									<th class="text-l">客流宝名称</th>
									<th width="20%">客流宝ID</th>
									<th width="20%">客流宝秘钥</th>
									<th width="20%">客流宝code</th>
									<th width="15%">操作</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"/></td>
									<td class="text-l">{{item.klbName}}</td>
									<td>{{item.klbSn}}</td>
									<td>{{item.klbApiKey}}</td>
									<td>{{item.klbShopCode}}</td>
									<td>
										<a class="btn-green details-btn" ng-click="modifyModal(item,'modify')">修改</a>
										<a class="btn-red goods-delbtn" ng-click="delModal(item.id)">删除</a>
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
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'Klblist',
                stoId: $scope.stoId,
                keyword: $scope.keyword,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/cashier/listKlbAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        	$scope.keyword = "";
        	$scope.stoId = "";
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
        $scope.delModal = function (id) { //员工删除
        	if (angular.isUndefined(id)) {
            	var ids = $scope.checked;
            } else {
                var ids = id;
            }
            var postData = {type: 'del', id: ids};
            layer.alert('亲，您确定删除该客流宝记录吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/cashier/listKlbAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        console.log($scope.checked);
        $scope.modifyModal = function (item,type) {//修改员工信息
            if(type=="modify"){
            	layer.open({
	        		type: 2,
	        		title: '修改客流宝',
	        		area : ['470px' , '100%'],
	        		anim: '2',
	        		resize: false,
	        		move: false,
	        		shadeClose: true,
	        		offset: ['0', '0'],
	        		content: 'detailsKlb.php?id='+item.id+'&klbName='+item.klbName+'&klbSn='+item.klbSn+'&klbApiKey='+item.klbApiKey+'&klbShopCode='+item.klbShopCode,
	        	});
            }else{
            	layer.open({
	        		type: 2,
	        		title: '添加客流宝',
	        		area : ['470px' , '100%'],
	        		anim: '2',
	        		resize: false,
	        		move: false,
	        		shadeClose: true,
	        		offset: ['0', '0'],
	        		content: 'detailsKlb.php',
	        	});
            }
        };
        $scope.reExcel = function (){
            var stoId = $scope.stoId;
            var keyword = $scope.keyword;
            window.location.href="../../Controller/cashier/listKlbAction.php?stoId="+stoId+"&keyword="+keyword+"&type=excel";
        }
    });
</script>
</body>
</html>