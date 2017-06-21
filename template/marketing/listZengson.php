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
    <title>汇汇生活商家后台-赠送</title>
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
                <h5>赠送</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">新增</a>
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
                            <th width="60%">赠送原因</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.reason}}</td>
                            <td>
                                <a class="btn-green new-btn" ng-click="addModal(item.reason,item.id)">编辑</a>
                                <a class="btn-red del-btn" ng-click="deleteModal(item.id)">删除</a>
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
                <label class="layui-form-label">赠送原因</label>
                <div class="layui-input-inline" style="width: 250px;">
                    <input name="title" placeholder="请输入赠送原因" class="layui-input" ng-model="reason" type="text">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal baocun-btn" value="保存" ng-click="saveModal(mid)">
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
            $http.post('../../Controller/marketing/listZengsongAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.price = undefined;
            $scope.startDate = undefined;
            $scope.endDate = undefined;
            $scope.state = undefined
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function (reason, id) {
            if (reason != '') {
                $scope.reason = reason;
                $scope.mid = id;
            } else {
                $scope.reason = '';
                $scope.mid = undefined;
            }
            layer.open({
                type: 1,
                title: "新增",//标题
                area: ['350px', '150px'],//宽高
                shadeClose: true, //点击遮罩关闭
                resize: false, //禁止拉伸
                content: $("#add"),//也可将html写在此处
            });
        }
        $scope.saveModal = function (id) {
            if (angular.isDefined(id)) {
                var type = 'modify';
                var msg = '修改成功！';
            } else {
                var type = 'add';
                var msg = '恭喜你，新增赠送成功！';
            }
            var postData = {
                type: type,
                reason: $scope.reason,
            };
            if (angular.isDefined(id)) {
                postData['mid'] = id;
            }
            $http.post('../../Controller/marketing/listZengsongAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(msg, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.deleteModal = function (id) {
            layer.alert('您确定删除该赠送原因吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                var postData = {
                    type: 'delete',
                    dId: id,
                };
                $http.post('../../Controller/marketing/listZengsongAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg('删除成功！', {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
    });
</script>
</body>
</html>