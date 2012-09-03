<?php

include('PHPExcel.php');
require_once 'PHPExcel/Cell/AdvancedValueBinder.php';
/** Create a new PHPExcel Object  **/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
            
/*HEADER STYLING*/
$styleArray = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),),
);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);

/*HEADER*/
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Project Name');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Start Date');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Time');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'End Date');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Time');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Comment');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Initials');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Spent');
/*SET COLUMN WIDTH*/
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
/*!HEADER*/

/*SET COLUMN STYLING*/
$objPHPExcel->getActiveSheet()
            ->getStyle('B')
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);

$objPHPExcel->getActiveSheet()
            ->getStyle('C')
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
            
$objPHPExcel->getActiveSheet()
            ->getStyle('D')
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);

$objPHPExcel->getActiveSheet()
            ->getStyle('E')
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
            
$objPHPExcel->getActiveSheet()
            ->getStyle('H')
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
/*BODY*/
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'DBA');

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
$objPHPExcel->getActiveSheet()->setCellValue('B3', '8/30/2012');
$objPHPExcel->getActiveSheet()->setCellValue('C3', '8:50');
$objPHPExcel->getActiveSheet()->setCellValue('D3', '8/30/2012');
$objPHPExcel->getActiveSheet()->setCellValue('E3', '9:30');


$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Balliauw');
$objPHPExcel->getActiveSheet()->setCellValue('H3', '=E3-C3');



/*OUTPUT*/
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("05featuredemo.xlsx");