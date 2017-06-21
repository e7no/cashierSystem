<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$stoType = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $name = $postData->name;
    $mobile = $postData->mobile;
    $code = $postData->code;
    $url = $config_host . '/service/sto/manage/querySubStore';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'subName' => $name,
        'mobile' => $mobile,
        'subCode' => $code,
        'state' => 1,
        'notInBindState' => 3
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'add') {
    $coding = $postData->coding;
    $array = object2array($coding);
    $codes = implode(',', $array);
    $url = $config_host . '/service/sto/manage/addBind';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'codes' => $codes
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['message'] = $json['datas']['msg'];
    } else {
        $str['success'] = false;
        $str['message'] = '新增门店失败！';
    }
    echo json_encode($str);
    exit;
} else if ($type == 'modify') {
    $downGoods = $postData->downGoods;
    $modifyPrice = $postData->modifyPrice;
    $manageEmp = $postData->manageEmp;
    $memberSystem = $postData->memberSystem;
    $cashRecharge = $postData->cashRecharge;
    $subCode = $postData->subCode;
    $array = object2array($subCode);
    if (count($array) > 1) {
        $subCodes = implode(',', $array);
    } else {
        if (is_array($subCode)) {
            $subCodes = implode(',', $subCode);
        } else {
            $subCodes = $subCode;
        }

    }
    $url = $config_host . '/service/sto/manage/editAuth';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'downGoods' => (string)$downGoods,
        'modifyPrice' => (string)$modifyPrice,
        'manageEmp' => (string)$manageEmp,
        'memberSystem' => (string)$memberSystem,
        'cashRecharge' => (string)$cashRecharge,
        'codes' => $subCodes
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['message'] = $json['datas']['msg'];
    } else {
        $str['success'] = false;
        $str['message'] = '修改失败！';
    }
    echo json_encode($str);
    exit;
} else if ($type == 'del') {
    $delId = $postData->id;
    $url = $config_host . '/service/sto/manage/delBindFail/' . $delId;
    $json = http($url, '', 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['message'] = '删除成功！';
    } else {
        $str['success'] = false;
        $str['message'] = '删除失败！';
    }
    echo json_encode($str);
    exit;
} else if ($type == 'relieve') {
    $idre = $postData->idre;
    $url = $config_host . '/service/sto/manage/unbind/' . $stoId . '/' . $idre;
    $json = http($url, '', 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['message'] = '解绑成功！';
    } else {
        $str['success'] = false;
        $str['message'] = '解绑失败！';
    }
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>