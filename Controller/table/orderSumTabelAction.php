<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
if($postData==null || $postData==""){
	$postData = json_decode($_GET["postData"]);
}
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
$stoType = $_SESSION['stoType'];
if ($type == "orderSumlist") { 
	$pageNo = $postData->currentPage; // 获取当前页
	$pageSize = $postData->itemsPerPage; // 获取每页多少条数据
	$createDateStart = $postData->createDateStart; //
	$createDateEnd = $postData->createDateEnd; //
	$no = $postData->no; //
	$listType = $postData->listType; //
	$url = $config_host . '/service/sto/order/report/orders';
	$datas = array('datas' => array(
		'pageNo' => $pageNo,
		'pageSize' => $pageSize,
		'stoId'=>$postData->stoId ? $postData->stoId : $stoId,
		'stoType'=>$postData->stoType ? $postData->stoType : $stoType,
		'createDateStart'=>$createDateStart ? $createDateStart : null,
		'createDateEnd'=>$createDateEnd ? $createDateEnd : null,
		'no'=>$no,
		'listType'=>$listType,
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if ($type == "details") { 
	$id = $postData->ordId; //
	$url = $config_host . '/service/sto/order/report/order/'.$id;
	$json = http($url, "", 1);
	$str['dataMap'] = $json['datas']['dataMap'];
	echo json_encode($str);
	exit;
}else if($type=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$pageNo = $postData->currentPage; // 获取当前页
	$pageSize = $postData->itemsPerPage; // 获取每页多少条数据
	$createDateStart = $postData->createDateStart; //
	$createDateEnd = $postData->createDateEnd; //
	$no = $postData->no; //
	$listType = $postData->listType; //
	$url = $config_host . '/service/sto/order/report/orders';
	$datas = array('datas' => array(
		'pageNo' => $pageNo,
		'pageSize' => $pageSize,
		'stoId'=>$postData->stoId ? $postData->stoId : $stoId,
		'stoType'=>$postData->stoType ? $postData->stoType : $stoType,
		'createDateStart'=>$createDateStart ? $createDateStart : null,
		'createDateEnd'=>$createDateEnd ? $createDateEnd : null,
		'no'=>$no,
		'listType'=>$listType,
	));
	$json = http($url, $datas, 1);
	$list=$json['datas']['list'];
	$count = count($list);
	for ($i = 0;$i<$count;$i++){
		if($list[$i]["orderType"]==1 || $list[$i]["orderType"]==4){
			$list[$i]["orderType"] = "当面付订单";
		}else if($list[$i]["orderType"]==2){
			$list[$i]["orderType"] = "门店订单";
		}else if($list[$i]["orderType"]==3 || $list[$i]["orderType"]==5){
			$list[$i]["orderType"] = "商城订单";
		}
		/* 支付方式：1-钱包，2-微信，3-支付宝，4-汇币，5-现金，6-刷卡，7-会员余额，8-会员积分，9-复合支付 */
		if($list[$i]["payType"]==1){
			$list[$i]["payType"] = "钱包支付";
		}else if($list[$i]["payType"]==2){
			$list[$i]["payType"] = "微信支付";
		}else if($list[$i]["payType"]==3){
			$list[$i]["payType"] = "支付宝支付";
		}else if($list[$i]["payType"]==4){
			$list[$i]["payType"] = "汇币支付";
		}else if($list[$i]["payType"]==5){
			$list[$i]["payType"] = "现金支付";
		}else if($list[$i]["payType"]==6){
			$list[$i]["payType"] = "刷卡支付";
		}else if($list[$i]["payType"]==7){
			$list[$i]["payType"] = "余额支付";
		}else if($list[$i]["payType"]==8){
			$list[$i]["payType"] = "积分支付";
		}else if($list[$i]["payType"]==9){
			$list[$i]["payType"] = "复合支付";
		}
		
	}
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', '单号')
	->setCellValue('B1', '订单类型')
	->setCellValue('C1', '门店名称')
	->setCellValue('D1', '时间')
	->setCellValue('E1', '消费金额')
	->setCellValue('F1', '优惠金额')
	->setCellValue('G1', '实付金额')
	->setCellValue('G1', '支付方式');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['no']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['orderType']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['storeName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['createDate']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['total']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['offSum']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['realSum']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['payType']);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setTitle('orderSum');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="订单明细.xls"');//导出文件
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0
	$xmlWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$xmlWriter->save('php://output');//导出文件
	$jsonstr["success"] = true;
}
//file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>