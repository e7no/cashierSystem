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
    $no = $postData->no;
    $outDateStart = $postData->outDateStart;
    $outDateEnd = $postData->outDateEnd;
    $operator = $postData->operator;
    $url = $config_host . '/service/gds/material/outStock/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'outDateStart' => $outDateStart,
        'outDateEnd' => $outDateEnd,
        'no' => $no,
        'personName' => $operator
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if($type=='details'){
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $deltailId = $postData->id;
    $url = $config_host . '/service/gds/material/outStock/detail/'.$deltailId;
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['outStockInfo'] = $json['datas']['outStockInfo'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'cat') {
    $url = $config_host . '/service/gds/material/findMaterialTypeList';
    $data = array('datas' => array(
        'stoId' => $stoId,
    ));
    $json = http($url, $data, 1);
    $str['list'] = $json['datas']['list'];
    echo json_encode($str);
    exit;
} else if ($type == 'goods') {
    $catId = $postData->catId;
    $url = $config_host . '/service/gds/material/findMaterialList';
    $data = array('datas' => array(
        'stoId' => $stoId,
        'openState' => '1',
    	'orderByType'=>'1'
    ));
    if ($catId != '' || $catId != NULL) {
        $data['datas']['typeId'] = $catId;
    }
    $json = http($url, $data, 1);
    $str['list'] = $json['datas']['list'];
    echo json_encode($str);
    exit;
} else if ($type == 'session') {
    unset ($_SESSION['cats']);
    $cats = $postData->cats;
    if ($cats != '') {
        if (empty($_SESSION['cats'])) {
            $_SESSION['cats'] = $cats;
        } else {
            $_SESSION['cats'] = array_unique(array_merge($_SESSION['cats'], $cats));
        }
        $str['success'] = true;
        echo json_encode($str);
        exit;
    } else {
        $str['success'] = false;
        $str['message'] = '请选择原料！';
        echo json_encode($str);
        exit;
    }
} else if($type=='get'){
    $datas=$postData->datas;
    $url = $config_host . '/service/gds/material/outStock/add';
    $json = http($url, $datas, 1);
    if ($json['success']) {
        unset ($_SESSION['cats']);
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '领用成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '领用失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
}else if($type=='unset'){
    unset ($_SESSION['cats']);
    $str['success'] = true;
    echo json_encode($str);
    exit;
}else {
    $str['success'] = true;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>