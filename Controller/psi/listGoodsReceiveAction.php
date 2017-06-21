<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $createId = $postData->createId; // 获取当前页
    $no = $postData->no; // 获取当前页
    $outDateStart = $postData->outDateStart; // 获取当前页
    $outDateEnd = $postData->outDateEnd; // 获取当前页
    $url = $config_host . '/service/gds/stock/out/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId,
        'outDateStart'=>$outDateStart ? $outDateStart : null,
        'outDateEnd'=>$outDateEnd ? $outDateEnd : null,
        'no'=>$no,
        'personName'=>$createId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else{
    $str['success'] = true;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>