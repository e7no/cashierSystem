<?php
session_start();
ini_set("mssql.textsize",200000000);
ini_set("mssql.textlimit",200000000);
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$imgType = $postData->type;
$imgPath = $postData->imgPath;
$img = $postData->img;
$imgBase64=explode(',',$imgPath);
$types=explode(';',$imgBase64[0]);
$type=explode(':',$types[0]);
$url = $config_host . '/service/sys/upload/b64image';
$datas['datas']['stoId']=$_SESSION['stoId'];
$datas['datas']['list'][0]['key']='img'.$img;
$datas['datas']['type']=$imgType;
$datas['datas']['list'][0]['type']=$type[1];
$datas['datas']['list'][0]['content']=$imgBase64[1];
$json = http($url, $datas, 1);
if ($json['success']) {
    $str['result']=$json['datas']['list'];
    $str['subdirectory']=$json['datas']['subdirectory'];
    $str['success'] = true;
    if ($json['errMsg'] == '') {
        $str['message'] = '上传成功！';
    } else {
        $str['message'] = $json['errMsg'];
    }
} else {
    $str['success'] = false;
    if ($json['errMsg'] == '') {
        $str['message'] = '上传失败！';
    } else {
        $str['message'] = $json['errMsg'];
    }
}
echo json_encode($str);
exit;
?>