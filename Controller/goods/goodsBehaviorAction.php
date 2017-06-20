<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$stoType = $_SESSION['stoType'];
if ($type == "list") {
    $url = $config_host . '/service/gds/manage/dishes/practices';
    $datas = array('datas' => array(
        'stoId' => $stoId,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'add') {
    $name = $postData->name;
    if ($name == '') {
        $str['success'] = false;
        $str['message'] = '名称不能为空';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/manage/dishes/addPractice';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'name' => $name,
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
    $id = $postData->id;
    if ($id == '') {
        $str['success'] = false;
        $str['message'] = '请选择要删除的做法';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/manage/dishes/delPractice/' . $id;
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
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//   file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>