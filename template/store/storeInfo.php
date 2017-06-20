<?php
include('../../Common/check.php');
include_once('../../Common/phpqrcode.php');
include_once('../../Common/function.php');
$id=$_SESSION['stoId'];
$url = $config_host . '/service/sto/manage/stoInfo/' . $id;
$str = http($url, '', 1);
$stoInfo=$str['datas']['info'];
$domain = $_SERVER['HTTP_HOST'];
$n = preg_match('/(.*\.)?\w+\.\w+$/', $domain, $matches);
if ($matches[1] == 'uat.') {
	$urlcode = $config_qrCoder_uat;
} else if ($matches[1] == 'demo.') {
	$urlcode = $config_qrCoder_demo;
} else {
	$urlcode = $config_qrCoder;
}
$value = $urlcode . $id; //二维码内容
$errorCorrectionLevel = 'L';//容错级别
$matrixPointSize = 6;//生成图片大小
//生成二维码图片
QRcode::png($value, '../../img/qrcode/' . $id . '.png', $errorCorrectionLevel, $matrixPointSize, 2);
$QR = '../../img/qrcode/qrcode.png';//已经生成的原始二维码图
$imgUrl = '../../img/qrcode/' . $id . '.png';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>汇汇生活商家后台-门店信息</title>
    <meta name="keywords" content="汇汇生活-让实体店生意火起来">
    <meta name="description" content="汇汇生活-世界都在用">
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/layui.css" />
    <link rel="stylesheet" href="../../css/will.css" />
</head>
<body>
	<div class="wrapper">
		<div class="content storeInfo-content">
			<div class="wbox">
				<div class="wbox-title">
					<h5>门店信息</h5>
					<div class="ibox-tools">
						<a class="btn-shuaxin" href="javascript:location.replace(location.href);" title="刷新">
							<i class="iconfont will-shuaxin"></i>
						</a>
					</div>
				</div>
				<div class="wbox-content">
					<div class="storeInfo-left">
						<fieldset class="layui-elem-field storeInfo-box">
							<legend>基本信息</legend>
							<div class="layui-field-box">
						    	<p><b>门店名称：</b><?php echo $stoInfo['name'];?></p>
						    	<p><b>门店编码：</b><?php echo $stoInfo['code'];?></p>
						    	<p><b>门店地址：</b><?php echo $stoInfo['address'];?></p>
						    	<p><b>&#12288;&#12288;电话：</b><?php echo $stoInfo['tel'];?></p>
						    	<p><b>经营品类：</b><?php echo $stoInfo['typeName'];?></p>
							</div>
						</fieldset>
						<fieldset class="layui-elem-field storeInfo-box">
							<legend>二维码：</legend>
							<div class="layui-field-box">
								<img src="<?php echo $imgUrl; ?>" alt="" style="width: 200px;height: 200px;">
							</div>
						</fieldset>
					</div>
					<div class="storeInfo-right">
						<fieldset class="layui-elem-field storeInfo-box">
							<legend>门店首图：</legend>
							<div class="layui-field-box">
						    	<img src="<?php echo $stoInfo['homeImgPath'];?>" style="max-width: 100%;max-height: 413px;" />
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>