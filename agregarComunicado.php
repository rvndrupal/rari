<?php
	ob_start();
	function extension($str) 
	{
		$array=explode("/", $str);
		return $array[count($array)-1];
	}

	include('php/inicioSesion.php');
	require_once('Connections/rari_coneccion.php');

	$IidComunicado=0;

	if(isset($_POST['idcmncd']))
		$IidComunicado=base64_decode(base64_decode($_POST['idcmncd']));
	
	//echo $IidComunicado;

	$titulo=$_POST['txtTituloComunicado'];
	$tipo_comunicado=$_POST['cmb_comunicados'][0];
	

	//Código nuevo. Se agrega variable para recibir el combo de áreas de adscripción. LVC. 7-Junio-2017.
	$areas_adscripcion=$_POST['cmb_area_adscripcion'][0];
	//Termina código nuevo.
	
	//Se agrega código para determinar si el comunicado tendrá Seguimiento. LVC 4-Octubre-2017
	if(isset($_POST['chk_seguimiento']))
	{
		$seguimiento= 1;
	}

	else
	{
		
		//agregar lo ultimo
		if(($_POST['cmb_nivel_riesgo'][0] == 3 or $_POST['cmb_nivel_riesgo'][0] == 4) and ($_POST['cmb_nivel_alerta'][0] == 5 or $_POST['cmb_nivel_alerta'][0] == 6) or ($_POST['cmb_resolucion'][0] == 6) or ($_POST['cmb_resolucion'][0] == 10) or ($_POST['cmb_resolucion'][0] == 17) or ($_POST['cmb_resolucion'][0] == 8) or ($_POST['cmb_resolucion'][0] == 21))
		{
			$seguimiento= 1;
		}
		else
		{
			$seguimiento= 0;
		}
	}
	//Termina código nuevo.

	
	if(isset($_POST['cmb_contaminacion']))
		$tipo_contaminacion=$_POST['cmb_contaminacion'][0];
	else
		$tipo_contaminacion="null";	

	if(isset($_POST['cmb_areas']))
		$id_area=$_POST['cmb_areas'][0];
	else
		$id_area="null";

	$fecha=$_POST['date'];//LLEGÓ
	$contenido=nl2br(strip_tags($_POST['contenido']));

	if(isset($_POST['lImagen'])&&$_POST['lImagen']!=0)
		$imagen=$_POST['lImagen'];
	else{
		$imagen=date("dmyHis").$_SESSION['id'].".".extension($_FILES['imagen']['type']);
		copy($_FILES['imagen']['tmp_name'],"archivos_alertas/imagenes/".$imagen);
	}

	if(isset($_FILES['pdf']))
	{
		$pdf=date("dmyHis")."_".utf8_decode($_FILES['pdf']['name']);
		move_uploaded_file($_FILES['pdf']['tmp_name'],"archivos_alertas/pdfs/".$pdf);
		$pdf="'".$pdf."'";
	}
	else if(isset($_POST['lPdf'])&&$_POST['lPdf']!=0)
		$pdf="'".$_POST['lPdf']."'";
	else
		$pdf="null";
		
	
	if(isset($_POST['lMapa'])&&$_POST['lMapa']!=0)
		$mapa="'".$_POST['lMapa']."'";
	else if(isset($_FILES['txtMapa']))
	{
		$mapa=date("dmyHis").$_SESSION['id'].".".extension($_FILES['txtMapa']['type']);
		copy($_FILES['txtMapa']['tmp_name'],"archivos_alertas/mapas/".$mapa);
		$mapa="'".$mapa."'";
	}
	else
		$mapa="null";
	


	$nivel_riesgo=$_POST['cmb_nivel_riesgo'];
	$nivel_alerta=$_POST['cmb_nivel_alerta'];
	if(isset($_POST['cmb_estatus']))
		$estatus_fito=$_POST['cmb_estatus'][0];
	else
		$estatus_fito="null";

	
	$area=$_POST['ar'];


	//Generar folio

	if(isset($_POST['mdd']))
	{
		$folio="";
		$ini="";
		$mdd=$_POST['mdd'];
		var_dump($mdd);
		if($mdd==1)
		{
			$ini="VEG-";
		}
		if($mdd==2)
		{
			$ini="ANI-";
		}

		if($mdd==3)
		{
			$ini="INO-";
		}
		if($mdd==4)
		{
			$ini="ACU-";
		}

		if($mdd==5)
		{
			$ini="INS-";
		}
		if($mdd==6)
		{
			$ini="UIS-";
		}
	}
	
	if($tipo_comunicado==1){
		$tp="Alerta";
	}
	if($tipo_comunicado==2){
		$tp="Cuarentena";
	}
	if($tipo_comunicado==3){
		$tp="Información";
	}
	if($tipo_comunicado==4){
		$tp="Noticias";
	}
	if($tipo_comunicado==5){
		$tp="Rechazo";
	}
	if($tipo_comunicado==6){
		$tp="Retención";
	}
	
	


	
	$titulo=$_POST['txtTituloComunicado'];	
	$texto=substr($titulo, 0 , 3);
	$folio=$ini.$tp."-".$fecha;
	


	$hora=date("h:i:s");


	//Generar folio

   
    

	

	// Se agrega funcionalidad nueva para establecer seguimientos. Se inserta dato en tabla tbl_comunicado. LVC 5-Octubre-2017.
	if($IidComunicado==0)
	{
		//$insertSQL ="INSERT INTO tbl_comunicado (idTipoComunicado, idTipoContaminacion, titulo, resumen, imagen, documento, idUsuario, fecha, idNivelRiesgo, idNivelAlerta, idEstatus, autorizacion, idArea, fecha_registro, mapa, idAreaUIS) VALUES (".$tipo_comunicado.",".$tipo_contaminacion.", '".$titulo."', '".$contenido."', '".$imagen."', ".utf8_decode($pdf).", ".$_SESSION['id'].", '".$fecha."', ".$nivel_riesgo[0].", ".$nivel_alerta[0].", ".$estatus_fito.", 0, ".$area.", curdate(),".$mapa.",".$id_area.")";
		$insertSQL ="INSERT INTO tbl_comunicado (idTipoComunicado, idTipoContaminacion, titulo, resumen, imagen, documento, idUsuario, fecha, idNivelRiesgo, idNivelAlerta, idEstatus, autorizacion, idArea, fecha_registro, hora, mapa, idAreaUIS, seguimiento, folio, desc_comunicado) VALUES (".$tipo_comunicado.",".$tipo_contaminacion.", '".$titulo."', '".$contenido."', '".$imagen."', ".$pdf.", ".$_SESSION['id'].", '".$fecha."', ".$nivel_riesgo[0].", ".$nivel_alerta[0].", ".$estatus_fito.", 0, ".$area.", curdate(),'".$hora."' ,".$mapa.",".$id_area.", ".$seguimiento.",'".$folio."','".$contenido."')";
		
		//$insertSQL ="INSERT INTO tbl_comunicado (idTipoComunicado, idTipoContaminacion, titulo) VALUES (".$tipo_comunicado.",".$tipo_contaminacion.", '".$titulo."')";
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		$id_alerta = mysql_insert_id($rari_coneccion);
		
		//Se inserta registro en nueva tabla de seguimiento. LVC 9-Octubre-2017
		$insertSQLseg ="INSERT INTO tbl_seguimiento (idComunicado, seguimientoResumen, seguimientoCambios) VALUES (".$id_alerta.", 'Resumen Original \n".$contenido."\n************************************', CONCAT('Alta de seguimiento. ', curdate(), '\n ' ))";

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result2 = mysql_query($insertSQLseg, $rari_coneccion) or die(mysql_error());

		
	//Termina código nuevo.
	
	}
	else
	{
		$id_alerta =$IidComunicado;
		$insertSQL ="UPDATE tbl_comunicado SET idTipoComunicado=".$tipo_comunicado.",  idTipoContaminacion=".$tipo_contaminacion.", titulo='".$titulo."', resumen='".$contenido."', imagen='".$imagen."', documento=".$pdf.", idUsuario=".$_SESSION['id'].", fecha='".$fecha."', idNivelRiesgo=".$nivel_riesgo[0].", idNivelAlerta=".$nivel_alerta[0].", idEstatus=".$estatus_fito.", mapa=".$mapa.", idAreaUIS=".$id_area." WHERE id=".$id_alerta;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		$catalogos=array("det_comunicado_agente",
						"det_comunicado_enlace",
						"det_comunicado_fraccion",
						"det_comunicado_localizacion",
						"det_comunicado_medidas_implementadas",
						"det_comunicado_medidas_implementar",
						"det_comunicado_motivos",
						"det_comunicado_oisas",
						"det_comunicado_productos",
						"det_comunicado_pvifs",
						"det_comunicado_pvis",
						"det_comunicado_reglam_int",
						"det_comunicado_reglamentacion",
						"det_comunicado_resolucion",
						"det_comunicado_riesgo");

		for($i=0; $i<count($catalogos);$i++)
		{
			$insertSQL ="DELETE FROM ".$catalogos[$i]." WHERE idComunicado=".$IidComunicado;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
			//echo "Eliminando de ".$catalogos[$i];
		}
			
	}

	//Inserción de enlaces   OK revisar registro vacío
	if(isset($_POST['resultEnlaces']))
	{
		$arreglo_enlaces= explode ("°",$_POST['resultEnlaces']);
		for($i=0;$i<count($arreglo_enlaces)-1;$i++) 
		{ 
			$insertSQL ="INSERT INTO det_comunicado_enlace (idComunicado, enlace) VALUES (".$id_alerta.", '".str_replace("'","''",utf8_encode($arreglo_enlaces[$i]))."')";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}

	echo '<br/><br/><br/><br/><br/><br/>';

	//Código nuevo. Inserción de áreas de adscripción. LVC. 7-Junio-2017
	//Se agregará código para insertar los secretarios generales. 27-julio-2017	
	$arreglo_areas_ads=$_POST['cmb_area_adscripcion'];
	
	for ($i=0;$i<count($arreglo_areas_ads);$i++) 
	{
		echo "Insertando (".$id_alerta.",".$arreglo_areas_ads[$i].")";
		$insertSQL ="INSERT INTO det_comunicado_area_adscripcion (idComunicado, idAreaAdscripcion) VALUES (".$id_alerta.", ".$arreglo_areas_ads[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}
	
	// Los secretarios no seran agregados a la tabla. Solo se les enviará el correo.
	// Solo agregaremos el grupo "Secretarios técnicos". Si el grupo no estaba en el arreglo, se enviarán correos a todos los miembros. Y si ya estaba, no se envian duplicados.
	array_push($arreglo_areas_ads, 7);
	//Termina código nuevo. 

	//Inserción de agentes   OK
	$arreglo_agentes=$_POST['cmb_agentes'];
	for ($i=0;$i<count($arreglo_agentes);$i++) 
	{
		//echo "Insertando (".$id_alerta.",".$arreglo_agentes[$i].")";
		$insertSQL ="INSERT INTO det_comunicado_agente (idComunicado, idAgente) VALUES (".$id_alerta.", ".$arreglo_agentes[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Inserción de productos u hospederos   OK
	$arreglo_productos=$_POST['cmb_productos'];
	for ($i=0;$i<count($arreglo_productos);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_productos (idComunicado, idProducto) VALUES (".$id_alerta.", ".$arreglo_productos[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Inserción de oisas  OK
	if(isset($_POST['cmb_oisas']))
	{
		$arreglo_oisas=$_POST['cmb_oisas'];;
		for ($i=0;$i<count($arreglo_oisas);$i++) 
		{
			$insertSQL ="INSERT INTO det_comunicado_oisas (idComunicado, idOisa) VALUES (".$id_alerta.", ".$arreglo_oisas[$i].")";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}

	//Inserción de PVIS   OK
	if(isset($_POST['cmb_pvis']))
	{
		$arreglo_pvis=$_POST['cmb_pvis'];
		for ($i=0;$i<count($arreglo_pvis);$i++)
		{
			$insertSQL ="INSERT INTO det_comunicado_pvis (idComunicado, idPvi) VALUES (".$id_alerta.", ".$arreglo_pvis[$i].")";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}

	//Inserción de PVIFS   OK
	if(isset($_POST['cmb_pvifs']))
	{
		$arreglo_pvifs=$_POST['cmb_pvifs'];
		for ($i=0;$i<count($arreglo_pvifs);$i++) 
		{
			$insertSQL ="INSERT INTO det_comunicado_pvifs (idComunicado, idPvif) VALUES (".$id_alerta.", ".$arreglo_pvifs[$i].")";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}
	
	//Inserción de fracciones
	if(isset($_POST['cmb_fraccion']))
	{
		$arreglo_fraccion=$_POST['cmb_fraccion'];
		for ($i=0;$i<count($arreglo_fraccion);$i++) 
		{
			$insertSQL ="INSERT INTO det_comunicado_fraccion (idComunicado, idFraccion) VALUES (".$id_alerta.", ".$arreglo_fraccion[$i].")";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}

	//Insercion de medidas implementadas
	$arreglo_med_implementadas=$_POST['cmb_med_implementadas'];
	for ($i=0;$i<count($arreglo_med_implementadas);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_medidas_implementadas (idComunicado, idMedidaImplementada) VALUES (".$id_alerta.", ".$arreglo_med_implementadas[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Insercion de medidas a implementar
	$arreglo_med_implementar=$_POST['cmb_med_aimplementar'];
	for ($i=0;$i<count($arreglo_med_implementar);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_medidas_implementar (idComunicado, idMedidaImplementada) VALUES (".$id_alerta.", ".$arreglo_med_implementar[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}
	
	//Insercion de motivos
	$arreglo_motivos=$_POST['cmb_motivos'];
	for ($i=0;$i<count($arreglo_motivos);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_motivos (idComunicado, idMotivo) VALUES (".$id_alerta.", ".$arreglo_motivos[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Insercion de riesgos
	$arreglo_riesgos=$_POST['cmb_riesgo'];
	for ($i=0;$i<count($arreglo_riesgos);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_riesgo (idComunicado, idRiesgo) VALUES (".$id_alerta.", ".$arreglo_riesgos[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Insercion de reglamentaciones
	$arreglo_reglamentacion=$_POST['cmb_reglamentacion'];
	for ($i=0;$i<count($arreglo_reglamentacion);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_reglamentacion (idComunicado, idReglamentacion) VALUES (".$id_alerta.", ".$arreglo_reglamentacion[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Insercione de reglamentos internacionales
	if(isset($_POST['cmb_reglamentacion_int']))
	{
		$arreglo_reg_int=$_POST['cmb_reglamentacion_int'];
		for ($i=0;$i<count($arreglo_reg_int);$i++) 
		{
			$insertSQL ="INSERT INTO det_comunicado_reglam_int (idComunicado, idReglaInt) VALUES (".$id_alerta.", ".$arreglo_reg_int[$i].")";;
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
	}

	//Insercion de resoluciones 
	$arreglo_resolucion=$_POST['cmb_resolucion'];
	for ($i=0;$i<count($arreglo_resolucion);$i++) 
	{
		$insertSQL ="INSERT INTO det_comunicado_resolucion (idComunicado, idResolucion) VALUES (".$id_alerta.", ".$arreglo_resolucion[$i].")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	//Insercione de localizaciones
	$arreglo_localizaciones= explode ("°",$_POST['resultLocs']);
	for($i=0;$i<count($arreglo_localizaciones)-1;$i++) 
	{
		$localizacion=explode ("|",$arreglo_localizaciones[$i]);
		$pais=$localizacion[0];
		$edo=count($localizacion)==6?$localizacion[1]:"null";
		$mpo=count($localizacion)==6?$localizacion[2]:"null";
		$otraLoc=count($localizacion)==6?$localizacion[3]:$localizacion[1];
		$Lat=count($localizacion)==6?$localizacion[4]:$localizacion[2];
		$Lon=count($localizacion)==6?$localizacion[5]:$localizacion[3];
		$insertSQL ="INSERT INTO det_comunicado_localizacion (idComunicado, idPais, idEstado, idMunicipio, region, latitud, longitud) VALUES (".$id_alerta.", ".$pais.", ".$edo.", ".$mpo.", '".$otraLoc."', ".$Lat.", ".$Lon.")";;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}


	
	/*
	//enviando correo a interesado.
	
	//$arreglo_destinatarios = $_POST['cmb_area_adscripcion'];
	$arreglo_destinatarios = $arreglo_areas_ads;
	
	for($i=0;$i<=count($arreglo_destinatarios)-1;$i++)
	{
		$destinatarios[$i]=$arreglo_destinatarios[$i];
	}

	$objClienteSOAP = new soapclient('http://sinavef.senasica.gob.mx/wsRARI/Service.asmx?WSDL');
	
	$params = array('AreasAdscripcion'=> $destinatarios, 'idAlerta' =>$id_alerta);
	//$objClienteSOAP->__soapCall("envioCorreoDirecciones", $params);
	$objClienteSOAP->envioCorreoDirecciones($params);
	*/
	//$Goto = '/bienvenido.php';
	//$GoTo = '/listado.php?mod='.$area;		
	header('Location: bienvenido.php ');
	exit();
 ?>