<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$no = $_GET['no'];
$invDateStart = $_GET['invDateStart'];
$invDateEnd = $_GET['invDateEnd'];
$operator = $_GET['operator'];
$url = $config_host . '/service/gds/stock/inventory/list';
$datas = array('datas' => array(
    'stoId' => $stoId
));
if ($no != '') {
    $datas['datas']['no'] = $no;
}
if ($invDateStart != '') {
    $datas['datas']['invDateStart'] = $invDateStart;
}
if ($invDateEnd != '') {
    $datas['datas']['invDateEnd'] = $invDateEnd;
}
if ($operator != '') {
    $datas['datas']['operator'] = $operator;
}
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Error reporting */
error_reporting(E_ALL);
/** Include PHPExcel */
require_once '../../Common/Classes/PHPExcel.php';
//// Create new PHPExcel object
//
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '单据编码')
    ->setCellValue('B1', '库存总量')
    ->setCellValue('C1', '库存总额')
    ->setCellValue('D1', '盘点总量')
    ->setCellValue('E1', '盘点总额')
    ->setCellValue('F1', '盈亏总量')
    ->setCellValue('G1', '盈亏总额')
    ->setCellValue('H1', '时间')
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
$objPHPExcel->getActiveSheet()->setTitle('商品盘点单列表');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="商品盘点单列表.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
