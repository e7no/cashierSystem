<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/sto/orderFree/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'add') {
    $name = $postData->name;
    if($name==''){
        $str['success'] = false;
        $str['message'] = '原因不能空！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/sto/orderFree/add';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'reason' => $name,
        'operator' => $_SESSION['bUserId']
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恭喜你，添加成功！';
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
} else if($type=='modify'){
    $mid = $postData->mid;
    $name = $postData->name;
    if($name==''){
        $str['success'] = false;
        $str['message'] = '原因不能空！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/sto/orderFree/update';
    $datas = array('datas' => array(
        'freeId' => $mid,
        'reason' => $name,
        'operator' => $_SESSION['bUserId']
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恭喜你，修改成功！';
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
}else if($type=='delete'){
    $dId = $postData->dId;
    $url = $config_host . '/service/sto/orderFree/delete/'.$dId;
    $json = http($url, '', 1);
    if ($json['datas']['flag']) {
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