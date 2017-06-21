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
if ($type == "list") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $createId = $postData->createId; // 获取当前页
    $no = $postData->no; // 获取当前页
    $invDateStart = $postData->invDateStart; // 获取当前页
    $invDateEnd = $postData->invDateEnd; // 获取当前页
    $url = $config_host . '/service/gds/material/inventory/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId,
        'invDateStart'=>$invDateStart,
        'invDateEnd'=>$invDateEnd,
        'no'=>$no,
        'personName'=>$createId
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if ($type == "inlistdetails") {
    $currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $id = $postData->id; // 获取当前页
    $url = $config_host . '/service/gds/material/inventory/detail/'.$id;
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage
    ));
    $json = http($url, $datas, 1);
    $str['list'] = $json['datas']['list'];
    $str['vo'] = $json['datas']['vo'];
    $str['total'] = $json['datas']['page']['totalSize'];
    echo json_encode($str);
    exit;
}else if($type == "excel"){
	require_once '../../Common/Classes/PHPExcel.php';
	$currentPage = $postData->currentPage; // 获取当前页
    $perPage = $postData->itemsPerPage; // 获取每页多少条数据
    $createId = $postData->createId; // 获取当前页
    $no = $postData->no; // 获取当前页
    $invDateStart = $postData->invDateStart; // 获取当前页
    $invDateEnd = $postData->invDateEnd; // 获取当前页
    $url = $config_host . '/service/gds/material/inventory/list';
    $datas = array('datas' => array(
        'pageNo' => $currentPage,
        'pageSize' => $perPage,
        'stoId'=>$stoId,
        'invDateStart'=>$invDateStart,
        'invDateEnd'=>$invDateEnd,
        'no'=>$no,
        'personName'=>$createId
    ));
    $json = http($url, $datas, 1);
    $list = $json['datas']['list'];
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '单据编码')
    ->setCellValue('B1', '库存总量')
    ->setCellValue('C1', '库存总额')
    ->setCellValue('D1', '盘点总额')
    ->setCellValue('E1', '盘点总量')
    ->setCellValue('F1', '盈亏总额')
    ->setCellValue('G1', '盈亏总量')
    ->setCellValue('H1', '盘点时间')
    ->setCellValue('I1', '备注')
    ->setCellValue('J1', '盘点员')
    ->setCellValue('K1', '操作员');
	foreach ($list as $key => $value) {
	    $key += 2;
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['no']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, ' ' . $value['stock']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, ' ' . $value['amount']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, ' ' . $value['invQty']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, ' ' . $value['invAmount']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, ' ' . $value['minusQty']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, ' ' . $value['minusAmount']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $key, ' ' . $value['invDate']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $key, ' ' . $value['note']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $key, ' ' . $value['personName']);
	    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $key, ' ' . $value['createName']);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	
	// Miscellaneous glyphs, UTF-8
	$objPHPExcel->getActiveSheet()->setTitle('原料盘点单列表');
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	// 工作区域标题
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="原料盘点单列表.xls"');//导出文件
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');//导出文件\
	exit;
}else if ($_GET["type"] == "indetailsexcel") {
	require_once '../../Common/Classes/PHPExcel.php';
    $currentPage = 1; // 获取当前页
    $perPage = 10000; // 获取每页多少条数据
    $id = $_GET["id"]; // 获取当前页
    $url = $config_host . '/service/gds/material/inventory/detail/'.$id;
    $datas = array('datas' => array(
        'pageNo' => 1,
        'pageSize' => 10000
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
	->setCellValue('A1', '原料编码')
	->setCellValue('B1', '原料名称')
	->setCellValue('C1', '原料类别')
	->setCellValue('D1', '单位')
	->setCellValue('E1', '规格')
	->setCellValue('F1', '原料标准价')
	->setCellValue('G1', '原料进价')
	->setCellValue('H1', '库存')
	->setCellValue('I1', '库存金额')
	->setCellValue('J1', '盘点数量')
	->setCellValue('K1', '盘点金额')
	->setCellValue('L1', '盈亏数量')
	->setCellValue('M1', '盈亏金额');
	foreach($list as $key => $value){
		$key+=2;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['code']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['typeName']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['unit']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['spec']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['standardPrice']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['invPrice']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['stock']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['amount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['invQty']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$key,$value['invAmount']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$key,$value['minusQty']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$key,$value['minusAmount']);
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
	$objPHPExcel->getActiveSheet()->setTitle('details');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	// 工作区域标题
	//$xmlWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_end_clean();
	header("Content-type:text/html;charset=utf-8");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="盘点原料详情.xls"');//导出文件
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0
	$xmlWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$xmlWriter->save('php://output');//导出文件
	$jsonstr["success"] = true;
}else if ($type == "addmaterial") {
	$data = json_decode($postData->data,true);
	$inStock = $postData->inStocks;
	$personName = $postData->personName;
	$invDate = $postData->invDate;
	$note = $postData->note;
	$url = $config_host . '/service/gds/material/inventory/add';
	$datas = array('datas' => array(
		'matInventoryDTO' => array(
			"personName" => $personName,
			'stoId' => $stoId,
			'createId' => $userId,
			"invDate" => $invDate,
			"note" => $note,
		),
	));
	$i = 0;
	foreach ($data as $value){
		$datas['datas']['matInventoryDTO']['detailList'][$i]["matId"] = $value["id"] ? $value["id"] : '';
		$datas['datas']['matInventoryDTO']['detailList'][$i]["invQty"] = $inStock[$i] ? $inStock[$i] : '';
		$i ++;
	}
	$json = http($url, $datas, 1);
	if ($json['success']) {
		$str['success'] = true;
		if ($json['errMsg'] == '') {
			$str['message'] = '添加成功！';
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
}else{
    $str['success'] = true;
    $str['message'] = '服务端请求错误！';
    echo json_encode($str);
    exit;
}
//    file_put_contents("log.txt", "json信息：".var_export($datas,TRUE)."\n", FILE_APPEND);
?>