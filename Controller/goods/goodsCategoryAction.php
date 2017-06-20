<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$stoType = $_SESSION['stoType'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $status = $postData->status; // 获取每页多少条数据
    $url = $config_host . '/service/gds/manage/category/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'status' => $status,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "add") {
    $name = $postData->name; // 获取每页多少条数据
    $sn = $postData->sn; // 获取每页多少条数据
    if ($name == '') {
        $str['success'] = false;
        $str['message'] = '请输入分类名称！';
        echo json_encode($str);
        exit;
    }
    if ($sn == '') {
        $str['success'] = false;
        $str['message'] = '请输入排序编号！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/manage/category/add';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'name' => $name,
        'sn' => $sn,
        'operator' => $userId
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
} else if ($type == 'modify') {
    $mcatId = $postData->catId; // 获取每页多少条数据
    $mname = $postData->name; // 获取每页多少条数据
    $msn = $postData->sn; // 获取每页多少条数据
    if ($mname == '') {
        $str['success'] = false;
        $str['message'] = '请输入分类名称！';
        echo json_encode($str);
        exit;
    }
    if ($msn == '') {
        $str['success'] = false;
        $str['message'] = '请输入排序编号！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/manage/category/update';
    $datas = array('datas' => array(
        'catId' => $mcatId,
        'name' => $mname,
        'sn' => $msn,
        'operator' => $userId
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
} else if ($type == 'del') {
    $delId = $postData->id; // 获取每页多少条数据
    $url = $config_host . '/service/gds/manage/category/disable/' . $delId . '/' . $userId;
    $json = http($url, '', 1);
    if ($json['success']) {
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
} else if ($type == 'recover') {
    $recId = $postData->id;
    $url = $config_host . '/service/gds/manage/category/enable/' . $recId . '/' . $userId;
    $json = http($url, '', 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '恢复成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '恢复失败！';
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
//   file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>