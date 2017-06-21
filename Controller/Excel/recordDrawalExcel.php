<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$url = $config_host . '/service/fin/manage/store/cashOutRecord';
$datas = array('datas' => array(
    'stoId' => $stoId,
));
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
for ($i = 0; $i < $num; $i++) {
    if ($list[$i]['status'] == 5 && $list[$i]['type'] == 1) {
        $list[$i]['txType'] = '提现失败、已退回账户余额';
    } else if ($list[$i]['status'] == 1 && $list[$i]['type'] == 1) {
        $list[$i]['txType'] = '提现成功';
    } else if ($list[$i]['status'] == 2 && $list[$i]['type'] == 1 || $list[$i]['status'] == 3 || $list[$i]['status'] == 4) {
        $list[$i]['txType'] = '提现处理中';
    } else if ($list[$i]['type'] != 1) {
        $list[$i]['txType'] = '提现失败退回';
    } else {
        $list[$i]['txType'] = '正在提交..';
    }
}
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
    ->setCellValue('A1', '提现银行')
    ->setCellValue('B1', '提现账号')
    ->setCellValue('C1', '提现金额')
    ->setCellValue('D1', '手续费')
    ->setCellValue('E1', '实际到账金额')
	->setCellValue('F1', '提现时间')
	->setCellValue('G1', '提现状态');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, $value['bankName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['cardNumbers']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['amount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['fee']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['realAmount']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, $value['createDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, $value['txType']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('提现记录');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="提现记录.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
