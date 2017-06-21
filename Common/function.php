<?php
/**
 * Created by PhpStorm.
 * User: Seven
 * Date: 2016/10/15
 * Time: 9:53
 * 公用方法
 */
error_reporting(E_ALL & ~E_NOTICE);
include "config_host.php";
//服务端接口数据交互
function http($url, $data = NULL, $json = false)//data:三维数组,转成JSON格式{datas:{page:1,pagesiz:10}}, json:是否用JSON传输 1：是 0：否
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        if ($json && is_array($data)) {
            $data = json_encode($data);
        }
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        if ($json) { //json=1,发送JSON数据
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length:' . strlen($data))
            );
        }
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($curl);
    $errorno = curl_errno($curl);
    if ($errorno) {
        return array('errorno' => false, 'errmsg' => $errorno);
    }
    curl_close($curl);
    return json_decode($res, true);
}
//post方式抓取API接口信息
function postData($url, $jsonStr)//$url=抓取地址   $jsonStr=数组
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonStr));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;',
            'Content-Length: ' . strlen(json_encode($jsonStr))
        )
    );
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return json_decode($response, true);//array($response);
}
//get方式获取API接口信息
function getData($url)//$url=抓取地址
{
	$info = file_get_contents($url);
	return json_decode($info);
}
//微信post方式抓取数据
function curlPost($url,$params){
	$ch = curl_init();
	$timeout = 5;
	curl_setopt ($ch, CURLOPT_URL, $url); //发贴地址  
	curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type: text/json'));//设置header属性  
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST,true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS,$params);  
	$file_contents = curl_exec($ch);//获得返回值  
	curl_close($ch);
	//$json=json_decode($file_contents,true);
	return $file_contents;
}
//微信get方式抓取数据
function curlGet($url,$method,$data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$temp = curl_exec($ch);
	return $temp;
}
//处理菜单权限的方法
function rolemenuoperate($checkurl,$userId,$url){
	$checkdata = array('datas' => array(
		"url" => $url,
		"userId" => (string)$userId
	));
	$json=postData($checkurl,$checkdata);
	$result = $json["datas"]["flag"];
	//file_put_contents("log.txt", "json信息：".var_export($checkdata,TRUE)."\n", FILE_APPEND);
	if(!$result && $userId!="1"){
		return false;
	}else{
		return true;
	}
}
//处理操作权限的方法
function roleoperate($checkurl,$userId,$url){
	$checkdata = array('datas' => array(
		"url" => $url,
		"userId" => (string)$userId
	));
	$json=postData($checkurl,$checkdata);
	//file_put_contents("log.txt", "json信息：".var_export($json,TRUE)."\n", FILE_APPEND);
	$result = $json["datas"]["flag"];
	if(!$result && $userId!=1){
		return "rolecss";
	}else{
		return "";
	}
}
//小数点的处理公共函数
function rounded($str,$number){
	return number_format($str, $number, '.', '');
}
//小数点的处理公共函数 
function rounds($s,$number){
	$s = trim(strval($s));
	if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
		$num = preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
		$arr=explode(".",$num);
		if($number==2){
			return number_format($num, 2, '.', '');
		}       
	}
	if($s=="0"){
		$num = number_format($s, 2, '.', '');
	}else if(strlen($s)==1 || strlen($s)==2 || strlen($s)==3){
		$num = number_format($s, 2, '.', '');
	}else if($number==2){
		$num = number_format($s, $number, '.', '');
	}else{
		$arr=explode(".",$num);
		if(strlen($arr[1])>7){
			$num = number_format($s, $number, '.', '');
		}else if(strlen($num)==1 || strlen($num)==2 || strlen($num)==3){
			$num = number_format($num, 2, '.', '');
		}else if($number==2){
			$num = number_format($num, $number, '.', '');
		}else if($number==2){
			$num = number_format($num, $number, '.', '');
		}else{
			if(strlen($arr[1])>7){
				$num = number_format($s, $number, '.', '');
			}else{
				/* $num=preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
				 $arr=explode(".",$num);
				 if(strlen($arr[1])>7){
					$m = number_format($s, $number, '.', '');
					$num=preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$m);
					}else{
					$m = number_format($s, $number, '.', '');
					$num=preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$m);
					} */
				$m = number_format($s, $number, '.', '');
				$num=preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$m);
			}
		}
	}
	return $num;
}
/*
 * 对象转成数组
 */
function object_array($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}
/*
 * stdClass转成数组
 */
function object2array(&$object) {
	$object =  json_decode( json_encode( $object),true);
	return  $object;
}
/**去除键值重复的数据**/
function second_array_unique_bykey($arr, $key){
	$tmp_arr = array();
	foreach($arr as $k => $v)
	{
		if(in_array($v[$key], $tmp_arr)){
			unset($arr[$k]);
		}
		else {
			$tmp_arr[$k] = $v[$key];
		}
	}
	sort($arr);
	//ksort($arr); //ksort函数对数组进行排序(保留原键值key)  sort为不保留key值
	return $arr;
}

?>
