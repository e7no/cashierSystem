<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
if ($type == "Klblist") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $keyword = $postData->keyword; // 获取当前页
    $stoId = $postData->stoId; // 获取当前页
    $url = $config_host . '/service/sto/klb/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId,
        'keyword'=>$keyword
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if ($type == "del") {
	$id = $postData->id; // 获取当前页
	$ids = "";
	if(is_array( $id )){
		for ($i = 0; $i < count($id); $i++){
			$ids .= $id[$i].",";
		}
	}
	$ids = rtrim($ids,",");
	if($ids==""){
		$ids = $id;
	}
	$url = $config_host . '/service/sto/klb/delete/'.$ids;
	$json = http($url, "", 1);
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
}else if($type == "addKlb"){
    $klbName = $postData->klbName; // 获取当前页
    $klbSn = $postData->klbSn; // 获取当前页
    $klbApiKey = $postData->klbApiKey; // 获取当前页
    $klbShopCode = $postData->klbShopCode; // 获取当前页
    $url = $config_host . '/service/sto/klb/add';
    $datas = array('datas' => array('vo'=>array(
        'stoId' => $stoId,
        'klbName' => $klbName,
        'klbSn' => $klbSn,
        'klbApiKey' => $klbApiKey,
        'klbShopCode' => $klbShopCode
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
}else if($type == "modifyKlb"){
	$id = $postData->id; // 获取当前页
    $klbName = $postData->klbName; // 获取当前页
    $klbSn = $postData->klbSn; // 获取当前页
    $klbApiKey = $postData->klbApiKey; // 获取当前页
    $klbShopCode = $postData->klbShopCode; // 获取当前页
    $url = $config_host . '/service/sto/klb/update';
    $datas = array('datas' => array('vo'=>array(
    	'id' => $id,
        'klbName' => $klbName,
        'klbSn' => $klbSn,
        'klbApiKey' => $klbApiKey,
        'klbShopCode' => $klbShopCode
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
}else{
    $str['success'] = true;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>