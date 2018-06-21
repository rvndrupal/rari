<?php 
	function obtenerComunicadosUIS( $database_rari_coneccion, $rari_coneccion)
	{
		$det_bitacoraSQL='select id, titulo, resumen, imagen, fecha, idTipoComunicado from tbl_comunicado where autorizacion=1 and idArea=6 order by fecha DESC LIMIT 10;';

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		
		$salida='';
		$salida2='';
		$index=1;
	
		while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
		{
			$id= base64_encode(base64_encode($row_det_bitacora['id']));
		
			$salida=$salida.'
				<a href="verComunicado.php?r='.$id.'"><div class="noticia-uis">
				<div class="ima" style="background-image:url(archivos_alertas/imagenes/'.$row_det_bitacora['imagen'].');">
				<span class="leyendaUIS">'.obtenerLocalizacionComunicado( $database_rari_coneccion, $rari_coneccion, $row_det_bitacora['id']).'</span>
				</div>
				<div class="cont"><span class="tituloUIS">
				'.recortarTexto($row_det_bitacora['titulo'],100).' ('.$row_det_bitacora['fecha'].')</span></div>
				</div></a>';
		}
		return $salida;	
	}
	echo obtenerComunicadosUIS( $database_rari_coneccion, $rari_coneccion);
?>