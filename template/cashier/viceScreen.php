<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/sto/manage/storeBasic/getByStoreId/' . $_SESSION['stoId'];
$json = http($url, '', 1);
$list = $json['datas']['basicSettingsVO'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-副屏管理</title>
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
                <h5>副屏管理</h5>
                <div class="ibox-tools">
                    <a class="btn-blue news-btn" ng-click="addImgModal()">新增图片</a>
                    <a class="btn-orange set-btn" ng-click="setModal()">副屏设置</a>
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
                            <th width="8%">排序</th>
                            <th width="32%">副屏标题</th>
                            <th width="15%">状态</th>
                            <th width="12%">图片</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list|orderBy:'-sn'">
                            <td>{{item.sn}}</td>
                            <td>{{item.name}}<span style="font-size: 12px; color: #999;"></span></td>
                            <td class="c-green" ng-if="item.status==1">启用</td>
                            <td class="c-red" ng-if="item.status==0">关闭</td>
                            <td><a ng-click="checkImg(item.id)" class="view-btn">查看</a></td>
                            <td>
                                <a class="btn-green news-btn" ng-click="editImgModal(item.id)">修改</a>
                                <a class="btn-red del-btn" ng-click="deleteModal(item.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--副屏设置-->
    <div class="popup set-popup" id="set">
        <form class="layui-form">
            <div class="layui-form-item">
                <label class="layui-form-label">支持副屏</label>
                <div class="layui-input-inline" style="width: 100px;padding: 4px 0;">
                    <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive]">
                        <input type="checkbox" ng-checked="isActive" ng-click="changeClass()"/>
                        <i class="iconfont"></i>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">切换时间</label>
                <div class="layui-input-inline" style="width: 210px;">
                    <input type="text" class="layui-input" ng-model="times" placeholder="请输入图片切换时间(单位：秒)">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal sp-btn" ng-click="saveSetModal()" value="设置">
            </div>
        </form>
    </div>
    <!--查看图片-->
    <div class="popup view-img">
        <img ng-src="{{thisPicture}}"/>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        if ('<?php echo $list['viceScreen'];?>' == 1) {
            $scope.isActive = true;
        } else {
            $scope.isActive = false;
        }
        $scope.times = '<?php echo $list['interv']?$list['interv']:'0';?>';
        var reSearch = function () {
            var postData = {
                type: 'list',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
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
        $scope.changeClass = function () {
            $scope.isActive = !$scope.isActive
        }
        $scope.checkImg = function (id) {
            layer.open({type: 1, title: false, closeBtn: 0, area: '600px', skin: 'layui-layer-nobg', shadeClose: true, content: $(".view-img"),});
            var postData = {
                type: 'checkImg',
                imgId: id
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    $scope.thisPicture = result.data.pic;
                } else {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.addImgModal = function () {
            layer.open({
                type: 2,
                title: '添加副屏',
                area: ['460px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'addVice.php',
            });
        }
        $scope.editImgModal = function (id) {
            layer.open({
                type: 2,
                title: '修改副屏',
                area: ['460px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'editVice.php?id=' + id,
            });
        }
        $scope.deleteModal = function (id) {
            layer.alert('亲，您确定删除该副屏广告吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                var postData = {type: 'del', delId: id};
                $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg('删除成功！', {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.setModal = function () {
            layer.open({type: 1, title: "副屏设置", area: ['320px', '200px'], shadeClose: true, resize: false, content: $("#set"),});
        }
        $scope.saveSetModal = function () {
            var status = 0;
            if ($scope.isActive) {
                status = 1;
            } else {
                status = 0;
            }
            var postData = {
                type: 'set',
                time: $scope.times,
                status: status,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg('恭喜你，设置成功！', {icon: 6, time: 1000});
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });
</script>
</body>
</html>