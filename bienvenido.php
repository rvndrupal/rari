<?php include('php/restriccionAcceso.php'); ?>
<?php include('Connections/variables.php');?>
<?php require_once('Connections/rari_coneccion.php'); ?>
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
		
		<!-- <link href="css/estilocomun.css" rel="stylesheet" type="text/css" /> -->
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<link rel="stylesheet" type="text/css" href="css/estilocomun.css" /> 
		
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="plugins/popups.js"></script>
		<script type="text/javascript" src="js/tcal.js"></script> 

		<?php 
			$pagina="index";
			include('php/controlTemas.php'); 
			establecerColores($color_vegetal_primario,$color_animal_primario,$color_inocuidad_primario,$color_inspeccion_primario,$color_sanidad_primario,$color_noticias_primario);

			$rol=$_SESSION['idRol'];
			$area=$_SESSION['area'];
			$nivel=$_SESSION['nivel']; 
			
			/*
			$rol=1;
			$area=6;
			$nivel=1; 
			*/
			
			// Se agrega código para redireccionar a los usuarios consultores 2, que no tienen permisos para entrar a módulo administrador. LVC 18-Mayo-2018
			if ($rol === '5')
			{
				header("Location: principal.php"); 
				exit;
			}
			// Termina código nuevo.
		?>

		<!-- InstanceEndEditable -->
		<!--[if lte IE 7]>
		<style>
		.content { margin-right: -1px; } /* este margen negativo de 1 px puede situarse en cualquiera de las columnas de este diseño con el mismo efecto corrector. */
		ul.nav a { zoom: 1; }  /* la propiedad de zoom da a IE el desencadenante hasLayout que necesita para corregir el espacio en blanco extra existente entre los vínculos */
		</style>
		<![endif]-->
	</head>

	<body>
	<!-- Se crearán modificaciones para los nuevos niveles asignados. 5-Junio-2018 -->
		<div id="cuerpo">
			<div id="header">
				<div id="encabezado"> </div>
				<div id="rari_tit"><?php echo $encabezadoURL; ?></div>
			</div>		  
			<div id="menu"></div>
			<div id="contenido"><!-- InstanceBeginEditable name="RegionCuerpo" --> 
				<div class="lineasverticales"></div>
				<div class="etiqueta-der" onclick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
					<div class="recuadro-interior">Salir</div> 
					<span class="triangulo-der"></span>
				</div>				
				<div class="etiqueta" style="width:50%; background-color:#030">
					<div class="recuadro-interior">
						Bienvenido <?php echo $_SESSION['nombre'];?> <input type="button" id="btnEditarUsuario" value="Editar Usuario" />
					</div> 
					<span class="triangulo-izq"></span>
				</div>
				<div class="lineasverticales"></div>
				<div class="etiqueta-completa" style="background-color:#030;">
					<div class="recuadro-interior" style="height:150px">
						<table align="center" width="80%">
							<tr>
								<!-- Autorizacion de comunicados habilitada para superadministrador y Enlace designado. LVC 5-Junio-2018-->
								<?php if($nivel==1 or $nivel==4){?>
								<td align="center">
									<div class="rectangulo-opciones" onclick="window.location='listado.php?emitir=0';">
									<!--<div class="rectangulo-opciones" onclick="window.location='http://10.24.17.53:567/listado.php?emitir=0';">-->
										<div class="recuadro-interior" style="height:116px; font-size:10px;">
											<table align="center" height="100%" width="100%">
												<tr><td height="75" ><div id="imagen-autorizacion-comunnicados" class="imagen-cuadro-modulo"></div></td></tr>
												<tr><td align="center">Autorización de comunicados</td></tr>
											</table>
									</div></div>	  
								</td>
								<?php }?>
								<td align="center">		  
									<div class="rectangulo-opciones" onclick="window.location='listado.php?emitir=1';">
										<div class="recuadro-interior" style="height:116px; font-size:11px;">
											<table align="center" height="100%" width="100%">
												<tr><td height="75" ><div id="imagen-listado-comunnicados" class="imagen-cuadro-modulo"></div></td></tr>
												<tr><td align="center">Comunicados emitidos</td></tr>
											</table>
								</div></div>		  
								</td>
								<!-- Gestion de catálogos habilitada para superadministrador y Representante de Área. LVC 5-Junio-2018-->
								<?php if($nivel==1 or $nivel==2){?>
								<td align="center">
									<div class="rectangulo-opciones"  onclick="window.location='catalogos.php?mod=<?php echo $_SESSION['area']; ?>';">
										<div class="recuadro-interior" style="height:116px; font-size:11px;">
											<table align="center" height="100%" width="100%">
												<tr><td height="75" ><div id="imagen-editar-catalogo" class="imagen-cuadro-modulo"></div></td></tr>
												<tr><td align="center">Gestionar catálogos</td></tr>
											</table>
									</div></div>
								</td>
								<?php }?>
								<td align="center">
									<div class="rectangulo-opciones" onclick="window.location='estadisticas.php?mod=0';">
										<div class="recuadro-interior" style="height:116px; font-size:10px;">
											<table align="center" height="100%" width="100%">
												<tr><td height="75" ><div id="imagen-estadisticas" class="imagen-cuadro-modulo"></div></td></tr>
												<tr><td align="center">Estadísticas de comunicados</td></tr>
											</table>
									</div></div>
								</td>
								<?php if($nivel==1){?>
								<td align="center">
									<div class="rectangulo-opciones" onclick="window.location='cats.php?mod=<?php echo $_SESSION['area']; ?>';">
										<div class="recuadro-interior" style="height:116px; font-size:11px;">
											<table align="center" height="100%" width="100%">
												<tr><td height="75" ><div id="imagen-directorio-usuarios" class="imagen-cuadro-modulo"></div></td></tr>
												<tr><td align="center">Directorio de usuarios</td></tr>
											</table>
									</div></div>
								</td>
								<?php }?>
							</tr>
						</table>
					</div>
					<span class="triangulo-izq"></span><span class="triangulo-der"></span>
				</div>		  
		  
				<!--
				<table align="center">
					<tr>
						<td><div id="loginimagecenter"></div></td>
					</tr>
				</table>
				-->
				<div class="lineasverticales"></div>		  
				<div id="iconos">
					<table align="center">
						<tr>
							<td>
								<a href="menu.php?mod=1">
								<div id="cuadro-vegetal" class="cuadro">
									<div class="recuadro-interior" style="height:110px; font-size:11px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-vegetal" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Sanidad vegetal</td></tr>
										</table>
									</div>
								</div>
								</a>
							</td>
							<td><div id="cuadro-animal" class="cuadro" onclick="window.location='menu.php?mod=2';">
									<div class="recuadro-interior" style="height:110px; font-size:11px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-animal" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Salud animal</td></tr>
										</table>
									</div>
							</div></td>
							<td><div id="cuadro-inocuidad" class="cuadro" onclick="window.location='menu.php?mod=3';">
									<div class="recuadro-interior" style="height:110px; font-size:11px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-inocuidad" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Inocuidad Agroalimentaria</td></tr>
										</table>
									</div>
							</div></td>
							<td><div id="cuadro-inspeccion" class="cuadro" onclick="window.location='menu.php?mod=4';">
									<div class="recuadro-interior" style="height:110px; font-size:11px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-inspeccion" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Inspección fitozoosanitaria</td></tr>
										</table>
									</div>
							</div></td>
							<td><div id="cuadro-sanidad" class="cuadro" onclick="window.location='menu.php?mod=5';">
									<div class="recuadro-interior" style="height:110px; font-size:10px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-sanidad" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Sanidad acuícola y pesquera</td></tr>
										</table>
									</div>
							</div></td>
							<td><div id="cuadro-noticias" class="cuadro" onclick="window.location='menu.php?mod=6';">
									<div class="recuadro-interior" style="height:110px; font-size:11px;">
										<table align="center" height="100%" width="100%">
											<tr><td height="75" ><div id="imagen-noticias" class="imagen-cuadro-modulo"></div></td></tr>
											<tr><td align="center">Comunicados internacionales</td></tr>
										</table>
									</div>
							</div></td>
						</tr>
					</table>		 
				</div>  
				<?php 
					$editFormAction = $_SERVER['PHP_SELF'];
					if (isset($_SERVER['QUERY_STRING'])) 
					{
						$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
					}
				?>    
			
				<div id="popupEditaUsuario" class="popup">
					<div class="interior">
						<div class="etiqueta" style="width:180px">
							<div class="recuadro-interior">
								>> Editar usuario
							</div> 
						</div>
						<form name="formEditaUsuario" action="<?php echo $editFormAction; ?>" method="POST" id="formEditaUsuario">		 
							<?php 
								mysql_select_db($database_rari_coneccion, $rari_coneccion);
								$mysql_obtener_datos_usuario = "select nombre as nombre, apellido, sexo, 
								fechaNacimiento, escolaridad, acceso_login, idEstado, idMunicipio, fechaNacimiento, escolaridad, dependencia from rari.tbl_usuarios u
								where u.id=" .$_SESSION['id']; 
				
								$datos_user =  mysql_query($mysql_obtener_datos_usuario, $rari_coneccion) or die(mysql_error());
								$row_user = mysql_fetch_assoc($datos_user);
							?>
							<table> 
							<!-- Modificaciones. LVC. Julio 2017.
									Se modifica la tabla, los elementos se acomodarán en otro orden. Los tres primeros elementos no serán editables.
									Se agrega función al campo de contraseña, para efectuar una validación. 
									Se agrega división,,donde se cargará la comprobación de contraseña.
									Se modifica fecha de nacimiento, para que el campo sea editable.
									Se agrega funcionalidad para que los municipios se actualicen de acuerdo al estado. -->
								<tr><td colspan="3" align="right">Usuario: <input type="text" id="txtUsuario" name="txtUsuario" style="background: rgb(187, 187, 187); width:290px;" readonly="readonly" background-color="gray" title="Este campo no se puede modificar" value="<?php echo $row_user['acceso_login'];?>"/></td></tr>
								<tr><td colspan="3" align="right">Nombre: <input type="text" id="txtNombre" name="txtNombre" style="background: rgb(187, 187, 187); width:290px;" readonly="readonly" title="Este campo no se puede modificar" value="<?php echo ($row_user['nombre']);?>"/></td></tr>
								<tr><td colspan="3" align="right">Apellidos: <input type="text" id="txtApellidos" name="txtApellidos" style="background: rgb(187, 187, 187); width:290px;" readonly title="Este campo no se puede modificar" value="<?php echo $row_user['apellido'];?>"/></td></tr>
								<tr><td colspan="3" align="right">Contraseña:<input type="password" id="txtPass" name="txtPass" style="width:290px;" onKeyPress="cargaConfContra(this.value)" onBlur="cargaConfContra(this.value)"/></td></tr>
								<tr><td><div id="myDiv"></div></td></tr>
								<tr><td colspan="3" align="right">Sexo:<input type="radio" id="rdiSexo" name="rdiSexo" style="width:100px;" value="1" <?php echo ($row_user['sexo']==1)? 'checked':'';?>/> hombre <input type="radio" id="rdiSexo" name="rdiSexo" style="width:100px;" value="2" <?php echo ($row_user['sexo']==2)? 'checked':'';?>/> Mujer</td></tr>
								<tr><td colspan="3" align="right">Fecha de nacimiento:<input id="dateFecha"  type="text" name="dateFecha" class="tcal" maxlength=10  value="<?php echo substr(( isset($row_user['fechaNacimiento'])? $row_user['fechaNacimiento']:date("Y-m-d")), 0, 10); ?>" /></td></tr>
								<tr><td colspan="3" align="right">Estado:<select id="cmbEstado" name="cmbEstado" style="width:290px;" onChange="actualizaMunicipio(this.value)" >
								<?php 
									$mysql_obtener_estados = "SELECT * FROM rari.tbl_estados;";
									$estados = mysql_query($mysql_obtener_estados, $rari_coneccion) or die(mysql_error());
									$row_estados = mysql_fetch_assoc($estados);
									
									do
									{
										echo '<option value="'.$row_estados['id'].'" ' .(($row_estados['id'] == $row_user['idEstado'])? "selected":"").' onSelect="load(this.value)" >'.$row_estados['nombre'].'</option>';
									}
									while ($row_estados = mysql_fetch_assoc($estados));			 
								?>								 
								</select></td></tr>
								<tr><td colspan="3" align="right">Municipio:<select id="cmbMunicipio" name="cmbMunicipio" style="width:290px;" >								 
								<?php
									$mysql_obtener_municipios = "SELECT * FROM rari.tbl_municipios where idEstado = '".$row_user['idEstado']."';";
									$municipios = mysql_query($mysql_obtener_municipios, $rari_coneccion) or die(mysql_error());
									$row_municipios = mysql_fetch_assoc($municipios);
												
									do
									{
										echo '<option value="'.$row_municipios['id'].'" ' .(($row_municipios['id'] == $row_user['idMunicipio'])? "selected":"").' >'.$row_municipios['nombre'].'</option>';
									}
									while ($row_municipios = mysql_fetch_assoc($municipios));
								?>
								</select>
								</td></tr>
							<!--Aqui termina código nuevo. LVC Julio 2017 -->
							<!-- Se comenta código siguiente, porque la actualización realizará la carga del combo.
								<tr><td colspan="3" align="right">Municipio:<select id="cmbMunicipio" name="cmbMunicipio" style="width:290px;" >
								 
								<?php 
									$mysql_obtener_municipios = "SELECT * FROM rari.tbl_municipios where idEstado = '".$row_user['idEstado']."';";
									$municipios = mysql_query($mysql_obtener_municipios, $rari_coneccion) or die(mysql_error());
									$row_municipios = mysql_fetch_assoc($municipios);
									
									do
									{
										echo '<option value="'.$row_municipios['id'].'" ' .(($row_municipios['id'] == $row_user['idMunicipio'])? "selected":"").' >'.utf8_encode($row_municipios['nombre']).'</option>';
									}
									while ($row_municipios = mysql_fetch_assoc($municipios));
								?>
								</select></td></tr>	-->
								<tr><td colspan="3" align="right">Dependencia:<input type="text" id="txtDependencia" name="txtDependencia" style="width:290px;" value="<?php echo $row_user['dependencia'];?>" /></td></tr>
								<tr>
									<td colspan="2" align="right">.
										<div id="errorUsuario" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;"> 
											<div class="recuadro-interior">
												Error del usuario </div>
										</div>
										<hr/>
										<input type="button" value="Cancelar" id="pBtnCancelarEditUser"><input type="button" value="Editar..." id="pBtnEditUser">
									</td>
								</tr>
							</table>							  
						</form>
					</div>
				</div>
				<!-- Nuevo código. Muestra información de seguimientos. LVC 23-Mayo-2018 -->
				<?php 
				
				
					$fin = 0;
				
					mysql_select_db($database_rari_coneccion, $rari_coneccion);	
					/*$mysql_obtener_titulo_comunicado = 'select com.id, com.titulo, com.fecha_registro, com.idnivelriesgo, com.idarea, com.folio, seg.idseguimiento ';
					$mysql_obtener_titulo_comunicado = $mysql_obtener_titulo_comunicado.'from tbl_comunicado com, tbl_seguimiento seg ';
					$mysql_obtener_titulo_comunicado = $mysql_obtener_titulo_comunicado.'where com.id = seg.idComunicado ';					
					$mysql_obtener_titulo_comunicado = $mysql_obtener_titulo_comunicado.'and com.seguimiento = 1 ';					
					$mysql_obtener_titulo_comunicado = $mysql_obtener_titulo_comunicado.'and com.idUsuario = '.$_SESSION['id'];*/

					$mysql_obtener_titulo_comunicado='SELECT * from tbl_comunicado
					where seguimiento=1
					and id in(select max(id) from tbl_comunicado GROUP by folio)
					ORDER BY 1';
					

					
					
					
					$datos_comunicado_seguimiento =  mysql_query($mysql_obtener_titulo_comunicado, $rari_coneccion) or die(mysql_error());
				
					$elementos_comunicado_seguimiento = mysql_num_rows($datos_comunicado_seguimiento);
				
					if ($elementos_comunicado_seguimiento > 0)
					{
						echo '<div id="popupMuestraSeg" class="popupSeg" >';
						$fin = 1;
					}
					
					$dateHoy = new DateTime('now');
				
					while($row_seguimiento = mysql_fetch_assoc($datos_comunicado_seguimiento))
					{
						$dateSeg = new DateTime($row_seguimiento['fecha_registro']);					
						echo '<div class="interiorSeg">';
					
						if ($row_seguimiento['idNivelRiesgo'] == 3)
						{
							echo '<div class="etiquetaSegAlta" style="width:500px" >';
						}
						else if ($row_seguimiento['idNivelRiesgo'] == 4)
						{
							echo '<div class="etiquetaSegMedia" style="width:500px" >';
						}
						else
						{
							echo '<div class="etiquetaSegOtra" style="width:500px" >';
						}
						
						echo '<div class="recuadro-interiorSeg">';
				
						echo '>> '.$row_seguimiento['titulo'];
						echo '</div>';
						echo '</div>';
						echo '<table>';
					
						$diff = $dateSeg->diff($dateHoy);
					
						echo '<tr><td colspan="3" align="right">'.$diff->days.' días de seguimientos </td></tr>';
						echo '<tr><td colspan="3" align="right">Folio: '.$row_seguimiento['folio'].'</td></tr>';
						echo '<tr><td colspan="3" align="right">Enlace:  <a href="seguimiento.php?mod='.$row_seguimiento['idArea'].'&comunicado='.$row_seguimiento['id'].'&foliob='.$row_seguimiento['folio'].'" >Ir al seguimiento </a></td></tr>';
						echo '</table>';
						echo '</div>';		
					}
					
					if ($fin ==1)
					{
						echo '</div>';
					}
					
					
					
				?> 
				<!-- Termina nuevo código. -->
				<div class="lineasverticales"  style="height:100px;"></div>
			<!-- InstanceEndEditable --></div>
		  
			<div id= "footer" ></div>
		</div>
	</body>
<!-- InstanceEnd --></html>