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
    <title>汇汇生活商家后台-添加商品</title>
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
            <div class="wbox-content addOtherFiles">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">类型</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="inOrOut" ng-change="selectProkect(inOrOut)">
                                <option value="">请选择...</option>
                                <option value="1">收入</option>
                                <option value="-1">支出</option>
                            </select>
                        </div>
                    </div>
                    <div class="aof-center" ng-repeat="i in range(num) track by $index">
                        <fieldset class="layui-elem-field">
                            <legend>收支项目</legend>
                            <div class="layui-field-box">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">项目名称</label>
                                    <div class="layui-input-inline" style="width: 270px;">
                                        <select class="layui-input" name="items" ng-model="$parent.project[$index]">
                                            <option value="">请选择...</option>
                                            <option ng-repeat="iteml in selectprolist" ng-value="iteml.id+','+iteml.name">{{iteml.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item" style="margin-top: 10px;">
                                    <label class="layui-form-label">&#12288;&#12288;费用</label>
                                    <div class="layui-input-inline" style="width: 270px;">
                                        <input type="text" class="layui-input" ng-model="$parent.amount[$index]" placeholder="请输入项目费用">
                                    </div>
                                </div>
                                <div class="layui-form-item" style="margin-top: 10px;">
                                    <label class="layui-form-label">&#12288;&#12288;备注</label>
                                    <div class="layui-input-inline" style="width: 270px;">
                                        <input type="text" class="layui-input" ng-model="$parent.remark[$index]" placeholder="请输入项目名称">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="width: 310px;">
                            <div class="btn-box">
                                <a class="add-btn" ng-click="dealNumModal(true)" ng-hide="addNum"><i class="iconfont will-jia"></i>增加</a>
                                <a class="del-btn" ng-click="dealNumModal(false)" ng-hide="reduceNum"><i class="iconfont will-desc"></i>删除</a>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 12px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" ng-click="saveFiles()" value="保存"/>
                        <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置"/>
                    </div>
                </form>
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
        $scope.addNum = false;
        $scope.reduceNum = true;
        $scope.project = [];
        $scope.amount = [];
        $scope.remark = [];
        $scope.typeName = [];
        $scope.num = 1;
        $scope.saveFiles = function () {
            var item = $("select[name=items] option[selected]").text();
            var postData = {
                type: 'Filesadd',
                inout: $scope.inOrOut,
                typeId: $scope.project,
                typeName: $scope.typeName,
                amount: $scope.amount,
                note: $scope.remark,
            };
            if ($scope.inOrOut == "") {
                layer.msg('请选择类型', {time: 3000});
                return false;
            } else if ($scope.project == "") {
                layer.msg('请选择项目名称', {time: 3000});
                return false;
            } else if ($scope.amount == "") {
                layer.msg('请填写项目费用', {time: 3000});
                return false;
            }
            $http.post('../../Controller/finance/listIncomeAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg(result.data.message, {icon: 6, time: 1500});
                    parent.location.reload();
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetSearch = function () {
            $scope.inOrOut = "";
            $scope.project = [];
            $scope.amount = [];
            $scope.remark = [];
            $scope.typeName = [];
        }
        $scope.range = function (n) {
            return new Array(n);
        }
        $scope.dealNumModal = function (Boole) {
            $scope.reduceNum = false;
            if (Boole) {
                $scope.num = $scope.num + 1;
                if ($scope.num == 10) {
                    $scope.addNum = true;
                } else {
                    $scope.addNum = false;
                }
            } else {
                $scope.addNum = false;
                $scope.num = $scope.num - 1;
                if ($scope.num == 1) {
                    $scope.reduceNum = true;
                } else {
                    $scope.reduceNum = false;
                }
            }
        }
        $scope.selectProkect = function (id) {
            var postData = {
                type: 'selectproject',
                selectId: id
            };
            $http.post('../../Controller/finance/listIncomeAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.selectprolist = result.data.datas.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });

</script>
</body>
</html>