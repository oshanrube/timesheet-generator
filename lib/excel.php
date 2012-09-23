<?php
include('PHPExcel.php');
require_once 'PHPExcel/Cell/AdvancedValueBinder.php';

class Excel{
	private $objPHPExcel;
	private $initials = 'O.R.';
	private $filename;
	
	public function __construct() {
		/** Create a new PHPExcel Object  **/
		$this->objPHPExcel = new PHPExcel();
		$this->filename = 'Oshan-'.date("Ymd").'.xlsx';
		date_default_timezone_set("Etc/GMT-2");
	}
	
	public function createExcel($records) {
		$this->createHeader();
		$this->createBody($records);
		$this->createOutput();
	}
	
	private function createHeader() {
		/*HEADER STYLING*/
		$styleArray = array(
			'font' => array('bold' => true,),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
			'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),),
		);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
		
		/*HEADER*/
		$this->objPHPExcel->setActiveSheetIndex(0);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', 'Project Name');
		$this->objPHPExcel->getActiveSheet()->setCellValue('B1', 'Start Date');
		$this->objPHPExcel->getActiveSheet()->setCellValue('C1', 'Time');
		$this->objPHPExcel->getActiveSheet()->setCellValue('D1', 'End Date');
		$this->objPHPExcel->getActiveSheet()->setCellValue('E1', 'Time');
		$this->objPHPExcel->getActiveSheet()->setCellValue('F1', 'Comment');
		$this->objPHPExcel->getActiveSheet()->setCellValue('G1', 'Initials');
		$this->objPHPExcel->getActiveSheet()->setCellValue('H1', 'Time Spent(H:M)');
		/*SET COLUMN WIDTH*/
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		/*!HEADER*/
		
		/*SET COLUMN STYLING*/
		$this->objPHPExcel->getActiveSheet()
		            ->getStyle('B')
		            ->getNumberFormat()
		            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY3);
	
		$this->objPHPExcel->getActiveSheet()
		            ->getStyle('C')
		            ->getNumberFormat()
		            ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3 );
		          
		$this->objPHPExcel->getActiveSheet()
		            ->getStyle('D')
		            ->getNumberFormat()
		            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY3);
		
		$this->objPHPExcel->getActiveSheet()
		            ->getStyle('E')
		            ->getNumberFormat()
		            ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3 );
		            
		$this->objPHPExcel->getActiveSheet()
		            ->getStyle('H')
		            ->getNumberFormat()
		            ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3 );
		            
		$this->objPHPExcel->getActiveSheet()
						->getStyle("G")
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	}
	
	private function createBody($records) {
		/*BODY*/
		$row = 3;
		foreach($records as $record){
			list($SDate,$STime) = explode(' ', date('d.m.Y H:i',$record->start_datetime));
			list($EDate,$ETime) = explode(' ', date('d.m.Y H:i',$record->end_datetime));
			
			$this->objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $record->projectname);			
			//PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
			$this->objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $SDate);
			$this->objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $STime);
			$this->objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $EDate);
			$this->objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $ETime);
			$this->objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $record->taskname);
			$this->objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $this->initials);
			$this->objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=E'.$row.'-C'.$row);
			$row++;
		}
	}

	private function createOutput() {
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$this->filename.'"');
		$objWriter->save('php://output');
	}
}