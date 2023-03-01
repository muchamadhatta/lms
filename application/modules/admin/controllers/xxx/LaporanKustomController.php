<?php

class Admin_LaporanKustomController extends Zend_Controller_Action
{
	
	public function init()
	{ 
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');		
		$this->_helper->_acl->allow('user.evaluasi', array('index', 'view'));
	}
	
	public function preDispatch()
	{
		$this->LaporanKustomService = new LaporanKustomService();
	}
	
	public function indexAction() 
	{	
		$this->view->rows = $this->LaporanKustomService->getAllData();
	}

	public function addAction() 
	{	
		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$sql = $this->getRequest()->getParam('sql');

			$this->LaporanKustomService->addData($judul, $sql);
			$this->_redirect('/admin/laporan-kustom/index');
		}
	}

	public function editAction() 
	{	
		$id = $this->getRequest()->getParam('id');

		if ( $this->getRequest()->isPost() )
		{
			$judul = $this->getRequest()->getParam('judul');
			$sql = $this->getRequest()->getParam('sql');

			$this->LaporanKustomService->editData($id, $judul, $sql);
			$this->_redirect('/admin/laporan-kustom/index');
		} else {
			$this->view->row = $this->LaporanKustomService->getData($id);
		}
	}

	public function deleteAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->LaporanKustomService->softDeleteData($id);
		$this->_redirect('/admin/laporan-kustom/index');
	}

	public function viewAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$id = $this->getRequest()->getParam('id');
		$this->view->row = $this->LaporanKustomService->getData($id);
		$this->view->rows = $this->LaporanKustomService->viewData($id);
		//var_dump($this->view->row);
	}

	public function exportAction()
	
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		$id = $this->getRequest()->getParam('id');
		$row = $this->LaporanKustomService->getData($id);
		$rows = $this->LaporanKustomService->viewData($id);
		
		$styleArrayBold = array(
			'font' => array(
				'bold' => true
			)
		);
		$styleArrayBorder = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$styleArrayBold = array(
			'font' => array(
				'bold' => true
			)
		);
	
		
			// Create PHPExcel object 
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("BDSI");			
			//$objPHPExcel->createSheet(1);
			//$objPHPExcel->setActiveSheetIndex(1);
			$objPHPSheet = $objPHPExcel->getActiveSheet();
			
			// insert Title & Merge Column Table
			$judul=$row->judul;
			$last_column = 'B';
			$sum_column = count((array)$rows[0]); 
			for ($i = 1; $i < $sum_column; ++$i) {
			  $last_column++;
			}
			$objPHPSheet->mergeCells('A2:'.$last_column.'2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN '.ucwords(strtoupper($judul)));
			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArrayBold);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
			// set auto size column
			foreach(range('A',$last_column) as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			
			$columny = 'A'; //first column
			$rowy = '4'; //first row
			$columnz = $columny;
			
			// insert title column
			$field_title  = $rowy;
			$column_title = $columny;
			$cetak_judul = true;
			foreach($rows as $row => $columns) {
				$row = $row + $rowy; 
				$row_title = $row;
				$row++;
				foreach($columns as $column => $data) {
					if ($cetak_judul) {
						$objPHPExcel->getActiveSheet()->getStyle($column_title.$row_title)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle($column_title.$row_title)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBFBF');
						$objPHPExcel->getActiveSheet()->getStyle($column_title.$row_title)->applyFromArray($styleArrayBold);
						$objPHPExcel->getActiveSheet()->getStyle($column_title.$row_title)->applyFromArray($styleArrayBorder);
						$objPHPExcel->getActiveSheet()->setCellValue($column_title++.$row_title, $column); 
							
					}
					if (is_numeric($data)) {
						
						$objPHPExcel->getActiveSheet()->getStyle($columnz.$row)->getNumberFormat()->setFormatCode('#');
					}
					$objPHPExcel->getActiveSheet()->getStyle(($columnz).$row)->applyFromArray($styleArrayBorder);
					
					$objPHPExcel->getActiveSheet()->setCellValue($columnz++.$row, $data);
					
						
				}
				$cetak_judul = false;
				$columnz = $columny;
			}
			for ($col = 'A'; col <= 'I'; $i++) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4,5);
			// Save xls file 


	
	//insert Title Chart
	$title = new PHPExcel_Chart_Title('Grafik '.$judul);
	$yAxisLabel = new PHPExcel_Chart_Title('');
	$objWorksheet = $objPHPExcel->getActiveSheet();			

	//	Set the Labels for each data series we want to plot
	$dataSeriesLabels = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$4', NULL, 1),	//	Pendidikan_Terakhir
		new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	jumlah

	);
	//	Set the X-Axis Labels
	$xAxisTickValues = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$5:$A$12', NULL, 4),	//	S3 to SD
	);
	//	Set the Data values for each data series we want to plot
	$dataSeriesValues = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$5:$B$12', NULL, 4),
		
	);

//	Build the dataseries
$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
	range(0, count($dataSeriesValues)-1),			// plotOrder
	$dataSeriesLabels,								// plotLabel
	$xAxisTickValues,								// plotCategory
	$dataSeriesValues								// plotValues
);

	//	Set additional dataseries parameters
	//		Make it a vertical column rather than a horizontal bar graph
	$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

	// Create object of chart layout to set data label 
	$layout1 = new PHPExcel_Chart_Layout();    
    $layout1->setShowVal(TRUE);                   
    $plotArea = new PHPExcel_Chart_PlotArea($layout1, array($series));
	
	//$plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series));
	//	Set the chart legend
	$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

	//	Create the chart
$chart = new PHPExcel_Chart(
	'chart1',		// name
	$title,			// title
	$legend,		// legend
	$plotArea,		// plotArea
	true,			// plotVisibleOnly
	0,				// displayBlanksAs
	NULL,			// xAxisLabel
	$yAxisLabel		// yAxisLabel
);


	//	Set the position where the chart should appear in the worksheet
	$chart->setTopLeftPosition('F4');
	$chart->setBottomRightPosition('O20');
	
	//	Print Chart if there's word 'Jumlah' on judul
		if (strpos($judul,'Jumlah') !== FALSE) {
		
		$objWorksheet->addChart($chart);
		}
			// Save xls file 		
		   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
		   $objWriter->setIncludeCharts(TRUE);
		   header('Content-Type: application/vnd.ms-excel'); 
		   header('Content-Disposition: attachment;filename="Laporan.xlsx"'); 
		   header('Cache-Control: max-age=0'); 
		   $objWriter->save('php://output'); 
		   exit(); 
	}
	
  
}