<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
//$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "list") { 
	$currentPage = $postData->currentPage; // 获取当前页
	$perPage = $postData->itemsPerPage; // 获取每页多少条数据
	$createDateStart = $postData->createDateStart; //
	$createDateEnd = $postData->createDateEnd; //
	$stoId = $postData->stoId; //
	if($stoId == ""){
		$stoId = $_SESSION['stoId'];
	}
	$url = $config_host . '/service/sto/manage/dailyStatement';
	$datas = array('datas' => array(
			'pageNo' => $currentPage,
			'pageSize' => $perPage,
			'stoId'=>$stoId,
			'bacDateStart'=>$createDateStart ? $createDateStart : null,
			'bacDateEnd'=>$createDateEnd ? $createDateEnd : null
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if($_GET["type"]=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$url = $config_host . '/service/sto/manage/dailyStatement';
	$stoId = $_GET["stoId"];
	if($stoId == ""){
		$stoId = $_SESSION['stoId'];
	}
	$datas = array('datas' => array(
		'pageNo' => '1',
		'pageSize' => '1000',
		'stoId'=>$stoId,
		'createDateStart'=>$_GET["createDateStart"] ? $_GET["createDateStart"] : null,
		'createDateEnd'=>$_GET["createDateEnd"] ? $_GET["createDateEnd"] : null
	));
	$json = http($url, $datas, 1);
	$list=$json['datas']['list'];
	$num=count($list);
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', '时间')
	->setCellValue('B1', '门店名称')
	->setCellValue('C1', '应收金额')
	->setCellValue('D1', '实收金额')
	->setCellValue('E1', '现金收款')
	->setCellValue('F1', '扫码付金额')
	->setCellValue('G1', 'POS金额')
	->setCellValue('H1', '会员消费金额')
	->setCellValue('I1', '差异金额')
	->setCellValue('J1', '备用金');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['bacDate']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['stoName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['recAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['realAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['cashAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['qrAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['postAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['memAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['minusAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['backupAmt']);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setTitle('dayReportTabel');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="门店日结报表.xls"');//导出文件
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
?>