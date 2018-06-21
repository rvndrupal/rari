<?php 
	//Se agrega código para nueva funcionalidad de gráficas. LVC y RV 6-Junio-2018
	//datos para el combo
	function datosArea($area=0, $database_rari_coneccion, $rari_coneccion)
	{
		$combobit="";
		$dat_area="select nombre from tbl_areas";
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_areas = mysql_query($dat_area, $rari_coneccion) or die(mysql_error());

		while($row_area=mysql_fetch_array($det_areas))
		{
			$combobit .=" <option value='".$row_area['nombre']."'>".$row_area['nombre']."</option>"; 
		}

		return $combobit;
	}//datos para el combo

	//grafica 4
	function obtenerEmitidos($area=0, $fInicio, $fFin, $database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		$nombres=array();
		
		$det_bitacoraSQL="
			select  tbl_areas.nombre as Nombre, COUNT(*) as Total from tbl_areas 
			inner join tbl_comunicado  ON
			tbl_comunicado.idArea=tbl_areas.id		
			where tbl_comunicado.fecha_registro>='".$fInicio."' and tbl_comunicado.fecha_registro<='".$fFin."'";
	
		/*
		$det_bitacoraSQL="select cat_comunicados.nombre as Nombre, count(*) as Total from tbl_comunicado 
		inner join cat_comunicados on tbl_comunicado.idTipoComunicado=cat_comunicados.id 
		where tbl_comunicado.fecha_registro>='".$fInicio."' and tbl_comunicado.fecha_registro<='".$fFin."'";*/

		if($area>0)
			$det_bitacoraSQL=$det_bitacoraSQL." and tbl_comunicado.idArea=".$area;

		$det_bitacoraSQL=$det_bitacoraSQL." group by tbl_areas.nombre order by tbl_areas.nombre ASC";
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		//$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		$i=0;
		$max=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			if($row_det_bitacora['Total']>$max)
				$max=$row_det_bitacora['Total'];
			$result[$i]=$row_det_bitacora['Total'];
			$nombres[$i]=$row_det_bitacora['Nombre'];
				
			$i++;
		}
				
		if($max<2)
			return null;
				
		//$nombres=obtenerNombres("cat_comunicados", $database_rari_coneccion, $rari_coneccion);
				
		return array($result,$nombres);
		//return $data;
		//fin de la seccion barra						
	}

	//grafica 4
	function obtenerComunicadosPorTipo($area=0, $fInicio, $fFin, $database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		$nombres=array();
	
		$det_bitacoraSQL='select cat_comunicados.nombre, count(*) as Total from tbl_comunicado 
			inner join cat_comunicados on tbl_comunicado.idTipoComunicado=cat_comunicados.id 
			where tbl_comunicado.fecha_registro>=\''.$fInicio.'\' and tbl_comunicado.fecha_registro<=\''.$fFin.'\'';
			
		if($area>0)
			$det_bitacoraSQL=$det_bitacoraSQL.' and tbl_comunicado.idArea='.$area;

		$det_bitacoraSQL=$det_bitacoraSQL.' group by tbl_comunicado.idTipoComunicado order by nombre ASC';
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		//$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		$i=0;
		$max=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			if($row_det_bitacora['Total']>$max)
				$max=$row_det_bitacora['Total'];
			$result[$i]=$row_det_bitacora['Total'];
			$nombres[$i]=$row_det_bitacora['nombre'];
			$i++;
		}
		
		if($max<2)
			return null;
		
		//$nombres=obtenerNombres("cat_comunicados", $database_rari_coneccion, $rari_coneccion);
		
		return array($result,$nombres);
		//return $data;
		//fin de la seccion barra
	}

	//grafica 5
	function obtenerEstatus($area=0, $fInicio, $fFin, $database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		$nombres=array();
	
		$det_bitacoraSQL='SELECT titulo, idEstatus as Total FROM tbl_comunicado
			where tbl_comunicado.fecha_registro>=\''.$fInicio.'\' and tbl_comunicado.fecha_registro<=\''.$fFin.'\' LIMIT 10';

		if($area>0)
		//$det_bitacoraSQL=$det_bitacoraSQL." and tbl_comunicado.idArea=".$area;
			$det_bitacoraSQL=$det_bitacoraSQL.' group by tbl_comunicado.idEstatus order by idEstatus ASC ';
			
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		//$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		$i=0;
		$max=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			if($row_det_bitacora['Total']>$max)
				$max=$row_det_bitacora['Total'];
			$result[$i]=$row_det_bitacora['Total'];
			$nombres[$i]=$row_det_bitacora['titulo'];
			$i++;				
		}
				
		if($max<2)
			return null;				
		return array($result,$nombres);										
	}

	//GRAFICA 6 CIRCULO
	function obtenerAreas($area=0, $fInicio, $fFin, $database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		$nombres=array();
	
		$det_bitacoraSQL='select areas.nombre as Nombre,  COUNT(areas.nombre) as Total from tbl_comunicado com 
			INNER JOIN tbl_areas areas ON areas.id=com.idArea
			where com.fecha_registro>=\''.$fInicio.'\' and com.fecha_registro<=\''.$fFin.'\'
			group by Nombre';
	
		/*$det_bitacoraSQL="select titulo as Nombre, idArea as Total from tbl_comunicado com
			where com.fecha_registro>='".$fInicio."' and com.fecha_registro<='".$fFin."' limit 10";*/

		if($area>0)
			//$det_bitacoraSQL=$det_bitacoraSQL." and tbl_comunicado.idArea=".$area;

			//$det_bitacoraSQL=$det_bitacoraSQL."GROUP by areas.nombre ";
			
			mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
			
		/*$i=0;
		$max=0;*/
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			/*if($row_det_bitacora['Total']>$max)
				$max=$row_det_bitacora['Total'];
			$result[$i]=$row_det_bitacora['Total'];
			$nombres[$i]=$row_det_bitacora['Nombre'];
			$i++;*/
			$result[]=$row_det_bitacora['Total'];
			$nombres[]=$row_det_bitacora['Nombre'];
		}
				
		/*if($max<2)
		return null;*/
							
		return array($result,$nombres);										
	}

	function obtenerComunicadosPorNivelRiesgo($catalogo, $campo, $area=0, $fInicio, $fFin, $database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		$nombres=array();
	
		$det_bitacoraSQL='select '.$catalogo.'.nombre, count(*) as Total from tbl_comunicado 
			inner join '.$catalogo.' on tbl_comunicado.'.$campo.'='.$catalogo.'.id where tbl_comunicado.fecha_registro>=\''.$fInicio.'\' and tbl_comunicado.fecha_registro<=\''.$fFin.'\'';

		if($area>0)
			$det_bitacoraSQL=$det_bitacoraSQL.' and tbl_comunicado.idArea='.$area;

		$det_bitacoraSQL=$det_bitacoraSQL.' group by tbl_comunicado.'.$campo.' order by nombre ASC';

		//echo "<br/><br/>".$det_bitacoraSQL=$det_bitacoraSQL;
	
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		//$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		//$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
		$i=0;
		$max=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			if($row_det_bitacora['Total']>$max)
				$max=$row_det_bitacora['Total'];
			$result[$i]=$row_det_bitacora['Total'];
			$nombres[$i]=$row_det_bitacora['nombre'];
			$i++;
		}
		
		if($max<2)
			return null;
		
		//$nombres=obtenerNombres($catalogo, $database_rari_coneccion, $rari_coneccion);
			
		return array($result,$nombres);
		//return $data;
	}

	function obtenerNombres($tabla, $database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL='select nombre from '.$tabla.' order by nombre ASC';

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
		$nombres=array();
		$i=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$nombres[$i]=$row_det_bitacora['nombre'];
			$i++;
		}
	
		return $nombres;	
	}
	
	function obtenerNombresSinOrden($tabla, $database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL='select nombre from '.$tabla;

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
		$nombres=array();
		$i=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$nombres[$i]=$row_det_bitacora['nombre'];
			$i++;
		}
		return $nombres;	
	}

	function obtenerDiviciones($datos)
	{
		$max=0;
	
		for($i=0; $i<count($datos); $i++)
		{
			if($datos[$i]>$max)
				$max=$datos[$i];
		}
		
		$lineas=array();
	
		if($max>10)
		{
			if($max>500)
				$dividirPor=100;
			else if(($max>100))
				$dividirPor=50;
			else if(($max>50))
				$dividirPor=10;
			else
				$dividirPor=5;
			
			//Redondeamos
			$max=ceil($max);
			$max=$max+10;

			/*
			for($i=1; $i<=($max/$dividirPor); $i++)
			{
				$lineas[$i]=$i*$dividirPor;
				echo $lineas[$i];
			}*/
		}
		else
		{	
			$lineas=array(1,2,3,4,5,6,7,8,9,10);
		}
		return $lineas;
	}

	function obtenerDiaSemana($fecha)
	{
		$dias=array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');

		//$fecha="1982-12-09" ;
		$dia=substr($fecha,8,2);
		$mes=substr($fecha,5,2);
		$anio=substr($fecha,0,4);
		$pru=$dias[intval((date('w',mktime(0,0,0,$mes,$dia,$anio))))];
		return $pru;
	}

	function fecha($fecha='')
	{ 
		$mesArray = array( 
							1 => 'Enero',
							2 => 'Febrero',
							3 => 'Marzo',
							4 => 'Abril', 
							5 => 'Mayo',
							6 => 'Junio', 
							7 => 'Julio', 
							8 => 'Agosto',
							9 => 'Septiembre', 
							10 => 'Octubre', 
							11 => 'Noviembre', 
							12 => 'Diciembre' 
						);
		$nombreDiaArray = array( 
								0 => 'Domingo',
								1 => 'Lunes',
								2 => 'Martes',
								3 => 'Miércoles',
								4 => 'Jueves', 
								5 => 'Viernes',
								6 => 'Sábado' 
								); 
		
		if($fecha=='')
		{
			$mes = date('n');
			$dia = date('d');
			$anio = date ('Y');
		}
		else
		{
			$array=explode ('-',$fecha);
			$dia=$array[2];
			$mes=$array[1];
			$anio=$array[0];
		}
		
		$mesReturn = $mesArray[intval($mes)]; 
        $nombreDiaReturn = $nombreDiaArray[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))];
        
        return $nombreDiaReturn.' '.intval($dia).' de '.$mesReturn.' de '.$anio; 
    }	
	
	function consultarNombreArea($idArea,$database_rari_coneccion, $rari_coneccion)
	{
		$result=array();
		if($idArea>0)
		{
			$det_bitacoraSQL='select nombre, color_s from tbl_areas where id='.$idArea;

			mysql_select_db($database_rari_coneccion, $rari_coneccion);
			$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
			$i=0;
			while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
			{
				$result[0]='Direccion General de '. utf8_encode($row_det_bitacora['nombre']);
				$result[1]=$row_det_bitacora['color_s'];
				$i++;
			}
		}
		else
		{
			$result[0]='Todas las areas';
			$result[1]='#666';
		}
	
		return $result;
	}
		
	function obtenerPrimerosEstados($idArea,$fechai,$fechaf,$database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL='select tbl_estados.id, nombre, count(det_comunicado_localizacion.idEstado) as Total from tbl_estados 
			inner join det_comunicado_localizacion on tbl_estados.id=det_comunicado_localizacion.idEstado 
			inner join tbl_comunicado on det_comunicado_localizacion.idComunicado=tbl_comunicado.id where tbl_comunicado.fecha_registro>=\''.$fechai.'\' and tbl_comunicado.fecha_registro<=\''.$fechaf.'\'';

		if($idArea>0)
			$det_bitacoraSQL=$det_bitacoraSQL.' and idArea='.$idArea;

		$det_bitacoraSQL=$det_bitacoraSQL.' group by det_comunicado_localizacion.idEstado LIMIT 10';

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		
		$nombres=array();
		$ides=array();
		$i=0;
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			//echo $row_det_bitacora["nombre"];
			$nombres[$i]=$row_det_bitacora['nombre'];
			$ides[$i]=$row_det_bitacora['id'];
			$i++;
		}
		
		if($i>1)
			return array($ides,$nombres);
		else return null;
	}
			
	function obtenercomunicadosPorTipoYEdo($idArea,$idEdo,$fechai,$fechaf,$database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL='select idTipoComunicado, count(*) as Total from det_comunicado_localizacion inner join tbl_comunicado
			on det_comunicado_localizacion.idComunicado=tbl_comunicado.id
			where idEstado='.$idEdo.' and tbl_comunicado.fecha_registro>=\''.$fechai.'\' and tbl_comunicado.fecha_registro<=\''.$fechaf.'\'';
		if($idArea>0)
			$det_bitacoraSQL=$det_bitacoraSQL.' and idArea='.$idArea;

		$det_bitacoraSQL=$det_bitacoraSQL.' group by idTipoComunicado';

		//echo $det_bitacoraSQL;

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
			
		$arrayCantidad=array();
			
		for($i=0; $i<6;$i++)
		{
			$arrayCantidad[$i]=0;
		}
			
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			//$arrayTipoComunicado[$i]=$row_det_bitacora["idTipoComunicado"];
			$arrayCantidad[$row_det_bitacora['idTipoComunicado']-1]=$row_det_bitacora['Total'];
			//$i++;
		}
			
		//$arrayNombres=obtenerNombresSinOrden("cat_comunicados", $database_rari_coneccion, $rari_coneccion);
		
		return $arrayCantidad;
	}
?>