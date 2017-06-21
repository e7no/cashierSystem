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
if ($type == "paymentlist") { 
	$pageNo = $postData->currentPage; // 获取当前页
	$pageSize = $postData->itemsPerPage; // 获取每页多少条数据
	$staDate = $postData->staDate; //
	$inOrOut = $postData->inOrOut; //
	$url = $config_host . '/service/sto/financeStatement/list';
	$datas = array('datas' => array(
		'pageNo' => $pageNo,
		'pageSize' => $pageSize,
		'stoId'=>$postData->stoId ? $postData->stoId : $stoId,
		'staDate'=>$staDate ? $staDate : null,
		'inOrOut'=>$inOrOut
	));
	$json = http($url, $datas, 1);
	$str['list'] = $json['datas']['list'];
	$str['financeStatement'] = $json['datas']['financeStatement'];
	$str['total'] = $json['datas']['page']['totalSize'];
	echo json_encode($str);
	exit;
}else if($type=="excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$pageNo = $postData->currentPage; // 获取当前页
	$pageSize = $postData->itemsPerPage; // 获取每页多少条数据
	$staDate = $postData->staDate; //
	$inOrOut = $postData->inOrOut; //
	$url = $config_host . '/service/sto/financeStatement/list';
	$datas = array('datas' => array(
		'pageNo' => $pageNo,
		'pageSize' => $pageSize,
		'stoId'=>$postData->stoId ? $postData->stoId : $stoId,
		'staDate'=>$staDate ? $staDate : null,
		'inOrOut'=>$inOrOut
	));
	$json = http($url, $datas, 1);
	$list=$json['datas']['list'];
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', '项目/商品')
	->setCellValue('B1', '数量')
	->setCellValue('C1', '收支金额')
	->setCellValue('D1', '备注');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['quantity']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['amount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['note']);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->setTitle('detailspayment');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="收支报表.xls"');//导出文件
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