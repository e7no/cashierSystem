<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$stoType = $_SESSION['stoType'];
$url = $config_host . '/service/sto/manage/stoList';
if($stoType==1){
	$datas=array('datas'=>array(
		'pid'=>$_SESSION['stoId']
	));
}else{
	$datas=array('datas'=>array(
		'stoId'=>$_SESSION['stoId']
	));
}
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-原料进销存</title>
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
                    <?php if ($stoType == 1) { ?>
                        <div class="layui-inline">
                            <label class="layui-form-label">门店</label>
                            <div class="layui-input-inline">
                                <select class="layui-input" ng-model="stoName" ng-init="stoName==''">
                                    <option value="">请选择...</option>
                                    <?php for ($i = 0; $i < $num; $i++) { ?>
                                        <option value="<?php echo $list[$i]['stoId']; ?>"><?php echo $list[$i]['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="layui-inline">
                        <label class="layui-form-label">时间</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" class="Wdate layui-input" ng-model="DateStart" id="logmin" placeholder="请选择日期" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" class="Wdate layui-input" ng-model="DateEnd" id="logmax" placeholder="请选择日期" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>原料进销存</h5>
                <div class="ibox-tools">
                    <a class="btn-green" id="excel">导出</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 2200px;">
                        <thead>
                        <tr class="text-c">
                            <th width="6%">时间</th>
                            <th width="8%">门店名称</th>
                            <th width="6%">原料类别</th>
                            <th width="6%">原料名称</th>
                            <th width="5%">期初库存</th>
                            <th width="5%">期初金额</th>
                            <th width="5%">入库数量</th>
                            <th width="5%">入库金额</th>
                            <th width="5%">领用数量</th>
                            <th width="5%">领用金额</th>
                            <th width="5%">报废数量</th>
                            <th width="5%">报废金额</th>
                            <th width="5%">盘点数量</th>
                            <th width="5%">盘点金额</th>
                            <th width="5%">盈亏数量</th>
                            <th width="5%">盈亏金额</th>
                            <th width="5%">期末数量</th>
                            <th width="5%">期末金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.balanceDate}}</td>
                            <td>{{item.stoName}}</td>
                            <td>{{item.typeName}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.preQty}}</td>
                            <td>{{item.preAmount}}</td>
                            <td>{{item.inQty}}</td>
                            <td>{{item.inAmount}}</td>
                            <td>{{item.outQty}}</td>
                            <td>{{item.outAmount}}</td>
                            <td>{{item.scrapQty}}</td>
                            <td>{{item.scrapAmount}}</td>
                            <td>{{item.invQty}}</td>
                            <td>{{item.invAmount}}</td>
                            <td>{{item.minusQty}}</td>
                            <td>{{item.minusAmount}}</td>
                            <td>{{item.qty}}</td>
                            <td>{{item.amount}}</td>
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
<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                stoName: $scope.stoName,
                DateStart: $scope.DateStart,
                DateEnd: $scope.DateEnd,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/materialPsitTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                if ($scope.total == 0) {
                    layer.msg('暂无数据', {time: 3000});
                } else {
                    layer.msg('服务端请求错误！', {time: 3000});
                }
            });
        }
        $scope.reSearch = reSearch;
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.resetSearch = function () {
            $scope.stoName = undefined;
            $scope.DateStart = undefined;
            $scope.DateEnd = undefined;
        }
        $('#excel').click(function () {
            var stoName = $scope.stoName ? $scope.stoName : '';
            var DateStart = $scope.DateStart ? $scope.DateStart : '';
            var DateEnd = $scope.DateEnd ? $scope.DateEnd : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/materialPsitTabelExcel.php?stoName=' + stoName + '&DateStart=' + DateStart + '&DateEnd=' + DateEnd;
        });
    });
</script>
</body>
</html>