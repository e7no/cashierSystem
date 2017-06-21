<?php
include('../../Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-折扣</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
    <script src="../../js/angular-cookies.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wboxform">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">折扣名称</label>
                        <div class="layui-input-inline" style="width: 160px;">
                            <input type="text" class="layui-input" ng-model="discountName" placeholder="请输入查找的折扣名称">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">折扣方式</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="discountWay">
                                <option value="">请选择...</option>
                                <option value="1">全单打折</option>
                                <option value="2">特定商品打折</option>
                                <option value="3">第二件商品打折</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="discountType">
                                <option value="">请选择...</option>
                                <option value="0">未开始</option>
                                <option value="1">已启用</option>
                                <option value="2">已关闭</option>
                                <option value="3">已过期</option>
                            </select>
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>折扣</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">新增折扣</a>
                    <a class="btn-red del-btn" ng-click="delModal()">删除</a>
                    <!--                    <a class="btn-delete" ng-click="deleteModal()"><i class="iconfont will-huishou"></i></a>-->
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1200px;">
                        <thead>
                        <tr class="text-c">
                            <th width="4%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                            <th width="8%">折扣名称</th>
                            <th width="8%">折扣方式</th>
                            <th width="8%">折扣百分比</th>
                            <th width="13%">开始时间</th>
                            <th width="13%">结束时间</th>
                            <th width="8%">状态</th>
                            <th width="6%">明细</th>
                            <th width="15%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td width="4%"><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"/></td>
                            <td>{{item.name}}</td>
                            <td ng-if="item.type==1">全单打折</td>
                            <td ng-if="item.type==2">特定商品打折</td>
                            <td ng-if="item.type==3">第二件打折</td>
                            <td>{{item.discount*100|number:0}}%</td>
                            <td>{{item.startDate|limitTo:10}}</td>
                            <td>{{item.endDate|limitTo:10}}</td>
                            <td class="c-red" ng-if="item.status==0">未开始</td>
                            <td class="c-green" ng-if="item.status==1">启用中</td>
                            <td class="c-red" ng-if="item.status==2">已停用</td>
                            <td class="c-red" ng-if="item.status==3">已过期</td>
                            <td><a class="view-btn" ng-click="checkModal(item.id)">查看</a></td>
                            <td>
                                <a class="btn-orange close-btn" ng-if="item.status==1" ng-click="dealModal(item.id,'close')">关闭</a>
                                <a class="btn-blue start-btn" ng-if="item.status==2" ng-click="dealModal(item.id,'open')">启用</a>
                                <a class="btn-green" ng-click="editModal(item.id)">编辑</a>
                                <a class="btn-red del-btn" ng-click="delModal(item.id)">删除</a>
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
<script type="text/javascript" src="../../js/layui.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination', 'ngCookies']);
    app.controller('listController', function ($scope, $http, $cookies) {
        if ($cookies.get("discountName") != '') {
            $scope.discountName = $cookies.get("discountName");
        }
        if ($cookies.get("discountWay") != '') {
            $scope.discountWay = $cookies.get("discountWay");
        }
        if ($cookies.get("discountType") != '') {
            $scope.discountType = $cookies.get("discountType");
        }
        var reSearch = function () {
            var postData = {
                type: 'list',
                discountName: $scope.discountName,
                discountWay: $scope.discountWay ? $scope.discountWay : undefined,
                discountType: $scope.discountType ? $scope.discountType : undefined,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.discountName = undefined, $scope.discountWay = undefined, $scope.discountType = undefined
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {
            layer.open({
                type: 2,
                title: "新增折扣",
                area: ['632px', '100%'],
                shadeClose: true,
                resize: false,
                offset: ['0', '0'],
                content: 'detailsDiscountAdd.php',
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
            })
            if ($scope.list.length === $scope.checked.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.dealModal = function (id, type) {
            if (type == 'open') {
                var msg = '亲，您确定重新启用该打折项目吗?';
                var state = '开启';
                var num = 3;
            }
            if (type == 'close') {
                var msg = '亲，您确定关闭该打折项目吗?';
                var state = '关闭';
                var num = 5;
            }
            layer.alert(msg, {icon: num, resize: false, title: state,}, function (index) {
                var postData = {type: type, id: id,};
                $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.delModal = function (id) {
            if (angular.isUndefined(id)) {
                var ids = $scope.checked;
            } else {
                var ids = id;
            }
            if (ids == '') {
                layer.msg('请选择需要删除的折扣！', {time: 3000});
            } else {
                layer.alert('亲，您确定删除选中打折项目吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                    var postData = {type: 'del', ids: ids,};
                    $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if (result.data.success) {
                            layer.msg(result.data.message, {icon: 6, time: 1000});
                            return reSearch();
                        } else {
                            layer.msg(result.data.message, {time: 3000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    });
                });
            }
        }
        $scope.checkModal = function (id) {
            layer.open({
                type: 2,
                title: "查看",
                area: ['470px', '100%'],
                shadeClose: true,
                resize: false,
                offset: ['0', '0'],
                content: 'viewDiscount.php?id=' + id,
            });
        }
        $scope.editModal = function (id) {
            var discountName = $scope.discountName ? $scope.discountName : '';
            var discountWay = $scope.discountWay ? $scope.discountWay : '';
            var discountType = $scope.discountType ? $scope.discountType : '';
            if (discountName != '') {
                $cookies.put("discountName", discountName, {expires: new Date(new Date().getTime() + 36000)});
            }
            if (discountWay != '') {
                $cookies.put("discountWay", discountWay, {expires: new Date(new Date().getTime() + 36000)});
            }
            if (discountType != '') {
                $cookies.put("discountType", discountType, {expires: new Date(new Date().getTime() + 36000)});
            }
            layer.open({
                type: 2,
                title: "编辑",
                area: ['632px', '100%'],
                shadeClose: true,
                resize: false,
                offset: ['0', '0'],
                content: 'detailsDiscountEdit.php?id=' + id,
            });
        }
    });
</script>
</body>
</html>