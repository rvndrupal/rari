<?php
	if(!isset($_SESSION['nombre']))
	{
		$MM_restrictGoTo = "index.php";
		header("Location: ". $MM_restrictGoTo); 
		exit;
	}

	require_once('Connections/rari_coneccion.php');
	date_default_timezone_set('America/Mexico_City');
	require_once('php/grafica.php'); ?>
<?php require_once('php/grafica1.php'); ?>
<?php require_once('php/grafica2.php'); ?>
<?php require_once('php/grafica3.php');
	//Se agrega código para funcionalidad de gráficas. LVC y RV 6-Junio-2018
	require_once('php/grafica4.php'); 
	require_once('php/grafica5.php'); 
	require_once('php/grafica6.php'); 

	/*
	$fechaI="2014-03-01";
	$fechaF="2014-04-02";
	$fechaE="2014-04-02";
	$area=0;*/

	$datosArea=consultarNombreArea($area,$database_rari_coneccion, $rari_coneccion);

	obtenerGraficoCircular($area, $fechaI, $fechaF, 0, $database_rari_coneccion, $rari_coneccion);
	obtenerGraficoCircular($area, $fechaI, $fechaF, 1, $database_rari_coneccion, $rari_coneccion);
	obtenerGraficoCircular($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
	obtenerGraficoBarras($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
	obtenerStackEstados($area,$fechaI, $fechaF,$database_rari_coneccion, $rari_coneccion);

	//Se agrega código para funcionalidad de gráficas. LVC y RV 6-Junio-2018
	//grafica 4
	obtenerGraficoEmitidos($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
	//grafica 5
	obtenerGraficoEstatus($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
	//grafico 6
	obtenerGraficoAreas($area, $fechaI, $fechaF, 0, $database_rari_coneccion, $rari_coneccion);
?>

<page style="font-size: 10pt">
	<table align="center">
		<tr><td colspan="2">
				<img src="imagenes/cabeceraReporte.jpg" />
		</td></tr>
		<tr>
			<td colspan="2" align="center">
				<span style="font-size:18px">
					Informe Estadístico de la Red de Alerta Rápida Interna
				</span>
				<br/>
				<span style="color:#333; font-size:16px; margin-top:1px;">
					<?php echo $datosArea[0] ?>
				</span>
				<br/>
				<span style="color:#999; margin-top:5px;">
					(<?php 
						if($fechaI!=$fechaF)
							echo 'Del día '.fecha($fechaI).' al día '.fecha($fechaF);
						else 
							echo 'Del día '.fecha($fechaI);
					?>)
				</span>
			</td>
		</tr>
		<tr>
			<td height="31px" align="right" colspan="2">
				<div style="height:30px; width:50px; float:right; margin-right:-100px; background-color:<?php echo $datosArea[1] ?>; border-radius:3px;"></div>
			</td>
		</tr>
		<tr>
			<td align="center" width="500px">
				<span style="color:#999; margin-bottom:3px;">
					Tipos de comunicados
				</span>
				<br/>
				<!--<img src="tmps/graf2.jpeg" width="370" height="220"/>-->
				<img src="tmps/graf2.jpeg" width="700" height="320"/>
			</td>
		</tr>
		<tr>
			<td align="center" width="500px" style="border-left:#999 dashed 1px;">
				<!--<span style="color:#999; margin-bottom::3px;">-->
				<span style="color:#999; margin:100px 0 0 0;">
					Tipos de comunicados
				</span>
				<br/>
				<!-- <img src="tmps/gTipoComunicados.jpeg" width="370" height="220"/> -->
				<img src="tmps/gTipoComunicados.jpeg" style="margin:110px 0 0 0;" width="380" height="270"/>
			</td>
		</tr><!--LAS DOS PRIMERAS-->
		<tr>
			<!-- <td align="center" colspan="2"> -->
			<td colspan="2">
				<img src="tmps/graf3.jpeg" width="700" height="300"/>
				<br/>
				<!-- <span style="color:#999; margin-top:-15px;"> -->
				<span style="color:#999; margin:0px 0 0 280px;">
					Comunicados por estados
				</span>
			</td>
		</tr>
		<!--Grafica tres-->
		<!--Cuatro-->
		<tr>
			<td  colspan="2">
				<img src="tmps/graf4.jpeg" width="750" height="400"/>
				<br/>
				<span style="color:#999; margin:15px 0 0 280px;">
					Comunicados Emitidos
				</span>
			</td>
		</tr>
		<!--Cuatro-->
		<!--cinco-->
		<tr >
			<td align="center" width="500px" style="border-top:#999 dashed 1px;">
				<!-- <img src="tmps/gNivelRiesgo.jpeg" width="370" height="220"/> -->
				<img src="tmps/gNivelRiesgo.jpeg" width="470" height="320"/>
				<br/>
				<!-- <span style="color:#999; margin-top:-25px;"> -->
				<span style="color:#999; margin-top:20px;">
					Comunicados por nivel de riesgo
				</span>
			</td>
		</tr>
		<!--cinco-->
		<!--seis-->
		<tr >
			<td align="center" width="500px" style="border-top:#999 dashed 1px;">
				<img src="tmps/graf5.jpeg" width="750" height="530"/>
				<br/>
				<span style="color:#999; margin-top:20px;">
					Catálogo por Estatus
				</span>
			</td>
		</tr>
		<!--seis-->
		<!--siete-->
		<tr>
			<td align="center" width="500px" style="border-top:#999 dashed 1px;">
				<!-- <img src="tmps/gNivelAlerta.jpeg" width="370" height="220"/> -->
				<img src="tmps/gNivelAlerta.jpeg" width="470" height="320"/>
				<br/>
				<span style="color:#999; margin-top:-25px;">
					Comunicados por nivel de alerta
				</span>
			</td>
		</tr>
		<!--siete-->
		<!--ocho-->
		<tr>
			<td align="center" width="500px" style="border-top:#999 dashed 1px;">
				<img src="tmps/graf6.jpeg" width="700" height="500"/>
				<br/>
				<span style="color:#999; margin:0 0 100px 0px;">
					Catálogo por Areas
				</span>
			</td>
		</tr>
		<!--ocho-->
		<tr >
			<td align="center" colspan="2">
				<div style="height:10px; width:100%; background-color:<?php echo $datosArea[1] ?>;"></div>
			</td>
		</tr>
		<tr>
			<td>
				<span style="color:#555; font-size:10px">
					<br><br><br><br>
					<?php echo $datosArea[0] ?>
					<br/>
				</span>
				<span style="color:#BBB; font-size:9px">
					Reporte generado por el sistema a petición de: <?php echo $_SESSION['nombre']; ?>
				</span>
			</td>
			<td colspan="" align="right">
				<!-- <span style="color:#555; font-size:10px"> -->
				<span style="color:#555; font-size:10px; margin:3px 0 0 -250px;">
					Fecha de emisión: <?php echo fecha();?>
					<br/>
				</span>
				<!-- <span style="color:#BBB"> -->
				<span style="color:#BBB; margin:0 0 0 -250px">
					RARI 2014
				</span>
			</td>
		</tr>
	</table>
</page>