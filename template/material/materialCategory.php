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
    <title>汇汇生活商家后台-原料分类</title>
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
                <h5>原料分类</h5>
                <div class="ibox-tools">
                    <a class="btn-blue level-btn" ng-click="addModal()">新增分类</a>
                    <a class="btn-green" id="excel">导出</a>
<!--                    <a class="btn-blue" href="javascript:;">导入</a>-->
                    <a class="btn-delete" ng-click="dustbinModal()" title="回收站"><i class="iconfont will-huishou"></i></a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 600px;">
                        <thead>
                        <tr class="text-c">
                            <th width="26%">分类名称</th>
                            <th width="28%">修改时间</th>
                            <th width="18%">操作员</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.typeName}}</td>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.createName?item.createName:'管理员'}}</td>
                            <td>
                                <a class="btn-green" ng-click="modifyModal(item.id,item.typeName)">修改</a>
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
    <!--新增分类-->
    <div class="popup popup-Level" id="deal">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input name="title" placeholder="请输入分类名称" class="layui-input" ng-model="levelName" type="text" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal Level-submit" value="保存" ng-click="dealModal()">
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
            $http.post('../../Controller/material/materialCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
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
            $scope.type='add';
            $scope.levelName='';
            layer.open({type: 1, title: "添加分类", area: ['310px', '150px'], shadeClose: true, resize: false, content: $("#deal"),});
        }
        $scope.modifyModal=function (id,name){
            $scope.type='modify';
            $scope.levelName='';
            $scope.mid=id;
            $scope.levelName=name;
            layer.open({type: 1, title: "修改设置", area: ['310px', '150px'], shadeClose: true, resize: false, content: $("#deal"),});
        }
        $scope.delModal=function (id){
            var postData = {type: 'del', id: id};
            layer.alert('您确定要删除吗?', {icon: 5, title: "删除", resize: false,}, function(){
                $http.post('../../Controller/material/materialCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg('删除成功！',{icon: 6,time:1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 2000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.dealModal = function () {
            if($scope.type=='add'){
                var postData = {type: $scope.type, typeName: $scope.levelName};
            }else{
                var postData = {type: $scope.type, id: $scope.mid,typeName:$scope.levelName};
            }
            console.log(postData);
            $http.post('../../Controller/material/materialCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.dustbinModal=function () {
            layer.open({type: 2, title: '回收站', area : ['100%' , '100%'], resize: false, move: false, shadeClose: true, offset: ['0', '0'], content: 'recycleMaterialCategory.php',});
        }
        $('#excel').click(function () {
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/materialCategoryExcel.php';
        });
    });
</script>
</body>
</html>