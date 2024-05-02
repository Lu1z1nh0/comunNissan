<?php
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");

	//Load Composer's autoloader
	require ($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

	/* Librerìa PhpSpreadsheet */
	use PhpOffice\PhpSpreadsheet\Helper\Sample;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	use PhpOffice\PhpSpreadsheet\Style\Color;
	use PhpOffice\PhpSpreadsheet\Style\Fill;
	use PhpOffice\PhpSpreadsheet\Style\Style;
	use PhpOffice\PhpSpreadsheet\Style\Border;
	use PhpOffice\PhpSpreadsheet\Style\Alignment;


	if (isset($_POST['descargarReporte'])) {

		$db=Db::conectar();


		$filtro = array(); 

		/* Validaciones para filtros */

		/* REVISAR */
		if (!empty($_POST['filvinplasr'])) {
		    $filtro[]  = 'vinpla = '.'"'.$_POST['filvinplasr'].'"';
		}  

		if (count($filtro)) {
			/* Si hay más de un filtro */
			$filtro = implode(" AND ",$filtro);
		} else {
		    unset($filtro);
		    $filtro = '1';
		}
			
		$select = $db->prepare("SELECT * FROM suscripciones WHERE $filtro ORDER BY id ASC");
		$select->execute();
		$registros = $select->fetchAll();
		$totalReg = $select->rowCount(); /* Total de registros devueltos */


		if($totalReg > 0 ) {
							
			date_default_timezone_set('America/El_Salvador');

			//if (PHP_SAPI == 'cli') { die('Este archivo solo se puede ver desde un navegador web'); }

			$helper = new Sample();
			if ($helper->isCli()) {
			    $helper->log('Este archivo solo se puede ver desde un navegador web' . PHP_EOL);

			    return;
			}

			/* Se crea el objeto Spreadsheet */
			$spreadsheet = new Spreadsheet();

			/* Se asignan las propiedades del libro */
			$spreadsheet->getProperties()->setCreator('Excel Automotriz El Salvador') /* Autor */
										 ->setLastModifiedBy('Excel Automotriz El Salvador') /* Último usuario que lo modificó */
										 ->setTitle('Reporte Excel Automotriz Suscripciones No Recall')
										 ->setSubject('Reporte Excel Automotriz Suscripciones No Recall')
										 ->setDescription('Reporte de suscripcciones')
										 ->setKeywords('reporte suscriptores')
										 ->setCategory('Reporte');

			$tituloReporte = 'Reporte de Suscripciones';
			$titulosColumnas = array('ID', 'Nombre', 'Apellido', 'Correo', 'Teléfono', 'VIN/Placa', 'Política de Privacidad');
			
			//Se combinan las celdas de B2 -> H2
			$spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:H2');
							
			/* Se agregan los titulos del reporte */
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('B2',  $tituloReporte) // A partir de la celda B2 se agrega el titulo
	        		    ->setCellValue('B4',  $titulosColumnas[0])
	        		    ->setCellValue('C4',  $titulosColumnas[1])
	        		    ->setCellValue('D4',  $titulosColumnas[2])
	        		    ->setCellValue('E4',  $titulosColumnas[3])
	        		    ->setCellValue('F4',  $titulosColumnas[4])
	        		    ->setCellValue('G4',  $titulosColumnas[5])
	        		    ->setCellValue('H4',  $titulosColumnas[6]);
			
			/* Se agregan los datos a partir de fila 5 de la hoja */
			$i = 5;

			foreach($registros as $fila) {

				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('B'.$i,  $fila['id'])
							->setCellValue('C'.$i,  $fila['nombre'])
							->setCellValue('D'.$i,  $fila['apellido'])
							->setCellValue('E'.$i,  $fila['correo'])
							->setCellValue('F'.$i,  $fila['telefono'])
							->setCellValue('G'.$i,  $fila['vinpla'])
							->setCellValue('H'.$i,  $fila['politicaPrivacida']);
	            		
							$i++;
			}

			//Se establece fecha y hora
			$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('K4', 'Fecha y Hora')
							->setCellValue('L4', date('d-m-Y h:i:s a', time()));
			
			$estiloTituloReporte = [
	        	'font' => [ 
		        	'name'   => 'Verdana',
	    	        'bold'   => true,
	        	    'italic' => false,
	                'strike' => false,
	               	'size'   => 12,
		            'color'  => ['rgb' => 'ffffff'],
	            ],
				'fill' => [
					'fillType'   => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'd13239'],
					'endColor'	 => ['rgb' => 'd13239'],
				],
	            'borders' => [
	               	'allborders' => [
	                   	'borderStyle' => Border::BORDER_THIN,
		                'color'  => ['rgb' => '000000'],                 
	               	],
	            ], 
	            'alignment' =>  [
	        			'horizontal'    => Alignment::HORIZONTAL_CENTER,
	        			'vertical'      => Alignment::VERTICAL_CENTER,
	        			'textRotation'  => 0,
	        			'wrapText'      => true,
	    		],
			];

			$estiloTituloColumnas = [
            	'font'  => [
	                'name'  => 'Arial',
	                'bold'  => true,                          
	                'color' => ['rgb' => '000000'],
	            ],
	            'fill' 	=> [
					'Filltype'	 => Fill::FILL_GRADIENT_LINEAR,
					'rotation'   => 90,
	        		'startColor' => ['rgb' => 'ffffff'],
	        		'endColor'   => ['rgb' => 'ffffff'],
				],
	            'borders' => [
	            	'top'     => [
	                    'borderStyle' => Border::BORDER_MEDIUM,
	                    'color' => ['rgb' => 'd13239'],
	                ],
	                'bottom'     => [
	                    'borderStyle' => Border::BORDER_MEDIUM,
	                    'color' => ['rgb' => 'd13239'],
	                ],
	            ],
				'alignment' =>  [	        			
						'horizontal' => Alignment::HORIZONTAL_CENTER,
	        			'vertical'   => Alignment::VERTICAL_CENTER,
	        			'wrapText'   => true,
	    		],
	    	];

			$estiloInformacion = [
	           	'font' => [
	               	'name'   => 'Arial',               
	               	'color'  => ['rgb' => '000000'],
	           	],
	           	'fill' 	=> [
					'Filltype'   => Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'ffffff'],
					'endtColor'	 => ['rgb' => 'ffffff'],
				],
	           	'borders' => [
	               	'allborders' => [
	                   	'borderStyle' => Border::BORDER_THIN ,
		                'color' => ['rgb' => '000000'],
	               	],             
	           	],
	            'alignment' =>  [
	        			'horizontal' => Alignment::HORIZONTAL_CENTER,
	        			'vertical'   => Alignment::VERTICAL_CENTER,
	        			'wrapText'   => true,
	    		],
	        ];
	 
			$spreadsheet->getActiveSheet()->getStyle('B2:H2')->applyFromArray($estiloTituloReporte);
			$spreadsheet->getActiveSheet()->getStyle('B4:H4')->applyFromArray($estiloTituloColumnas);		
			$spreadsheet->getActiveSheet()->getStyle('B5:H'.($i-1))->applyFromArray($estiloInformacion);
			
			$spreadsheet->getActiveSheet()->getStyle('K4')->applyFromArray($estiloTituloReporte);
			$spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($estiloTituloColumnas);

			

			for($i = 'B'; $i <= 'L'; $i++){
				$spreadsheet->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
			}
			
			/* Se asigna el nombre a la hoja */
			$spreadsheet->getActiveSheet()->setTitle('Suscripciones');

			/* Se activa la hoja para que sea la que se muestre cuando el archivo se abre */
			$spreadsheet->setActiveSheetIndex(0);
			
			/* Inmovilizar paneles */
			//$spreadsheet->getActiveSheet(0)->freezePane(0,4);

			//Redirect output to a client’s web browser (Xlsx), con el nombre que se indica.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Reporte de Suscripcciones Excel Recall - '.date("dmY").'.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
			exit;
			
		} else {
			header('Location: ../reportes?r=suscripcionesr&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡La consulta no ha devuelto ningún valor!#msjcita');
			
			/* print_r($select); */
		}

	} else {
		header('Location: ../reportes?r=suscripcionesr&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Ha ocurrido algún error!#msjcita');
	}

?>