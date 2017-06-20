<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "jhblist") { 
	$currentPage = $postData->currentPage; // 获取当前页
	$perPage = $postData->itemsPerPage; // 获取每页多少条数据
	$createDateStart = $postData->createDateStart; //
	$createDateEnd = $postData->createDateEnd; //
	$cashierName = $postData->cashierName; //
	$url = $config_host . '/service/sto/relieve/list';
	$datas = array('datas' => array(
			'pageNo' => $currentPage,
			'pageSize' => $perPage,
			'stoId'=>$stoId,
			'createDateStart'=>$createDateStart ? $createDateStart : null,
			'createDateEnd'=>$createDateEnd ? $createDateEnd : null,
			'cashierName'=>$cashierName
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if($_GET["type"]=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$url = $config_host . '/service/sto/relieve/list';
	$datas = array('datas' => array(
		'pageNo' => '1',
		'pageSize' => '1000',
		'stoId'=>$stoId,
		'createDateStart'=>$_GET["createDateStart"] ? $_GET["createDateStart"] : null,
		'createDateEnd'=>$_GET["createDateEnd"] ? $_GET["createDateEnd"] : null,
		'cashierName'=>$_GET["cashierName"]
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
	->setCellValue('A1', '收银员')
	->setCellValue('B1', '交换班时间')
	->setCellValue('C1', '客单数')
	->setCellValue('D1', '现金盘点')
	->setCellValue('E1', '现金收银')
	->setCellValue('F1', '上交金额')
	->setCellValue('G1', '扫码收银')
	->setCellValue('H1', 'POS收银')
	->setCellValue('I1', '会员卡收银')
	->setCellValue('J1', '会员卡现金充值')
	->setCellValue('K1', '营业总额')
	->setCellValue('L1', '上次备用金')
	->setCellValue('M1', '本次备用金');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['cashierName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['createDate']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['orderNum']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['cashCheckAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['cashPayAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['submitAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['scanPayAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['posPayAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['memPayAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['memRechargeAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$key,$value['totalAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$key,$value['backupCash']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$key,$value['residueBackupCash']);
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setTitle('STORelieve');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="交换班记录列表.xls"');//导出文件
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