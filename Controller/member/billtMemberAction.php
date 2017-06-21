<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$currentPage = $postData->currentPage; // 获取当前页
$perPage = $postData->itemsPerPage; // 获取每页多少条数据
$memId = $postData->memId; // 获取每页多少条数据
$createDateStart = $postData->createDateStart; // 获取每页多少条数据
$createDateEnd = $postData->createDateEnd; // 获取每页多少条数据
$url = $config_host . '/service/mem/manage/chsMemBalanceList';
$datas = array('datas' => array(
    'pageNo' => $currentPage,
    'pageSize' => $perPage,
    'memId' => $memId,
    'createDateStart' => $createDateStart,
    'createDateEnd' => $createDateEnd
));
$json = http($url, $datas, 1);
$str['list'] = $json['datas']['list'];
$str['total'] = $json['datas']['page']['totalSize'];
echo json_encode($str);
exit;
//file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>