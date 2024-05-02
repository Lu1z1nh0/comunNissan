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
		if (!empty($_POST['fecMr'])){
		    $filtro[]  = 'fechaManto = '.'"'.$_POST['fecMr'].'"';
		}

		if (!empty($_POST['filsucsr'])){
		    $filtro[]  = 'sucursal = '.'"'.$_POST['filsucsr'].'"';
		}

		if (!empty($_POST['filestater'])){
		    $filtro[]  = 'estado = '.'"'.$_POST['filestater'].'"';
		}

		/* REVISAR */
		if (!empty($_POST['filvinplar'])){
		    $filtro[]  = 'placa = '.'"'.$_POST['filvinplar'].'"'.' OR vin = '.'"'.$_POST['filvinplar'].'"';
		}  

		if (!empty($_POST['horMr'])){
		    $filtro[]  = 'hora = '.'"'.$_POST['horMr'].'"';
		} 

		if (count($filtro)) {
			/* Si hay más de un filtro */
			$filtro = implode(" AND ",$filtro);
		} else {
		    unset($filtro);
		    $filtro = '1';
		}
			
		$select = $db->prepare("SELECT * FROM cita WHERE $filtro ORDER BY id ASC");
		$select->execute();
		$registros = $select->fetchAll();
		$totalReg = $select->rowCount(); /* Total de registros devueltos */


		if($totalReg > 0 ) {
							
			date_default_timezone_set('America/El_Salvador');

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
										 ->setTitle('Reporte Excel Automotriz Citas Recall')
										 ->setSubject('Reporte Excel Automotriz Citas Recall')
										 ->setDescription('Reporte de Citas')
										 ->setKeywords('reporte citas')
										 ->setCategory('Reporte');

			$tituloReporte = 'Reporte de Citas';
			$titulosColumnas = array('ID', 'VIN', 'Placa', 'Nombre', 'Apellido', 'Correo', 'Teléfono', 'Sucursal', 'Fecha de Reserva', 'Hora de Reserva', 'Estado', 'Política de Privacidad', 'Agregó/Editó', 'Fecha/Hora');

			//Se combinan las celdas de B2 -> O2
			$spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:O2');
							
			/* Se agregan los titulos del reporte */
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('B2',  $tituloReporte) // A partir de la celda B2 se agrega el titulo
	        		    ->setCellValue('B4',  $titulosColumnas[0])
			            ->setCellValue('C4',  $titulosColumnas[1])
	        		    ->setCellValue('D4',  $titulosColumnas[2])
	            		->setCellValue('E4',  $titulosColumnas[3])
			            ->setCellValue('F4',  $titulosColumnas[4])
	        		    ->setCellValue('G4',  $titulosColumnas[5])
	            		->setCellValue('H4',  $titulosColumnas[6])
	            		->setCellValue('I4',  $titulosColumnas[7])
	            		->setCellValue('J4',  $titulosColumnas[8])
	            		->setCellValue('K4',  $titulosColumnas[9])
	            		->setCellValue('L4',  $titulosColumnas[10])
	            		->setCellValue('M4',  $titulosColumnas[11])
	            		->setCellValue('N4',  $titulosColumnas[12])
	            		->setCellValue('O4',  $titulosColumnas[13]);
			
			/* Se agregan los datos */
			$i = 5;

			foreach($registros as $fila) {

				$spreadsheet->setActiveSheetIndex(0)
		        		    ->setCellValue('B'.$i,  $fila['id'])
				            ->setCellValue('C'.$i,  $fila['vin'])
				            ->setCellValue('D'.$i,  $fila['placa'])
				            ->setCellValue('E'.$i,  $fila['nombre'])
		        		    ->setCellValue('F'.$i,  $fila['apellido'])
		            		->setCellValue('G'.$i,  $fila['correo'])
		        		    ->setCellValue('H'.$i,  $fila['telefono'])
		        		    ->setCellValue('I'.$i,  $fila['sucursal'])
				            ->setCellValue('J'.$i,  $fila['fechaManto'])
		        		    ->setCellValue('K'.$i,  $fila['hora'])
		        		    ->setCellValue('L'.$i,  $fila['estado'])
		        		    ->setCellValue('M'.$i,  $fila['politicaPrivacida'])
		        		    ->setCellValue('N'.$i,  $fila['addEdit'])
		        		    ->setCellValue('O'.$i,  $fila['fechaAddEdit']); 
		            		
							$i++;
			}

			//Se establece fecha y hora
			$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('R4', 'Fecha y Hora')
							->setCellValue('S4', date('d-m-Y h:i:s a', time()));
			
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

			$spreadsheet->getActiveSheet()->getStyle('B2:O2')->applyFromArray($estiloTituloReporte);
			$spreadsheet->getActiveSheet()->getStyle('B4:O4')->applyFromArray($estiloTituloColumnas);		
			$spreadsheet->getActiveSheet()->getStyle('B5:O'.($i-1))->applyFromArray($estiloInformacion);
			
			$spreadsheet->getActiveSheet()->getStyle('R4')->applyFromArray($estiloTituloReporte);
			$spreadsheet->getActiveSheet()->getStyle('S4')->applyFromArray($estiloTituloColumnas);
					
			for($i = 'B'; $i <= 'S'; $i++){
				$spreadsheet->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
			}
			
			/* Se asigna el nombre a la hoja */
			$spreadsheet->getActiveSheet()->setTitle('Citas');

			/* Se activa la hoja para que sea la que se muestre cuando el archivo se abre */
			$spreadsheet->setActiveSheetIndex(0);
			
			/* Inmovilizar paneles */
			//$spreadsheet->getActiveSheet(0)->freezePane(0,4);

			//Redirect output to a client’s web browser (Xlsx), con el nombre que se indica.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Reporte de Citas Excel Recall - '.date("dmY").'.xlsx"');
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
			
		}
		else{
			header('Location: ../reportes?r=citas&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡La consulta no ha devuelto ningún valor!#msjcita');
			
			/* print_r($select); */
		}

	} else {
		header('Location: ../reportes?r=citas&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Ha ocurrido algún error!#msjcita');
	}

?>