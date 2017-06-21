<?php
session_start();
include_once('../../Common/function.php');
$postData = json_decode(file_get_contents("php://input")); // 接收post过来的数据
$type = $postData->type;
$stoId = $_SESSION['stoId'];
$userId = $_SESSION['bUserId'];
$busId = $_SESSION['busId'];
if ($type == "list") { 
	$currentPage = $postData->currentPage; // 获取当前页
	$perPage = $postData->itemsPerPage; // 获取每页多少条数据
	$logmin = $postData->logmin; //
	$stoId = $postData->stoId; //
	if($stoId == ""){
		$stoId = $_SESSION['stoId'];
	}
	$url = $config_host . '/service/sto/manage/monthlyStatement';
	$datas = array('datas' => array(
			'pageNo' => $currentPage,
			'pageSize' => $perPage,
			'stoId'=>$stoId,
			'month'=>$logmin ? $logmin : null
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if($_GET["type"]=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$url = $config_host . '/service/sto/manage/monthlyStatement';
	$stoId = $_GET["stoId"];
	if($stoId == ""){
		$stoId = $_SESSION['stoId'];
	}
	$datas = array('datas' => array(
		'pageNo' => '1',
		'pageSize' => '1000',
		'stoId'=>$stoId,
		'logmin'=>$_GET["logmin"] ? $_GET["logmin"] : null
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
	->setCellValue('A1', '月份')
	->setCellValue('B1', '门店名称')
	->setCellValue('C1', '原材料入库总金额')
	->setCellValue('D1', '销售总金额')
	->setCellValue('E1', '其他收支')
	->setCellValue('F1', '门店租金')
	->setCellValue('G1', '员工工资')
	->setCellValue('H1', '物业费')
	->setCellValue('I1', '电费')
	->setCellValue('J1', '水费')
	->setCellValue('K1', '门店纯利润');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['month']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['stoName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['matAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['saleAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['otherAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['rentAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['salaryAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['propAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['elecAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['waterAmt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$key,$value['profitAmt']);
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
	$objPHPExcel->getActiveSheet()->setTitle('monthlyStatementTabel');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="门店月结报表.xls"');//导出文件
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