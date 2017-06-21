<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/gds/manage/category/list';
$data = array('datas' => array('stoId' => $_SESSION['stoId']));
$json = http($url, $data, 1);
$list = $json['datas']['list'];
$num = count($list);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品库存</title>
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
                        <label class="layui-form-label">商品分类</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="catId">
                                <option value="">请选择...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?PHP echo $list[$i]['catId'] ?>"><?PHP echo $list[$i]['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" class="layui-input" placeholder="请输入商品名称" ng-model="goodName">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">商品编码</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" class="layui-input" placeholder="请输入商品编码" ng-model="goodCode">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">库存小于</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="inventory">
                                <option value="">请选择...</option>
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>商品库存列表</h5>
                <div class="ibox-tools">
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
                            <th width="16%">商品编码</th>
                            <th width="16%">商品名称</th>
                            <th width="13%">商品分类</th>
                            <th width="6%">单位</th>
                            <th width="12%">规格</th>
                            <th width="8%">商品单价</th>
                            <th width="10%">库存</th>
                            <th width="12%">库存金额</th>
                            <th width="8%">详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list|orderBy : '-no'">
                            <td>{{item.no}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.catName}}</td>
                            <td>{{item.unit}}</td>
                            <td>{{item.skuName}}</td>
                            <td>{{item.salePrice}}</td>
                            <td>{{item.storeNum ? item.storeNum : 0}}</td>
                            <td>{{item.salePrice*item.storeNum|number:2}}</td>
                            <td><a class="btn-blue check-btn" ng-click="checkModal(item.itemId,item.itemType)">查看</a></td>
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
                catId: $scope.catId,
                name: $scope.goodName,
                no: $scope.goodCode,
                storeNum: $scope.inventory,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/inventory/listGoodsInventoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.catId = undefined;
            $scope.goodName = undefined;
            $scope.goodCode = undefined;
            $scope.inventory = undefined;
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.checkModal = function (id, type) {
            layer.open({
                type: 2,
                title: '详情',
                area: ['100%', '100%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'detailsGoodsInventory.php?id=' + id + '&type=' + type,
            });
        }
        $('#excel').click(function () {
            var catId = $scope.catId ? $scope.catId : '';
            var name = $scope.goodName ? $scope.goodName : '';
            var no = $scope.goodCode ? $scope.goodCode : '';
            var storeNum = $scope.inventory ? $scope.inventory : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listGoodsInventoryExcel.php?catId=' + catId + '&name=' + name + '&no=' + no + '&storeNum=' + storeNum;
        });
    });
</script>
</body>
</html>