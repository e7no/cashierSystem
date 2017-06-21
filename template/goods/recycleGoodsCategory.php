<?php
include('../../Common/check.php');
$stoType = $_SESSION['stoType'];
$downGoods = $_SESSION['authDownGoods'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品分类-回收站</title>
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
                <h5>商品分类</h5>
                <div class="ibox-tools">
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width:800px;">
                        <thead>
                        <tr class="text-c">
                            <th width="26%">商品分类</th>
                            <th width="22%">修改时间</th>
                            <th width="13%">前台排序</th>
                            <th width="15%">操作员</th>
                            <?php if ($downGoods == 1 || $stoType != 1) { ?>
                            <td>操作</td>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.name}}</td>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.sn}}</td>
                            <td>{{item.operator}}</td>
                            <?php if ($downGoods == 1 || $stoType != 2) { ?>
                            <td>
                                <a class="btn-blue restore-btn" ng-click="recoverModal(item.catId)">恢复</a>
                            </td>
                            <?php }?>
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
<!--<script type="text/javascript" src="../../js/recycleGoodsCategory.js"></script>-->
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                status: '1',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.typeId = '', $scope.quickSearch = ''
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.recoverModal = function (id) {
            layer.alert('确认恢复该分类吗？', {
                icon: 3,
                title: "分类恢复",
                resize: false,
            }, function (index) {
                var postData = {
                    type: 'recover',
                    id: id
                };
                $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layer.msg('恢复成功！', {icon: 6, time: 1500});
                        parent.location.reload();
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