<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$quick = $_GET['quick'];
$createDateStart = $_GET['createDateStart'];
$createDateEnd = $_GET['createDateEnd'];
$url = $config_host . '/service/mem/manage/rechConsumRecord';
$datas = array('datas' => array(
    'quick' => $quick,
    'createDateStart' => $createDateStart,
    'createDateEnd' => $createDateEnd
));
if($_SESSION['stoType']==1){
    $datas['datas']['headStoId']=$stoId;
}else{
    $datas['datas']['stoId']=$stoId;
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
    ->setCellValue('B1', '卡号')
    ->setCellValue('C1', '姓名')
    ->setCellValue('D1', '手机号码')
    ->setCellValue('E1', '充值（消费）金额')
    ->setCellValue('F1', '余额');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['createDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, ' ' . $value['card']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, ' ' . $value['realName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, ' ' . $value['mobile']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, ' ' . $value['changeAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, ' ' . $value['lastWallet']?$value['lastWallet']:'0.00');
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('充值消费记录');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="充值消费记录.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
