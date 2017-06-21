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
    <title>汇汇生活商家后台-会员列表</title>
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
        <div class="wboxform">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">快速查找</label>
                        <div class="layui-input-inline" style="width: 200px;">
                            <input type="text" class="layui-input" placeholder="请输入会员卡号/姓名/手机号码" ng-model="quickCheck">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>会员列表</h5>
                <div class="ibox-tools">
                    <a class="btn-green" id="excel">导出</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 2400px;">
                        <thead>
                        <tr class="text-c">
                            <th width="4%">资金记录</th>
                            <th>卡号</th>
                            <th width="5%">姓名</th>
                            <th width="4%">性别</th>
                            <th width="5%">手机号码</th>
                            <th width="6%">生日</th>
                            <th width="6%">余额</th>
                            <th width="6%">充值金额</th>
                            <th width="6%">赠送金额</th>
                            <th width="6%">总金额</th>
                            <th width="6%">消费总金额</th>
                            <th width="6%">积分</th>
                            <th width="5%">兑换积分</th>
                            <th width="5%">剩余积分</th>
                            <th width="5%">消费总次数</th>
                            <th width="5%">扫码付次数</th>
                            <th width="5%">会员支付次数</th>
                            <th width="7%">最后消费时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td><a class="check-btn" ng-click="checkModal(item.memId)">查看</a></td>
                            <td>{{item.card}}</td>
                            <td>{{item.realName}}</td>
                            <td ng-if="item.sex==1">男</td>
                            <td ng-if="item.sex==2">女</td>
                            <td>{{item.mobile}}</td>
                            <td>{{item.birthday}}</td>
                            <td>{{item.wallet}}</td>
                            <td>{{item.rechargeTotal}}</td>
                            <td>{{item.giveTotal}}</td>
                            <td>{{item.rechargeTotal+item.giveTotal}}</td>
                            <td>{{item.consumeTotal}}</td>
                            <td>{{item.integralTotal}}</td>
                            <td>{{item.conIntegralTotal}}</td>
                            <td>{{item.integral}}</td>
                            <td>{{item.qrConTimes+item.cardConTimes}}</td>
                            <td>{{item.qrConTimes}}</td>
                            <td>{{item.cardConTimes}}</td>
                            <td>{{item.lastConDate}}</td>
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
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                quick: $scope.quickCheck
            };
            $http.post('../../Controller/member/listMemberAction.php', postData).then(function (result) {  //正确请求成功时处理
                console.log(result);
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.quickCheck = ''
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 5, // 每页展示的数据条数
            perPageOptions: [10, 20, 30] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.checkModal = function (id) {
            layer.open({
                type: 2,
                title: '资金记录',
                area: ['540px', '100%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                offset: 't',
                offset: 'r',
                content: 'billtMember.php?id=' + id,
            });
        };
        $('#excel').click(function () {
            var quick = $scope.quickCheck ? $scope.quickCheck : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listMemberExcel.php?quick=' + quick;
        });
    });
</script>
</body>
</html>