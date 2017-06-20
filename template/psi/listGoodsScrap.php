<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
session_start();
//$url = $config_host . '/service/sto/manage/roleList/' . $_SESSION['stoId'];
//$strrole = http($url, '', 1);
//$role_list = $strrole['datas']['stoRoleVOList'];
//$role_num = count($role_list);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品报废</title>
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
                        <label class="layui-form-label">单据编码</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" class="layui-input" placeholder="请输入单据编码" ng-model="no">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">报废时间</label>
                        <div class="layui-input-inline" style="width: 110px;">
                            <input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择开始时间" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 110px;">
                            <input type="text" class="Wdate layui-input" ng-model="createDateEnd" id="logmax" placeholder="请选择结束时间" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
                        </div>
                    </div>
                    <!--                    <div class="layui-inline">-->
                    <!--                        <label class="layui-form-label">操作员</label>-->
                    <!--                        <div class="layui-input-inline">-->
                    <!--                            <select class="layui-input" ng-model="operator" ng-init="operator=''">-->
                    <!--                                <option value="">请选择...</option>-->
                    <!--                                --><?php //for ($i = 0; $i < $role_num; $i++) { ?>
                    <!--                                    <option value="--><?php //echo $role_list[$i]['id']; ?><!--">-->
                    <?php //echo $role_list[$i]['name']; ?><!--</option>-->
                    <!--                                --><?php //} ?>
                    <!--                            </select>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="layui-inline">
                        <label class="layui-form-label">报废员</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" class="layui-input" placeholder="请输入报废员姓名" ng-model="operator">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>成品报废单列表</h5>
                <div class="ibox-tools">
                    <a class="btn-blue news-btn" ng-click="addModal()">新增单据</a>
                    <a class="btn-green" id="excel">导出</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1200px;">
                        <thead>
                        <tr class="text-c">
                            <th width="15%">单据编码</th>
                            <th width="12%">报废总量</th>
                            <th width="12%">报废总额</th>
                            <th width="13%">报废时间</th>
                            <th width="13%">备注</th>
                            <th width="8%">报废员</th>
                            <th width="8%">操作员</th>
                            <th width="8%">详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.no}}</td>
                            <td>{{item.quantity}}</td>
                            <td>{{item.amount}}</td>
                            <td>{{item.scrapDate}}</td>
                            <td>{{item.note}}</td>
                            <td>{{item.personName}}</td>
                            <td>{{item.createName?item.createName:'管理员'}}</td>
                            <td><a class="btn-blue check-btn" ng-click="checkDetail(item.id)">查看</a></td>
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
<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                no: $scope.no,
                scrapDateStart: $scope.createDateStart,
                scrapDateEnd: $scope.createDateEnd,
                operator: $scope.operator,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/psi/listGoodsScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.no = undefined;
            $scope.createDateStart = undefined;
            $scope.createDateEnd = undefined;
            $scope.operator = undefined;
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {
            var postData = {
                type: 'unset',
            };
            $http.post('../../Controller/psi/listGoodsScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
                layer.open({
                    type: 2,
                    title: '报废商品编辑',
                    area: ['100%', '100%'],
                    anim: '0',
                    resize: false,
                    move: false,
                    shadeClose: true,
                    offset: ['0', '0'],
                    content: 'editGoodsScrap.php',
                });
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.checkDetail = function (id) {
            layer.open({
                type: 2,
                title: '详情',
                area: ['100%', '100%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'detailsGoodsScrap.php?id=' + id,
            });
        }
        $('#excel').click(function () {
            var no = $scope.no ? $scope.no : '';
            var scrapDateStart = $scope.createDateStart ? $scope.createDateStart : '';
            var scrapDateEnd = $scope.createDateEnd ? $scope.createDateEnd : '';
            var operator = $scope.operator ? $scope.operator : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listGoodsScrapExcel.php?no=' + no + '&scrapDateStart=' + scrapDateStart + '&scrapDateEnd=' + scrapDateEnd + '&operator=' + operator;
        });
    });
</script>
</body>
</html>