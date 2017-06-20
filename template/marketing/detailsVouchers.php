<?php
include('../../Common/check.php');
$id = $_GET['id'];
if ($id == '') {
    echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新查询！\',{icon: 5,time:2000});</script>';
    exit;
}
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
                        <label class="layui-form-label">使用状态</label>
                        <div class="layui-input-inline">
                            <select class="layui-input" ng-model="states">
                                <option value="">请选择...</option>
                                <option value="0">未使用</option>
                                <option value="1">已使用</option>
                                <option value="2">已过期</option>
                            </select>
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>优惠券</h5>
                <div class="ibox-tools">
                    <a class="btn-green" id="excel">导出</a>
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
                            <th width="20%">券码</th>
                            <th width="12%">优惠券类型</th>
                            <th width="12%">面额</th>
                            <th>使用条件</th>
                            <th width="20%">有效期</th>
                            <th width="10%">使用状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.password}}</td>
                            <td>线上</td>
                            <td>{{item.faceValue | number:2}}</td>
                            <td ng-if="item.useCond==''">无条件使用</td>
                            <td ng-if="item.useCond!=''">满{{item.useCond}}元使用</td>
                            <td>{{item.startDate|limitTo:10}} 至 {{item.endDate|limitTo:10}}</td>
                            <td class="c-green" ng-if="item.useState==0">未使用</td>
                            <td class="c-blue" ng-if="item.useState==1">已使用</td>
                            <td class="c-red" ng-if="item.useState==2">已过期</td>
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
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'delist',
                setId: '<?php echo $id;?>',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
            };
            if ($scope.states != '') {
                postData['states'] = $scope.states;
            }
            $http.post('../../Controller/marketing/listVouchersAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.states = '';
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.addModal = function () {
            layer.open({type: 1, title: "新增", area: ['415px', '190px'], shadeClose: true, resize: false, content: $("#add"),});
        }
        $('#excel').click(function () {
            var setId = '<?php echo $id;?>';
            var states ='';
            if ($scope.states != '' && !angular.isUndefined($scope.states)) {
                states = $scope.states;
            }
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listVouchersExcel.php?setId=' + setId + '&states=' + states;
        });
    });
    //导出Excel

</script>
</body>
</html>