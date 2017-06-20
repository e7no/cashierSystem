<?php
session_start();
include_once('../../Common/function.php');
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
$stoId = $_SESSION['stoId'];
$stoTypes = $_SESSION['stoType'];
$CatId = $_GET['CatId'];
$quick = $_GET['quick'];
$StoType = $_GET['StoType'];
if ($stoTypes == 1) {
    $pStoId = '';
} else {
    $pStoId = $_SESSION['pid'];
}
$url = $config_host . '/service/gds/manage/goods/list';
$datas = array('datas' => array(
    'stoId' => $stoId
));
if ($CatId != '') {
    $datas['datas']['catId'] = $CatId;
}
if ($quick != '') {
    $datas['datas']['searchText'] = $quick;
}
if ($StoType != '' && $StoType != 0) {
    $datas['datas']['type'] = (int)$StoType;
}
if ($pStoId != '') {
    $datas['datas']['pStoId'] = $pStoId;
}
$json = http($url, $datas, 1);
$list = $json['datas']['list'];
$num = count($list);
for ($i = 0; $i < $num; $i++) {
    if ($stoTypes == 1) {
        $list[$i]['ntype'] = '总部商品';
    } else if ($stoTypes == 2) {
        if ($list[$i]['type'] != 2) {
            $list[$i]['ntype'] = '分店商品';
        } else {
            $list[$i]['ntype'] = '总部商品';
        }
    } else {
        $list[$i]['ntype'] = '';
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
    ->setCellValue('A1', '编码')
    ->setCellValue('B1', '商品名称')
    ->setCellValue('C1', '所属分类')
    ->setCellValue('D1', '单位')
    ->setCellValue('E1', '是否称重')
    ->setCellValue('F1', '规格')
    ->setCellValue('G1', '进价')
    ->setCellValue('H1', '收银价')
    ->setCellValue('I1', '商城价')
    ->setCellValue('J1', '积分价')
    ->setCellValue('K1', '商品库类型')
    ->setCellValue('L1', '状态')
    ->setCellValue('M1', '保质期')
    ->setCellValue('N1', '修改时间')
    ->setCellValue('O1', '操作员');

foreach ($list as $key => $value) {
    $key += 2;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $key, ' ' . $value['no']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $key, $value['name']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $key, $value['catName']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $key, $value['unit']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $key, $value['weight'] ? '√' : '×');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $key, $value['skuText']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $key, ' ' . $value['skuInPriceText']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $key, ' ' . $value['saleStatus'] ? $value['skuSalePriceText'] : '');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $key, ' ' . $value['takeOut'] ? $value['skuTakeOutPriceText'] : '');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $key, ' ' . $value['useIntegral'] ? $value['skuIntegralText'] : '');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $key, ' ' . $value['ntype']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $key, $value['status'] ? '下架' : '上架');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $key, ' ' . $value['bzq']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $key, $value['modifyDate']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $key, $value['modifyName'] ? $value['modifyName'] : $value['createName']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->getActiveSheet()->setTitle('商品列表');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 工作区域标题
ob_end_clean();
header("Content-type:text/html;charset=utf-8");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="商品列表.xls"');//导出文件
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');//导出文件\
exit;
