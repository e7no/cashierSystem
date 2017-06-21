<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$stoName = $_GET['stoName'];
$DateStart = $_GET['DateStart'];
$DateEnd = $_GET['DateEnd'];
$url = $config_host . '/service/gds/material/balance/detailList';
$datas = array('datas' => array(
    'pageNo' => $currentPage,
    'pageSize' => $perPage,
    'balanceDateStart' => $DateStart,
    'balanceDateEnd' => $DateEnd,
));
if ($stoType == 1) {
    if ($stoName == '' || $stoName == NULL) {
        $datas['datas']['stoId'] = $stoId;
    } else {
        $datas['datas']['stoId'] = $stoName;
    }
} else {
    $datas['datas']['stoId'] = $stoId;
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
    ->setCellValue('A1', '时间')
    ->setCellValue('B1', '门店名称')
    ->setCellValue('C1', '原料类别')
    ->setCellValue('D1', '原料名称')
    ->setCellValue('E1', '期初库存')
    ->setCellValue('F1', '期初金额')
    ->setCellValue('G1', '入库数量')
    ->setCellValue('H1', '入库金额')
    ->setCellValue('I1', '领用数量')
    ->setCellValue('J1', '领用金额')
    ->setCellValue('K1', '报废数量')
    ->setCellValue('L1', '报废金额')
    ->setCellValue('M1', '盘点数量')
    ->setCellValue('N1', '盘点金额')
    ->setCellValue('O1', '盈亏数量')
    ->setCellValue('P1', '盈亏金额')
    ->setCellValue('Q1', '期末数量')
    ->setCellValue('R1', '期末金额');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['balanceDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, ' ' . $value['stoName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, ' ' . $value['typeName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, ' ' . $value['name']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, ' ' . $value['preQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, ' ' . $value['preAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, ' ' . $value['inQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $key, ' ' . $value['inAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $key, ' ' . $value['outQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $key, ' ' . $value['outAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $key, ' ' . $value['scrapQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $key, ' ' . $value['scrapAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $key, ' ' . $value['invQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $key, ' ' . $value['invAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $key, ' ' . $value['minusQty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $key, ' ' . $value['minusAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $key, ' ' . $value['qty']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $key, ' ' . $value['amount']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(25);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('原料入库单列表');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="原料入库单列表.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
