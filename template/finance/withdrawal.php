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
    <title>汇汇生活商家后台-余额提现</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper withdrawal" ng-controller="listController">
    <div class="content">
        <div class="wboxform">
            <div class="withdrawal-info">
                <div class="w-money">账户余额：<b>{{wallet|number:2}}</b></div>
                <div class="w-money">结算中金额：<b>{{unSettle|number:2}}</b></div>
                <div class="w-money">提现中金额：<b>{{cashOut|number:2}}</b></div>
                <a ng-click="checkTxModal()" class="record-btn">查看提现记录</a>
            </div>
            <fieldset class="layui-elem-field withdrawal-tips">
                <legend>温馨提示：</legend>
                <div class="layui-field-box">
                    1、营业收入款于每天凌晨00:00-03:00通过民生银行系统清算，期间不可申请提现；<br/>
                    2、单笔提现限额5万元，单卡日累计提现限额10万元；<br/>
                    3、工作日09:30和15:30处理提现，当天15:00前申请提现的24:00前到账，15:30后申请提现第二个工作日到账，如遇周末或法定节假日顺延。<br/>
                    4、单日前{{freeTimes}}次提现免手续费，超出后{{fee?fee:3}}元/笔
                </div>
            </fieldset>
            <form class="layui-form">
                <div class="drawal-box">
                    <span>&#12288;银行卡</span>
                    <div class="drawal-list">
                        <ul>
                            <li ng-repeat="item in list" ng-click='li_click(item.id)' ng-class='{active: item.id==actNum}'>
                                <label>
                                    <input type="checkbox"/>
                                    <i class="iconfont will-zhengque"></i>
                                    <img ng-src="../../img/{{item.icon}}"/>
                                </label>
                                <p>{{item.num|limitTo:3}}*** ***{{item.num|limitTo:-4}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 10px;">
                    <label class="layui-form-label">提现金额</label>
                    <div class="layui-input-inline" style="width: 175px;">
                        <input type="number" class="layui-input" placeholder="请输入提现金额" ng-model="money" ng-change="sumNum()"
                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                               onafterpaste="this.value=this.value.replace(/\D/g,'')">
                    </div>
                    <div class="layui-input-inline" style="line-height: 32px;color: #666;padding-left: 10px;">
                        该银行卡本次最多可提现<span
                            style="padding:0 3px;font-weight:bold;color: #FF5722;">{{(txWallet-realFee)>0?(txWallet-realFee):'0.00'|number:0}}</span>元
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 5px;">
                    <label class="layui-form-label">提现费用</label>
                    <div class="layui-input-inline" style="line-height: 32px; color: #666;">
                        {{realFee}}元/笔（单日已超出免费提现次数）
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">实收金额</label>
                    <div class="layui-input-inline" style="line-height: 32px; color: #666;">
                        {{money}}元
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 5px;">
                    <label class="layui-form-label">交易密码</label>
                    <div class="layui-input-inline" style="width: 175px;">
                        <input type="text" class="layui-input" placeholder="请输入交易密码" ng-model="password" autocomplete="off" onfocus="this.type='password'">
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 5px;">
                    <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal unit-btn" value="确定提现" ng-click="txModal()"
                           ng-show="readDrivingUnable">
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal unit-btn" disabled="disabled" value="确定提现" ng-click="txModal()"
                           ng-show="!readDrivingUnable">
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        $scope.readDrivingUnable = true;
        $scope.realFeeMoney = 0;
        $scope.txWallet = 0;
        var postData = {
            type: 'list',
        };
        $http.post('../../Controller/finance/withdrawalAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.list = result.data.card;
            $scope.wallet = result.data.list.wallet;
            $scope.unSettle = result.data.list.unSettle;
            $scope.cashOut = result.data.list.cashOut;
            $scope.freeTimes = result.data.list.freeTimes;
            $scope.fee = result.data.list.fee;
            $scope.realFee = result.data.list.realFee;
//            $scope.actNum = result.data.card[0].id;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.txModal = function () {
            if(angular.isUndefined($scope.actNum)||$scope.actNum==''){
                $scope.readDrivingUnable = true;
                layer.msg('请先选择提现银行卡！', {time: 3000});
                return;
            }
            $scope.readDrivingUnable = false;
            var postData = {
                type: 'tixian',
                num: $scope.actNum,
                money: $scope.money,
                pwd: $scope.password
            };
            $http.post('../../Controller/finance/withdrawalAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {time: 3000});
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    $scope.readDrivingUnable = true;
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                $scope.readDrivingUnable = true;
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.li_click = function (i) {
            $scope.actNum = i;
            var postData = {
                type: 'check',
                id: i
            };
            $http.post('../../Controller/finance/withdrawalAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.allowAmt = result.data.allowAmt;
                if ($scope.wallet < $scope.allowAmt) {
                    $scope.txWallet = $scope.wallet;
                } else {
                    $scope.txWallet = $scope.allowAmt;
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.checkTxModal = function () {
            layer.open({
                type: 2,
                title: "提现记录",
                area: ['100%', '100%'],
                shadeClose: true,
                resize: false,
                offset: ['0', '0'],
                content: 'recordDrawal.php',
            });
        }
        $scope.sumNum = function () {
            $scope.realFeeMoney = parseInt($scope.money) + parseInt($scope.realFee);
            return $scope.realFeeMoney;
        }
    });
</script>
</body>
</html>