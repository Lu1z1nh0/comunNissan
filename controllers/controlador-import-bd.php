<?php
	/* Conforma la comunicación con el Modelo */ 
	require_once($_SERVER['DOCUMENT_ROOT']."/models/vaciado-bd.php");

	require ($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");
	
	/* Libreria PhpSpreadsheet que permite la importacion a una BD desde un archivo excel .xls y .xlsx */
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Csv;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use PhpOffice\PhpSpreadsheet\Reader\Xls;
	
	$vaciado = new VaciadoBd();
	
	if (isset($_POST["importar"]))
	{ 
		/* Tabla a vaciar */
	    $tabla = $_POST['tabla']; 
		
		/* Fecha de carga de tabla */
		$fechacarga = $_POST['fechacarga'];
		
		/* Usuario que carga la tabla */
		$usercarga = $_POST['usercarga'];

		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

			/* Busca la tabla a vaciar y lo hace si esta existe */
			if ($vaciado->buscarTabla($tabla)) {
				$vaciado->vaciarBd($tabla);
			}else{
				header('Location: ../gestion-bd?msjcls1=mensaje-error&mensaje1=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡La Tabla no existe o ha ocurrido algún error!#msj1');
			}

		     
	        $arr_file = explode('.', $_FILES['file']['name']); //para obtener la extensión del archivo
	        $extension = end($arr_file); //la extensión del archivo ej.: .csv, .xls, .xlsx
	     
	     	//Establece una ruta de guardado del archivo de excel subido
	     	$targetPath = '../uploads/'.$_FILES['file']['name'];
	     	
	     	//guarda el archivo en la ubicación proporcionada $targetPath
	     	move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

			if('csv' == $extension) {  
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else if('xls' == $extension) {  
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {    
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}

	        $spreadsheet = $reader->load($targetPath);
	 
	        $sheetData = $spreadsheet->getActiveSheet()->toArray();
	         
	        if (!empty($sheetData)) {

	            for ($i=0; $i<count($sheetData); $i++) {

	                $pais = $sheetData[$i][0];
	                $vin = $sheetData[$i][1];
	                $placa = $sheetData[$i][2];
	                $marca = $sheetData[$i][3];
	                $modelo = $sheetData[$i][4];
	                $idExcel = $sheetData[$i][5];
	                $idFabrica = $sheetData[$i][6];
	                $nombreCampanya = $sheetData[$i][7];
	                $descripcionCampanya = $sheetData[$i][8];


					if (!empty($pais) || !empty($vin) || !empty($placa) || !empty($marca) || !empty($modelo) || !empty($idExcel) || !empty($idFabrica) || !empty($nombreCampanya) || !empty($descripcionCampanya)) {
						
						$db=DB::conectar();

						/* Carga los datos en la tabla "campanyas" */
						$insert=$db->prepare('INSERT INTO campanyas (pais, vin, placa, marca, modelo, idExcel, idFabrica, nombreCampanya, descripcionCampanya) VALUES(:pais, :vin, :placa, :marca, :modelo, :idExcel, :idFabrica, :nombreCampanya, :descripcionCampanya)');

						$insert->bindValue(':pais',$pais, PDO::PARAM_STR);
						$insert->bindValue(':vin',$vin, PDO::PARAM_STR);
						$insert->bindValue(':placa',$placa, PDO::PARAM_STR);
						$insert->bindValue(':marca',$marca, PDO::PARAM_STR);
						$insert->bindValue(':modelo',$modelo, PDO::PARAM_STR);
						$insert->bindValue(':idExcel',$idExcel, PDO::PARAM_INT);
						$insert->bindValue(':idFabrica',$idFabrica, PDO::PARAM_STR);
						$insert->bindValue(':nombreCampanya',$nombreCampanya, PDO::PARAM_STR);
						$insert->bindValue(':descripcionCampanya',$descripcionCampanya, PDO::PARAM_STR);
						/* $insert->execute(); */

						/* Carga los datos en la tabla "auditoria" */
						$insert1=$db->prepare('INSERT INTO auditoria (pais, vin, placa, marca, modelo, idExcel, idFabrica, nombreCampanya, descripcionCampanya, fechaCarga, usuarioCarga) VALUES(:pais, :vin, :placa, :marca, :modelo, :idExcel, :idFabrica, :nombreCampanya, :descripcionCampanya, :fechaCarga, :usuarioCarga)');

						$insert1->bindValue(':pais',$pais, PDO::PARAM_STR);
						$insert1->bindValue(':vin',$vin, PDO::PARAM_STR);
						$insert1->bindValue(':placa',$placa, PDO::PARAM_STR);
						$insert1->bindValue(':marca',$marca, PDO::PARAM_STR);
						$insert1->bindValue(':modelo',$modelo, PDO::PARAM_STR);
						$insert1->bindValue(':idExcel',$idExcel, PDO::PARAM_INT);
						$insert1->bindValue(':idFabrica',$idFabrica, PDO::PARAM_STR);
						$insert1->bindValue(':nombreCampanya',$nombreCampanya, PDO::PARAM_STR);
						$insert1->bindValue(':descripcionCampanya',$descripcionCampanya, PDO::PARAM_STR);
						$insert1->bindValue(':fechaCarga',$fechacarga, PDO::PARAM_STR);
						$insert1->bindValue(':usuarioCarga',$usercarga, PDO::PARAM_STR);
						/* $insert1->execute(); */
						
						try {
							$insertp=$insert->execute();
						} catch (Exception $e) {
							echo 'Excepción capturada: ',  $e->getMessage(), "\n";
						}
						
						if ($insertp) {
							/* Realiza la insercion de datos en la tabla "auditoria" */
							$insert1->execute();
							header('Location: ../gestion-bd?msjcls1=mensaje-exito&mensaje1=<i class="fa fa-check" aria-hidden="true"></i> ¡La importación ha sido exitosa!#msj1');
						} else {
							header('Location: ../gestion-bd?msjcls1=mensaje-error&mensaje1=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Ha ocurrido un problema al importar!#msj1');
						}
					}//fin IF empty(data)

	            }//fin FOR Count

	        }//fin IF empty(!sheetData)

	    //fin IF isset(FILE)
	    } else { 
			header('Location: ../gestion-bd?msjcls1=mensaje-error&mensaje1=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Formato de archivo inválido, debe ser: .xls ó .xlsx#msj1');
		}

	}//fin If que valida se se presiono el botón importar
?>