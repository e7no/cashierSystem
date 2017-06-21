<?php
include('../../Common/check.php');
if($_POST["type"]=="list"){
	$arr = json_decode($_POST["datas"], true);
}
$_SESSION["datas"] = $_POST["datas"];
//file_put_contents("log.txt", "json信息：".var_export($_POST["type"],TRUE)."\n", FILE_APPEND);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-入库商品编辑</title>
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
			<div class="wbox">
				<div class="wbox-title">
					<h5>入库商品编辑</h5>
					<div class="ibox-tools">
						<a class="btn-red del-btn" ng-click="delGoods()">删除</a>
						<a class="btn-blue put-btn" ng-click="AddInStock()" ng-disabled="data">入库</a>
						<a class="btn-shuaxin" href='javascript:$("#sub").submit();' title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<form class="layui-form layui-form-pane psi-form">
						<div class="con-table">
							<table class="layui-table" style="min-width: 1000px;">
								<thead>
									<tr class="text-c">
										<th width="3%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
										<th>商品编码</th>
										<th width="16%" class="text-l">商品名称</th>
										<th width="12%">商品类别</th>
										<th width="8%">单位</th>
										<th width="10%">规格</th>
										<th width="8%">商品进价</th>
										<th width="10%">入库数量</th>
										<th width="10%">入库金额</th>
										<th width="10%">当前库存</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if($_POST["type"]=="list"){?>
									<tr class="text-c" ng-repeat="item in list" ng-cloak>
										<td><input type="checkbox" ng-model="$parent.checked[item.goodsId+item.skuId]" ng-change="selectOne(item.goodsId,item.skuId)" /></td>
										<td>{{item.no}}</td>
										<td class="text-l">{{item.name}}</td>
										<td>{{item.catName}}</td>
										<td>{{item.unit}}</td>
										<td>{{item.skuName}}</td>
										<td>{{item.salePrice}}</td>
										<td><input type="text" class="egs-text" ng-model="$parent.arr[item.goodsId+item.skuId]" onafterpaste="this.value=this.value.replace(/\D/g,'')" ng-keyup="addnum(item.salePrice,$index,item.goodsId+item.skuId)" placeholder="入库数量" /></td>
										<td><span>{{$parent.arrtotal[item.goodsId+item.skuId]|number:2}}</span></td>
										<td>{{item.storeNum}}</td>
									</tr>
								<?php }?>
									<tr class="text-c">
										<td></td>
										<td colspan="2" class="text-l psi-select" ng-click="AddGoods()">
											请选择入库商品...
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="layui-form-item">
							<div class="layui-inline">
						    	<label class="layui-form-label">入库时间</label>
						    	<div class="layui-input-inline" style="width: 142px;">
						    		<!-- <select class="layui-input">
								        <option value="0">请选择...</option>
								        <option value="1">生产入库</option>
								        <option value="2">预订入库</option>
								        <option value="3">采购入库</option>
								        <option value="4">其他入库</option>
								    </select> -->
								    <input type="text" class="Wdate layui-input" ng-model="inDateStart" id="logmin" placeholder="请选择..." onchange=""  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'%y-%M-%d\'}'})">
						    	</div>
							</div>
							<div class="layui-inline">
						    	<label class="layui-form-label">入库员</label>
						    	<div class="layui-input-inline" style="width: 120px;">
						    		<input type="text" ng-model="personName" class="layui-input" placeholder="请输入入库员姓名">
						    	</div>
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<label class="layui-form-label">备注</label>
					    	<div class="layui-input-inline" style="width: 370px;">
						    	<input type="text" class="layui-input" ng-model="note" placeholder="请输入商品入库备注">
						    </div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" ng-disabled="data" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="入库" ng-click="AddInStock()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="reInStock()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<form action="editGoodsStorage.php" id="sub" method="post">
		<input name="datas" type="hidden" value='<?php echo $_POST["datas"];?>' id="datas" />
		<input name="type" type="hidden" value="list" />
	</form>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
var app = angular.module('myApp', ['tm.pagination']);
app.controller('listController', function ($scope, $http) {
	$scope.checked = [];
	$scope.lists = [];
	$scope.arr = [];
	$scope.arrtotal = [];
	$scope.data = false;
	var data = '<?php echo $_POST["datas"];?>';
	if(data==""){
		$scope.list = [];
	}else{
		$scope.list = eval("(" + data + ")");
	}
	$scope.AddGoods=function(){
		layer.open({
			type: 2,
			title: '添加商品',
			area : ['70%' , '84%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			content: "addGoodsStorage.php",
		});
    }
	$scope.AddInStock = function (){
		$scope.inStock = [];
		$scope.data = true;
		angular.forEach($scope.list, function (item) {
            if ($scope.arr[item.goodsId+item.skuId] != "") {
                $scope.inStock.push($scope.arr[item.goodsId+item.skuId]);
            }
        })
        if ($scope.list.length == 0) {
                layer.msg('请添加入库商品！', {time: 3000});
                $scope.data = false;
                return;
        }
		var postData = {
            type: 'addgoods',
            data: angular.toJson($scope.list),
            inStocks: $scope.inStock,
            inDateStart: $scope.inDateStart,
            personName: $scope.personName,
            note: $scope.note
        };
        $scope.inStocks = 0;
		angular.forEach($scope.list, function (item) {
			if (!angular.isDefined($scope.arr[item.goodsId+item.skuId])) {
				$scope.inStocks = 1;
            }
			if (Number($scope.arr[item.goodsId+item.skuId])==0) {
				$scope.inStocks = 2;
            }
        })
        if($scope.inStocks=="1"){
        	layer.msg("请输入完整入库数量", {time: 3000});
        	$scope.data = false;
        	return false;
        }else if($scope.inStocks=="2"){
        	layer.msg("所有的商品入库数量必须大于 0", {time: 3000});
        	$scope.data = false;
        	return false;
        }
		if(!angular.isDefined($scope.inDateStart)){
        	layer.msg("请选择入库时间", {time: 3000});
        	$scope.data = false;
        	return false;
        }
        if(!angular.isDefined($scope.personName)){
        	layer.msg("请输入入库员", {time: 3000});
        	$scope.data = false;
        	return false;
        }
		$http.post('../../Controller/psi/listGoodsStorageAction.php', postData).then(function (result) {  //正确请求成功时处理
        	if (result.data.success) {
        		var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
                layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                parent.location.reload();
            } else {
                layer.msg(result.data.message, {time: 3000});
                $scope.data = false;
            }
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
            $scope.data = false;
        });
	}
	$scope.delGoods = function (){
    	var ids = $scope.checked;
    	if(ids.length<=0){
    		layer.msg('请选择你要删除的入库商品', {time: 3000});
        	return false;
       	}
        layer.alert('亲，您确定删除选中的入库商品吗？', {icon: 5, title: "删除", resize: false,}, function () {
        	ids.forEach(function(val,index,arr){
            	$scope.list.del(function(item){
            		 return item.str == val;
            	})
            })
        	layer.msg('恭喜你，删除成功！', {icon: 6, time: 1500});
        	var postData = angular.toJson($scope.list);
        	$("#datas").val(postData);
            $("#sub").submit();
        	//location.href='editGoodsStorage.php?datas='+postData+'&type=list';
        });
    }
	Array.prototype.del = function(filter){
	  var idx = filter;
	  if(typeof filter == 'function'){
	    for(var i=0;i<this.length;i++){
	      if(filter(this[i],i)) idx = i;
	    }
	  }
	  this.splice(idx,1)
	}
    $scope.selectAll = function () {
        if ($scope.select_all) {
            $scope.checked = [];
            angular.forEach($scope.list, function (item) {
            	//item.checked = true;
                $scope.checked[item.goodsId+item.skuId] = true;
                $scope.checked.push(item.goodsId+item.skuId);
            })
        } else {
            angular.forEach($scope.list, function (item) {
                //item.checked = false;
                $scope.checked[item.goodsId+item.skuId] = false;
                $scope.checked = [];
            })
        }
    };
    $scope.selectOne = function (id,skuId) {
        angular.forEach($scope.list, function (item) {
            var index = $scope.checked.indexOf(id+skuId);
            if ($scope.checked[id+skuId] && index === -1) {
                $scope.checked.push(id+skuId);
            } else if (!$scope.checked[id+skuId] && index !== -1) {
                $scope.checked.splice(index, 1);
            }
            ;
        })
        if ($scope.list.length === $scope.checked.length) {
            $scope.select_all = true;
        } else {
            $scope.select_all = false;
        }
    }
    $scope.addnum = function(money,id,str){
        var num = $scope.arr[str];
    	//$scope.total = num*money;
    	$scope.arr[str] = num.replace(/[^\d.]/g, "").replace(/^\./g, "").replace(/\.{2,}/g, ".").replace(".", "$#$").replace(/\./g, "").replace("$#$", ".").replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3')
    	$scope.arrtotal[str] = num*money;
    }
});
</script>
</body>
</html>