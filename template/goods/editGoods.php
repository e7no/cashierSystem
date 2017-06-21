<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
$id = $_GET['id'];
$t = $_GET['t'];
$page = $_GET['page'];
$CatId = $_GET['CatId'];
$StoType = $_GET['StoType'];
$quick = $_GET['quick'];
if ($id == '') {
    echo '<script> var index=parent.layer.getFrameIndex(window.name);parent.layer.close(index);parent.layer.msg(\'查询错误，请刷新后重新查询！\',{icon: 5,time:2000});</script>';
    exit;
}
$urlUnit = $config_host . '/service/gds/manage/storeUnitList';
$dataUnit = $datas = array('datas' => array('stoId' => $_SESSION['stoId'], 'state' => '1'));
$jsonUnit = http($urlUnit, $dataUnit, 1);
$unit = $jsonUnit['datas']['list'];
$unitNum = count($unit);
$url = $config_host . '/service/gds/manage/category/list';
$datas = array('datas' => array('stoId' => $_SESSION['stoId'], 'status' => '0'));
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
    <title>汇汇生活商家后台-商品编辑</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css?v=2.1"/>
    <script src="../../js/angular.min.js"></script>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-content article-goods">
                <form class="layui-form layui-form-pane" id='myupload' action='../../Controller/goods/upload.php' method='post' enctype='multipart/form-data'>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><b>*</b>商品名称</label>
                                <div class="layui-input-inline" style="width: 224px;">
                                    <input type="text" class="layui-input" ng-model="GoodName" placeholder="请输入商品名称" autocomplete="off" ng-disabled="t">
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 10px;">
                                <div class="layui-inline">
                                    <label class="layui-form-label"><b>*</b>商品分类</label>
                                    <div class="layui-input-inline" style="width: 224px;">
                                        <select class="layui-select" ng-model="GoodsCategory" id="catId" ng-disabled="t">
                                            <option value="">请选择商品分类...</option>
                                            <?php for ($i = 0; $i < $num; $i++) { ?>
                                                <option value="<?php echo $list[$i]['catId']; ?>"><?php echo $list[$i]['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 10px;">
                                <label class="layui-form-label"><b>*</b>单位</label>
                                <div class="layui-input-inline" style="width: 224px;">
                                    <select class="layui-select" ng-model="GoodUnit" id="unitVal" ng-disabled="t">
                                        <option value="">请选择商品单位...</option>
                                        <?php for ($i = 0; $i < $unitNum; $i++) { ?>
                                            <option value="<?php echo $unit[$i]['name']; ?>"><?php echo $unit[$i]['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 10px;">
                                <label class="layui-form-label">保质期</label>
                                <div class="layui-input-inline" style="width: 224px;">
                                    <input type="text" class="layui-input" placeholder="请输入商品保质期" ng-model="LaterTime" autocomplete="off" ng-disabled="t">
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 10px;">
                                <label class="layui-form-label">条形码</label>
                                <div class="layui-input-inline" style="width: 224px;">
                                    <input type="text" class="layui-input" placeholder="请输入商品条形码" ng-model="barCode" autocomplete="off" ng-disabled="t">
                                </div>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="article-img">
                                <span id="imglist" style="margin: 0;padding: 0;width:230px;height: 230px;"><img style="width:230px;height: 230px;" ng-show="isImg" src="../../img/upload.gif"/></span>
                                <input type="file" id="upload" multiple="" accept="image/jpeg,image/jpg,image/png"
                                       onchange="angular.element(this).scope().img_upload(this.files)" style="display:none;"/>
                                <input type="button" onclick="upload.click()" class="img-btn" value="上传图片" ng-disabled="t"/>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">上架</label>
                            <div class="layui-input-block" style="width: 60px;margin-left: 80px;">
                                <div ng-class="{true: 'will-check active', false: 'will-check'}[isPutaway]">
                                    <input type="checkbox" ng-checked="isPutaway" ng-click="changeClass('isPutaway')"/>
                                    <i class="iconfont"></i>
                                </div>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label" style="width: 80px;">称重</label>
                            <div class="layui-input-block" style="width: 60px;margin-left: 80px;">
                                <div ng-class="{true: 'will-check active', false: 'will-check'}[isWeigh]">
                                    <input type="checkbox" ng-checked="isWeigh" ng-click="changeClass('isWeigh')"/>
                                    <i class="iconfont"></i>
                                </div>
                            </div>
                        </div>
                        <div class="layui-inline">
							<label class="layui-form-label" style="width: 80px;">减库存</label>
							<div class="layui-input-block" style="width: 60px;margin-left: 80px;">
								<div ng-class="{true: 'will-check active', false: 'will-check'}[stockManage]">
                                    <input type="checkbox" ng-checked="stockManage" ng-click="changeClass('stockManage')" ng-disabled="t"/>
                                    <i class="iconfont"></i>
                                </div>
							</div>
						</div>
						<div class="layui-inline">
							<label class="layui-form-label" style="width: 80px;">临时菜</label>
							<div class="layui-input-block" style="width: 60px;margin-left: 80px;">
								<div ng-class="{true: 'will-check active', false: 'will-check'}[temporary]">
                                    <input type="checkbox" ng-checked="temporary" ng-click="changeClass('temporary')" ng-disabled="t"/>
                                    <i class="iconfont"></i>
                                </div>
							</div>
						</div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="con-table">
                            <table class="layui-table detail-table" style="width: 561px;">
                                <thead>
                                <tr class="text-c">
                                    <th>规格</th>
                                    <th width="19%">进价</th>
                                    <th width="19%">收银价</th>
                                    <th width="19%">商城价</th>
                                    <th width="18%">积分价</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-c">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div ng-class="{true: 'will-check active', false: 'will-check'}[isPrice]">
                                            <input type="checkbox" ng-checked="isPrice" ng-click="changeClass('isPrice')" ng-disabled="t"/>
                                            <i class="iconfont"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div ng-class="{true: 'will-check active', false: 'will-check'}[isStore]">
                                            <input type="checkbox" ng-checked="isStore" ng-click="changeClass('isStore')" ng-disabled="t"/>
                                            <i class="iconfont"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div ng-class="{true: 'will-check active', false: 'will-check'}[isIntegral]">
                                            <input type="checkbox" ng-checked="isIntegral" ng-click="changeClass('isIntegral')" ng-disabled="t"/>
                                            <i class="iconfont"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-c" id="tab-len" ng-repeat="i in range(num) track by $index">
                                    <td><input type="text" class="layui-input" ng-model="$parent.standard[$index]" placeholder="规格" autocomplete="off"
                                               ng-disabled="t"/></td>
                                    <td><input type="number" class="layui-input" ng-model="$parent.purchaseing[$index]" placeholder="进价" autocomplete="off"
                                               ng-change="checkNum1(this.purchaseing[$index],$index)" onkeyup="if(isNaN(value))execCommand('undo')"
                                               onafterpaste="if(isNaN(value))execCommand('undo')"
                                               ng-disabled="t"/></td>
                                    <td><input type="number" class="layui-input" ng-model="$parent.collect[$index]" placeholder="收银价" ng-show="isPrice"
                                               ng-change="checkNum2(this.collect[$index],$index)"
                                               autocomplete="off" onkeyup="if(isNaN(value))execCommand('undo')"
                                               onafterpaste="if(isNaN(value))execCommand('undo')"
                                               autocomplete="off"></td>
                                    <td><input type="number" class="layui-input" ng-model="$parent.shopping[$index]" placeholder="商城价" ng-show="isStore"
                                               ng-change="checkNum3(this.shopping[$index],$index)"
                                               autocomplete="off" onkeyup="if(isNaN(value))execCommand('undo')"
                                               onafterpaste="if(isNaN(value))execCommand('undo')"
                                               autocomplete="off"></td>
                                    <td><input type="number" class="layui-input" ng-model="$parent.integration[$index]" placeholder="积分价" ng-show="isIntegral"
                                               ng-change="checkNum4(this.integration[$index],$index)"
                                               autocomplete="off" onkeyup="if(isNaN(value))execCommand('undo')"
                                               onafterpaste="if(isNaN(value))execCommand('undo')"
                                               autocomplete="off">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-form-item tab-btn" style="margin-top: -5px;" ng-hide="t">
                            <a class="add-tab" ng-click="dealNumModal(true)" ng-hide="addNum"><i class="iconfont will-jia"></i>添加规格（最多3个）</a>
                            <a class="del-tab" ng-click="dealNumModal(false)" ng-hide="reduceNum"><i class="iconfont will-desc"></i>删除</a>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 15px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal article-button" value="修改" ng-click="saveModal()"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery.form.min.js"></script>
<script type="text/javascript" src="../../js/layer/layer.min.js"></script>
<script type="text/javascript">
    var app = angular.module('myApp', []);
    app.controller('listController', function ($scope, $http) {
        var tt = '<?php echo $t;?>';
        if (tt == '1') {
            $scope.t = false;
        } else {
            $scope.t = true;
        }
        $scope.isImg = false;
        $scope.uplo = true;
        $scope.standardids = [];
        $scope.standard = [];
        $scope.purchaseing = [];
        $scope.collect = [];
        $scope.shopping = [];
        $scope.integration = [];
        $scope.isUpload = false;
        var postData = {
            type: 'detail',
            dId: '<?php echo $id;?>'
        };
        $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
            $scope.filePath = result.data.filePath;
            if (result.data.sku.length == 0) {
                $scope.num = 1;
                $scope.purchaseing.push(result.data.list.inPrice);
                $scope.collect.push(result.data.list.salePrice);
                $scope.shopping.push(result.data.list.takeOutPrice);
                $scope.integration.push(result.data.list.integral);
            } else {
                $scope.num = result.data.sku.length;
            }
            if ($scope.num == 1) {
                $scope.reduceNum = true;
            }
            if ($scope.num == 3) {
                $scope.addNum = true;
            } else {
                $scope.addNum = false;
            }
            $scope.GoodName = result.data.list.name;
            $scope.barCode = result.data.list.barCode;
            $scope.GoodsCategory = result.data.list.catId;
            $scope.GoodUnit = result.data.list.unit;
            $scope.LaterTime = result.data.list.bzq;
            $scope.picture = result.data.list.bigImagePath;
            var url = $scope.filePath + '/' + result.data.list.bigImagePath;
            if(result.data.list.bigImagePath!=''){
                $('#imglist').html('<img style="width:230px;height:230px;" src="' + url + '">');
            }
            if (result.data.list.status == 0) {
                $scope.isPutaway = true;
            } else {
                $scope.isPutaway = false;
            }
            if (result.data.list.weight == 1) {
                $scope.isWeigh = true;
            } else {
                $scope.isWeigh = false;
            }
            if (result.data.list.stockManage == 1) {
                $scope.stockManage = true;
            } else {
                $scope.stockManage = false;
            }
            if (result.data.list.temporary == 1) {
                $scope.temporary = true;
            } else {
                $scope.temporary = false;
            }
            if (result.data.list.saleStatus == 1) {
                $scope.isPrice = true;
            } else {
                $scope.isPrice = false;
            }
            if (result.data.list.takeOut == 1) {
                $scope.isStore = true;
            } else {
                $scope.isStore = false;
            }
            if (result.data.list.useIntegral == 1) {
                $scope.isIntegral = true;
            } else {
                $scope.isIntegral = false;
            }
            angular.forEach(result.data.sku, function (item) {
                $scope.standardids.push(item.id);
                $scope.standard.push(item.name);
                $scope.purchaseing.push(item.inPrice);
                $scope.collect.push(item.salePrice);
                $scope.shopping.push(item.takeOutPrice);
                $scope.integration.push(item.integral);
            })
        }).catch(function () { //捕捉错误处理
            layer.msg('服务端请求错误！', {time: 3000});
        });
        $scope.reader = new FileReader();   //创建一个FileReader接口
        $scope.img_upload = function (files) {       //单次提交图片的函数
            var type=files[0].type;
            if(type!='image/png' && type!='image/jpg'&& type!='image/jpeg'){
                layer.msg("请上传PNG/JPG/JPEG图片格式", {time: 3000});
                return false;
            }
            $scope.uplo = false;
            $('#imglist').html('<img style="width:230px;height: 230px;" ng-show="isImg" src="../../img/upload.gif"/>');
            $scope.isImg = true;
            $scope.isUpload = true;
            $scope.guid = (new Date()).valueOf();   //通过时间戳创建一个随机数，作为键名使用
            $scope.reader.readAsDataURL(files[0]);  //FileReader的方法，把图片转成base64
            $scope.reader.onload = function (ev) {
                var postData = {
                    type: '1',
                    img: $scope.guid,
                    imgPath: ev.target.result,
                };
                $http.post('../../Controller/goods/upload.php', postData).then(function (result) {  //正确请求成功时处理
                    var id = 'img' + $scope.guid;
                    if (result.data.success) {
                        $scope.uplo = true;
                        $scope.isImg = false;
                        var imgUrl = result.data.result[id].url;
                        var fileName = result.data.result[id].fileName;
                        $scope.picture = result.data.subdirectory + '/' + fileName;
                        var attstr = '<img style="width:230px;height:230px;" src="' + imgUrl + '">';
                        $('#imglist').html(attstr);
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('上传图片格式有误,请换张图片再试！！', {time: 3000});
                });
            };
        }
        $scope.range = function (n) {
            return new Array(n);
        }
        $scope.dealNumModal = function (Boole) {
            $scope.reduceNum = false;
            if (Boole) {
                $scope.num = $scope.num + 1;
                if ($scope.num == 3) {
                    $scope.addNum = true;
                } else {
                    $scope.addNum = false;
                }
            } else {
                $scope.addNum = false;
                $scope.num = $scope.num - 1;
                if ($scope.num == 1) {
                    $scope.reduceNum = true;
                } else {
                    $scope.reduceNum = false;
                }
            }
        }
        $scope.checkNum1 = function (num,index) {
            if(num>100000){
                $scope.purchaseing[index]='';
                layer.msg('进价最大值不能超过10万！', {time: 3000});
                return;
            }
        }
        $scope.checkNum2 = function (num,index) {
            if(num>100000){
                $scope.collect[index]='';
                layer.msg('收银价最大值不能超过10万！', {time: 3000});
                return;
            }
        }
        $scope.checkNum3 = function (num,index) {
            if(num>100000){
                $scope.shopping[index]='';
                layer.msg('商城价最大值不能超过10万！', {time: 3000});
                return;
            }
        }
        $scope.checkNum4 = function (num,index) {
            if(num>100000){
                $scope.integration[index]='';
                layer.msg('积分价最大值不能超过10万！', {time: 3000});
                return;
            }
        }
        $scope.saveModal = function () {
            var postData = {
                type: 'modify',
                id: '<?php echo $id;?>',
                catId: $scope.GoodsCategory ? $scope.GoodsCategory : undefined,
                name: $scope.GoodName,
                num: $scope.num,
                unit: $scope.GoodUnit,
                barCode: $scope.barCode,
                status: $scope.isPutaway ? 0 : 1,
                bigImagePath: $scope.picture,
                weight: $scope.isWeigh ? 1 : 0,
                stockManage: $scope.stockManage ? 1 : 0,
                temporary: $scope.temporary ? 1 : 0,
                bzq: $scope.LaterTime,
                saleStatus: $scope.isPrice ? 1 : 0,
                takeOut: $scope.isStore ? 1 : 0,
                useIntegral: $scope.isIntegral ? 1 : 0,
                ids: $scope.standardids,
                norms: $scope.standard,
                inPrice: $scope.purchaseing,
                salePrice: $scope.collect,
                takeOutPrice: $scope.shopping,
                integral: $scope.integration,
            };
            if (!$scope.uplo) {
                layer.msg('图片尚未上传完成,请稍等！', {time: 3000});
                return;
            }
            if ($scope.isPrice == 0) {
                postData['salePrice'] = [];
            }
            if ($scope.isStore == 0) {
                postData['takeOutPrice'] = [];
            }
            if ($scope.isIntegral == 0) {
                postData['integral'] = [];
            }
            var page = '<?php echo $page?>';
            var CatId = '<?php echo $CatId?>';
            var StoType = '<?php echo $StoType?>';
            var quick = '<?php echo $quick?>';
            $http.post('../../Controller/goods/listGoodsAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('恭喜你，修改成功！', {icon: 6, time: 1500});
                    //parent.location.reload();
                    parent.location.href='listGoods.php?v=1.0&page=' + page + '&CatId=' + CatId + '&StoType=' + StoType + '&quick=' + quick;
                    //return window.parent.reSearch();
                } else {
                    layer.msg(result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
//        $scope.resetModal = function () {
//            $scope.GoodName = '';
//            $scope.GoodsCategory = undefined;
//            $scope.GoodsCategory = undefined;
//            $scope.LaterTime = '';
//            $scope.barCode = '';
//            $scope.isPutaway = false;
//            $scope.isWeigh = false;
//            $scope.isPrice = false;
//            $scope.isStore = false;
//            $scope.isIntegral = false;
//            $scope.addNum = false;
//            $scope.reduceNum = true;
//            $scope.num = 1;
//            $scope.standard = [];
//            $scope.purchaseing = [];
//            $scope.collect = [];
//            $scope.shopping = [];
//            $scope.integration = [];
//            $scope.picture='';
//            $('#imglist img').remove();
//        }
        $scope.changeClass = function (type) {
            if (type == 'isPutaway') {
                $scope.isPutaway = !$scope.isPutaway
            }
            if (type == 'isPrice') {
                $scope.isPrice = !$scope.isPrice
            }
            if (type == 'isWeigh') {
                $scope.isWeigh = !$scope.isWeigh
            }
            if (type == 'stockManage') {
                $scope.stockManage = !$scope.stockManage
            }
            if (type == 'temporary') {
                $scope.temporary = !$scope.temporary
            }
            if (type == 'idSales') {
                $scope.idSales = !$scope.idSales
            }
            if (type == 'isStore') {
                $scope.isStore = !$scope.isStore
            }
            if (type == 'isIntegral') {
                $scope.isIntegral = !$scope.isIntegral
            }
        }
    });
    /** 压缩图片大小**/
    //    app.service('Util', function ($q) {
    //        var dataURItoBlob = function (dataURI) {
    //            // convert base64/URLEncoded data component to raw binary data held in a string
    //            var byteString;
    //            if (dataURI.split(',')[0].indexOf('base64') >= 0)
    //                byteString = atob(dataURI.split(',')[1]);
    //            else
    //                byteString = unescape(dataURI.split(',')[1]);
    //            // separate out the mime component
    //            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    //            // write the bytes of the string to a typed array
    //            var ia = new Uint8Array(byteString.length);
    //            for (var i = 0; i < byteString.length; i++) {
    //                ia[i] = byteString.charCodeAt(i);
    //            }
    //            return new Blob([ia], {
    //                type: mimeString
    //            });
    //        };
    //        var resizeFile = function (file) {
    //            var deferred = $q.defer();
    //            var img = document.createElement("img");
    //            try {
    //                var reader = new FileReader();
    //                reader.onload = function (e) {
    //                    img.src = e.target.result;
    //                    //resize the image using canvas
    //                    var canvas = document.createElement("canvas");
    //                    var ctx = canvas.getContext("2d");
    //                    ctx.drawImage(img, 0, 0);
    //                    var MAX_WIDTH = 800;
    //                    var MAX_HEIGHT = 800;
    //                    var width = img.width;
    //                    var height = img.height;
    //                    if (width > height) {
    //                        if (width > MAX_WIDTH) {
    //                            height *= MAX_WIDTH / width;
    //                            width = MAX_WIDTH;
    //                        }
    //                    } else {
    //                        if (height > MAX_HEIGHT) {
    //                            width *= MAX_HEIGHT / height;
    //                            height = MAX_HEIGHT;
    //                        }
    //                    }
    //                    canvas.width = width;
    //                    canvas.height = height;
    //                    var ctx = canvas.getContext("2d");
    //                    ctx.drawImage(img, 0, 0, width, height);
    //                    //change the dataUrl to blob data for uploading to server
    //                    var dataURL = canvas.toDataURL('image/jpeg,image/jpg,image/png');
    //                    var blob = dataURItoBlob(dataURL);
    //                    deferred.resolve(blob);
    //                };
    //                reader.readAsDataURL(file);
    //            } catch (e) {
    //                deferred.resolve(e);
    //            }
    //            return deferred.promise;
    //        };
    //        return {
    //            resizeFile: resizeFile
    //        };
    //    });
</script>
</body>
</html>