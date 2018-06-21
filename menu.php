<?php include('php/restriccionAcceso.php'); ?>
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

<?php include('Connections/variables.php');?>
<?php 

if($_GET['mod']==0)
{
	$MM_restrictGoTo = "bienvenido.php";
	 header("Location: ". $MM_restrictGoTo);
	}


$pagina="form";
include('php/controlTemas.php');

$rol=$_SESSION['idRol'];
$area=$_SESSION['area'];
$nivel=$_SESSION['nivel']; 
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
    <div id="rari_tit"><?php echo $encabezadoURL; ?></div>
  </div>
  
  <div id="menu">
  
  </div>
  
  <div id="contenido"><!-- InstanceBeginEditable name="RegionCuerpo" --> 
  <div class="lineasverticales">
  </div>
  
  
  <div class="etiqueta-der" onclick="window.location='<?php echo $logoutAction ?>';" style="width:15%; cursor:pointer;">
 <div class="recuadro-interior">
Salir
 </div> 
 <span class="triangulo-der"></span>
 </div>
 
 
  <div id="volver-menu" class="etiqueta" onclick="window.location='bienvenido.php';">
 <div class="recuadro-interior">
 Volver al menú
 </div> 
 <span class="triangulo-izq"></span>
 </div>
 
 
 <div class="etiqueta" style="width:63%">
 <div class="recuadro-interior" style="text-align:right" >
 Bienvenido <?php echo $_SESSION['nombre'];?>
 </div> 
 <span class="triangulo-izq"></span>
 </div>
 
  <div class="cuadro-modulo" style="background-image:url(imagenes/iconsanidadv.jpg);"> 
 <div class="recuadro-interior" style="height:228px; font-size:20px;">
  <table width="100%" height="100%" align="center">
  <tr height="130px"><td align="center"><div class="imagen-modulo"></div></td></tr>
  <tr><td align="center"><?php echo $etiqueta; ?></td></tr>
  </table>
  </div>
 </div>
 
 <div class="lineasverticales">
  </div>
 
 <div class="etiqueta-completa">
  
  <div class="recuadro-interior" style="height:150px">
  
  
  <table align="center" <?php if((($area==$modulo)||($rol==1))&&$nivel!=3) echo 'width="70%"'; else echo 'width="40%"'?> >
  <tr>
  <?php if((($area==$modulo)&&($nivel!=3)||$rol==1)){?>
  <td align="center">
  
  
  <div class="rectangulo-opciones" onclick="window.location='form.php?mod=<?php echo $modulo?>';">
  <div class="recuadro-interior" style="height:116px; font-size:11px;">
  <table align="center" width="100%" height="100%">
  <tr><td height="75"><div id="imagen-agregar-comunicado" class="imagen-cuadro-modulo"></div></td></tr>
  <tr><td>Agregar comunicado</td></tr>
  </table>
  </div></div>
 
  
  </td>
   <?php }?>
  <td align="center">
  
  
  <div class="rectangulo-opciones" onclick="window.location='listado.php?mod=<?php echo $modulo?>';">
  <div class="recuadro-interior" style="height:116px; font-size:11px;">
  <table align="center">
  <tr><td height="75" ><div id="imagen-lista-comunicado" class="imagen-cuadro-modulo"></div></td></tr>
  <tr><td>Lista de comunicados</td></tr>
  </table>
  </div></div>
  
  
  </td>
  <td align="center">
  
  
  <div class="rectangulo-opciones" onclick="window.location='estadisticas.php?mod=<?php echo $modulo?>';">
  <div class="recuadro-interior" style="height:116px; font-size:11px;">
  <table align="center">
   <tr><td height="75" ><div id="imagen-estadisticas" class="imagen-cuadro-modulo"></div></td></tr>
  <tr><td>Estadísticas de comunicados</td></tr>
  </table>
  </div></div>
  
  
  </td>
  <?php if((($area==$modulo)||($rol==1))&&$nivel==1){?>
  
  <td align="center">
 
 
  <div class="rectangulo-opciones" onclick="window.location='listado.php?mod=<?php echo $modulo?>&updt=true';">
  <div class="recuadro-interior" style="height:116px; font-size:11px;">
  <table align="center">
  <tr><td height="75" ><div id="imagen-editar-catalogo" class="imagen-cuadro-modulo"></div></td></tr>
  <tr><td>Edita tus comunicados</td></tr>
  </table>
  </div></div>
  
  
  </td>
  
  <?php }?>
  </tr>
  </table>
  

    
    </div>
    <span class="triangulo-izq"></span><span class="triangulo-der"></span>
 </div>
  
  


 
 
 
 <div class="lineasverticales">
  </div>
  
  <!-- InstanceEndEditable --></div>
  
  <div id= "footer" ></div>
</div>
</body>
<!-- InstanceEnd --></html>
