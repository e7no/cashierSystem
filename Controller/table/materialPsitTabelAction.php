<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
$stoType = $_SESSION['stoType'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $stoName = $postData->stoName;
    $balanceDateStart = $postData->DateStart;
    $balanceDateEnd = $postData->DateEnd;
    $url = $config_host . '/service/gds/material/balance/detailList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'balanceDateStart' => $balanceDateStart,
        'balanceDateEnd' => $balanceDateEnd,
    ));
    if ($stoType == 1) {
        if ($stoName == '' || $stoName == NULL) {
            $datas['datas']['stoId'] = $stoId;
        } else {
            $datas['datas']['stoId'] = $stoName;
        }
    } else {
        $datas['datas']['stoId'] = $stoId;
    }
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求报错！';
    echo json_encode($str);
    exit;
}
?>