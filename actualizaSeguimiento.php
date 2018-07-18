<!-- 
******************************************************************
**	Página creada por Luis Antonio Vera Castañeda.				**
**	Octubre de 2017.											**
**	                                                            **
**	actualizaSeguimiento.php									**
**	Página creada para cubrir funcionalidad de seguimientos.	**
**	Basada en el código de la página form.php					**
**	El código se ha depurado y corregido.						**
**                                                              **
******************************************************************
-->

<?php
	ob_start();
	function extension($str) 
	{
		$array=explode("/", $str);
		return $array[count($array)-1];
	}
	
	include('php/inicioSesion.php');
	require_once('Connections/rari_coneccion.php');
	
	if(isset($_POST['idcmncd']))
		$IidComunicado=base64_decode(base64_decode($_POST['idcmncd']));
	else
	{
		$GoTo = '/bienvenido.php';
		header('Location :' .$GoTo);
	}	
	
$actulizado="falso";

    $titulo=$_POST['txtTituloComunicado'];
    $tipo_comunicado=$_POST['cmb_comunicados'][0];
    $areas_adscripcion=$_POST['cmb_area_adscripcion'][0];
    $fecha=$_POST['date'];
    $contenido=nl2br(strip_tags($_POST['contenido']));
    $nivel_riesgo=$_POST['cmb_nivel_riesgo'];
    $nivel_alerta=$_POST['cmb_nivel_alerta'];
    $detalles_seguimiento = nl2br(strip_tags($_POST['contenido']));
    $nuevos_detalles_seguimiento = nl2br(strip_tags($_POST['anexoContenido']));
    $area=$_POST['ar'];
    
    if (isset($_POST['chk_seguimiento'])) {
        //Se agrega condición, para quitar seguimiento a comunicados en estatus "Resuelto", "Cerrado" o "De Conocimiento". LVC 11-Junio-2018.
        if ($_POST['cmb_resolucion'][0] == 7 or $_POST['cmb_resolucion'][0] == 9 or $_POST['cmb_resolucion'][0] == 11 or $_POST['cmb_resolucion'][0] == 18 or
            $_POST['cmb_resolucion'][0] == 20 or $_POST['cmb_resolucion'][0] == 23 or $_POST['cmb_resolucion'][0] == 24 or $_POST['cmb_resolucion'][0] == 26 or
            $_POST['cmb_resolucion'][0] == 27 or $_POST['cmb_resolucion'][0] == 28 or $_POST['cmb_resolucion'][0] == 29) {
            $seguimiento= 0;
        } else {
            $seguimiento= 1;
        }
    } else {
        if (($_POST['cmb_nivel_riesgo'][0] == 3 or $_POST['cmb_nivel_riesgo'][0] == 4) and ($_POST['cmb_nivel_alerta'][0] == 5 or $_POST['cmb_nivel_alerta'][0] == 6)) {
            $seguimiento= 1;
        } else {
            $seguimiento= 0;
        }
    }
    
    if (isset($_POST['cmb_contaminacion'])) {
        $tipo_contaminacion=$_POST['cmb_contaminacion'][0];
    } else {
        $tipo_contaminacion='null';
    }
    
    if (isset($_POST['cmb_areas'])) {
        $id_area=$_POST['cmb_areas'][0];
    } else {
        $id_area='null';
    }
    
    if (isset($_POST['lImagen'])&&$_POST['lImagen']!=0) {
        $imagen=$_POST['lImagen'];
    } else {
        $imagen=date('dmyHis').$_SESSION['id'].'.'.extension($_FILES['imagen']['type']);
        copy($_FILES['imagen']['tmp_name'], 'archivos_alertas/imagenes/'.$imagen);
    }

    if (isset($_FILES['pdf'])) {
        $pdf=date('dmyHis').'_'.$_FILES['pdf']['name'];
        move_uploaded_file($_FILES['pdf']['tmp_name'], 'archivos_alertas/pdfs/'.$pdf);
        $pdf='\''.$pdf.'\'';
    } elseif (isset($_POST['lPdf'])&&$_POST['lPdf']!=0) {
        $pdf='\''.$_POST['lPdf'].'\'';
    } else {
        $pdf='null';
    }

    if (isset($_POST['lMapa'])&&$_POST['lMapa']!=0) {
        $mapa='\''.$_POST['lMapa'].'\'';
    } elseif (isset($_FILES['txtMapa'])) {
        $mapa=date('dmyHis').$_SESSION['id'].'.'.extension($_FILES['txtMapa']['type']);
        copy($_FILES['txtMapa']['tmp_name'], 'archivos_alertas/mapas/'.$mapa);
        $mapa='\''.$mapa.'\'';
    } else {
        $mapa='null';
    }
    
    if (isset($_POST['cmb_estatus'])) {
        $estatus_fito=$_POST['cmb_estatus'][0];
    } else {
        $estatus_fito='null';
	}
	
	if(isset($_POST['txtfolio'])){
		$folio=$_POST['txtfolio'];		
	}
    
    
    $buscarSQL ='select idSeguimiento from tbl_seguimiento where idComunicado = '.$IidComunicado;
    mysql_select_db($database_rari_coneccion, $rari_coneccion);
    $obtenerIdSeg = mysql_query($buscarSQL, $rari_coneccion) or die(mysql_error());
    $id_seguimiento = mysql_fetch_assoc($obtenerIdSeg);

    
    
    
    
    
    if ($IidComunicado==0) {
        $insertSQL ='INSERT INTO tbl_comunicado (idTipoComunicado, idTipoContaminacion, titulo, resumen, imagen, documento, idUsuario, fecha, idNivelRiesgo, idNivelAlerta, idEstatus, autorizacion, idArea, fecha_registro, mapa, idAreaUIS, seguimiento, folio) VALUES ('.$tipo_comunicado.','.$tipo_contaminacion.', \''.$titulo.'\', \''.$contenido.'\', \''.$imagen.'\', '.$pdf.', '.$_SESSION['id'].', \''.$fecha.'\', '.$nivel_riesgo[0].', '.$nivel_alerta[0].', '.$estatus_fito.', 0, '.$area.', curdate(),'.$mapa.','.$id_area.', '.$seguimiento.',\''.$folio.'\')';
        
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        $id_alerta = mysql_insert_id($rari_coneccion);

        
        $insertSQLseg ='INSERT INTO tbl_seguimiento (idComunicado, seguimientoResumen, seguimientoCambios) VALUES ('.$id_alerta.',\'Resumen Original \n'.$contenido.'\n************************************\', \'Alta de seguimiento. '.date().'\n \' )';

        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result2 = mysql_query($insertSQLseg, $rari_coneccion) or die(mysql_error());
    } else {
        $id_alerta =$IidComunicado;
       // var_dump($IidComunicado);
		
       /* $insertSQL ='UPDATE tbl_comunicado SET  idTipoComunicado='.$tipo_comunicado.', idTipoContaminacion='.$tipo_contaminacion.' , imagen=\''.$imagen.'\', documento='.$pdf.', idUsuario='.$_SESSION['id'].', fecha=\''.$fecha.'\', idNivelRiesgo='.$nivel_riesgo[0].', idNivelAlerta='.$nivel_alerta[0].', idEstatus='.$estatus_fito.', mapa='.$mapa.', idAreaUIS='.$id_area.', seguimiento='.$seguimiento.' WHERE id='.$id_alerta;
    
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());	*/
		
		


       /* $updateSQLseg ='UPDATE tbl_seguimiento SET seguimientoResumen=CONCAT(\''.$detalles_seguimiento.'\', \'\n\nNuevo registro \t\', curdate(), \'\n\n\', \''.$nuevos_detalles_seguimiento.'\', \'\n\n************************************\n\') WHERE idSeguimiento= '.$id_seguimiento['idSeguimiento'];
        //$insertSQLseg ='INSERT INTO tbl_seguimiento (idComunicado, seguimientoResumen, seguimientoCambios) VALUES ('.$IidComunicado.',\'Resumen Original \n'.$detalles_seguimiento.'\n************************************\', \'Alta de seguimiento. '.$nuevos_detalles_seguimiento.'\n \' )';
        
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($updateSQLseg, $rari_coneccion) or die(mysql_error());*/
		
				
        
        $catalogos=array('det_comunicado_agente',
                            'det_comunicado_enlace',
                            'det_comunicado_fraccion',
                            'det_comunicado_localizacion',
                            'det_comunicado_medidas_implementadas',
                            'det_comunicado_medidas_implementar',
                            'det_comunicado_motivos',
                            'det_comunicado_oisas',
                            'det_comunicado_productos',
                            'det_comunicado_pvifs',
                            'det_comunicado_pvis',
                            'det_comunicado_reglam_int',
                            'det_comunicado_reglamentacion',
                            'det_comunicado_resolucion',
                            'det_comunicado_riesgo');
        
        for ($i=0; $i<count($catalogos);$i++) {
            $insertSQL ='DELETE FROM '.$catalogos[$i].' WHERE idComunicado='.$IidComunicado;
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		}
		
    }
    

    if (isset($_POST['resultEnlaces'])) {
        $arreglo_enlaces= explode('°', $_POST['resultEnlaces']);
        
        for ($i=0;$i<count($arreglo_enlaces)-1;$i++) {
            $insertSQL ='INSERT INTO det_comunicado_enlace (idComunicado, enlace) VALUES ('.$id_alerta.', \''.$arreglo_enlaces[$i].'\')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }
    
    //echo '<br/><br/><br/><br/><br/><br/>';
    
    $arreglo_areas_ads=$_POST['cmb_area_adscripcion'];
    
    for ($i=0;$i<count($arreglo_areas_ads);$i++) {
        echo 'Insertando ('.$id_alerta.','.$arreglo_areas_ads[$i].')';
        $insertSQL ='INSERT INTO det_comunicado_area_adscripcion (idComunicado, idAreaAdscripcion) VALUES ('.$id_alerta.', '.$arreglo_areas_ads[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    array_push($arreglo_areas_ads, 7);

    //Inserción de agentes   OK
    $arreglo_agentes=$_POST['cmb_agentes'];
    for ($i=0;$i<count($arreglo_agentes);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_agente (idComunicado, idAgente) VALUES ('.$id_alerta.', '.$arreglo_agentes[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }
    
    //Inserción de productos u hospederos   OK
    $arreglo_productos=$_POST['cmb_productos'];
    for ($i=0;$i<count($arreglo_productos);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_productos (idComunicado, idProducto) VALUES ('.$id_alerta.', '.$arreglo_productos[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Inserción de oisas  OK
    if (isset($_POST['cmb_oisas'])) {
        $arreglo_oisas=$_POST['cmb_oisas'];
        ;
        for ($i=0;$i<count($arreglo_oisas);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_oisas (idComunicado, idOisa) VALUES ('.$id_alerta.', '.$arreglo_oisas[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }
    
    //Inserción de PVIS   OK
    if (isset($_POST['cmb_pvis'])) {
        $arreglo_pvis=$_POST['cmb_pvis'];
        for ($i=0;$i<count($arreglo_pvis);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_pvis (idComunicado, idPvi) VALUES ('.$id_alerta.', '.$arreglo_pvis[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Inserción de PVIFS   OK
    if (isset($_POST['cmb_pvifs'])) {
        $arreglo_pvifs=$_POST['cmb_pvifs'];
        for ($i=0;$i<count($arreglo_pvifs);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_pvifs (idComunicado, idPvif) VALUES ('.$id_alerta.', '.$arreglo_pvifs[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Inserción de fracciones
    if (isset($_POST['cmb_fraccion'])) {
        $arreglo_fraccion=$_POST['cmb_fraccion'];
        for ($i=0;$i<count($arreglo_fraccion);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_fraccion (idComunicado, idFraccion) VALUES ('.$id_alerta.', '.$arreglo_fraccion[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de medidas implementadas
    $arreglo_med_implementadas=$_POST['cmb_med_implementadas'];
    for ($i=0;$i<count($arreglo_med_implementadas);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_medidas_implementadas (idComunicado, idMedidaImplementada) VALUES ('.$id_alerta.', '.$arreglo_med_implementadas[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de medidas a implementar
    $arreglo_med_implementar=$_POST['cmb_med_aimplementar'];
    for ($i=0;$i<count($arreglo_med_implementar);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_medidas_implementar (idComunicado, idMedidaImplementada) VALUES ('.$id_alerta.', '.$arreglo_med_implementar[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }
    
    //Insercion de motivos
    if (isset($_POST['cmb_motivos'])) {
        $arreglo_motivos=$_POST['cmb_motivos'];
        for ($i=0;$i<count($arreglo_motivos);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_motivos (idComunicado, idMotivo) VALUES ('.$id_alerta.', '.$arreglo_motivos[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de riesgos
    $arreglo_riesgos=$_POST['cmb_riesgo'];
    for ($i=0;$i<count($arreglo_riesgos);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_riesgo (idComunicado, idRiesgo) VALUES ('.$id_alerta.', '.$arreglo_riesgos[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de reglamentaciones
    $arreglo_reglamentacion=$_POST['cmb_reglamentacion'];
    for ($i=0;$i<count($arreglo_reglamentacion);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_reglamentacion (idComunicado, idReglamentacion) VALUES ('.$id_alerta.', '.$arreglo_reglamentacion[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercione de reglamentos internacionales
    if (isset($_POST['cmb_reglamentacion_int'])) {
        $arreglo_reg_int=$_POST['cmb_reglamentacion_int'];
        for ($i=0;$i<count($arreglo_reg_int);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_reglam_int (idComunicado, idReglaInt) VALUES ('.$id_alerta.', '.$arreglo_reg_int[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de resoluciones
    $arreglo_resolucion=$_POST['cmb_resolucion'];
    for ($i=0;$i<count($arreglo_resolucion);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_resolucion (idComunicado, idResolucion) VALUES ('.$id_alerta.', '.$arreglo_resolucion[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de localizaciones
    $arreglo_localizaciones= explode('°', $_POST['resultLocs']);
    for ($i=0;$i<count($arreglo_localizaciones)-1;$i++) {
        $localizacion=explode('|', $arreglo_localizaciones[$i]);
        $pais=$localizacion[0];
        $edo=count($localizacion)==6?$localizacion[1]:'null';
        $mpo=count($localizacion)==6?$localizacion[2]:'null';
        $otraLoc=count($localizacion)==6?$localizacion[3]:$localizacion[1];
        $Lat=count($localizacion)==6?$localizacion[4]:$localizacion[2];
        $Lon=count($localizacion)==6?$localizacion[5]:$localizacion[3];
        $insertSQL ='INSERT INTO det_comunicado_localizacion (idComunicado, idPais, idEstado, idMunicipio, region, latitud, longitud) VALUES ('.$id_alerta.', '.$pais.', '.$edo.', '.$mpo.', \''.$otraLoc.'\', '.$Lat.', '.$Lon.')';

        mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		
    }

	if($Result1)
	{
		$actualizado="ok";
	}
		

//SEGUIMIENTO

if ($actualizado=="ok") {
    $titulo=$_POST['txtTituloComunicado'];
   // $fechaf = date("h:i:s");
    $texto=substr($titulo, 0 , 4);
    $folio='Seg-'.$texto;
    $hora=date("h:i:s");

   
    $insertSQL ='INSERT INTO tbl_comunicado (idTipoComunicado, idTipoContaminacion, titulo, resumen, imagen, documento, idUsuario, fecha, idNivelRiesgo, idNivelAlerta, idEstatus, autorizacion, idArea, fecha_registro,hora, mapa, idAreaUIS, seguimiento, folio, desc_comunicado ) VALUES ('.$tipo_comunicado.','.$tipo_contaminacion.', \''.$titulo.'\', \''.$contenido.'\', \''.$imagen.'\', '.$pdf.', '.$_SESSION['id'].', \''.$fecha.'\', '.$nivel_riesgo[0].', '.$nivel_alerta[0].', '.$estatus_fito.', 0, '.$area.', curdate(),\''.$hora.'\','.$mapa.','.$id_area.', '.$seguimiento.',\''.$folio.'\',\''.$nuevos_detalles_seguimiento.'\')';
        
    mysql_select_db($database_rari_coneccion, $rari_coneccion);
    $Result1= mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    $id_alerta = mysql_insert_id($rari_coneccion);

    //Inserción de productos u hospederos   OK
    $arreglo_productos=$_POST['cmb_productos'];
    for ($i=0;$i<count($arreglo_productos);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_productos (idComunicado, idProducto) VALUES ('.$id_alerta.', '.$arreglo_productos[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //enlaces Url
    if (isset($_POST['resultEnlaces'])) {
        $arreglo_enlaces= explode('°', $_POST['resultEnlaces']);
        
        for ($i=0;$i<count($arreglo_enlaces)-1;$i++) {
            $insertSQL ='INSERT INTO det_comunicado_enlace (idComunicado, enlace) VALUES ('.$id_alerta.', \''.$arreglo_enlaces[$i].'\')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }


    //Inserción de agentes   OK
    $arreglo_agentes=$_POST['cmb_agentes'];
    for ($i=0;$i<count($arreglo_agentes);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_agente (idComunicado, idAgente) VALUES ('.$id_alerta.', '.$arreglo_agentes[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

        

    //Inserción de oisas  OK
    if (isset($_POST['cmb_oisas'])) {
        $arreglo_oisas=$_POST['cmb_oisas'];
        ;
        for ($i=0;$i<count($arreglo_oisas);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_oisas (idComunicado, idOisa) VALUES ('.$id_alerta.', '.$arreglo_oisas[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
	}
	
	

    //Inserción de PVIS   OK
    if (isset($_POST['cmb_pvis'])) {
        $arreglo_pvis=$_POST['cmb_pvis'];
        for ($i=0;$i<count($arreglo_pvis);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_pvis (idComunicado, idPvi) VALUES ('.$id_alerta.', '.$arreglo_pvis[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Inserción de PVIFS   OK
    if (isset($_POST['cmb_pvifs'])) {
        $arreglo_pvifs=$_POST['cmb_pvifs'];
        for ($i=0;$i<count($arreglo_pvifs);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_pvifs (idComunicado, idPvif) VALUES ('.$id_alerta.', '.$arreglo_pvifs[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Inserción de fracciones
    if (isset($_POST['cmb_fraccion'])) {
        $arreglo_fraccion=$_POST['cmb_fraccion'];
        for ($i=0;$i<count($arreglo_fraccion);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_fraccion (idComunicado, idFraccion) VALUES ('.$id_alerta.', '.$arreglo_fraccion[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de medidas implementadas
    $arreglo_med_implementadas=$_POST['cmb_med_implementadas'];
    for ($i=0;$i<count($arreglo_med_implementadas);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_medidas_implementadas (idComunicado, idMedidaImplementada) VALUES ('.$id_alerta.', '.$arreglo_med_implementadas[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de medidas a implementar
    $arreglo_med_implementar=$_POST['cmb_med_aimplementar'];
    for ($i=0;$i<count($arreglo_med_implementar);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_medidas_implementar (idComunicado, idMedidaImplementada) VALUES ('.$id_alerta.', '.$arreglo_med_implementar[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de motivos
    if (isset($_POST['cmb_motivos'])) {
        $arreglo_motivos=$_POST['cmb_motivos'];
        for ($i=0;$i<count($arreglo_motivos);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_motivos (idComunicado, idMotivo) VALUES ('.$id_alerta.', '.$arreglo_motivos[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de riesgos
    $arreglo_riesgos=$_POST['cmb_riesgo'];
    for ($i=0;$i<count($arreglo_riesgos);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_riesgo (idComunicado, idRiesgo) VALUES ('.$id_alerta.', '.$arreglo_riesgos[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de reglamentaciones
    $arreglo_reglamentacion=$_POST['cmb_reglamentacion'];
    for ($i=0;$i<count($arreglo_reglamentacion);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_reglamentacion (idComunicado, idReglamentacion) VALUES ('.$id_alerta.', '.$arreglo_reglamentacion[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercione de reglamentos internacionales
    if (isset($_POST['cmb_reglamentacion_int'])) {
        $arreglo_reg_int=$_POST['cmb_reglamentacion_int'];
        for ($i=0;$i<count($arreglo_reg_int);$i++) {
            $insertSQL ='INSERT INTO det_comunicado_reglam_int (idComunicado, idReglaInt) VALUES ('.$id_alerta.', '.$arreglo_reg_int[$i].')';
            mysql_select_db($database_rari_coneccion, $rari_coneccion);
            $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
        }
    }

    //Insercion de resoluciones
    $arreglo_resolucion=$_POST['cmb_resolucion'];
    for ($i=0;$i<count($arreglo_resolucion);$i++) {
        $insertSQL ='INSERT INTO det_comunicado_resolucion (idComunicado, idResolucion) VALUES ('.$id_alerta.', '.$arreglo_resolucion[$i].')';
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //Insercion de localizaciones
    $arreglo_localizaciones= explode('°', $_POST['resultLocs']);
    for ($i=0;$i<count($arreglo_localizaciones)-1;$i++) {
        $localizacion=explode('|', $arreglo_localizaciones[$i]);
        $pais=$localizacion[0];
        $edo=count($localizacion)==6?$localizacion[1]:'null';
        $mpo=count($localizacion)==6?$localizacion[2]:'null';
        $otraLoc=count($localizacion)==6?$localizacion[3]:$localizacion[1];
        $Lat=count($localizacion)==6?$localizacion[4]:$localizacion[2];
        $Lon=count($localizacion)==6?$localizacion[5]:$localizacion[3];
        $insertSQL ='INSERT INTO det_comunicado_localizacion (idComunicado, idPais, idEstado, idMunicipio, region, latitud, longitud) VALUES ('.$id_alerta.', '.$pais.', '.$edo.', '.$mpo.', \''.$otraLoc.'\', '.$Lat.', '.$Lon.')';

        mysql_select_db($database_rari_coneccion, $rari_coneccion);
        $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
    }

    //tabla seguimiento
    
    $IidComunicado+=1;
    $insertSQLseg ='INSERT INTO tbl_seguimiento (idComunicado, seguimientoResumen, seguimientoCambios) VALUES ('.$IidComunicado.',\'Resumen Original \n'.$detalles_seguimiento.'\n*****************\', \'Alta de seguimiento. '.$nuevos_detalles_seguimiento.'\n \' )';
        
        mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQLseg, $rari_coneccion) or die(mysql_error());
}

//SEGUIMIENTO
	
	

/*	
	//enviando correo a interesado.

	//$arreglo_destinatarios = $_POST['cmb_area_adscripcion'];
	$arreglo_destinatarios = $arreglo_areas_ads;

	for($i=0;$i<=count($arreglo_destinatarios)-1;$i++){
		$destinatarios[$i]=$arreglo_destinatarios[$i];
	}

	$objClienteSOAP = new soapclient('http://localhost:122/Service.asmx?WSDL');
	$params = array('AreasAdscripcion'=> $destinatarios, 'idAlerta' =>$id_alerta);
	//$objClienteSOAP->__soapCall("envioCorreoDirecciones", $params);
	$objClienteSOAP->envioCorreoDirecciones($params);

	
	//$GoTo = '/bienvenido.php';
			
	//header('Location :' .$GoTo);
	*/
	header('Location: bienvenido.php');

	exit();

 ?>