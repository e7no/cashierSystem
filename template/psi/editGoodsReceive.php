<?php
include('../../Common/check.php');
if($_POST["type"]=="list"){
	$arr = json_decode($_POST["datas"], true);
}
$_SESSION["datas"] = $_POST["datas"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-出库商品编辑</title>
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
					<h5>出库商品编辑</h5>
					<div class="ibox-tools">
						<a class="btn-red del-btn" ng-click="delGoods()">删除</a>
						<a class="btn-blue put-btn" ng-click="AddOutStock()" ng-disabled="data">出库</a>
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
										<th width="10%">出库数量</th>
										<th width="10%">出库金额</th>
										<th width="10%">当前库存</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if($_POST["type"]=="list"){?>
									<tr class="text-c" ng-repeat="item in list" ng-cloak>
										<td><input type="checkbox" ng-model="$parent.checked[item.str]" ng-change="selectOne(item.str)" /></td>
										<td>{{item.no}}</td>
										<td class="text-l">{{item.name}}</td>
										<td>{{item.catName}}</td>
										<td>{{item.unit}}</td>
										<td>{{item.skuName}}</td>
										<td>{{item.salePrice}}</td>
										<td><input type="text" ng-model="$parent.arr[item.goodsId+item.skuId]" onafterpaste="this.value=this.value.replace(/\D/g,'')" ng-keyup="addnum(item.salePrice,$index,item.goodsId+item.skuId)" class="egs-text" placeholder="出库数量" /></td>
										<td>{{$parent.arrtotal[item.goodsId+item.skuId]|number:2}}</td>
										<td>{{item.storeNum}}</td>
									</tr>
							    <?php }?>
									<tr class="text-c">
										<td><input type="checkbox" /></td>
										<td colspan="2" class="text-l psi-select" ng-click="AddGoods()">
											请选择出库商品...
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
						    	<label class="layui-form-label">出库时间</label>
						    	<div class="layui-input-inline" style="width: 152px;">
						    		<input type="text" class="Wdate layui-input" ng-model="outDateStart" onchange="" id="logmin" placeholder="请选择..."  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'%y-%M-%d\'}'})">
						    	</div>
							</div>
							<div class="layui-inline">
						    	<label class="layui-form-label">出库员</label>
						    	<div class="layui-input-inline" style="width: 120px;">
						    		<input type="text" class="layui-input" ng-model="personName" placeholder="请输入出库员姓名">
						    	</div>
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<label class="layui-form-label">备注</label>
					    	<div class="layui-input-inline" style="width: 360px;">
						    	<input type="text" class="layui-input" ng-model="note" placeholder="请输入商品出库备注">
						    </div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" ng-disabled="data" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="出库" ng-click="AddOutStock()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="reOutStock()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<form action="editGoodsReceive.php" id="sub" method="post">
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
			content: 'addGoodsReceive.php',
		});
    }
	$scope.AddOutStock = function (){
		$scope.outStock = [];
		$scope.data = true;
		angular.forEach($scope.list, function (item) {
            if ($scope.arr[item.goodsId+item.skuId] != "") {
                $scope.outStock.push($scope.arr[item.goodsId+item.skuId]);
            }
        })
        if ($scope.list.length == 0) {
                layer.msg('请添加出库商品！', {time: 3000});
                $scope.data = false;
                return;
        }
		var postData = {
            type: 'outgoods',
            data: angular.toJson($scope.list),
            outStock: $scope.outStock,
            outDateStart: $scope.outDateStart,
            personName: $scope.personName,
            note: $scope.note
        };
        $scope.outStocks = 0;
		angular.forEach($scope.list, function (item) {
			if (!angular.isDefined($scope.arr[item.goodsId+item.skuId])) {
				$scope.outStocks = 1;
            }
			if (Number($scope.arr[item.goodsId+item.skuId])==0) {
				$scope.outStocks = 2;
            }
        })
        if($scope.outStocks=="1"){
        	layer.msg("请输入完整出库数量", {time: 3000});
        	$scope.data = false;
        	return false;
        }else if($scope.outStocks=="2"){
        	layer.msg("所有的商品出库数量必须大于 0", {time: 3000});
        	$scope.data = false;
        	return false;
        }
		if(!angular.isDefined($scope.outDateStart)){
        	layer.msg("请选择出库时间", {time: 3000});
        	$scope.data = false;
        	return false;
        }
        if(!angular.isDefined($scope.personName)){
        	layer.msg("请输入出库员", {time: 3000});
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
    		layer.msg('请选择你要删除的出库商品', {time: 3000});
        	return false;
       	}
    	//console.log(ids);
        layer.alert('亲，您确定删除选中的出库商品吗？', {icon: 5, title: "删除", resize: false,}, function () {
        	//console.log($scope.list);
			ids.forEach(function(val,index,arr){
            	$scope.list.del(function(item){
            		 return item.str == val;
            	})
            })
        	//console.log($scope.list);
        	layer.msg('恭喜你，删除成功！', {icon: 6, time: 1500});
        	var postData = angular.toJson($scope.list);
        	$("#datas").val(postData);
            $("#sub").submit();
            var index = layer.index; //获取当前弹层的索引号
            layer.close(index); //关闭当前弹层
        	//location.href='editGoodsReceive.php?datas='+postData+'&type=list';
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
                $scope.checked[item.str] = true;
                $scope.checked.push(item.str);
            })
        } else {
            angular.forEach($scope.list, function (item) {
                //item.checked = false;
                $scope.checked[item.str] = false;
                $scope.checked = [];
            })
        }
    };
    $scope.selectOne = function (str) {
        angular.forEach($scope.list, function (item) {
            var index = $scope.checked.indexOf(str);
            if ($scope.checked[str] && index === -1) {
                $scope.checked.push(str);
            } else if (!$scope.checked[str] && index !== -1) {
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
        $scope.arr[str] = num.replace(/[^\d.]/g, "").replace(/^\./g, "").replace(/\.{2,}/g, ".").replace(".", "$#$").replace(/\./g, "").replace("$#$", ".").replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3')
    	$scope.arrtotal[str] = num*money;
    }
});
</script>
</body>
</html>