<?php require_once('Connections/rari_coneccion.php');
	  require_once 'php/detalles.php';
 ?>

<?php

	
//768 157
mysql_select_db($database_rari_coneccion, $rari_coneccion);
$query_comunicados = "SELECT tbl_c.id, fecha, titulo, imagen, estatus_comunicado, nombre, idArea, idNivelRiesgo, idNivelAlerta, resumen, tbl_c.idEstatus, mapa, imagen FROM tbl_comunicado as tbl_c inner join cat_comunicados cat_c on tbl_c.idTipoComunicado = cat_c.id where tbl_c.id=".$idCatalogo;

$query_agente_causal = "select nombre from cat_agentes where id in (select idAgente from det_comunicado_agente where idComunicado = " .$idCatalogo.")";

$query_hospedero = "select * from cat_productos where id in (select idProducto from det_comunicado_productos where idComunicado = " .$idCatalogo.")";

$query_localizacion = "select region, e.nombre as estado, m.nombre as municipio, p.nombre as pais from rari.det_comunicado_localizacion l left join  tbl_paises p on l.idPais = p.id left join tbl_estados e
on l.idEstado= e.id left join tbl_municipios m on l.idMunicipio = m.id where idComunicado = "  .$idCatalogo;

$query_oisas = "select * from cat_oisas where id in (select idOisa from det_comunicado_oisas where idComunicado = " .$idCatalogo.")";

$query_pvis = "select * from cat_pvis where id in (select idPvi from det_comunicado_pvis where idComunicado = ". $idCatalogo.")";

$query_pvifs = "select * from cat_pvifs where id in (select idPvif from det_comunicado_pvifs where idComunicado =". $idCatalogo.")";

$query_enlaces = "select * FROM rari.det_comunicado_enlace where idComunicado = ". $idCatalogo. "";

$query_medidas_implementadas = "select * from cat_med_implementadas where id in (select idMedidaImplementada from det_comunicado_medidas_implementadas where idComunicado =". $idCatalogo.")";

$query_medidas_aimplementar = "select * from cat_med_aimplementar where id in (select idMedidaImplementada from det_comunicado_medidas_implementar where idComunicado =". $idCatalogo.")";

$query_motivos = "select * from cat_motivos where id in (select idMotivo from det_comunicado_motivos where idComunicado =". $idCatalogo.")";

$query_riesgo = "select * from cat_riesgo where id in (select idRiesgo from det_comunicado_riesgo where idComunicado =". $idCatalogo.")";

$query_reglamentacion = "select * from cat_reglamentacion where id in (select idReglamentacion from det_comunicado_reglamentacion where idComunicado =". $idCatalogo.")";

$query_resolucion_estatus = "select * from cat_resolucion where id in (select idResolucion from det_comunicado_resolucion where idComunicado =".$idCatalogo.")";


$comunicado = mysql_query($query_comunicados, $rari_coneccion) or die(mysql_error());
$row_comunicado = mysql_fetch_assoc($comunicado);
$total_comunicados = mysql_num_rows($comunicado);

$agente =mysql_query($query_agente_causal, $rari_coneccion) or die(mysql_error());
$row_agente = mysql_fetch_assoc($agente);
$total_agentes = mysql_num_rows($agente);

$hospedero =mysql_query($query_hospedero, $rari_coneccion) or die(mysql_error());
$row_hospedero = mysql_fetch_assoc($hospedero);
$total_hospedero = mysql_num_rows($hospedero);

$localizacion = mysql_query($query_localizacion, $rari_coneccion) or die(mysql_error());
$row_localizacion = mysql_fetch_assoc($localizacion);
$total_localizaciones = mysql_num_rows($localizacion);


$oisas =mysql_query($query_oisas, $rari_coneccion) or die(mysql_error());
$row_oisas = mysql_fetch_assoc($oisas);
$total_oisas = mysql_num_rows($oisas);

$pvis =mysql_query($query_pvis, $rari_coneccion) or die(mysql_error());
$row_pvis = mysql_fetch_assoc($pvis);
$total_pvis = mysql_num_rows($pvis);

$pvifs =mysql_query($query_pvifs, $rari_coneccion) or die(mysql_error());
$row_pvifs = mysql_fetch_assoc($pvifs);
$total_pvifs = mysql_num_rows($pvifs);


$enlaces = mysql_query($query_enlaces, $rari_coneccion) or die(mysql_error());
$row_enlace = mysql_fetch_assoc($enlaces);
$total_enlaces = mysql_num_rows($enlaces);


$implementadas = mysql_query($query_medidas_implementadas, $rari_coneccion) or die(mysql_error());
$row_implementadas = mysql_fetch_assoc($implementadas);
$total_implementadas = mysql_num_rows($implementadas);

$implementar = mysql_query($query_medidas_aimplementar, $rari_coneccion) or die(mysql_error());
$row_implementar = mysql_fetch_assoc($implementar);
$total_implementar = mysql_num_rows($implementar);

$motivos = mysql_query($query_motivos, $rari_coneccion) or die(mysql_error());
$row_motivos = mysql_fetch_assoc($motivos);
$total_motivos = mysql_num_rows($motivos);

$riegos = mysql_query($query_riesgo, $rari_coneccion) or die(mysql_error());
$row_riesgos = mysql_fetch_assoc($riegos);
$total_riesgos = mysql_num_rows($riegos);

$reglamentacion = mysql_query($query_reglamentacion, $rari_coneccion) or die(mysql_error());
$row_reglamentacion = mysql_fetch_assoc($reglamentacion);
$total_reglamentacion = mysql_num_rows($reglamentacion);

$resolucion_estatus = mysql_query($query_resolucion_estatus, $rari_coneccion) or die(mysql_error());
$row_resolucion_estatus = mysql_fetch_assoc($resolucion_estatus);
$total_resolucion_estatus = mysql_num_rows($resolucion_estatus);


$arreglo_pdf= obtenerDetallePdf($idCatalogo, $database_rari_coneccion, $rari_coneccion);
$arreglo_mapa= obtenerDetalleMapa($idCatalogo, $database_rari_coneccion, $rari_coneccion);

if(isset($row_comunicado['idNivelRiesgo'])){
	$query_Nivel_Riesgo = "select * from cat_nivel_riesgo where id = ".$row_comunicado['idNivelRiesgo'];
	$nivel_riesgo = mysql_query($query_Nivel_Riesgo, $rari_coneccion) or die(mysql_error());
	$row_nivel_riesgo = mysql_fetch_assoc($nivel_riesgo);
}else{
	$row_nivel_riesgo["nombre"] = utf8_encode("Sin nivel de riesgo");
}


if(isset($row_comunicado['idNivelAlerta'])){
	$query_Nivel_alerta = "select * from cat_nivel_alerta where id = ".$row_comunicado['idNivelAlerta'];
	$nivel_alerta = mysql_query($query_Nivel_alerta, $rari_coneccion) or die(mysql_error());
	$row_nivel_alerta = mysql_fetch_assoc($nivel_alerta);
}else{
	$row_nivel_alerta["nombre"] = utf8_encode("Sin nivel de alerta");
}

if(isset($row_comunicado['idArea'])){
$query_area = "select nombre from tbl_areas where id = ".$row_comunicado['idArea'];
	$area = mysql_query($query_area, $rari_coneccion) or die(mysql_error());
	$row_area = mysql_fetch_assoc($area);}else{
	$row_area["nombre"] = utf8_encode("Sin área");
}


?>


<page style="font-size: 10pt"  backtop="50mm" backbottom="40mm" backleft="20mm" backright="20mm">

<style>
#table1, #th1, #td1 , #td2{
    border: 1px solid black;
    border-collapse: collapse;
}
#th1, #td1, #td2 {
    padding: 5px;
    text-align: left;    
}

#th1 {
 	background-color:#696969;
 	color:white;
}

#td2 {
	background-color:#a8a8a8;
}

#th2 {
	background-color:#a8a8a8;
}
</style>


<page_header>
	<table align="center">
		<tr>
			<td colspan="2" align="center">
				<img style="height:90px; width:630px;" src="imagenes/encabezadoRARI.png" />
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:16px" >
					<?php echo "COMUNICADO DE " .  mb_strtoupper($row_area['nombre'], 'UTF-8');?>
				</span>
				<hr>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:10px">
					<?php echo $row_comunicado["titulo"]; ?>
				</span>
			</td>
		</tr>
		
	</table>
</page_header>
<page_footer>
	<table align="center">
		<tr>
			<td colspan="2" align="center">
				<img src="imagenes/escudoMexico.jpg" width="50" height="50"/>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:8px">
					<?php echo utf8_encode("Boulevard Adolfo Ruiz Cortines, No. 5010, Piso 8, Col. Insurgentes Cuicuilco, Del. Coyoacán, Ciudad de México, MÉXICO, C.P. 04530"); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:8px">
					<?php echo utf8_encode("Teléfono de Atención: +52(55) 5905-1000  ext. 54043; 54256"); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:8px">
					<?php echo utf8_encode("Comentarios sobre este sitio de internet: rarialertas.dj@senasica.gob.mx"); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:8px">
					<?php echo utf8_encode("Dirección de Planeación e Inteligencia Sanitaria"); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td  align="center">
				<span style="font-size:8px">
					<br>
					<?php echo utf8_encode("http://www.rari.senasica.gob.mx/"); ?>
				</span>
			</td>
		</tr>		
	</table>
</page_footer>
<table id="table1" width=800px>
		<tr>
			<th id="th1"  style="width: 20%;"><span style="font-size:10px">Fecha </span></th>
			<td id="td1"  style="width: 30%;"><span style="font-size:10px"><?php echo $row_comunicado['fecha'];?></span></td>
			<td id="td1" colspan="2" rowspan="4">
				<?php 
				
					if(strpos($row_comunicado['mapa'],".jpg") !== false || strpos($row_comunicado['mapa'],".jpeg") !== false || stristr($row_comunicado['mapa'],".png") !== false){?>
					<img src="archivos_alertas/mapas/<?php echo $row_comunicado['mapa'];?>" width="280" height="175"/ >
				<?php }else{?>
					<img src="archivos_alertas/mapas/imagenblanco.jpg" width="280" height="175"/ >
				<?php }?>
			</td>
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"> <span style="font-size:10px">Tipo de comunicado</span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php echo $row_comunicado['nombre'];?></span></td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px">Problema/Agente causal </span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php 

			$ele_agentes = "";
			if ($total_agentes>0) do {
				$ele_agentes .= $row_agente['nombre'].", ";
			}while($row_agente = mysql_fetch_assoc($agente));			
			
			$ele_agentes = trim($ele_agentes,", "); //elimina la ultima coma
			echo ($ele_agentes."."); 
								?></span>
			</td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px">Hospedero</span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php
			$ele_hospedero = "";
			if ($total_hospedero>0) do {
				$ele_hospedero .= $row_hospedero['nombre'].", ";
			}while($row_hospedero = mysql_fetch_assoc($hospedero));			
			
			$ele_hospedero = trim($ele_hospedero,", "); //elimina la ultima coma
			echo $ele_hospedero."."; 
			
			?></span></td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px"><?php echo utf8_encode("Localización")?></span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px">
<?php
							
							 $localizacionCompleta ="";
							 if($total_localizaciones >0) do{
				                 $localizacionCompleta .= $row_localizacion['region'].", ";
				                 $localizacionCompleta.= (isset($row_localizacion['municipio']))? $row_localizacion['municipio'].", ":""; 
								 $localizacionCompleta.= (isset($row_localizacion['estado']))? $row_localizacion['estado'].", ":"";
								 $localizacionCompleta.= (isset($row_localizacion['pais']))? $row_localizacion['pais'].". ":".";
							 }while($row_localizacion =  mysql_fetch_assoc($localizacion));
							 
							 $localizacionCompleta = trim($localizacionCompleta,",");
							 
							 echo $localizacionCompleta;
							 ?></span></td>
			<td id="td1" colspan="2" rowspan="4">
<?php if(stristr($row_comunicado['imagen'],".jpg") !== false || stristr($row_comunicado['imagen'],".jpeg") !== false || stristr($row_comunicado['imagen'],".png") !== false){?>
					<img src="archivos_alertas/imagenes/<?php echo $row_comunicado['imagen'];?>"  width="280" height="175"/>
				<?php }else{?>
					<img src="archivos_alertas/imagenes/imagenblanco.jpg" width="280" height="175"/ >
				<?php }?>


</td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px">OISA</span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php
			$ele_oisas = "";
			if ($total_oisas>0) do {
				$ele_oisas .= $row_oisas['nombre'].", ";
			}while($row_oisas = mysql_fetch_assoc($oisas));			
			
			$ele_oisas = trim($ele_oisas,", "); //elimina la ultima coma
			echo ($ele_oisas."."); 
			
			?>
			</span>
			</td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px">PVIS</span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php
			$ele_pvis = "";
			if ($total_pvis>0) do {
				$ele_pvis .= $row_pvis['nombre'].", ";
			}while($row_pvis = mysql_fetch_assoc($pvis));			
			
			$ele_pvis = trim($ele_pvis,", "); //elimina la ultima coma
			echo ($ele_pvis."."); 
			
			?></span></td>
			
		</tr>
		<tr>
			<th id="th1" style="width: 20%;"><span style="font-size:10px">PVIF</span></th>
			<td id="td1" style="width: 30%;"><span style="font-size:10px"><?php
			$ele_pvifs = "";
			if ($total_pvifs>0) do {
				$ele_pvifs .= $row_pvifs['nombre'].", ";
			}while($row_pvifs = mysql_fetch_assoc($pvifs));			
			
			$ele_pvifs = trim($ele_pvifs,", "); //elimina la ultima coma
			echo ($ele_pvifs."."); 
			
			?></span></td>
			
		</tr>
		</table>
	<br>
		<div text-align="center">
			<span style="font-size:14px;"><b>CONTENIDO </b></span>
		</div>
		<br>
		
		<span style="font-size:10px;" text-align="justify"> <?php echo $row_comunicado["resumen"]; ?></span>
		<br>
	
<table style="width : 100%" id="table2">
		<tr>
			<th colspan="4" id="th2" align="center" style="width: 100%;">SEGUIMIENTO</th>
		</tr>
		<tr>
			<td id="td2" style="width: 25%"><span style="font-size:10px">
				Medidas implementadas:</span>
			</td>
			<td id="td1" style="width: 25%"><span style="font-size:10px">
			<?php
			$ele_implementadas = "";
			if ($total_implementadas>0) do {
				$ele_implementadas .= $row_implementadas['nombre'].", ";
			}while($row_implementadas = mysql_fetch_assoc($implementadas));			
			
			$ele_implementadas = trim($ele_implementadas,", "); //elimina la ultima coma
			echo $ele_implementadas."."; 
			
			?>
				</span>
			</td>
			<td id="td2" style="width: 25%"><span style="font-size:10px">
				Medidas a implementar:</span>
			</td>
			<td id="td1" style="width: 25%"><span style="font-size:10px"><?php 
			$ele_implementar = "";
			if ($total_implementar >0) do {
				$ele_implementar .= $row_implementar ['nombre'].", ";
			}while($row_implementar = mysql_fetch_assoc($implementar));			
			
			$ele_implementar = trim($ele_implementar,", "); //elimina la ultima coma
			echo $ele_implementar."."; 
			?></span>
			</td>
		</tr>
		<tr>
			<td id="td2" style="width: 25%"><span style="font-size:10px">
				<?php echo utf8_encode("Motivo de la notificación:")?></span>
			</td>
			<td id="td1" style="width: 25%"><span style="font-size:10px"><?php 
			$ele_motivos = "";
			if ($total_motivos >0) do {
				$ele_motivos .= $row_motivos ['nombre'].", ";
			}while($row_motivos = mysql_fetch_assoc($motivos));			
			
			$ele_motivos = trim($ele_motivos,", "); //elimina la ultima coma
			echo $ele_motivos."."; 
			?>
				</span>
			</td>
			<td colspan = 1 id="td2" style="width: 25%"><span style="font-size:10px">
				<?php echo utf8_encode("Categoría del riesgo:")?></span>
			</td>
			<td  id="td1" style="width: 25%"><span style="font-size:10px">
<?php 
			$ele_riesgos = "";
			if ($total_riesgos >0) do {
				$ele_riesgos .= $row_riesgos ['nombre'].", ";
			}while($row_riesgos = mysql_fetch_assoc($riegos));			
			
			$ele_riesgos = trim($ele_riesgos,", "); //elimina la ultima coma
			echo $ele_riesgos."."; 
			?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan = 1 id="td2" style="width: 25%"><span style="font-size:10px">
				Nivel de riesgo:</span>
			</td>
			<td  id="td1" style="width: 25%"><span style="font-size:10px">
				<?php echo $row_nivel_riesgo['nombre'];?></span>
			</td>
			<td colspan = 1 id="td2" style="width: 25%"><span style="font-size:10px">
				<?php echo utf8_encode("Reglamentación:")?></span>
			</td>
			<td  id="td1" style="width: 25%"><span style="font-size:10px"><?php 
			$ele_reglamentacion = "";
			if ($total_reglamentacion >0) do {
				$ele_reglamentacion .= $row_reglamentacion ['nombre'].", ";
			}while($row_reglamentacion = mysql_fetch_assoc($reglamentacion));			
			
			$ele_reglamentacion = trim($ele_reglamentacion,", "); //elimina la ultima coma
			echo $ele_reglamentacion."."; 
			?></span>
			</td>
		</tr>
		<tr>
			<td  id="td2" style="width: 25%"><span style="font-size:10px">
				Nivel de alerta:</span>
			</td>
			<td id="td1" style="width: 25%"><span style="font-size:10px">
				<?php echo $row_nivel_alerta['nombre'];?></span>
			</td>
			<td  id="td2" style="width: 25%"><span style="font-size:10px">
				<?php echo utf8_encode("Resolución/Estatus:")?></span>
			</td>
			<td id="td1" style="width: 25%"><span style="font-size:10px">

<?php 
			$ele_resolucion_estatus = "";
			if ($total_resolucion_estatus >0) do {
				$ele_resolucion_estatus .= $row_resolucion_estatus ['nombre'].", ";
			}while($row_resolucion_estatus = mysql_fetch_assoc($resolucion_estatus));			
			
			$ele_resolucion_estatus = trim($ele_resolucion_estatus,", "); //elimina la ultima coma
			echo $ele_resolucion_estatus."."; 
			?>
</span>
			</td>
		</tr>
	</table>

</page>