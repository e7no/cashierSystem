<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/gds/material/findMaterialTypeList';
$datas = array('datas' => array('stoId' => $_SESSION['sotId']));
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-原料列表-回收站</title>
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
                        <label class="layui-form-label">原料分类</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="mtypeId">
                                <option value="">请选择...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['typeName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">快速查找</label>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" class="layui-input" placeholder="请输入查找的原料名称/编码" ng-model="quickSearch"">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>原料列表</h5>
                <div class="ibox-tools">
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1500px;">
                        <thead>
                        <tr class="text-c">
                            <th width="13%">编码</th>
                            <th class="text-l" width="12%">名称</th>
                            <th width="9%">所属分类</th>
                            <th width="4%">单位</th>
                            <th width="9%">规格</th>
                            <th width="7%">采购标准价</th>
                            <th width="7%">采购最高价</th>
                            <th width="5%">状态</th>
                            <th width="11%">修改时间</th>
                            <th width="8%">操作员</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.code}}</td>
                            <td class="text-l">{{item.name}}</td>
                            <td>{{item.typeName}}</td>
                            <td>{{item.unit}}</td>
                            <td>{{item.spce}}</td>
                            <td>{{item.standardPrice}}</td>
                            <td>{{item.maxPrice}}</td>
                            <td class="c-green" ng-if="item.openState==1">启用</td>
                            <td class="c-red" ng-if="item.openState==0">关闭</td>
                            <td>{{item.modifyDate}}</td>
                            <td>{{item.createName}}</td>
                            <td>
                                <a class="btn-blue restore-btn" ng-click="recoverModal(item.id)">恢复</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<!--	<script type="text/javascript" src="../../js/recycleMaterial.js"></script>-->
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                mtypeId: $scope.mtypeId,
                quickSearch: $scope.quickSearch,
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            $http.post('../../Controller/material/recycleMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {$scope.mtypeId='';$scope.quickSearch='';}
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.recoverModal=function(id){
            var postData = {type: 'recover',rid:id};
            layer.alert('确认恢复该原料吗？', {icon: 3, title: "原料恢复", resize: false,}, function(index){
                $http.post('../../Controller/material/recycleMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                  if(result.data.success){
                      var index = parent.layer.getFrameIndex(window.name);
                      parent.layer.close(index);
                      parent.layer.msg('恭喜你，添恢复成功！',{icon: 6,time:2000});
                      parent.location.reload();
                  }else{
                      layer.msg(result.data.message, {time: 3000});
                  }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        }
    });
</script>
</body>
</html>