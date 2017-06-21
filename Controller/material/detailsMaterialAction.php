<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$stoId = $_SESSION['stoId'];
$type = $postData->type;
if ($type == 'add') {
    $materialName = $postData->materialName;
    $materialCategory = $postData->materialCategory;
    $materialUnit = $postData->materialUnit;
    $specification = $postData->specification;
    $Price = $postData->Price;
    $maxPrice = $postData->maxPrice;
    $check = $postData->check;
    if ($materialName == '') {
        $str['success'] = false;
        $str['message'] = '原料名称不能为空！';
    } else if ($materialCategory == '') {
        $str['success'] = false;
        $str['message'] = '请选择原料分类！';
    } else if ($materialUnit == '') {
        $str['success'] = false;
        $str['message'] = '请选择单位！';
    } else if ($Price == '') {
        $str['success'] = false;
        $str['message'] = '请填写采购标准价！';
    } else if (!is_numeric($Price)) {
        $str['success'] = false;
        $str['message'] = '数字格式错误，请输入数字';
    } else if ($maxPrice == '') {
        $str['success'] = false;
        $str['message'] = '请填写采购最高价！';
    } else if (!is_numeric($maxPrice)) {
        $str['success'] = false;
        $str['message'] = '数字格式错误，请输入数字';
    } else if ($maxPrice < $Price || $maxPrice == $Price) {
        $str['success'] = false;
        $str['message'] = '采购最高价应大于采购标准价格！';
    }else {
        $url = $config_host . '/service/gds/material/addMaterial';
        $datas = array('datas' => array('vo' => array(
            'typeId' => $materialCategory,
            'name' => $materialName,
            'unit' => $materialUnit,
            'spec' => $specification,
            'standardPrice' => $Price,
            'maxPrice' => $maxPrice,
            'openState' => $check,
            'stoId' => $stoId,
            'createId' => $_SESSION['bUserId']
        )));
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
    }
    echo json_encode($str);
    exit;
} else if ($type == 'modify') {
    $mifId = $postData->mifId;
    $materialName = $postData->materialName;
    $materialCategory = $postData->materialCategory;
    $materialUnit = $postData->materialUnit;
    $specification = $postData->specification;
    $Price = $postData->Price;
    $maxPrice = $postData->maxPrice;
    $check = $postData->check;
    if ($materialName == '') {
        $str['success'] = false;
        $str['message'] = '原料名称不能为空！';
    } else if ($materialCategory == '') {
        $str['success'] = false;
        $str['message'] = '请选择原料分类！';
    } else if ($materialUnit == '') {
        $str['success'] = false;
        $str['message'] = '请选择单位！';
    } else if ($Price == '') {
        $str['success'] = false;
        $str['message'] = '请填写采购标准价！';
    } else if (!is_numeric($Price)) {
        $str['success'] = false;
        $str['message'] = '数字格式错误，请输入数字';
    } else if ($maxPrice == '') {
        $str['success'] = false;
        $str['message'] = '请填写采购最高价！';
    } else if (!is_numeric($Price)) {
        $str['success'] = false;
        $str['message'] = '数字格式错误，请输入数字';
    } else if ($maxPrice < $Price || $maxPrice == $Price) {
        $str['success'] = false;
        $str['message'] = '采购最高价应大于采购标准价格！';
    } else {
        $url = $config_host . '/service/gds/material/updateMaterial';
        $datas = array('datas' => array('vo' => array(
            'id' => $mifId,
            'typeId' => $materialCategory,
            'name' => $materialName,
            'unit' => $materialUnit,
            'spec' => $specification,
            'standardPrice' => $Price,
            'maxPrice' => $maxPrice,
            'openState' => $check,
            'modifyId' => $_SESSION['bUserId']
        )));
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
    }
    echo json_encode($str);
    exit;
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求出错！';
    echo json_encode($str);
    exit;

}
//file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>