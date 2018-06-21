<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); ?>
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
						Administración de usuarios
					</div> 
					<span class="triangulo-izq"></span>
				</div>
				<div class="lineasverticales"></div>
				<table align="center" width="100%">
					<tr><td width="95%" align="center">  
							<div id="tablaUsuarios" style="width:85%;"> 
								<?php $page= 'consultaUsuarios.php';   
									include($page); ?>  
							</div>
					</td></tr>
					<tr><td align="center">
							<input type="button" id="btnAgregarUsuario" value="Agregar nuevo" />
					</td></tr>
				</table>
  
				<div id="popupUsuarios" class="popup">
					<div class="interior">
						<div class="etiqueta" style="width:180px">
							<div class="recuadro-interior">
								>> Nuevo usuario
							</div> 
						</div>
						<form name="formInsertarUsuarios" action="<?php echo $editFormAction; ?>" method="POST" id="formInsertarUsuarios">
							<table>
								<?php if($_SESSION['idRol']==1){?>
								<tr >
									<td colspan="3" align="right">
										Área: <select name="cmbArea" id="cmbArea" style="width:300px">
										<?php 
											mysql_select_db($database_rari_coneccion, $rari_coneccion);
											$query_areas = "SELECT id, nombre FROM tbl_areas";
											$areas = mysql_query($query_areas, $rari_coneccion) or die(mysql_error());
											$row_areas = mysql_fetch_assoc($areas);
											$totalRows_areas = mysql_num_rows($areas);
			  
											do
											{
												echo '
													<option value="'.$row_areas['id'].'" >'.utf8_encode($row_areas['nombre']).'</option>';
											}
											while ($row_areas = mysql_fetch_assoc($areas));		  
										?></select>      
									</td>
								</tr>
    
								<?php }?>
								<tr >                    
									<td colspan="3" align="right">    
										Rol: 
										<select name="cmbRol" id="cmbRol" onchange="actualizaMpio(this.value)" style="width:300px">
											<?php 
												mysql_select_db($database_rari_coneccion, $rari_coneccion);
												$query_areas = "SELECT id, nombre FROM tbl_roles where id<>1";
												if($_SESSION['idRol']==1)
													$query_areas = "SELECT id, nombre FROM tbl_roles";

												$areas = mysql_query($query_areas, $rari_coneccion) or die(mysql_error());
												$row_areas = mysql_fetch_assoc($areas);
												$totalRows_areas = mysql_num_rows($areas);
			  
												do
												{
													echo '
														<option value="'.$row_areas['id'].'" >'.utf8_encode($row_areas['nombre']).'</option>';
												}
												while ($row_areas = mysql_fetch_assoc($areas));
											?>     
										</select>
									</td>
								</tr> 
    
								<tr >                    
									<td colspan="3" align="right">
										<div id="divMpio">
											Nivel de acceso:
											<select name="cmbNivel" id="cmbNivel" style="width:300px">
												<option value="1">1.- Registro, Consulta, Modificación, Eliminación</option>
												<option value="2">2.- Registro, Consulta </option>
												<option value="3">3.- Consulta </option>
											</select>
										</div>
									</td>
								</tr>   
    
								<tr><td colspan="3" align="right">Nombre: <input type="text" id="txtNombre" name="txtNombre" style="width:300px;" /></td></tr>     
								<tr><td colspan="3" align="right">Apellidos: <input type="text" id="txtApellidos" name="txtApellidos" style="width:300px;" /></td></tr>     
        
								<tr><td colspan="3" align="right">Usuario: <input type="text" id="txtUsuario" name="txtUsuario" style="width:300px;" /></td></tr>   
								<tr><td colspan="3" align="right">Contraseña: <input type="text" id="txtPass" name="txtPass" style="width:300px;" /></td></tr>     
           
								<tr>
									<td colspan="2" align="right">
										<div id="errorUsuario" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;"> 
											<div class="recuadro-interior">
												Error del usuario </div>
										</div>
										<hr/>

										<input type="button" value="Cancelar" id="pBtnCancelarUser"><input type="button" value="Agregar..." id="pBtnAgregarUser">
									</td>
								</tr>
							</table>
							<input type="hidden" name="MM_insert" value="formInsertarUsuarios" />
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
<?php
mysql_free_result($areas);
?>