<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "proList") {
	$url = $config_host . '/service/gds/stock/finishedProduct/list';
	$datas = array('datas' => array('stoId' => $stoId,'openState' => '1'));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	echo json_encode($str);
	exit;
}
//file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>