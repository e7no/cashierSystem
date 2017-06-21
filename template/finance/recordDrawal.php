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
    <title>汇汇生活商家后台-提现记录</title>
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
                <h5>提现记录</h5>
                <div class="ibox-tools">
                    <a class="btn-green" id="excel">导出</a>
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
                            <th width="15%">提现银行</th>
                            <th width="15%">提现账号</th>
                            <th width="15%">提现金额</th>
                            <th width="15%">手续费</th>
                            <th width="15%">实际到账金额</th>
                            <th width="15%">提现时间</th>
                            <th>提现状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.bankName}}</td>
                            <td>{{item.cardNumbers}}</td>
                            <td>{{item.amount-item.fee|number:2}}</td>
                            <td>{{item.fee|number:2}}</td>
                            <td>{{item.realAmount|number:2}}</td>
                            <td>{{item.createDate}}</td>
                            <td class="c-red" ng-if="item.status==5 && item.type==1">提现失败、已退回账户余额</td>
                            <td class="c-green" ng-if="item.type==1 && item.status==1">提现成功</td>
                            <td class="c-blue" ng-if=" item.type==1 && item.status==2 || item.status==3 || item.status==4">提现处理中</td>
                            <td class="c-blue" ng-if="item.type!=1">提现失败退回</td>
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
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'record',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/finance/withdrawalAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        $('#excel').click(function () {
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/recordDrawalExcel.php';
        });
    });
</script>
</body>
</html>