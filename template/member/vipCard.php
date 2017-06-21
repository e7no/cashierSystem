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
    <title>汇汇生活商家后台-会员卡设置</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content" ng-init="reSearch()">
        <div class="wbox">
            <div class="wbox-title">
                <h5>会员卡设置</h5>
                <div class="ibox-tools">
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <fieldset class="layui-elem-field storeInfo-box">
                    <legend>充值设置</legend>
                    <div class="vipCard-form">
                        <form class="layui-form">
                            <div ng-repeat="item in list | orderBy : 'sn'">
                            <div class="layui-form-item" style="padding-top: 15px;">
                                <input type="hidden" id="id{{$index}}" value="{{item.id}}">
                                <label class="layui-form-label" ng-if="item.reType==1">充值金额</label>
                                <label class="layui-form-label" ng-if="item.reType==2">自定义充值</label>
                                <div class="layui-input-inline" style="width: 100px;">
                                    <input type="text" id="amount{{$index}}" class="layui-input" ng-trim="false" ng-trim="false" ng-model="item.amount" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                </div>
                                <label class="layui-form-label" ng-if="item.reType==1">元，</label>
                                <label class="layui-form-label" ng-if="item.reType==1">额外赠送金额</label>
                                <label class="layui-form-label" ng-if="item.reType==2">元起，赠送</label>
                                <div class="layui-input-inline" style="width: 100px;">
                                    <input type="text" id="give{{$index}}" class="layui-input" ng-model="item.give" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                </div>
                                <label class="layui-form-label"  ng-if="item.reType==1">元</label>
                                <label class="layui-form-label"  ng-if="item.reType==2">%（设置赠送比例）</label>
                            </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 15px;">
                                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;&#12288;</label>
                                <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="确认" ng-click="setData()"/>
                                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" />
                            </div>
                            <div class="layui-form-item" style="margin-top: 15px;">
                                操作说明：设置固定的充值金额及赠金额（赠送金额为0或留空则表示没有额外赠送），自定义充值可设置赠送比例（可以为0或留空）
                            </div>
                        </form>
                    </div>
                </fieldset>
                <fieldset class="layui-elem-field storeInfo-box">
                    <legend>积分设置</legend>
                    <div class="vipCard-form">
                        <form class="layui-form">
                            <div class="layui-form-item">
                                <label class="layui-form-label">消费</label>
                                <div class="layui-input-inline" style="width: 100px;">
                                    <input type="text" class="layui-input" ng-model="consume" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                                </div>
                                <label class="layui-form-label">元，</label>
                                <label class="layui-form-label">赠送</label>
                                <div class="layui-input-inline" style="width: 100px;">
                                    <input type="text" class="layui-input" ng-model="integral" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                                </div>
                                <label class="layui-form-label">积分</label>
                            </div>
                            <div class="layui-form-item" style="margin-top: 15px;">
                                <label class="layui-form-label">&#12288;&#12288;</label>
                                <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="确认" ng-click="integralModal()"/>
                                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="integralrestModal()"/>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/layui.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {type: 'list',};
            $http.post('../../Controller/member/vipCardAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.list=result.data.list;
                $scope.consume=result.data.conAmount;
                $scope.integral=result.data.integral;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.setData = function () {
            var postData = {type: 'set'};
            for(var i=0;i<4;i++){
                postData['id'+i]=$('#id'+i).val();
                postData['amount'+i]=$('#amount'+i).val();
                postData['give'+i]=$('#give'+i).val();
            }
            $http.post('../../Controller/member/vipCardAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.integralModal=function (){
            var postData = {
                type: 'integral',
                consume: $scope.consume,
                integral: $scope.integral
            };
            $http.post('../../Controller/member/vipCardAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.integralrestModal=function (){$scope.consume='',$scope.integral=''}
    });
</script>
</body>
</html>