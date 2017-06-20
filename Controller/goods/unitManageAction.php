<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $name = $postData->name; // 获取每页多少条数据
    $url = $config_host . '/service/gds/manage/storeUnitList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'name' => $name
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "add") {
    $Unitname = $postData->Unitname; // 获取每页多少条数据
    $url = $config_host . '/service/gds/manage/addUnit';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'name' => $Unitname,
        'createId' => $_SESSION['bUserId']
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '添加成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '添加失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'deal') {
    $gsuId = $postData->gsuId; // 获取每页多少条数据
    $url = $config_host . '/service/gds/manage/changeState';
    $datas = array('datas' => array('gsuId' => $gsuId));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '设置成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '设置失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//
?>