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
    $catId = $postData->catId;
    $name = $postData->name;
    $no = $postData->no;
    $storeNum = $postData->storeNum;
    $url = $config_host . '/service/gds/stock/finishedProduct/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'catId' => $catId,
        'no' => $no,
        'name' => $name,
        'stoId' => $stoId
    ));
    if($storeNum!=''){
        $datas['datas']['storeNum']=$storeNum;
    }
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if($type=='detail'){
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $id = $postData->id;
    $itype = $postData->itype;
    $no = $postData->no;
    $ntype = $postData->ntype;
    $createDateStart = $postData->createDateStart;
    $createDateEnd = $postData->createDateEnd;
    $url = $config_host . '/service/gds/stock/balance/'.$id.'/'.$itype;
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'no' => $no,
        'createDateStart' => $createDateStart,
        'createDateEnd' => $createDateEnd
    ));
    if($ntype!=''){
        $datas['datas']['type']=$ntype;
    }
    $json = http($url, $datas, 1);
    $str['goodsInfo'] = $json['datas']['goodsInfo'];
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