<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); 

	require_once 'php/detalles.php';
	$pagina="form";
	$modulo=2;
	include('php/controlTemas.php'); 

	function extension($str) 
	{
		$array=explode("/", $str);
		return $array[count($array)-1];
	}

	if(!isset($_GET['idAlerta']))
	{
		$titulo=$_POST['txtTituloComunicado'];
		if(!isset($_POST['lImagen'])||$_POST['lImagen']==0)
		{
			$imagen="user".$_SESSION['id'].".".extension($_FILES['imagen']['type']);
			copy($_FILES['imagen']['tmp_name'],"archivos_alertas/tmp/".$imagen);
			$imagen="archivos_alertas/tmp/".$imagen;
		}
		else
			$imagen="archivos_alertas/imagenes/".$_POST['lImagen'];
			
		$fecha=$_POST['date'];
		$tipoComunicado=$_POST['cmb_comunicados'][0];
		$arreglo_agentes=$_POST['cmb_agentes'];
		$arreglo_productos=$_POST['cmb_productos'];
 		$arreglo_localizaciones= explode ("°",$_POST['resultLocs']);

		//Nuevo código. Se agregará aquí la variable para recibir el listado de áreas de adscripción. 
		//Se validará si se puede quedar nulo; de ser así, deberá agregarse validación
		//LVC 7-Junio-2017
		$arreglo_areas_ads= $_POST['cmb_area_adscripcion'];
		//Termina código nuevo.

		if(isset($_POST['cmb_oisas']))
			$arreglo_oisas=$_POST['cmb_oisas'];
		else 
			$arreglo_oisas=null;

		////////////agregar PVI y PVIFS/////////////
		if(isset($_POST['cmb_pvis']))
			$arreglo_pvis=$_POST['cmb_pvis'];
		else 
			$arreglo_pvis=null;
		///////////////////////////////////
		if(isset($_POST['cmb_pvifs']))
			$arreglo_pvifs=$_POST['cmb_pvifs'];
		else 
			$arreglo_pvifs=null;
		////////fin de agregar PVI y PVIF//////////

		$contenido=$_POST['contenido'];

		

		if(isset($_POST['resultEnlaces']))
		{
			$enlaces=$_POST['resultEnlaces'];
			$arreglo_enlaces= explode ("°",$enlaces);
		}
		else
			$arreglo_enlaces=null;

		$arreglo_med_implementadas=$_POST['cmb_med_implementadas'];
		$arreglo_med_implementar=$_POST['cmb_med_aimplementar'];
		$nivel_riesgo=$_POST['cmb_nivel_riesgo'][0];
		$nivel_alerta=$_POST['cmb_nivel_alerta'][0];

		if(isset($_POST['cmb_motivos']))
			$arreglo_motivos=$_POST['cmb_motivos'];
		else
			$arreglo_motivos=null;

		$arreglo_reglamentacion=$_POST['cmb_reglamentacion'];
		$arreglo_resolucion=$_POST['cmb_resolucion'];
		$arreglo_riesgos=$_POST['cmb_riesgo'];

		//Se agregan variables para recibir/setear datos para PDF. LVC. 31-Mayo-2017
		if(isset($_POST['lPdf']))
			$arreglo_pdf=$_POST['lPdf'];
		else
			$arreglo_pdf=null;
		//Se agregan variables para recibir/setear datos para Mapas
		if(isset($_POST['lMapa']))
			$arreglo_mapa=$_POST['lMapa'];
		else
			$arreglo_mapa=null;
		//Fin de código nuevo.
		
		//Se agrega variable para recibir el booleano de seguimiento. LVC. 5-Octubre-2017
		if(isset($_POST['chk_seguimiento']))
		{
			$seguimiento=1;
		}
		else
		{
			$seguimiento=0;
		}    
		//Termina código nuevo.
	}
	else
	{
		$idAlerta=$_GET['idAlerta'];
		$det_bitacoraSQL="select * from tbl_comunicado where id=".$idAlerta;

		

		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
		$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
		$totalRows_det_bitacora = mysql_num_rows($det_bitacora);

		//mostrar seguimientos
		$conS="";
		$conSegui="select desc_comunicado from tbl_comunicado where id=".$idAlerta;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$conS = mysql_query($conSegui, $rari_coneccion) or die(mysql_error());
		$row_conS = mysql_fetch_assoc($conS);
	
		
		
	
		if($totalRows_det_bitacora!=1)
		{
			$GoTo = "bienvenido.php";			
			header(sprintf("Location: %s", $GoTo));
		}		
		
		if($row_det_bitacora['idArea']!=$_GET['mod'])
		{
			$GoTo = "bienvenido.php";			
			header(sprintf("Location: %s", $GoTo));
		}

		$titulo=$row_det_bitacora['titulo'];
		$imagen="archivos_alertas/imagenes/".$row_det_bitacora['imagen'];
		//copy($_FILES['imagen']['tmp_name'],"archivos_alertas/tmp/".$imagen);

		$fecha=$row_det_bitacora['fecha'];
		$tipoComunicado=$row_det_bitacora['idTipoComunicado'];
		$arreglo_agentes=obtenerDetalles($idAlerta, 1, $database_rari_coneccion, $rari_coneccion);
		$arreglo_enlaces= obtenerDetalleEnlaces($idAlerta, $database_rari_coneccion, $rari_coneccion);
		
		///////////////////Agregar links de pdf/////////////////////////////////////////
		$arreglo_pdf= obtenerDetallePdf($idAlerta, $database_rari_coneccion, $rari_coneccion);
		///////////////////FIN Agregar pdf////////////////////////////////////////////// 

		///////////////////Agregar links de mapa/////////////////////////////////////////
		$arreglo_mapa= obtenerDetalleMapa($idAlerta, $database_rari_coneccion, $rari_coneccion);
		///////////////////FIN Agregar mapa////////////////////////////////////////////// 

		$arreglo_productos=obtenerDetalles($idAlerta, 8, $database_rari_coneccion, $rari_coneccion);
		$arreglo_localizaciones=obtenerDetalleLoc($idAlerta,$database_rari_coneccion, $rari_coneccion);

		//Nuevo código. Se agregará aquí la variable para recibir el listado de áreas de adscripción. 
		//LVC 9-Junio-2017
		$arreglo_areas_ads= obtenerDetalles($idAlerta, 16, $database_rari_coneccion, $rari_coneccion);
		//Termina código nuevo.

		$arreglo_oisas=obtenerDetalles($idAlerta, 7, $database_rari_coneccion, $rari_coneccion);
		////////////////// Agregrar PVI y PVIF /////////////////////////////////////
		$arreglo_pvis=obtenerDetalles($idAlerta, 10, $database_rari_coneccion, $rari_coneccion);
		$arreglo_pvifs=obtenerDetalles($idAlerta, 9, $database_rari_coneccion, $rari_coneccion);
		////////////////// FIN Agregrar PVI y PVIF /////////////////////////////////////

		$contenido=$row_det_bitacora['resumen'];
		$enlaces=null;
		$arreglo_med_implementadas=obtenerDetalles($idAlerta, 4, $database_rari_coneccion, $rari_coneccion);
		$arreglo_med_implementar=obtenerDetalles($idAlerta, 5, $database_rari_coneccion, $rari_coneccion);
		$nivel_riesgo=$row_det_bitacora['idNivelRiesgo'];
		$nivel_alerta=$row_det_bitacora['idNivelAlerta'];
		$arreglo_motivos=obtenerDetalles($idAlerta, 6, $database_rari_coneccion, $rari_coneccion);
		$arreglo_reglamentacion=obtenerDetalles($idAlerta, 12, $database_rari_coneccion, $rari_coneccion);
		$arreglo_resolucion=obtenerDetalles($idAlerta, 13, $database_rari_coneccion, $rari_coneccion);
		$arreglo_riesgos=obtenerDetalles($idAlerta, 14, $database_rari_coneccion, $rari_coneccion);
		
		//Se agrega variable para recibir el booleano de seguimiento. LVC. 5-Octubre-2017
		$seguimiento=obtenerDetalleSeg($idAlerta, $database_rari_coneccion, $rari_coneccion);
		//Termina código nuevo.
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
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />

		<script type="text/javascript" src="js/tcal.js"></script> 
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="plugins/popups.js"></script>
		<script type="text/javascript">
		</script>

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
				<div id="rari_tit">rari-senasica.gob.mx</div>
			</div>
  
			<div id="menu"></div>
			
			<div id="contenido"><!-- InstanceBeginEditable name="RegionCuerpo" --> 
				<div class="lineasverticales"></div>
				
				<div class="etiqueta" style="width:500px">
					<div class="recuadro-interior" style="text-align:right">
						Vista del comunicado
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
  
				<div class="lineasverticales"></div>
 
				<div class="etiqueta-completa">
					<div class="recuadro-interior">
						<?php echo $titulo; ?>
					</div>
 
					<span class="triangulo-izq"></span><span class="triangulo-der"></span>
				</div>

				<table width="95%" align="center" >
					<tr>
						<td colspan="2">>> Identidad</td>
					</tr>
					<tr>
						<td width="25%"><div style="width:100%; height:250px; border:2px solid #999;">
											<div class="imagen-lista" style="background-image:url(<?php echo $imagen; ?>); height:100%; width:100%; background-size:cover; background-position:center;"></div>
										</div></td>
						<td width="75%">
							<table width="100%" style="border-collapse:separate;">
								<tr>
									<td bgcolor="#CCCCCC" align="right" width="25%">Fecha:</td><td width="75%"><?php echo $fecha; ?></td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right">Tipo de comunicado:</td><td><?php echo obtenerNombreCampo($tipoComunicado, "cat_comunicados", $database_rari_coneccion, $rari_coneccion); ?></td>
								</tr>
								<!-- Se comenta código. No deben visualizarse las áreas de adscripción en la vista previa 
								<!--Código nuevo. Se agrega Áreas de Adscripción. LVC. 7-Junio-2017 
								<tr>
									<td bgcolor="#CCCCCC" align="right">Áreas de Adscripción:</td><td><?php 
										$cad="'";
										for ($i=0;$i<count($arreglo_areas_ads);$i++) 
										{
											if($i>0)
											$cad=$cad."', '";
											$cad=$cad. obtenerNombreCampo($arreglo_areas_ads[$i], "cat_area_adscripcion", $database_rari_coneccion, $rari_coneccion). "'";
										}
										 echo $cad;

									?></td>
								</tr>
								-->
								<!--Termina código nuevo. -->
								<tr>
									<td bgcolor="#CCCCCC" align="right">Problema/AgenteCausal:</td><td><?php 
										$cad="";
										for ($i=0;$i<count($arreglo_agentes);$i++) 
										{
											if($i>0)
												$cad=$cad.", ";
											$cad=$cad. obtenerNombreCampo($arreglo_agentes[$i], "cat_agentes", $database_rari_coneccion, $rari_coneccion);
										}
										echo $cad;
									?></td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right">Hospedero:</td><td><?php 
										$cad="";
										for ($i=0;$i<count($arreglo_productos);$i++) 
										{
											if($i>0)
												$cad=$cad.", ";
											$cad=$cad. obtenerNombreCampo($arreglo_productos[$i], "cat_productos", $database_rari_coneccion, $rari_coneccion);
										}
										echo $cad;
									?></td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right">Localización:</td><td>
										<?php 
											if($arreglo_localizaciones!=null)
											{
												$coordenadas="";
												$total=count($arreglo_localizaciones);
												if(!isset($_GET['idAlerta']))
													$total--;
												$localizaciones="";
												for($i=0;$i<$total;$i++) 
												{
													$localizacion=explode ("|",$arreglo_localizaciones[$i]);
	
													if($localizaciones!="")
														$localizaciones=$localizaciones.", ";
													$pais=$localizacion[0];
													$edo=count($localizacion)==6?$localizacion[1]:null;
													$mpo=count($localizacion)==6?$localizacion[2]:null;
													$otraLoc=count($localizacion)==6?$localizacion[3]:$localizacion[1];
													$Lat=count($localizacion)==6?$localizacion[4]:$localizacion[2];
													$Lon=count($localizacion)==6?$localizacion[5]:$localizacion[3];													
													$localizaciones=$localizaciones.obtenerNombreCampo($pais, "tbl_paises", $database_rari_coneccion, $rari_coneccion).", ".$otraLoc;
													
													if($i>0)
														$coordenadas=$coordenadas." ";
													$coordenadas=$coordenadas.$Lon.",".$Lat;
												}
												echo $localizaciones;
											}
										?>
									</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right">Oisa:</td><td>
										<?php 
											if($arreglo_oisas!=null)
											{
												$cad="";
												for ($i=0;$i<count($arreglo_oisas);$i++) 
												{
													if($i>0)
														$cad=$cad.", ";
													$cad=$cad. obtenerNombreCampo($arreglo_oisas[$i], "cat_oisas", $database_rari_coneccion, $rari_coneccion);
												}
												echo $cad;
											}
										?>
									</td>
								</tr>
								<!--  -------Agregar PVI y PVIF--------------  -->
								<tr>
									<td bgcolor="#CCCCCC" align="right">PVIS:</td>
									<td>
										<?php 
											if($arreglo_pvis!=null)
											{
												$cad="";
												for ($i=0;$i<count($arreglo_pvis);$i++) 
												{
													if($i>0)
														$cad=$cad.", ";
													$cad=$cad. obtenerNombreCampo($arreglo_pvis[$i], "cat_pvis", $database_rari_coneccion, $rari_coneccion);
												}
												echo $cad;
											}
										?>
									</td>
								</tr> 
								<tr>
									<td bgcolor="#CCCCCC" align="right">PVIFS:</td>
									<td> 
										<?php  
											if($arreglo_pvifs!=null)
											{
												$cad="";
												for ($i=0;$i<count($arreglo_pvifs);$i++) 
												{
													if($i>0)
														$cad=$cad.", ";
													$cad=$cad. obtenerNombreCampo($arreglo_pvifs[$i], "cat_pvifs", $database_rari_coneccion, $rari_coneccion);
												}
												echo $cad;
											}
										?> 
									</td>
								</tr> 
							<!--  -------FIN Agregar PVI y PVIF--------------  -->
							</table>
						</td>
					</tr>
				</table>
							 
				<div class="lineasverticales"></div>				
				<div class="etiqueta-completa">
					<div class="recuadro-interior">
						Contenido
					</div>
							 
					<span class="triangulo-izq"></span><span class="triangulo-der"></span>
				</div>
				<table width="95%" align="center" >
				
					<tr>
						<td colspan="2"><?php echo $contenido; 
						
						echo"<p>Seguimiento Actual:";
						echo"<br>--------------------------------------------------------------------<br>";
						echo $row_conS['desc_comunicado'];
						
						?>						
						</td>
						

						<td colspan="2"><?php echo $conS; ?></td>
						
					</tr>
					
					<tr height="400px">
						<td  colspan="2">
							<?php if(!isset($_GET['idAlerta'])){?>
							<!-- Mapa ESRI para comunicado -->
							<!-- <object type="text/html" data="http://10.24.17.53/mapaAlertas/mapaAlertas.aspx?id=<?php echo $coordenadas; ?>"
									style="width:100%; height:100%; border:2px solid #999;">
							</object> -->
							
							<iframe src="http://sinavef.senasica.gob.mx/mapaAlertas/mapaAlertas.aspx?id=<?php echo $coordenadas; ?>"
								style="width:950px; height:398px; border:2px solid #999;">
							</iframe> 
							<!-- <iframe src="http://localhost/mapaAlertas/mapaAlertas.aspx?id=<?php echo $coordenadas; ?>"
									style="width:950px; height:398px; border:2px solid #999;">
							</iframe> -->
							<?php }
								else
								{
							?>
							<!-- <object type="text/html" data="http://10.24.17.53/mapaAlertas/mapaAlertas.aspx?id=<?php echo $_GET['idAlerta']; ?>"
									style="width:100%; height:100%; border:2px solid #999;">
							</object> -->
							<iframe src="http://sinavef.senasica.gob.mx/mapaAlertas/mapaAlertas.aspx?id=<?php echo $_GET['idAlerta']; ?>"
								style="width:950px; height:398px; border:2px solid #999;">
							</iframe>
							<!-- <iframe src="http://localhost:97/mapaAlertas/mapaAlertas.aspx?id=<?php echo $_GET['idAlerta']; ?>"
									style="width:950px; height:398px; border:2px solid #999;">
							</iframe> -->
							<?php }?>
						</td>
					</tr>
					<tr>
						<td width="75%">
							<table width="100%" style="border-collapse:separate;">
								<tr>
									<td bgcolor="#CCCCCC" align="right" width="25%">Enlaces:</td><td width="75%">
										<?php 
											//Inserción de enlaces   OK revisar registro vacío
											if($arreglo_enlaces!=null)
											{
												$total=count($arreglo_enlaces);
												if(!isset($_GET['idAlerta']))
													$total--;
												for($i=0;$i<$total;$i++) 
												{ 
													$narreglo="";
										?>
										- <a href="<?php
											if(substr_count ($arreglo_enlaces[$i],"http://")==0&&substr_count ($arreglo_enlaces[$i],"https://")==0)
												$narreglo="http://".$arreglo_enlaces[$i];
											else
												$narreglo=$arreglo_enlaces[$i];
											echo $narreglo;?>" TARGET="_blank"><?php echo $arreglo_enlaces[$i]; ?></a><br/>
										<?php }
											}
										?>
									</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right" width="25%">Documento:</td><td width="75%">
										<?php 
											//Inserción de links pdf   OK revisar registro vacío
											if($arreglo_pdf!=null)
											{
												$total=count($arreglo_pdf);
												if(!isset($_GET['idAlerta']))
													$total--;
												
												for($i=0;$i<$total;$i++) 
												{ 
													$narreglo="";
													$cad_prueba="";
										?>
										- <a href="<?php
													if(substr_count ($arreglo_pdf[$i],"../archivos_alertas/pdfs/")==0)
													{
														$narreglo="../archivos_alertas/pdfs/".$arreglo_pdf[$i];
														$cad_prueba= substr($narreglo,(strlen($narreglo)-4),4);
													}
													else
														$narreglo=$arreglo_pdf[$i];
													echo $narreglo;?>" TARGET="_blank"><?php
													if($cad_prueba==".pdf" || $cad_prueba=="xlsx" || $cad_prueba=="docx" || $cad_prueba==".xls" || $cad_prueba==".doc" || $cad_prueba==".ppt" || $cad_prueba=="pptx")
													{
														echo $arreglo_pdf[$i];
													}
													else
													{
										?></a>
										<?php 
														echo "No existe documento relacionado"; 
													}
										?><br/>
										<?php 	}
											}
										?>
									</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" align="right" width="25%">MAPA:</td><td width="75%">
										<?php 
											//Inserción de mapa   OK revisar registro vacío
											if($arreglo_mapa!=null)
											{
												$total=count($arreglo_mapa);
												if(!isset($_GET['idAlerta']))
													$total--;
												
												for($i=0;$i<$total;$i++) 
												{ 
													$narreglo="";
													$cad_prueba="";
										?>
										- <a href="<?php
													if(substr_count ($arreglo_mapa[$i],"../archivos_alertas/mapas/")==0)
													{
														$narreglo="../archivos_alertas/mapas/".$arreglo_mapa[$i];
														$cad_prueba= substr($narreglo,(strlen($narreglo)-3),3);
													}
													else
														$narreglo=$arreglo_mapa[$i];
													echo $narreglo;?>" TARGET="_blank"><?php
													if($cad_prueba=="peg" || $cad_prueba=="png")
													{
														echo $arreglo_mapa[$i]; 
													}
													else
													{
										?>
										</a>
										<?php 
														echo "No existe mapa relacionado"; 
													}
										?><br/>
										<?php 	}
											}
										?>
									</td>
								</tr>
							</table>
						</td>

						<td width="25%"> </td>
					</tr>
				</table>
				
				<div class="lineasverticales"></div>

				<table align="center" width="95%">
					<tr><td colspan="4">Seguimiento</td></tr>
					<tr style="border:#999 1px solid;">
						<td bgcolor="#CCCCCC" align="right" width="20%">Medidas implementadas:</td>
						<td width="30%">
							<?php 
								$cad="";
								for ($i=0;$i<count($arreglo_med_implementadas);$i++) 
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_med_implementadas[$i], "cat_med_implementadas", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad;
							?>
						</td>
						<td bgcolor="#CCCCCC" align="right" width="20%">Medidas a implementar:</td>
						<td width="30%">
							<?php 
								$cad="";
								for ($i=0;$i<count($arreglo_med_implementar);$i++) 
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_med_implementar[$i], "cat_med_aimplementar", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad;
							?>
						</td>
					</tr>
					<tr style="border:#999 1px solid;">
						<td bgcolor="#CCCCCC" align="right" width="20%">Motivo de notificación:</td>
						<td width="30%">
							<?php 
								$cad="";
								for ($i=0;$i<count($arreglo_motivos);$i++) 
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_motivos[$i], "cat_motivos", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad; 
							?>
						</td>
						<td bgcolor="#CCCCCC" align="right" width="20%">Categoría del riesgo:</td>
						<td width="30%">
							<?php 
								//Insercion de riesgos
								//$arreglo_riesgos=$_POST['cmb_riesgo'];
								$cad="";
								for ($i=0;$i<count($arreglo_riesgos);$i++) 
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_riesgos[$i], "cat_riesgo", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad;
							?>
						</td>
					</tr>
					<tr style="border:#999 1px solid;">
						<td bgcolor="#CCCCCC" align="right" width="20%">Nivel de riesgo:</td>
						<td width="30%">
							<?php 
								echo obtenerNombreCampo($nivel_riesgo, "cat_nivel_riesgo", $database_rari_coneccion, $rari_coneccion);
							?>
						</td>
						<td bgcolor="#CCCCCC" align="right" width="20%">Reglamentación:</td>
						<td width="30%">
							<?php 
								$cad="";
								for ($i=0;$i<count($arreglo_reglamentacion);$i++) 
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_reglamentacion[$i], "cat_reglamentacion", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad;
							?>
						</td>
					</tr>
					<tr style="border:#999 1px solid;">
						<td bgcolor="#CCCCCC" align="right" width="20%">Nivel de alerta:</td>
						<td width="30%">
							<?php 
								echo obtenerNombreCampo($nivel_alerta, "cat_nivel_alerta", $database_rari_coneccion, $rari_coneccion);
							?>
						</td>
						<td bgcolor="#CCCCCC" align="right" width="20%">Resolución/Estatus:</td>
						<td width="30%">
							<?php 
								//Insercion de resoluciones 
								$cad="";
								for ($i=0;$i<count($arreglo_resolucion);$i++)
								{
									if($i>0)
										$cad=$cad.", ";
									$cad=$cad. obtenerNombreCampo($arreglo_resolucion[$i], "cat_resolucion", $database_rari_coneccion, $rari_coneccion);
								}
								echo $cad;
							?>
						</td>
					</tr>
				</table>
				<div class="lineasverticales"></div>
				
				<!-- Se agrega código para mostrar si el comunicado tendrá Seguimiento. LVC 4-Octubre-2017 --> 
				<?php
					if($seguimiento==1)
					{
						echo "<table align=\"center\" width=\"95%\"><tr><td width=\"30%\" align=\"center\">";
						echo "SE ESTABLECE SEGUIMIENTO.";
						echo "</td></tr><tr><td></td></tr></table>";
						echo "<div class=\"lineasverticales\"></div>";
					}
				?>
				<!-- Termina código nuevo. --> 

			<!-- InstanceEndEditable --></div>
  
			<div id= "footer" ></div>
		</div>
	</body>
<!-- InstanceEnd --></html>