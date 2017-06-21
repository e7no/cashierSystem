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
    <title>汇汇生活商家后台-添加副屏</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
    <script src="../../js/angular.min.js"></script>
    <style>
        a {
            width: 50px;
            text-align: center;
            height: 25px;
            line-height: 25px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            display: inline-block;
        }

        a input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
    </style>
</head>
<body ng-app="myApp">
<div class="wrapper" ng-controller="listController">
    <div class="content">
        <div class="wbox">
            <div class="wbox-content add-vice">
                <form class="layui-form layui-form-pane">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><b>*</b>副屏标题</label>
                        <div class="layui-input-inline" style="width: 278px">
                            <input type="text" class="layui-input" placeholder="请输入副屏标题" ng-model="title">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label"><b>*</b>排序</label>
                        <div class="layui-input-inline" style="width: 278px">
                            <input type="text" class="layui-input" placeholder="请输入副屏展示序号" ng-model="sn">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <div class="layui-inline">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block" style="width: 278px;">
                                <div ng-class="{true: 'will-check active', false: 'will-check'}[isActive]">
                                    <input type="checkbox" ng-checked="isActive" ng-click="changeClass()"/>
                                    <i class="iconfont"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px;">
                        <label class="layui-form-label"><b>*</b>副屏图片</label>
                        <div class="layui-input-block" style="width: 278px;">
                            <div class="layui-input-inline" style="width: 278px">
                                <input type="hidden" id="picture">
                                <a href="javascript:;" class="choose-book">
                                    <input type="file" id="upload" multiple="" accept="image/jpeg,image/jpg,image/png" onchange="angular.element(this).scope().img_upload(this.files)"/>浏览
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-top: 10px; color: #999;" class="id_photos">
                        <!--图片规格1366*768-->
                    </div>
                    <div class="layui-form-item" style="text-align: center;"><span id="uploading" ng-show="isUpload"><img src="../../img/upload.gif" id="uploadpic" style="width:400px;height:auto;"/></span></div>
                    <div class="layui-form-item" style="margin-top: 12px;">
                        <input type="button" class="layui-btn layui-btn-small layui-btn-normal add-btn" value="保存" ng-click="saveModal()"/>
                        <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetModal()"/>
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
        $scope.isUpload = false;
        $scope.reader = new FileReader();   //创建一个FileReader接口
        $scope.img_upload = function (files) {       //单次提交图片的函数
            var type=files[0].type;
            if(type!='image/png' && type!='image/jpg'&& type!='image/jpeg'){
                layer.msg("请上传PNG/JPG/JPEG图片格式", {time: 3000});
                return false;
            }
            $scope.isUpload = true;
            $scope.guid = (new Date()).valueOf();   //通过时间戳创建一个随机数，作为键名使用
            $scope.reader.readAsDataURL(files[0]);  //FileReader的方法，把图片转成base64
            $scope.reader.onload = function (ev) {
                var postData = {
                    type: '2',
                    img: $scope.guid,
                    imgPath: ev.target.result,
                };
                $http.post('../../Controller/cashier/upload.php', postData).then(function (result) {  //正确请求成功时处理
                    var id = 'img' + $scope.guid;
                    if (result.data.success) {
                        var imgUrl = result.data.result[id].url;
                        $('#picture').val(imgUrl);
                        var attstr = '<img style="width:400px;height:auto;" src="' + imgUrl + '">';
                        $('#uploading').html(attstr);
                    } else {
                        layer.msg(result.data.message, {time: 3000});
                    }
                }).catch(function () { //捕捉错误处理
                    layer.msg('上传图片格式有误,请换张图片再试！', {time: 3000});
                });
            };
        }
        $scope.isActive = false;
        $scope.saveModal = function () {
            var status = 0;
            if ($scope.isActive) {
                status = 1;
            } else {
                status = 0;
            }
            var postData = {
                type: 'add',
                name: $scope.title,
                imgPath: $('#picture').val(),
                sn: $scope.sn,
                status: status,
            };
            if(!angular.isDefined($scope.title)){
            	layer.msg("请输入副屏标题", {time: 3000});
            	return;
            }
            if(!angular.isDefined($scope.sn)){
            	layer.msg("请输入副屏展示序号", {time: 3000});
            	return;
            }
            if($('#picture').val()==""){
            	layer.msg("请上传副屏图片", {time: 3000});
            	return;
            }
            $http.post('../../Controller/cashier/viceScreenAction.php', postData).then(function (result) {  //正确请求成功时处理
                if (result.data.success) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('恭喜你，添加成功！', {icon: 6, time: 1500});
                    parent.location.reload();
                } else {
                    layer.msg("上传图片类型有误或" + result.data.message, {time: 3000});
                }
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.changeClass = function () {
            $scope.isActive = !$scope.isActive
        }
        $scope.resetModal = function () {
            $scope.isActive = false;
            $scope.title = '';
            $scope.sn = '';
            $('#picture').val('');
            $('#uploading img').remove();
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
    ////                	if(!/\.(gif|jpg|jpeg|png|gif|jpg|png)$/.test(file.name)){　　//判断上传文件格式
    ////                		layer.msg('上传的图片格式不正确，请重新选择', {time: 3000});
    ////    					return false;　　　　　　　　　　
    ////    				}
    //                    img.src = e.target.result;
    //                    //resize the image using canvas
    //                    var canvas = document.createElement("canvas");
    //                    var ctx = canvas.getContext("2d");
    //                    ctx.drawImage(img, 0, 0);
    //                    var MAX_WIDTH = 1024;
    //                    var MAX_HEIGHT = 768;
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
</html>