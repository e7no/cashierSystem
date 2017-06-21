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
    <title>汇汇生活商家后台-商品类别</title>
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
                <h5>商品分类</h5>
                <div class="ibox-tools">
                    <?php if ($downGoods == 1 || $stoType != 2) { ?>
                        <a class="btn-blue level-btn" ng-click="addModal()">新增分类</a>
                    <?php } ?>
                    <a class="btn-green" id="excel">导出</a>
                    <!--                    <a class="btn-blue" href="javascript:;">导入</a>-->
                    <a class="btn-delete" ng-click="deleteModal()"><i class="iconfont will-huishou"></i></a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 800px;">
                        <thead>
                        <tr class="text-c">
                            <th width="26%">分类名称</th>
                            <th width="18%">分类类型</th>
                            <th width="20%">修改时间</th>
                            <th width="10%">前台排序</th>
                            <th width="15%">操作员</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.name}}</td>
                            <?php if ($stoType == 1) { ?>
                                <td>总部分类</td>
                            <?php } else if ($stoType == 2) { ?>
                                <td ng-if="item.type==2">总部分类</td>
                                <td ng-if="item.type==1">门店分类</td>
                            <?php } else { ?>
                                <td> </td>
                            <?php } ?>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.sn}}</td>
                            <td>{{item.operator}}</td>
                            <?php if ($stoType != 2) { ?>
                                <td>
                                    <a class="btn-green" ng-click="modifyModal(item)">修改</a>
                                    <a class="btn-red del-btn" ng-click="delModal(item.catId)">删除</a>
                                </td>
                            <?php } else { ?>
                                <td ng-if="item.type==1">
                                    <a class="btn-green" ng-click="modifyModal(item)">修改</a>
                                    <a class="btn-red del-btn" ng-click="delModal(item.catId)">删除</a>
                                </td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--修改分类-->
    <div class="popup popup-Level" id="modify">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input name="title" placeholder="请输入分类名称" class="layui-input" ng-model="modifyName" type="text" autocomplete="off">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">前台排序</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input name="title" placeholder="请输入前台排序编号" class="layui-input" ng-model="modifySn" type="text"
                           onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                </div>
            </div>
            <div style="margin-top: 8px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <span style="font-size: 12px; color: #999;">分类的排序，从小到大，越小排序则越在前面</span>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal Level-submit" value="保存" ng-click="saveModiyModal()">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModify()"/>
            </div>
        </form>
    </div>
    <!--新增分类-->
    <div class="popup popup-Level" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input name="title" placeholder="请输入分类名称" class="layui-input" ng-model="addcatName" type="text">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">前台排序</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input name="title" placeholder="请输入前台排序编号" class="layui-input" ng-model="addSn" type="text"
                           onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                </div>
            </div>
            <div style="margin-top: 8px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <span style="font-size: 12px; color: #999;">分类的排序，从小到大，越小排序则越在前面</span>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal Level-submit" value="保存" ng-click="saveAddModal()">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetAdd()"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        $scope.st = '<?php echo $stoType;?>';
        var reSearch = function () {
            var postData = {
                type: 'list',
                status: '0',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
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
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {
            $scope.addcatName = '';
            $scope.addSn = '';
            layer.open({type: 1, title: "新增分类", area: ['350px', '220px'], shadeClose: true, resize: false, content: $("#add")});
        }
        $scope.resetAdd = function () {
            $scope.addcatName = '';
            $scope.addSn = '';
        }
        $scope.modifyModal = function (item) {
            $scope.modifyId = item.catId;
            $scope.modifyName = item.name;
            $scope.modifySn = item.sn;
            layer.open({type: 1, title: "修改分类", area: ['350px', '220px'], shadeClose: true, resize: false, content: $("#modify")});
        }
        $scope.saveAddModal = function () {
            var postData = {
                type: 'add',
                name: $scope.addcatName,
                sn: $scope.addSn,
            };
            $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 1000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.saveModiyModal = function () {
            var postData = {
                type: 'modify',
                catId: $scope.modifyId,
                name: $scope.modifyName,
                sn: $scope.modifySn,
            };
            $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 1000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetModify = function () {
            $scope.modifyId = '';
            $scope.modifyName = '';
            $scope.modifySn = '';
        }
        $scope.delModal = function (id) {
            layer.alert('您确定要删除该分类吗?', {icon: 5, title: "删除", resize: false,}, function (index) {
                var postData = {type: 'del', id: id};
                $http.post('../../Controller/goods/goodsCategoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg('删除成功！', {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 1000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });

            });
        }
        $scope.deleteModal = function () {
            layer.open({
                type: 2,
                title: '回收站',
                area: ['100%', '100%'],
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'recycleGoodsCategory.php',
            });
        }
        $('#excel').click(function () {
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/goodsCategoryExcel.php';
        });
    });
</script>
</body>
</html>