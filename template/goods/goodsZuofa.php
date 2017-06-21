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
    <title>汇汇生活商家后台-做法管理</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-title">
                <h5>做法管理</h5>
                <div class="ibox-tools">
                    <a class="btn-blue add-btn" ng-click="addModal()">添加</a>
                    <a class="btn-red del-btn" ng-click="delModal()">删除</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="list-zuofa">
                    <ul ng-repeat="item in list">
                        <li ng-click='li_click(item.id)' ng-class='{active: item.id==actId}'>
                            <label>
                                <input type="radio" name="radio"/>
                                <span>{{item.name}}</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--添加-->
    <div class="popup add-popup" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-inline" style="width: 200px;">
                    <input placeholder="请输入属性名称" class="layui-input" ng-model="doName" type="text" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal zuofa-submit" value="保存" ng-click="saveModal()">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModal()"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/layui.js"></script>
<!--	<script type="text/javascript" src="../../js/goodsZuofa.js"></script>-->
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var postData = {
            type: 'list',
        };
        $http.post('../../Controller/goods/goodsBehaviorAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.list = result.data.list;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.li_click = function (i) {
            $scope.actId = i;
        }
        $scope.addModal=function(){
            layer.open({
                type: 1,
                title: "添加商品做法",
                area: ['275px', '150px'],
                shadeClose: true,
                resize: false,
                content: $("#add"),
            });
        }
        $scope.saveModal=function(){
            var postData = {
                type: 'add',
                name: $scope.doName,
            };
            $http.post('../../Controller/goods/goodsBehaviorAction.php', postData).then(function (result) {  //正确请求成功时处理
               if(result.data.success){
                   layer.closeAll('page'); //关闭弹层
                   layer.msg('恭喜你，添加成功！',{icon: 6,time:1000});
                   window.location.reload();
               }else{
                   layer.msg(result.data.message, {time: 3000});
               }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetModal=function(){
            $scope.doName='';
        }
        $scope.delModal=function(){
            layer.alert('亲，您确定把我删了吗？', {icon: 5, title: "删除", resize: false,}, function(index){
                var postData = {
                    type: 'del',
                    id: $scope.actId?$scope.actId:'',
                };
                $http.post('../../Controller/goods/goodsBehaviorAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if(result.data.success){
                        layer.msg('删除成功！',{icon: 6,time:1000});
                        window.location.reload();
                    }else{
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