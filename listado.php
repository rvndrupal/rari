<?php 
	date_default_timezone_set('America/Mexico_City');
	require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); ?>
<?php include('Connections/variables.php');?>
<?php include('gestionCatalogos.php'); 

	if(isset($_GET['mod']))
		$mod=$_GET['mod'];
	else
		$mod=$_SESSION['area'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantillaBase.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- InstanceBeginEditable name="doctitle" -->
		<link href="imagenes/tipo_comunicados/rari-icono.png" type="image/x-icon" rel="shortcut icon" />
		<title>RARI-SENASICA</title>
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="head" -->
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="regionEstilos" -->
									
		<link href="css/estilocomun.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
			
		<?php 
			$pagina="form";

			if(isset($_GET['emitir']))
			{
				$emitir=$_GET['emitir'];
				if($emitir!=1&&$emitir!=0)
				{
					$GoTo = "bienvenido.php";			
					header(sprintf("Location: %s", $GoTo));
				}
			}
			else if($_GET['mod']==0)
			{
				$MM_restrictGoTo = "bienvenido.php";
				header("Location: ". $MM_restrictGoTo);
			}

			include('php/controlTemas.php'); 

			$rol=$_SESSION['idRol'];
			$area=$_SESSION['area'];
			$nivel=$_SESSION['nivel']; 
		?>
		
		<script type="text/javascript" src="js/tcal.js"></script> 
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="plugins/popups.js"></script>
		<script type="text/javascript"></script>

		<!-- InstanceEndEditable -->
		<!--[if lte IE 7]>
		<style>
		.content { margin-right: -1px; } /* este margen negativo de 1 px puede situarse en cualquiera de las columnas de este diseño con el mismo efecto corrector. */
		ul.nav a { zoom: 1; }  /* la propiedad de zoom da a IE el desencadenante hasLayout que necesita para corregir el espacio en blanco extra existente entre los vínculos */
		</style>
		<![endif]-->
	</head>

	<body>
		<div id="cuerpo">
			<div id="header">
				<div id="encabezado"> </div>
				<div id="rari_tit"><?php echo $encabezadoURL; ?></div>
			</div>
	  
			<div id="menu"></div>
	  
			<div id="contenido"><!-- InstanceBeginEditable name="RegionCuerpo" --> 
				<div class="lineasverticales"></div>
				<?php if(isset($_GET["updt"])){?>
				<input type="hidden" id="update" value="1"/>
				<?php } ?>
				<input type="hidden" id="info_row" value="0" />
				<input type="hidden" id="tab_select" value="0" />
				<input type="hidden" id="rol" value="<?php echo $_SESSION['idRol'] ?>" />
				<input type="hidden" id="ar_select" value="<?php echo $mod; ?>" />
				<input type="hidden" id="us_select" value="<?php echo $_SESSION['id'] ?>" />
				<div class="etiqueta-der" onclick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
					<div class="recuadro-interior">
						Salir
					</div> 
					<span class="triangulo-der"></span>
				</div>
	 
				<?php $volverA="menu.php?mod=".$modulo;
					if(isset($emitir))
						$volverA="bienvenido.php";
				?>
				<div id="volver-menu" class="etiqueta" onclick="window.location='<?php echo $volverA; ?>';">
					<div class="recuadro-interior">
						Volver al menú
					</div> 
					<span class="triangulo-izq"></span>
				</div>
	 
				<div class="etiqueta" style="width:500px">
					<div class="recuadro-interior" style="text-align:right">
						<?php
							if(isset($emitir))
							{
								if($emitir==0)
									echo "Autorización de comunicados";
								else
									echo "Comunicados emitidos";
							}
							else
								echo "Lista de comunicados en ".$etiqueta;
							
							if(isset($emitir))
								$cad_emitir=",".$emitir;
							else
								$cad_emitir=""; 
	  
							$cad_emitir=$modulo.$cad_emitir;
						?>
					</div> 
					<span class="triangulo-izq"></span>
				</div>
	 
				<div class="cuadro-modulo-chico"> 
					<div class="recuadro-interior" style="height:100px; font-size:10px;">
						<table align="center" width="100%" height="100%">
							<tr><td height="100%" ><div id="imagen-cuadro-peq" class="imagen-cuadro-modulo"></div></td></tr>
						</table>
					</div>
				</div>
	  
				<input type="hidden" name="rol" value="<?php echo $_SESSION['idRol'];?>">
				
				<div class="lineasverticales"></div>
				
				<table align="center">
					<!-- Código nuevo. Se agrega un buscador de comunicados por palabras clave. LVC 26-Abril-2017 -->
					<tr>
						<td align="right" colspan=3 >Buscar por palabras claves: <input type="text" name="txtBusPalClave" id="txtBusPalClave" onKeyUp="validaTxtBPC(<?php echo $cad_emitir;?>)" /></td></tr>
						<tr><td>&nbsp;&nbsp;</td></tr>
						<tr><td align="center" colspan=3 >Buscar por rango de fechas:</td></tr>
					<!-- Termina código nuevo-->					
					<td>Fecha Inicio: <input onchange="filtrarFecha(<?php echo $cad_emitir;?>)" id="date0" readonly="readonly" type="text" name="date0" class="tcal" value="<?php echo date("Y-m-d"); ?>" /></td><td>Fin: <input onchange="filtrarFecha(<?php echo $modulo;?>)" id="date1" readonly="readonly" type="text" name="date1" class="tcal" value="<?php echo date("Y-m-d"); ?>" /></td><td><input type="button" onclick="filtrarFecha(<?php echo $cad_emitir;?>)"  value="Consultar"/> <?php if(!isset($emitir)&&($rol!=0||$area==$mod)){?> <input id="dwl" type="button" onclick="descargarBitacora()"  value="Descargar"/> <?php }?>
					<?php if(!isset($emitir)){?><input id="verMapa" type="button" value="Ver mapa"/><input id="verMapaG" type="button" value="Ver mapa grande"/><?php }?></td></table>
				<div style="width:100%; height:50px;">
					<table align="center" width="60%">
						<tr>
							<td>
	 							<?php $cad=$modulo;
									if(isset($emitir))
										$cad=$cad.",".$emitir;
								?>	 
								<div title="Todos los tipos de comunicados" onclick="mover(0,<?php echo $cad;?>);" id="p_todos" style="background-image:url(imagenes/tipo_comunicados/todos.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo alertas" onclick="mover(1,<?php echo $cad;?>);" id="p_alerta" style="background-image:url(imagenes/tipo_comunicados/alerta.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo cuarentenas" onclick="mover(2,<?php echo $cad;?>);" id="p_cuarentena" style="background-image:url(imagenes/tipo_comunicados/cuarentena.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo información" onclick="mover(3,<?php echo $cad;?>);" id="p_informacion" style="background-image:url(imagenes/tipo_comunicados/informacion.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo noticias" onclick="mover(4,<?php echo $cad;?>);" id="p_noticia" style="background-image:url(imagenes/tipo_comunicados/noticia.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo rechazos" onclick="mover(5,<?php echo $cad;?>);" id="p_rechazo" style="background-image:url(imagenes/tipo_comunicados/rechazo.png)" class="pestana"></div>
							</td>
							<td>
								<div title="Sólo retenciones" onclick="mover(6,<?php echo $cad;?>);" id="p_retencion" style="background-image:url(imagenes/tipo_comunicados/retencion.png)" class="pestana"></div>
							</td>
						</tr>
					</table>
				</div>
				<div style="width:100%; height:20px;">
					<div id="seleccionador" class="triangulo_inf"></div>
				</div>
	 
				<table align="center" width="95%">
					<tr><td><div class="recuadro-interior" style="margin-top:-20px;">	 
								<div id="tabla_comunicados" style="width:100%; background-color:#FFF;">
									<?php include('listado_comunicados.php'); ?>
								</div>
							</div>
							<input type="hidden" id="naction" value="<?php 
								if(isset($emitir))
									echo $emitir; ?>" />
					</td></tr>	 
				</table>
				
				<div id="popupMapa" class="popup" style="width:770px">
					<div id="contentMapa" class="recuadro-interior">
						<div class="etiqueta" style="width:250px;">
							<div id="titulo_catalogo" class="recuadro-interior">
								>> Localización
							</div> 
						</div>
						<div id="capaMapa" style="width:745px; height:350px;"></div>
					</div>
				</div>
	   
			<!-- InstanceEndEditable --></div>
			<div id= "footer" ></div>
		</div>
	</body>
<!-- InstanceEnd --></html>