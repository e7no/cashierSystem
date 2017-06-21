<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$url = $config_host . '/service/sto/manage/roleList/' . $_SESSION['stoId'];
$strrole = http($url, '', 1);
$role_list = $strrole['datas']['stoRoleVOList'];
$role_num = count($role_list);
$stoType = $_SESSION['stoType'];
if ($stoType==1) {
    $url = $config_host . '/service/sto/manage/stoList';
    $data['datas']['pid'] = $_SESSION['stoId'];
    $json = http($url, $data, 1);
    $str= $json['datas']['list'];
    $sto_num = count($str);
} else {
    $str[0]['stoId'] = $_SESSION['stoId'];
    $str[0]['name'] = $_SESSION['stoName'];
    $sto_num = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-员工管理</title>
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
                        <label class="layui-form-label">快速查找</label>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="text" class="layui-input" placeholder="请输入查的找员工姓名" ng-model="name">
                        </div>
                        <div class="layui-input-inline" style="width: 180px;">
                            <input type="number" class="layui-input" placeholder="请输入查的找员工手机" ng-model="mobile">
                        </div>
                    </div>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" ng-click="reSearch()" value="查询"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" ng-click="resetSearch()" value="重置"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>员工列表</h5>
                <div class="ibox-tools">
                    <a class="btn-blue new-btn" ng-click="addModal()">新增</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 800px;">
                        <thead>
                        <tr class="text-c">
                            <!--                            <th width="8%">序号</th>-->
                            <th width="15%">员工姓名</th>
                            <th width="15%">员工手机</th>
                            <th width="28%">所属门店</th>
                            <th width="15%">员工岗位</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <!--                            <td>{{item.empId}}</td>-->
                            <td>{{item.empName}}</td>
                            <td>{{item.mobile}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.roleName}}</td>
                            <td>
                                <a class="btn-green" ng-click="modifyModal(item)">修改</a>
                                <a class="btn-red del-btn" ng-click="delete(item)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--新增员工-->
    <div class="popup staff-popup" id="add">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">选择门店</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <select class="layui-input" ng-model="addData.stoId">
                            <option value="">请选择...</option>
                            <?php for ($i = 0; $i < $sto_num; $i++) { ?>
                                <option value="<?php echo $str[$i]['stoId']; ?>"><?php echo $str[$i]['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">&nbsp;员工岗位</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <select class="layui-input" ng-model="addData.roleId">
                            <option value="">请选择...</option>
                            <?php for ($i = 0; $i < $role_num; $i++) { ?>
                                <option value="<?php echo $role_list[$i]['id'] ?>"><?php echo $role_list[$i]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">员工姓名</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" class="layui-input" placeholder="请输入员工姓名" ng-model="addData.empName"/>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">&nbsp;员工手机</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="number" class="layui-input" placeholder="请输入员工手机" ng-model="addData.mobile"/>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal staff-btn" value="保存" ng-click="dealModal(addData)"/>
                <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置"/>
            </div>
        </form>
    </div>
    <!--修改员工-->
    <div class="popup staff-popup " id="modify">
        <form class="layui-form">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">选择门店</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <select class="layui-input" ng-model="modalData.stoId">
                            <?php for ($i = 0; $i < $sto_num; $i++) { ?>
                                <option value="<?php echo $str[$i]['stoId']; ?>"><?php echo $str[$i]['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">&nbsp;员工岗位</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <select class="layui-input" ng-model="modalData.roleId">
                            <?php for ($i = 0; $i < $role_num; $i++) { ?>
                                <option value="<?php echo $role_list[$i]['id'] ?>"><?php echo $role_list[$i]['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <div class="layui-inline">
                    <label class="layui-form-label">员工姓名</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" class="layui-input" placeholder="请输入员工姓名" ng-model="modalData.empName">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">&nbsp;员工手机</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" class="layui-input" placeholder="请输入员工手机" ng-model="modalData.mobile">
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 10px;">
                <label class="layui-form-label">&#12288;&#12288;&#12288;&#12288;</label>
                <input type="button" class="layui-btn layui-btn-small layui-btn-normal staff-btn" value="保存" ng-click="dealModal(modalData)"/>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', ['tm.pagination']);
    app.controller('listController', function ($scope, $http) {
        var reSearch = function () {
            var postData = {
                type: 'list',
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                name: $scope.name,
                mobile: $scope.mobile
            };
            $http.post('../../Controller/staff/staffManageAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch=function (){$scope.name='';$scope.mobile='';}
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.modifyModal = function (item) {//修改员工信息
            layer.open({type: 1, title: "员工信息修改", area: ['480px', '190px'], shadeClose: true, resize: false, content: $("#modify"),});
            $scope.modalData = item;
            $scope.type = 'modify';
        };
        $scope.addModal = function () {//添加员工
            layer.open({type: 1, title: "添加员工", area: ['480px', '190px'], shadeClose: true, resize: false, content: $("#add"),});
            $scope.type = 'add';
            $scope.addData = {};
        }
        $scope.dealModal = function (Data) {//员工信息修改
            var postData = {
                type: $scope.type,
                id: Data.empId,
                stoIdstaff:Data.stoId,
                name: Data.empName,
                mobile: Data.mobile,
                roleId: Data.roleId
            };
            $http.post("../../Controller/staff/staffManageAction.php", postData).then(function (result) {
                if (result.data.success) {
                    layer.closeAll('page'); //关闭弹层
                    layer.msg(result.data.message, {icon: 6, time: 1000});
                    return reSearch();
                } else {
                    layer.msg(result.data.message, {time: 2000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.delete = function (item) { //员工删除
            var postData = {type: 'del', id: item.empId};
            layer.alert('亲，您确定删除该员工吗？', {icon: 5, title: "删除", resize: false,}, function () {
                $http.post("../../Controller/staff/staffManageAction.php", postData).then(function (result) {
                    if (result.data.success) {
                        layer.msg(result.data.message, {icon: 6, time: 1000});
                        return reSearch();
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('服务端请求错误！', {time: 3000});
                });
            });
        };
    })
</script>
</body>
</html>