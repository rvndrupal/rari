<?php 
	require_once('Connections/rari_coneccion.php');
	
	// Se agrega código para considerar elementos habilitados/deshabilitados. LVC 14-Mayo-2018
	$estatusHab = isset($_GET['estReg']) ? $_GET['estReg'] : null;
	// Termina código nuevo.

	if(isset($_GET['nombre'])&&isset($_GET['cat']))
	{
		if(isset($_GET['id']))
		{
			// Se modifica código para considerar elementos habilitados/deshabilitados. LVC 14-Mayo-2018
			if ($estatusHab != null && $estatusHab !='undefined')
			{
				if ($estatusHab == '1')
				{
					$insertSQL ='UPDATE cat_'.obtenerNombreTabla($_GET['cat']).' set nombre=\''.$_GET['nombre'].'\', idEstatus = 1 where id='.$_GET['id'];
				}
				else
				{
					$insertSQL ='UPDATE cat_'.obtenerNombreTabla($_GET['cat']).' set nombre=\''.$_GET['nombre'].'\', idEstatus = 0 where id='.$_GET['id'];
				}
			}
			else
				$insertSQL ='UPDATE cat_'.obtenerNombreTabla($_GET['cat']).' set nombre=\''.$_GET['nombre'].'\' where id='.$_GET['id'];				
			// Termina código nuevo.
		}
		else
		{	
			$array=explode("$", $_GET['nombre']);
			if($_GET['cat']<=14)
			{	
				$insertSQL ="INSERT INTO cat_".obtenerNombreTabla($_GET['cat'])." (nombre, idArea) VALUES ";
				for($i=0; $i<count($array); $i++)
				{
					if($array[$i]!=null&&trim($array[$i])!="")
					{
						if($i>0)
							$insertSQL=$insertSQL.",";
						$insertSQL=$insertSQL."('".trim($array[$i])."',".$_GET['area'].")";
					}
				}
				//array_search()
			}
			else
			{
				$insertSQL ="INSERT INTO cat_".obtenerNombreTabla($_GET['cat'])." (nombre) VALUES ";
				for($i=0; $i<count($array); $i++)
				{
					if($array[$i]!=null&&trim($array[$i])!="")
					{
						if($i>0)
							$insertSQL=$insertSQL.",";
						$insertSQL=$insertSQL."('".trim($array[$i])."')";
					}
				}	
			}
		}

		//echo $insertSQL;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
		echo obtenerCatalogoSelect($_GET['cat'],$database_rari_coneccion, $rari_coneccion,$_GET['area']);
	}

	if(isset($_GET['edo']))
	{
		echo obtenerCatalogoSelectS(21,$database_rari_coneccion,$rari_coneccion,$_GET['edo']);
	}
	//echo 'salio';
	//echo 'Nombre: '.$_GET['nombre'].' <br/>Catálogo: '.obtenerNombreTabla($_GET['cat']); 

	function obtenerNombre($Id, $Tabla, $database_rari_coneccion, $rari_coneccion)
	{
		if($Id==null)
			return "NA";
		
		$det_bitacoraSQL="select nombre from ".$Tabla." where id=".$Id;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
		return $row_det_bitacora['nombre'];
	}  

	function obtenerLocalizacionesPorComunicado($database_rari_coneccion,$rari_coneccion,$idComunicado)
	{
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogos = "select *from det_comunicado_localizacion where idComunicado=".$idComunicado;
		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		
		$data=array();
		$dataNombres=array();
		$i=0;
		while($row_catalogos = mysql_fetch_assoc($catalogos))
		{
			$arreglo=array(6);
			$arreglo2=array(6);
			$arreglo[0]=$row_catalogos['idPais'];
			$arreglo[1]=$row_catalogos['idEstado'];
			$arreglo[2]=$row_catalogos['idMunicipio'];
			$arreglo[3]=$row_catalogos['region'];
			$arreglo[4]=$row_catalogos['latitud'];
			$arreglo[5]=$row_catalogos['longitud'];
			$data[$i]=$arreglo;
			
			$arreglo2[0]=obtenerNombre($row_catalogos['idPais'], "tbl_paises", $database_rari_coneccion, $rari_coneccion);
			$arreglo2[1]=$row_catalogos['idEstado']!=null?obtenerNombre($row_catalogos['idEstado'], "tbl_estados", $database_rari_coneccion, $rari_coneccion):null;
			$arreglo2[2]=$row_catalogos['idMunicipio']!=null?obtenerNombre($row_catalogos['idMunicipio'], "tbl_municipios", $database_rari_coneccion, $rari_coneccion):null;
			$arreglo2[3]=$row_catalogos['region'];
			$arreglo2[4]=$row_catalogos['latitud'];
			$arreglo2[5]=$row_catalogos['longitud'];
			$dataNombres[$i]=$arreglo2;
			$i++;
		}
		$totalRows_catalogos= mysql_num_rows($catalogos);
		if($totalRows_catalogos>0)
			return array($data,$dataNombres);
		return null;
	}
	
	// Se modifica función, para mostrar los datos habilitado o deshabilitados en el catálogo. LVC 14-Mayo-2018
	function obtenerCatalogoSelect($cat,$database_rari_coneccion,$rari_coneccion,$area,$idComuicado=0)
	{
		$selecciones=null;
		if($idComuicado>0)
		{
			$selecciones=obtenerIdesSeleccionados($idComuicado, $cat,$database_rari_coneccion,$rari_coneccion);		
		}
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogos = 'SELECT * FROM cat_'.obtenerNombreTabla($cat).(($cat<=14)?(' WHERE idArea='.$area):(''));
		$query_catalogos.= ' order by nombre';
		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$row_catalogos = mysql_fetch_assoc($catalogos);
		$totalRows_catalogos= mysql_num_rows($catalogos);
		
		$salida='<select id="cmb_'.obtenerNombreTabla($cat).'" name="cmb_'.obtenerNombreTabla($cat).'[]" style="width:98%;" multiple="multiple">';
	
		do 
		{
			$select='';
			if($selecciones!=null)
			{
				if(in_array($row_catalogos['id'],$selecciones))
					$select=' selected=\'selected\'';
			}
		
			if($totalRows_catalogos>0)
				if ($row_catalogos['idEstatus'] === '1')
					$salida=$salida.'<option'. $select.' value='.$row_catalogos['id'].'>'.$row_catalogos['nombre'].'</option>';
				else
					$salida=$salida.'<option'. $select.' value='.$row_catalogos['id'].' style="color:#eee9e9">'.$row_catalogos['nombre'].'</option>';
		} 
		while ($row_catalogos = mysql_fetch_assoc($catalogos));
		$salida=$salida.'</select>';
		return $salida;
	}
	
	// Se crea una nueva función, para mostrar datos filtrados en el formulario (captura). LVC 14-Mayo-2018
	function obtenerCatalogoSelectF($cat,$database_rari_coneccion,$rari_coneccion,$area,$idComuicado=0, $palabraClave="")
	{
		$selecciones=null;
		if($idComuicado>0)
		{
			$selecciones=obtenerIdesSeleccionados($idComuicado, $cat,$database_rari_coneccion,$rari_coneccion);			
		}
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogos = 'SELECT * FROM cat_'.obtenerNombreTabla($cat).(($cat<=14)?(' WHERE idArea='.$area.' AND idEstatus = 1'):(' WHERE idEstatus = 1'));
		
		if($palabraClave != "")
			$query_catalogos .= ' AND (nombre like \''.$palabraClave.'%\')';
		
		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$row_catalogos = mysql_fetch_assoc($catalogos);
		$totalRows_catalogos= mysql_num_rows($catalogos);
		
	   
		
		$salida='<select id="cmb_'.obtenerNombreTabla($cat).'" name="cmb_'.obtenerNombreTabla($cat).'[]" style="width:98%;" multiple="multiple">';
		
		//var_dump($row_catalogos);

		

		do 
		{
			$select="";
			if($selecciones!=null)
			{
				if(in_array($row_catalogos['id'],$selecciones))
					$select=" selected='selected'";
			}

			//extra seleccionar curso
			if ($row_catalogos['nombre']=="En curso") {
				$select=" selected='selected'";				
			}	
			
			 if($totalRows_catalogos>0)
				$salida=$salida.'<option'. $select.' value='.$row_catalogos['id'].'>'.$row_catalogos['nombre'].'</option>';	


				
						
		} 
		while ($row_catalogos = mysql_fetch_assoc($catalogos));

		
		$salida=$salida.'</select>';
		return $salida;
	}
		
	function obtenerDataComunicado($database_rari_coneccion, $rari_coneccion,$id)
	{
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
	
		$query_catalogos = "SELECT * FROM tbl_comunicado where id=".$id;
		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$totalRows_catalogos= mysql_num_rows($catalogos);
		if($totalRows_catalogos<1)
			return null;
		return mysql_fetch_assoc($catalogos);
	}
	
	function obtenerCatalogoSelectS($cat,$database_rari_coneccion,$rari_coneccion,$area,$idComuicado=0)
	{
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		if($cat>=19)
			$query_catalogos = "SELECT *FROM tbl_".obtenerNombreTabla($cat).(($cat==21)?(" WHERE idEstado=".$area):(""));
		else
			$query_catalogos = "SELECT *FROM cat_".obtenerNombreTabla($cat).(($cat<=14)?(" WHERE idArea=".$area):(""));

		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$row_catalogos = mysql_fetch_assoc($catalogos);
		$totalRows_catalogos= mysql_num_rows($catalogos);
	
		$salida='<select id="cmb_'.obtenerNombreTabla($cat).'" name="cmb_'.obtenerNombreTabla($cat).'[]">';
	
		do 
		{
			if($totalRows_catalogos>0)
				$salida=$salida.'<option'.(($cat==19&&$row_catalogos['id']=="132"||$idComuicado==$row_catalogos['id'])?" selected='selected'":"").' value='.$row_catalogos['id'].'>'.(($cat>=19&&$cat<=22||$cat==17)?$row_catalogos['nombre']:$row_catalogos['nombre']).'</option>';
		} 
		while ($row_catalogos = mysql_fetch_assoc($catalogos));
		$salida=$salida.'</select>';
		return $salida;
	}

	function obtenerEnlaces($Id, $database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL="select *from det_comunicado_enlace where idComunicado=".$Id;

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		
		$data=array();
		$i=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$data[$i]=$row_det_bitacora["enlace"];
			$i++;
		}
		
		return $data;		
	} 

	//Se modificará la función, para que considere las áreas de adscripcion. LVC. 30-Mayo-2017
	function obtenerNombreTabla($cat)
	{
		switch($cat)
		{
			case 1:
				return "productos";
				break;
			case 2:
				return "oisas";
				break;
			case 3:
				return "agentes";
				break;
			case 4:
				return "pvis";
				break;
			case 5:
				return "pvifs";
				break;
			case 6:
				return "fraccion";
				break;
			case 7:
				return "med_implementadas";
				break;
			case 8:
				return "med_aimplementar";
				break;
			case 9:
				return "motivos";
				break;
			case 10:
				return "riesgo";
				break;
			case 11:
				return "reglamentacion";
				break;
			case 12:
				return "reglamentacion_int";
				break;
			case 13:
				return "resolucion";
				break;
			case 14:
				return "estatus";
				break;
			case 15:
				return "nivel_riesgo";
				break;
			case 16:
				return "nivel_alerta";
				break;
			case 17:
				return "comunicados";
				break;
			case 18:
				return "contaminacion";
				break;
			case 19:
				return "paises";
				break;
			case 20:
				return "estados";
				break;
			case 21:
				return "municipios";
				break;
			case 22:
				return "areas";
				break;
			case 23:
				return "area_adscripcion";
				break;
		}
	}
		
	function obtenerIdesSeleccionados($idAlerta, $catalogo,$database_rari_coneccion,$rari_coneccion)
	{
		$tablas=obtenerNombreDetTabla($catalogo);
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogo = "select ".$tablas[1].".id from ".$tablas[0]." inner join ".$tablas[1]." on ".$tablas[0].".".$tablas[2]."=".$tablas[1].".id
			where ".$tablas[0].".idComunicado=".$idAlerta;
		//echo $query_catalogo;
		$catalogo = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
		//$totalRows_catalogo= mysql_num_rows($catalogo);
	 
		$array=array();
	 
		$i=0;
		while($row_catalogo = mysql_fetch_assoc($catalogo))
		{
			//echo $row_catalogo["id"]."<br/>";
			$array[$i]=$row_catalogo["id"];
			$i++;
		}

		if($i>0)
			return $array;
		else return null;
	}
	
	//Se modificará la función, para que considere las áreas de adscripcion. LVC. 9-Junio-2017
	function obtenerNombreDetTabla($num)
	{
		switch($num)
		{
			case 1:
				return array("det_comunicado_productos","cat_productos", "idProducto");
			case 2:
				return array("det_comunicado_oisas","cat_oisas", "idOisa");
			case 3:
				return array("det_comunicado_agente","cat_agentes", "idAgente");
			case 4:
				return array("det_comunicado_pvis","cat_pvis", "idPvi");
			case 5:
				return array("det_comunicado_pvifs","cat_pvifs", "idPvif");
			case 6:
				return array("det_comunicado_fraccion","cat_fraccion", "idFraccion");
			case 7:
				return array("det_comunicado_medidas_implementadas","cat_med_implementadas", "idMedidaImplementada");
			case 8:
				return array("det_comunicado_medidas_implementar","cat_med_aimplementar", "idMedidaImplementada");
			case 9:
				return array("det_comunicado_motivos","cat_motivos", "idMotivo");
			case 10:
				return array("det_comunicado_riesgo","cat_riesgo", "idRiesgo");
			case 11:
				return array("det_comunicado_reglamentacion","cat_reglamentacion", "idReglamentacion");
			case 12:
				return array("det_comunicado_reglam_int","cat_reglamentacion_int", "idReglaInt");
			case 13:
				return array("det_comunicado_resolucion","cat_resolucion", "idResolucion");
			/*case 3:
				return array("det_comunicado_localizacion","");*/
			case 23:
				return array("det_comunicado_area_adscripcion", "cat_area_adscripcion", "idAreaAdscripcion");
		}
	}

	
	
	//Función para obtener los datos de la tabla de seguimientos.
	//LVC 18-Octubre-2017
	function obtenerDataSeguimiento($database_rari_coneccion, $rari_coneccion, $id)
	{
		mysql_select_db($database_rari_coneccion, $rari_coneccion);	
		
		$query_catalogo = "SELECT * FROM tbl_seguimiento where idComunicado=".$id;
		//$query_catalogo = "SELECT * FROM tbl_seguimiento";
		$catalogo = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
		$totalRows_catalogo= mysql_num_rows($catalogo);
			
		if($totalRows_catalogo<1)
			return null;
			
		return mysql_fetch_assoc($catalogo);
	}

	function obtenerFolio($database_rari_coneccion, $rari_coneccion,$id){
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);	
		
		$query_catalogo = "SELECT folio FROM tbl_comunicado where id=".$id;
		$folioR = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
		return mysql_fetch_assoc($folioR);
	}

	function obtenerDesc($database_rari_coneccion, $rari_coneccion,$foll){
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);	
		
		//$query_com = "SELECT desc_comunicado FROM tbl_comunicado WHERE folio = '".$foll."' ORDER by desc_comunicado desc";
		$query_com = "SELECT desc_comunicado FROM tbl_comunicado WHERE folio = '".$foll."' ";
		$desF = mysql_query($query_com, $rari_coneccion) or die(mysql_error());
		//return mysql_fetch_assoc($desF);
		$filas=array();
		$i=0;
		while($des_com = mysql_fetch_assoc($desF))
		{
			$filas[$i]=$des_com["desc_comunicado"];
			$i++;
		}
		
		return $filas;
		
	}

	


	
	//Termina código nuevo.

	/*	function obtenerDataComunicado($database_rari_coneccion, $rari_coneccion,$id){
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		
		$query_catalogos = "SELECT *FROM tbl_comunicado where id=".$id;
		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$totalRows_catalogos= mysql_num_rows($catalogos);
		if($totalRows_catalogos<1)
		return null;
		return mysql_fetch_assoc($catalogos);
		}
	*/
?>