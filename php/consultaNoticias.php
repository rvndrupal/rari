<?php 
	require_once('php/encriptador.php'); 
	
	function recortarTexto($texto, $longitud)
	{
		//$texto=$row_catalogo['resumen'];
		if(strlen($texto)>$longitud)
		{
			$posicion=strripos(substr($texto,0,$longitud),' ');
			$texto= substr($texto,0,$posicion).'...';
		}
 
		return $texto;
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

	function obtenerLocalizacionComunicado( $database_rari_coneccion, $rari_coneccion, $idComunicado, $todasLasLocalizaciones=false)
	{
		$det_bitacoraSQL='select concat(det_comunicado_localizacion.region ,\' (\',tbl_paises.nombre,\')\') as Lugar from det_comunicado_localizacion
						inner join tbl_paises on det_comunicado_localizacion.idPais=tbl_paises.id where det_comunicado_localizacion.idComunicado='.$idComunicado;

		if($todasLasLocalizaciones==false)
			$det_bitacoraSQL=$det_bitacoraSQL.' LIMIT 3;';

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$salida='';
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			if($salida!='')
				$salida=$salida.', ';
			$salida=$salida.$row_det_bitacora['Lugar'];
		}
		return $salida;
	}

	function obtenerComunicados( $database_rari_coneccion, $rari_coneccion, $idArea=1)
	{
		$det_bitacoraSQL='select id, titulo, resumen, imagen, fecha, idTipoComunicado from tbl_comunicado where autorizacion=1 and idArea='.$idArea.' order by fecha DESC LIMIT 10;';

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
		$salida='';
		$salida2='';
		$index=1;
	
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$id= base64_encode(base64_encode($row_det_bitacora['id']));
			$salida=$salida.'
				<a href="verComunicado.php?r='.$id.'"><div id="n_not'.$index.'" style="width:100%; '.(($index==1)?'':'display:none;').' float:left; height:360px; background-image:url(archivos_alertas/imagenes/'.$row_det_bitacora['imagen'].'); background-position:center; background-size:cover;">
				<div class="contentInfoComunicado">
				<div class="barraInfo">'.strip_tags(recortarTexto($row_det_bitacora['resumen'],200)).'</div>
				<div class="iconoComunicado" style="background-image:url(imagenes/tipo_comunicados/'.obtenerNombreIco($row_det_bitacora['idTipoComunicado']).');"></div>
				</div>
				</div></a>';

			$salida2=$salida2.'
				<tr id="not'.$index.'"><td width="10%"><div class="selector"; style=" '.(($index==1)?'display:block;':'display:none;').' "></div></td><td><span style="font-size:14px; font-weight:bold;">'.$row_det_bitacora['titulo'].'</span> ('.$row_det_bitacora['fecha'].')<br/> '.obtenerLocalizacionComunicado( $database_rari_coneccion, $rari_coneccion, $row_det_bitacora['id']).' </td><td><div style="width:25px; height:25px; background-image:url(imagenes/tipo_comunicados/'.obtenerNombreIco($row_det_bitacora['idTipoComunicado']).'); background-size:contain; background-repeat:no-repeat;"></div></td></tr>
				';
			$index++;
		}
		return array($salida,$salida2);	
	}
?>

<?php 
	$texto='Sanidad Vegetal';
	$img='salud_vegetal_peq';
	if(!isset($_GET['r']))
		$area=1;
	else
	{
		$area=1;
		$texto=base64_decode(base64_decode($_GET['r']));
		if($texto=='Sanidad Vegetal')
		{
			$area=1;
			$img='salud_vegetal_peq';
		}
		else if($texto=='Salud Animal')
		{
			$area=2;
			$img='salud_animal_peq';
		}
		else if($texto=='Inocuidad Agroalimentaria')
		{
			$area=3;
			$img='inocuidad_peq';
		}
		else if($texto=='Inspección fitozoosanitaria')
		{
			$area=4;
			$img='inspeccion_peq';
		}
		else if($texto=='Sanidad acuicola y pesquera')
		{
			$area=5;
			$img='sanidad_acuicola_peq';
		}
		else 
		{
			$MM_restrictGoTo = 'index.php';
			header('Location: '. $MM_restrictGoTo);
		}
	}

	$data=obtenerComunicados($database_rari_coneccion, $rari_coneccion, $area);
?>

<table height="390px" width="100%">
	<tr>
		<td height="30px;" colspan="2" style="background-color:#666;" align="center">
			<table width="90%"><tr>
				<td><div class="tabArea" style="background-image:url(imagenes/<?php echo $img ?>.png);"></td>
				<td><span style="font-size:16px; font-weight:bolder; color:#FFF;">Comunicados nacionales en <?php echo $texto; ?></span></td>
				<!-- Se realiza modificación para nueva pantalla de acceso. LVC 12-junio-2018 
				<td><a title="Sanidad Vegetal" href="index.php?r=<?php /* echo base64_encode(base64_encode("Sanidad Vegetal"));?>"><div class="tabArea" style="background-image:url(imagenes/salud_vegetal_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Salud Animal" href="index.php?r=<?php echo base64_encode(base64_encode("Salud Animal"));?>"><div class="tabArea" style="background-image:url(imagenes/salud_animal_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Inocuidad Agroalimentaria" href="index.php?r=<?php echo base64_encode(base64_encode("Inocuidad Agroalimentaria"));?>"><div class="tabArea" style="background-image:url(imagenes/inocuidad_peq.png)"></div></a></td>
				<td  align="center"style="border-left:1px #aaa solid;"><a title="Inspección fitozoosanitaria" href="index.php?r=<?php echo base64_encode(base64_encode("Inspección fitozoosanitaria"));?>"><div class="tabArea" style="background-image:url(imagenes/inspeccion_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Sanidad acuicola y pesquera" href="index.php?r=<?php echo base64_encode(base64_encode("Sanidad acuicola y pesquera")); */?>"><div class="tabArea" style="background-image:url(imagenes/sanidad_acuicola_peq.png)"></div></a></td>
				 Se comenta código para guardarlo. -->
				<td><a title="Sanidad Vegetal" href="principal.php?r=<?php echo base64_encode(base64_encode('Sanidad Vegetal'));?>"><div class="tabArea" style="background-image:url(imagenes/salud_vegetal_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Salud Animal" href="principal.php?r=<?php echo base64_encode(base64_encode('Salud Animal'));?>"><div class="tabArea" style="background-image:url(imagenes/salud_animal_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Inocuidad Agroalimentaria" href="principal.php?r=<?php echo base64_encode(base64_encode('Inocuidad Agroalimentaria'));?>"><div class="tabArea" style="background-image:url(imagenes/inocuidad_peq.png)"></div></a></td>
				<td  align="center"style="border-left:1px #aaa solid;"><a title="Inspección fitozoosanitaria" href="principal.php?r=<?php echo base64_encode(base64_encode('Inspección fitozoosanitaria'));?>"><div class="tabArea" style="background-image:url(imagenes/inspeccion_peq.png)"></div></a></td>
				<td align="center" style="border-left:1px #aaa solid;"><a title="Sanidad acuicola y pesquera" href="principal.php?r=<?php echo base64_encode(base64_encode('Sanidad acuicola y pesquera'));?>"><div class="tabArea" style="background-image:url(imagenes/sanidad_acuicola_peq.png)"></div></a></td>
			</tr></table>
	</td></tr>
	<tr>
		<td height="360px" width="70%" bgcolor="#fff" style="overflow:hidden; background-color:#fff; background-image:url(imagenes/imagenrarilat_b.png); background-size:contain; background-position:center; background-repeat:no-repeat;">
			<div style="width:100%; height:360px; position:relative;">
				<?php echo $data[0]; ?>
				<div style="background-image: url(imagenes/logorari.png); bottom:0; z-index: 2; position: absolute; float: right; background-size: contain; background-repeat: no-repeat; background-position: center; width: 120px; height: 60px;"></div>
			</div>
		</td>
		<td>
			<div style="height:360px; width:100%; overflow:auto;">
				<table id="tbl_noticias" width="100%" class="noticias">
					<?php echo $data[1]; ?>
				</table>
				<a href="historia.php<?php if(isset($_GET['r'])) echo '?r='.$_GET['r']; ?>"><div style="text-align:center; margin-top:10px;">Histórico de comunicados</div></a>
			</div>
		</td>
	</tr>
</table>