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
    <title>汇汇生活商家后台-门店管理</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css?version=4"/>
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
                        <label class="layui-form-label">门店名称</label>
                        <div class="layui-input-inline" style="width: 220px;">
                            <input type="text" ng-model="name" class="layui-input" placeholder="请输入门店名称">
                        </div>
                        <label class="layui-form-label">&nbsp;&nbsp;门店编码</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" ng-model="code" class="layui-input" placeholder="请输入门店编码">
                        </div>
                        <label class="layui-form-label">&nbsp;&nbsp;手机</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" ng-model="mobile" class="layui-input" placeholder="请输入手机号码">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询"/>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>门店列表</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">添加</a>
                    <a class="btn-green function-btn" ng-click="modifyModal()">修改</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1600px;">
                        <thead>
                        <tr class="text-c">
                            <th width="4%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                            <th width="12%">门店名称</th>
                            <th width="7%">门店编码</th>
                            <th width="7%">手机号码</th>
                            <th width="16%">门店地址</th>
                            <th width="7%">门店电话</th>
                            <th width="7%">添加商品</th>
                            <th width="9%">修改总部商品价格</th>
                            <th width="6%">管理员工</th>
                            <th width="5%">会员系统</th>
                            <th width="5%">现金充值</th>
                            <th width="6%">门店状态</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"/></td>
                            <td>{{item.subName}}</td>
                            <td>{{item.subCode}}</td>
                            <td>{{item.mobile}}</td>
                            <td>{{item.address}}</td>
                            <td>{{item.tel}}</td>
                            <td class="{{item.downGoods?'c-red':'c-green'}}">{{item.downGoods?'×':'√'}}</td>
                            <td class="{{item.modifyPrice?'c-green':'c-red'}}">{{item.modifyPrice?'√':'×'}}</td>
                            <td class="{{item.manageEmp?'c-green':'c-red'}}">{{item.manageEmp?'√':'×'}}</td>
                            <td class="{{item.memberSystem?'c-green':'c-red'}}">{{item.memberSystem?'√':'×'}}</td>
                            <td class="{{item.cashRecharge?'c-green':'c-red'}}">{{item.cashRecharge?'√':'×'}}</td>
                            <td class="c-red" ng-if="item.bindState==0">审核中</td>
                            <td class="c-green" ng-if="item.bindState==1">正常</td>
                            <td class="c-red" ng-if="item.bindState==2">绑定失败</td>
                            <td>
                                <a class="btn-green" ng-click="modifyModal(item)">修改</a>
                                <a class="btn-red del-btn" ng-if="item.bindState==1" ng-click="relieveModal(item.id)">解绑</a>
                                <a class="btn-red del-btn" ng-if="item.bindState==2" ng-click="delModal(item.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--添加门店-->
    <div class="popup bind-popup" id="add">
        <form class="layui-form">
            <div id="codingparent">
                <div class="layui-form-item" style="margin-top: 10px;" ng-repeat="i in range(num) track by $index">
                    <label class="layui-form-label">门店编码</label>
                    <div class="layui-input-inline" style="width: 200px;">
                        <input type="text" class="layui-input" ng-model="Code.coding[$index]" placeholder="请输入门店编码" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <a class="btn-green" ng-click="addNum(num)" style="width: 264px; height: 36px; line-height: 36px; font-size: 14px;">更多</a>
            </div>
            <div class="layui-form-item" style="margin-top: 12px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal bangding-btn" value="保存" ng-click="dealAddModal(Code)"/>
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置"/>
            </div>
        </form>
    </div>
    <!--功能修改-->
    <div class="popup fendian-change" id="modify">
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label" style="width: 150px; text-align: right;">禁止添加商品</label>
                <div class="layui-input-block">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive1]">
                        <input type="checkbox" ng-checked="isActive1" ng-click="changeClass(1)"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label" style="width: 150px; text-align: right;">禁止修改总部商品价格</label>
                <div class="layui-input-block">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive2]">
                        <input type="checkbox" ng-checked="isActive2" ng-click="changeClass(2)"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label" style="width: 150px; text-align: right;">禁止管理员工</label>
                <div class="layui-input-block">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive3]">
                        <input type="checkbox" ng-checked="isActive3" ng-click="changeClass(3)"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label" style="width: 150px; text-align: right;">会员系统</label>
                <div class="layui-input-block">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive4]">
                        <input type="checkbox" ng-checked="isActive4" ng-click="changeClass(4)" disabled ng-show="isActive5"/>
                        <input type="checkbox" ng-checked="isActive4" ng-click="changeClass(4)" ng-show="!isActive5"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label" style="width: 150px; text-align: right;">现金充值</label>
                <div class="layui-input-block">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive5]">
                        <input type="checkbox" ng-checked="isActive5" ng-click="changeClass(5)" disabled ng-show="!isActive4"/>
                        <input type="checkbox" ng-checked="isActive5" ng-click="changeClass(5)"  ng-show="isActive4"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 12px;">
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal change-btn" ng-click="SaveOpen(subCode)" value="保存"
                       style="display:block;margin: 0 auto;"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http, $filter) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                name: $scope.name,
                code: $scope.code,
                mobile: $scope.mobile
            };
            $http.post('../../Controller/store/storeManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetSearch = function () {
            $scope.name = '';
            $scope.code = '';
            $scope.mobile = '';
        }
        $scope.reSearch = reSearch;
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {//添加员工
            layer.open({type: 1, title: "添加门店", anim: '2', area: ['310px', '100%'], shadeClose: true, offset: ['0', '0'], resize: false, content: $("#add"),});
            $scope.type = 'add';
            $scope.Code = {};
            $scope.num = 5;
            $scope.range = function (n) {
                return new Array(n);
            };
        }
        $scope.addNum = function (n) {
            $scope.num = n + 5;
        }
        $scope.checked = [];
        $scope.selectAll = function () {
            if ($scope.select_all) {
                $scope.checked = [];
                angular.forEach($scope.list, function (item) {
                    item.checked = true;
                    $scope.checked.push(item.subCode);
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
                var index = $scope.checked.indexOf(item.subCode);
                if (item.checked && index === -1) {
                    $scope.checked.push(item.subCode);
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
        $scope.modifyModal = function (item) {//修改员工信息
            $scope.isActive = false;
            if (angular.equals(undefined, item)) {
                if (angular.equals([], $scope.checked)) {
                    layer.msg('请选择修改的店铺！', {time: 3000});
                } else {
                    layer.open({type: 1, title: "修改分店权限", anim: '2', area: ['400px', '350px'], shadeClose: true, resize: false, content: $("#modify"),});
                    $scope.subCode = $scope.checked;
                    if ($scope.subCode.length == 1) {
                        angular.forEach($scope.list, function (data) {
                            if (data.subCode == $scope.subCode) {
                                if (data.downGoods == 0) {
                                    $scope.isActive1 = true;
                                } else {
                                    $scope.isActive1 = false;
                                }
                                if (data.modifyPrice == 1) {
                                    $scope.isActive2 = true;
                                } else {
                                    $scope.isActive2 = false;
                                }
                                if (data.manageEmp == 1) {
                                    $scope.isActive3 = true;
                                } else {
                                    $scope.isActive3 = false;
                                }
                                if (data.memberSystem == 1) {
                                    $scope.isActive4 = true;
                                } else {
                                    $scope.isActive4 = false;
                                }
                                if (data.cashRecharge == 1) {
                                    $scope.isActive5 = true;
                                } else {
                                    $scope.isActive5 = false;
                                }
                            }
                        });
                    } else {
                        $scope.isActive1 = false;
                        $scope.isActive2 = false;
                        $scope.isActive3 = false;
                        $scope.isActive4 = false;
                        $scope.isActive5 = false;
                    }
                }
            } else {
                if (item.downGoods == 0) {
                    $scope.isActive1 = true;
                } else {
                    $scope.isActive1 = false;
                }
                if (item.modifyPrice == 1) {
                    $scope.isActive2 = true;
                } else {
                    $scope.isActive2 = false;
                }
                if (item.manageEmp == 1) {
                    $scope.isActive3 = true;
                } else {
                    $scope.isActive3 = false;
                }
                if (item.memberSystem == 1) {
                    $scope.isActive4 = true;
                } else {
                    $scope.isActive4 = false;
                }
                if (item.cashRecharge == 1) {
                    $scope.isActive5 = true;
                } else {
                    $scope.isActive5 = false;
                }
                layer.open({type: 1, title: "修改分店权限", anim: '2', area: ['340px', '350px'], shadeClose: true, resize: false, content: $("#modify"),});
                $scope.subCode = item.subCode;
            }
        };
        $scope.SaveOpen = function (subCode) {
            if ($scope.isActive1) {
                var downGoods = 0;
            } else {
                var downGoods = 1;
            }
            if ($scope.isActive2) {
                var modifyPrice = 1;
            } else {
                var modifyPrice = 0;
            }
            if ($scope.isActive3) {
                var manageEmp = 1;
            } else {
                var manageEmp = 0;
            }
            if ($scope.isActive4) {
                var memberSystem = 1;
            } else {
                var memberSystem = 0;
            }
            if ($scope.isActive5) {
                var cashRecharge = 1;
            } else {
                var cashRecharge = 0;
            }
            var postData = {
                type: 'modify',
                downGoods: downGoods,
                modifyPrice: modifyPrice,
                manageEmp: manageEmp,
                memberSystem: memberSystem,
                cashRecharge: cashRecharge,
                subCode: subCode
            };
            $http.post('../../Controller/store/storeManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    $scope.checked = [];
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.dealAddModal = function (Code) {//添加分店
            var postData = {
                type: $scope.type,
                coding: Code.coding
            }
            $http.post("../../Controller/store/storeManageAction.php", postData).then(function (result) {
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.delModal = function (id) { //员工删除
            var postData = {type: 'del', id: id};
            layer.alert('亲，您确定删除该店铺吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/store/storeManageAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        $scope.relieveModal = function (id) { //解除绑定
            var postData = {type: 'relieve', idre: id};
            layer.alert('亲，您确定解绑本店吗？', {icon: 5, title: "解绑", resize: false,}, function () {
                $http.post("../../Controller/store/storeManageAction.php", postData).then(function (result) {
                    layer.msg(result.data.message, {icon: 6, time: 2000});
                    return reSearch();
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
        $scope.changeClass = function (id) {
            if (id == 1) {
                $scope.isActive1 = !$scope.isActive1;
            }
            if (id == 2) {
                $scope.isActive2 = !$scope.isActive2;
            }
            if (id == 3) {
                $scope.isActive3 = !$scope.isActive3;
            }
            if (id == 4) {
                $scope.isActive4 = !$scope.isActive4;
            }
            if (id == 5) {
                $scope.isActive5 = !$scope.isActive5;
            }
        }
    })
</script>
</body>
</html>