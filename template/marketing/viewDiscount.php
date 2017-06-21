<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
if ($id == '') {
    echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新查询！\',{icon: 5,time:2000});</script>';
    exit;
} else {
    $url = $config_host . '/service/sto/discount/getById/'.$id;
    $json = http($url, '', 1);
    $list = $json['datas']['discountVO'];
    $product = $json['datas']['goodsList'];
    if(!empty($product)){
        $proNum = count($product);
        for ($i = 0; $i < $proNum; $i++) {
            $catIds[] = $product[$i]['catId'];
        }
        $catId = array_unique($catIds);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-查看</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper discount-wrap" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-content view-discount">
                <div class="vd-info">
                    <p>折扣名称：{{list.name}}</p>
                    <p ng-if="list.type==1">折扣方式：全单打折</p>
                    <p ng-if="list.type==2">折扣方式：特定商品打折</p>
                    <p ng-if="list.type==3">折扣方式：第二件商品打折</p>
                    <p>折扣百分比：{{list.discount*100|number:0}}%</p>
                </div>
                <div class="list-zkxm">
                    <h2>适用范围</h2>
                    <div class="lz-content">
                        <div class="lz-left">
                            <ul ng-repeat="item in detail | unique:'catId'">
                                <li ng-click="li_click(item.catId)" ng-class='{active: item.catId==active}'>{{item.catName}}</li>
                            </ul>
                        </div>
                        <div class="lz-right">
                            <ul>
                                <li ng-repeat="items in detail | filter:{'catId':active}:true">{{items.goodsName |limitTo:7}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/layui.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['common']);
    app.controller('listController', function ($scope, $http) {
        $scope.isActive = false;
        var postData = {type: 'oneList', oneId: '<?php echo $id;?>'};
        $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.list = result.data.list;
            if(result.data.detail!=''){
                $scope.detail = result.data.detail;
                $scope.active = result.data.detail[0].catId;
            }
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.li_click = function (i) {$scope.active = i;}
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
</script>
</body>
</html>