<?php
include('../../Common/check.php');
$datas = $_SESSION["datas"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-选择商品</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
	<div class="wrapper ags-wrapper">
		<div class="content">
			<div class="wbox">
				<div class="wbox-content">
					<div class="ags-left">
						<h2>商品分类</h2>
						<ul class="ags-category">
							<li ng-repeat="items in lists | unique:'catId'" ng-cloak ng-if="items.catName!=''" ng-click='li_click(items.catId)' ng-class='{active: items.catId==active}'><input type="checkbox" ng-model="$parent.conf[items.catId]" ng-click="selectAll(items.catId,items.skuId)"/>&nbsp;{{items.catName}}</li>
						</ul>
					</div>
					<div class="con-table ags-right">
						<table class="layui-table" style="min-width: 600px;">
							<thead>
								<tr class="text-c">
									<th></th>
									<th>商品编码</th>
									<th width="22%" class="text-l">商品名称</th>
									<th width="18%">规格</th>
									<th width="10%">单位</th>
									<th width="18%">当前库存</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="itemsg in lists | filter:{'catId':active}:true" ng-cloak>
									<td><input type="checkbox"  ng-model="$parent.confchil[itemsg.goodsId+itemsg.skuId]" ng-change="selectOne(itemsg.catId,itemsg.goodsId,itemsg.no,itemsg.name,itemsg.skuName,itemsg.unit,itemsg.storeNum,itemsg.salePrice,itemsg.stoId,itemsg.skuId,itemsg.catId,itemsg.catName)" ng-change="selectOne()"></td>
									<td>{{itemsg.no}}</td>
									<td class="text-l">{{itemsg.name}}</td>
									<td>{{itemsg.skuName}}</td>
									<td>{{itemsg.unit}}</td>
									<td>{{itemsg.storeNum}}</td>
									<input type="checkbox"  ng-model="$parent.confchil0[itemsg.goodsId]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil1[itemsg.no]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil2[itemsg.name]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil3[itemsg.skuName]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil4[itemsg.unit]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil5[itemsg.storeNum]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil6[itemsg.salePrice]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil7[itemsg.stoId]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil8[itemsg.skuId]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil9[itemsg.catId]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil10[itemsg.catName]" style="display: none;" />
								</tr>
							</tbody>
						</table>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" value="添加" ng-click="AddGoods()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="reGoods()" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form action="editGoodsStorage.php" id="sub" method="post" target="_parent">
		<input name="datas" type="hidden" value='' id="datas" />
		<input name="type" type="hidden" value="list" />
	</form>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
	<script type="text/javascript" src="../../js/layui.js"></script>
<script type="text/javascript">
var app = angular.module('myApp', ['common']);
app.controller('listController', function ($scope, $http) {
	$scope.checked = [];
	$scope.checked0 = [];
    $scope.checked1 = [];
    $scope.checked2 = [];
    $scope.checked3 = [];
    $scope.checked4 = [];
    $scope.checked5 = [];
    $scope.checked6 = [];
    $scope.checked7 = [];
    $scope.checked8 = [];
    $scope.checked9 = [];
    $scope.checked10 = [];
    $scope.conf = [];
    $scope.confchil = [];
    $scope.confchil0 = [];
    $scope.confchil1 = [];
    $scope.confchil2 = [];
    $scope.confchil3 = [];
    $scope.confchil4 = [];
    $scope.confchil5 = [];
    $scope.confchil6 = [];
    $scope.confchil7 = [];
    $scope.confchil8 = [];
    $scope.confchil9 = [];
    $scope.confchil10 = [];
    $scope.childArr = [];
	var postData = {type: 'proList'};
    $http.post('../../Controller/psi/addGoodsStorageAction.php', postData).then(function (result) {  //正确请求成功时处理
        $scope.lists = result.data.list;
        $scope.active = result.data.list[0].catId;
        var datas = '<?php echo $datas;?>';
    	if(datas==""){
    		$scope.list = [];
    	}else{
    		$scope.list = eval("(" + datas + ")");
    	}
    	var i = 0;
        /* var data = {};
        var data1 = {}; */
        angular.forEach($scope.lists, function (item) {
        	angular.forEach($scope.list, function (items) {
        		if ((item.goodsId+item.skuId) == (items.goodsId+items.skuId)) {
            		$scope.confchil[item.goodsId+item.skuId] = true;
                    $scope.checked.push(item.goodsId+item.skuId);
                    
                    $scope.confchil0[item.goodsId] = true;
                    $scope.checked0.push(item.goodsId);
                    //编号
                    $scope.confchil1[item.no] = true;
                    $scope.checked1.push(item.no);
                    //名称
                    $scope.confchil2[item.name] = true;
                    $scope.checked2.push(item.name);
                    //规格
                    $scope.confchil3[item.skuName] = true;
                    $scope.checked3.push(item.skuName);
                    //单位
                    $scope.confchil4[item.unit] = true;
                    $scope.checked4.push(item.unit);
                    //库存
                    $scope.confchil5[item.storeNum] = true;
                    $scope.checked5.push(item.storeNum);
                    //商品入库金额
                    $scope.confchil6[item.salePrice] = true;
                    $scope.checked6.push(item.salePrice);
                    //店铺编号
                    $scope.confchil7[item.stoId] = true;
                    $scope.checked7.push(item.stoId);
                    //
                    $scope.confchil8[item.skuId] = true;
                    $scope.checked8.push(item.skuId);
                    //类别
                    $scope.confchil9[item.catId] = true;
                    $scope.checked9.push(item.catId);
                    //类别
                    $scope.confchil10[item.catName] = true;
                    $scope.checked10.push(item.catName);
                 }
        	}) 
        	$scope.partentIdarr = [];
            $scope.arr = [];
            angular.forEach($scope.lists, function (items) {
                if (items.catId == item.catId) {
                	$scope.partentIdarr.unshift(items.goodsId+items.skuId);
                }
            })
            angular.forEach($scope.lists, function (items) {
                if ($scope.confchil[items.goodsId+items.skuId] == true && items.catId == item.catId) {
                	$scope.childArr.unshift(items.goodsId+items.skuId);
                }
            })
            uniqueArray($scope.childArr);
            if ($scope.partentIdarr.length === $scope.childArr.length && $scope.partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
                $scope.childArr.shift();
                $scope.conf[item.catId] = false;
            } else if ($scope.partentIdarr.sort().toString() == $scope.childArr.sort().toString()) {
                $scope.conf[item.catId] = true;
                $scope.childArr = [];
            } else {
                $scope.childArr.shift();
                if ($scope.partentIdarr.length === $scope.childArr.length && $scope.partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
                    $scope.childArr.shift();
                    $scope.conf[item.catId] = true;
                    $scope.childArr = [];
                } else {
                    $scope.conf[item.catId] = false;
                }
            }
        	/* data = countId($scope.list);
        	data1 = countId($scope.lists);
        	if($scope.list[i].skuId==""){
        		var t1 = data[$scope.list[i].catId];
            	var t2 = data1[item.catId];
           	}else{
           		var t1 = data[$scope.list[i].catId+$scope.list[i].skuId];
            	var t2 = data1[item.catId+item.skuId];
            }
        	if(t1==t2){
        		$scope.conf[item.catId] = true;
           	}else{
           		$scope.conf[item.catId] = false;
            } */
            i++;
        })
    }).catch(function () { //捕捉错误处理
        layer.msg('服务端请求错误！', {time: 3000});
    });
    $scope.li_click = function (i) {
        $scope.active = i;
    }
    $scope.selectAll = function (catId,skuId) {
        if ($scope.conf[catId]) {
            angular.forEach($scope.lists, function (item) {
                if (item.catId == catId) {
                	$scope.confchil[item.goodsId+item.skuId] = true;
                    $scope.checked.push(item.goodsId+item.skuId);

                    $scope.confchil0[item.goodsId] = true;
                    $scope.checked0.push(item.goodsId);
                    //编号
                    $scope.confchil1[item.no] = true;
                    $scope.checked1.push(item.no);
                    //名称
                    $scope.confchil2[item.name] = true;
                    $scope.checked2.push(item.name);
                    //规格
                    $scope.confchil3[item.skuName] = true;
                    $scope.checked3.push(item.skuName);
                    //单位
                    $scope.confchil4[item.unit] = true;
                    $scope.checked4.push(item.unit);
                    //库存
                    $scope.confchil5[item.storeNum] = true;
                    $scope.checked5.push(item.storeNum);
                    //商品入库金额
                    $scope.confchil6[item.salePrice] = true;
                    $scope.checked6.push(item.salePrice);
                    //店铺编号
                    $scope.confchil7[item.stoId] = true;
                    $scope.checked7.push(item.stoId);
                    //
                    $scope.confchil8[item.skuId] = true;
                    $scope.checked8.push(item.skuId);
                    //类别
                    $scope.confchil9[item.catId] = true;
                    $scope.checked9.push(item.catId);
                    //类别
                    $scope.confchil10[item.catName] = true;
                    $scope.checked10.push(item.catName);
                }
            })
        } else {
            angular.forEach($scope.lists, function (item) {
                if (item.catId == catId) {
                    $scope.confchil[item.goodsId+item.skuId] = false;
                    $scope.checked.splice($.inArray(item.goodsId+item.skuId, $scope.checked), 1);

                    $scope.confchil0[item.goodsId] = false;
                    $scope.checked0.splice($.inArray(item.goodsId, $scope.checked0), 1);
                    //编号
                    $scope.confchil1[item.no] = false;
                    $scope.checked1.splice($.inArray(item.no, $scope.checked1), 1);
                    //名称
                    $scope.confchil2[item.name] = false;
                    $scope.checked2.splice($.inArray(item.name, $scope.checked2), 1);
                    //规格
                    $scope.confchil3[item.skuName] = false;
                    $scope.checked3.splice($.inArray(item.skuName, $scope.checked3), 1);
                    //单位
                    $scope.confchil4[item.unit] = false;
                    $scope.checked4.splice($.inArray(item.unit, $scope.checked4), 1);
                    //库存
                    $scope.confchil5[item.storeNum] = false;
                    $scope.checked5.splice($.inArray(item.storeNum, $scope.checked5), 1);
                    //商品入库金额
                    $scope.confchil6[item.salePrice] = false;
                    $scope.checked6.splice($.inArray(item.salePrice, $scope.checked6), 1);
                    //商品入库金额
                    $scope.confchil7[item.stoId] = false;
                    $scope.checked7.splice($.inArray(item.stoId, $scope.checked7), 1);
                    //商品入库金额
                    $scope.confchil8[item.skuId] = false;
                    $scope.checked8.splice($.inArray(item.skuId, $scope.checked8), 1);
                    //商品类别
                    $scope.confchil9[item.catId] = false;
                    $scope.checked9.splice($.inArray(item.catId, $scope.checked9), 1);
                    //商品类别
                    $scope.confchil10[item.catName] = false;
                    $scope.checked10.splice($.inArray(item.catName, $scope.checked10), 1);
                }
            })
        }
    }
    $scope.selectOne = function (partentId, id, no, name, skuName, unit, storeNum, salePrice, stoId, skuId,catId,catName) {
    	$scope.partentIdarr = [];
        $scope.arr = [];
        var index = $scope.checked.indexOf(id+skuId);
        var index0 = $scope.checked.indexOf(id);
        var index1 = $scope.checked1.indexOf(no);
        var index2 = $scope.checked2.indexOf(name);
        var index3 = $scope.checked3.indexOf(skuName);
        var index4 = $scope.checked4.indexOf(unit);
        var index5 = $scope.checked5.indexOf(storeNum);
        var index6 = $scope.checked6.indexOf(salePrice);
        var index7 = $scope.checked7.indexOf(stoId);
        var index8 = $scope.checked8.indexOf(skuId);
        var index9 = $scope.checked9.indexOf(catId);
        var index10 = $scope.checked10.indexOf(catName);
        if ($scope.confchil[id+skuId] && index === -1) {
        	$scope.checked.push(id+skuId);
        	$scope.checked0.push(id);
        	$scope.checked1.push(no);
        	$scope.checked2.push(name);
        	$scope.checked3.push(skuName);
        	$scope.checked4.push(unit);
        	$scope.checked5.push(storeNum);
        	$scope.checked6.push(salePrice);
        	$scope.checked7.push(stoId);
        	$scope.checked8.push(skuId);
        	$scope.checked9.push(catId);
        	$scope.checked10.push(catName);
        } else if (!$scope.confchil[id+skuId] && index !== -1) {
            $scope.checked.splice(index, 1);
            $scope.checked0.splice(index0, 1);
            $scope.checked1.splice(index1, 1);
        	$scope.checked2.splice(index2, 1);
        	$scope.checked3.splice(index3, 1);
        	$scope.checked4.splice(index4, 1);
        	$scope.checked5.splice(index5, 1);
        	$scope.checked6.splice(index6, 1);
        	$scope.checked7.splice(index7, 1);
        	$scope.checked8.splice(index8, 1);
        	$scope.checked9.splice(index9, 1);
        	$scope.checked10.splice(index10, 1);
        }
        angular.forEach($scope.lists, function (item) {
            if (item.catId == partentId) {
            	$scope.partentIdarr.unshift(item.goodsId+item.skuId);
            }
        })
        angular.forEach($scope.lists, function (item) {
            if ($scope.confchil[item.goodsId+item.skuId] == true && item.catId == partentId) {
            	$scope.childArr.unshift(item.goodsId+item.skuId);
            }
        })
        uniqueArray($scope.childArr);
        if ($scope.partentIdarr.length === $scope.childArr.length && $scope.partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
            $scope.childArr.shift();
            $scope.conf[partentId] = false;
        } else if ($scope.partentIdarr.sort().toString() == $scope.childArr.sort().toString()) {
            $scope.conf[partentId] = true;
            $scope.childArr = [];
        } else {
            $scope.childArr.shift();
            if ($scope.partentIdarr.length === $scope.childArr.length && $scope.partentIdarr.sort().toString() != $scope.childArr.sort().toString()) {
                $scope.childArr.shift();
                $scope.conf[partentId] = true;
                $scope.childArr = [];
            } else {
                $scope.conf[partentId] = false;
            }
        }
    }
    $scope.AddGoods = function(){
    	uniqueArray($scope.checked);
        var count = $scope.checked.length;
        if(count==0){
        	layer.msg('请选择商品', {time: 3000});
        	return false;
        }
        var datas = new Array();
        for (var i = 0; i < count; i++) {
            datas[i] = {};
            datas[i]['str'] = $scope.checked[i];
            datas[i]['goodsId'] = $scope.checked0[i];
            datas[i]['no'] = $scope.checked1[i];
            datas[i]['name'] = $scope.checked2[i];
            datas[i]['skuName'] = $scope.checked3[i];
            datas[i]['unit'] = $scope.checked4[i];
            datas[i]['storeNum'] = $scope.checked5[i];
            datas[i]['salePrice'] = $scope.checked6[i];
            datas[i]['stoId'] = $scope.checked7[i];
            datas[i]['skuId'] = $scope.checked8[i];
            datas[i]['catId'] = $scope.checked9[i];
            datas[i]['catName'] = $scope.checked10[i];
        } 
        var postData = angular.toJson(datas);
        parent.layer.msg('恭喜你，添加成功', {icon: 6, time: 1500});
        $("#datas").val(postData);
        $("#sub").submit();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        //parent.location.href='editGoodsStorage.php?datas='+postData+'&type=list';
    }
    $scope.reGoods = function(){
    	$scope.checked = [];
    	$scope.checked0 = [];
        $scope.checked1 = [];
        $scope.checked2 = [];
        $scope.checked3 = [];
        $scope.checked4 = [];
        $scope.checked5 = [];
        $scope.checked6 = [];
        $scope.checked7 = [];
    	$scope.checked8 = [];
    	$scope.checked9 = [];
    	$scope.checked10 = [];
    }
    Array.prototype.unique3 = function () {
        var res = [];
        var json = {};
        for (var i = 0; i < this.length; i++) {
            if (!json[this[i]]) {
                res.push(this[i]);
                json[this[i]] = 1;
            }
        }
        return res;
    }
});
angular.module('common', []).filter('unique', function () {
    return function (collection, keyname) {
        var output = [], keys = [];
        angular.forEach(collection, function (item) {
            var key = item[keyname];
            if (keys.indexOf(key) === -1) {
                keys.push(key);
                output.push(item);
            }
        });
        return output;
    }
});
function uniqueArray(data) {
    data = data || [];
    var a = {};
    for (var i = 0; i < data.length; i++) {
        var v = data[i];
        if (typeof(a[v]) == 'undefined') {
            a[v] = 1;
        }
    }
    ;
    data.length = 0;
    for (var i in a) {
        data[data.length] = i;
    }
    return data;
}
//检查某一元素在数组中出现的次数
function countId(data){
  var count={};
  for(var i=0;i<data.length;i++){
	 	if(data[i].skuId==""){
	 		if(count[data[i].catId]){
		        count[data[i].catId]++;
		        continue;
		    }
		    count[data[i].catId]=1;
		}else{
		    if(count[data[i].catId+data[i].skuId]){
		        count[data[i].catId+data[i].skuId]++;
		        continue;
		    }
		    count[data[i].catId+data[i].skuId]=1;
		}
  }
  return count;
}
</script>
</body>
</html>