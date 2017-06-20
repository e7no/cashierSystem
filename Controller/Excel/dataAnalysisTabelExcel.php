<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$stoType = $_SESSION['stoType'];
$stoName = $_GET['stoName'];
$indexDate = $_GET['indexDate'];
$url = $config_host . '/service/fin/report/klb/analysis';
$datas = array('datas' => array(
    'indexDate' => $indexDate,
    'stoType'=>$stoType
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
    ->setCellValue('A1', '日期')
    ->setCellValue('B1', '门店名称')
    ->setCellValue('C1', '门前人流量')
    ->setCellValue('D1', '进店客流量')
    ->setCellValue('E1', '进店转化率')
    ->setCellValue('F1', '进店跳出量')
    ->setCellValue('G1', '进店跳出率')
    ->setCellValue('H1', '新客量')
    ->setCellValue('I1', '老客量');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['indexDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, ' ' . $value['stoName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, ' ' . $value['outside']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, ' ' . $value['instore']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, ' ' . ((float)$value['inConvRate']*100).'%');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, ' ' . $value['bounce']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, ' ' . ((float)$value['outConvRate']*100).'%');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $key, ' ' . $value['freshCustomer']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $key, ' ' . $value['oldCustomer']);
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

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('客流分析');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="客流分析.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
