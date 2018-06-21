<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require_once('Connections/rari_coneccion.php'); 
	//require_once("libs/SOAP/nusoap.php");

	function recortar_texto($texto, $limite)
	{
		$texto = trim($texto);
		$texto = strip_tags($texto);
		$tamano = strlen($texto);
		$resultado = '';
		if($tamano <= $limite)
		{
			return $texto;
		}
		else
		{
			$texto = substr($texto, 0, $limite);
			$palabras = explode(' ', $texto);
			$resultado = implode(' ', $palabras);
			$resultado .= '...';
		}   
		return $resultado;
	}
?>

<?php 

	if(!isset($emitir)&&isset($_GET['emitir']))
	{
		$emitir=$_GET['emitir'];
	}

	if(isset($_GET['idsMap']))
	{
		//$_GET['idsMap']="30,31";
?>
	<!-- Mapa ESRI para comunicado -->
    <object id="mapaM" type="text/html" data="http://10.24.17.53/mapaAlertas/mapaAlertas.aspx?id=<?php echo $_GET['idsMap']; ?>"
            style="width:100%;  height:100%; border:2px solid #999;">
    </object>
    
    
<?php
	}
	else if(!isset($_GET['idAlert']))
	{
		if(!isset($modulo)&&isset($_GET['mod']))
			$modulo=$_GET['mod'];
			

		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		//$query_catalogos = 'SELECT id, idTipoComunicado, fecha, titulo, imagen FROM tbl_comunicado where idArea='.$modulo;
		$query_catalogos = 'SELECT id, idTipoComunicado, fecha, titulo, imagen FROM tbl_comunicado where idArea='.$modulo;
	


		if(isset($_GET['tipo'])&&$_GET['tipo']>0)
			$query_catalogos =$query_catalogos.' and idTipoComunicado='.$_GET['tipo'];

			
		//sección de las fechas

		$fecUno=$_GET['da1'];
		$fecDos=$_GET['da2'];

		if(isset($fecUno)&&isset($fecDos))
		{
			if($_GET['da1']==$_GET['da2'])
				$query_catalogos =$query_catalogos.' and fecha=\''.$fecUno.'\'';
			if($_GET['da1']<$_GET['da2'])
			$query_catalogos =$query_catalogos.' and fecha>=\''.$fecUno.'\' and fecha<=\''.$fecDos.'\' ';
			if($_GET['da1']>$_GET['da2'])
				$query_catalogos =$query_catalogos.' and fecha=\''.$fecUno.'\'';	
			//$query_catalagos=$query_catalagos.'  ORDER BY  fecha=\''.$fecUno.'\' DES';
		}

		//fechas

/*

		if(isset($_GET['da1'])&&isset($_GET['da2']))
		{
			if($_GET['da1']==$_GET['da2'])
				$query_catalogos =$query_catalogos." and fecha_registro='".$_GET['da1']."'";
			else
				$query_catalogos =$query_catalogos." and fecha_registro>='".$_GET['da1']."' and fecha_registro<='".$_GET['da2']."'";	
		}


		if(!isset($_GET['da1'])&&!isset($_GET['da2']))
			$query_catalogos =$query_catalogos." and fecha_registro=curdate()";
*/
		
		if(isset($emitir))
		{
			$query_catalogos =$query_catalogos.' and autorizacion='.$emitir;
			
		}
		
		
		if(isset($emitir))
		{
			$query_catalogos =$query_catalogos.' and autorizacion='.$emitir;
		}
		
		if (isset($_GET['palClave']))
		{
			//Criterios de búsqueda
			$palClave = $_GET['palClave'];
			
			
			$arregloCriteriosBusqueda = preg_split('/\s/', $palClave);
			
			$criterio = ' and (';
	
			foreach ($arregloCriteriosBusqueda as $value)
			{	
				
				if ($palClave != ' ' and $palClave != ''){
				$criterio .= 'titulo LIKE \'%'.$value.'%\' OR ';		
				}	
				
			}
			
			
			$criterio = substr($criterio, 0, -4);
			$criterio .= ')';
			
			$query_catalogos .= $criterio;
		}

		//echo '<br>'.$query_catalogos.'<br><br><br><br>';


		$catalogos = mysql_query($query_catalogos, $rari_coneccion) or die(mysql_error());
		$row_catalogos = mysql_fetch_assoc($catalogos);
		$totalRows_catalogos= mysql_num_rows($catalogos);
		$ides="";
?>


	<input type="hidden" name="totalRows" id="totalRows" value="<?php echo $totalRows_catalogos; ?>"/>

	<table class="recuadro-interior" style="border-radius:10px" width="100%" align="center">
		<tr height="40" class="recuadro-interior" style="color:#333">
			<td width="8%" align="center"></td>
			<td width="15%">Fecha</td>
			<td width="40%" align="center">T&iacute;tulo</td>
			<td width="10%" align="center">Im&aacute;gen</td>
			<td width="27%" align="center">Lugar</td></tr>
		<tr>
			<td colspan="5" bgcolor="#333333" align="center"><?php
 
		echo $ides;
		echo $totalRows_catalogos.' elemento(s) encontrado(s).'; ?></td>
		</tr>
		<?php if($totalRows_catalogos>0)do{?>
		<tr onclick="mostrarDetalle(<?php 
			if($ides!='')
				$ides=$ides.',';
			$ides=$ides.$row_catalogos['id'];
			$cadEnviar=$row_catalogos['id'];
			if(isset($emitir))
				$cadEnviar=$row_catalogos['id'].',false,'.$emitir;
 
			echo $cadEnviar;?>)" class="fila" >
			<td align="center">
				<div class="ico-lista" style="background-image:url(imagenes/tipo_comunicados/<?php echo obtenerNombreIco($row_catalogos['idTipoComunicado']) ?>);"></div>
			</td>
			<td><?php echo $row_catalogos['fecha'];?></td>
			<td><?php echo $row_catalogos['titulo'];?></td>
			<td align="center">
				<div class="imagen-lista" style="background-image:url(archivos_alertas/imagenes/<?php echo $row_catalogos['imagen']; ?>);"></div>
				<?php //echo $row_catalogos['imagen'];?></td>
			<td style="font-size:10px;"><?php echo obtenerLoc($database_rari_coneccion, $rari_coneccion,$row_catalogos['id']) ?></td></tr>
		<tr height="80px" bgcolor="#333" style="display:none; background-image:url(imagenes/barra.png);" class="row_detalle" id="row_<?php echo $row_catalogos['id'];?>">
			<td colspan="5">
				<div id="info_alerta_<?php echo $row_catalogos['id'];?>" class="info_alerta"></div>
			</td>
		</tr>
  
		<?php }while($row_catalogos = mysql_fetch_assoc($catalogos));?>
 
		<tr><td>
			<input type="hidden" name="commmons" id="commmons" value="<?php echo $ides; ?>"/>
		</td></tr>
	</table>
  
<?php 
	}
	else
	{
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogo = 'SELECT tbl_comunicado.id, tbl_comunicado.idArea, tbl_comunicado.autorizacion, resumen, tbl_usuarios.nombre, tbl_usuarios.apellido FROM tbl_comunicado inner join tbl_usuarios on tbl_usuarios.id=tbl_comunicado.idUsuario where tbl_comunicado.id='.$_GET['idAlert'];
		$catalogo = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
		$row_catalogo = mysql_fetch_assoc($catalogo);
		$totalRows_catalogo= mysql_num_rows($catalogo);

		if(isset($_GET['modo'])&&$_GET['modo']!="mod")
		{
			$n_valor=0;
			if($row_catalogo['autorizacion']==0)
				$n_valor=1;
	
			if($n_valor==1)
				echo enviarComunicado($_GET['idAlert']);
	
			$query_cat = 'update tbl_comunicado set autorizacion='.$n_valor.' where tbl_comunicado.id='.$_GET['idAlert'];
			$cat = mysql_query($query_cat, $rari_coneccion) or die(mysql_error());
  
			$catalogo = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
			$row_catalogo = mysql_fetch_assoc($catalogo);
			$totalRows_catalogo= mysql_num_rows($catalogo);	
		}

		do
		{
?>
	<div style="margin-top:-22px; margin-left:400px;" class="triangulo_inf"></div>
	<table width="100%">
		<tr>
			<td width="90%">
				<span class="resumen"> Resumen: <?php 
			
			$texto=$row_catalogo['resumen'];
			if(strlen($texto)>200)
			{
				$posicion=strripos(substr($texto,0,200)," ");
				$texto= substr($texto,0,$posicion)."...";
			}
			echo $texto;
 
			//echo recortar_texto($row_catalogo['resumen'], 200);
			//echo $row_catalogo['resumen']?></span></td>
 
			<td width="10%"> 
				<span style=" font-size:12px; cursor:pointer;" onclick="verMas(<?php echo $row_catalogo['id'];?>,<?php echo $row_catalogo['idArea'];?>)">Ver más</span>
				<span style="color:<?php if($row_catalogo['autorizacion']==1) echo '#0F0'; else echo '#F00'?>; cursor:pointer;" onclick="mostrarDetalle(<?php 
			
			$cadEnviar=$row_catalogo['id'].',true';
			if(isset($emitir))
				$cadEnviar=$cadEnviar.','.$emitir;
			
			echo $cadEnviar;?>)" class="resumen">
			
			<?php if(isset($emitir))
				{if($row_catalogo['autorizacion']==1) echo '<br/><br/>Publico'; else echo '<br/><br/>Privado';}?></span>
			<?php if(isset($_GET['modo'])&&$_GET['modo']=="mod"){?>
			
				<br/><br/>
			
				<span style="cursor:pointer;" class="resumen" onclick="actualizar(<?php echo $row_catalogo['id']; ?>)"> Modificar </span>
			<?php }?>
			</td>
		</tr>
		<tr>
			<td>
				<span class="resumen"> Publicado por: <span class="nombre"><?php echo $row_catalogo['nombre'].' '.$row_catalogo['apellido']?></span></span>
			</td>
		</tr>
	</table>
<?php
		}
		while($row_catalogo = mysql_fetch_assoc($catalogo));	
	}
	
	function obtenerNombreIco($tipoAlerta)
	{
		switch($tipoAlerta)
		{
			case 1:
			return 'alerta.png';
			case 2:
			return 'cuarentena.png';
			case 3:
			return 'informacion.png';
			case 4:
			return 'noticia.png';
			case 5:
			return 'rechazo.png';
			case 6:
			return 'retencion.png';
		}
	}
	  
	function obtenerLoc($database_rari_coneccion, $rari_coneccion, $idAlerta)
	{
		//No sirve
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_catalogo = 'select 
		(select tbl_paises.nombre from tbl_paises where tbl_paises.id=det_comunicado_localizacion.idPais) as Pais,
		(select tbl_estados.nombre from tbl_estados where tbl_estados.id=det_comunicado_localizacion.idEstado) as Edo,
		(select tbl_municipios.nombre from tbl_municipios where det_comunicado_localizacion.idMunicipio=tbl_municipios.id) as Mpo,
		region,
		det_comunicado_localizacion.idComunicado from det_comunicado_localizacion where idComunicado='.$idAlerta;
	 
		$catalogo = mysql_query($query_catalogo, $rari_coneccion) or die(mysql_error());
		$row_catalogo = mysql_fetch_assoc($catalogo);
		$totalRows_catalogo= mysql_num_rows($catalogo);

		if($totalRows_catalogo>0)
		{
			$cad=$row_catalogo['region'];

			if($row_catalogo['Mpo']!=null)
			{
				$cad=$cad.', '.$row_catalogo['Mpo'];
				$cad=$cad.', '.$row_catalogo['Edo'];
			}

			$cad=$cad.', '.$row_catalogo['Pais'].'<br/>';
			return $cad;
		}
		else
			return '';
	}
	  
	function enviarComunicado($id)
	{
		/*Llamada a webservice de envio de correo*/
		$objClienteSOAP = new soapclient('http://localhost/wsRARI/Service.asmx?WSDL');

		$params = array();
		$params['idAlerta'] = $id;

		$result=$objClienteSOAP->aplicacion($params);

		return $result->enviarComunicadosResult;
	}
?>