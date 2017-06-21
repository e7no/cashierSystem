<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "Otherlist") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $no = $postData->no; //
    $inOrOut = $postData->inOrOut; //
    $createDateStart = $postData->createDateStart; //
    $createDateEnd = $postData->createDateEnd; //
    $personName = $postData->personName; //
    $url = $config_host . '/service/fin/manage/store/otherFinance';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'no' => $no,
        'inOrOut' => $inOrOut,
        'createDateStart' => $createDateStart,
        'createDateEnd' => $createDateEnd,
        'personName' => $personName
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "Filesadd") {
    $inout = $postData->inout;
    $typeId = $postData->typeId;
    $amount = $postData->amount;
    $note = $postData->note;
    $url = $config_host . '/service/fin/manage/store/addOtherFinance';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'inout' => $inout,
        'billDate' => date("Y-m-d H:i:s", time()),
        'operator' => $userId
    )));
    $count = count($typeId);
    for ($i = 0; $i < $count; $i++) {
        $id = explode(",", $typeId[$i])[0];
        $project = explode(",", $typeId[$i])[1];
        $datas['datas']['vo']['details'][$i]['typeId'] = $id ? $id : '';
        $datas['datas']['vo']['details'][$i]['typeName'] = $project ? $project : '';
        $datas['datas']['vo']['details'][$i]['amount'] = $amount[$i] ? $amount[$i] : '';
        $datas['datas']['vo']['details'][$i]['note'] = $note[$i] ? $note[$i] : '';
    }
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恭喜你，添加成功！' . $json['errMsg'];
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
} else if ($type == 'selectproject') {
    $selectId = $postData->selectId;
    $url = $config_host . '/service/fin/manage/billType';
    $datas = array('datas' => array(
        'inOrOut' => $selectId,
    ));
    $json = http($url, $datas, 1);
    echo json_encode($json);
    exit;
}
//file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);