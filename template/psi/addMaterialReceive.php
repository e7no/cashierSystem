<?php
include('../../Common/check.php');
session_start();
if (isset($_SESSION['cats'])) {
    $cats = implode(',', array_filter($_SESSION['cats']));
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
    <title>汇汇生活商家后台-原料领用-选择原料</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper ags-wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-content">
                <div class="ags-left">
                    <h2>原料分类</h2>
                    <ul class="ags-category">
                        <li ng-repeat="itemCat in cat" ng-click="li_click(itemCat.id)"><a href="">{{itemCat.typeName}}</a></li>
                    </ul>
                </div>
                <div class="con-table ags-right">
                    <table class="layui-table" style="min-width: 600px;">
                        <thead>
                        <tr class="text-c">
                            <th><input type="checkbox" ng-model="select_all" ng-click="selectAll(selAllId)"/></th>
                            <th>原料编码</th>
                            <th width="22%">原料名称</th>
                            <th width="18%">规格</th>
                            <th width="10%">单位</th>
                            <th width="18%">当前库存</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in goods">
                            <td><input type="checkbox" ng-model="$parent.conf[item.id]" ng-change="selectOne(item.id)"/></td>
                            <td>{{item.code}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.spec}}</td>
                            <td>{{item.unit}}</td>
                            <td>{{item.stock}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" value="添加" ng-click="addGood()">
                        <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetaddGood()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var g = '<?php echo $cats;?>';
        if (g != '') {
            $scope.cats = g.split(",");
        } else {
            $scope.cats = [];
        }
        $scope.conf = [];
        $scope.check = [];
        $scope.allcat = [];
        var postData = {
            type: 'cat',
        };
        $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.cat = result.data.list;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.li_click = function (i) {
            $scope.check = [];
            $scope.selAllId = i;
            if (contains($scope.allcat, i)) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
            var postData = {
                type: 'goods',
                catId: i,
            };
            $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.goods = result.data.list;
                angular.forEach(result.data.list, function (item) {
                    if ($scope.goods[0] != '') {
                        angular.forEach($scope.cats, function (items) {
                            if (item.id == items) {
                                $scope.conf[item.id] = true;
                            }
                        })
                    }
                })
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.selectAll = function (id) {
            if ($scope.select_all) {
                $scope.allcat.push(id);
                angular.forEach($scope.goods, function (item) {
                    if (item.typeId == id) {
                        $scope.conf[item.id] = true;
                        $scope.cats.push(item.id);
                    }
                })
            } else {
                removeByValue($scope.allcat, id);
                angular.forEach($scope.goods, function (item) {
                    if (item.typeId == id) {
                        $scope.conf[item.id] = false;
                        removeByValue($scope.cats, item.id);
                    }
                })
            }
        };
        $scope.selectOne = function () {
            angular.forEach($scope.goods, function (item) {
                var index = $scope.cats.indexOf(item.id);
                if ($scope.conf[item.id] && index === -1) {
                    $scope.cats.push(item.id);
                    $scope.check.push(item.id);
                } else if (!$scope.conf[item.id] && index !== -1) {
                    $scope.cats.splice(index, 1);
                    removeByValue($scope.check, item.id);
                }
            })
            if ($scope.check.length == $scope.goods.length) {
                $scope.select_all = true;
            } else {
                $scope.select_all = false;
            }
        }
        $scope.addGood = function () {
            var postData = {
                type: 'session',
                cats: $scope.cats.unique3(),
            };
            $http.post('../../Controller/psi/listMaterialReceialAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.location.reload();
                } else {
                    layer.msg('服务端请求错误！', {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetaddGood = function () {
            angular.forEach($scope.goods, function (item) {
                $scope.conf[item.id] = false;
                $scope.select_all = false;
                $scope.cats = [];
            })
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