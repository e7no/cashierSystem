<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-新增折扣</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-content details-discount">
                <form class="layui-form layui-form-pane">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>折扣名称</label>
                            <div class="layui-input-inline" style="width: 440px;">
                                <input type="text" class="layui-input" ng-model="discountName" placeholder="请输入折扣名称">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>折扣百分比</label>
                            <div class="layui-input-inline" style="width: 160px;">
                                <input type="text" class="layui-input" ng-model="discountSet" placeholder="请输入折扣百分比"
                                       onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                <!--折扣百分比限制1到100-->
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>折扣方式</label>
                            <div class="layui-input-inline" style="width: 160px;">
                                <select class="layui-select"  ng-model="discountWay" ng-change="changediscountType(discountWay)">
                                    <option value="">请选择折扣方式...</option>
                                    <option value="1">全单打折</option>
                                    <option value="2">特定商品</option>
                                    <option value="3">第二件打折</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>开始时间</label>
                            <div class="layui-input-inline" style="width: 160px;">
                                <input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择开始时间" onchange=""
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'})">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>结束时间</label>
                            <div class="layui-input-inline" style="width: 160px;">
                                <input type="text" class="Wdate layui-input" ng-model="createDateEnd" id="logmax" placeholder="请选择结束时间" onchange=""
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'#F{$dp.$D(\'logmin\')}'})">
                            </div>
                        </div>
                    </div>
                    <div class="scope-goods" ng-show="discountType">
                        <h2>适用范围</h2>
                        <div class="sg-content">
                            <div class="sg-category">
                                <ul ng-repeat="item in lists | unique:'catId'">
                                    <li ng-if="item.catName!=''" ng-click='li_click(item.catId)' ng-class='{active: item.catId==active}'>
                                        <input type="checkbox" ng-model="$parent.conf[item.catId]" ng-click="selectAll(item.catId)"/>
                                        <span>{{item.catName}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="sg-list">
                                <ul>
                                    <li ng-repeat="items in lists | filter:{'catId':active}:true">
                                        <label>
                                            <input type="checkbox" ng-model="$parent.confchil[items.goodsId]" ng-change="selectOne(items.catId,items.goodsId)"/>
                                            <span>{{items.goodsName |limitTo:7}}</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--适用范围默认隐藏，选择全单打折隐藏，选择特定商品和第二件打折显示-->
                    <div class="layui-form-item" style="margin-top: 15px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal details-button" value="确定修改" ng-click="saveModal()"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['common']);
    app.controller('listController', function ($scope, $http) {
        var postData = {type: 'proList'};
        $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.lists = result.data.list;
            $scope.active = result.data.list[0].catId;
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.checked = [];
        $scope.conf = [];
        $scope.confchil = [];
        $scope.delArr = [];
        $scope.childArr = [];
        $scope.status = 0;
        var postDatas = {type: 'oneList', oneId: '<?php echo $id;?>'};
        $http.post('../../Controller/marketing/listDiscountAction.php', postDatas).then(function (result) {  //正确请求成功时处理
            $scope.discountName = result.data.list.name;
            $scope.discountWay=(result.data.list.type).toString() ;
            if(result.data.list.type==1){
                $scope.discountType=false;
            }else{
                $scope.discountType=true;
            }
            $scope.discountSet = parseInt(result.data.list.discount*100);
            $scope.createDateStart = result.data.list.startDate.substr(0,10);
            $scope.createDateEnd = result.data.list.endDate.substr(0,10);
            $scope.status = result.data.list.status;        
            var i = 0;
            var data = {};
            var data1 = {};
            angular.forEach(result.data.detail, function (item) {
            	if (item.goodsId == result.data.detail[i].goodsId) {
                    $scope.confchil[item.goodsId] = true;
                    $scope.checked.push(item.goodsId);
                }
            	data = countId(result.data.detail);
            	data1 = countId($scope.lists);
            	var t1 = data[result.data.detail[i].catId];
            	var t2 = data1[item.catId];
            	if(t1==t2){
            		$scope.conf[item.catId] = true;
               	}else{
               		$scope.conf[item.catId] = false;
                }
                i++;
            })
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.li_click = function (i) {$scope.active = i;}
        $scope.changediscountType=function(type){
            if(type=='1'){
                $scope.discountType=false;
            }else{
                $scope.discountType=true;
            }
        }
        $scope.selectAll = function (catId) {
            if ($scope.conf[catId]) {
                angular.forEach($scope.lists, function (item) {
                    if (item.catId == catId) {
                        $scope.confchil[item.goodsId] = true;
                        $scope.checked.push(item.goodsId);
                    }
                })
            } else {
                angular.forEach($scope.lists, function (item) {
                    if (item.catId == catId) {
                        $scope.confchil[item.goodsId] = false;
                        $scope.checked.splice($.inArray(item.goodsId, $scope.checked), 1);
                    }
                })
            }
        }
        $scope.selectOne = function (partentId, id) {
        	var partentIdarr = [];
            var index = $scope.checked.indexOf(id);
            if ($scope.confchil[id] && index === -1) {
                $scope.checked.push(id);
            } else if (!$scope.confchil[id] && index !== -1) {
                $scope.checked.splice(index, 1);
            }
            angular.forEach($scope.lists, function (item) {
                if (item.catId == partentId) {
                    partentIdarr.push(item.goodsId);
                }
            })
            
            angular.forEach($scope.lists, function (item) {
                 if ($scope.confchil[item.goodsId]==true && item.catId == partentId) {
                     $scope.childArr.unshift(item.goodsId);
                 }
            })
            uniqueArray($scope.childArr);
            if (partentIdarr.length === $scope.childArr.length && partentIdarr.sort().toString()!= $scope.childArr.sort().toString()) {
            	$scope.childArr.shift();
            	$scope.conf[partentId] = false;
            }else if (partentIdarr.sort().toString()== $scope.childArr.sort().toString()) {
                $scope.conf[partentId] = true;
                $scope.childArr=[];
        	} else {
        		$scope.childArr.shift();
        		if (partentIdarr.length === $scope.childArr.length && partentIdarr.sort().toString()!= $scope.childArr.sort().toString()) {
                	$scope.childArr.shift();
                	$scope.conf[partentId] = true;
                	$scope.childArr=[];
                }else{
                	$scope.conf[partentId] = false;
                }
            }
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
        $scope.saveModal = function () {
            var postData = {
                type: 'modify',
                sid: '<?php echo $id;?>',
                name: $scope.discountName,
                discount: parseInt($scope.discountSet),
                types:  $scope.discountWay,
                startDate: $scope.createDateStart,
                endDate: $scope.createDateEnd,
                goodsList: $scope.checked.unique3()
            }
            if( $scope.discountWay=='2' ||  $scope.discountWay=='3' ){
                if($scope.checked.unique3()==''){
                    layer.msg('请选择折扣商品！', {time: 3000});
                    return;
                }
            }
            $http.post('../../Controller/marketing/listDiscountAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('恭喜你，修改成功！', {icon: 6, time: 1500});
                    parent.location.reload();
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
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
    function uniqueArray(data){  
  	   data = data || [];  
  	   var a = {};  
  	   for (var i=0; i<data.length; i++) {  
  	       var v = data[i];  
  	       if (typeof(a[v]) == 'undefined'){  
  	            a[v] = 1;  
  	       }  
  	   };  
  	   data.length=0;  
  	   for (var i in a){  
  	        data[data.length] = i;  
  	   }  
  	   return data;  
  	} 
    //检查某一元素在数组中出现的次数
    function countId(data){
	  var count={};
	  for(var i=0;i<data.length;i++){
	    if(count[data[i].catId]){
	        count[data[i].catId]++;
	        continue;
	    }
	    count[data[i].catId]=1;
	  }
	  return count;
	}
</script>
</body>
</html>