<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/gds/material/findMaterialTypeList';
$datas = array('datas' => array('stoId' => $_SESSION['stoId']));
$json = http($url, $datas, 1);
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
    <title>汇汇生活商家后台-原料列表</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
    <script src="../../js/angular-cookies.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wboxform">
            <form class="layui-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">原料分类</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="typeId">
                                <option value="">请选择...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['typeName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">快速查找</label>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" class="layui-input" placeholder="请输入查找的原料名称/编码" ng-model="quickSearch">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>原料列表</h5>
                <div class="ibox-tools">
                    <a class="btn-blue details-btn" ng-click="addModal()">添加原料</a>
                    <a class="btn-red del-btn" ng-click="delModal()">删除</a>
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
                    <table class="layui-table" style="min-width: 1500px;">
                        <thead>
                        <tr class="text-c">
                            <th width="3%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                            <th width="10%">编码</th>
                            <th width="10%">名称</th>
                            <th width="8%">所属分类</th>
                            <th width="4%">单位</th>
                            <th width="6%">规格</th>
                            <th width="5%">库存</th>
                            <th width="7%">采购标准价</th>
                            <th width="7%">采购最高价</th>
                            <th width="5%">状态</th>
                            <th width="11%">修改时间</th>
                            <th width="8%">操作员</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()"/></td>
                            <td>{{item.code}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.typeName}}</td>
                            <td>{{item.unit}}</td>
                            <td>{{item.spec}}</td>
                            <td>{{item.stock ? item.stock : 0}}</td>
                            <td>{{item.standardPrice}}</td>
                            <td>{{item.maxPrice}}</td>
                            <td class="c-green" ng-if="item.openState==1">启用</td>
                            <td class="c-red" ng-if="item.openState==0">关闭</td>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.createName}}</td>
                            <td>
                                <a class="btn-orange txj-btn" ng-if="item.openState==1" ng-click="dealModal('close',item.id)">关闭</a>
                                <a class="btn-blue tsj-btn" ng-if="item.openState==0" ng-click="dealModal('open',item.id)">启用</a>
                                <a class="btn-green details-btn" ng-click="modifyModal(item.id)">修改</a>
                                <a class="btn-red goods-delbtn" ng-click="deleteModal(item.id)">删除</a>
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
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination', 'ngCookies']);
    app.controller('listController', function ($scope, $http, $cookies) {
        if($cookies.get("typeId")!=''){
            $scope.typeId=$cookies.get("typeId");
        }
        if($cookies.get("quickSearch")!=''){
            $scope.quickSearch=$cookies.get("quickSearch");
        }
        if($cookies.get("currentPage")!=''){
            $scope.currentPage=$cookies.get("currentPage");
        }
        var reSearch = function () {
            var postData = {
                type: 'list',
                mtypeId: $scope.typeId,
                quickSearch: $scope.quickSearch,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/material/listMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.typeId = '', $scope.quickSearch = ''
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: $scope.currentPage ? $scope.currentPage : 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
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
        $scope.addModal = function () {
            layer.open({
                type: 2,
                title: '添加原料',
                area: ['460px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'detailsMaterial.php',
            });
        }
        $scope.dustbinModal = function () {
            layer.open({
                type: 2,
                title: '回收站',
                area: ['100%', '100%'],
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'recycleMaterial.php',
            });
        }
        $scope.deleteModal = function (id) {
            var postData = {type: 'delOne', delId: id};
            layer.alert('亲，您确定删除该原料吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                $http.post('../../Controller/material/listMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 1000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.delModal = function () {
            var postData = {type: 'delMore', delIds: $scope.checked};
            layer.alert('亲，您确定删除选中的原料吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                $http.post('../../Controller/material/listMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        $scope.checked = [];
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 1000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.modifyModal = function (id) {
            var mtypeId = $scope.typeId ? $scope.typeId : '';
            var quickSearch = $scope.quickSearch ? $scope.quickSearch : '';
            var currentPage = $scope.paginationConf.currentPage;
            if (mtypeId != '') {
                $cookies.put("mtypeId", mtypeId, {expires: new Date(new Date().getTime() + 36000)});
            }
            if (quickSearch != '') {
                $cookies.put("quickSearch", quickSearch, {expires: new Date(new Date().getTime() + 36000)});
            }
            $cookies.put("currentPage", currentPage, {expires: new Date(new Date().getTime() + 36000)});
            layer.open({
                type: 2,
                title: '修改原料',
                area: ['460px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'detailsMaterial.php?id=' + id,
            });
        }
        $scope.dealModal = function (t, id) {
            var postData = {type: 'deal', id: id};
            if (t == 'open') {
                layer.alert('亲，您确定将该原料重新启用吗？', {icon: 3, resize: false, title: "启用",}, function (index) {
                    $http.post('../../Controller/material/listMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if (result.data.success) {
                            layer.msg('启动成功！', {icon: 6, time: 1000});
                            return reSearch();
                        } else {
                            layer.msg(result.data.message, {time: 1000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    });
                });
            } else {
                layer.alert('亲，您确定将该原料关闭吗？', {icon: 3, resize: false, title: "关闭",}, function (index) {
                    $http.post('../../Controller/material/listMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if (result.data.success) {
                            layer.msg('关闭成功！', {icon: 6, time: 1000});
                            return reSearch();
                        } else {
                            layer.msg(result.data.message, {time: 1000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    });
                });
            }
        }
        $('#excel').click(function () {
            var mtypeId = $scope.typeId ? $scope.typeId : '';
            var quickSearch = $scope.quickSearch ? $scope.quickSearch : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listMaterialExcel.php?mtypeId=' + mtypeId + '&quickSearch=' + quickSearch;
        });
    });
</script>
</body>
</html>