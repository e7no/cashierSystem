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
    <title>汇汇生活商家后台-单位管理</title>
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
                        <label class="layui-form-label">名称</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" placeholder="请输入查找的单位名称" style="width: 150px;" ng-model="name">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>单位管理</h5>
                <div class="ibox-tools">
                    <?php if ($downGoods == 1 || $stoType != 2) { ?>
                    <a class="btn-blue new-btn" ng-click="addModal()">添加</a>
                    <?php }?>
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
                            <th width="10%">序号</th>
                            <th width="14%">单位名称</th>
                            <th width="24%">修改时间</th>
                            <th width="22%">状态</th>
                            <?php if ($downGoods == 1 || $stoType != 2) { ?>
                            <th>操作</th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{$index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.CreateDate}}</td>
                            <td class="c-red" ng-if="item.state==0">已停用</td>
                            <td class="c-green" ng-if="item.state==1">已启用</td>
                            <?php if ($downGoods == 1 || $stoType != 2) { ?>
                            <td>
                                <a class="btn-blue disable-btn" ng-if="item.state==0" ng-click="dealModal('open',item.gsuId)">启用</a>
                                <a class="btn-red disable-btn" ng-if="item.state==1" ng-click="dealModal('close',item.gsuId)">停用</a>
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
    <!--新建单位-->
    <div class="popup new-open" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">单位名称</label>
                <div class="layui-input-inline" style="width: 150px;">
                    <input name="title" placeholder="请输入单位名称" class="layui-input" ng-model="Unitname" type="text" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal unit-btn" value="保存" ng-click="SaveModal(Unitname)">
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
                type:'list',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                name: $scope.name
            };
            $http.post('../../Controller/goods/unitManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {$scope.name = ''}
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal=function(){
            $scope.Unitname='';
            layer.open({type: 1, title: "添加单位", area: ['250px', '150px'], shadeClose: true, resize: false, content: $("#add"),});
        }
        $scope.SaveModal=function(Unitname){
            var postData = {type:'add',Unitname: Unitname};
            $http.post('../../Controller/goods/unitManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                if(result.data.success){
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message,{icon: 6,time:2000});
                    return reSearch();
                }else{
                    layer.msg(result.data.message,{time:2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.dealModal=function(t,id){
            var postData = {type:'deal',gsuId: id};
            if(t=='close'){
                layer.alert('亲，您确定停用该单位吗？', {icon: 5, title: "停用", resize: false,}, function(index){
                    $http.post('../../Controller/goods/unitManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if(result.data.success){
                            layer.msg('停用成功！',{icon: 6,time:1000});
                            return reSearch();
                        }else{
                            layer.msg(result.data.message,{time:2000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    })
                });
            }else{
                layer.alert('亲，您确定启用该单位吗？', {icon: 6, title: "启用", resize: false,}, function(index){
                    $http.post('../../Controller/goods/unitManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if(result.data.success){
                            layer.msg('启用成功！',{icon: 6,time:1000});
                            return reSearch();
                        }else{
                            layer.msg(result.data.message,{time:2000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    })
                });
            }

        }
    });
</script>
</body>
</html>