<?php
include('../../Common/check.php');
$id = $_GET['id'];
$page = $_GET['page'];
$CatId = $_GET['CatId'];
$StoType = $_GET['StoType'];
$quick = $_GET['quick'];
if ($id == '') {
    echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新查询！\',{icon: 5,time:2000});</script>';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-商品价格调控</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-title">
                <h5>商品分类</h5>
                <div class="ibox-tools">
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <form class="price-form">
                    <div class="con-table">
                        <table class="layui-table" style="min-width: 1800px;">
                            <thead>
                            <tr class="text-c">
                                <th class="text-l"></th>
                                <th width="5%">收银系统</th>
                                <th width="23%">收银价（元）</th>
                                <th width="5%">商城</th>
                                <th width="23%">商城价（元）</th>
                                <th width="5%">积分兑换</th>
                                <th width="23%">积分价</th>
                            </tr>
                            <tr class="text-c">
                                <th class="text-l">总部参考价格</th>
                                <th><input type="checkbox" ng-checked="head1" disabled/></th>
                                <th ng-if="head1">
                                    <span ng-repeat="skuh in skuList"
                                          style="padding-right: 50px;">{{skuh.salePrice}}  ({{skuh.skuName}})</span>
                                </th>
                                <th ng-if="!head1">
                                    <span>/</span>
                                </th>
                                <th><input type="checkbox" ng-checked="head2" disabled/></th>
                                <th ng-if="head2">
                                    <span ng-repeat="skuh in skuList"
                                          style="padding-right: 50px;">{{skuh.takeOutPrice}}  ({{skuh.skuName}})</span>
                                </th>
                                <th ng-if="!head2">
                                    <span>/</span>
                                </th>
                                <th><input type="checkbox" ng-checked="head3" disabled/></th>
                                <th ng-if="head3">
                                    <span ng-repeat="skuh in skuList"
                                          style="padding-right: 50px;">{{skuh.integral}}  ({{skuh.skuName}})</span>
                                </th>
                                <th ng-if="!head3">
                                    <span>/</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c" ng-repeat="item in list">
                                <td class="text-l">{{item.stoName}}</td>
                                <td><input type="checkbox" ng-show="head1" ng-model="$parent.check1[item.goodsId]"/></td>
                                <td>
                                    <div ng-show="$parent.check1[item.goodsId]">
                                        <div class="price-box" ng-repeat="sku in item.skuList">
                                            <input type="text" class="layui-input price-text" placeholder="售价" ng-model="$parent.salePrice[sku.skuId]"
                                                   onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" autocomplete="off"/>
                                            <span>({{sku.skuName}})</span>
                                        </div>
                                    </div>
                                </td>
                                <td><input type="checkbox" ng-show="head2" ng-model="$parent.check2[item.goodsId]"/></td>
                                <td>
                                    <div ng-show="$parent.check2[item.goodsId]">
                                        <div class="price-box" ng-repeat="sku in item.skuList">
                                            <input type="text" class="layui-input price-text" placeholder="售价" ng-model="$parent.takeOutPrice[sku.skuId]"
                                                   onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" autocomplete="off"/>
                                            <span>({{sku.skuName}})</span>
                                        </div>
                                    </div>
                                </td>
                                <td><input type="checkbox" ng-show="head3" ng-model="$parent.check3[item.goodsId]"/></td>
                                <td>
                                    <div ng-show="$parent.check3[item.goodsId]">
                                        <div class="price-box" ng-repeat="sku in item.skuList">
                                            <input type="text" class="layui-input price-text" placeholder="售价" ng-model="$parent.integral[sku.skuId]"
                                                   onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" autocomplete="off"/>
                                            <span>({{sku.skuName}})</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="text-l">
                                <td colspan="7" class="c-blue">温馨提示：可在“门店商品价格批量设置”项统一修改各门店的销售渠道和销售价格，再对个别门店进行调整</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-form-item">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal price-btn" value="保存" ng-click="saveModal()"/>
                        <input type="button" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModal()"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<!--	<script type="text/javascript" src="../../js/priceControl.js"></script>-->
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        $scope.check1 = [];
        $scope.check2 = [];
        $scope.check3 = [];
        $scope.salePrice = [];
        $scope.takeOutPrice = [];
        $scope.integral = [];
        $scope.stoIdArr = [];
        $scope.goodsIdArr = [];
        $scope.skuIdArr = [];
        var postData = {type: 'ctl', id: '<?php echo $id;?>'};
        $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
            if(result.data.subGoodsList.length==0){
                layer.msg('该商品暂无分店下载，无法调控！', {time: 3000});
                return;
            }
            if (result.data.parentGoodsObj.saleStatus == 1) {
                $scope.head1 = true;
            } else {
                $scope.head1 = false;
            }
            if (result.data.parentGoodsObj.takeOut == 1) {
                $scope.head2 = true;
            } else {
                $scope.head2 = false;
            }
            if (result.data.parentGoodsObj.useIntegral == 1) {
                $scope.head3 = true;
            } else {
                $scope.head3 = false;
            }
            $scope.skuList = result.data.parentGoodsObj.skuList;
            $scope.fsalePrice = result.data.parentGoodsObj.salePrice;
            $scope.ftakeOutPrice = result.data.parentGoodsObj.takeOutPrice;
            $scope.fintegral = result.data.parentGoodsObj.integral;
            $scope.list = result.data.subGoodsList;
            $scope.stoNum = result.data.subGoodsList.length;
            if ($scope.stoNum == 0 || $scope.stoNum == '') {
                $scope.check1 = [];
                $scope.check2 = [];
                $scope.check3 = [];
                $scope.salePrice = [];
                $scope.takeOutPrice = [];
                $scope.integral = [];
            } else {
                angular.forEach(result.data.subGoodsList, function (item) {
                    $scope.skuIdArr[item.goodsId] = [];
                    var i = 0;
                    angular.forEach(item.skuList, function (items) {
                        $scope.skuIdArr[item.goodsId][i] = [];
                        if (items.saleStatus == 1 && $scope.head1 == 1) {
                            $scope.check1[item.goodsId] = true;
                        } else {
                            $scope.check1[item.goodsId] = false;
                        }
                        if (items.takeOut == 1 && $scope.head2 == 1) {
                            $scope.check2[item.goodsId] = true;
                        } else {
                            $scope.check2[item.goodsId] = false;
                        }
                        if (items.useIntegral == 1 && $scope.head3 == 1) {
                            $scope.check3[item.goodsId] = true;
                        } else {
                            $scope.check3[item.goodsId] = false;
                        }
                        $scope.salePrice[items.skuId] = items.salePrice;
                        $scope.takeOutPrice[items.skuId] = items.takeOutPrice;
                        $scope.integral[items.skuId] = items.integral;
                        $scope.skuIdArr[item.goodsId][i].push(items.skuId);
                        i++;
                    });
                    $scope.goodsIdArr.push(item.goodsId);
                })
            }
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.saveModal = function () {
            var gNum = $scope.goodsIdArr.length;
            var userId = '<?php echo $_SESSION['bUserId']?>';
            var datas = new Array();
            for (var i = 0; i < gNum; i++) {
                datas[i] = {};
                datas[i]['saleStatus'] = $scope.check1[$scope.goodsIdArr[i]] ? 1 : 0;
                datas[i]['takeOut'] = $scope.check2[$scope.goodsIdArr[i]] ? 1 : 0;
                datas[i]['useIntegral'] = $scope.check3[$scope.goodsIdArr[i]] ? 1 : 0;
                datas[i]['salePrice'] = $scope.fsalePrice;
                datas[i]['takeOutPrice'] = $scope.ftakeOutPrice;
                datas[i]['integral'] = $scope.fintegral;
                datas[i]['modifyId'] = userId;
                datas[i]['goodsId'] = $scope.goodsIdArr[i];
                datas[i]['skuList'] = new Array();
                for (var j = 0; j < $scope.skuIdArr[$scope.goodsIdArr[i]].length; j++) {
                    datas[i]['skuList'][j] = {};
                    datas[i]['skuList'][j]['saleStatus'] = $scope.check1[$scope.goodsIdArr[i]] ? 1 : 0;
                    datas[i]['skuList'][j]['takeOut'] = $scope.check2[$scope.goodsIdArr[i]] ? 1 : 0;
                    datas[i]['skuList'][j]['useIntegral'] = $scope.check3[$scope.goodsIdArr[i]] ? 1 : 0;
                    datas[i]['skuList'][j]['salePrice'] = $scope.salePrice[$scope.skuIdArr[$scope.goodsIdArr[i]][j][0]];
                    datas[i]['skuList'][j]['takeOutPrice'] = $scope.takeOutPrice[$scope.skuIdArr[$scope.goodsIdArr[i]][j][0]];
                    datas[i]['skuList'][j]['integral'] = $scope.integral[$scope.skuIdArr[$scope.goodsIdArr[i]][j][0]];
                    datas[i]['skuList'][j]['modifyId'] = userId;
                    datas[i]['skuList'][j]['skuId'] = $scope.skuIdArr[$scope.goodsIdArr[i]][j][0];
                }
            }
            var data = {
                'type': 'updateCtl',
                'datas': {'adjustList': datas}
            };
            var postData = JSON.stringify(data);
            var page = '<?php echo $page?>';
            var CatId = '<?php echo $CatId?>';
            var StoType = '<?php echo $StoType?>';
            var quick = '<?php echo $quick?>';
            $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('恭喜你，修改成功！', {icon: 6, time: 1500});
                    parent.location.href='listGoods.php?v=1.0&page=' + page + '&CatId=' + CatId + '&StoType=' + StoType + '&quick=' + quick;
                } else {
                    layer.msg('请填写完整！', {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetModal = function () {
            $scope.salePrice = [];
            $scope.takeOutPrice = [];
            $scope.integral = [];
        }
    });
</script>
</body>
</html>