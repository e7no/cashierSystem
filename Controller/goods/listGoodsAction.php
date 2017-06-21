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
    $CatId = $postData->CatId;
    $StoType = $postData->StoType;
    $quick = $postData->quick;
    if($stoType==1){
        $pStoId='';
    }else{
        $pStoId=$_SESSION['pid'];
    }
    $url = $config_host . '/service/gds/manage/goods/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'catId' => $CatId,
        'searchText' => $quick,
        'state' => 1,
    ));
    if ($StoType != '' && $StoType != 0) {
        $datas['datas']['type'] = (int)$StoType;
    }
    if($pStoId!=''){
        $datas['datas']['pStoId'] = $pStoId;
    }
    $json = http($url, $datas, 1);
    $str['filePath'] = $json['datas']['filePath'];
    $str['compelDownGoods'] = $json['datas']['compelDownGoods'];
    $str['editParentGoodsStatus'] = $json['datas']['editParentGoodsStatus'];
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'add') {
    $catId = $postData->catId;
    $name = $postData->name;
    $unit = $postData->unit;
    $barCode = $postData->barCode;
    $status = $postData->status;
    $bigImagePath = $postData->bigImagePath;
    $weight = $postData->weight;
    $stockManage = $postData->stockManage;
    $temporary  = $postData->temporary;
    $bzq = $postData->bzq;
    $saleStatus = $postData->saleStatus;
    $takeOut = $postData->takeOut;
    $useIntegral = $postData->useIntegral;
    $norms = $postData->norms;
    $inPrice = $postData->inPrice;
    $salePrice = $postData->salePrice;
    $takeOutPrice = $postData->takeOutPrice;
    $integral = $postData->integral;
    $nums=$postData->nums;
    if($name==''){
        $str['success'] = false;
        $str['message'] = '商品名称不能为空';
        echo json_encode($str);
        exit;
    }
    if($catId==''){
        $str['success'] = false;
        $str['message'] = '请选择商品分类';
        echo json_encode($str);
        exit;
    }
    if($unit==''){
        $str['success'] = false;
        $str['message'] = '请选择单位';
        echo json_encode($str);
        exit;
    }
    if($inPrice[0]==''){
        $str['success'] = false;
        $str['message'] = '请填写进价!';
        echo json_encode($str);
        exit;
    }
//    if($inPrice[0]==0){
//        $str['success'] = false;
//        $str['message'] = '进价不能为0!';
//        echo json_encode($str);
//        exit;
//    }
    if($saleStatus==1){
        if($salePrice[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写收银价!';
            echo json_encode($str);
            exit;
        }
    }
    if($takeOut==1){
        if($takeOutPrice[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写商城价!';
            echo json_encode($str);
            exit;
        }
    }
    if($useIntegral==1){
        if($integral[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写积分价!';
            echo json_encode($str);
            exit;
        }
    }
    if ($stoType == 1) {
        $stype = 2;
    } else {
        $stype = 1;
    }
    $noreNum = count($norms);
    $url = $config_host . '/service/gds/manage/goods/add';
    $datas = array('datas' => array(
        'goodsVO' => array(
            'stoId' => $stoId,
            'catId' => $catId,
            'name' => $name,
            'unit' => $unit,
            'barCode' => $barCode,
            'saleStatus' => $saleStatus,
            'status' => $status,
            'takeOut' => $takeOut,
            'useIntegral' => $useIntegral,
            'bigImagePath' => $bigImagePath,
            'type' => $stype,
            'weight' => $weight,
            'stockManage' => $stockManage,
        	'temporary' => $temporary,
            'bzq' => $bzq,
            'createId' => $userId,
        ),
    ));
    if ($noreNum == 0) {
        $datas['datas']['skuList'][0]['inPrice'] = $inPrice[0] ? $inPrice[0] : '';
        $datas['datas']['skuList'][0]['salePrice'] = $salePrice[0] ? $salePrice[0] : '';
        $datas['datas']['skuList'][0]['takeOutPrice'] = $takeOutPrice[0] ? $takeOutPrice[0] : '';
        $datas['datas']['skuList'][0]['integral'] = $integral[0] ? $integral[0] : '';
    } else {
        for ($i = 0; $i < $nums; $i++) {
            $datas['datas']['skuList'][$i]['name'] = $norms[$i] ? $norms[$i] : '';
            $datas['datas']['skuList'][$i]['inPrice'] = $inPrice[$i] ? $inPrice[$i] : '';
            $datas['datas']['skuList'][$i]['salePrice'] = $salePrice[$i] ? $salePrice[$i] : '';
            $datas['datas']['skuList'][$i]['takeOutPrice'] = $takeOutPrice[$i] ? $takeOutPrice[$i] : '';
            $datas['datas']['skuList'][$i]['integral'] = $integral[$i] ? $integral[$i] : '';
        }
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
} else if ($type == 'modify') {
    $id = $postData->id;
    $ids = $postData->ids;
    $num = $postData->num;
    $catId = $postData->catId;
    $name = $postData->name;
    $unit = $postData->unit;
    $barCode = $postData->barCode;
    $status = $postData->status;
    $bigImagePath = $postData->bigImagePath;
    $weight = $postData->weight;
    $stockManage = $postData->stockManage;
    $temporary = $postData->temporary;
    $bzq = $postData->bzq;
    $saleStatus = $postData->saleStatus;
    $takeOut = $postData->takeOut;
    $useIntegral = $postData->useIntegral;
    $norms = $postData->norms;
    $inPrice = $postData->inPrice;
    $salePrice = $postData->salePrice;
    $takeOutPrice = $postData->takeOutPrice;
    $integral = $postData->integral;
    if($name==''){
        $str['success'] = false;
        $str['message'] = '商品名称不能为空';
        echo json_encode($str);
        exit;
    }
    if($catId==''){
        $str['success'] = false;
        $str['message'] = '请选择商品分类';
        echo json_encode($str);
        exit;
    }
    if($unit==''){
        $str['success'] = false;
        $str['message'] = '请选择单位';
        echo json_encode($str);
        exit;
    }
    if ($num > 1 && count($norms) < $num || $num > 1 && $norms[0] == null) {
        $str['success'] = false;
        $str['message'] = '请填写规格名称!';
        echo json_encode($str);
        exit;
    }
//    if($inPrice[0]==''){
//        $str['success'] = false;
//        $str['message'] = '进价不能为空!';
//        echo json_encode($str);
//        exit;
//    }
    if($inPrice[0]==''){
        $str['success'] = false;
        $str['message'] = '请填写进价!';
        echo json_encode($str);
        exit;
    }
    if($saleStatus==1){
        if($salePrice[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写收银价!';
            echo json_encode($str);
            exit;
        }
    }
    if($takeOut==1){
        if($takeOutPrice[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写商城价!';
            echo json_encode($str);
            exit;
        }
    }
    if($useIntegral==1){
        if($integral[0]==''){
            $str['success'] = false;
            $str['message'] = '请填写积分价!';
            echo json_encode($str);
            exit;
        }
    }
    $url = $config_host . '/service/gds/manage/goods/update';
    $datas = array('datas' => array(
        'goodsVO' => array(
            'id' => $id,
            'stoId' => $stoId,
            'catId' => $catId,
            'name' => $name,
            'unit' => $unit,
            'barCode' => $barCode,
            'saleStatus' => $saleStatus,
            'status' => $status,
            'takeOut' => $takeOut,
            'useIntegral' => $useIntegral,
            'bigImagePath' => $bigImagePath,
            'weight' => $weight,
        	'stockManage' => $stockManage,
        	'temporary' => $temporary,
            'bzq' => $bzq,
            'modifyId' => $userId,
        ),
    ));
    for ($i = 0; $i < $num; $i++) {
        if ($ids[$i] != '') {
            $datas['datas']['skuList'][$i]['id'] = $ids[$i];
        }
        $datas['datas']['skuList'][$i]['name'] = $norms[$i] ? $norms[$i] : '';
        $datas['datas']['skuList'][$i]['inPrice'] = $inPrice[$i] ? $inPrice[$i] : '';
        $datas['datas']['skuList'][$i]['salePrice'] = $salePrice[$i] ? $salePrice[$i] : '';
        $datas['datas']['skuList'][$i]['takeOutPrice'] = $takeOutPrice[$i] ? $takeOutPrice[$i] : '';
        $datas['datas']['skuList'][$i]['integral'] = $integral[$i] ? $integral[$i] : '';
    }
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '修改成功！';
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
} else if ($type == 'del') {
    $ids = object2array($postData->ids);
    $url = $config_host . '/service/gds/manage/goods/delete';
    $datas = array('datas' => array(
        'modifyId' => $userId
    ));
    if (is_array($ids)) {
        $delIds = $ids;
        $datas['datas']['ids'] = $ids;
    } else {
        $datas['datas']['ids'][0] = $postData->ids;
    }
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
} else if ($type == 'up') {
    $upid = $postData->id;
    $url = $config_host . '/service/gds/manage/goods/updateStatus';
    $datas = array('datas' => array(
        'goodsId' => $upid,
        'status' => 0,
        'modifyId' => $userId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '上架成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '上架失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'down') {
    $upid = $postData->id;
    $url = $config_host . '/service/gds/manage/goods/updateStatus';
    $datas = array('datas' => array(
        'goodsId' => $upid,
        'status' => 1,
        'modifyId' => $userId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '下架成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '下架失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'ctl') {
    $ctlId = $postData->id;
    $url = $config_host . '/service/gds/manage/goods/getPriceAdjust/' . $ctlId;
    $json = http($url, '', 1);
    $str['parentGoodsObj'] = $json['datas']['parentGoodsObj'];
    $str['subGoodsList'] = $json['datas']['subGoodsList'];
    echo json_encode($str);
    exit;
} else if ($type == 'delete') {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $CatId = $postData->CatId;
    $StoType = $postData->StoType;
    $quick = $postData->quick;
    $url = $config_host . '/service/gds/manage/goods/discard/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'state' => 0,
        'type' => $StoType,
        'catId' => $CatId,
        'searchText' => $quick
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['filePath'] = $json['datas']['filePath'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == 'recover') {
    $rcId = $postData->id;
    $url = $config_host . '/service/gds/manage/goods/undelete';
    $datas = array('datas' => array(
        'modifyId' => $userId
    ));
    $datas['datas']['ids'][0] = $rcId;
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
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
} else if ($type == 'update') {
    $url = $config_host . '/service/gds/manage/goods/download';
    $datas = array('datas' => array(
        'stoId' => $stoId,
        'operator' => $userId
    ));
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '下载成功！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    } else {
        $str['success'] = false;
        if ($json['errMsg'] == '') {
            $str['message'] = '下载失败！';
        } else {
            $str['message'] = $json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
} else if ($type == 'detail') {
    $id = $postData->dId;
    $url = $config_host . '/service/gds/manage/goods/get/' . $id;
    $json = http($url, '', 1);
    $str['list'] = $json['datas']['dto'];
    $str['filePath'] = $json['datas']['filePath'];
    $str['sku'] = $json['datas']['dto']['skuList'];
    echo json_encode($str);
    exit;
} else if ($type == 'updateCtl') {
    $datas['datas'] = object2array($postData->datas);
    $url = $config_host . '/service/gds/manage/goods/doPriceAdjust';
    $json = http($url, $datas, 1);
    if ($json['success']) {
        $str['success'] = true;
        if ($json['errMsg'] == '') {
            $str['message'] = '修改成功！';
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
} else {
    $str['success'] = false;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>