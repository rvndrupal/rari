<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('php/inicioSesion.php'); ?>
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
$pagina="index";
include('php/controlTemas.php'); 
establecerColores($color_vegetal_primario,$color_animal_primario,$color_inocuidad_primario,$color_inspeccion_primario,$color_sanidad_primario,$color_noticias_primario);
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

<div id="cuerpo">
  <div id="header">
    <div id="encabezado"> </div>
    <div id="rari_tit">rari-senasica.gob.mx</div>
  </div>
  
  <div id="menu">
  
  </div>
  
  <div id="contenido"><!-- InstanceBeginEditable name="RegionCuerpo" --> 
 


 <div class="lineasverticales">
 </div>
 


    
  
   <table align="center">
   <tr>
   <td><div id="loginimagecenter"></div></td>
   </tr>
   </table>

 
 <div class="lineasverticales">
 </div>
   
      <div class="etiqueta" style="width:70%; background-color:#030">
 <div class="recuadro-interior">
 <form action="<?php echo $loginFormAction; ?>" name="login" method="POST" class="login">
  <table>
  <tr><td>Usuario</td><td>Contraseña</td><td></td></tr>
  <tr><td><input name="usuario" type="text" id="usuario" /></td><td><input name="password" type="password" id="password"></td><td><input id="ingresar" style="width:110px; border:0px;" name="login" type="submit" value="Ingresar"/></td></tr>
  <tr><td colspan="2"></td></tr>
  </table>
   
    </form>
 </div> 
 <span class="triangulo-izq"></span>
 </div>



   
   <div class="lineasverticales">
  </div>
  <!-- InstanceEndEditable --></div>
  
  <div id= "footer" ></div>
</div>
</body>
<!-- InstanceEnd --></html>

