<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "proList") {
	$typeurl = $config_host . '/service/gds/material/findMaterialTypeList';//分类
	$goodsurl = $config_host . '/service/gds/material/findMaterialList';//分类
	$datas = array('datas' => array('stoId' => $stoId,'openState' => '1','orderByType'=>'1'));
	$typejson = http($typeurl, $datas, 1);
	
	$goodsjson = http($goodsurl, $datas, 1);
	
	$str['typelist'] = $typejson['datas']['list'];
	$str['goodslist'] = $goodsjson['datas']['list'];
	echo json_encode($str);
	exit;
}
//file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>