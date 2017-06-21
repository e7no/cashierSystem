<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $name = $postData->name;
    $mobile = $postData->mobile;
    $stoType= $_SESSION['stoType'];
    $stoId = $_SESSION['stoId'];
    $url = $config_host . '/service/sto/manage/empList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId' => $stoId,
        'stoType'=>$stoType,
        'name' => $name,
        'mobile' => $mobile,
        'state' => '1'
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
} else if ($type == "check") {
    $id = $postData->id;
    $url = $config_host . '/service/sto/manage/stoList';
    $data['datas']['pid']=$id;
    $json = http($url, $data, 1);
    $str = $json['datas']['list'];
    echo json_encode($str);
    exit;
}else if($type == "add"){
    $stoIdstaff=$postData->stoIdstaff;
    $name = $postData->name;
    $mobile = $postData->mobile;
    $roleId=$postData->roleId;
    $url = $config_host . '/service/sto/manage/addEmp';
    $datas = array('datas' => array(
        'stoId' => $stoIdstaff,
        'name' => $name,
        'mobile' => $mobile,
        'roleId' => $roleId
    ));
    $json = http($url, $datas, 1);
    if($json['success']){
        $str['success']=true;
        $str['message']='添加成功！';
        echo json_encode($str);
        exit;
    }else{
        $str['success']=false;
        $str['message']= $json['errMsg'];
        echo json_encode($str);
        exit;
    }
}else if($type == "modify"){
    $id=$postData->id;
    $stoIdstaff=$postData->stoIdstaff;
    $name = $postData->name;
    $mobile = $postData->mobile;
    $roleId=$postData->roleId;
    $url = $config_host . '/service/sto/manage/editEmp';
    $datas = array('datas' => array(
        'id' => $id,
        'stoId' => $stoIdstaff,
        'name' => $name,
        'mobile' => $mobile,
        'roleId' => $roleId
    ));
    $json = http($url, $datas, 1);
    if($json['success']){
        $str['success']=true;
        $str['message']='修改成功！';
        echo json_encode($str);
        exit;
    }else{
        $str['success']=false;
        $str['message']= $json['errMsg'];
        echo json_encode($str);
        exit;
    }
}else if($type='del'){
    $id=$postData->id;
    $url = $config_host . '/service/sto/manage/delEmp/'.$id;
    $json = http($url, '', 1);
    if($json['success']){
        if($json['datas']['flag']){
            $str['success']=true;
            $str['message']='修改成功！';
            echo json_encode($str);
            exit;
        }else{
            $str['success']=false;
            $str['message']='删除失败！';
            echo json_encode($str);
            exit;
        }
    }else{
        $str['success']=false;
        $str['message']= $json['errMsg'];
        echo json_encode($str);
        exit;
    }
}
//file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
?>