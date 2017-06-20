<?php
include('../../Common/check.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-原料库存详情</title>
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
					    	<label class="layui-form-label">单号</label>
					    	<div class="layui-input-inline" style="width: 150px;">
					        	<input type="text" class="layui-input" placeholder="请输入单号" ng-model="no">
					    	</div>
					    </div>
						<div class="layui-inline">
					    	<label class="layui-form-label">类型</label>
					    	<div class="layui-input-inline">
					    		<select class="layui-input" ng-model="typeId">
							        <option value="">请选择...</option>
							        <option value="1">采购入库</option>
	                                <option value="2">预订入库</option>
	                                <option value="3">其它入库</option>
	                                <option value="4">退货</option>
	                                <option value="6">销售</option>
	                                <option value="7">预订出库</option>
	                                <option value="8">采购退回</option>
	                                <option value="9">其他出库</option>
	                                <option value="10">报废</option>
	                                <option value="11">盘点</option>
							    </select>
					    	</div>
						</div>
						<div class="layui-inline">
					    	<label class="layui-form-label">时间</label>
					    	<div class="layui-input-inline" style="width: 110px;">
					    		<input type="text" class="Wdate layui-input" id="logmin" ng-model="createDateStart" onchange="" placeholder="请选择..."  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
					    	</div>
					    	<div class="layui-form-mid">-</div>
					    	<div class="layui-input-inline" style="width: 110px;">
					    		<input type="text" class="Wdate layui-input" id="logmax" ng-model="createDateEnd" onchange="" placeholder="请选择..." onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
					    	</div>
					    </div>
					    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()" />
						<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()" />
					</div>
				</form>
			</div>
			<div class="wbox">
				<div class="wbox-title">
					<h5>原料库存详情</h5>
					<div class="ibox-tools">
						<!-- <a class="btn-green" href="javascript:;">导出</a> -->
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<form> 
						<div class="cprk-box">
							<span>原料编码：{{vo.code}}</span>
							<span>原料名称：{{vo.name}}</span>
							<span>原料分类：{{vo.typeName}}</span>
							<span>单位：{{vo.unit}}</span>
							<span>规格：{{vo.spec}}</span>
						</div>
						<div class="con-table">
							<table class="layui-table" style="min-width: 1000px;">
								<thead>
									<tr class="text-c">
										<th width="18%">单号</th>
										<th width="14%">类型</th>
										<th width="16%">时间</th>
										<th width="12%">出入库数量</th>
										<th width="12%">库存</th>
										<th class="text-l">备注</th>
									</tr>
								</thead>
								<tbody>
								<!-- 业务类型：1-采购入库,2-预订入库,3-其他入库,4-生产领用\r\n            5-预订出库.6-采购退回,7-其他领用,8-报废,9-盘点', -->
									<tr class="text-c" ng-repeat="item in list" ng-cloak>
										<td>{{item.no}}</td>
										<td ng-if="item.type==1">采购入库</td>
										<td ng-if="item.type==2">预订入库</td>
										<td ng-if="item.type==3">其它入库</td>
										<td ng-if="item.type==4">退货</td>
										<td ng-if="item.type==5">其他入库</td>
										<td ng-if="item.type==6">销售</td>
										<td ng-if="item.type==7">预订出库</td>
										<td ng-if="item.type==8">采购退回</td>
										<td ng-if="item.type==9">其他出库</td>
										<td ng-if="item.type==10">报废</td>
										<td ng-if="item.type==11 && item.changeStock>0">盘盈</td>
										<td ng-if="item.type==11 && item.changeStock<0">盘亏</td>
										<td>{{item.createDateText}}</td>
										<td ng-if="item.changeStock>0" class="c-green">+{{item.changeStock}}</td>
										<td ng-if="item.changeStock<=0" class="c-red">{{item.changeStock}}</td>
										<td>{{item.lastStock}}</td>
										<td class="text-l">{{item.note}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<tm-pagination conf="paginationConf"></tm-pagination>
					</form>
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
        var reSearch = function () {
            var postData = {
                type: 'detail',
                id: '<?php echo $id;?>',
                no: $scope.no,
                typeId: $scope.typeId,
                createDateStart: $scope.createDateStart,
                createDateEnd: $scope.createDateEnd,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/inventory/listMaterialInventoryAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
                $scope.vo = result.data.vo;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.no = undefined;
            $scope.typeId = undefined;
            $scope.createDateStart = undefined;
            $scope.createDateEnd = undefined;
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
    });
</script>
</body>
</html>