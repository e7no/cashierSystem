<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$stoType = $_SESSION['stoType'];
if ($type == "list") {
    $url = $config_host . '/service/fin/manage/store/fundDetails/' . $stoId;
    $json = http($url, '', 1);
    $url_card = $config_host . '/service/fin/manage/bankCardList';
    $datas_card = array('datas' => array(
        'userId' => $userId
    ));
    $json_card = http($url_card, $datas_card, 1);
    $str['list'] = $json['datas']['dataMap'];
    $str['card'] = $json_card['datas']['list'];
    echo json_encode($str);
    exit;
} else if ($type == 'tixian') {
    $cardId = $postData->num; // 获取当前页
    $money = $postData->money; // 获取当前页
    $pwd = $postData->pwd; // 获取当前页
    if ($money == '') {
        $str['success'] = false;
        $str['message'] = '请输入提现金额！';
        echo json_encode($str);
        exit;
    }
    if ($pwd == '') {
        $str['success'] = false;
        $str['message'] = '请输入密码！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/fin/manage/store/withdrawDeposit';
    $datas = array('datas' => array(
        'userId' => $userId,
        'payPassword' => $pwd,
        'cardId' => $cardId
    ));
    $datas['datas']['list'][0]['stoId'] = $stoId;
    $datas['datas']['list'][0]['amount'] = $money;
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '申请提现成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '提现失败,请重新提现！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'record') {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/fin/manage/store/cashOutRecord';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'check') {
    $cid = $postData->id;
    $url = $config_host . '/service/fin/manage/store/getCashOutLimit/'.$cid;
    $json = http($url, '', 1);
    $str['allowAmt']=$json['datas']['allowAmt'];
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//   file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>