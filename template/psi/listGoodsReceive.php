<?php
include('../../Common/check.php');
/* include_once('../../Common/function.php');
$url = $config_host . '/service/sto/manage/empList';
$stoId = $_SESSION["stoId"];
$datas = array('datas' => array(
		'pageNo' => 1,
		'pageSize' => 100,
		'stoId' => $stoId,
		'stoType'=>$stoType,
		'name' => "",
		'mobile' => "",
		'state' => '1'
));
$json = http($url, $datas, 1);
$list = $json['datas']['list']; */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-商品出库</title>
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
						<div class="layui-inline">
					    	<label class="layui-form-label">单据编码</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					        	<input type="text" ng-model="no" class="layui-input" placeholder="请输入单据编码">
					    	</div>
					    </div>
						<div class="layui-inline">
					    	<label class="layui-form-label">出库时间</label>
					    	<div class="layui-input-inline" style="width: 110px;">
					    		<input type="text" class="Wdate layui-input" ng-model="outDateStart" onchange="" id="logmin" placeholder="请选择..."  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 110px;">
					    		<input type="text" class="Wdate layui-input" ng-model="outDateEnd" onchange="" id="logmax" placeholder="请选择..." onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <!--
					    <div class="layui-inline">
					    	<label class="layui-form-label">出库类型</label>
					    	<div class="layui-input-inline">
					    		<select class="layui-input">
							        <option value="0">请选择...</option>
							        <option value="1">销售</option>
							        <option value="2">采购退回</option>
							        <option value="3">预订出库</option>
							        <option value="4">其他出库</option>
							    </select>
					    	</div>
						</div>
						-->
						<div class="layui-inline">
					    	<label class="layui-form-label">出库员</label>
					    	<div class="layui-input-inline">
					    		<!-- <select class="layui-input" ng-model="createId">
							        <option value="">请选择...</option>
							        <?php 
                                    foreach ($list as $info){
							    	?>
							        <option value="<?php echo $info["empId"]?>"><?php echo $info["empName"]?></option>
							        <?php }?>
							    </select> -->
							    <input type="text" class="layui-input" placeholder="请输入出库员姓名" ng-model="createId">
					    	</div>
						</div>
					    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>商品出库单列表</h5>
					<div class="ibox-tools">
						<a class="btn-blue news-btn" ng-click="AddOrder()">新增单据</a>
						<a class="btn-green" ng-click="reExcel()">导出</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="con-table">
						<table class="layui-table" style="min-width: 1200px;">
							<thead>
								<tr class="text-c">
									<th width="15%">单据编码</th>
									<th width="10%">出库总量</th>
									<th width="12%">出库总额</th>
									<th width="13%">出库时间</th>		
									<th class="text-l">备注</th>
									<th width="8%">出库员</th>
									<th width="8%">操作员</th>
									<th width="8%">详情</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="item in list" ng-cloak>
									<td>{{item.no}}</td>
									<td>{{item.quantity}}</td>
									<td>{{item.amount|number:2}}</td>
									<td>{{item.outDate}}</td>
									<td class="text-l">{{item.note}}</td>
									<td>{{item.personName}}</td>
									<td>{{item.createName}}</td>
									<td><a class="btn-blue check-btn" ng-click="detail(item.id)">查看</a></td>
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
	<script type="text/javascript" src="../../js/layui.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
    	$scope.inStock = 0;
    	$scope.amount = 0;
        $scope.total = 0;
        var reSearch = function () {
            var postData = {
                type: 'list',
                no: $scope.no,
                createId: $scope.createId,
                outDateStart: $scope.outDateStart ? $scope.outDateStart : undefined,
                outDateEnd: $scope.outDateEnd ?　$scope.outDateEnd : undefined,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/psi/listGoodsReceiveAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.Detail = result.data.list[0].detailList;
                $scope.createDateText = result.data.list[0].detailList[0].createDateText;
                var i = 0;
                angular.forEach($scope.Detail, function (item) {
                	$scope.outStock = $scope.inStock+$scope.Detail[i].outStock;
                    $scope.amount = $scope.amount+($scope.Detail[i].outPrice*$scope.Detail[i].outStock);
                    i++;
                })
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
        $scope.AddOrder=function(){
        	layer.open({
        		type: 2,
        		title: '出库商品编辑',
        		area : ['100%' , '100%'],
        		anim: '0',
        		resize: false,
        		move: false,
        		shadeClose: true,
        		offset: ['0', '0'],
        		content: 'editGoodsReceive.php',
        	});
        }
        $scope.detail=function(id){
        	layer.open({
    			type: 2,
    			title: '详情',
    			area : ['100%' , '100%'],
    			anim: '0',
    			resize: false,
    			move: false,
    			shadeClose: true,
    			offset: ['0', '0'],
    			content: 'detailsGoodsReceive.php?id='+id,
    		});
        }
        $scope.resetSearch = function (){
        	$scope.no = undefined;
        	$scope.outDateStart = undefined;
        	$scope.outDateEnd = undefined;
        	$scope.createId = undefined;
        }
        $scope.reExcel = function (){
        	var datas = new Array();
        	datas = {};
            datas["type"] = 'outexcel';
            datas["createId"] = $scope.createId,
            datas["outDateStart"] = $scope.outDateStart ? $scope.outDateStart : null,
            datas["outDateEnd"] = $scope.outDateEnd ? $scope.outDateEnd : null,
            datas["no"] = $scope.no,
            datas["currentPage"] = 1,
            datas["itemsPerPage"] = 10000,
            postData = angular.toJson(datas);
            window.location.href="../../Controller/psi/listGoodsStorageAction.php?postData="+postData;
        }
    });
</script>
</body>
</html>