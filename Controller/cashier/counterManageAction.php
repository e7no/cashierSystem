<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $areaType = $postData->areaType;
    $url = $config_host . '/service/sto/table/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId,
        'areaType'=>$areaType
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if($type=='table'){
    $url = $config_host . '/service/sto/tableArea/list';
    $datas = array('datas' => array(
        'stoId' => $stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
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