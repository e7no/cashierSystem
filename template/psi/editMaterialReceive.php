<?php
include('../../Common/check.php');
session_start();
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
if (isset($_SESSION['cats'])) {
    $cats = implode(',', $_SESSION['cats']);
} else {
    $cats = '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-领用原料编辑</title>
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
                <h5>领用原料编辑</h5>
                <div class="ibox-tools">
                    <a class="btn-red del-btn" ng-click="delModal()">删除</a>
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
                                <th width="3%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
                                <th>原料编码</th>
                                <th width="15%">原料名称</th>
                                <th width="12%">原料类别</th>
                                <th width="6%">单位</th>
                                <th width="6%">规格</th>
                                <th width="8%">原料标准价</th>
                                <th width="8%">原料单价</th>
                                <th width="8%">领用数量</th>
                                <th width="10%">领用金额</th>
                                <th width="10%">当前库存</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c" ng-repeat="item in list">
                                <td><input type="checkbox" ng-model="$parent.conf[item.id]" ng-change="selectOne(item.id)"/></td>
                                <td>{{item.code}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.typeName}}</td>
                                <td>{{item.unit}}</td>
                                <td>{{item.spec}}</td>
                                <td>{{item.standardPrice}}</td>
                                <td>{{item.avgPrice}}</td>
                                <td><input type="text" class="egs-text" placeholder="领用数量" ng-model="$parent.num[$index]"/></td>
                                <td>{{(item.avgPrice*$parent.num[$index]?item.avgPrice*$parent.num[$index]:0)|number:2}}</td>
                                <td ng-if="item.stock==''||item.stock==0">0</td>
                                <td ng-if="item.stock!=''||item.stock!=0">{{item.stock}}</td>
                            </tr>
                            <tr class="text-c">
                                <td><input type="checkbox"/></td>
                                <td colspan="2" class="psi-select" ng-click="addGoodModal()">
                                    请选择领用原料...
                                </td>
                                <td></td>
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
                    <!--
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">领用类型</label>
                            <div class="layui-input-inline" style="width: 132px;">
                                <select class="layui-input">
                                    <option value="0">请选择...</option>
                                    <option value="1">生产领用</option>
                                    <option value="2">预订出库</option>
                                    <option value="3">采购退回</option>
                                    <option value="4">其他领用</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">采购员</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" class="layui-input" placeholder="请输入采购员姓名">
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">领用时间</label>
                            <div class="layui-input-inline" style="width: 152px;">
                                <input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择时间" onchange=""
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'%y-%M-%d\'}'})">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">领用员</label>
                            <div class="layui-input-inline" style="width: 120px;">
                                <input type="text" class="layui-input" placeholder="请输入领用员姓名" ng-model="name">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label">备注</label>
                        <div class="layui-input-inline" style="width: 380px;">
                            <input type="text" class="layui-input" placeholder="请输入原料领用备注" ng-model="note">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="领用" disabled="disabled"
                               ng-show="!readDrivingUnable" ng-click="getModal()">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="领用" ng-show="readDrivingUnable"
                               ng-click="getModal()">
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
        var g = '<?php echo $cats;?>';
        if (g != '') {
            $scope.cats = g.split(",");
        } else {
            $scope.cats = [];
        }
        $scope.list = [];
        $scope.conf = [];
        $scope.num = [];
        $scope.catsnew = [];
        $scope.allcatnew = [];
        var reSearch = function () {
            var postData = {
                type: 'goods',
            };
            $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
                angular.forEach(result.data.list, function (item) {
                    angular.forEach($scope.cats, function (cats) {
                        if (item.id == cats) {
                            $scope.list.push(item);
                        }
                    })
                })
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetModal = function () {
            $scope.cats = [];
            $scope.list = [];
            $scope.createDateStart = '';
            $scope.name = '';
            $scope.note = '';
            return reSearch();
        }
        $scope.selectAll = function () {
            if ($scope.select_all) {
                angular.forEach($scope.list, function (item) {
                    $scope.conf[item.id] = true;
                    $scope.catsnew.push(item.id);
                })
            } else {
                angular.forEach($scope.list, function (item) {
                    $scope.conf[item.id] = false;
                    removeByValue($scope.catsnew, item.id);
                })
            }
        };
        $scope.selectOne = function () {
            angular.forEach($scope.list, function (item) {
                var index = $scope.catsnew.indexOf(item.id);
                if ($scope.conf[item.id] && index === -1) {
                    $scope.catsnew.push(item.id);
                } else if (!$scope.conf[item.id] && index !== -1) {
                    removeByValue($scope.catsnew, item.id);
                }
            })
            if ($scope.catsnew.length == $scope.list.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.addGoodModal = function () {
            layer.open({
                type: 2,
                title: '添加原料',
                area: ['70%', '84%'],
                anim: '0',
                resize: false,
                move: false,
                shadeClose: true,
                content: 'addMaterialReceive.php',
            });
        }
        $scope.delModal = function () {
            layer.alert('亲，您确定删除选中的原料吗？', {icon: 5, title: "删除", resize: false,}, function (index) {
                var c = [];
                for (var i = 0; i < $scope.cats.length; i++) {
                    if (!contains($scope.catsnew, $scope.cats[i])) {
                        c.push($scope.cats[i]);
                    }
                }
                $scope.cats = c;
                var postData = {
                    type: 'session',
                    cats: c
                };
                $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
                    if (result.data.success) {
                        $scope.list = [];
                        $scope.select_all = false;
                        layer.msg('删除成功！', {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg('服务端请求错误！', {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
        $scope.getModal = function () {
            $scope.readDrivingUnable = false;
            var num = $scope.list.length;
            if (num == 0) {
                layer.msg('请添加原料再进行领用！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            var detailList = new Array();
            for (var i = 0; i < num; i++) {
                detailList[i] = {};
                detailList[i]['matId'] = $scope.list[i].id;
                if ($scope.list[i].id != '') {
                	if ($scope.num[i] == '' || angular.isUndefined($scope.num[i])) {
                        layer.msg('请填写领用数量！', {time: 3000});
                        $scope.readDrivingUnable = true;
                        return;
                    }else if (Number($scope.num[i]) == 0) {
                        layer.msg('填写领用数量必须大于 0！', {time: 3000});
                        $scope.readDrivingUnable = true;
                        return;
                    } else {
                        detailList[i]['outStock'] = $scope.num[i];
                    }
                }
            }
            if (angular.isUndefined($scope.createDateStart) || $scope.createDateStart == '') {
                layer.msg('请选择领用时间！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            if (angular.isUndefined($scope.name) || $scope.name == '') {
                layer.msg('请输入领用员姓名！', {time: 3000});
                $scope.readDrivingUnable = true;
                return;
            }
            var data = {
                'datas': {
                    'matOutStockDTO': {
                        'detailList': detailList,
                        'personName': $scope.name,
                        'outDate': $scope.createDateStart,
                        'note': $scope.note,
                        'stoId': '<?php echo $stoId;?>',
                        'createId': '<?php echo $userId;?>'
                    }
                }
            };
            var datas = JSON.stringify(data);
            var postData = {
                type: 'get',
                datas: datas,
            };
            $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    layer.msg('领用成功！', {time: 3000});
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
        function removeByValue(arr, val) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == val) {
                    arr.splice(i, 1);
                    break;
                }
            }
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

        Array.prototype.unique3 = function () {
            var res = [];
            var json = {};
            for (var i = 0; i < this.length; i++) {
                if (!json[this[i]]) {
                    res.push(this[i]);
                    json[this[i]] = 1;
                }
            }
            return res;
        }
    });
</script>
</body>
</html>