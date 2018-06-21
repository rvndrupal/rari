<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); ?>
<?php include('gestionCatalogos.php'); ?>
<!--Se agrega require, para llamar a la opción de gráficos. Desarrollado por Rodrigo Villanueva. 6-Junio-2018 -->
<?php require('php/consultasGraficos.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantillaBase.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Documento sin título</title>
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="head" -->
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="regionEstilos" -->
                            
		<link href="css/estilocomun.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<!-- Carga CSS con estilos para gráficas. Desarrollado por Rodrigo Villanueva. 6-Junio-2018 -->
		<link rel="stylesheet" href="src/css/graficas.css">

		<?php include('Connections/variables.php');?>	
		<?php 
			$pagina='form';
			include('php/controlTemas.php'); 

			$rol=$_SESSION['idRol'];
			$area=$_SESSION['area'];
			$nivel=$_SESSION['nivel']; 

			/*
			if($_GET['mod']==0&&$rol!=1)
			{
				$MM_restrictGoTo = "bienvenido.php";
				header("Location: ". $MM_restrictGoTo);
			}
			*/
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
				<input type="hidden" id="info_row" value="0" />
				<input type="hidden" id="tab_select" value="0" />
				<div class="etiqueta-der" onclick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
					<div class="recuadro-interior">
						Salir
					</div> 
					<span class="triangulo-der"></span>
				</div>
 
				<div id="volver-menu" class="etiqueta" onclick="window.location='menu.php?mod=<?php echo $modulo; ?>';">
					<div class="recuadro-interior">
						Volver al menú
					</div> 
					<span class="triangulo-izq"></span>
				</div>
 
				<!-- Código nuevo. Filtros gráficas. LVC - RV. 6-Junio-2018 -->
				<div class="etiqueta" style="width:500px">
					<div class="recuadro-interior" style="text-align:right">
						Estadísticas en <?php echo $etiqueta;?>
					</div> 
					<span class="triangulo-izq"></span>
				</div>
				<!-- Termina código nuevo. -->
 
				<div class="cuadro-modulo-chico"> 
					<div class="recuadro-interior" style="height:100px; font-size:10px;">
						<table align="center" width="100%" height="100%">
							<tr><td height="100%" ><div id="imagen-cuadro-peq" class="imagen-cuadro-modulo"></div></td></tr>
						</table>
					</div>
				</div>
    
				<div class="lineasverticales"></div>  

				<form name="filtros" id="filtros">
					<table align="center">
						<tr><td colspan="4">Especifique un periodo para mostrar resultados:</td></tr>
						<tr>
							<!-- Se agrega codigo nuevo, para filtros de imágenes. LVC -RV 6-Junio-2018 -->
							<tr>
								<td>Selecciona un Area <select name="comArea" id="comArea">
									<option value="todos">Todas la Gráficas</option>
									<option value="ccEM">Comunicados Emitidos</option>
									<option value="ttCU">Tipos de Comunicados</option>
									<option value="ccPE">Comunicados por Estado</option>
									<option value="ccRE">Comunicados por nivel de Riesgo</option>
									<option value="ccAL">Comunicados por nivel de Alerta</option>
									<option value="ccES">Catálogo por Estatus</option>
									<option value="ccAA">Catálogo por Areas</option>
								</select></td>
							</tr><br>
							<!-- Termina código nuevo. -->
							<td>Fecha Inicio: <input onchange="filtrarFecha(<?php echo $modulo;?>)" id="date0" readonly="readonly" type="text" name="date0" class="tcal" value="<?php echo date("Y-m-d"); ?>" /></td><td>Fin: <input onchange="filtrarFecha(<?php echo $modulo;?>)" id="date1" readonly="readonly" type="text" name="date1" class="tcal" value="<?php echo date("Y-m-d"); ?>" /></td><td><input type="button" onclick="consultarGraficos()"  value="Consultar"/><input type="button" onclick="mostrarPDF()"  value="Descargar"/><input type="hidden" name="area" value="<?php echo $_GET['mod']; ?>" /></td>
						</tr>
					</table>
				</form>
				<table align="center" width="95%">
					<tr>
						<td width="100%">
							<div id="graficas"></div>
						</td>
					</tr>
				</table>
   
			<!-- InstanceEndEditable --></div>
			<div id= "footer" ></div>
		</div>
	</body>
<!-- InstanceEnd --></html>