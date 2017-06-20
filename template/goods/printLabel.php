<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
if ($id == '') {
    echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新打印！\',{icon: 5,time:2000});</script>';
    exit;
}
$url = $config_host . '/service/gds/manage/goods/getLable/' . $id;
$json = http($url, '', 1);
$str = $json['datas']['skuList'];
$num = count($str);
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
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController" ng-init="reSearch()">
    <div class="wbox">
        <div class="wbox-content">
            <fieldset class="layui-elem-field">
                <legend>标签预览</legend>
                <div class="layui-field-box">
                    <div class="preview-template">
                        <h2>{{name}}</h2>
                        <div class="preview-box1">价格：￥{{salePrice}}</div>
                        <div class="preview-box1">生产日期：{{createDate}}</div>
                        <div class="preview-box1">保质期：{{bzq}}</div>
                        <div class="preview-box1">门店电话：{{tel}}</div>
                        <div class="preview-box1">地址：{{address}}</div>
                    </div>
            </fieldset>
            <div class="layui-inline" ng-hide="unitHide">
                <label class="layui-form-label">规格</label>
                <div class="layui-input-inline">
                    <select class="layui-select" style="width: 150px;" id="uName" ng-model="ngChange" ng-change="change()"
                            ng-init="ngChange='<?php echo $str[0][name]; ?>'">
                        <?php for ($i = 0; $i < $num; $i++) { ?>
                            <option value="<?php echo $str[$i]['name']; ?>"><?php echo $str[$i]['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <a class="layui-btn layui-btn-small btn-blue" ng-click="printModal();" style="margin-left: 20px;">打印</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        $scope.unitHide = false;
        var reSearch = function () {
            var uName = $('#uName').val();
            var postData = {
                id: '<?php echo $id;?>'
            };
            $http.post('../../Controller/goods/printAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.skuList.length == 0) {
                    $scope.unitHide = true;
                    if(result.data.lable.salePrice==''){
                        $scope.salePrice='0.00';
                    }else{
                        $scope.salePrice = result.data.lable.salePrice.toFixed(2);
                    }
                } else {
                    angular.forEach(result.data.skuList, function (item) {
                        if (item.name == uName) {
                            $scope.unitHide = false;
                            $scope.salePrice = (item.salePrice).toFixed(2) + '(' + item.name + ')';
                        }
                    })
                }
                $scope.name = result.data.lable.name;
                $scope.bzq = result.data.lable.bzq;
                $scope.tel = result.data.lable.tel;
                $scope.address = result.data.lable.address;
                $scope.createDate = (result.data.lable.createDate).substr(0, 16);
            }).catch(function () {
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.change = reSearch;
        $scope.printModal = function () {
            var oPop = window.open('', "_blank");
            var str = '<!DOCTYPE html>'
            str += '<html>'
            str += '<head>'
            str += '<meta charset="utf-8">'
            str += '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
            str += '<style>';
            str += 'body,div,ul,li,h2 {padding: 0;margin: 0;list-style: none;font-family: Microsoft YaHei;}div {width: 146px;height: 104px;padding: 2px 3px;margin-left:9px;verflow: hidden;s}h2 {width: 100%;padding-bottom:2px;line-height: 14px;text-align: center;font-size: 13px;font-weight: 400;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;}li {line-height: 14px;font-size: 12px;}';
            str += '</style>';
            str += '</head>'
            str += '<body>'
            str += '<div><h2>' + $scope.name + '</h2><ul><li>价格:￥&nbsp;' + $scope.salePrice + '</li><li>日期:&nbsp;' + $scope.createDate + '</li><li>保质期:&nbsp;' + $scope.bzq + '</li> <li>电话:&nbsp;' + $scope.tel + '</li>	<li>地址:&nbsp;'+$scope.address+'</li></ul></div>';
            str += '</body>'
            str += '</html>'
            oPop.document.write(str);
            oPop.document.close();
            oPop.focus();
            oPop.print();
            oPop.close();
        }
    });
</script>
</body>
</html>
