<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $no = $postData->no;
    $scrapDateStart = $postData->scrapDateStart;
    $scrapDateEnd = $postData->scrapDateEnd;
    $operator = $postData->operator;
    $url = $config_host . '/service/gds/stock/scrap/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'no' => $no,
        'personName' => $operator
    ));
    if ($scrapDateStart != '') {
        $datas['datas']['scrapDateStart'] = $scrapDateStart . ' 00:00:00';
    }
    if ($scrapDateEnd != '') {
        $datas['datas']['scrapDateEnd'] = $scrapDateEnd . ' 23:59:59';
    }
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'details') {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $deltailId = $postData->id;
    $url = $config_host . '/service/gds/stock/scrap/detail/' . $deltailId;
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['scrapStockInfo'] = $json['datas']['scrapStockInfo'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'cat') {
    $url = $config_host . '/service/gds/manage/category/list';
    $data = array('datas' => array('stoId' => $stoId));
    $json = http($url, $data, 1);
    $str['list'] = $json['datas']['list'];
    echo json_encode($str);
    exit;
} else if ($type == 'goods') {
    $catId = $postData->catId;
    $url = $config_host . '/service/gds/stock/finishedProduct/list';
    $data = array('datas' => array(
        'stoId' => $stoId,
    ));
    if ($catId != '' || $catId != NULL) {
        $data['datas']['catId'] = $catId;
    }
    $json = http($url, $data, 1);
    $str['list'] = $json['datas']['list'];
    echo json_encode($str);
    exit;
} else if ($type == 'session') {
    unset ($_SESSION['checked']);
    unset ($_SESSION['skuId']);
    $checked = $postData->checked;
    $skuId = $postData->skuId;
    if ($checked != '' || $skuId != '') {
        if (empty($_SESSION['checked'])) {
            $_SESSION['checked'] = $checked;
        } else {
            $_SESSION['checked'] = array_unique(array_merge($_SESSION['checked'], $checked));
        }
        if (empty($_SESSION['skuId'])) {
            $_SESSION['skuId'] = $skuId;
        } else {
            $_SESSION['skuId'] = array_unique(array_merge($_SESSION['skuId'], $skuId));
        }
        $str['success'] = true;
        echo json_encode($str);
        exit;
    } else {
        $str['success'] = false;
        $str['message'] = '请选择商品！';
        echo json_encode($str);
        exit;
    }
} else if ($type == 'addDelete') {
    $datas = $postData->datas;
    $url = $config_host . '/service/gds/stock/scrap/save';
    $json = http($url, $datas, 1);
    if ($json['success']) {
        unset ($_SESSION['checked']);
        unset ($_SESSION['skuId']);
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '报废成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '报废失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'unset') {
    unset ($_SESSION['checked']);
    unset ($_SESSION['skuId']);
    $str['success'] = true;
    echo json_encode($str);
    exit;
} else {
    $str['success'] = true;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>