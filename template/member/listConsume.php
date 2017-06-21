<?php
include('../../Common/check.php');
include_once('../../Common/function.php');
if ($_SESSION['stoType'] == 1) {
    $url = $config_host . '/service/sto/manage/stoList';
    $data['datas']['pid'] = $_SESSION['stoId'];
    $json = http($url, $data, 1);
    $stoList = $json['datas']['list'];
    $listNum = count($stoList);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title>汇汇生活商家后台-消费列表</title>
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
                        <label class="layui-form-label">会员卡号</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" class="layui-input" placeholder="请输入会员卡号" ng-model="cardNum">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">会员姓名</label>
                        <div class="layui-input-inline" style="width: 110px;">
                            <input type="text" class="layui-input" placeholder="请输入会员姓名" ng-model="cardName">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">会员手机</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" class="layui-input" placeholder="请输入会员手机" ng-model="cardPhone">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">时间</label>
                        <div class="layui-input-inline" style="width: 156px;">
                            <input type="text" class="Wdate layui-input" ng-model="createDateStart" id="logmin" placeholder="请选择开始时间" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})">
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline" style="width: 156px;">
                            <input type="text" class="Wdate layui-input" ng-model="createDateEnd" id="logmax" placeholder="请选择结束时间" onchange=""
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})">
                        </div>
                    </div>
                    <?php if ($_SESSION['stoType'] == 1) { ?>
                        <div class="layui-inline">
                            <label class="layui-form-label">消费门店</label>
                            <div class="layui-input-inline">
                                <select class="layui-input" ng-model="cstoId">
                                    <option value="">请选择...</option>
                                    <?php for ($i = 0; $i < $listNum; $i++) { ?>
                                        <option value="<?php echo $stoList[$i]['stoId']; ?>"><?php echo $stoList[$i]['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="button" class="layui-btn layui-btn-small layui-btn-normal" value="查询" ng-click="reSearch()"/>
                    <input type="reset" class="layui-btn layui-btn-small layui-btn-primary" value="重置" ng-click="resetSearch()"/>
                </div>
            </form>
        </div>
        <div class="wbox">
            <div class="wbox-title">
                <h5>消费列表</h5>
                <div class="ibox-tools">
                    <a class="btn-green" id="excel">导出</a>
                    <a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
                        <i class="iconfont will-shuaxin"></i>
                    </a>
                </div>
            </div>
            <div class="wbox-content">
                <div class="con-table">
                    <table class="layui-table" style="min-width: 1100px;">
                        <thead>
                        <tr class="text-c">
                            <th width="18%">单号</th>
                            <th width="16%">卡号</th>
                            <th width="8%">姓名</th>
                            <th width="9%">手机号码</th>
                            <th width="8%">会员卡支付金额</th>
                            <th width="15%">时间</th>
                            <th class="text-l">消费门店</th>
                            <th width="7%">明细</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c" ng-repeat="item in list">
                            <td>{{item.no}}</td>
                            <td>{{item.card}}</td>
                            <td>{{item.realName}}</td>
                            <td>{{item.mobile}}</td>
                            <td>{{item.memberPayAmount}}</td>
                            <td>{{item.finishDate}}</td>
                            <td class="text-l">{{item.storeName}}</td>
                            <td>
                                <a class="btn-blue view-btn" ng-click="checkModal(item.ordId)">查看</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <tm-pagination conf="paginationConf"></tm-pagination>
            </div>
        </div>
    </div>
    <!--查看购买明细-->
    <div class="popup view-open" id="check">
        <div class="popup-body">
            <p><span>单号：</span>{{detail.ordNo}}</p>
            <p><span>时间：</span>{{detail.createDate}}</p>
            <p><span>会员卡号：</span>{{detail.card}}</p>
            <p><span>会员姓名：</span>{{detail.realName}}</p>
            <p><span>会员手机：</span>{{detail.mobile}}</p>
            <p><span>消费门店：</span>{{detail.storeName}}</p>
            <ul ng-repeat="items in itemList">
                <li>
                    <h5>{{items.goodsName}}</h5>
                    <b>×{{items.quantity}}</b>
                    <span>{{items.realSum|currency:'￥':2}}</span>
                    <div class="pb-sx">{{items.note}}&nbsp;{{items.skuName}}</div>
                </li>
            </ul>
            <p ng-repeat="item in payList"><span>{{item.payTypeName}}: </span><span> {{item.paySum|currency:'￥':2}}</span></p>
            <p><span>应收金额: </span><span> {{item.realSum|currency:'￥':2}}</span></p>
            <p><span>实付金额: </span><span> {{item.recAmt|currency:'￥':2}}</span></p>
            <p><span>找零金额: </span><span> {{item.chgAmt|currency:'￥':2}}</span></p>
            <p><span>支付方式：</span>
                <span ng-if="detail.payType==1">钱包</span>
                <span ng-if="detail.payType==2">微信</span>
                <span ng-if="detail.payType==3">支付宝</span>
                <span ng-if="detail.payType==4">汇币</span>
                <span ng-if="detail.payType==5">现金</span>
                <span ng-if="detail.payType==6">刷卡</span>
                <span ng-if="detail.payType==7">会员余额</span>
                <span ng-if="detail.payType==8">会员积分</span>
                <span ng-if="detail.payType==9">复合支付</span>
            </p>
        </div>
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
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                cardNum: $scope.cardNum,
                cardName: $scope.cardName,
                cardPhone: $scope.cardPhone,
                createDateStart: $scope.createDateStart,
                createDateEnd: $scope.createDateEnd,
                cstoId: $scope.cstoId
            };
            $http.post('../../Controller/member/listConsumeAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.paginationConf.totalItems = result.data.total;
                $scope.list = result.data.list;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $scope.reSearch = reSearch;
        $scope.resetSearch = function () {
            $scope.cardNum = undefined;
            $scope.cardName = undefined;
            $scope.cardPhone = undefined;
            $scope.createDateStart = undefined;
            $scope.createDateEnd = undefined;
            $scope.cstoId = undefined;
        }
        $scope.paginationConf = {//配置分页基本参数
            currentPage: 1, //起始页
            itemsPerPage: 20, // 每页展示的数据条数
            perPageOptions: [20, 30, 50] //可选择显示条数的数组
        };
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', reSearch);
        $scope.checkModal = function (id) {
            layer.open({
                type: 1,
                title: "购买明细",
                move: false,
                area: ['450px', '100%'],
                offset: ['0', '0'],
                shadeClose: true,
                resize: false,
                content: $("#check"),
            });
            var postData = {type: 'check', ordId: id};
            $http.post('../../Controller/member/listConsumeAction.php', postData).then(function (result) {  //正确请求成功时处理
                $scope.detail = result.data.detail;
                $scope.itemList = result.data.detail.itemList;
                $scope.payList = result.data.detail.payList;
            }).catch(function () { //捕捉错误处理
                layer.msg('服务端请求错误！', {time: 3000});
            });
        }
        $('#excel').click(function () {
            var cardNum = $scope.cardNum ? $scope.cardNum : '';
            var cardName = $scope.cardName ? $scope.cardName : '';
            var cardPhone = $scope.cardPhone ? $scope.cardPhone : '';
            var createDateStart = $scope.createDateStart ? $scope.createDateStart : '';
            var createDateEnd = $scope.createDateEnd ? $scope.createDateEnd : '';
            var cstoId = $scope.cstoId ? $scope.cstoId : '';
            layer.msg('数据导出中，请耐心等待....！', {time: 2500});
            window.location.href = '../../Controller/Excel/listConsumeExcel.php?cardNum=' + cardNum + '&cardName=' + cardName + '&cardPhone=' + cardPhone + '&createDateStart=' + createDateStart + '&createDateEnd=' + createDateEnd + '&cstoId=' + cstoId;
        });
    });
</script>
</body>
</html>