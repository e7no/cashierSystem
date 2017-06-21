<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$stoType = $_SESSION['stoType'];
$url = $config_host . '/service/gds/manage/category/list';
$datas = array('datas' => array(
    'stoId' => $stoId,
    'status' => '0',
));
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
for ($i = 0; $i < $num; $i++) {
    if ($stoType == 1) {
        $list[$i]['catType'] = '总部分类';
    } else if ($stoType == 2) {
        if ($list[$i]['type'] == 2) {
            $list[$i]['catType'] = '总部分类';
        } else {
            $list[$i]['catType'] = '门店分类';
        }
    } else {
        $list[$i]['catType'] = '';
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
    ->setCellValue('A1', '分类名称')
    ->setCellValue('B1', '分类类型')
    ->setCellValue('C1', '修改时间')
    ->setCellValue('D1', '前台排序')
    ->setCellValue('E1', '操作员');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, $value['name']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['catType']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['modifyDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['sn']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['operator']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('商品分类');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="商品分类.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
