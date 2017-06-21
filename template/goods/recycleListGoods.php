<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/gds/manage/goods/queryStoreGoods';
$datas = array('datas' => array('stoId' => $_SESSION['stoId']));
$json = http($url, $datas, 1);
$list = $json['datas']['goodsList'];
$catList = second_array_unique_bykey($list, 'catId');
$num = count($catList);
$stoType = $_SESSION['stoType'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品列表-回收站</title>
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
                        <label class="layui-form-label">商品类别</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="CatId">
                                <option value="">请选择...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?php echo $catList[$i]['catId']; ?>"><?php echo $catList[$i]['catName']; ?></option>
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
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 2000px;">
                        <thead>
                        <tr class="text-c">
                            <th width="6%">编码</th>
                            <th width="3%">商品图片</th>
                            <th width="6%">商品名称</th>
                            <th width="4%">所属分类</th>
                            <th width="3%">单位</th>
                            <th width="4%">称重商品</th>
                            <th width="8%">规格</th>
                            <th width="9%">进价</th>
                            <th width="9%">收银价</th>
                            <th width="9%">商城价</th>
                            <th width="9%">积分价</th>
                            <th width="5%">商品库类型</th>
                            <th width="3%">状态</th>
                            <th width="5%">保质期</th>
                            <th width="9%">修改时间</th>
                            <th width="4%">操作员</th>
                            <th width="4%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.no}}</td>
                            <td ng-if="item.bigImagePath!=''"><a class="details-btn"><img ng-src="{{filePath+'/'+item.bigImagePath}}" width="60" height="60"></a></td>
                            <td ng-if="item.bigImagePath==''"><a class="details-btn"><img src="../../img/img-bg.png" width="60" height="60"></a></td>
                            <td><a class="details-btn">{{item.name}}</a></td>
                            <td>{{item.catName}}</td>
                            <td>{{item.unit}}</td>
                            <td class="c-green" ng-if="item.weight==1">√</td>
                            <td class="c-red" ng-if="item.weight==0">×</td>
                            <td>{{item.skuText}}</td>
                            <td>{{item.skuInPriceText}}</td>
                            <td>{{item.skuSalePriceText}}</td>
                            <td>{{item.skuTakeOutPriceText}}</td>
                            <td>{{item.skuIntegralText}}</td>
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
                            <td>{{item.modifyName?item.modifyName:'管理员'}}</td>
                            <td>
                                <?php if ($stoType == 1) { ?>
                                    <a class="btn-blue restore-btn" ng-click="recoverModal(item.id)">恢复</a>
                                <?php } else { ?>
                                    <a class="btn-blue restore-btn" ng-if="item.type!=2" ng-click="recoverModal(item.id)">恢复</a>
                                    <a class="btn-blue restore-btn" ng-if="item.type==2"></a>
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
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        $scope.isFa = false;
        $scope.storeType = '<?php echo $stoType;?>';
        if ($scope.storeType == 1) {
            $scope.StoType = 2;
            $scope.isFa = true;
        }
        var reSearch = function () {
            var postData = {
                type: 'delete',
                CatId: $scope.CatId ? $scope.CatId : undefined,
                StoType: $scope.StoType ? $scope.StoType : undefined,
                quick: $scope.quick,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage
            };
            $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.filePath = result.data.filePath;
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.CatId = undefined;
            $scope.quick = '';
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.recoverModal = function (id) {
            layer.alert('确认恢复该商品吗？', {icon: 3, title: "商品恢复", resize: false,}, function (index) {
                var postData = {
                    type: 'recover',
                    id: id
                };
                $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                        parent.layer.msg('恢复成功！', {icon: 6, time: 1500});
                        parent.location.reload();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });

            });
        }
    });
</script>
</body>
</html>