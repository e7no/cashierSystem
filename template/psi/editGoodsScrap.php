<?php
include('../../Common/check.php');
session_start();
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
if (isset($_SESSION['checked'])) {
    $checked = implode(',', $_SESSION['checked']);
} else {
    $checked = '';
}
if (isset($_SESSION['skuId'])) {
    $skuId = implode(',', $_SESSION['skuId']);
} else {
    $skuId = '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-报废商品编辑</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController" ng-init="reSearch()">
    <div class="content">
        <div class="wbox">
            <div class="wbox-title">
                <h5>报废商品编辑</h5>
                <div class="ibox-tools">
                    <a class="btn-red del-btn" href="javascript:;" ng-click="delModal()">删除</a>
                    <!--                    <a class="btn-blue put-btn" href="javascript:;" ng-click="deleteModal()">报废</a>-->
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <form class="layui-form layui-form-pane psi-form">
                    <div class="con-table">
                        <table class="layui-table" style="min-width: 1000px;">
                            <thead>
                            <tr class="text-c">
                                <th><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                                <th>商品编码</th>
                                <th width="16%">商品名称</th>
                                <th width="12%">商品类别</th>
                                <th width="8%">单位</th>
                                <th width="10%">规格</th>
                                <th width="8%">商品进价</th>
                                <th width="10%">报废数量</th>
                                <th width="10%">报废金额</th>
                                <th width="10%">当前库存</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c" ng-repeat="item in list">
                                <td><input type="checkbox" ng-model="$parent.conf[item.goodsId+item.skuId]" ng-change="selectOne(item.skuId)"/></td>
                                <td>{{item.no}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.catName}}</td>
                                <td>{{item.unit}}</td>
                                <td>{{item.skuName}}</td>
                                <td>{{item.salePrice}}</td>
                                <td><input type="text" class="egs-text" placeholder="报废数量" ng-model="$parent.num[$index]"/></td>
                                <td>{{item.salePrice*$parent.num[$index]?(item.salePrice*$parent.num[$index]|number:2):'0.00'}}</td>
                                <td>{{item.storeNum}}</td>
                            </tr>
                            <tr class="text-c">
                                <td></td>
                                <td colspan="2" class="psi-select" ng-click="addGoodModal()">
                                    请选择报废商品...
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">报废时间</label>
                            <div class="layui-input-inline" style="width: 152px;">
                                <input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择时间" onchange=""
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'%y-%M-%d\'}'})">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">报废员</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" class="layui-input" ng-model="name" placeholder="请输入报废员姓名">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label">备注</label>
                        <div class="layui-input-inline" style="width: 380px;">
                            <input type="text" class="layui-input" ng-model="note" placeholder="请输入商品报废备注">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="报废" disabled="disabled" ng-show="!readDrivingUnable" ng-click="deleteModal()">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="报废" ng-show="readDrivingUnable" ng-click="deleteModal()">
                        <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModal()"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        $scope.readDrivingUnable = true;
        var c = '<?php echo $checked;?>'
        var s = '<?php echo $skuId;?>'
        $scope.checked = c.split(",");
        $scope.skuId = s.split(",");
        $scope.list = [];
        $scope.conf = [];
        $scope.num = [];
        $scope.checkednew = [];
        $scope.skuIdnew = [];
        var reSearch = function () {
            var postData = {
                type: 'goods',
            };
            $http.post('../../Controller/psi/listGoodsScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
                angular.forEach(result.data.list, function (item) {
                    if (item.skuId != '') {
                        angular.forEach($scope.skuId, function (skuId) {
                            if (item.skuId == skuId) {
                                $scope.list.push(item);
                            }
                        })
                    } else {
                        angular.forEach($scope.checked, function (checked) {
                            if (item.goodsId == checked && item.skuId == '') {
                                $scope.list.push(item);
                            }
                        })
                    }
                })
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetModal = function () {
            $scope.checked = [];
            $scope.skuId = [];
            $scope.list = [];
            $scope.createDateStart = '';
            $scope.name = '';
            $scope.note = '';
            return reSearch();
        }
        $scope.selectAll = function () {
            if ($scope.select_all) {
                angular.forEach($scope.list, function (item) {
                    $scope.conf[item.goodsId + item.skuId] = true;
                    if (item.skuId == '') {
                        $scope.checkednew.push(item.goodsId);
                    } else {
                        $scope.skuIdnew.push(item.skuId);
                    }
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    $scope.conf[item.goodsId + item.skuId] = false;
                    $scope.checkednew = [];
                    $scope.skuIdnew = [];
                })
            }
        };
        $scope.selectOne = function (id) {
            if (id == '') {
                angular.forEach($scope.list, function (item) {
                    var index = $scope.checkednew.indexOf(item.goodsId);
                    if ($scope.conf[item.goodsId] && index === -1) {
                        $scope.checkednew.push(item.goodsId);
                    } else if (!$scope.conf[item.goodsId] && index !== -1) {
                        $scope.checkednew.splice(index, 1);
                    }
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    var index = $scope.skuIdnew.indexOf(item.skuId);
                    if ($scope.conf[item.goodsId + item.skuId] && index === -1) {
                        $scope.skuIdnew.push(item.skuId);
                    } else if (!$scope.conf[item.goodsId + item.skuId] && index !== -1) {
                        $scope.skuIdnew.splice(index, 1);
                    }
                })
            }
        }
        $scope.addGoodModal = function () {
            layer.open({
                type: 2,
                title: '添加商品',
                area: ['70%', '84%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                content: 'addGoodsScrap.php',
            });
        }
        $scope.delModal = function () {
            var c = [];
            var s = [];
            for (var i = 0; i < $scope.checked.length; i++) {
                if (!contains($scope.checkednew, $scope.checked[i])) {
                    c.push($scope.checked[i]);
                }
            }
            for (var i = 0; i < $scope.skuId.length; i++) {
                if (!contains($scope.skuIdnew, $scope.skuId[i])) {
                    s.push($scope.skuId[i]);
                }
            }
            $scope.checked = c;
            $scope.skuId = s;
            var postData = {
                type: 'session',
                checked: c,
                skuId: s,
            };
            $http.post('../../Controller/psi/listGoodsScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    $scope.list = [];
                    layer.msg('删除成功！',{icon: 6,time:1000});
                    return reSearch();
                } else {
                    layer.msg('服务端请求错误！', {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.deleteModal = function () {
            $scope.readDrivingUnable = false;
            var num = $scope.list.length;
            if (num == 0) {
                layer.msg('请添加报废商品再进行报废！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            var detailList = new Array();
            for (var i = 0; i < num; i++) {
                detailList[i] = {};
                if ($scope.list[i].skuId == '') {
                    detailList[i]['goodsId'] = $scope.list[i].goodsId;
                    if($scope.list[i].goodsId!=''){
                        if ($scope.num[i] == '' || angular.isUndefined($scope.num[i])) {
                            layer.msg('请填写报废数量！', {time: 3000});
                            $scope.readDrivingUnable = true;
                            return;
                        }else if (Number($scope.num[i]) == 0) {
                            layer.msg('填写报废数量必须大于 0！', {time: 3000});
                            $scope.readDrivingUnable = true;
                            return;
                        } else {
                            detailList[i]['scrapStock'] = $scope.num[i];
                        }
                    }
                } else {
                    detailList[i]['goodsId'] = $scope.list[i].goodsId;
                    if($scope.list[i].goodsId!=''){
                        if ($scope.num[i] == '' || angular.isUndefined($scope.num[i])) {
                            layer.msg('请填写报废数量！', {time: 3000});
                            $scope.readDrivingUnable = true;
                            return;
                        }else if (Number($scope.num[i]) == 0) {
                            layer.msg('填写报废数量必须大于 0！', {time: 3000});
                            $scope.readDrivingUnable = true;
                            return;
                        } else {
                            detailList[i]['scrapStock'] = $scope.num[i];
                        }
                    }
                    detailList[i]['skuId'] = $scope.list[i].skuId;
                }
            }
            if (angular.isUndefined($scope.createDateStart) || $scope.createDateStart == '') {
                layer.msg('请选择报废时间！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            if (angular.isUndefined($scope.name) || $scope.name == '') {
                layer.msg('请填写报废员姓名！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            var data = {
                'datas': {
                    'goodsScrapStockDTO': {
                        'detailList': detailList,
                        'personName': $scope.name,
                        'scrapDate': $scope.createDateStart,
                        'note': $scope.note,
                        'stoId': '<?php echo $stoId;?>',
                        'createId': '<?php echo $userId;?>'
                    }
                }
            };
            var datas = JSON.stringify(data);
            var postData = {
                type: 'addDelete',
                datas: datas,
            };
            $http.post('../../Controller/psi/listGoodsScrapAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg('报废成功！', {time: 3000});
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.location.reload();
                } else {
                    $scope.readDrivingUnable = true;
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        function contains(arr, obj) {
            var i = arr.length;
            while (i--) {
                if (arr[i] === obj) {
                    return true;
                }
            }
            return false;
        }
    });
</script>
</body>
</html>