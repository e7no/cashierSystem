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
    <title>汇汇生活商家后台-收支汇总</title>
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
					    	<label class="layui-form-label">收支项目</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					        	<input type="text" class="layui-input" ng-model="IncomeTitle" placeholder="请输入查找的收支项目">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">收入支出</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="IncomeType">
							    	<option value="">请选择...</option>
                                    <option value="1">收入</option>
                                    <option value="2">支出</option>
                                </select>
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" ng-model="Incomelogmin" id="logmin" placeholder="请选择开始时间"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" ng-model="Incomelogmax" id="logmax" placeholder="请选择结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>收支汇总</h5>
					<div class="ibox-tools">
						<a class="btn-green" href="javascript:;">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="inconme-spending">
						<span>收入：6488元</span>
						<span>支出：88元</span>
					</div>
					<div class="con-table">
						<table class="layui-table">
							<thead>
								<tr class="text-c">
									<th class="text-l">收支项目</th>
									<th width="30%">收支时间</th>
									<th width="20%">收支金额</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c">
									<td class="text-l">2017年03月23日营业收入结算款</td>
									<td>2017-02-20 09:00</td>
									<td class="c-green">+ 888.00</td>
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
                type: 'list',
                discountName: $scope.IncomeTitle,
                discountWay: $scope.discountWay?$scope.discountWay:undefined,
                discountType: $scope.discountType?$scope.discountType:undefined,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/finance/listIncomeAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
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
        $scope.addAreaModal=function(){layer.open({type: 1, title: "添加桌台区域", area: ['275px', '190px'], shadeClose: true, resize: false, content: $("#addArea"),});}
        $scope.addTableModal=function(){
        	layer.open({
    			type: 1,
    			title: "添加桌台",//标题
    			area: ['400px', '190px'],//宽高
    			shadeClose: true, //点击遮罩关闭
    			resize: false, //禁止拉伸
    			content: $("#add"),//也可将html写在此处
    		});
        }
        $scope.TableModal=function(areaType){
        	var postData = {
                    type: 'list',
                    areaType:areaType,
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
        $scope.saveAreaModal=function(){
            var postData = {
                type: 'addArea',
                name: $scope.name,
                additionalFee: $scope.TeaPrice,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
            	if (result.data.success) {
            		layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    window.location.href=window.location.href;
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
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
        $scope.delTableModal = function (id) { //桌台删除
        	if (angular.isUndefined(id)) {var ids = $scope.checked;} else {var ids = id;}
            var postData = {type: 'Tabledel', id: ids};
            layer.alert('亲，您确定删除选中的桌台吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/cashier/viceScreenAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        $scope.modifyTableModal = function (item) {//修改桌台信息
        	layer.open({
    			type: 1,
    			title: "修改桌台",//标题
    			area: ['400px', '190px'],//宽高
    			shadeClose: true, //点击遮罩关闭
    			resize: false, //禁止拉伸
    			content: $("#modify"),
    		});
        	$scope.modalData = item;
            $scope.type = 'modify';
    	}
        $scope.savaTableModal = function (data) {//桌台信息修改
            var postData = {
            		type: 'modifyTable',
            		id: data.id,
                    name: "桌台"+data.sn+"号",
                    galleryful: data.galleryful,
                    areaType: data.areaType,
                    additionalFee: data.additionalFee
            };
            $http.post("../../Controller/cashier/viceScreenAction.php", postData).then(function (result) {
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.saveTableModal=function(){
            var postData = {
                type: 'addTable',
                name: "桌台"+$scope.tablenum+"号",
                galleryful: $scope.tablecount,
                areaType: $('#chooseId').val(),
                additionalFee: $scope.tableprice
            };
            if($('#chooseId').val()==""){
            	layer.msg('请选择一个左边区域', {time: 3000});
            	return false;
            }else if($scope.tablenum==""){
            	layer.msg('请输入桌台号', {time: 3000});
            	return false;
            }else if($scope.tablecount==""){
            	layer.msg('请输入就餐人数', {time: 3000});
            	return false;
            }else if($scope.tableprice==""){
            	layer.msg('请输入茶位费', {time: 3000});
            	return false;
            }
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
            	if (result.data.success) {
            		layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    window.location.href=window.location.href;
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.delAreaModal=function(){
            var ids = $('#chooseId').val();
            var postData = {
                type: 'delArea',
                ids: ids
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
            	if (result.data.success) {
            		layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，删除成功！', {icon: 6, time: 1500});
                    window.location.href=window.location.href;
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });
    $(".counter-qy ul").find("li").click(function(){
        if ($(this).find("input[type=radio]").is(":checked")) {
            $(this).siblings('li').removeClass('active');
            $(this).addClass("active");
            $('#chooseId').val($(this).find("input[type=radio]").val());
        }
    })
</script>
</body>
</html>