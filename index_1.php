<?php require_once('Connections/rari_coneccion.php'); 

?>
<?php include('php/inicioSesion.php'); 


?>
<?php include('Connections/variables.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="imagenes/tipo_comunicados/rari-icono.png" type="image/x-icon" rel="shortcut icon" />
<title>RARI-SENASICA</title>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/Concurrent.Thread.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.bpopup.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="plugins/uis-plugin.js"></script>
<script type="text/javascript" src="plugins/controlador_publico.js"></script>

<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>

<link href="css/estilo_publico.css" rel="stylesheet" type="text/css" />


</head>
<body>
<div style="max-width:1800px; margin:auto;">



<div  id="divLogin" style="display:none; margin:auto;">


<form action="<?php echo $loginFormAction; ?>" name="login" method="POST" class="login">
  <table align="center">
  
  <tr><td>Usuario: <input name="usuario" placeholder="Usuario" type="text" id="usuario" /></td><td>Contraseña: <input name="password" placeholder="Contraseña" type="password" id="password"></td><td><div id="cargando" style="width: 25px; height: 25px; position: absolute; left: 152px; background-image: url(http://www.nisergon.com.mx/img/loading2.gif); display:none; background-size: contain; background-position: center; background-repeat: no-repeat; top: 798px;"></div><input id="ingresar" style="width:110px; border:1px #666666 solid;" name="login" type="submit" value="Ingresar"/></td></tr>
  
  </table>
   
    </form>
 

</div>







<div id="encabezado" class="encabezado" >
<table height="100px" width="80%" align="center" style="min-width:950px;">
<tr>
<td align="center">
<a href="http://www.sagarpa.gob.mx/" target="_blank">
<div style="background-image:url(imagenes/sagarpa%20negro.png); background-position:center; background-size:contain; height:80px; width:100%; background-repeat:no-repeat;"></div></a>
</td>
<td align="center">
<a href="http://www.senasica.gob.mx/" target="_blank">
<div style="background-image:url(imagenes/senasica.png); background-position:center; background-size:contain; height:60px; width:100%; background-repeat:no-repeat;"></div></a>
</td>
<td>
<div id="rari" style="background-image:url(imagenes/logorari.png); cursor:pointer; background-position:center; background-size:contain; height:85px; width:100%; background-repeat:no-repeat;"></div>
</td>
<td width="30%" align="left">

<h1 style="color:#999;"><?php echo $encabezadoURL; ?></h1></td>
</tr>
<tr></tr>
</table>












</div>
<div class="cuerpo">
<div class="barraIzq">
<table width="100%">
<tr><td height="300px;" align="center">
<div style="background-image:url(imagenes/imagenrarilat.png); background-size:contain; height:60%; width:85%; background-repeat:no-repeat;"></div>
</td></tr>
<tr><td style="border-top:#666 1px dashed;">
<div style="padding:5px">
<br/>
<h3>Seguir a SENASICA</h3>
<a title="Ir a facebook" href="http://www.facebook.com/senasica?ref=ts&fref=ts" TARGET='_blank'>
<div style="background-image:url(imagenes/iconos-redes/facebook.png); background-repeat:no-repeat; width:120px; height:40px; background-size:contain;">
</div>
</a>
<a title="Ir a twitter" href="http://twitter.com/senasica" TARGET='_blank'>
<div style="background-image:url(imagenes/iconos-redes/twitter.png); background-repeat:no-repeat; width:120px; height:40px; background-size:contain;">
</div>
</a>
<a title="Ir a youtube" href="http://www.youtube.com/user/senasica1" TARGET='_blank'>
<div style="background-image:url(imagenes/iconos-redes/youtube.png); background-repeat:no-repeat; width:120px; height:40px; background-size:contain;">
</div>
</a>
<br/>
<br/>
<br/><!--
<div id="suscribirse" style="width:95%; margin-left:-8px; padding-top:1px; padding-bottom:1px; padding-left:10px; border-radius:3px; background-color:#063"><h3 style="color:#FFF;">Suscribirse a noticias RARI</h3></div>-->
 </div>
</td></tr>
<tr>
<td>
<a href="about.php">
<div style="width:95%; cursor:pointer; padding-top:1px; padding-bottom:1px; padding-left:10px; border-radius:3px; background-color:#063"><h3 style="color:#FFF;"><span style="color:#ddd">Acerca de RARI</span></h3></div></a>

<br/>

<!-- <a href="suscribirse.php">
<div style="width:95%; cursor:pointer; padding-top:1px; padding-bottom:1px; padding-left:10px; border-radius:3px; background-color:#063"><h3 style="color:#FFF;"><span style="color:#ddd">Suscribirse a RARI</span></h3></div></a>
ESTA LINEA SE COMENTÓ A PETICIÓN DE LA UIS, ES PARA DESAPARECER EL BOTÓN "SUSCRIBIRSE A RARI" --> </td></tr> 
</table>
</div>

<div class="centro">
<table height="800px;" width="100%">
<tr>
<td>
<div id="n_nacioneales" style="width:100%; height:400px;">
<input type="hidden" id="corriendo" value="1" />
<?php include('php/consultaNoticias.php'); ?>
</div>
<div id="noticiasUISc" style="width:100%; height:400px; margin-top:10px;  float: left;">
<div style="background-color:#535353; padding-top:5px; height:25px; text-align:center; width:100%;">
<span style="font-size:16px; font-weight:bolder; color:#FFF; text-shadow: 0.1em 0.1em #444;">Comunicados Internacionales   </span>
</div>


<?php include('php/consultaNoticiasUIS.php'); ?>


</div>
<div style="text-align:center">
<a href="historia.php?r=not_inter"> Histórico de Comunicados</a></div>
</td>
<td style="border-left:1px dashed #cdcdcd;" width="18%">



<div style="width:95%; height:100%; text-align:center;">
<h2>Conceptualización de comunicados en RARI</h2>
<table align="center" width="100%">
<tr>
<td align="center"> <div id="tabAlerta" style="background-image:url(imagenes/tipo_comunicados/alerta.png); border-bottom: #27C54A solid 3px; background-position:center; background-size:contain;" class="tab">
 </div >Alertas </td>

<td align="center" > <div id="tabCuarentena" style="background-image:url(imagenes/tipo_comunicados/cuarentena.png); background-position:center; background-size:contain;" class="tab">
 </div >Cuarentenas</td>

<td align="center"> <div id="tabInformacion" style="background-image:url(imagenes/tipo_comunicados/informacion.png); background-position:center; background-size:contain;" class="tab"> 
 </div >Información</td>
</tr>
<tr>
<td colspan="3"><hr/></td>
</tr>


<tr>
<td align="center"> <div id="tabNoticia" style="background-image:url(imagenes/tipo_comunicados/noticia.png); background-position:center; background-size:contain;" class="tab">
 </div >Noticias </td>

<td align="center"> <div id="tabRechazo" style="background-image:url(imagenes/tipo_comunicados/rechazo.png); background-position:center; background-size:contain;" class="tab">
 </div >Cancelación</td>
 
 <td align="center"> <div id="tabRetencion" style="background-image:url(imagenes/tipo_comunicados/retencion.png); background-position:center; background-size:contain;" class="tab">
 </div >Retención</td>
</tr>
</table>
<div id="tipoAlerta" style="width:100%; height:300px; overflow:auto; padding:5px;">
<div id="alertasDesc" class="desc">
<h3>Alerta</h3>
<p>Advierte sobre la potencial introducción, dispersión o establecimiento de un riesgo para la salud humana y/o las especies endémicas y de producción nacional, sean estas vegetales, animales, acuícolas o pesqueras; y que obliga a las áreas involucradas, a poner en marcha los protocolos de vigilancia y reacción temprana establecidos, de acuerdo a las competencias y atribuciones del SENASICA.</p>
</div>
<div id="cuarentenasDesc" class="desc" style="display:none;">
<h3>Cuarentenas</h3>
<p>(Salud Animal) Se usa para publicar comunicados de medidas preventivas, restrictivas y de actividades zoosanitarias, que se desarrollen para evitar la propagación de una enfermedad en una región a partir de un foco notificado; o bien, para impedir la introducción de una enfermedad a una región, entidad federativa o el territorio nacional.</p>
<p>(Sanidad Vegetal) Se usa para publicar comunicados en las que se aplican restricciones a la movilización de mercancías que se establecen en disposiciones legales aplicables, con el propósito de prevenir o retardar la introducción de plagas en áreas donde no se sabe que existan.</p>
</div>
<div id="informacionesDesc" class="desc" style="display:none;">
<h3>Información</h3>
<p>Comunicados emitidos de manera oficial referente a información relevante que tenga relación con la mitigación de riesgos dentro del sector, tales como: Declaración de Zonas libres, Cambio de estatus (erradicación de plagas y enfermedades), cambio en las NOM.</p>
</div>
<div id="noticiasDesc" class="desc" style="display:none;">
<h3>Noticias</h3>
<p>Comunicados relacionados con las sanidades, investigaciones científicas e innovaciones tecnológicas acerca de plagas y enfermedades fitozoosanitarias</p>
</div>
<div id="cancelacionesDesc" class="desc" style="display:none;">
<h3>Cancelación</h3>
<p>Son los Comunicados de remesas de alimentos e insumos que se han examinado y rechazado en las fronteras exteriores al detectarse un riesgo sanitario.</p>
</div>
<div id="retencionesDesc" class="desc" style="display:none;">
<h3>Retención</h3>
<p>Comunicado que ordena la Secretaría para asegurar temporalmente mercancía agrícola o pecuaria, desechos, despojos, productos químicos, farmacéuticos, biológicos o alimenticios, considerados como de riesgo fitozoosanitario, mismo que conlleva a 3 medidas sanitarias: análisis de riesgo, rechazo, destrucción o acondicionamiento.</p>
</div>
</div>
<div style="height:200px; margin:auto;">
<h3>Monitoreo para la detección de riesgos</h3>
<div style="font-size:10px; margin-left:5px; float:left;">
<a title="Organización Norteamericana de Protección a las Plantas" href="http://www.nappo.org/es/?" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/NAPPO.png);"></div></a>
<a title="Convención Internacional de Protección Fitosanitaria" href="https://www.ippc.int/index.php?id=1110589&no_cache=1&L=1&language=es" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/IPPC.png);"></div></a>
<a title="European and Mediterranean Plant Protection Organization" href="http://www.eppo.int/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/EMPPO.png);"></div></a>
<a title="Rapid Alert System for Food and Feed" href="http://ec.europa.eu/food/food/rapidalert/index_en.htm" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/RASFF.png);"></div></a>
<a title="Sistema de Alerta Rápida para Productos no Alimentarios" href="http://ec.europa.eu/consumers/safety/rapex/index_en.htm" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/RAPEX.png);"></div></a>
<a title="Codex Alimentarius" href="http://www.codexalimentarius.org/about-codex/que-es-el-codex/es/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/CODEX.png);"></div></a>
<a title="Organización Mundial de Sanidad Animal" href="http://www.oie.int/es/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/OIE.png);"></div></a>
<a title="HealthMap" href="http://healthmap.org/es/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/HEALTMAP.png);"></div></a>
<a title="Portal SINAVEF" href="http://portal.sinavef.gob.mx/alertasMenu.php" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/ALERTAS%20SINAVEF.png);"></div></a>

<a title="Centre for Agricultural Bioscience International" href="http://www.cabi.org/default.aspx" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/Cabi.png);"></div></a>
<a title="Organización Mundial de la Salud" href="http://www.who.int/es/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/OMS.png);"></div></a>
<a title="Organización Mundial del Comercio" href="http://www.wto.org/indexsp.htm" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/OMC.png);"></div></a>
<a title="Organizacion de las Naciones Unidas para la Alimentación y la Agricultura" href="http://www.fao.org/home/es/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/FAO.png);"></div></a>
<a title="Food Safety News" href="http://www.foodsafetynews.com/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/FSN.png);"></div></a>
<a title="Boletín de Intoxicación Alimentaria" href="http://foodpoisoningbulletin.com/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/Food%20poisoning%20bulletin.png);"></div></a>
<a title="The Center for Food Security & Public Health" href="http://www.cfsph.iastate.edu/?lang=en" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/cfsph-logo.gif); width:60px;"></div></a>
<a title="Animal and Plant Health Inspection Service" href="http://www.aphis.usda.gov/wps/portal/aphis/home/" target="_blank"><div class="enlace" style="background-image:url(imagenes/seguimiento/APHIS.png);"></div></a>
</div>
</div>
</td>
</tr>
<tr><td><div class="bannerPie" style="width:100%; background-color:#FFF;  min-width:900px; bottom:0; background-image:url(imagenes/footer.jpg); background-position:center; background-repeat:no-repeat; background-size:contain; height:180px; ">
</div></td></tr>
</table>

</div>

</div>






</div>

</body>
</html>