<?php include('php/restriccionAcceso.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="imagenes/tipo_comunicados/rari-icono.png" type="image/x-icon" rel="shortcut icon" />
<title>RARI-SENASICA</title>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<link href="css/estilo_publico.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/Concurrent.Thread.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="plugins/uis-plugin.js"></script>
<script type="text/javascript" src="plugins/controlador_suscribirse.js"></script>

<?php include('Connections/variables.php');?>

</head><body style="background-color:#FFF;">
<div id="encabezado" class="encabezado" >
<table height="100px" width="80%" align="center" style="min-width:950px;">
<tr>
<td align="center">
<div style="background-image:url(imagenes/sagarpa%20negro.png); background-position:center; background-size:contain; height:80px; width:100%; background-repeat:no-repeat;"></div>
</td>
<td align="center">
<div style="background-image:url(imagenes/senasica.png); background-position:center; background-size:contain; height:60px; width:100%; background-repeat:no-repeat;"></div>
</td>
<td>
<a href="index.php">
<div id="rari" style="background-image:url(imagenes/logorari.png); cursor:pointer; background-position:center; background-size:contain; height:85px; width:100%; background-repeat:no-repeat;"></div></a>
</td>
<td width="30%" align="left">

<h1 style="color:#999;"><?php echo $encabezadoURL; ?></h1></td>
</tr>
<tr></tr>
</table>
</div>


<div class="centro" style="width:100%;  min-width:900px; float:left; position:relative;">


<div style="width:70%; min-height:600px; min-width:900px; margin:auto; padding:10px; text-align:justify;">




<h2>Suscribirse a noticias RARI</h2>

<div id="fff" style=" width:40%; height:400px; background-image: url(http://www.nisergon.com.mx/img/loading2.gif); background-position:center; background-repeat:no-repeat; float:left;">


<div id="formularioDiv" style="width:100%; background-color:#FFF; height:400px;">
<form id="frm_suscripcion" name="frm_suscripcion" style="margin:auto;">
<table>
<tr><td colspan="3"><h3>Datos del suscriptor</h3></td></tr>
<tr><td colspan="3" align="center">
<input type="text" id="correo" name="correo" placeholder="Correo electrónico" />
</td></tr>
<tr><td colspan="3" align="center">
<input type="text" id="nombre" name="nombre" placeholder="Nombre" />
</td></tr>
<tr><td colspan="3" align="center">
<input type="text" id="apPaterno" name="apPaterno" placeholder="Apellido Paterno" />
</td></tr>
<tr><td colspan="3" align="center">
<input type="text" name="apMaterno" placeholder="Apellido Materno" />
</td></tr>
<tr><td colspan="3" align="center">
<input type="text" id="institucion" name="institucion" placeholder="¿De que institución nos visita?" />
</td></tr>
<tr height="50px;"><td colspan="3"><h3>Fecha de nacimiento</h3></td></tr>
<tr><td>Día: 
<select name="dia">
<?php 
	for($i=1; $i<32; $i++)
		echo '<option value="'.$i.'"'.'>'.$i.'</option>';
?>
</select>
</td>
<td>Mes: 
<select name="mes">
<option value="1">Enero</option>
<option value="2">Febrero</option>
<option value="3">Marzo</option>
<option value="4">Abril</option>
<option value="5">Mayo</option>
<option value="6">Junio</option>
<option value="7">Julio</option>
<option value="8">Agosto</option>
<option value="9">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>
</select>
</td>
<td>Año: 
<select name="anio">
<?php 
	for($i=$i=(date("Y")); $i>=(date("Y")-90);  $i--)
		echo '<option value="'.$i.'"'.'>'.$i.'</option>';
?>
</select>
</td></tr>
<tr><td colspan="3" align="center">
<hr/>
<input type="button" id="btnSusc" name="suscribirse" value="Suscribirse" style="width:120px;"/>
</td></tr>
</table>
</form>
</div>



</div>


<div style="width:50%; float:right; height:400px;">

<div style="width:100%; height:100%; background-color:#FFF;">
<h2>¿Por qué RARI solicita esta información acerca de mi?</h2>
Rari solicita esta información para llevar un control estadístico de toda persona que recibe comunicados vía correo electrónico. En ningún momento y por ningún motivo RARI revela esta información. 
</div>

<div style="width:100%; height:100%; display:none; background-repeat:no-repeat; background-position:center; background-image:url(imagenes/imagenrarilat.png);"></div>

</div>



<div id="divLoadSusc" style="width:100%; height:100%; display:none;">
 <h2>Cargando... Por favor espere!</h2>
</div>
</div>
 
<div style="width:100%; height:180px;"></div>
</div>




</div>
</div>
<div class="bannerPie" style="width:100%; background-color:#FFF;  min-width:900px; bottom:0; background-image:url(imagenes/footer.jpg); background-position:center; background-repeat:no-repeat; background-size:contain; position:fixed; height:180px; ">
</div>



</body>
</html>