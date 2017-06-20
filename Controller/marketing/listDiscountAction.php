<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $discountName = $postData->discountName;
    $discountWay = $postData->discountWay;
    $discountType = $postData->discountType;
    $url = $config_host . '/service/sto/discount/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'name' => $discountName,
        'type' => $discountWay,
        'status' => $discountType,
        'stoId' => $stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "proList") {
    $url = $config_host . '/service/gds/manage/goods/queryStoreGoods';
    $datas = array('datas' => array('stoId' => $stoId));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['goodsList'];
    echo json_encode($str);
    exit;
} else if ($type == "add") {
    $name = $postData->name;
    $discount = $postData->discount;
    $types = $postData->types;
    $startDate = $postData->startDate;
    $endDate = $postData->endDate;
    $goodsLists = object2array($postData->goodsList);
    if ($name == '') {
        $str['success'] = false;
        $str['message'] = '请填写折扣名称！';
        echo json_encode($str);
        exit;
    }
    if ($discount == '') {
        $str['success'] = false;
        $str['message'] = '请填写折扣百分比！';
        echo json_encode($str);
        exit;
    }
    if ($types == '') {
        $str['success'] = false;
        $str['message'] = '请选择折扣方式！';
        echo json_encode($str);
        exit;
    }
    if ($startDate == '') {
        $str['success'] = false;
        $str['message'] = '请选择开始时间！';
        echo json_encode($str);
        exit;
    }
    if ($endDate == '') {
        $str['success'] = false;
        $str['message'] = '请选择结束时间！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/sto/discount/add';
    $datas = array('datas' => array(
        'discountVO' => array(
            'stoId' => $stoId,
            'name' => $name,
            'discount' => number_format(($discount / 100), 2),
            'type' => (int)$types,
            'startDate' => $startDate . ' 00:00:00',
            'endDate' => $endDate . ' 00:00:00',
            "createId" => $_SESSION['bUserId']
        ),
        'goodsList' => $goodsLists
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
} else if ($type == "open" || $type == "close") {
    $id = $postData->id; // 获取当前页
    $url = $config_host . '/service/sto/discount/change';
    $datas = array('datas' => array(
        'ids' => $id,
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
} else if ($type == "del") {
    $ids = object2array($postData->ids);
    if (is_array($ids)) {
        $delIds = implode(',', $ids);
    } else {
        $delIds = $ids;
    }
    $url = $config_host . '/service/sto/discount/delete';
    $datas = array('datas' => array('ids' => $delIds));
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
} else if ($type == "oneList") {
    $oneId = object2array($postData->oneId);
    $url = $config_host . '/service/sto/discount/getById/' . $oneId;
    $json = http($url, '', 1);
    $list = $json['datas']['discountVO'];
    $product = $json['datas']['goodsList'];
    $str['list'] = $json['datas']['discountVO'];
    $str['detail'] = $json['datas']['goodsList'];
    echo json_encode($str);
    exit;
} else if ($type == "modify") {
    $sid = $postData->sid;
    $name = $postData->name;
    $discount = $postData->discount;
    $types = $postData->types;
    $startDate = $postData->startDate;
    $endDate = $postData->endDate;
    $goodsLists = object2array($postData->goodsList);
    if ($name == '') {
        $str['success'] = false;
        $str['message'] = '请填写折扣名称！';
        echo json_encode($str);
        exit;
    }
    if ($discount == '') {
        $str['success'] = false;
        $str['message'] = '请填写折扣百分比！';
        echo json_encode($str);
        exit;
    }
    if ($types == '') {
        $str['success'] = false;
        $str['message'] = '请选择折扣方式！';
        echo json_encode($str);
        exit;
    }
    if ($startDate == '') {
        $str['success'] = false;
        $str['message'] = '请选择开始时间！';
        echo json_encode($str);
        exit;
    }
    if ($endDate == '') {
        $str['success'] = false;
        $str['message'] = '请选择结束时间！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/sto/discount/update';
    $datas = array('datas' => array(
        'discountVO' => array(
            'id' => $sid,
            'stoId' => $stoId,
            'name' => $name,
            'discount' => number_format(($discount / 100), 2),
            'type' => (int)$types,
            'startDate' => $startDate . ' 00:00:00',
            'endDate' => $endDate . ' 00:00:00',
            "createId" => $_SESSION['bUserId']
        ),
        'goodsList' => $goodsLists
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
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求报错！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>