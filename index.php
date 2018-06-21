<?php
	if (isset($_SESSION)) 
	{
		session_destroy();
	}
	
	require_once('Connections/rari_coneccion.php');
	include('php/inicioSesion.php');
	include('Connections/variables.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
		<title>RARI-SENASICA</title>
		<link href="Content/css/estiloFonts.css" type="text/css" rel="stylesheet" />
		<link href="Content/bootstrap/bootstrap.css" type="text/css"  rel="stylesheet" />
		<link href="Content/css/estiloVisual.css" type="text/css"rel="stylesheet" />
		<script src="Content/bootstrap/jquery-1.11.1.min.js"></script>
		<script src="Content/bootstrap/bootstrap.js"></script>
		<script src="bundles/modernizr?v=qVODBytEBVVePTNtSFXgRX0NCEjh9U_Oj8ePaSiRcGg1"></script>
		<script type="text/javascript" src="/Scripts/funcionesPropias.js"></script>	
	</head>
	<body>
		<div style="max-width:1800px; margin:auto;">
			<div class="tablaAnchoAltoCompleto">
				<!-- ==== PARTE 1: AREA DEL ENCABEZADO EN LA PLANTILLA ESTABLECIDA ==== -->
				<div class="pseudoTR">
					<div class="celdaCentradaVertical">
						<header>
							<nav class="navbar navbar-inverse navbar-modificado navbar-fixed-top" role="navigation">
								<div class="container">
									<div class="navbar-header navbar-header-modificado">
										<h2>Red de Alerta Rápida Interna</h2>
									</div>
								</div>
							</nav>
						</header>
					</div>
				</div>

				<!-- ==== PARTE 2: AREA DEL CONTENIDO PRINCIPAL EN LA PLANTILLA ESTABLECIDA ==== -->
				<div class="pseudoTR">
					<div class="celdaCentradaVertical anchoAltoFull contenidoBodyCentral">
						<div class="col-md-celda col-md-logos">
							<div class="col-md-10 col-md-offset-2">
								<div class="row"><div class="col-xs-12 vcenter"><img src="Content/assets/plantilla/escudoNacional.png" class="center-block img-responsive" /></div></div>
							</div>
						</div>
						<div class="col-md-celda">
							<div class="col-md-9 col-md-offset-1">
								<div class="cuadroFormaAcceso">
									<h2 class="plecaSubtitulo"><span class="plecaTexto">Ingrese sus datos</span><span class="plecaLinea"></span></h2>								
									<form action="<?php echo $loginFormAction; ?>" name="login" method="POST" class="login">								
										<div id="alert-contenedor" class="alert alert-warning objetoOculto">
											<p id="alert-mensaje" class="text-center">... Cargando texto ...</p>
										</div>

										<div class="form-group">
											<label class="col-sm-4 text-right">Usuario:</label>
											<div class="col-sm-8"><input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario" /></div><br><br>
										</div>
										<div class="form-group">
											<label class="col-sm-4 text-right">Contraseña:</label>
											<div class="col-sm-8"><input type="password" name="password" class="form-control" placeholder="Contraseña" /></div><br><br>
										</div>
										<div id="btnEdicion" class="text-center"><input class="btn btn-default" type="submit" value="Acceder" /></div>
										<div class="padding1em">
											<br /><br /><br />
											<p>
												<b>?Problemas para conectarse?</b>
												<br />
												Si por alguna razón usted no puede acceder a su cuenta no dude en contactarnos.
											</p>
											<p>Correos de contacto:</p>
											<ul class="lista_lineal_basica">
												<li>webmaster@senasica.gob.mx</li>
											</ul>
											<p class="text-justify">
												<b>Importante:</b> Para ver correctamente este sitio necesita tener una resolución de pantalla mínima de 1024 x 768 pixeles,
												y la versión de alguno de los navegadores:
											</p>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- ==== PARTE 3: AREA DEL PIE DE PAGINA EN LA PLANTILLA ESTABLECIDA ==== -->
				<div class="space_bottom"></div>
				<footer class="main-footer">
					<div class="container">
						<div class="row">
							<div class="col-sm-4">
								<img src="/Content/assets/plantilla/logoInstitucional.png" alt="Servicio Nacional de Sanidad, Inocuidad y Calidad Agroalimentaria" class="img-responsive center-block">
							</div>
							<div class="col-sm-4 col-sm-offset-4">
								<div class="nomSistema">
									<h2>RARI</h2>
									<h3>Red de Alerta R�pida Interna</h3>
								</div>
							</div>
						</div>
					</div>
				</footer>
				<div class="pseudoTR">
					<div class="celdaCentradaVertical">
						<div class="barra01"></div>
						<div class="barra02"></div>
						<div class="barra03"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>