<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $url = $config_host . '/service/gds/material/findMaterialTypeList';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if($type=='add'){
    $typeName= $postData->typeName;
    if($typeName==''){
        $str['success']=false;
        $str['message']='请输入分类名称！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/material/addMaterialType';
    $datas = array('datas' =>array(
        'vo'=>array(
            'typeName' => $typeName,
            'createId'=>$_SESSION['bUserId'],
            'stoId'=>$stoId
     )));
    $json = http($url, $datas, 1);
    if($json['success']){
        $str['success']=true;
        if($json['errMsg']==''){
            $str['message']='恭喜你，分类添加成功！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }else{
        $str['success']=false;
        if($json['errMsg']==''){
            $str['message']='新增失败！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
}else if($type=='modify'){
    $id= $postData->id;
    $typeName= $postData->typeName;
    if($typeName==''){
        $str['success']=false;
        $str['message']='请输入分类名称！';
        echo json_encode($str);
        exit;
    }
    $url = $config_host . '/service/gds/material/updateMaterialType';
    $datas = array('datas' => array('vo'=>array(
        'id' => $id,
        'typeName' => $typeName,
        'modifyId'=>$_SESSION['bUserId'],
        'stoId'=>$stoId
    )));
    $json = http($url, $datas, 1);
    if($json['success']){
        $str['success']=true;
        if($json['errMsg']==''){
            $str['message']='恭喜你，分类修改成功！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }else{
        $str['success']=false;
        if($json['errMsg']==''){
            $str['message']='修改失败！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
}else if($type=='del'){
    $id= $postData->id;
    $url = $config_host . '/service/gds/material/deleteMaterialType';
    $datas = array('datas' => array(
        'ids' => $id
    ));
    $json = http($url, $datas, 1);
    if($json['success']){
        $str['success']=true;
        if($json['errMsg']==''){
            $str['message']='删除成功！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }else{
        $str['success']=false;
        if($json['errMsg']==''){
            $str['message']='删除失败！';
        }else{
            $str['message']=$json['errMsg'];
        }
    }
    echo json_encode($str);
    exit;
}else{
    $str['success']=false;
    $str['message']='服务端请求报错！';
    echo json_encode($str);
    exit;
}
?>