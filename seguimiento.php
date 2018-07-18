﻿<!-- 
******************************************************************
**	Página creada por Luis Antonio Vera Castañeda.              **
**	Octubre de 2017.                                            **
**	                                                            **
**	seguimiento.php                                            	**
**	Página creada para cubrir funcionalidad de seguimientos.	**
**	Basada en el código de la página form.php                  	**
**	El código se ha depurado y corregido.                      	**
**                                                             	**
******************************************************************
-->

<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/restriccionAcceso.php'); ?>
<?php include('gestionCatalogos.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="imagenes/tipo_comunicados/rari-icono.png" type="image/x-icon" rel="shortcut icon" />
		<title>RARI-SENASICA</title>
								
		<link href="css/estilocomun.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		
		<?php 
		$pagina='seguimiento';
		include('php/controlTemas.php'); 

		function establecerOptionsVisibles($datos)
		{
			for($i=0; $i<count($datos); $i++)
			{
				$arreglo=$datos[$i];			
				$cadena=$arreglo[3].",";
					
				if($arreglo[1]!=null)
				{
					$cadena=$cadena.' '.$arreglo[1].', '.$arreglo[2].', ';
				}			
					
				$cadena=$cadena.$arreglo[0].' ('.$arreglo[4].','.$arreglo[5].')';			
		?>
		<option value="<?php echo $i; ?>"><?php echo $cadena; ?></option>
		<?php
			}
		}

		function establecerOptions($datos)
		{
			for($i=0; $i<count($datos); $i++)
			{
				$arreglo=$datos[$i];
				$cadena="";
				
				for($j=0; $j<count($arreglo);$j++)
				{
					if($j>0&&$arreglo[$j]!=null)
						$cadena=$cadena."|";
					
					$cadena=$cadena.$arreglo[$j];
				}
		?>
		<option value="<?php echo $i; ?>"><?php echo $cadena; ?></option>
		<?php
			}
		}

		$rol=$_SESSION['idRol'];
		$area=$_SESSION['area'];
		$nivel=$_SESSION['nivel']; 
		$comunicado=null;
		$dataComunicado=null;
		if(isset($_GET['comunicado']))
		{
			$comunicado=$_GET['comunicado'];
			$dataComunicado=obtenerDataComunicado($database_rari_coneccion, $rari_coneccion,$comunicado);
			$dataSeguimiento = obtenerDataSeguimiento($database_rari_coneccion, $rari_coneccion,$comunicado);
			$dataFolio = obtenerFolio($database_rari_coneccion, $rari_coneccion,$comunicado);
			$FoliSeg=$dataFolio['folio'];
			$descSeguimiento=obtenerDesc($database_rari_coneccion, $rari_coneccion,$comunicado,$FoliSeg);
			//echo "hola".$descSeguimiento['desc_comunicado'];
			echo $FoliSeg."#########";
			var_dump($descSeguimiento);
			echo"############### seguimeinto " .$descSeguimiento['desc_comunicado'];
		}
		else
		{
			$GoTo = 'bienvenido.php';			
			header(sprintf('Location: %s', $GoTo));
		}

		if($modulo!=$area&&$rol!=1)
		{
			$GoTo = 'bienvenido.php';
			header(sprintf('Location: %s', $GoTo));
		}

		
		

		
		

		?>
		<script type="text/javascript" src="js/tcal.js"></script> 
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="plugins/popups.js"></script>
		<script type="text/javascript"></script>
	</head>

	<body>
		<div id="cuerpo">
			<div id="header">
				<div id="encabezado"></div>
				<div id="rari_tit">rari.senasica.gob.mx</div>
			</div>
	  
			<div id="menu"></div>
	  
			<div id="contenido">
				<div class="lineasverticales"></div>
		
				<div class="etiqueta-der" onClick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
					<div class="recuadro-interior">Salir</div> 
					<span class="triangulo-der"></span>
				</div>
		
				<div id="volver-menu" class="etiqueta" onClick="window.location='menu.php?mod=<?php echo $modulo; ?>';">
					<div class="recuadro-interior">Volver al men&uacute;</div> 
					<span class="triangulo-izq"></span>
				</div>
	 
				<div class="etiqueta" style="width:500px">
					<div class="recuadro-interior" style="text-align:right">Seguimiento a Comunicado en  <?php echo $etiqueta; ?></div> 
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
		
				<form id="formVegetal" name="formVegetal" method="post" enctype="multipart/form-data" action="#" > 
					<input type="hidden" name="idcmncd" id="idcmncd" value="<?php echo base64_encode(base64_encode($comunicado)); ?>" />
					<input type="hidden" name="ar" id="ar" value="<?php echo $modulo; ?>"/>
					<div class="etiqueta">
						<div class="recuadro-interior"> >> Identidad</div> 
						<span class="triangulo-izq"></span>
					</div>
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">T&iacute;tulo:<h3 /></div></td>
							<td width="64%">
								<!--<input type="text" id="txtTituloComunicado" name="txtTituloComunicado" style="min-width:400px" value="<?php echo $dataComunicado['titulo'];?>" readonly />-->
								<input type="text" id="txtTituloComunicado" name="txtTituloComunicado" style="min-width:400px" value="<?php echo $dataComunicado['titulo'];?>"  />
							</td>
						</tr>
					</table>

					<div class="lineasverticales"></div>
					<!--
					 <table width="100%">
						<tr>
							<td width="36%">
								<div class="campo_folio"><h3 style="margin-left:20px; color:#333;">Folio:<h3 /></div>
							</td>
							<td width="64%">
								<input type="text" id="txtfolio" name="txtfolio" style="min-width:200px" value="<?php echo ($comunicado!=null?$dataComunicado['folio']:"");?>" readonly  />
								
							</td>
						</tr>
					</table> 
					-->
	 
					
	 
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Tipo de Comunicados:<h3 /></div></td>
							<td width="64%">
							<?php echo obtenerCatalogoSelectS(17,$database_rari_coneccion,$rari_coneccion,$modulo,$dataComunicado['idTipoComunicado']); ?>
							</td></tr>
					</table>
	 
					<div class="lineasverticales"></div>
	 
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Direcciones:<h3 /></div></td>
							<td width="64%">
							<?php echo obtenerCatalogoSelect(23,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado,$dataComunicado['idTipoContaminacion']); ?>
							</td></tr>
					</table>

					<?php if($modulo==6){?>
					<div class="lineasverticales"></div>
	 
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Área:<h3 /></div></td>
						<td width="64%"><?php echo obtenerCatalogoSelectS(22,$database_rari_coneccion,$rari_coneccion,$modulo,$dataComunicado['idTipoComunicado']); ?></td></tr>
					</table>
					<?php }?>
	 
					<?php if($modulo==3) {?>
					<div class="lineasverticales"></div>
	 
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Tipo de Contaminaci&oacute;n:<h3 /></div></td>
							<td width="64%"><?php echo obtenerCatalogoSelectS(18,$database_rari_coneccion,$rari_coneccion,$modulo); ?></td></tr>
					</table>
					<?php }?>
	 
					<div class="lineasverticales"></div>
	 
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Problema/agente causal:<h3 /></div></td>
							<td width="64%"><?php echo obtenerCatalogoSelect(3,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
					</table>
	 
					<div class="lineasverticales"></div>
	  
					<table width="100%">
						<tr><td width="37%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;"><?php echo $etiquetaHospedero;?>:<h3 /></div></td>
							<td width="30%"><?php echo obtenerCatalogoSelect(1,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td>
							<td width="8%" align="right"><div class="campo_titulo" ><h3 style="margin-left:20px; color:#333;">Fecha: </h3></div></td>
							<td width="25%"><div><input id="date" readonly type="text" name="date" class="tcal" value="<?php echo $dataComunicado['fecha'];?>" /></div></td></tr>
					</table>
	 
					<?php if($modulo==4){?>
					<div class="lineasverticales"></div>
	 
					<table width="100%">
						<tr><td width="26%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Fraccion arancelaria:<h3 /></div></td>
							<td width="75%"><?php echo obtenerCatalogoSelect(6,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
					</table>
					<?php }?>
	 
					<div class="lineasverticales"></div>
					
					<div class="campo_titulo" ><h3 style="margin-left:20px; color:#333;">Localizaci&oacute;n:</h3></div>
					
					<table width="100%">
						<tr><td align="center"><select id="cmbLocs" multiple="multiple" name="cmbLocs" style="width:70%;">
								<?php 
									$datos=obtenerLocalizacionesPorComunicado($database_rari_coneccion,$rari_coneccion,$comunicado);
									$datos1=$datos[0];
									$datos2=$datos[1];		
									
									establecerOptionsVisibles($datos2);
								?>
								</select>
								<select id="cmbLocsOculto" multiple="multiple" name="cmbLocsOculto" style="display:none;"><?php establecerOptions($datos1); ?></select>

								<input type="hidden" id="contaLocs" name="contaLocs" value="1"/>
								<input type="hidden" id="resultLocs" name="resultLocs" value="1"/>
							</td></tr>
						<tr><td align="center">
								<input id="btnAgregarLoc" type="button" value="Agregar localización" class="btnAgregarLoc">
								<input id="btnQuitarLoc" type="button" value="Quitar localización" class="btnQuitarLoc">
							</td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr><td width="25%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Oisa:<h3 /></div></td>
							<td width="35%"><?php echo obtenerCatalogoSelect(2,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td>
							<td>
								<table>
									<tr><td align="right" width="40%">PVI:</td>
										<td width="60%"><?php echo obtenerCatalogoSelect(4,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
									<tr><td align="right" width="40%">PVIF:</td>
										<td width="60%"><?php echo obtenerCatalogoSelect(5,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
								</table>
							</td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<div class="etiqueta">
						<div class="recuadro-interior"> >> Seguimiento</div>
						<span class="triangulo-izq"></span>
					</div>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr align="center"><td width="50%" align="center"><div class="campo_titulo" style=" color:#333;"><?php if($modulo==3) echo 'Acciones realizadas:'; else echo 'Medidas implementadas:'?></div></td>
						<td width="50%" align="center"><div class="campo_titulo" style=" color:#333;"><?php if($modulo==3) echo 'Acciones de seguimiento:'; else echo 'Medidas a implementar:'?></div></td></tr>
						<tr align="center"><td width="50%" align="center"><?php echo obtenerCatalogoSelect(7,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td>
						<td width="50%" align="center"><?php echo obtenerCatalogoSelect(8,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr align="center">
							<?php if($modulo!=3){?>
							<td width="50%" align="center"><div class="campo_titulo" style=" color:#333;">Motivo de notificaci&oacute;n:</div></td>
							<?php } ?>
							<td width="50%" align="center"><div class="campo_titulo" style=" color:#333;">Categor&iacute;a <?php echo $modulo==6?"de la noticia:":"del riesgo:"; ?></div></td></tr>
						<tr align="center">
							<?php if($modulo!=3){?>
							<td width="50%" align="center"><?php echo obtenerCatalogoSelect(9,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td>
							<?php }?>
							<td width="50%" align="center"><?php echo obtenerCatalogoSelect(10,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr align="center"><td width="50%" align="center"><div class="campo_titulo" style=" color:#333;">Nivel de alerta:</div></td>
							<td width="50%" align="center"><div class="campo_titulo" style=" color:#333;">Resoluci&oacute;n:</div></td></tr>
						<tr align="center"><td width="50%" align="center"><?php echo obtenerCatalogoSelectS(16,$database_rari_coneccion,$rari_coneccion,$modulo,$dataComunicado['idTipoComunicado']);?></td>
							<td width="50%" align="center"><?php echo obtenerCatalogoSelect(13,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr align="center"><td width="50%" align="center"><div class="campo_titulo" style=" color:#333;"><?php if($modulo==3) {echo 'Regulación nacional';}else{echo'Reglamentación:';}?></div></td>
							<td width="50%" align="center"><?php if($modulo==3) {?><div class="campo_titulo" style=" color:#333;">Reglamentaci&oacute;n internacional:</div><?php }?></td></tr>
						<tr align="center"><td width="100%" align="center"><?php echo obtenerCatalogoSelect(11,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado);?></td>
							<td width="50%" align="center"><?php if($modulo==3) echo obtenerCatalogoSelect(12,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado); ?></td></tr>
					</table>
	 
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr align="center"><td width="50%" align="center"><div class="campo_titulo" style=" color:#333;">Nivel de riesgo:</div></td>
							<td width="50%" align="center"></td></tr>
						<tr align="center"><td width="50%" align="center"><?php echo obtenerCatalogoSelectS(15,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado); ?></td>
							<td width="50%" align="center"></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<div class="etiqueta">
						<div class="recuadro-interior"> >> Contenido</div> 
						<span class="triangulo-izq"></span>
					</div>
					
					<?php if($modulo<3 || $modulo>4){?>
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Estatus <?php if ($modulo==6 or $modulo==4) {echo 'fitozoosanitario';} else if($modulo==5 or $modulo==3) {echo 'sanitario';} else if($modulo==2) {echo 'zoosanitario';} else if($modulo==1) {echo 'fitosanitario';}?>:<h3 /></div></td>
							<td width="64%"><?php echo obtenerCatalogoSelectS(14,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado); ?></td></tr>
					</table>
					<?php }?>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Mapa: <h3 /></div></td>
							<td width="64%"><input  name="txtMapa" id="txtMapa" type="file"/>
											<input  name="lMapa" id="lMapa" type="hidden"value="<?php echo ($dataComunicado['mapa']!=null?$dataComunicado['mapa']:'0')?>"/></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="90%" align="center"><h5 style="margin-left:20px; color:#333;">DESCRIPCIÓN DEL COMUNICADO: <h5 />
					<tr><td width="100%"><textarea  style="width:100%; max-width:100%"  name="contenido" id="txt_contenido" rows="6" readonly ><?php echo strip_tags($descSeguimiento['desc_comunicado']);?></textarea></td></tr>
					<!--	<tr><td width="100%"><textarea  style="width:100%; max-width:100%"  name="contenido" id="txt_contenido" rows="6"  ><?php // echo strip_tags($dataSeguimiento['seguimientoResumen']);?></textarea></td></tr>-->
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="90%" align="center"><h5 style="margin-left:20px; color:#333;">DETALLE DE SEGUIMIENTO DEL COMUNICADO: <h5 />
						<tr><td width="100%"><textarea  style="width:100%; max-width:100%"  name="anexoContenido" id="txt_anexoContenido" rows="6"  ></textarea></td></tr>
					</table>
	  
					<div class="lineasverticales"></div>
					
					<table width="90%" align="center">
						<tr><td width="100%"></td></tr>
						<?php echo "<tr><td width=\"100%\" align=\"center\"><h3 style=\"margin-left:20px; color:#333;\">CONTINUAR SEGUIMIENTO <input type=\"checkbox\" name=\"chk_seguimiento\" id=\"chk_seguimiento\" checked></h3></td></tr>"; ?>
						<tr><td width="100%"></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%" align="center">
						<tr><td width="100%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Enlaces externos:</h3></div> </td></tr>
						<tr><td width="100%" align="center"><select id="cmbEnlaces" multiple="multiple" name="cmbEnlaces" style="width:70%;">
								<?php
									$datosEnl=obtenerEnlaces($comunicado, $database_rari_coneccion, $rari_coneccion);
									for($i=0; $i<count($datosEnl);$i++)
									{
								?><option value="<?php echo $i; ?>"><?php echo $datosEnl[$i]; ?></option>
								<?php 
									}
								?>
								</select></td></tr>
						<tr><td width="100%" align="center">
								<input type="button" id="btnAgregarEnlace" value="Agregar enlace" class="clsAgregarEnlace">
								<input type="button" id="btnQuitarEnlace" value="Quitar enlace" class="clsAgregarEnlace">
								<input type="hidden" id="contaEnlaces" name="contaEnlaces" value="1"/>
								<input type="hidden" id="resultEnlaces" name="resultEnlaces" value=""/></td></tr>
						<tr><td width="100%"></td></tr>
					</table>
					
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">Im&aacute;gen del COMUNICADO: <h3 /></div></td>
							<td width="64%"><input  name="imagen" id="imagen" type="file"  /><input  name="lImagen" id="lImagen" type="hidden"value="<?php echo $dataComunicado['imagen']?>"/></td></tr>
					</table>
	 
					<div class="lineasverticales"></div>
					
					<table width="100%">
						<tr><td width="36%"><div class="campo_titulo"><h3 style="margin-left:20px; color:#333;">PDF del COMUNICADO: <h3 /></div></td>
							<td width="64%"><input  name="pdf" id="pdf" type="file"  /><input  name="lPdf" id="lPdf" type="hidden" value="<?php echo ($dataComunicado['documento']!=null?$dataComunicado['documento']:'0')?>"/></td></tr>
					</table>
					
					<div id="errorAlerta" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;">
						<div class="recuadro-interior">Error del usuario </div></div>
			
					<table align="center">
						<tr><!-- 
							<td><div class="agrega" style="background-color:#333; cursor:pointer; padding:3px; border-radius:10px; color:#FFF;">
									<div class="recuadro-interior" style="text-align:center" onClick="vistaPrevia(<?php /*echo $_GET['mod']; */?>)">Vista previa</div></div></td>
							-->
							<td><div class="agrega" style="background-color:#333; cursor:pointer; padding:3px; border-radius:10px; color:#FFF;">
									<div class="recuadro-interior" style="text-align:center" onClick="EnviarFormularioSeg()"><?php echo 'Actualizar'; ?></div></div></td></tr>
					</table>
				</form>

				<div class="lineasverticales"></div>
				
				<div id="popupLocalizacion" class="popup">
					<div class="interior">
						<div class="etiqueta" style="width:180px">
							<div class="recuadro-interior">	>> Localizaci&oacute;n</div></div>
						<table>
							<tr><td colspan="3" align="right">Pa&iacute;s: <?php echo obtenerCatalogoSelectS(19,$database_rari_coneccion,$rari_coneccion,1);?></td></tr>
							<tr class="edos"><td colspan="3" align="right">Estado: <?php echo obtenerCatalogoSelectS(20,$database_rari_coneccion,$rari_coneccion,1);?></td></tr>
							<tr class="edos"><td colspan="3" align="right">Municipio:<span id="divMpio"><?php echo obtenerCatalogoSelectS(21,$database_rari_coneccion,$rari_coneccion,1);?></span></td></tr>
							<tr><td>Otra regi&oacute;n: <input type="text" id="txtOtraReg" name="txtOtraReg" style="width:300px;" /></td></tr>
							<tr align="center"><td align="right" width="100%">Latitud: <input max="90" min="-90" type="number" id="txtLatitud"/></td></tr>
							<tr align="right" width="100%"><td>Longitud: <input max="180" min="-180" type="number" id="txtLongitud"/></td></tr>
							<tr><td colspan="2" align="right">
									<div id="errorLoc" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;">
										<div class="recuadro-interior">Error del usuario </div></div>
									<hr/>
									<input type="button" value="Cancelar" id="pBtnCancelarLoc"><input type="button" value="Agregar..." id="pBtnAgregarLoc"></td></tr>
						</table>
					</div>
				</div>
				
				<div id="popupEnlaces" class="popup">
					<div class="interior">
						<div class="etiqueta" style="width:220px">
							<div class="recuadro-interior">	>> Enlaces externos</div>
						</div>
						<table width="550" id="tablaEnlace">
							<tr><td align="left">
									<div class="campo_titulo">Enlaces hacia otros sitios de internet...</div></td></tr>
							<tr><td align="right">
									<input type="text" id="txtEnlaces" style="width:100%"/></td></tr>
							<tr><td align="right">
									<div id="errorEnl" style="background-color:#C30; color:#FFF; display:none; text-align:center; border-radius:10px; padding:1px;">
										<div class="recuadro-interior">Error del usuario</div>
									</div>
									<hr/>
									<input type="button" value="Cancelar" id="pBtnCancelarEnlace"> <input type="button" value="Agregar..." id="pBtnAgregarEnlace"></td></tr>
						</table>					
						<div></div>
					</div>
				</div>
			</div>
			
			<div id= "footer" ></div>
		</div>
	</body>
</html>