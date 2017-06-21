<?php
include('../../Common/check.php'); 
include_once('../../Common/function.php');
$url = $config_host . '/service/sto/manage/stoList';
if($_SESSION['stoType']==1){
	$datas=array('datas'=>array(
		'pid'=>$_SESSION['stoId']
	));
}else{
	$datas=array('datas'=>array(
		'stoId'=>$_SESSION['stoId']
	));
}
$json = http($url,$datas,1);
$store=$json['datas']['list'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-门店月结报表</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
	<script src="../../js/angular.min.js"></script>
    <script src="../../js/tmpagination/tm.pagination.js"></script>
</head>
<body ng-app="myApp">
	<div class="wrapper" ng-controller="listController">
		<div class="content">
			<div class="wboxform">
				<form class="layui-form">
					<div class="layui-form-item">
						<?php if ($_SESSION['stoType'] == 1) { ?>
						<div class="layui-inline">
					    	<label class="layui-form-label">门店</label>
					    	<div class="layui-input-inline">
							    <select class="layui-input" ng-model="stoId">
							    	<option value="">请选择...</option>
                                    <?php 
                                    foreach ($store as $info){
							    	?>
                                    <option value="<?php echo $info["stoId"];?>"><?php echo $info["name"];?></option>
                                    <?php }?>
                                </select>
					    	</div>
					   </div>
					   <?php }?>
					    <div class="layui-inline">
					    	<label class="layui-form-label">月份</label>
					    	<div class="layui-input-inline" style="width: 100px;">
					    		<input type="text" class="Wdate layui-input" id="logmin" ng-model="logmin" placeholder="请选择月份" onfocus="WdatePicker({dateFmt:'yyyy-MM',maxDate:'%y-%M'})">
					    	</div>
					    </div>
					    <button class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()">查询</button>
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>门店月结报表</h5>
					<div class="ibox-tools">
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table  class="layui-table" style="min-width: 1500px;">
							<thead>
								<tr class="text-c">
									<th width="6%">月份</th>
									<th class="text-l">门店名称</th>
									<th width="10%">原材料入库总金额</th>
									<th width="10%">销售总金额</th>
									<th width="9%">其他收支</th>
									<th width="8%">门店租金</th>
									<th width="9%">员工工资</th>
									<th width="7%">物业费</th>
									<th width="7%">电费</th>
									<th width="7%">水费</th>
									<th width="9%">门店纯利润</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list">
									<td>{{item.month}}</td>
									<td class="text-l">{{item.stoName}}</td>
									<td>{{item.matAmt}}</td>
									<td>{{item.saleAmt}}</td>
									<td class="c-red">-{{item.otherAmt}}</td>
									<td class="c-red">-{{item.rentAmt}}</td>
									<td class="c-red">-{{item.salaryAmt}}</td>
									<td class="c-red">-{{item.propAmt}}</td>
									<td class="c-red">-{{item.elecAmt}}</td>
									<td class="c-red">-{{item.waterAmt}}</td>
									<td class="c-red">-{{item.profitAmt}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<tm-pagination conf="paginationConf"></tm-pagination>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
    	$scope.total = 0;
        var reSearch = function () {
            var postData = {
                type: 'list',
                stoId: $scope.stoId ? $scope.stoId : "",
                logmin: $scope.logmin ? $scope.logmin : "",
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/table/monthlyStatementTabelAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
            	if($scope.total==0){
                	layer.msg('暂无数据', {time: 3000});
                }else{
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
        $scope.resetSearch = function (){
            $scope.stoId = "";
            $scope.logmin = "";
        }
        $scope.reExcel = function (){
            var stoId = $scope.stoId ? $scope.stoId : "";
            var logmin = $scope.logmin ? $scope.logmin : "";
            window.location.href="../../Controller/table/monthlyStatementTabelAction.php?stoId="+stoId+"&logmin="+logmin+"&type=excel";
        }
    });
</script>
</body>
</html>