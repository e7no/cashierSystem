<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/gds/manage/category/list';
$datas = array('datas' => array('stoId' => $_SESSION['stoId'], 'status' => '0'));
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
$stoType = $_SESSION['stoType'];
$modifyPrice = $_SESSION['authModifyPrice'];
$downGoods = $_SESSION['authDownGoods'];
$page = $_GET["page"] ? $_GET["page"] : 1;
$CatId = $_GET['CatId'] ? $_GET["CatId"] : "";
$StoType = $_GET['StoType'] ? $_GET["StoType"] : "";
$quick = $_GET['quick'] ? $_GET["quick"] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品列表</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css?v=1"/>
    <!--    <link rel="stylesheet" type="text/css" href="../../js/dialog/css/dialog.css"/>-->
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
                        <label class="layui-form-label">商品类别</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="CatId">
                                <option value="">请选择...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?php echo $list[$i]['catId']; ?>"><?php echo $list[$i]['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline" ng-hide="isFa">
                        <label class="layui-form-label">商品库类型</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="StoType" id="stoChoose">
                                <option value="">请选择...</option>
                                <option value="2">总部商品</option>
                                <option value="1">分店商品</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">快速查找</label>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" class="layui-input" ng-model="quick" placeholder="请输入查找的商品名称/编码">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>商品列表</h5>
                <div class="ibox-tools">
                    <?php if ($stoType != 2) { ?>
                        <a class="btn-blue details-btn" ng-click="addPorModal()">新增商品</a>
                    <?php } else { ?>
                        <?php if ($downGoods) { ?>
                            <a class="btn-blue details-btn" ng-click="addPorModal()">新增商品</a>
                        <?php } else {
                        } ?>
                    <?php } ?>
                    <a class="btn-red del-btn" ng-click="delModal()">删除</a>
                    <a class="btn-green" id="excel">导出</a>
                    <!--<a class="btn-blue" href="javascript:;">导入</a>-->
                    <!--                    <a class="btn-keep" ng-hide="isFa" ng-click="downloadModal()">总部商品库下载</a>-->
                    <a class="btn-delete" ng-click="deleteModal()"><i class="iconfont will-huishou"></i></a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 3000px;">
                        <thead>
                        <tr class="text-c">
                            <th width="2%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                            <th width="6%">编码</th>
                            <th width="3%">商品图片</th>
                            <th width="6%">商品名称</th>
                            <th width="4%">所属分类</th>
                            <th width="2%">单位</th>
                            <th width="3%">称重商品</th>
                            <th width="8%">规格</th>
                            <th width="9%">进价</th>
                            <th width="9%">收银价</th>
                            <th width="9%">商城价</th>
                            <th width="9%">积分价</th>
                            <th width="4%">商品库类型</th>
                            <th width="2%">状态</th>
                            <th width="5%">保质期</th>
                            <th width="6%">修改时间</th>
                            <th width="3%">操作员</th>
                            <th width="12%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td><input type="checkbox" ng-model="item.checked" ng-change="selectOne()" ng-disabled="sType!=1&&item.type==2"/></td>
                            <td>{{item.no}}</td>
                            <td ng-if="item.bigImagePath!=''"><a class="details-btn"><img ng-src="{{filePath+'/'+item.bigImagePath}}" width="60"
                                                                                          height="60"></a></td>
                            <td ng-if="item.bigImagePath==''"><a class="details-btn"><img src="../../img/img-bg.png" width="60" height="60"></a></td>
                            <?php if ($stoType != 2) { ?>
                                <td><a class="details-btn" ng-click="modifyModal(item.id,1)">{{item.name}}</a></td>
                            <?php } else { ?>
                                <td ng-if="item.type!=2"><a class="details-btn" ng-click="modifyModal(item.id,1)">{{item.name}}</a></td>
                                <?php if ($modifyPrice == 0) { ?>
                                    <td ng-if="item.type==2"><a class="details-btn" ng-click="modifyModal(item.id,2)">{{item.name}}</a></td>
                                <?php } else { ?>
                                    <td ng-if="item.type==2"><a class="details-btn">{{item.name}}</a></td>
                                <?php } ?>

                            <?php } ?>
                            <td>{{item.catName}}</td>
                            <td>{{item.unit}}</td>
                            <td class="c-green" ng-if="item.weight==1">√</td>
                            <td class="c-red" ng-if="item.weight==0">×</td>
                            <td>{{item.skuText}}</td>
                            <td>{{item.skuInPriceText}}</td>
                            <td ng-if="item.saleStatus==1">{{item.skuSalePriceText}}</td>
                            <td ng-if="item.saleStatus!=1"></td>
                            <td ng-if="item.takeOut==1">{{item.skuTakeOutPriceText}}</td>
                            <td ng-if="item.takeOut!=1"></td>
                            <td ng-if="item.useIntegral==1">{{item.skuIntegralText}}</td>
                            <td ng-if="item.useIntegral!=1"></td>
                            <?php if ($stoType == 1) { ?>
                                <td>总部商品</td>
                            <?php } else if ($stoType == 2) { ?>
                                <td ng-if="item.type!=2">分店商品</td>
                                <td ng-if="item.type==2">总部商品</td>
                            <?php } else { ?>
                                <td></td>
                            <?php } ?>
                            <td class="c-green" ng-if="item.status==0">上架</td>
                            <td class="c-red" ng-if="item.status==1">下架</td>
                            <td>{{item.bzq}}</td>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.modifyName?item.modifyName:item.createName}}</td>
                            <td>
                                <?php if ($stoType == 1) { ?>
                                    <a class="btn-orange txj-btn" ng-if="item.status==1" ng-click="upModal(item.id)">上架</a>
                                    <a class="btn-red txj-btn" ng-if="item.status==0" ng-click="downModal(item.id)">下架</a>
                                    <a class="btn-green revise-btn" ng-click="modifyModal(item.id,1)">修改</a>
                                    <a class="btn-keep price-btn" ng-click="ctlModal(item.id)">价格调控</a>
                                    <a class="btn-red goods-delbtn" ng-click="delModal(item.id)">删除</a>
                                    <a class="btn-blue print-btn" ng-click="printModal(item.id)">标签打印</a>
                                <?php } else if ($stoType == 0) { ?>
                                    <a class="btn-orange txj-btn" ng-if="item.status==1" ng-click="upModal(item.id)">上架</a>
                                    <a class="btn-red txj-btn" ng-if="item.status==0" ng-click="downModal(item.id)">下架</a>
                                    <a class="btn-green revise-btn" ng-click="modifyModal(item.id,1)">修改</a>
                                    <a class="btn-red goods-delbtn" ng-click="delModal(item.id)">删除</a>
                                    <a class="btn-blue print-btn" ng-click="printModal(item.id)">标签打印</a>
                                <?php } else { ?>
                                    <a class="btn-orange txj-btn" ng-if="item.type!=2&&item.status==1" ng-click="upModal(item.id)">上架</a>
                                    <a class="btn-gray txj-btn" ng-if="item.type==2&&item.status==1">上架</a>
                                    <a class="btn-red txj-btn" ng-if="item.type!=2 && item.status==0" ng-click="downModal(item.id)">下架</a>
                                    <a class="btn-gray txj-btn" ng-if="item.type==2&&item.status==0">下架</a>
                                    <a class="btn-green revise-btn" ng-if="item.type!=2" ng-click="modifyModal(item.id,1)">修改</a>
                                    <?php if ($modifyPrice == 0) { ?>
                                        <a class="btn-green revise-btn" ng-if="item.type==2" ng-click="modifyModal(item.id,2)">修改</a>
                                    <?php } else { ?>
                                        <a class="btn-gray revise-btn" ng-if="item.type==2">修改</a>
                                    <?php } ?>
                                    <a class="btn-red goods-delbtn" ng-if="item.type!=2" ng-click="delModal(item.id)">删除</a>
                                    <a class="btn-gray goods-delbtn" ng-if="item.type==2">删除</a>
                                    <a class="btn-blue print-btn" ng-click="printModal(item.id)">标签打印</a>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--    <div class="loding-bg" ng-show="isShamde"></div>-->
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<!--<script type="text/javascript" src="../../js//dialog/js/dialog.js"></script>-->
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        $scope.sType = '<?php echo $stoType;?>';
        $scope.isFa = false;
        $scope.isShamde = false;
        $scope.currentPage = <?php echo $page;?>;
        $scope.CatId = '<?php echo $CatId;?>';
        $scope.StoType = '<?php echo $StoType;?>';
        $scope.quick = '<?php echo $quick;?>';
        var reSearch = function () {
            if ($scope.sType == 1) {
                $scope.isFa = true;
            } else {
                $scope.storeType = '<?php echo $stoType;?>';
            }
            $scope.currentPage = <?php echo $page;?>;
            if($scope.currentPage==1){
            	$scope.currentPage = $scope.paginationConf.currentPage;
            }
            if($scope.currentPage!=$scope.paginationConf.currentPage && $scope.paginationConf.currentPage!=1){
            	$scope.currentPage = $scope.paginationConf.currentPage;
            }
            if($scope.currentPage!=$scope.paginationConf.currentPage && $scope.paginationConf.currentPage==1){
            	$scope.currentPage = $scope.paginationConf.currentPage;
            }
            var postData = {
                type: 'list',
                CatId: $scope.CatId ? $scope.CatId : undefined,
                StoType: $scope.StoType ? $scope.StoType : undefined,
                quick: $scope.quick,
                currentPage: $scope.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.filePath = result.data.filePath;
                $scope.compelDownGoods = result.data.compelDownGoods;
                $scope.editParentGoodsStatus = result.data.editParentGoodsStatus;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.CatId = undefined;
            $scope.quick = '';
            $scope.StoType = undefined;
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: $scope.currentPage, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addPorModal = function () {
            layer.open({
                type: 2,
                title: '添加商品',
                area: ['645px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'detailsGoods.php',
            });
        }
        $scope.checked = [];
        $scope.selectAll = function () {
            if ($scope.select_all) {
                $scope.checked = [];
                angular.forEach($scope.list, function (item) {
                    if ($scope.sType != '2') {
                        item.checked = true;
                        $scope.checked.push(item.id);
                    } else {
                        if (item.type != 2) {
                            item.checked = true;
                            $scope.checked.push(item.id);
                        }
                    }
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    item.checked = false;
                    $scope.checked = [];
                })
            }
        }
        $scope.selectOne = function () {
            angular.forEach($scope.list, function (item) {
                var index = $scope.checked.indexOf(item.id);
                if (item.checked && index === -1) {
                    $scope.checked.push(item.id);
                } else if (!item.checked && index !== -1) {
                    $scope.checked.splice(index, 1);
                }
            })
            if ($scope.list.length === $scope.checked.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.delModal = function (id) {
            var ids = '';
            if (angular.isUndefined(id)) {
                ids = $scope.checked;
            } else {
                ids = id;
            }
            if (ids == '') {
                layer.msg('请选择需要删除的商品！', {time: 3000});
            } else {
                layer.alert('亲，您确定删除选中的商品吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                    var postData = {type: 'del', ids: ids,};
                    $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                        if (result.data.success) {
                            layer.msg(result.data.message, {icon: 6, time: 1000});
                            return reSearch();
                        } else {
                            layer.msg(result.data.message, {time: 3000});
                        }
                    }).catch(function () { //捕捉错误处理
                        layer.msg('服务端请求错误！', {time: 3000});
                    });
                });
            }

        }
        $scope.upModal = function (id) {
            layer.alert('亲，您确定将该商品重新上架吗？', {icon: 3, resize: false, title: "上架",}, function (index) {
                var postData = {type: 'up', id: id,};
                $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.downModal = function (id) {
            layer.alert('亲，您确定下架该商品吗？', {icon: 5, resize: false, title: "下架",}, function (index) {
                var postData = {type: 'down', id: id,};
                $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.ctlModal = function (id) {
        	var page = $scope.currentPage;
            var CatId = $scope.CatId;
            var StoType = $scope.StoType;
            var quick = $scope.quick;
            layer.open({
                type: 2,
                title: '商品价格调控',
                area: ['100%', '100%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'priceControl.php?id=' + id + '&page=' + page + '&CatId=' + CatId + '&StoType=' + StoType + '&quick=' + quick,
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
                content: 'recycleListGoods.php',
            });
        }
//        $scope.downloadModal = function () {
//            $scope.isShamde = true;
//            LoadDialog("商品库下载中");
//            var postData = {type: 'update'};
//            $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
//                if (result.data.success) {
//                    RemoveLoadDialog();
//                    $scope.isShamde = false;
//                    layer.msg('下载成功！', {icon: 6, time: 1000});
//                    return reSearch();
//                } else {
//                    RemoveLoadDialog();
//                    $scope.isShamde = false;
//                    layer.msg(result.data.message, {time: 3000});
//                }
//            }).catch(function () { //捕捉错误处理
//                layer.msg('服务端请求错误！', {time: 3000});
//            });
//        }
        $scope.printModal = function (id) {
            layer.open({
                type: 2,
                title: '商品标签打印',
                area: ['400px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'printLabel.php?id=' + id,
            });
        }
        $scope.modifyModal = function (id, t) {
            var page = $scope.currentPage;
            var CatId = $scope.CatId;
            var StoType = $scope.StoType;
            var quick = $scope.quick;
            layer.open({
                type: 2,
                title: '商品修改',
                area: ['645px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'editGoods.php?id=' + id + '&t=' + t + '&page=' + page + '&CatId=' + CatId + '&StoType=' + StoType + '&quick=' + quick,
            });
        }
        $('#excel').click(function () {
            if ($scope.sType == 1) {
                var StoType = $scope.StoType;
            } else {
                var StoType = '<?php echo $stoType;?>';
            }
            var CatId = $scope.CatId ? $scope.CatId : '';
            var quick = $scope.quick ? $scope.quick : '';
            var StoType = $scope.StoType;
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listGoodsExcel.php?CatId=' + CatId + '&quick=' + quick + '&StoType=' + StoType;
        });
    });
</script>
</body>
</html>