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
    <title>汇汇生活商家后台-折让</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-title">
                <h5>折让</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">新增</a>
                    <a class="btn-orange zrxe-btn" ng-click="limitModal()">折让限额</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table">
                        <thead>
                        <tr class="text-c">
                            <th width="60%">折让原因</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.reason}}</td>
                            <td>
                                <a class="btn-green new-btn" ng-click="modifyModal(item.id,item.reason)">编辑</a>
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
    <!--新增、编辑-->
    <div class="popup new-open" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">折让原因</label>
                <div class="layui-input-inline" style="width: 250px;">
                    <input name="title" placeholder="请输入折让原因" class="layui-input" ng-model="reason" type="text" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal baocun-btn" value="保存" ng-click="saveAddModal(zId)">
            </div>
        </form>
    </div>
    <div class="popup zrxe-popup" id="limit">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">折让限额</label>
                <div class="layui-input-inline" style="width: 150px;">
                    <input name="title" placeholder="请输入折让限制的额度" ng-model="limitNum" class="layui-input" type="text" autocomplete="off">
                    <!--限制为带两位小数点的金额-->
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal zr-btn" ng-click="limitSaveModal()" value="保存">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/marketing/listRebateAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        $scope.addModal = function () {
            $scope.type = 'add';
            $scope.reason = '';
            $scope.zId = '';
            layer.open({type: 1, title: "新增", area: ['350px', '150px'], shadeClose: true, resize: false, content: $("#add"),})
        }
        $scope.modifyModal = function (id, reason) {
            $scope.type = 'modify';
            $scope.reason = reason;
            $scope.zId = id;
            layer.open({type: 1, title: "编辑", area: ['350px', '150px'], shadeClose: true, resize: false, content: $("#add"),})
        }
        $scope.delModal = function (id) {
            layer.alert('亲，您确定删除该折让吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                var postData = {
                    type: 'del',
                    delId: id
                };
                $http.post('../../Controller/marketing/listRebateAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 1000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.limitModal = function () {
            layer.open({type: 1, title: "折让限额", area: ['250px', '150px'], shadeClose: true, resize: false, content: $("#limit"),});
            var postData = {type: 'check',};
            $http.post('../../Controller/marketing/listRebateAction.php', postData).then(function (result) {
                $scope.limitNum = result.data.orderCut;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.saveAddModal = function (zId) {
            var postData = {type: $scope.type, reason: $scope.reason}
            if (zId != '') {postData['id'] = zId;}
            $http.post('../../Controller/marketing/listRebateAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    layer.closeAll('page'); //关闭弹层
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 1000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.limitSaveModal = function () {
            var postData = {
                type: 'limit',
                limitNum: $scope.limitNum,
            };
            $http.post('../../Controller/marketing/listRebateAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    layer.closeAll('page'); //关闭弹层
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 1000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });
</script>
</body>
</html>