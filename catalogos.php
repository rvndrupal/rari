<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); ?>
<?php include('gestionCatalogos.php'); ?>
<?php include('Connections/variables.php');?>
<?php
	if (!function_exists("GetSQLValueString")) 
	{
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
			if (PHP_VERSION < 6) 
			{
				$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}

			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

			switch ($theType) 
			{
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;    
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					break;
				case "double":
					$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
					break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
					break;
			}
			return $theValue;
		}
	}

	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) 
	{
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
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
		<?php 
			$pagina="form";
			include('php/controlTemas.php'); 
			establecerColores($color_vegetal_primario,$color_animal_primario,$color_inocuidad_primario,$color_inspeccion_primario,$color_sanidad_primario,$color_noticias_primario);

			$rol=$_SESSION['idRol'];
			$area=$_SESSION['area'];
			
			// Se agrega código para redireccionar a los usuarios consultores 2, que no tienen permisos para entrar a módulo administrador. LVC 18-Mayo-2018
			if ($rol === '5')
			{
				header("Location: principal.php"); 
				exit;
			}
			// Termina código nuevo.
		?>
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="plugins/popups.js"></script>
		<SCRIPT>
			function boton(id)
			{
				alert("Seleccionaste el id "+id);
			}
		</SCRIPT>
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
				<input type="hidden" id="prueba_a" name="prueba_a" value="<?php echo $area;?>" />
				<input type="hidden" id="prueba_b" name="prueba_b" value="<?php echo $rol;?>" />
				<input type="hidden" id="elemento" name="elemento" value="1" />
				<input type="hidden" id="capa" name="capa" value="" />
				<div class="lineasverticales"></div>
 
				<div class="etiqueta-der" onclick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
					<div class="recuadro-interior">Salir</div> 
					<span class="triangulo-der"></span>
				</div>
				
				<div id="volver-menu" class="etiqueta" onclick="window.location='bienvenido.php';" >
					<div class="recuadro-interior">
						Volver al menú
					</div> 
					<span class="triangulo-izq"></span>
				</div>
				<div class="etiqueta" style="width:500px">
					<div class="recuadro-interior" style="text-align:right">
						Administración de catálogos
					</div> 
					<span class="triangulo-izq"></span>
				</div>
				<div class="lineasverticales"></div>
				
				<table align="center" width="90%">
					<tr><td width="95%" align="center">
							<table width="100%">
								<tr>
									<td width="34%" align="center">
										<div class="recuadro-interior" style="color:#222">
											<?php if($area==2||$area==5) echo 'Hospedero/Especie';
												else if($area==3||$area==4) echo "Producto";
												else echo "Hospedero";
											?>
											<br />
											<div id="Productos">
												<?php echo obtenerCatalogoSelect(1,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(1,'productos');" value="Editar" /><input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(1);" value="Agregar" />
										</div>
									</td>
									<td width="66%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Oisas
											<br />
											<div id="Oisas">
												<?php echo obtenerCatalogoSelect(2,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(2,'oisas');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(2);" value="Agregar" />
										</div>
									</td>
								</tr>
								<tr height="30px">
									<td colspan="2"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td width="100%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Problema/Agente Causal
											<br />
											<div id="Agentes">
												<?php echo obtenerCatalogoSelect(3,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(3,'agentes');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(3);" value="Agregar" />
										</div>
									</td>
								</tr>
								<tr height="30px">
									<td colspan="1"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td  width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											PVI'S<br />
											<div id="PVISss">
												<?php echo obtenerCatalogoSelect(4,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(4,'pvis');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(4);" value="Agregar" />
										</div>
									</td>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											PVIF'S
											<br />
											<div id="PVIFSs">
												<?php echo obtenerCatalogoSelect(5,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(5,'pvifs');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(5);" value="Agregar" />
										</div>
									</td>
								</tr>
								<tr height="30px">
									<td colspan="2"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<?php if($area==4){?>
									<td width="100%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Fracción arancelaria
											<br />
											<div id="Fraccion">
												<?php echo obtenerCatalogoSelect(6,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(6,'fraccion');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(6);" value="Agregar" />
										</div>
									</td>
									<?php }?>
								</tr>
								<tr height="30px">
									<td colspan="1"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											<?php if($area==4)echo 'Medidas implementadas'; else echo 'Medidas implementadas'; ?>
											<br />
											<div id="Mimplementadas">
												<?php echo obtenerCatalogoSelect(7,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(7,'med_implementadas');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(7);" value="Agregar" />
										</div>
									</td>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											<?php if($area==4)echo 'Medidas a implementar'; else echo 'Medidas a implementar'; ?>
											<br />
											<div id="Mimplementar">
												<?php echo obtenerCatalogoSelect(8,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(8,'med_aimplementar');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(8);" value="Agregar" />
										</div>
									</td>
								</tr>
								<tr height="30px">
									<td colspan="2"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<?php if($area!=3){?>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Motivos de notificación
											<br />
											<div id="Motivos">
												<?php echo obtenerCatalogoSelect(9,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(9,'motivos');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(9);" value="Agregar" />
										</div>
									</td>
									<?php }?>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Categorias del Riesgo
											<br />
											<div id="Riesgos">
												<?php echo obtenerCatalogoSelect(10,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(10,'riesgo');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(10);" value="Agregar" />
										</div>
									</td>
								</tr>
								<tr height="30px">
									<td colspan="2"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>    	
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											<?php if($area==3)echo 'Regulación Nacional'; else echo 'Reglamentación';  ?>
											<br />
											<div id="Reglamentacion">
												<?php echo obtenerCatalogoSelect(11,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(11,'reglamentacion');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(11);" value="Agregar" />
										</div>
									</td>
									<?php if($area==3){?>
									<td width="50%" align="center">
										<div class="recuadro-interior" style="color:#222">
											R. internacional
											<br />
											<div id="Rinternacionals">
												<?php echo obtenerCatalogoSelect(12,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(12,'reglamentacion_int');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(12);" value="Agregar" />
										</div>
									</td>
									<?php }?>
								</tr>
								<tr height="30px">
									<td colspan="3"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td width="34%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Resolución
											<br />
											<div id="Resolucion">
												<?php echo obtenerCatalogoSelect(13,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(13,'resolucion');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(13);" value="Agregar" />
										</div>
									</td>
									<?php if($area!=3&&$area!=4){?>
									<td width="66%" align="center">
										<div class="recuadro-interior" style="color:#222">
											<?php if($area==5) echo "Estatus sanitario"; else echo "Estatus fitosanitario"; ?>
											<br />
											<div id="Estatus">
												<?php echo obtenerCatalogoSelect(14,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(14,'estatus');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(14);" value="Agregar" />
										</div>
									</td>
									<?php }?>
								</tr>
								<tr height="30px">
									<td colspan="2"> </td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td width="33%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Nivel de riesgo
											<br />
											<div id="N_Riesgo">
												<?php echo obtenerCatalogoSelect(15,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(15,'nivel_riesgo');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(15);" value="Agregar" />
										</div>
									</td>
									<td width="33%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Nivel de alerta
											<br />
											<div id="N_Alerta">
												<?php echo obtenerCatalogoSelect(16,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(16,'nivel_alerta');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(16);" value="Agregar" />
										</div>
									</td>
									<td width="34%">
									</td>
								</tr>
								<tr height="30px">
									<td colspan="3"> </td>
								</tr>
								<tr>    	
									<?php if($area>95){?>
									<td width="33%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Comunicados
											<br />
											<div id="Comunicados">
												<?php echo obtenerCatalogoSelect(17,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(17,'comunicados');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(17);" value="Agregar" />
										</div>
									</td>
									<?php }?>
									<?php if($area==3){ ?>
									<td width="33%" align="center">
										<div class="recuadro-interior" style="color:#222">
											Contaminación
											<br />
											<div id="Contaminacion">
												<?php echo obtenerCatalogoSelect(18,$database_rari_coneccion,$rari_coneccion,$area);?>
											</div>
											<hr/>
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(18,'contaminacion');" value="Editar" />
											<input type="button" id="btnAgregarUsuario" onclick="LanzarPopUp(18);" value="Agregar" />
										</div>
									</td>
									<?php }?>
									<td width="34%">
									</td>
								</tr>
							</table> 
					</td></tr>
					<tr><td align="center">
					</td></tr>
				</table>
				<div id="popupCatalogos" class="popup">
					<div class="interior">
						<div class="etiqueta" style="width:250px">
							<div id="titulo_catalogo" class="recuadro-interior">
								>> Nuevo usuario
							</div> 
						</div>
						<form >
							<table>
								<tr><td colspan="3" align="right">Nombre: <input type="text" id="txtNombre" name="txtNombre" style="width:300px;" /></td></tr> 
								<!-- Se modifica para agregar funcionalidad de activación/desactivación de elementos del catálogo. LVC 14-Mayo-2018 -->
								<tr><td><div id="estatusRegistro" align="center"></div>
								<!-- Termina código nuevo. -->
								<tr id="ncientifico"><td colspan="3" align="right">Nombre científico: <input type="text" id="txtNcientifico" name="txtNcientifico" style="width:300px;" /></td></tr>     
								<tr>
									<td colspan="2" align="right">
										<div id="nota" style="color:#C30; display:none; text-align:center;">
											Caracter de separación: $
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<div id="errorCatalogo" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;"> 
											<div class="recuadro-interior">
												Error catalogo</div>
										</div>
										<hr/>
										<input type="button" value="Cancelar" id="pBtnCancelarCatalogo"><input type="button" value="Agregar..." id="pBtnAgregarCatalogo">
										<input type="hidden" id="udpId" value="0" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				
				<!--
				<table align="center">
					<tr>
						<td><div id="loginimagecenter"></div></td>
					</tr>
				</table>
				-->
				
				<div class="lineasverticales"  style="height:100px;"></div>   
			<!-- InstanceEndEditable --></div>
  			<div id= "footer" ></div>
		</div>
	</body>
<!-- InstanceEnd --></html>