<?php
include('../../Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-其他收支</title>
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
					    	<label class="layui-form-label">单据编号</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					        	<input type="text" class="layui-input" ng-model="IncomeNum" placeholder="请输入查找的单据编号">
					    	</div>
					    </div>
					    <div class="layui-inline">
					    	<label class="layui-form-label">类型</label>
					    	<div class="layui-input-inline">
					    		<select class="layui-input" ng-model="IncomeType">
							        <option value="">请选择...</option>
							        <option value="1">收入</option>
							        <option value="-1">支出</option>
							    </select>
					    	</div>
						</div>
						<div class="layui-inline">
					    	<label class="layui-form-label">入库时间</label>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" onchange="" ng-model="Incomelogmin" id="logmin" placeholder="请选择开始时间"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 156px;">
					    		<input type="text" class="Wdate layui-input" onchange="" ng-model="Incomelogmax" id="logmax" placeholder="请选择结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
						<div class="layui-inline">
					    	<label class="layui-form-label">操作员</label>
					    	<div class="layui-input-inline">
							    <input type="text" class="layui-input" ng-model="IncomeStaff" placeholder="请输入操作员">
					    	</div>
						</div>
					    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>其他收支</h5>
					<div class="ibox-tools">
						<a class="btn-blue news-btn" ng-click="AddFiles()">新增单据</a>
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="cprk-box">
						<span id="Outcome">支出总金额：{{totalOutcome}}元</span>
						<span id="Income">收入总金额：{{totalIncome}}元</span>
					</div>
					<div class="layui-tab will-tab">
						<div class="wt-left">
							<h2 class="wt-title">单据编码</h2>
							<ul class="layui-tab-title" ng-repeat="item in list" ng-cloak>
								<li ng-click="li_click(item.no)" ng-class='{"layui-this": item.no==active}'>{{item.no}}</li>
							</ul>
						</div>
						<div class="layui-tab-content wt-right">
							<div class="layui-tab-item layui-show con-table">
								<table class="layui-table" style="min-width: 900px;">
									<thead>
										<tr class="text-c">
											<th class="text-l">项目名称</th>
											<th width="12%">费用</th>
											<th width="10%">类型</th>
											<th width="25%" class="text-l">备注</th>
											<th width="18%">时间</th>
											<th width="12%">操作员</th>
										</tr>
									</thead>
									<tbody>
										<tr class="text-c" ng-repeat="items in details" ng-cloak>
											<td class="text-l">{{items.typeName}}</td>
											<td class="c-red">{{items.amount}}</td>
											<td>{{inOrOut}}</td>
											<td class="text-l">{{items.note}}</td>
											<td>{{billDate}}</td>
											<td>{{personName}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
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
        var reSearch = function () {
            var postData = {
                type: 'Otherlist',
                no: $scope.IncomeNum,
                inOrOut: $scope.IncomeType,
                createDateStart: $scope.Incomelogmin,
                createDateEnd: $scope.Incomelogmax,
                personName: $scope.IncomeStaff,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $scope.totalIncome = 0;
            $scope.totalOutcome = 0;
            $scope.total = 0;
            $http.post('../../Controller/finance/listIncomeAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.total = result.data.total;
                $scope.list = result.data.list;
                $scope.details = result.data.list[0].details;
                $scope.active = result.data.list[0].no;
                $scope.personName = result.data.list[0].personName;
                $scope.billDate = result.data.list[0].billDate;
                if(result.data.list[0].inOrOut==-1){
					$scope.inOrOut = "支出";
					$scope.totalOutcome = $scope.totalOutcome+result.data.list[0].amount;
					$("#Income").hide();
					$("#Outcome").show();
                }else{
                	$scope.inOrOut = "收入";
                	$scope.totalIncome = $scope.totalIncome+result.data.list[0].amount;
                	$("#Outcome").hide();
                	$("#Income").show();
                }
            }).catch(function () { //捕捉错误处理
            	$scope.totalIncome = 0;
        		$scope.totalOutcome = 0;
        		$scope.details = null;
            	if($scope.total==0){
                	layer.msg('暂无数据', {time: 3000});
                }else{
                	layer.msg('服务端请求错误！', {time: 3000});
                }
            });
        }
        $scope.li_click = function (i) {
        	$scope.totalOutcome = 0;
        	$scope.totalIncome = 0;
            var postData = {
                    type: 'Otherlist',
                    no: $scope.IncomeNum,
                    inOrOut: $scope.IncomeType,
                    createDateStart: $scope.Incomelogmin,
                    createDateEnd: $scope.Incomelogmax,
                    personName: $scope.IncomeStaff,
                    currentPage: $scope.paginationConf.currentPage,
                    itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/finance/listIncomeAction.php', postData).then(function (result) {  //正确请求成功时处理
                    $scope.paginationConf.totalItems = result.data.total;
                    $scope.list = result.data.list;
                    $scope.details = result.data.list[0].details;
                    $scope.active = result.data.list[0].no;
                    $scope.personName = result.data.list[0].personName;
                    if(result.data.list[0].inOrOut==-1){
    					$scope.inOrOut = "支出";
    					$("#Income").hide();
    					$("#Outcome").show();
                    }else{
                    	$scope.inOrOut = "收入";
                    	$("#Outcome").hide();
                    	$("#Income").show();
                    }
                    var postDatas = {
                            type: 'Otherlist',
                            no: i,
                            inOrOut: $scope.IncomeType,
                            createDateStart: $scope.Incomelogmin,
                            createDateEnd: $scope.Incomelogmax,
                            personName: $scope.IncomeStaff,
                            currentPage: $scope.paginationConf.currentPage,
                            itemsPerPage: $scope.paginationConf.itemsPerPage,
                    };
                    $http.post('../../Controller/finance/listIncomeAction.php', postDatas).then(function (res) {  //正确请求成功时处理
                    	$scope.lists = res.data.list;
                    	angular.forEach($scope.list, function (item) {
							if($scope.lists[0].no == item.no){
			                    $scope.details = res.data.list[0].details;
			                    $scope.active = res.data.list[0].no;
			                    $scope.personName = res.data.list[0].personName;
			                    $scope.billDate = result.data.list[0].billDate;
			                    if(res.data.list[0].inOrOut==-1){
			                    	$scope.totalOutcome = $scope.totalOutcome+res.data.list[0].amount;
			    					$scope.inOrOut = "支出";
			    					$("#Income").hide();
			    					$("#Outcome").show();
			                    }else{
			                    	$scope.inOrOut = "收入";
			                    	$scope.totalIncome = $scope.totalIncome+res.data.list[0].amount;
			                    	$("#Outcome").hide();
			                    	$("#Income").show();
			                    }
							}
                    	})
                    })
                    $scope.active = i; 
            }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.AddFiles=function(){
        	layer.open({
        		type: 2,
        		title: '添加收支项目',
        		area : ['460px' , '100%'],
        		anim: '0',
        		resize: false,
        		move: false,
        		shadeClose: true,
        		offset: ['0', '0'],
        		content: 'addOtherFiles.php',
        	});
        }
        $scope.resetSearch = function (){
			$scope.IncomeType = "";
			$scope.IncomeNum = "";
            $scope.Incomelogmin = "";
            $scope.Incomelogmax = "";
            $scope.IncomeStaff = "";
        }
    });
</script>
</body>
</html>