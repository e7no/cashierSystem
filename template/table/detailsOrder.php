<?php
include('../../Common/check.php'); 
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-订单详情</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
	<script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
	<div class="wrapper" ng-controller="listController">
		<div class="content">
			<div class="wbox">
				<div class="wbox-content">
					<div class="popup-body">
						<p><span>单号：</span>{{dataMap.no}}</p>
						<p><span>时间：</span>{{dataMap.createDate}}</p>
						<p><span>会员卡号：</span>{{dataMap.cardNo ? dataMap.cardNo : "无"}}</p>
						<p><span>会员姓名：</span>{{dataMap.memName ? dataMap.memName : "匿名"}}</p>
						<p><span>会员手机：</span>{{dataMap.mobile ? dataMap.mobile : "无"}}</p>
						<p><span>订单类型：</span>
						<span ng-if="dataMap.orderType==1 || dataMap.orderType==4">扫码付订单</span>
						<span ng-if="dataMap.orderType==2">门店订单</span>
						<span ng-if="dataMap.orderType==3 || dataMap.orderType==5"">商城订单</span>
						</p>
						<p><span>消费门店：</span>{{dataMap.storeName}}</p>
						<ul>
							<li ng-repeat="item in dataMap.itemList" ng-cloak>
								<h5>{{item.goodsName}}</h5>
								<b>*{{item.quantity}}</b>
								<span>￥{{item.realSum ? item.realSum : 0}}</span>
								<!-- <div class="pb-sx">{{item.unit}}热&nbsp;大杯</div> -->
							</li>
						</ul>
						<p><span>合计：</span>￥{{dataMap.total ? dataMap.total : 0}}</p>
						<p><span>优惠金额：</span>￥{{dataMap.offSum ? dataMap.offSum : 0}}</p>
						<p><span>打包费：</span>￥{{dataMap.additionalFee ? dataMap.additionalFee : 0}}</p>
						<p><span>配送费：</span>￥{{dataMap.freightFee ? dataMap.freightFee : 0}}</p>
						<p><span>实付金额：</span>￥{{dataMap.realSum ? dataMap.realSum : 0}}</p>
						<p><span>收银员：</span>{{dataMap.cashierName ? dataMap.cashierName : "匿名"}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var postData = {
                type: 'details',
                ordId: '<?php echo $id;?>'
        };
        $http.post('../../Controller/table/orderSumTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.dataMap = result.data.dataMap;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
    });
</script>
</body>
</html>