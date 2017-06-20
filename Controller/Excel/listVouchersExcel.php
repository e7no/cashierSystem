<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$setId = $_GET['setId'];
$states = $_GET['states'];
$url = $config_host . '/service/sto/offCoupon/listItem';
$datas = array('datas' => array(
    'stoId' => $stoId,
    'setId' => $setId,

));
if ($states != '') {
    $datas['datas']['useState'] = $states;
}
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
for ($i = 0; $i < $num; $i++) {
    if ($list[$i]['useCond'] == '') {
        $list[$i]['cod'] = '无条件使用';
    } else {
        $list[$i]['cod'] = '满' + $list[$i]['useCond'] + '元使用';
    }
    if ($list[$i]['useState'] == 0) {
        $list[$i]['uste'] = '未使用';
    } else if ($list[$i]['useState'] == 1) {
        $list[$i]['uste'] = '已使用';
    } else {
        $list[$i]['uste'] = '已过期';
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
    ->setCellValue('A1', '券码')
    ->setCellValue('B1', '优惠券类型')
    ->setCellValue('C1', '面额')
    ->setCellValue('D1', '使用条件')
    ->setCellValue('E1', '有效期')
    ->setCellValue('F1', '使用状态');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['password']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, '线上');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, number_format($value['faceValue'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['cod']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, substr($value['startDate'], 0, 10) . '至' . substr($value['endDate'], 0, 10));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, $value['uste']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('优惠券');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="优惠券.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
