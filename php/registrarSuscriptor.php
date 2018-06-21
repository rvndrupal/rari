<?php 

require_once('../Connections/rari_coneccion.php'); 

if(isset($_POST['correo'])&&isset($_POST['nombre'])&&isset($_POST['apPaterno'])&&$_POST['correo']!=""&&$_POST['nombre']!=""&&$_POST['apPaterno']!="")
{
	
	$apellidos=$_POST['apPaterno'];
	if(isset($_POST['apMaterno']))
	$apellidos=$apellidos." ". $_POST['apMaterno'];
	
	$fecha=$_POST['anio']."-".$_POST['mes']."-".$_POST['dia'];
	
	$institucion="null";
	if(isset($_POST['institucion']))
	$institucion=$_POST['institucion'];
	
$insertSQL ="INSERT INTO tbl_suscriptores (nombre, apellidos, fecha_nacimiento, correo, institucion) VALUES ('".$_POST['nombre']."','".$apellidos."', '".$fecha."', '".$_POST['correo']."','".$institucion."')";


  mysql_select_db($database_rari_coneccion, $rari_coneccion);
  $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
  
  
  ?>
  <span style="font-size:18px;">Su registro a la Red de Alerta Rápida Interna se llevó a cabo de forma correcta</span>
  <br/>
  <a href="index.php">(Volver al inicio)</a>
  <?php
  
  
}
else
{
	?>
	
	<span style="font-size:18px;">No se pudo completar su registro</span>
  <br/>
  <a href="suscribirse.php">(Intentar de nuevo)</a>
	<?php
	}

?>