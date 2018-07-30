<?php 	
	function consultarLocs($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{	
		$latitudes=array();
		$longitudes=array();
		$localizaciones=array();	
	
		$det_bitacoraSQL='select 
			tbl_paises.nombre, 
			det_comunicado_localizacion.region, 
			det_comunicado_localizacion.latitud, 
			det_comunicado_localizacion.longitud,
			(select nombre from tbl_estados 
			where tbl_estados.id=det_comunicado_localizacion.idEstado) as Edo,
			(select nombre from tbl_municipios 
			where tbl_municipios.id=det_comunicado_localizacion.idMunicipio) as Mpo
			from det_comunicado_localizacion inner join tbl_paises
			ON det_comunicado_localizacion.idPais=tbl_paises.id
			where det_comunicado_localizacion.idComunicado='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		//$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		$i=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$latitudes[$i]=$row_det_bitacora['latitud'];
			$longitudes[$i]=$row_det_bitacora['longitud'];
			$loc=$row_det_bitacora['region'];
		
			if($row_det_bitacora['Mpo']!=null)
				$loc=$loc.", ".$row_det_bitacora['Mpo'];
		
			if($row_det_bitacora['Edo']!=null)
				$loc=$loc.", ".$row_det_bitacora['Edo'];
		
			$loc=$loc.", ".$row_det_bitacora['nombre'];
				
			$localizaciones[$i]=$loc;
		
			$i++;
		}
		return array($latitudes,$longitudes,$localizaciones);
		//return $data;
	}

	function consultarDetalle($idAlerta, $Tabla, $database_rari_coneccion, $rari_coneccion)
	{
		$nombres_tablas=obtenerNombreDetTabla($Tabla);	  
		if($Tabla!=3)
			$det_bitacoraSQL ='select idComunicado,  nombre from '.$nombres_tablas[0].' 
				inner join '.$nombres_tablas[1].' on '.$nombres_tablas[1].'.id='.$nombres_tablas[0].'.'.$nombres_tablas[2].'
				where '.$nombres_tablas[0].'.idComunicado='.$idAlerta;
		else
			$det_bitacoraSQL='select 
				tbl_paises.nombre, 
				det_comunicado_localizacion.region, 
				det_comunicado_localizacion.latitud, 
				det_comunicado_localizacion.longitud,
				(select nombre from tbl_estados 
				where tbl_estados.id=det_comunicado_localizacion.idEstado) as Edo,
				(select nombre from tbl_municipios 
				where tbl_municipios.id=det_comunicado_localizacion.idMunicipio) as Mpo
				from det_comunicado_localizacion inner join tbl_paises
				ON det_comunicado_localizacion.idPais=tbl_paises.id
				where det_comunicado_localizacion.idComunicado='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
		$cadena='';
		$cadena1='';
		do
		{
			if($cadena!='')
				$cadena=$cadena.', ';
		
			if($Tabla!=3)
				$cadena=$cadena.$row_det_bitacora['nombre'];
			else
			{
				$cadena=$cadena.$row_det_bitacora['nombre'].' '.$row_det_bitacora['Edo'].' '.$row_det_bitacora['Mpo'].' '.$row_det_bitacora['region'];
				if($cadena1!="")
					$cadena1=$cadena1.', ';
				$cadena1=$cadena1.'('.$row_det_bitacora['latitud'].','.$row_det_bitacora['longitud'].')';
			}		
		}
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora));
		
		if($cadena=='')
			$cadena='Ninguno';
		
		if($Tabla==3)
  		{
			$cadena=array($cadena,$cadena1);
		}
		
		return $cadena;	
	}	  
	  
	function obtenerNombreCampo($Id, $Tabla, $database_rari_coneccion, $rari_coneccion)
	{		
		if($Id==null)
			return 'NA';
		
		$det_bitacoraSQL='select nombre from '.$Tabla.' where id='.$Id;

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
		return $row_det_bitacora['nombre'];	
	}
	
	function obtenerDetalleLoc($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$tablaArray=obtenerNombreDetTabla(3);
		$det_bitacoraSQL='select * from  '.$tablaArray[0].' where idComunicado='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
		if($totalRows_det_bitacora<1)
			return null;	
	
		$arreglo=array();
	
		for($i=0; $i<$totalRows_det_bitacora; $i++)
		{
			$cad="";
			$cad=$row_det_bitacora['idPais'];
			if($row_det_bitacora['idEstado']!=null)
				$cad=$cad."|".$row_det_bitacora['idEstado'];
			if($row_det_bitacora['idMunicipio']!=null)
				$cad=$cad."|".$row_det_bitacora['idMunicipio'];
			$cad=$cad."|".$row_det_bitacora['region'];
			$cad=$cad."|".$row_det_bitacora['latitud'];
			$cad=$cad."|".$row_det_bitacora['longitud'];
			$arreglo[$i]=$cad;
			$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		}
		
		return $arreglo;	
	}	
	
	function obtenerDetalleEnlaces($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$arreglo=array();
		$tablaArray=obtenerNombreDetTabla(3);
		$det_bitacoraSQL='select *from det_comunicado_enlace where idComunicado='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		while ($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			array_push($arreglo,$row_det_bitacora['enlace']);
		}
		/*$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		
		if($totalRows_det_bitacora<1)
			return null;
		
		$arreglo=array();
	
		for($i=0; $i<$totalRows_det_bitacora; $i++)
		{		
			$arreglo[$i]=$row_det_bitacora['enlace'];
		}
		*/
		return $arreglo;	
	}
	
	function obtenerDetallePdf($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$tablaArray=obtenerNombreDetTabla(15);
		$det_bitacoraSQL='select * from tbl_comunicado where id='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		
		if($totalRows_det_bitacora<1)
			return null;
		
		$arreglo=array();
	
		for($i=0; $i<$totalRows_det_bitacora; $i++)
		{
			$arreglo[$i]=$row_det_bitacora['documento'];
		}
	
		return $arreglo;	
	}
	
	function obtenerDetalleMapa($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$tablaArray=obtenerNombreDetTabla(15);
		$det_bitacoraSQL='select * from tbl_comunicado where id='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		
		if($totalRows_det_bitacora<1)
			return null;
		
		$arreglo=array();
	
		for($i=0; $i<$totalRows_det_bitacora; $i++)
		{
			$arreglo[$i]=$row_det_bitacora['mapa'];
		}
	
		return $arreglo;	
	}
		
	function obtenerDetalles($idAlerta, $numTabla, $database_rari_coneccion, $rari_coneccion)	
	{
		$arreglo=array();
		$tablaArray=obtenerNombreDetTabla($numTabla);
		$det_bitacoraSQL='select '.$tablaArray[2].' as idCat from '.$tablaArray[0].' where idComunicado='.$idAlerta;

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		while ($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			array_push($arreglo,$row_det_bitacora['idCat']);
			//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
			//if($totalRows_det_bitacora<1)
			//return null;
			/*for($i=0; $i<$totalRows_det_bitacora; $i++)
			{
				$arreglo[$i]=$row_det_bitacora['idCat'];
			}*/
		}
		return $arreglo;	
	}
	  
	//Se modificará la función, para que considere las áreas de adscripcion. LVC. 9-Junio-2017
	function obtenerNombreDetTabla($num)
	{
		switch($num)
		{
			case 1:
			return array('det_comunicado_agente','cat_agentes', 'idAgente');
			case 2:
			return array('det_comunicado_fraccion','cat_fraccion', 'idFraccion');
			case 3:
			return array('det_comunicado_localizacion','');
			case 4:
			return array('det_comunicado_medidas_implementadas','cat_med_implementadas', 'idMedidaImplementada');
			case 5:
			return array('det_comunicado_medidas_implementar','cat_med_aimplementar', 'idMedidaImplementada');
			case 6:
			return array('det_comunicado_motivos','cat_motivos', 'idMotivo');
			case 7:
			return array('det_comunicado_oisas','cat_oisas', 'idOisa');
			case 8:
			return array('det_comunicado_productos','cat_productos', 'idProducto');
			case 9:
			return array('det_comunicado_pvifs','cat_pvifs', 'idPvif');
			case 10:
			return array('det_comunicado_pvis','cat_pvis', 'idPvi');
			case 11:
			return array('det_comunicado_reglam_int','cat_reglamentacion_int', 'idReglaInt');
			case 12:
			return array('det_comunicado_reglamentacion','cat_reglamentacion', 'idReglamentacion');
			case 13:
			return array('det_comunicado_resolucion','cat_resolucion', 'idResolucion');
			case 14:
			return array('det_comunicado_riesgo','cat_riesgo', 'idRiesgo');
			case 15:
			return array('tbl_comunicado','');
			case 16:
			return array('det_comunicado_area_adscripcion', 'cat_area_adscripcion', 'idAreaAdscripcion');
		}
	}
	
	// Se crea nueva función, basada en la lógica actual, para obtener el seguimiento establecido en el comunicado. LVC 5-Octubre-2017
	function obtenerDetalleSeg($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$seg_comunicadoSQL='select seguimiento from tbl_comunicado where id='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$seg_comunicado = mysql_query($seg_comunicadoSQL, $rari_coneccion) or die(mysql_error());
		$row_seg_comunicado = mysql_fetch_assoc($seg_comunicado);
	
		return $regresa=$row_seg_comunicado['seguimiento'];
	}
	// Termina función nueva.

	// Se crea nueva función, basada en la lógica actual, para obtener el seguimiento establecido en el comunicado. LVC 5-Octubre-2017
	function obtenerDetalleSegN($idAlerta, $database_rari_coneccion, $rari_coneccion)
	{
		$seg_comunicadoSQLN='select desc_comunicado from tbl_comunicado where id='.$idAlerta;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$seg_comunicado = mysql_query($seg_comunicadoSQLN, $rari_coneccion) or die(mysql_error());
		$row_seg_comunicado = mysql_fetch_assoc($seg_comunicado);
	
		return $regresa=$row_seg_comunicado['seguimiento'];
	}
	// Termina función nueva.
?>