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
    $typeId = $postData->typeId;
    $name = $postData->name;
    $code = $postData->code;
    $stock = $postData->stock;
    $url = $config_host . '/service/gds/material/findMaterialList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'typeId' => $typeId,
        'code' => $code,
        'name' => $name,
        'stockGE' => $stock,
        'stoId' => $stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if($type=='detail'){
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $id = $postData->id;
    $no = $postData->no;
    $type = $postData->typeId;
    $createDateStart = $postData->createDateStart;
    $createDateEnd = $postData->createDateEnd;
    $url = $config_host . '/service/gds/material/balance/list/'.$id;
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'no' => $no,
        'type' => $typeId,
        'createDateStart' => $createDateStart, 
        'createDateEnd' => $createDateEnd
    ));
    $json = http($url, $datas, 1);
    $str['vo'] = $json['datas']['vo'];
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
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