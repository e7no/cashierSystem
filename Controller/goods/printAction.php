<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$id = $postData->id;
$url = $config_host . '/service/gds/manage/goods/getLable/' . $id;
$json = http($url, '', 1);
$str['lable'] = $json['datas']['lable'];
$str['skuList'] = $json['datas']['skuList'];
echo json_encode($str);
exit;
//   file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>