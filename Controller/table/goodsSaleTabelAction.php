<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "SaleTablelist") { 
	$pageNo = $postData->currentPage; // 获取当前页
	$pageSize = $postData->itemsPerPage; // 获取每页多少条数据
	$createDateStart = $postData->createDateStart; //
	$createDateEnd = $postData->createDateEnd; //
	$goodsName = $postData->goodsName; //
	$orderType = $postData->orderType; //
	$url = $config_host . '/service/gds/manage/goods/queryGoodsRank';
	$datas = array('datas' => array(
		'pageNo' => $pageNo,
		'pageSize' => $pageSize,
		'stoId'=>$postData->stoId ? $postData->stoId : $stoId,
		'createDateStart'=>$createDateStart ? $createDateStart : null,
		'createDateEnd'=>$createDateEnd ? $createDateEnd : null,
		'goodsName'=>$goodsName,
		'orderType'=>$orderType
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if($_GET["type"]=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$url = $config_host . '/service/gds/manage/goods/queryGoodsRank';
	$datas = array('datas' => array(
		'pageNo' => 1,
		'pageSize' => 1000,
		'stoId'=>$_GET["stoId"] ? $_GET["stoId"] : $stoId,
		'createDateStart'=>$_GET["createDateStart"] ? $_GET["createDateStart"] : null,
		'createDateEnd'=>$_GET["createDateEnd"] ? $_GET["createDateEnd"] : null,
		'goodsName'=>$_GET["goodsName"],
		'orderType'=>$_GET["orderType"],
	));
	$json = http($url, $datas, 1);
	$list=$json['datas']['list'];
	$count = count($list);
	for ($i = 0;$i<$count;$i++){
		if($list[$i]["channel"]==1){
			$list[$i]["channel"] = "门店";
		}else if($list[$i]["channel"]==2){
			$list[$i]["channel"] = "商城";
		}else{
			$list[$i]["channel"] = "门店";
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
	->setCellValue('A1', '商品名称')
	->setCellValue('B1', '门店名称')
	->setCellValue('C1', '销售渠道')
	->setCellValue('D1', '销售数量')
	->setCellValue('E1', '金额占比')
	->setCellValue('F1', '销售金额')
	->setCellValue('G1', '数量占比');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['goodsName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['storeName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['channel']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['quantity']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['proportionAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['salePrice']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['proportionQuantity']);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setTitle('goodsSaleTabel');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="商品销售排行列表.xls"');//导出文件
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