<?php 
include('php/restriccionAcceso.php');
require_once('Connections/rari_coneccion.php');
require_once 'php/detalles.php';
function recortarTexto($texto, $longitud)
{
	 //$texto=$row_catalogo['resumen'];
 
 if(strlen($texto)>$longitud)
 {
 $posicion=strripos(substr($texto,0,$longitud)," ");
 $texto= substr($texto,0,$posicion)."...";
 }
 
 return $texto;
	}
function obtenerDiaSemana($fecha)
{
$dias=array("Domingo","Lunes","Martes","Miércoles" ,"Jueves","Viernes","Sábado");

//$fecha="1982-12-09" ;
$dia=substr($fecha,8,2);
$mes=substr($fecha,5,2);
$anio=substr($fecha,0,4);
$pru=$dias[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))];
return $pru;
	}


 function fecha($fecha=""){ 
        
        $mesArray = array( 
            1 => "Enero",
            2 => "Febrero",
             3 => "Marzo",
             4 => "Abril", 
             5 => "Mayo",
              6 => "Junio", 
              7 => "Julio", 
              8 => "Agosto",
           9 => "Septiembre", 
           10 => "Octubre", 
           11 => "Noviembre", 
           12 => "Diciembre" 
         );
         
        
        $nombreDiaArray = array( 
		0 => "Domingo",
            1 => "Lunes",
            2 => "Martes",
             3 => "Miércoles",
             4 => "Jueves", 
             5 => "Viernes",
              6 => "Sábado", 
               
        ); 
		
		if($fecha=="")
		{
		$mes = date("n");  
		$dia = date("d"); 
        $anio = date ("Y"); 
		
		
		}
		else
		{
			$array=explode ("-",$fecha);
			$dia=$array[2];
			$mes=$array[1];
			$anio=$array[0];
			}
		
		
		
        $mesReturn = $mesArray[intval($mes)]; 
        $nombreDiaReturn = $nombreDiaArray[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))];
        
        return $nombreDiaReturn." ".intval($dia)." de ".$mesReturn." de ".$anio; 
    }
	?>

<?php 

function sumarVisita($database_rari_coneccion, $rari_coneccion, $idComunicado){
	$insertSQL="UPDATE tbl_comunicado set visto_por_publico=visto_por_publico+1 where id=".$idComunicado;
mysql_select_db($database_rari_coneccion, $rari_coneccion);
  $Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
}

function obtenerLocalizacionComunicado( $database_rari_coneccion, $rari_coneccion, $idComunicado){
	$det_bitacoraSQL="select concat(det_comunicado_localizacion.region ,' (',tbl_paises.nombre,')') as Lugar from det_comunicado_localizacion
inner join tbl_paises on det_comunicado_localizacion.idPais=tbl_paises.id where det_comunicado_localizacion.idComunicado=".$idComunicado;
	mysql_select_db($database_rari_coneccion, $rari_coneccion);
  	$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	$salida="";
	while($row_det_bitacora = mysql_fetch_assoc($det_bitacora))
	{
		if($salida!="")
		$salida=$salida.", ";
		$salida=$salida.$row_det_bitacora['Lugar'];
	}
	return $salida;
}

function establecerTextos($title, $catal, $arreglo, $database_rari_coneccion, $rari_coneccion){

$cad="<h3>".$title."</h3>";
for ($i=0;$i<count($arreglo);$i++) 
{
	$cad=$cad."> ". obtenerNombreCampo($arreglo[$i], $catal, $database_rari_coneccion, $rari_coneccion)."<br/>";
	}
 return $cad."<br/>";
}



	

$det_bitacoraSQL="select tbl_comunicado.id, tbl_comunicado.imagen, tbl_comunicado.titulo, tbl_comunicado.fecha, tbl_comunicado.resumen, tbl_usuarios.nombre, tbl_usuarios.apellido from tbl_comunicado inner join tbl_usuarios on tbl_comunicado.idUsuario=tbl_usuarios.id where autorizacion=1  order by fecha desc";

	mysql_select_db($database_rari_coneccion, $rari_coneccion);
  	$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	
	$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="imagenes/tipo_comunicados/rari-icono.png" type="image/x-icon" rel="shortcut icon" />
<title>RARI-SENASICA</title>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<link href="css/noticias.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/Concurrent.Thread.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="plugins/controlador_historicos.js"></script>
<style>
.titls{
color:#C30; text-decoration:none;
}
.titls:hover{
	text-decoration:underline;
	color:#C00;
}
</style>
</head><body>
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

<h1 style="color:#999;">rari-<span style="color:#555;">senasica</span>.gob.mx</h1></td>
</tr>
<tr></tr>
</table>
</div>


<div class="centro" style="width:100%;  min-width:900px; float:left; position:relative;">




<div style="width:70%; background-color:#fff; min-height:600px; min-width:900px; margin:auto; position:relative; text-align:justify;">
<div style="background-color:#efefef; text-align:center; padding:1px; padding-left:5px;">
<h3>Últimas noticias en <?php 
if(isset($_GET['r'])){
if($_GET['r']!="not_inter") echo base64_decode(base64_decode($_GET['r'])); else if($_GET['r']=="not_inter") echo 'Comunicados Internacionales';
}else echo "Sanidad Vegetal" ?></h3>
</div>
<input type="hidden" id="total" value="0" />
<input type="hidden" id="modulo" value="<?php if(isset($_GET['r'])) echo $_GET['r']?>" />
<table id="comunicados" class="noticias" width="100%">
<tbody>




</tbody>

</table>



<div id="vermas" style="background-color:#efefef; cursor:pointer; margin-top:5px; margin-bottom:5px; text-align:center; padding:1px;">
<h3>Ver más noticias</h3>
</div>
<div class="bannerPie" style="width:100%; background-color:#FFF;  min-width:900px; bottom:0; background-image:url(imagenes/footer.jpg); background-position:center; background-repeat:no-repeat; background-size:contain; height:180px; ">

</div>
</div>
</div>




</body>
</html>