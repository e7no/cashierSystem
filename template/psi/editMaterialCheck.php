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
    <title>汇汇生活商家后台-盘点原料编辑</title>
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
					<h5>盘点原料编辑</h5>
					<div class="ibox-tools">
						<a class="btn-red del-btn" ng-click="delGoods()">删除</a>
						<a class="btn-blue put-btn" ng-click="AddInStock()" ng-disabled="data">盘点</a>
						<a class="btn-shuaxin" href='javascript:$("#sub").submit();' title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<form class="layui-form layui-form-pane psi-form">
						<div class="con-table">
							<table class="layui-table" style="min-width: 1600px;">
								<thead>
									<tr class="text-c">
										<th width="2%"><input type="checkbox" ng-model="select_all" ng-click="selectAll()"/></th>
										<th>原料编码</th>
										<th width="12%" class="text-l">原料名称</th>
										<th width="8%">原料类别</th>
										<th width="5%">单位</th>
										<th width="8%">规格</th>
										<th width="6%">当前库存</th>
										<th width="8%">当前库存金额</th>
										<th width="6%">原料标准价</th>
										<th width="6%">原料单价</th>
										<th width="8%">盘点数量</th>
										<th width="8%">盘点金额</th>
										<th width="6%">盈亏数量</th>
										<th width="7%">盈亏金额</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if($_POST["type"]=="list"){?>
									<tr class="text-c" ng-repeat="item in list" ng-cloak>
										<td><input type="checkbox" ng-model="$parent.checked[item.id]" ng-change="selectOne(item.id)" /></td>
										<td>{{item.code}}</td>
										<td class="text-l">{{item.name}}</td>
										<td>{{item.typeName}}</td>
										<td>{{item.unit}}</td>
										<td>{{item.spec}}</td>
										<td>{{item.stock ? item.stock : 0}}</td>
										<td>{{item.stock*item.avgPrice}}</td>
										<td>{{item.standardPrice}}</td>
										<td>{{item.avgPrice}}</td>
										<td><input type="text" class="egs-text" ng-model="$parent.arr[item.id]" ng-keyup="addnum(item.id,item.avgPrice,item.stock)" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="盘点数量" /></td>
										<td><span>{{$parent.arrtotal[item.id] ? ($parent.arrtotal[item.id]|number:2) : '0.00'}}</span></td>
										<td><span>{{$parent.minusQty[item.id] ? ($parent.minusQty[item.id]|number:2) : 0}}</span></td>
										<td>{{$parent.minusQty[item.id] ? ($parent.minusAmount[item.id]|number:2) : '0.00'}}</td>
									</tr>
									<?php }?>
									<tr class="text-c">
										<td></td>
										<td colspan="2" class="text-l psi-select" ng-click="AddGoods()">
											请选择盘点原料...
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
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
						    	<label class="layui-form-label">盘点时间</label>
						    	<div class="layui-input-inline" style="width: 152px;">
						    		<input type="text" class="Wdate layui-input" id="logmin" ng-model="invDate" placeholder="请选择..." onchange="" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{\'%y-%M-%d\'}'})">
						    	</div>
							</div>
							<div class="layui-inline">
						    	<label class="layui-form-label">盘点员</label>
						    	<div class="layui-input-inline" style="width: 120px;">
						    		<input type="text" class="layui-input" ng-model="personName" placeholder="请输入盘点员姓名">
						    	</div>
							</div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<label class="layui-form-label">备注</label>
					    	<div class="layui-input-inline" style="width: 380px;">
						    	<input type="text" class="layui-input" ng-model="note" placeholder="请输入原料盘点备注">
						    </div>
						</div>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" ng-disabled="data" class="layui-btn layui-btn-small layui-btn-normal put-btn" value="盘点" ng-click="AddinvStock()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="reinvStock()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<form action="editMaterialCheck.php" id="sub" method="post">
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
	$scope.minusQty = [];
	$scope.minusAmount = [];
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
			title: '添加原料',
			area : ['70%' , '84%'],
			anim: '0',
			resize: false,
			move: false,
			shadeClose: true,
			content: "addMaterialCheck.php",
		});
    }
	$scope.AddinvStock = function (){
		$scope.inStock = [];
		$scope.data = true;
		angular.forEach($scope.list, function (item) {
			if ($scope.arr[item.id] != "") {
            	$scope.inStock.push($scope.arr[item.id]);
            }
        })
        if ($scope.list.length == 0) {
                layer.msg('请添加盘点原料！', {time: 3000});
                $scope.data = false;
                return;
        }
		var postData = {
            type: 'addmaterial',
            data: angular.toJson($scope.list),
            inStocks: $scope.inStock,
            invDate: $scope.invDate,
            personName: $scope.personName,
            note: $scope.note
        };
		$scope.inStocks = 0;
		angular.forEach($scope.list, function (item) {
			if (!angular.isDefined($scope.arr[item.id])) {
				$scope.inStocks = 1;
            }
			if (Number($scope.arr[item.id])==0) {
				$scope.inStocks = 2;
            }
        })
		if($scope.inStocks=="1"){
        	layer.msg("请输入完整盘点数量", {time: 3000});
        	$scope.data = false;
        	return false;
        }else if($scope.inStocks=="2"){
        	layer.msg("所有的原料入库数量必须大于 0", {time: 3000});
        	$scope.data = false;
        	return false;
        }
		if(!angular.isDefined($scope.invDate)){
        	layer.msg("请选择盘点时间", {time: 3000});
        	$scope.data = false;
        	return false;
        }
        if(!angular.isDefined($scope.personName)){
        	layer.msg("请输入盘点员", {time: 3000});
        	$scope.data = false;
        	return false;
        }
		$http.post('../../Controller/psi/listMaterialCheckAction.php', postData).then(function (result) {  //正确请求成功时处理
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
    		layer.msg('请选择你要删除的入库原料', {time: 3000});
        	return false;
       	}
        layer.alert('亲，您确定删除选中的入库原料吗？', {icon: 5, title: "删除", resize: false,}, function () {
        	ids.forEach(function(val,index,arr){
            	$scope.list.del(function(item){
            		 return item.id == val;
            	})
            })
        	layer.msg('恭喜你，删除成功！', {icon: 6, time: 1500});
        	var postData = angular.toJson($scope.list);
        	$("#datas").val(postData);
            $("#sub").submit();
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
	$scope.reinvStock = function () {
		$scope.inStock = [];
        $scope.invDate = "";
        $scope.personName = "";
        $scope.note = "";
	}
    $scope.selectAll = function () {
        if ($scope.select_all) {
            $scope.checked = [];
            angular.forEach($scope.list, function (item) {
            	//item.checked = true;
                $scope.checked[item.id] = true;
                $scope.checked.push(item.id);
            })
        } else {
            angular.forEach($scope.list, function (item) {
                //item.checked = false;
                $scope.checked[item.id] = false;
                $scope.checked = [];
            })
        }
    };
    $scope.selectOne = function (id) {
        angular.forEach($scope.list, function (item) {
            var index = $scope.checked.indexOf(id);
            if ($scope.checked[id] && index === -1) {
                $scope.checked.push(id);
            } else if (!$scope.checked[id] && index !== -1) {
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
    $scope.addnum = function(id,money,stock){
    	$scope.arr[id] = $scope.arr[id].replace(/[^\d.]/g, "").replace(/^\./g, "").replace(/\.{2,}/g, ".").replace(".", "$#$").replace(/\./g, "").replace("$#$", ".").replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');
    	var num = $scope.arr[id] ? $scope.arr[id] : 0;
    	//$scope.total = num*money;
    	$scope.arrtotal[id] = num*money;
    	$scope.minusQty[id] = num-stock;
    	$scope.minusAmount[id] = $scope.minusQty[id]*money;
    }
});
</script>
</body>
</html>