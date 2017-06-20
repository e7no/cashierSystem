<?php
include('../../Common/check.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-优惠券</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
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
                        <label class="layui-form-label">面额</label>
                        <div class="layui-input-inline" style="width: 160px;">
                            <input type="text" class="layui-input" ng-model="price" placeholder="请输入查找的代金券面额">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">截止时间</label>
                        <div class="layui-input-inline" style="width: 156px;">
                            <input type="text" class="Wdate layui-input" id="logmin" ng-model="startDate" placeholder="请选择开始时间"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 156px;">
                            <input type="text" class="Wdate layui-input" id="logmax" ng-model="endDate" placeholder="请选择结束时间"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>优惠券</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">新增优惠券</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1000px;">
                        <thead>
                        <tr class="text-c">
                            <th width="10%">名称</th>
                            <th width="10%">优惠券类型</th>
                            <th width="10%">面额</th>
                            <th width="10%">数量</th>
                            <th width="15%">使用条件</th>
                            <th width="20%">有效期</th>
                            <th width="10%">详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.name}}</td>
                            <td>线下</td>
                            <td>{{item.faceValue| number:2}}</td>
                            <td>{{item.total}}</td>
                            <td ng-if="item.useCond!=0">满{{item.useCond}}元使用</td>
                            <td ng-if="item.useCond==0">无条件使用</td>
                            <td>{{item.startDate | limitTo:10}} 至 {{item.endDate | limitTo:10}}</td>
                            <td><a class="btn-blue details-btn" ng-click="checkModal(item.id)">查看</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--新增、编辑-->
    <div class="popup new-open" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">名&#12288;&#12288;称</label>
                    <div class="layui-input-inline" style="width: 314px;">
                        <input name="title" placeholder="请输入生成代金券的批次标识或名称" class="layui-input" ng-model="Vname" type="text" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">生成数量</label>
                    <div class="layui-input-inline" style="width: 120px;">
                        <input name="title" placeholder="生成数量" class="layui-input" ng-model="Vnum" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">有效期至</label>
                    <div class="layui-input-inline" style="width: 120px;">
                        <input type="text" class="Wdate layui-input" ng-model="Vdate" id="logmin" placeholder="使用期限" onchange=""
                               onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'})">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">面&#12288;&#12288;额</label>
                    <div class="layui-input-inline" style="width: 120px;">
                        <input name="title" placeholder="生成面额" class="layui-input" ng-model="Vprice" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">使用条件</label>
                    <div class="layui-input-inline" style="width: 120px;">
                        <input name="title" placeholder="限制条件" class="layui-input" ng-model="Vstate" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal baocun-btn" value="保存" ng-click="saveModal()">
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetM()"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript" src="../../js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                faceValue: $scope.price,
                endDateStart: $scope.startDate,
                endDateEnd: $scope.endDate,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/marketing/listVouchersAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.price = undefined;
            $scope.startDate = undefined;
            $scope.endDate = undefined;
            $scope.state = undefined
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {
            $scope.Vname='';
            $scope.Vprice='';
            $scope.Vstate='';
            $scope.Vdate='';
            $scope.Vnum='';
            layer.open({type: 1, title: "新增", area: ['415px', '240px'], shadeClose: true, resize: false, content: $("#add"),});
        }
        $scope.checkModal = function (id) {layer.open({type: 2, title: "代金券详情", area: ['100%', '100%'], shadeClose: true, resize: false, offset: ['0', '0'], content: 'detailsVouchers.php?id='+id,});}
        $scope.saveModal=function(){
            if($scope.Vstate==0 ||$scope.Vstate=='0'){
                $scope.Vstate='';
            }
            if($scope.Vstate!=''){
                if(parseInt($scope.Vstate)<=parseInt($scope.Vprice)){
                    layer.msg('使用条件需要大于面额，请重新填写！',{icon: 6,time:1000});
                    return;
                }
            }
            var postData = {
                type: 'add',
                name: $scope.Vname,
                faceValue: $scope.Vprice,
                useCond: $scope.Vstate,
                endDate: $scope.Vdate,
                total: $scope.Vnum,
            };
            $http.post('../../Controller/marketing/listVouchersAction.php', postData).then(function (result) {  //正确请求成功时处理
               if(result.data.success){
                   layer.closeAll('page'); //关闭弹层
                   layer.msg('恭喜你，代金券生成成功！',{icon: 6,time:1000});
                   return reSearch();
               }else{
                   layer.msg(result.data.message,{icon: 6,time:1000});
               }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetM=function(){$scope.Vname='';$scope.Vprice='';$scope.Vstate='';$scope.Vdate='';$scope.Vnum='';}
    });
</script>
</body>
</html>