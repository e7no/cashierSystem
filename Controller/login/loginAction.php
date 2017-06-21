<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input"));
$type = $postData->type;
if($type=="login"){
	$code = $postData->code;
	$login = $postData->name;
	$pwd = $postData->pwd;
	$url = $config_host . '/service/sys/bizCloudLogin';
	$data = array('datas' => array('code' => $code, 'login' => $login, 'pwd' => $pwd));
	$str = http($url, $data, 1);
	if ($str["success"]) {
	    $_SESSION['stoId'] = $str["datas"]["userMap"]["stoId"];
	    $_SESSION['bUserId'] = $str["datas"]["userMap"]["userId"];
	    $_SESSION['busId'] = $str["datas"]["userMap"]["busId"];
	    $_SESSION['stoType'] = $str["datas"]["userMap"]["stoType"];
	    $_SESSION['pid'] = $str["datas"]["userMap"]["pid"];
	    $_SESSION['code'] = $str["datas"]["userMap"]["code"];
	    $_SESSION['stoName'] = $str["datas"]["userMap"]["stoName"];
	    $_SESSION['authManageEmp'] = $str["datas"]["userMap"]["authManageEmp"];
	    $_SESSION['authDownGoods'] = $str["datas"]["userMap"]["authDownGoods"];
	    $_SESSION['authModifyPrice'] = $str["datas"]["userMap"]["authModifyPrice"];
	    $_SESSION['time']=time();
	    $_SESSION['login']=$login;
	    $json['login'] = true;
	} else {
	    $json['errMsg'] = $str['errMsg'];
	    $json['login'] = false;
	}
	echo json_encode($json);
	exit;
}else if($type=="modifypass"){
	$password = $postData->password;
	$newpassword = $postData->newpassword;
	$surepassword = $postData->surepassword;
	$url = $config_host . '/service/sys/updatePassword';
	$data = array('datas' => array('oldPwd' => $password, 'login' => $_SESSION['login'], 'newPwd' => $newpassword));
	$json = http($url, $data, 1);
	if ($json['success']) {
		$str['success'] = true;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '恭喜你，密码已经重置';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	} else {
		$str['success'] = false;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '密码重置失败';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	}
	echo json_encode($str);
	exit;
}else if($type=="forgetpass"){
	$mobile = $postData->mobile;
	$newpassword = $postData->newPassword;
	$verify = $postData->verify;
	$url = $config_host . '/service/sys/resetPassword';
	$data = array('datas' => array('mobile' => $mobile, 'verify' => $verify, 'newPassword' => $newpassword));
	$json = http($url, $data, 1);
	if ($json['success']) {
		$str['success'] = true;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '恭喜你，密码已经重置';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	} else {
		$str['success'] = false;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '密码重置失败';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	}
	echo json_encode($str);
	exit;
}else if($type=="getverify"){
	$mobile = $postData->mobile;
	$url = $config_host . '/service/sys/sendVerify';
	$data = array('datas' => array('mobile' => $mobile));
	$json = http($url, $data, 1);
	if ($json['success']) {
		$str['success'] = true;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '已经发送短信到手机号码，请注意查收';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	} else {
		$str['success'] = false;
		if ($json['errMsg'] == '') {
			$str['errMsg'] = '发送失败';
		} else {
			$str['errMsg'] = $json['errMsg'];
		}
	}
	echo json_encode($str);
	exit;
}
//file_put_contents("log.txt", "json信息：" . var_export($str, TRUE) . "\n", FILE_APPEND);
?>

