<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/sto/cutReason/list';
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
    $reason = $postData->reason; // 获取当前页
    $url = $config_host . '/service/sto/cutReason/add';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'reason' => $reason,
        'createId' => $_SESSION['bUserId']
    )));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
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
} else if ($type == 'modify') {
    $reason = $postData->reason; // 获取当前页
    $id = $postData->id; // 获取当前页
    $url = $config_host . '/service/sto/cutReason/update';
    $datas = array('datas' => array('vo' => array(
        'id' => $id,
        'stoId' => $stoId,
        'reason' => $reason,
        'modifyId' => $_SESSION['bUserId']
    )));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
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
            $str['message'] = '修改失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'del') {
    $id = $postData->delId; // 获取当前页
    $url = $config_host . '/service/sto/cutReason/delete';
    $datas = array('datas' => array(
        'ids' => $id,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恭喜你，删除成功！';
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
} else if ($type == 'limit') {
    $limitNum = $postData->limitNum; // 获取当前页
    $url = $config_host . '/service/sto/manage/storeBasic/update';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'orderCut' => $limitNum,
        'createId' => $_SESSION['bUserId']
    )));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恭喜你，设置成功！';
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
} else if ($type == 'check') {
    $url = $config_host . '/service/sto/manage/storeBasic/getByStoreId/' . $stoId;
    $json = http($url, '', 1);
    $str = $json['datas']['basicSettingsVO'];
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求报错！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>