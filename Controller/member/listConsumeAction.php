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
    $cardNum = $postData->cardNum; // 获取每页多少条数据
    $cardName = $postData->cardName; // 获取每页多少条数据
    $cardPhone = $postData->cardPhone; // 获取每页多少条数据
    $createDateStart = $postData->createDateStart; // 获取每页多少条数据
    $createDateEnd = $postData->createDateEnd; // 获取每页多少条数据
    $cstoId = $postData->cstoId; // 获取每页多少条数据
    $stoType= $_SESSION['stoType'];
    $url = $config_host . '/service/mem/manage/cardWallet/consume';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'finishDateStart'=>$createDateStart,
        'finishDateEnd'=>$createDateEnd,
        'card'=>$cardNum,
        'realName'=>$cardName,
        'mobile'=>$cardPhone,
    ));
    if($stoType==1){
        if($cstoId==''){
            $datas['datas']['pid']=$_SESSION['stoId'];
        }else{
            $datas['datas']['stoId']=$cstoId;
        }
    }else{
        $datas['datas']['stoId']=$_SESSION['stoId'];
    }
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if($type=='check'){
    $ordId= $postData->ordId;
    $url = $config_host . '/service/mem/manage/consume/detail/'.$ordId;
    $json = http($url, '', 1);
    if($json['success']){
        $str['success']=true;
        $str['detail']=$json['datas']['detail'];
        $str['message']=$json['datas']['msgs'];
    }else{
        $str['success']=false;
        $str['message']='查询失败！';
    }
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>