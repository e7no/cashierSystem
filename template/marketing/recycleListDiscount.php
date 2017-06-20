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
    <title>汇汇生活商家后台-折扣-回收站</title>
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
                <h5>折扣</h5>
                <div class="ibox-tools">
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
                            <th width="4%"><input type="checkbox"/></th>
                            <th class="text-l">折扣名称</th>
                            <th width="8%">折扣类型</th>
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
                        <tr class="text-c">
                            <td width="4%"><input type="checkbox"/></td>
                            <td class="text-l">3月全单打8折</td>
                            <td>手动打折</td>
                            <td>全单打折</td>
                            <td>80%</td>
                            <td>2016-03-01 00:00:00</td>
                            <td>2016-03-31 23:59:59</td>
                            <td>启用中</td>
                            <td><a class="view-btn" href="javascript:;">查看</a></td>
                            <td>
                                <a class="btn-blue restore-btn" href="javascript:;">恢复</a>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <td width="4%"><input type="checkbox"/></td>
                            <td class="text-l">4月菜品8折</td>
                            <td>手动打折</td>
                            <td>特定商品</td>
                            <td>80%</td>
                            <td>2016-04-01 00:00:00</td>
                            <td>2016-04-30 23:59:59</td>
                            <td>关闭中</td>
                            <td><a class="view-btn" href="javascript:;">查看</a></td>
                            <td>
                                <a class="btn-blue restore-btn" href="javascript:;">恢复</a>
                            </td>
                        </tr>
                        <tr class="text-c">
                            <td width="4%"><input type="checkbox"/></td>
                            <td class="text-l">3月第二件半折</td>
                            <td>自动折扣</td>
                            <td>第二件打折</td>
                            <td>50%</td>
                            <td>2016-03-20 00:00:00</td>
                            <td>2016-03-31 23:59:59</td>
                            <td>关闭中</td>
                            <td><a class="view-btn" href="javascript:;">查看</a></td>
                            <td>
                                <a class="btn-blue restore-btn" href="javascript:;">恢复</a>
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
<!--<script type="text/javascript" src="../../js/recycleListDiscount.js"></script>-->
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                discountName: $scope.discountName,
                discountWay: $scope.discountWay,
                discountType: $scope.discountType,
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
    });
</script>
</body>
</html>