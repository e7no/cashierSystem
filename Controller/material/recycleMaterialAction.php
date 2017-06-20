<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $mtypeId = $postData->mtypeId; // 获取每页多少条数据
    $quickSearch = $postData->quickSearch; // 获取每页多少条数据
    $url = $config_host . '/service/gds/material/getMaterialList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'mtypeId' => $mtypeId,
        'quick' => $quickSearch,
        'stoId' => $stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if($type=='recover'){
    $id = $postData->rid; // 获取当前页
    $url = $config_host . '/service/gds/material/recoveryMaterial';
    $datas = array('datas' => array('ids' => $id));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '删除成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '删除失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
}else {
    $str['success'] = false;
    $str['message'] = '服务端请求报错！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>