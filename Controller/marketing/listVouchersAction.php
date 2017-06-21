<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $faceValue = $postData->faceValue; // 获取当前页
    $endDateStart = $postData->endDateStart; // 获取当前页
    $endDateEnd = $postData->endDateEnd; // 获取当前页
    $url = $config_host . '/service/sto/offCoupon/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'faceValue' => $faceValue,
        'endDateStart' => $endDateStart,
        'endDateEnd' => $endDateEnd
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'add') {
    $name = $postData->name;
    $faceValue = $postData->faceValue;
    $useCond = $postData->useCond;
    $startDate = date("Y-m-d H:i:s");
    $endDate = $postData->endDate;
    $total = $postData->total;
    $url = $config_host . '/service/sto/offCoupon/add';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'name' => $name,
        'faceValue' => (int)$faceValue,
        'useCond' => (int)$useCond,
        'startDate' => $startDate,
        'endDate' => date("Y-m-d H:i:s", strtotime($endDate)),
        'total' => $total,
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
    $url = $config_host . '/service/sto/manage/cutReason/update';
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
} else if ($type == 'delist') {
    $useState = $postData->states; // 获取当前页
    $setId = $postData->setId; // 获取当前页
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/sto/offCoupon/listItem';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'setId' => $setId,
    ));
    if ($useState != '' && $useState != undefined) {
        $datas['datas']['useState'] = (int)$useState;
    }
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'limit') {
    $limitNum = $postData->limitNum; // 获取当前页
    $url = $config_host . '/service/sto/manage/setStoreOrderCut';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'orderCut' => $limitNum,
        'createId' => $_SESSION['bUserId']
    ));
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
    $url = $config_host . '/service/sto/manage/getStoreOrderCut/' . $stoId;
    $json = http($url, '', 1);
    $str['list'] = $json['datas']['basicSettingsVO'];
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