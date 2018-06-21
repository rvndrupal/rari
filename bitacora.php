<?php require_once('Connections/rari_coneccion.php');
require_once 'libs/PHPExcel/PHPExcel.php'; 
require_once 'php/detalles.php';

if(!isset($_GET['us'])||!isset($_GET['ar']))
{
	$GoTo = "bienvenido.php";			
header(sprintf("Location: %s", $GoTo));
	}




date_default_timezone_set('America/Mexico_City');
$objPHPExcel = new PHPExcel();
							 
	
$objPHPExcel->getProperties()->setCreator("RARI")
    ->setLastModifiedBy("RARI")
    ->setTitle("Reporte Excel con PHP y MySQL")
    ->setSubject("Reporte Excel con PHP y MySQL")
    ->setDescription("Reporte de bitacora")
    ->setKeywords("reporte")
    ->setCategory("Reporte excel"); 
	
	$periodo=" el día ".$_GET['fa1'];
	$rango="(".$_GET['fa1'].")";
	if($_GET['fa1']!=$_GET['fa2'])
	{
	$periodo=" desde ".$_GET['fa1']." hasta ". $_GET['fa2'];
	$rango="(".$_GET['fa1']."-".$_GET['fa2'].")";
	}
	$tituloReporte = "Bitácora de comunicados emitidos en RARI".$periodo;
	$titulosColumnas = array('Tipo de comunicado', ' Area', 'Tipo de contaminación', 'Problema/Agente causal
','Hospedero', 'Fecha', 'Fracción arancelaria', 'Localización', 'Oisa', 'PVI', 'PVIF', 'Medidas implementadas', 'Medidas a implementar', 'Motivo de notificación', 'Categoría del riesgo', 'Reglamentación', 'Regulación Internacional', 'Resolución', 'Nivel de riesgo', 'Nivel de alerta', 'Estatus fitosanitario', 'Latitud', 'Longitud');
	
	$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:W1');
	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',utf8_encode($tituloReporte))
        		    ->setCellValue('A3',  utf8_encode($titulosColumnas[0]))
		            ->setCellValue('B3',  utf8_encode($titulosColumnas[1]))
        		    ->setCellValue('C3',  utf8_encode($titulosColumnas[2]))
					->setCellValue('D3',  utf8_encode($titulosColumnas[3]))
					->setCellValue('E3',  utf8_encode($titulosColumnas[4]))
					->setCellValue('F3',  utf8_encode($titulosColumnas[5]))
					->setCellValue('G3',  utf8_encode($titulosColumnas[6]))
					->setCellValue('H3',  utf8_encode($titulosColumnas[7]))
					->setCellValue('I3',  utf8_encode($titulosColumnas[8]))
					->setCellValue('J3',  utf8_encode($titulosColumnas[9]))
					->setCellValue('K3',  utf8_encode($titulosColumnas[10]))
					->setCellValue('L3',  utf8_encode($titulosColumnas[11]))
					->setCellValue('M3',  utf8_encode($titulosColumnas[12]))
					->setCellValue('N3',  utf8_encode($titulosColumnas[13]))
					->setCellValue('O3',  utf8_encode($titulosColumnas[14]))
					->setCellValue('P3',  utf8_encode($titulosColumnas[15]))
					->setCellValue('Q3',  utf8_encode($titulosColumnas[16]))
					->setCellValue('R3',  utf8_encode($titulosColumnas[17]))
					->setCellValue('S3',  utf8_encode($titulosColumnas[18]))
					->setCellValue('T3',  utf8_encode($titulosColumnas[19]))
            		->setCellValue('U3',  utf8_encode($titulosColumnas[20]))
					->setCellValue('V3',  utf8_encode($titulosColumnas[21]))
					->setCellValue('W3',  utf8_encode($titulosColumnas[22]));
							 
				
	$bitacoraSQL ="";
	
	if(isset($_GET['ar']) && $_GET['ar']!=0){
		$bitacoraSQL ="select 
		tbl_comunicado.id as Id,
		tbl_comunicado.titulo as Titulo,
		tbl_comunicado.idTipoContaminacion,
		tbl_comunicado.idEstatus,
		tbl_comunicado.fecha as Fecha,
		cat_comunicados.nombre as TipoComunicado, 
		tbl_areas.nombre as Area, 
		cat_nivel_alerta.nombre as NivelAlerta, 
		cat_nivel_riesgo.nombre as NivelRiesgo
		from tbl_comunicado
		inner join cat_comunicados on tbl_comunicado.idTipoComunicado=cat_comunicados.id
		inner join tbl_areas on tbl_comunicado.idArea=tbl_areas.id
		inner join cat_nivel_alerta on tbl_comunicado.idNivelAlerta=cat_nivel_alerta.id
		inner join cat_nivel_riesgo on tbl_comunicado.idNivelRiesgo=cat_nivel_riesgo.id
		where tbl_comunicado.idArea=".$_GET['ar']." and tbl_comunicado.fecha_registro>='".$_GET['fa1']."' and tbl_comunicado.fecha_registro<='".$_GET['fa2']."'";
	}else{
		$bitacoraSQL ="select
		tbl_comunicado.id as Id,
		tbl_comunicado.titulo as Titulo,
		tbl_comunicado.idTipoContaminacion,
		tbl_comunicado.idEstatus,
		tbl_comunicado.fecha as Fecha,
		cat_comunicados.nombre as TipoComunicado,
		tbl_areas.nombre as Area,
		cat_nivel_alerta.nombre as NivelAlerta,
		cat_nivel_riesgo.nombre as NivelRiesgo
		from tbl_comunicado
		inner join cat_comunicados on tbl_comunicado.idTipoComunicado=cat_comunicados.id
		inner join tbl_areas on tbl_comunicado.idArea=tbl_areas.id
		inner join cat_nivel_alerta on tbl_comunicado.idNivelAlerta=cat_nivel_alerta.id
		inner join cat_nivel_riesgo on tbl_comunicado.idNivelRiesgo=cat_nivel_riesgo.id
		where tbl_comunicado.idArea>=".$_GET['ar']." and tbl_comunicado.fecha_registro>='".$_GET['fa1']."' and tbl_comunicado.fecha_registro<='".$_GET['fa2']."'";
	}
	
	
	
	//if(isset($_GET['rol'])&&$_GET['rol']>1)
	//$bitacoraSQL=$bitacoraSQL." and tbl_comunicado.idUsuario=".$_GET['us'];
	
	
$bitacoraSQL=$bitacoraSQL." order by Id";
	mysql_select_db($database_rari_coneccion, $rari_coneccion);
  	$bitacora = mysql_query($bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
	
	$i = 4;
	while($row_bitacora = mysql_fetch_assoc($bitacora))
	{
		$olocs=consultarLocs($row_bitacora["Id"], $database_rari_coneccion, $rari_coneccion);
		
		for($x=0; $x<count($olocs[0]); $x++)
		{
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $row_bitacora["TipoComunicado"])
		            ->setCellValue('B'.$i,  $row_bitacora["Area"])
					->setCellValue('C'.$i,  obtenerNombreCampo($row_bitacora['idTipoContaminacion'], "cat_contaminacion", $database_rari_coneccion, $rari_coneccion))
					->setCellValue('D'.$i,  consultarDetalle($row_bitacora["Id"],1,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('E'.$i,  consultarDetalle($row_bitacora["Id"],8,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('F'.$i,  $row_bitacora["Fecha"])
					->setCellValue('G'.$i,  consultarDetalle($row_bitacora["Id"],2,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('H'.$i,  $olocs[2][$x])
					->setCellValue('I'.$i, utf8_encode(consultarDetalle($row_bitacora["Id"],7,$database_rari_coneccion, $rari_coneccion)))
					->setCellValue('J'.$i,  consultarDetalle($row_bitacora["Id"],9,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('K'.$i,  consultarDetalle($row_bitacora["Id"],10,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('L'.$i,  consultarDetalle($row_bitacora["Id"],4,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('M'.$i,  consultarDetalle($row_bitacora["Id"],5,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('N'.$i,  consultarDetalle($row_bitacora["Id"],6,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('O'.$i, 	consultarDetalle($row_bitacora["Id"],14,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('P'.$i,  consultarDetalle($row_bitacora["Id"],12,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('Q'.$i,  consultarDetalle($row_bitacora["Id"],11,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('R'.$i,  consultarDetalle($row_bitacora["Id"],13,$database_rari_coneccion, $rari_coneccion))
					->setCellValue('S'.$i,  $row_bitacora["NivelRiesgo"])
					->setCellValue('T'.$i,  $row_bitacora["NivelAlerta"])
					->setCellValue('U'.$i,  obtenerNombreCampo($row_bitacora['idEstatus'], "cat_estatus", $database_rari_coneccion, $rari_coneccion))
					->setCellValue('V'.$i,  $olocs[0][$x])
					->setCellValue('W'.$i,  $olocs[1][$x]);
					$i++;
		}
		}


	
	
	

	
				$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>16,
	            	'color'     => array(
    	            	'rgb' => '333333'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'CCCCCC')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), 
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'borders' => array(
            	'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));
			
		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',               
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'EEEEEE')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
                   	)
               	)             
           	)
        ));
		 
		$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:W3')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:W".($i-1));
				
		for($i = 'A'; $i <= 'V'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		
		$objPHPExcel->getActiveSheet()->setTitle('Bitacora');

		
		$objPHPExcel->setActiveSheetIndex(0);


			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BitacoraRARI-'.$rango.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;



 
  ?>