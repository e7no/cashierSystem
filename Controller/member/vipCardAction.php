<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $url = $config_host . '/service/mem/manage/card/rechSetting/list/' . $stoId;
    $json = http($url, '', 1);
    $url2 = $config_host . '/service/mem/manage/getStoreIntegral';
    $datas = array('datas' => array(
        'stoId' => $stoId
    ));
    $json2 = http($url2, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['list'] = $json['datas']['list'];
        $str['integral'] = $json2['datas']['backupCash'];
        $str['conAmount'] = $json2['datas']['conAmount'];
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '数据初始化失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'set') {
    $id0 = $postData->id0;
    $id1 = $postData->id1;
    $id2 = $postData->id2;
    $id3 = $postData->id3;
    $amount0 = $postData->amount0;
    $amount1 = $postData->amount1;
    $amount2 = $postData->amount2;
    $amount3 = $postData->amount3;
    $give0 = $postData->give0;
    $give1 = $postData->give1;
    $give2 = $postData->give2;
    $give3 = $postData->give3;
    if ($amount0 == '' || $amount1 == '' || $amount2 == '') {
        $str['success'] = false;
        $str['message'] = '请填写完所有充值金额！';
    } else if ($amount0 <= 1 || $amount1 <= 1 || $amount2 <= 1) {
        $str['success'] = false;
        $str['message'] = '充值金额必须大于1元！';
    } else if ($give3 > 100) {
        $str['success'] = false;
        $str['message'] = '赠送比例不能大于100！';
    } else {
        $url = $config_host . '/service/mem/manage/card/rechSetting/update';
        $datas = array('datas' => array('list' => array(
            array(
                'id' => $id0,
                'amount' => $amount0,
                'give' => $give0,
                'reType' => 1
            ),
            array(
                'id' => $id1,
                'amount' => $amount1,
                'give' => $give1,
                'reType' => 1
            ),
            array(
                'id' => $id2,
                'amount' => $amount2,
                'give' => $give2,
                'reType' => 1
            ),
            array(
                'id' => $id3,
                'amount' => $amount3,
                'give' => $give3,
                'reType' => 2
            )
        )));
        $json = http($url, $datas, 1);
        if ($json['success']) {
            $str['success'] = true;
            $str['message'] = '设置成功！';
        } else {
            $str['success'] = false;
            if ($json['errMsg'] == '') {
                $str['message'] = '设置失败！';
            } else {
                $str['message'] = $json['errMsg'];
            }
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'integral') {
    $consume = $postData->consume;
    $integral = $postData->integral;
    $url = $config_host . '/service/mem/manage/setIntegral';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'conAmount' => $consume,
        'integral' => $integral
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['message'] = '设置成功！';
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
    $str['message'] = '服务端请求报错！';
    echo json_encode($str);
    exit;
}

?>