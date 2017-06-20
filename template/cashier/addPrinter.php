<?php
include('../../Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-添加打印机</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="wbox">
        <div class="wbox-content add-printer">
            <form class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>打印机名称</label>
                        <div class="layui-input-inline" style="width: 160px;">
                            <input type="text" ng-model="name" class="layui-input" placeholder="请输入打印机名称">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>打印机IP</label>
                        <div class="layui-input-inline" style="width: 160px;">
                            <input type="text" ng-model="ip" class="layui-input" placeholder="请输入打印机IP">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 10px;">
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>打印机类型</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" style="width: 160px;" ng-model="printertype" ng-change="selectType(printertype)">
                                <option value="">请选择打印机类型...</option>
                                <option value="1">本地打印机</option>
                                <option value="2">云打印机</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>设备型号</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" ng-model="printercat" style="width: 160px;">
                                <option value="">请选择设备型号...</option>
                                <option ng-value="x.id" ng-repeat="x in printList" ng-bind="x.name"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 10px;">
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>打印规格</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" ng-model="guige" style="width: 160px;">
                                <option value="">请选择打印规格...</option>
                                <option value="58">58</option>
                                <option value="80">80</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label"><b>*</b>打印场景</label>
                        <div class="layui-input-inline">
                            <select class="layui-select" ng-model="printScene" style="width: 160px;" ng-init="printScene='1'">
                                <option value="1">前台打印</option>
                                <option value="2">后厨打印</option>
                                <option value="3">水吧打印</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 10px;">
					<div class="layui-inline">
						<label class="layui-form-label">切单选项</label>
						<div class="will-inline">
							<label>
								<input type="checkbox" ng-model="allPrint" />
								全单
							</label>
							<label>
								<input type="checkbox" ng-model="partPrint" />
								切单
							</label>
						</div>
					</div>
				</div>
                <fieldset class="layui-elem-field">
                    <legend id="tmp">打印模板</legend>
                    <div class="layui-field-box">
                        <table class="layui-table" lay-skin="nob">
                            <colgroup>
                                <col width="150">
                                <col width="40">
                                <col width="60">
                                <col width="30">
                                <col>
                            </colgroup>
                            <tbody ng-repeat="item in list">
                            <tr class="text-l">
                                <td>{{item.name}}</td>
                                <td>打印</td>
                                <td><input type="text" class="layui-input" ng-model="$parent.arr[item.id]"></td>
                                <td>份</td>
                                <td><a class="zdy-btn" ng-click="addDefineModal()">自定义</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <div class="scope-goods" id="goods" ng-show="isShow">
                    <h2>选择商品</h2>
                    <div class="sg-content">
                        <div class="sg-category">
                            <ul ng-repeat="items in lists | unique:'catId'">
                                <li ng-if="items.catName!=''" ng-click='li_click(items.catId)' ng-class='{active: items.catId==active}'>
                                    <input type="checkbox" ng-model="$parent.conf[items.catId]" ng-click="selectAll(items.catId)"/>
                                    <span>{{items.catName}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="sg-list">
                            <ul>
                                <li ng-repeat="itemsg in lists | filter:{'catId':active}:true">
                                    <label>
                                        <input type="checkbox" ng-model="$parent.confchil[itemsg.goodsId]" ng-change="selectOne(itemsg.catId,itemsg.goodsId)"/>
                                        <span>{{itemsg.goodsName | limitTo:6}}</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 15px;">
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal add-hbtn" ng-click="saveModel()" value="保存"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置"/>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['common']);
    app.controller('listController', function ($scope, $http) {
        $scope.isShow = false;
        $scope.arr = [];
        $scope.tmpname = [];
        $scope.tmpid = [];
        $scope.tmpnum = [];
        $scope.isActive = false;
        $scope.checked = [];
        $scope.conf = [];
        $scope.confchil = [];
        $scope.childArr = [];
        var postData = {type: 'proList',};
        $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.lists = result.data.list;
            $scope.active = result.data.list[0].catId;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.changeClass = function () {
            $scope.isActive = !$scope.isActive
        }
        $scope.li_click = function (i) {
            $scope.active = i;
        }
        $scope.selectType = function (id) {
            var postData = {
                type: 'chooseCat',
                cid: id
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.printList=result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.selectAll = function (catId) {
            if ($scope.conf[catId]) {
                angular.forEach($scope.lists, function (item) {
                    if (item.catId == catId) {
                        $scope.confchil[item.goodsId] = true;
                        $scope.checked.push(item.goodsId);
                    }
                })
            } else {
                angular.forEach($scope.lists, function (item) {
                    if (item.catId == catId) {
                        $scope.confchil[item.goodsId] = false;
                        $scope.checked.splice($.inArray(item.goodsId, $scope.checked), 1);
                    }
                })
            }
        }
        $scope.selectOne = function (partentId, id) {
            var partentIdarr = [];
            var index = $scope.checked.indexOf(id);
            if ($scope.confchil[id] && index === -1) {
                $scope.checked.push(id);
            } else if (!$scope.confchil[id] && index !== -1) {
                $scope.checked.splice(index, 1);
            }
            angular.forEach($scope.lists, function (item) {
                if (item.catId == partentId) {
                    partentIdarr.push(item.goodsId);
                }
            })

            angular.forEach($scope.lists, function (item) {
                if ($scope.confchil[item.goodsId] == true && item.catId == partentId) {
                    $scope.childArr.unshift(item.goodsId);
                }
            })
            uniqueArray($scope.childArr);
            if (partentIdarr.length === $scope.childArr.length && partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
                $scope.childArr.shift();
                $scope.conf[partentId] = false;
            } else if (partentIdarr.sort().toString() == $scope.childArr.sort().toString()) {
                $scope.conf[partentId] = true;
                $scope.childArr = [];
            } else {
                $scope.childArr.shift();
                if (partentIdarr.length === $scope.childArr.length && partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
                    $scope.childArr.shift();
                    $scope.conf[partentId] = true;
                    $scope.childArr = [];
                } else {
                    $scope.conf[partentId] = false;
                }
            }
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
        var reSearch = function () {
            if ($scope.printScene == '2' || $scope.printScene == '3') {
                $scope.isShow = true;
            } else {
                $scope.isShow = false;
            }
            var postDatas = {
                type: 'printertemplate',
                id: $scope.printScene,
            };
            $http.post('../../Controller/cashier/viceScreenAction.php', postDatas).then(function (result) {  //正确请求成功时处理
                $scope.list = result.data;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.$watch('printScene + printertype', reSearch);
        $scope.addDefineModal = function () {//添加自定义模板
            layer.open({
                type: 2,
                title: '自定义模板',
                area: ['600px', '100%'],
                anim: '2',
                resize: false,
                move: false,
                shadeClose: true,
                offset: ['0', '0'],
                content: 'printTemplate.php',
            });
        }
        $scope.saveModel = function () {
            angular.forEach($scope.list, function (item) {
                if ($scope.arr[item.id] != "") {
                    $scope.tmpname.push(item.name);
                    $scope.tmpid.push(item.id);
                    $scope.tmpnum.push($scope.arr[item.id]);
                }
            })
            if($scope.partPrint==true){
            	$scope.partPrints = "1";
            }else{
            	$scope.partPrints = "0";
            }
            if($scope.allPrint==true){
            	$scope.allPrints = "1";
            }else{
            	$scope.allPrints = "0";
            }
            var postData = {
                type: 'addprinter',
                catId: $scope.printercat,
                name: $scope.name,
                ip: $scope.ip,
                guige: $scope.guige,
                allPrint: $scope.allPrints,
                partPrint: $scope.partPrints,
                printScene: $scope.printScene,
                nums: $scope.tmpnum,
                tmpname: $scope.tmpname,
                tmpid: $scope.tmpid,
                goodsList: $scope.checked.unique3()
            };
            if ($scope.printercat == '') {
                layer.msg('请选择设备型号', {time: 3000});
                return false;
            }
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    parent.location.reload();
                } else {
                    $scope.tmpnum = [];
                    $scope.tmpname = [];
                    $scope.tmpid = [];
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
    });
    angular.module('common', []).filter('unique', function () {
        return function (collection, keyname) {
            var output = [], keys = [];
            angular.forEach(collection, function (item) {
                var key = item[keyname];
                if (keys.indexOf(key) === -1) {
                    keys.push(key);
                    output.push(item);
                }
            });
            return output;
        }
    });
    function uniqueArray(data) {
        data = data || [];
        var a = {};
        for (var i = 0; i < data.length; i++) {
            var v = data[i];
            if (typeof(a[v]) == 'undefined') {
                a[v] = 1;
            }
        }
        ;
        data.length = 0;
        for (var i in a) {
            data[data.length] = i;
        }
        return data;
    }
</script>
</body>
</html>