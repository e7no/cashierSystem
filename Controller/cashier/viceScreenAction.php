<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/sto/viceScreen/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "priterlist") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/sto/printer/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "basic") {
    $url = $config_host . '/service/sto/manage/storeBasic/getByStoreId/' . $stoId;
    $json = http($url, "", 1);
    $str['paperFee'] = $json['datas']['basicSettingsVO']['paperFee'];
    $str['backupCash'] = $json['datas']['basicSettingsVO']['backupCash'];
    $str['payRound'] = $json['datas']['basicSettingsVO']['payRound'];
    $str['id'] = $json['datas']['basicSettingsVO']['id'];
    echo json_encode($str);
    exit;
} else if ($type == "basicset") {
    $url = $config_host . '/service/sto/manage/storeBasic/update';
    $datas = array('datas' => array('vo' => array(
        'id' => $postData->id,
        'stoId' => $stoId,
        'backupCash' => $postData->backupCash,
        'payRound' => $postData->payRound,
        'paperFee' => $postData->paperFee
    )));
    $json = http($url, $datas, 1);
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
} else if ($type == "add") {
    $name = $postData->name; // 获取当前页
    $sn = $postData->sn; // 获取当前页
    $imgPath = $postData->imgPath; // 获取当前页
    $status = $postData->status; // 获取当前页
    $url = $config_host . '/service/sto/viceScreen/add';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'name' => $name,
        'sn' => $sn,
        'imgPath' => $imgPath,
        'status' => $status
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
    echo json_encode($str);
    exit;
} else if ($type == "modify") {
    $name = $postData->name; // 获取当前页
    $id = $postData->id; // 获取当前页
    $sn = $postData->sn; // 获取当前页
    $imgPath = $postData->imgPath; // 获取当前页
    $status = $postData->status; // 获取当前页
    $url = $config_host . '/service/sto/viceScreen/udpate';
    $datas = array('datas' => array('vo' => array(
        'id' => $id,
        'stoId' => $stoId,
        'name' => $name,
        'sn' => $sn,
        'imgPath' => $imgPath,
        'status' => $status
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
    echo json_encode($str);
    exit;
} else if ($type == 'checkImg') {
    $imgId = $postData->imgId; // 获取当前页
    $url = $config_host . '/service/sto/viceScreen/getById/' . $imgId;
    $json = http($url, '', 1);
    if ($json['success']) {
        $str['success'] = true;
        $str['pic'] = $json['datas']['viceScreenImgVO']['imgPath'];
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
} else if ($type == 'del') {
    $delId = $postData->delId; // 获取当前页
    $url = $config_host . '/service/sto/viceScreen/delete';
    $datas = array('datas' => array(
        'ids' => $delId,
    ));
    $json = http($url, $datas, 1);
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
} else if ($type == 'set') {
    $time = $postData->time; // 获取当前页
    $status = $postData->status; // 获取当前页
    if ($time < 0 || $time == 0) {
        $str['success'] = false;
        $str['message'] = '时间必须大于0！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/sto/manage/storeBasic/update';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'viceScreen' => $status,
        'interv' => $time,
    )));
    $json = http($url, $datas, 1);
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
} else if ($type == "addArea") {
    $name = $postData->name; // 获取当前页
    $additionalFee = $postData->additionalFee; // 获取当前页
    $url = $config_host . '/service/sto/tableArea/add';
    $datas = array('datas' => array('vo' => array(
        'stoId' => $stoId,
        'name' => $name,
        'additionalFee' => $additionalFee,
        'createId' => $userId
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
    echo json_encode($str);
    exit;
} else if ($type == "addTable") {
    $name = $postData->name; // 获取当前页
    $additionalFee = $postData->additionalFee; // 获取当前页
    $galleryful = $postData->galleryful; // 获取当前页
    $areaType = $postData->areaType; // 获取当前页
    $url = $config_host . '/service/sto/table/add';
    $datas = array('datas' => array('vo' => array(
        'busId' => $busId,
        'stoId' => $stoId,
        'name' => $name,
        'galleryful' => $galleryful,
        'areaType' => $areaType,
        'additionalFee' => $additionalFee,
        'createId' => $userId
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
    echo json_encode($str);
    exit;
} else if ($type == "delArea") {
    $ids = $postData->ids; // 获取当前页
    $url = $config_host . '/service/sto/tableArea/delete';
    $datas = array('datas' => array(
        'ids' => $ids
    ));
    $json = http($url, $datas, 1);
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
} else if ($type == 'Tabledel') {
    $delId = $postData->id; // 获取当前页
    $url = $config_host . '/service/sto/table/delete';
    $ids = "";
    if (is_array($delId)) {
        for ($i = 0; $i < count($delId); $i++) {
            $ids .= $delId[$i] . ",";
        }
    }
    $ids = rtrim($ids, ",");
    if ($ids == "") {
        $ids = $delId;
    }
    $datas = array('datas' => array(
        'ids' => $ids,
    ));
    $json = http($url, $datas, 1);
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
} else if ($type == 'Printerdel') {
    $delId = $postData->id; // 获取当前页
    $url = $config_host . '/service/sto/printer/delete';
    $ids = "";
    if (is_array($delId)) {
        for ($i = 0; $i < count($delId); $i++) {
            $ids .= $delId[$i] . ",";
        }
    }
    $ids = rtrim($ids, ",");
    if ($ids == "") {
        $ids = $delId;
    }
    $datas = array('datas' => array(
        'ids' => $ids,
    ));
    $json = http($url, $datas, 1);
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
} else if ($type == 'modifyTable') {
    $name = $postData->name; // 获取当前页
    $additionalFee = $postData->additionalFee; // 获取当前页
    $galleryful = $postData->galleryful; // 获取当前页
    $areaType = $postData->areaType; // 获取当前页
    $id = $postData->id; // 获取当前页
    $url = $config_host . '/service/sto/table/update';
    $datas = array('datas' => array('vo' => array(
        'id' => $id,
        'busId' => $busId,
        'stoId' => $stoId,
        'name' => $name,
        'galleryful' => $galleryful,
        'areaType' => $areaType,
        'additionalFee' => $additionalFee,
        'modifyId' => $userId
    )));
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
            $str['message'] = '修改失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'printertemplate') {
    $id = $postData->id; // 获取当前页
    //获取设备号
    $url = $config_host . '/service/sto/printerTemplate/list';
    $datas = array('datas' => array(
        "printScene" => $id
    ));
    $json = http($url, $datas, 1);
    $list = $json['datas']['list'];
    echo json_encode($list);
    exit;
} else if ($type == 'printerList') {
    $id = $postData->id; // 获取当前页
    //获取设备号
    $url = $config_host . '/service/sto/printer/getById/' . $id;
    $json = http($url, '', 0);
    $list["goodsList"] = $json['datas']['goodsList'];
    $list["tempSetList"] = $json['datas']['tempSetList'];
    $list["printerVO"] = $json['datas']['printerVO'];
    $list["printerCatVO"] = $json['datas']['printerCatVO'];
    echo json_encode($list);
    exit;
} else if ($type == 'addprinter') {
    $catId = $postData->catId;
    $name = $postData->name;
    $ipAddress = $postData->ip;
    $spec = $postData->guige;
    $partPrint = $postData->partPrint;
    $allPrint = $postData->allPrint;
    $printScene = $postData->printScene;
    $nums = $postData->nums;
    $tmpname = $postData->tmpname;
    $tmpid = $postData->tmpid;
    $goodsList = $postData->goodsList;

    $count = count($nums);
    $counts = count($goodsList);
    $url = $config_host . '/service/sto/printer/add';
    $datas = array('datas' => array(
        'printerVO' => array(
            'stoId' => $stoId,
            'catId' => $catId,
            'name' => $name,
            'ipAddress' => $ipAddress,
            'spec' => $spec,
            'partPrint' => $partPrint,
            'allPrint' => $allPrint,
            'printScene' => (int)$printScene,
            'status' => 0,
            'createId' => $userId,
        ),
    ));
    for ($i = 0; $i < $counts; $i++) {
        $datas['datas']['goodsList'][$i] = $goodsList[$i] ? $goodsList[$i] : '';
    }
    //定义空数组
    $array = array();
    $array1 = array();
    $array2 = array();
    for ($i = 0; $i < $count; $i++) {
        if ($nums[$i] != "" && $nums[$i] != 0) {
            $array[] = $nums[$i];
            $array1[] = $tmpid[$i];
            $array2[] = $tmpname[$i];
        }
    }
    for ($i = 0; $i < count($array); $i++) {
        $datas['datas']['tempSetList'][$i]['tempId'] = $array1[$i] ? $array1[$i] : '';
        $datas['datas']['tempSetList'][$i]['tempName'] = $array2[$i] ? $array2[$i] : '';
        $datas['datas']['tempSetList'][$i]['printNum'] = $array[$i] ? $array[$i] : '';
    }
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
} else if ($type == 'eidtprinter') {
    $id = $postData->id;
    $catId = $postData->catId;
    $name = $postData->name;
    $ipAddress = $postData->ip;
    $spec = $postData->guige;
    $partPrint = $postData->partPrint;
    $allPrint = $postData->allPrint;
    $printScene = $postData->printScene;
    $nums = $postData->nums;
    $tmpname = $postData->tmpname;
    $tmpid = $postData->tmpid;
    $goodsList = $postData->goodsList;

    $count = count($nums);
    $counts = count($goodsList);
    $url = $config_host . '/service/sto/printer/udpate';
    $datas = array('datas' => array(
        'printerVO' => array(
            'id' => $id,
            'stoId' => $stoId,
            'catId' => $catId,
            'name' => $name,
            'ipAddress' => $ipAddress,
            'spec' => $spec,
            'partPrint' => $partPrint,
            'allPrint' => $allPrint,
            'printScene' => $printScene,
            'status' => 0,
            'createId' => $userId,
        ),
    ));
    /* for ($i = 0; $i < $count; $i++) {
        if($nums[$i]!="" && $nums[$i]!=0){
            $datas['datas']['tempSetList'][$i]['tempId'] = $tmpid[$i] ? $tmpid[$i] : '';
            $datas['datas']['tempSetList'][$i]['tempName'] = $tmpname[$i] ? $tmpname[$i] : '';
            $datas['datas']['tempSetList'][$i]['printNum'] = $nums[$i] ? $nums[$i] : '';
        }
    } */
    for ($i = 0; $i < $counts; $i++) {
        $datas['datas']['goodsList'][$i] = $goodsList[$i] ? $goodsList[$i] : '';
    }
    //定义空数组
    $array = array();
    $array1 = array();
    $array2 = array();
    for ($i = 0; $i < $count; $i++) {
        if ($nums[$i] != "" && $nums[$i] != 0) {
            $array[] = $nums[$i];
            $array1[] = $tmpid[$i];
            $array2[] = $tmpname[$i];
        }
    }
    for ($i = 0; $i < count($array); $i++) {
        $datas['datas']['tempSetList'][$i]['tempId'] = $array1[$i] ? $array1[$i] : '';
        $datas['datas']['tempSetList'][$i]['tempName'] = $array2[$i] ? $array2[$i] : '';
        $datas['datas']['tempSetList'][$i]['printNum'] = $array[$i] ? $array[$i] : '';
    }
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '修改完成！';
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
} else if ($type == 'chooseCat') {
    $catId = $postData->cid;
    $url = $config_host . '/service/sto/printerCat/list';
    $datas = array('datas' => array(
        'type' => $catId,
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
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