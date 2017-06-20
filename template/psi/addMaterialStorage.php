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
    <title>汇汇生活商家后台-添加原料</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
	<div class="wrapper ags-wrapper" ng-controller="listController">
		<div class="content">
			<div class="wbox">
				<div class="wbox-content">
					<div class="ags-left">
						<h2>原料分类</h2>
						<ul class="ags-category">
							<li ng-repeat="items in typelist" ng-cloak ng-if="items.typeName!=''" ng-click='li_click(items.id)' ng-class='{active: items.id==active}'><input type="checkbox" ng-model="$parent.conf[items.id]" ng-click="selectAll(items.id)"/>&nbsp;{{items.typeName}}</li>
						</ul>
					</div>
					<div class="con-table ags-right">
						<table class="layui-table" style="min-width: 600px;">
							<thead>
								<tr class="text-c">
									<th></th>
									<th>原料编码</th>
									<th width="22%" class="text-l">原料名称</th>
									<th width="18%">规格</th>
									<th width="10%">单位</th>
									<th width="18%">当前库存</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-c" ng-repeat="itemsg in goodslist | filter:{'typeId':active}:true" ng-cloak>
									<td><input type="checkbox"  ng-model="$parent.confchil[itemsg.id]" ng-change="selectOne(itemsg.typeId,itemsg.id,itemsg.code,itemsg.name,itemsg.spec,itemsg.unit,itemsg.stock,itemsg.standardPrice,itemsg.typeName,itemsg.maxPrice)" ng-change="selectOne()"></td>
									<td>{{itemsg.code}}</td>
									<td class="text-l">{{itemsg.name}}</td>
									<td>{{itemsg.spec}}</td>
									<td>{{itemsg.unit}}</td>
									<td>{{itemsg.stock ? itemsg.stock : 0}}</td>
									<input type="checkbox"  ng-model="$parent.confchil1[itemsg.code]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil2[itemsg.name]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil3[itemsg.spec]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil4[itemsg.unit]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil5[itemsg.stock]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil6[itemsg.standardPrice]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil7[itemsg.typeName]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil8[itemsg.typeId]" style="display: none;" />
									<input type="checkbox"  ng-model="$parent.confchil9[itemsg.maxPrice]" style="display: none;" />
								</tr>
							</tbody>
						</table>
						<div class="layui-form-item" style="margin-top: 10px;">
							<input type="button" class="layui-btn layui-btn-small layui-btn-normal add-submit" value="添加" ng-click="AddMaterial()">
							<input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="reMaterial()" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form action="editMaterialStorage.php" id="sub" method="post" target="_parent">
		<input name="datas" type="hidden" value='' id="datas" />
		<input name="type" type="hidden" value="list" />
	</form>
	<script type="text/javascript" src="../../js/jquery.min.js" ></script>
	<script type="text/javascript" src="../../js/layer/layer.min.js" ></script>
<script type="text/javascript">
var app = angular.module('myApp', ['common']);
app.controller('listController', function ($scope, $http) {
	$scope.checked = [];
    $scope.checked1 = [];
    $scope.checked2 = [];
    $scope.checked3 = [];
    $scope.checked4 = [];
    $scope.checked5 = [];
    $scope.checked6 = [];
    $scope.checked7 = [];
    $scope.checked8 = [];
    $scope.checked9 = [];
    $scope.conf = [];
    $scope.confchil = [];
    $scope.confchil1 = [];
    $scope.confchil2 = [];
    $scope.confchil3 = [];
    $scope.confchil4 = [];
    $scope.confchil5 = [];
    $scope.confchil6 = [];
    $scope.confchil7 = [];
    $scope.confchil8 = [];
    $scope.confchil9 = [];
    $scope.childArr = [];
	var postData = {type: 'proList'};
    $http.post('../../Controller/psi/addMaterialStorageAction.php', postData).then(function (result) {  //正确请求成功时处理
    	$scope.typelist = result.data.typelist;
    	$scope.goodslist = result.data.goodslist;
    	if($scope.typelist.length<=0){
    		layer.msg('暂无数据！', {time: 3000});
    		return false;
       	}
        $scope.active = $scope.typelist[0].id;
        var datas = '<?php echo $datas;?>';
    	if(datas==""){
    		$scope.list = [];
    	}else{
    		$scope.list = eval("(" + datas + ")");
    	}
    	var i = 0;
        var data = {};
        var data1 = {};
        angular.forEach($scope.goodslist, function (item) {
	        angular.forEach($scope.list, function (items) {
	        	if (item.id == items.id) {
	                $scope.confchil[item.id] = true;
	                $scope.checked.push(item.id);
	                //编号
	                $scope.confchil1[item.code] = true;
	                $scope.checked1.push(item.code);
	                //名称
	                $scope.confchil2[item.name] = true;
	                $scope.checked2.push(item.name);
	                //规格
	                $scope.confchil3[item.spec] = true;
	                $scope.checked3.push(item.spec);
	                //单位
	                $scope.confchil4[item.unit] = true;
	                $scope.checked4.push(item.unit);
	                //库存
	                $scope.confchil5[item.stock] = true;
	                $scope.checked5.push(item.stock);
	                //商品入库金额
	                $scope.confchil6[item.standardPrice] = true;
	                $scope.checked6.push(item.standardPrice);
	                //店铺编号
	                $scope.confchil7[item.typeName] = true;
	                $scope.checked7.push(item.typeName);
	                
	                $scope.confchil8[item.typeId] = true;
	                $scope.checked8.push(item.typeId);
	                
	                $scope.confchil9[item.maxPrice] = true;
	                $scope.checked9.push(item.maxPrice);
	            }
	        }) 
            data = countId($scope.goodslist);
            data1 = countId($scope.list);
            var t1 = data[item.typeId];
            var t2 = data1[$scope.goodslist[i].typeId];
            if(t1==t2){
            	$scope.conf[item.typeId] = true;
            }else{
               	$scope.conf[item.typeId] = false;
            }
            i++;
        }) 
    }).catch(function () { //捕捉错误处理
        layer.msg('服务端请求错误！', {time: 3000});
    });
    $scope.li_click = function (i) {
        $scope.active = i;
        var postData = {type: 'proList'};
        $http.post('../../Controller/psi/addMaterialStorageAction.php', postData).then(function (result) {  //正确请求成功时处理
        	$scope.typelist = result.data.typelist;
            $scope.goodslist = result.data.goodslist;
            var datas = '<?php echo $datas;?>';
        	if(datas==""){
        		$scope.list = [];
        	}else{
        		$scope.list = eval("(" + datas + ")");
        	}
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
    }
    $scope.selectAll = function (id) {
        if ($scope.conf[id]) {
            angular.forEach($scope.goodslist, function (item) {
                if (item.typeId == id) {
                	$scope.confchil[item.id] = true;
                    $scope.checked.push(item.id);
                    //编号
                    $scope.confchil1[item.code] = true;
                    $scope.checked1.push(item.code);
                    //名称
                    $scope.confchil2[item.name] = true;
                    $scope.checked2.push(item.name);
                    //规格
                    $scope.confchil3[item.spec] = true;
                    $scope.checked3.push(item.spec);
                    //单位
                    $scope.confchil4[item.unit] = true;
                    $scope.checked4.push(item.unit);
                    //库存
                    $scope.confchil5[item.stock] = true;
                    $scope.checked5.push(item.stock);
                    //商品入库金额
                    $scope.confchil6[item.standardPrice] = true;
                    $scope.checked6.push(item.standardPrice);
                    //类别
                    $scope.confchil7[item.typeName] = true;
                    $scope.checked7.push(item.typeName);
                    //类别
                    $scope.confchil8[item.typeId] = true;
                    $scope.checked8.push(item.typeId);

                    $scope.confchil8[item.maxPrice] = true;
                    $scope.checked8.push(item.maxPrice);
                }
            })
        } else {
            angular.forEach($scope.goodslist, function (item) {
                if (item.typeId == id) {
                    $scope.confchil[item.id] = false;
                    $scope.checked.splice($.inArray(item.id, $scope.checked), 1);

                    //编号
                    $scope.confchil1[item.code] = false;
                    $scope.checked1.splice($.inArray(item.code, $scope.checked1), 1);
                    //名称
                    $scope.confchil2[item.name] = false;
                    $scope.checked2.splice($.inArray(item.name, $scope.checked2), 1);
                    //规格
                    $scope.confchil3[item.spec] = false;
                    $scope.checked3.splice($.inArray(item.spec, $scope.checked3), 1);
                    //单位
                    $scope.confchil4[item.unit] = false;
                    $scope.checked4.splice($.inArray(item.unit, $scope.checked4), 1);
                    //库存
                    $scope.confchil5[item.stock] = false;
                    $scope.checked5.splice($.inArray(item.stock, $scope.checked5), 1);
                    //商品入库金额
                    $scope.confchil6[item.standardPrice] = false;
                    $scope.checked6.splice($.inArray(item.standardPrice, $scope.checked6), 1);
                    //商品类别
                    $scope.confchil7[item.typeName] = false;
                    $scope.checked7.splice($.inArray(item.typeName, $scope.checked7), 1);
                    //商品类别
                    $scope.confchil8[item.typeId] = false;
                    $scope.checked8.splice($.inArray(item.typeId, $scope.checked8), 1);

                    $scope.confchil9[item.maxPrice] = false;
                    $scope.checked9.splice($.inArray(item.maxPrice, $scope.checked9), 1);
                }
            })
        }
    }
    $scope.selectOne = function (partentId, id, code, name, spec, unit, stock, standardPrice,typeName,maxPrice) {
    	$scope.partentIdarr = [];
        $scope.arr = [];
        var index = $scope.checked.indexOf(id);
        var index1 = $scope.checked1.indexOf(code);
        var index2 = $scope.checked2.indexOf(name);
        var index3 = $scope.checked3.indexOf(spec);
        var index4 = $scope.checked4.indexOf(unit);
        var index5 = $scope.checked5.indexOf(stock);
        var index6 = $scope.checked6.indexOf(standardPrice);
        var index7 = $scope.checked7.indexOf(typeName);
        var index8 = $scope.checked8.indexOf(partentId);
        var index9 = $scope.checked9.indexOf(maxPrice);
        if ($scope.confchil[id] && index === -1) {
        	$scope.checked.push(id);
        	$scope.checked1.push(code);
        	$scope.checked2.push(name);
        	$scope.checked3.push(spec);
        	$scope.checked4.push(unit);
        	$scope.checked5.push(stock);
        	$scope.checked6.push(standardPrice);
        	$scope.checked7.push(typeName);
        	$scope.checked8.push(partentId);
        	$scope.checked9.push(maxPrice);
        } else if (!$scope.confchil[id] && index !== -1) {
            $scope.checked.splice(index, 1);
            $scope.checked1.splice(index1, 1);
        	$scope.checked2.splice(index2, 1);
        	$scope.checked3.splice(index3, 1);
        	$scope.checked4.splice(index4, 1);
        	$scope.checked5.splice(index5, 1);
        	$scope.checked6.splice(index6, 1);
        	$scope.checked7.splice(index7, 1);
        	$scope.checked8.splice(index8, 1);
        	$scope.checked9.splice(index9, 1);
        }
        angular.forEach($scope.goodslist, function (item) {
            if (item.typeId == partentId) {
            	$scope.partentIdarr.unshift(item.id);
            }
        })
        angular.forEach($scope.goodslist, function (item) {
            if ($scope.confchil[item.id] == true && item.typeId == partentId) {
            	$scope.childArr.unshift(item.id);
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
    $scope.AddMaterial = function(){
    	uniqueArray($scope.checked);
        var count = $scope.checked.length;
        if(count==0){
        	layer.msg('请选择原料', {time: 3000});
        	return false;
        }
        var datas = new Array();
        for (var i = 0; i < count; i++) {
            datas[i] = {};
            datas[i]['id'] = $scope.checked[i];
            datas[i]['code'] = $scope.checked1[i];
            datas[i]['name'] = $scope.checked2[i];
            datas[i]['spec'] = $scope.checked3[i];
            datas[i]['unit'] = $scope.checked4[i];
            datas[i]['stock'] = $scope.checked5[i];
            datas[i]['standardPrice'] = $scope.checked6[i];
            datas[i]['typeName'] = $scope.checked7[i];
            datas[i]['typeId'] = $scope.checked8[i];
            datas[i]['maxPrice'] = $scope.checked9[i];
        } 
        var postData = angular.toJson(datas);
        parent.layer.msg('恭喜你，添加成功', {icon: 6, time: 1500});
        $("#datas").val(postData);
        $("#sub").submit();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        //parent.location.href='editGoodsStorage.php?datas='+postData+'&type=list';
    }
    $scope.reMaterial = function(){
    	$scope.checked = [];
        $scope.checked1 = [];
        $scope.checked2 = [];
        $scope.checked3 = [];
        $scope.checked4 = [];
        $scope.checked5 = [];
        $scope.checked6 = [];
        $scope.checked7 = [];
        $scope.checked8 = [];
        $scope.checked9 = [];
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
	  if(count[data[i].typeId]){
	        count[data[i].typeId]++;
	        continue;
	    }
	    count[data[i].typeId]=1;
  }
  return count;
}
</script>
</body>
</html>