<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
if ($id != '') {
    $type = 'modify';
    $urlMif = $config_host . '/service/gds/material/getMaterialById';
    $datasMif = array('datas' => array('id' => $id));
    $jsonMif = http($urlMif, $datasMif, 1);
    $Mif = $jsonMif['datas']['materialVO'];
} else {
    $type = 'add';
}
$url = $config_host . '/service/gds/material/findMaterialTypeList';
$datas = array('datas' => array('stoId' => $_SESSION['stoId']));
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
$urlUnit = $config_host . '/service/gds/manage/storeUnitList';
$dataUnit = $datas = array('datas' => array('stoId' => $_SESSION['stoId'],'state'=>'1'));
$jsonUnit = http($urlUnit, $dataUnit, 1);
$unit = $jsonUnit['datas']['list'];
$unitNum = count($unit);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-原料编辑</title>
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
            <div class="wbox-content details-material">
                <form class="layui-form layui-form-pane">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><b>*</b>原料名称</label>
                        <div class="layui-input-inline" style="width: 260px;">
                            <input type="text" class="layui-input" ng-model="materialName" placeholder="请输入原料名称">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label"><b>*</b>原料分类</label>
                        <div class="layui-input-inline" style="width: 260px;">
                            <select class="layui-select" id="materialCategory">
                                <option value="">请选择原料分类...</option>
                                <?php for ($i = 0; $i < $num; $i++) { ?>
                                    <option value="<?php echo $list[$i]['id']; ?>"><?php echo $list[$i]['typeName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label"><b>*</b>单位</label>
                        <div class="layui-input-inline" style="width: 260px;">
                            <select class="layui-select" id="materialUnit">
                                <option value="">请选择原料单位...</option>
                                <?php for ($i = 0; $i < $unitNum; $i++) { ?>
                                    <option value="<?php echo $unit[$i]['name']; ?>"><?php echo $unit[$i]['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label">规格</label>
                        <div class="layui-input-inline" style="width: 260px;">
                            <input type="text" class="layui-input" placeholder="请输入原料规格" ng-model="specification">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>采购标准价</label>
                            <div class="layui-input-inline" style="width: 225px;">
                                <input type="text" class="layui-input" ng-model="Price" placeholder="请输入售价">
                            </div>
                            <span>元</span>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label"><b>*</b>采购最高价</label>
                            <div class="layui-input-inline" style="width: 225px;">
                                <input type="text" class="layui-input" ng-model="maxPrice" placeholder="请输入售价">
                            </div>
                            <span>元</span>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label">启用</label>
                            <div class="layui-input-block" style="width: 260px;">
                                <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive]">
                                    <input type="checkbox" ng-checked="isActive" ng-click="changeClass()"/>
                                    <i class="iconfont"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 12px;padding-left: 100px;">
                        <?php if ($type == 'add') { ?>
                            <input type="button" class="layui-btn layui-btn-small layui-btn-normal article-button" value="保存" ng-click="saveModal()"/>
                            <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModal()"/>
                        <?php } else { ?>
                            <input type="button" class="layui-btn layui-btn-small layui-btn-normal article-button" value="确认修改" ng-click="saveModal()"/>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        $scope.isActive=false;
        $scope.type = '<?php echo $type;?>';
        if ($scope.type == 'modify') {
            $scope.materialName = '<?php echo $Mif['name'];?>';
            $scope.materialCategory = '<?php echo $Mif['name'];?>';
            $scope.specification = '<?php echo $Mif['spec'];?>';
            $scope.Price = '<?php echo $Mif['standardPrice'];?>';
            $scope.maxPrice = '<?php echo $Mif['maxPrice'];?>';
            $('#materialCategory').val('<?php echo $Mif['typeId'];?>');
            $('#materialUnit').val('<?php echo $Mif['unit'];?>');
            var mifCheck = '<?php echo $Mif['openState'];?>';
            if (mifCheck == '1') {
                $scope.isActive=true;
            } else {
                $scope.isActive=false;
            }
        }
        $scope.saveModal = function () {
            if ($scope.isActive) {
                var check = 1;
            } else {
                var check = 0;
            }
            var materialCategory = $('#materialCategory').val();
            var materialUnit = $('#materialUnit').val();
            var postData = {
                type:  $scope.type,
                materialName: $scope.materialName,
                materialCategory: materialCategory,
                materialUnit: materialUnit,
                specification: $scope.specification,
                Price: $scope.Price,
                maxPrice: $scope.maxPrice,
                check: check
            };
            if($scope.type=='modify'){
                postData['mifId']='<?php echo $id;?>';
            }
            $http.post('../../Controller/material/detailsMaterialAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg(result.data.message, {icon: 6, time: 1500});
                    parent.location.reload();
                } else {
                    layer.msg(result.data.message, {time: 1500});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.resetModal = function () {
            $scope.materialName = '';
            $scope.specification = '';
            $scope.Price = '';
            $scope.maxPrice = '';
            $scope.checked = 'false';
            $('#materialCategory').val('');
            $('#materialUnit').val('');
        }
        $scope.changeClass = function () {$scope.isActive = !$scope.isActive}
    });
</script>
</body>
</html>