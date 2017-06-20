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
    <title>汇汇生活商家后台-桌台管理</title>
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
        <div class="counter">
            <div class="counter-left">
                <div class="wbox">
                    <div class="wbox-title">
                        <h5>区域管理</h5>
                        <div class="ibox-tools">
                            <a class="btn-blue addqy-btn" ng-click="addAreaModal()">添加</a>
                            <a class="btn-red delqy-btn" ng-click="delAreaModal()">删除</a>
                        </div>
                    </div>
                    <div class="wbox-content">
                        <div class="counter-qy">
                            <ul>
                                <li ng-repeat="tab in table" ng-class='{active: tab.id==active}'>
                                    <label>
                                        <input type="radio" name="radio" ng-click="li_click(tab.id,tab.additionalFee)"/>
                                        <span>{{tab.name}}</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="counter-right">
                <div class="wbox">
                    <div class="wbox-title">
                        <h5>桌台管理</h5>
                        <div class="ibox-tools">
                            <a class="btn-blue addzt-btn" ng-click="addTableModal()">添加</a>
                            <a class="btn-red delzt-btn" ng-click="delTableModal()">删除</a>
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
                                    <th width="5%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                                    <th>桌台号</th>
                                    <!-- <th width="16%">所属区域</th> -->
                                    <th width="15%">就餐人数</th>
                                    <th width="15%">茶位费</th>
                                    <th width="15%">餐纸费</th>
                                    <th width="18%">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-c" ng-repeat="item in list" ng-cloak>
                                    <td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"></td>
                                    <td>{{item.name}}</td>
                                    <!-- <td>{{item.areaType}}</td> -->
                                    <td>{{item.galleryful}}</td>
                                    <td>{{item.additionalFee}}</td>
                                    <td ng-if="item.paperAmount==''">0</td>
                                    <td ng-if="item.paperAmount!=''">{{item.paperAmount}}</td>
                                    <td>
                                        <a class="btn-blue ewm-btn" ng-click="qrcode(item.id)">二维码</a>
                                        <a class="btn-green addzt-btn" ng-click="modifyTableModal(item)">修改</a>
                                        <a class="btn-red delzt-btn" ng-click="delTableModal(item.id)">删除</a>
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
    </div>
    <!--添加区域-->
    <div class="popup addqy-popup" id="addArea">
        <div class="layui-form-item">
            <label class="layui-form-label">&#12288;&#12288;名称</label>
            <div class="layui-input-inline" style="width: 170px;">
                <input placeholder="请输入区域" class="layui-input" ng-model="name" id="name" type="text">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 10px;">
            <label class="layui-form-label">茶位费用</label>
            <div class="layui-input-inline" style="width: 170px;">
                <input placeholder="请输入区域茶位费用" class="layui-input" onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')" ng-model="TeaPrice" id="TeaPrice" type="text">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 10px;">
            <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
            <input type="button" class="layui-btn layui-btn-small layui-btn-normal qy-submit" value="保存" ng-click="saveAreaModal()">
            <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetAreaModal()"/>
        </div>
    </div>
    <!--添加桌台-->
    <div class="popup addzt-popup" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">&#12288;桌台号</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入桌台号" class="layui-input" ng-model="tablenum" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">就餐人数</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入就餐人数" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"
                               class="layui-input" ng-model="tablecount" id="tablecount" type="text">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">茶位费用</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入茶位费用" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"
                               class="layui-input" ng-model="tableprice" id="tableprice" type="text">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal zt-submit" ng-click="saveTableModal()" value="保存">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetTableModal()" value="重置"/>
            </div>
        </form>
    </div>
    <!--修改桌台-->
    <div class="popup addzt-popup" id="modify">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">&#12288;桌台号</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入桌台号" class="layui-input" ng-model="modalData.name" type="text">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">就餐人数</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入就餐人数" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"
                               class="layui-input" ng-model="modalData.galleryful" id="" type="text">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">茶位费用</label>
                    <div class="layui-input-inline" style="width: 110px;">
                        <input placeholder="请输入茶位费用" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"
                               class="layui-input" ng-model="modalData.additionalFee" type="text">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal zt-submit" ng-click="savaTableModal(modalData)" value="保存">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        $scope.active = '';
//        $scope.actives = '';
//        $scope.tableprices == '';
        var postDatas = {
            type: 'table',
        };
        $http.post('../../Controller/cashier/counterManageAction.php', postDatas).then(function (result) {  //正确请求成功时处理
            $scope.table = result.data.list;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.li_click = function (i, fee) {
            if (angular.isUndefined($scope.tableprices) || $scope.tableprices == '') {
                $scope.tableprice = fee;
            } else {
                $scope.tableprice = $scope.tableprices;
            }
            if (angular.isUndefined($scope.actives) || $scope.actives == '') {
                $scope.active = i;
            } else {
                $scope.active = $scope.actives;
            }
            var postData = {
                type: 'list',
                areaType: $scope.active,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/cashier/counterManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        var reSearch = function () {
            $scope.li_click();
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addAreaModal = function () {
            $scope.name = "";
            $scope.TeaPrice = "";
            layer.open({
                type: 1,
                title: "添加桌台区域",
                area: ['275px', '190px'],
                shadeClose: true,
                resize: false,
                content: $("#addArea"),
            });
        }
        $scope.addTableModal = function () {
            if (angular.isUndefined($scope.active) || $scope.active == '') {
                $scope.tableprice = "";
                layer.msg('请选择一个左边区域', {time: 3000});
                return false;
            }
            $scope.tablenum = '';
            $scope.tablecount = '';
            layer.open({
                type: 1,
                title: "添加桌台",//标题
                area: ['400px', '190px'],//宽高
                shadeClose: true, //点击遮罩关闭
                resize: false, //禁止拉伸
                content: $("#add"),//也可将html写在此处
            });
        }
        $scope.saveAreaModal = function () {
            var postData = {
                type: 'addArea',
                name: $scope.name,
                additionalFee: $scope.TeaPrice,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    location.reload();
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetTableModal = function () {
            $scope.tablenum = "";
            $scope.tablecount = "";
            $scope.tableprice = "";
        }
        $scope.resetAreaModal = function () {
            $scope.name = "";
            $scope.TeaPrice = "";
        }
        $scope.checked = [];
        $scope.selectAll = function () {
            if ($scope.select_all) {
                $scope.checked = [];
                angular.forEach($scope.list, function (item) {
                    item.checked = true;
                    $scope.checked.push(item.id);
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    item.checked = false;
                    $scope.checked = [];
                })
            }
        };
        $scope.selectOne = function () {
            angular.forEach($scope.list, function (item) {
                var index = $scope.checked.indexOf(item.id);
                if (item.checked && index === -1) {
                    $scope.checked.push(item.id);
                } else if (!item.checked && index !== -1) {
                    $scope.checked.splice(index, 1);
                }
                ;
            })
            if ($scope.list.length === $scope.checked.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.delTableModal = function (id) { //桌台删除
            if (angular.isUndefined(id)) {
                var ids = $scope.checked;
            } else {
                var ids = id;
            }
            var postData = {type: 'Tabledel', id: ids};
            layer.alert('亲，您确定删除选中的桌台吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/cashier/viceScreenAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    $scope.tableprices = $("#tableprice").val();
                    $scope.actives = $scope.active
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        $scope.modifyTableModal = function (item) {//修改桌台信息
            layer.open({
                type: 1,
                title: "修改桌台",//标题
                area: ['400px', '190px'],//宽高
                shadeClose: true, //点击遮罩关闭
                resize: false, //禁止拉伸
                content: $("#modify"),
            });
            $scope.modalData = item;
            $scope.type = 'modify';
        }
        $scope.savaTableModal = function (data) {//桌台信息修改
            var postData = {
                type: 'modifyTable',
                id: data.id,
                name: data.name,
                galleryful: data.galleryful,
                areaType: data.areaType,
                additionalFee: data.additionalFee
            };
            $http.post("../../Controller/cashier/viceScreenAction.php", postData).then(function (result) {
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    $scope.tableprices = $("#tableprice").val();
                    $scope.actives = $scope.active
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.saveTableModal = function () {
            var postData = {
                type: 'addTable',
                name: $scope.tablenum,
                galleryful: $("#tablecount").val(),
                areaType: $scope.active,
                additionalFee: $("#tableprice").val()
            };
            if ($scope.active == '') {
                layer.msg('请选择一个左边区域', {time: 3000});
                return false;
            } else if ($scope.tablenum == "") {
                layer.msg('请输入桌台号', {time: 3000});
                return false;
            } else if ($("#tablecount").val() == "") {
                layer.msg('请输入就餐人数', {time: 3000});
                return false;
            } else if ($("#tableprice").val() == "") {
                layer.msg('请输入茶位费', {time: 3000});
                return false;
            }
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    $scope.tableprices = $("#tableprice").val();
                    $scope.actives = $scope.active
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.delAreaModal = function () {
            var postData = {
                type: 'delArea',
                ids: $scope.active
            };
            layer.alert('亲，您确定删除选中的区域吗？', {icon: 5, title: "删除", resize: false,}, function () {
	            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
	                if (result.data.success) {
	                    layer.closeAll('page'); //关闭弹层
	                    layer.msg('恭喜你，删除成功！', {icon: 6, time: 1500});
	                    location.reload();
	                } else {
	                    layer.msg(result.data.message, {time: 3000});
	                }
	            }).catch(function () { //捕捉错误处理
	                layer.msg('服务端请求错误！', {time: 3000});
	            });
            });
        }
        $scope.qrcode = function (id) {
            layer.open({
                type: 2,
                title: '桌台二维码',
                area: ['300px', '100%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'qrCode.php?id=' + id,
            });
        }
    });
</script>
</body>
</html>