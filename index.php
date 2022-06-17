<?php 
	spl_autoload_register();
	set_time_limit(0);
	ignore_user_abort(true);
	
	require_once 'assets/libs/phpQuery.php';
	require_once 'assets/libs/PHPExcel-1.8/Classes/PHPExcel.php';
	require_once 'assets/libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';

	use \Assets\Classes\Parser;

	$xls = new PHPExcel();

	//Установка сводки документа
	$xls->getProperties()->setTitle($config['excelTitle']);
	$xls->getProperties()->setSubject($config['excelSubject']);
	$xls->getProperties()->setCreator($config['excelCreator']);
	$xls->getProperties()->setManager($config['excelManager']);
	$xls->getProperties()->setCompany($config['excelCompany']);
	$xls->getProperties()->setCategory($config['excelCategory']);
	$xls->getProperties()->setKeywords($config['excelKeywords']);
	$xls->getProperties()->setDescription($config['excelDescription']);
	$xls->getProperties()->setLastModifiedBy($config['excelLastModifiedBy']);
	$xls->getProperties()->setCreated($config['excelCreated']);


	$pq = phpQuery::newDocument(getPage("https://www.rosfirm.ru/catalog"));
	$rubriks = $pq->find(".rubrik-content");

	//echo("<ul>");
	$sheetTitle = 1;
	foreach ($rubriks as $rubrik) {

		//Создаем новый лист, далее работаем с ним через переменную $sheet.
		$sheet = $xls->createSheet();
		$xls->setActiveSheetIndex($sheetTitle);
		$sheet->setTitle("Table".$sheetTitle);

		//Параметры печати
		// Формат
		$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		 
		// Ориентация
		// ORIENTATION_PORTRAIT — книжная
		// ORIENTATION_LANDSCAPE — альбомная
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		 
		// Поля
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.75);
		$sheet->getPageMargins()->setLeft(0.75);
		$sheet->getPageMargins()->setBottom(1);

		$pq = pq($rubrik);
		$href = "https://www.rosfirm.ru" . $pq->find(".h4 a")->attr('href');
		$rubrik = $pq->find(".h4 a")->text();

		//echo("<li>" . $rubrik . "</li>");

		$pq = phpQuery::newDocument(getPage($href));
		$rubriks1 = $pq->find(".rubrik-content");
		//echo("<ul>");
		$chr = 0;
		if(!empty($rubriks1->text())){
			foreach ($rubriks1 as $rubrik1) {
				$pq = pq($rubrik1);
				$href = "https://www.rosfirm.ru" . $pq->find(".h4 a")->attr('href');
				$rubrik = $pq->find(".h4 a")->text();

				//echo("<li>" . $rubrik . "</li>");
				//Запись в ячейку и ее формат
				if(($chr / 25) > 1){
					$col = "A" . chr(65 + $chr % 26);
				}else{
					$col = chr(65 + $chr);
				}

				$sheet->setCellValue($col."1", $rubrik);
				$xls->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
				$bg = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'FFFF00')
					)
				);
				$sheet->getStyle($col."1")->applyFromArray($bg);
				$border = array(
					'borders'=>array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
					)
				);		 
				$sheet->getStyle($col."1")->applyFromArray($border);
				//echo("<ul>");
				$row = 2;
				foreach (getRubriks($href) as $value) {
					$sheet->setCellValue($col.$row, $value);
					$border = array(
						'borders'=>array(
							'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							),
						)
					); 
					$sheet->getStyle($col.$row)->applyFromArray($border);
					$row++;
					//echo("<li>" . $value . "</li>");
				}
				//echo("</ul>");
				$chr++;
			}
		}else{
			$col = chr(65 + $chr);
			$sheet->setCellValue($col."1", $rubrik);
			$xls->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			$bg = array(
				'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FFFF00')
				)
			);
			$sheet->getStyle($col."1")->applyFromArray($bg);
			$border = array(
				'borders'=>array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
				)
			); 
			$sheet->getStyle($col."1")->applyFromArray($border);
			//echo("<li>" . $rubrik . "</li>");
			//echo("<ul>");
			$row = 2;
			foreach (getRubriks($href) as $value) {
				$sheet->setCellValue($col.$row, $value);
				$border = array(
					'borders'=>array(
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
					)
				); 
				$sheet->getStyle($col.$row)->applyFromArray($border);
				$row++;
				//echo("<li>" . $value . "</li>");
			}
			//echo("</ul>");
		}
		//echo("</ul>");
		$sheetTitle++;
	}
	//echo("</ul>");
	
	function getPage($url)
	{
		$parser = new Parser($url);
		
		return $parser->getPage();
	}
	function getRubriks($url)
	{
		$pq = phpQuery::newDocument(getPage($url));

		$rubriks = $pq->find("#moreRubriks__ a");

		foreach ($rubriks as $rubrik) {
			$pq = pq($rubrik);
			if($pq->parent("div")->attr("class") != "moreParams"){
				$rubrik = $pq->text();
				$data[] = $rubrik;
			}
		}

		return $data;
	}
	//Сохранение
	header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=parse.xlsx");
	 
	$objWriter = new PHPExcel_Writer_Excel2007($xls);
	$objWriter->save('php://output'); 
	exit();	
?>
