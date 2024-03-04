<?php 

require_once("Classes/PHPExcel.php");
$excel = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0); 

$rowCount = 1;
// th
$objPHPExcel->getActiveSheet()->SetCellValue($excel[0].$rowCount,'A');
$objPHPExcel->getActiveSheet()->SetCellValue($excel[0].$rowCount,'B');


$rowCount = 2;
$objPHPExcel->getActiveSheet()->SetCellValue($excel[0].$rowCount,1);
$objPHPExcel->getActiveSheet()->SetCellValue($excel[0].$rowCount,2);


$filename = "export.xlsx";
// export
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
$objWriter->save($filename);
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Type: application/vnd.openxmlformatsofficedocument.spredsheetml.sheet');
header('Content-Length:'.filesize($filename));
header('Content-Transfer-Encoding:binary ');
header('Cache-Control: must-revalidate');
header('Pragma:no-cache');
readfile($filename);
return;
 ?>
