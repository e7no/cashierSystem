<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$quick = $_GET['quick'];
$url = $config_host . '/service/mem/manage/chsMemList';
$datas = array('datas' => array(
    'quick' => $quick
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
    ->setCellValue('A1', '卡号')
    ->setCellValue('B1', '姓名')
    ->setCellValue('C1', '性别')
    ->setCellValue('D1', '手机号码')
    ->setCellValue('E1', '生日')
    ->setCellValue('F1', '余额')
    ->setCellValue('G1', '充值金额')
    ->setCellValue('H1', '赠送金额')
    ->setCellValue('I1', '总金额')
    ->setCellValue('J1', '消费总金额')
    ->setCellValue('K1', '积分')
    ->setCellValue('L1', '兑换积分')
    ->setCellValue('M1', '剩余积分')
    ->setCellValue('N1', '消费总次数')
    ->setCellValue('O1', '扫码付次数')
    ->setCellValue('P1', '会员支付次数')
    ->setCellValue('Q1', '最后消费时间');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['card']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, ' ' . $value['realName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, ' ' . $value['sex']==1?'男':'女');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, ' ' . $value['mobile']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, ' ' . $value['birthday']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, ' ' . $value['wallet']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, ' ' . $value['rechargeTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $key, ' ' . $value['giveTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $key, ' ' . $value['rechargeTotal']+$value['giveTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $key, ' ' . $value['consumeTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $key, ' ' . $value['integralTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $key, ' ' . $value['conIntegralTotal']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $key, ' ' . $value['integral']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $key, ' ' . $value['qrConTimes']+$value['cardConTimes']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $key, ' ' . $value['qrConTimes']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $key, ' ' . $value['cardConTimes']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $key, ' ' . $value['lastConDate']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('会员列表');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="会员列表.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
