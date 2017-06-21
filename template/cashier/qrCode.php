<?php
include_once('../../Common/phpqrcode.php');
$id = $_GET['id'];
$url = $config_host . '/service/sto/table/generateQrCode/';
$datas = array('datas' => array(
    'tabId' => $id,
    'quantity' => 1,
    'isPosition' => 0,
));
$str = http($url, $datas, 1);
$list = $str['datas']['tableVO'];
$url = $str['datas']['list'][0];
$errorCorrectionLevel = 'L';//容错级别
$matrixPointSize = 6;//生成图片大小
//生成二维码图片
QRcode::png($url, '../../img/qrcode/' . $id . '.png', $errorCorrectionLevel, $matrixPointSize, 2);
$QR = '../../img/qrcode/qrcode.png';//已经生成的原始二维码图
$imgUrl = '../../img/qrcode/' . $id . '.png';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <title</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel="stylesheet" href="../../css/layui.css"/>
    <link rel="stylesheet" href="../../css/will.css"/>
</head>
<style type="text/css">
    .content {
        padding-top: 70px;
        width: 149px;
        margin: 0 auto;
    }

    .content h2 {
        padding: 10px 0;
        margin: 0;
        font-size: 18px;
    }

    .ewm-box {
        margin-left: -5px;
        width: 147px;
    }

    .ewm-box span {
        margin-left: 8px;
        margin-right: 8px;
        display: block;
        line-height: 16px;
        font-size: 10px;
        text-align: center;
        color: #000;
    }

    .btn-ewm {
        width: 100px;
        margin: 15px auto 0;
    }

    .btn-ewm input[type="button"] {
        width: 87px;
        height: 30px;
        margin: 0 auto;
        background: #5a98de;
        border: none;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
        color: #fff;
        border-radius: 6px;
    }

    @media print {
        　　.ewm-box {
            border: none;
        }
    }

    }
</style>
<style type="text/css" media="print">
    /*白纸黑字*/
    @media print {
        body {
            color: #000;
            background: #fff;
        }
    }

    @page :first {
        margin: 0px 0px;
    }

    @page :left {
        margin-left: 0cm;
    }

    @page :right {
        margin-right: 0cm;
    }

    @page {
        size: 40mm 50mm;
    }

    @page {
        width: 40mm;
    }

    @media print {
        h1 {
            color: #000;
            background: none;
        }

        nav, aside {
            display: none;
        }

        body, article {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        @page {
            margin: 2cm;
        }
    }
</style>
<body>
<div class="wrapper">
    <div class="content">
        <div id="content">
            <div class="ewm-box" id="pritn">
                <img src="<?php echo $imgUrl; ?>" alt="" style="width: 147px;height: 147px;"/>
                <span style="background: #fff;width: 147px;height:26px;line-height:26px;margin-left: 0px;font-size: 16px;">桌台：<?php echo $list['name']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="new-open"></div>
</body>
</html>