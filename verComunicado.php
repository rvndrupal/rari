<?php 
include('php/restriccionAcceso.php');
require_once('Connections/rari_coneccion.php');
require_once 'php/detalles.php';
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

$idAlerta=base64_decode(base64_decode($_GET['r']));


	sumarVisita($database_rari_coneccion, $rari_coneccion, $idAlerta);

$det_bitacoraSQL="select *from tbl_comunicado where autorizacion=1 and id=".$idAlerta;

	mysql_select_db($database_rari_coneccion, $rari_coneccion);
  	$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	$row_det_bitacora = mysql_fetch_assoc($det_bitacora);
	$totalRows_det_bitacora = mysql_num_rows($det_bitacora);
	
	if($totalRows_det_bitacora!=1)
	{
		$GoTo = "index.php";			
header(sprintf("Location: %s", $GoTo));
		}
		
$idArea=$row_det_bitacora['idArea'];

$fecha=$row_det_bitacora['fecha'];
	
$titulo=$row_det_bitacora['titulo'];

$imagen="archivos_alertas/imagenes/".$row_det_bitacora['imagen'];
//copy($_FILES['imagen']['tmp_name'],"archivos_alertas/tmp/".$imagen);

$fecha=$row_det_bitacora['fecha'];

$tipoComunicado=1;

 $arreglo_agentes=obtenerDetalles($idAlerta, 1, $database_rari_coneccion, $rari_coneccion);
 
 
 $arreglo_enlaces= obtenerDetalleEnlaces($idAlerta, $database_rari_coneccion, $rari_coneccion);
 
 $arreglo_productos=obtenerDetalles($idAlerta, 8, $database_rari_coneccion, $rari_coneccion);
 
 $arreglo_localizaciones=obtenerDetalleLoc($idAlerta,$database_rari_coneccion, $rari_coneccion);
 
  
$arreglo_oisas=obtenerDetalles($idAlerta, 7, $database_rari_coneccion, $rari_coneccion);


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




?>
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
<script type="text/javascript" src="plugins/controlador_comunicado.js"></script>


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


<div style="box-shadow:1px 1px 5px #000;
	-moz-box-shadow:1px 1px 5px #000;
	-webkit-box-shadow:1px 1px 5px #000; text-align:center; color:#eee;  padding:5px; float: left; background-color: #0376CB; position: static; margin-right:5px;">Visto<br/><span style="font-size:24px; color:#fff; text-shadow: 0.05em 0.05em #666; font-weight:bolder;"><?php echo $row_det_bitacora['visto_por_publico']; ?></span><br/><?php echo ($row_det_bitacora['visto_por_publico']>1?"Veces":"Vez"); ?></div>



<div style="width:70%; background-color:#efefef; min-height:600px; min-width:900px; margin:auto; position:relative; padding:10px; text-align:justify;">


<h1><?php echo $titulo; ?></h1>


<div style="width:500px; border:2px solid #666; float:left; height:360px; margin-right:10px; margin-bottom:10px; background-repeat:no-repeat; background-image:url(archivos_alertas/imagenes/<?php echo  $row_det_bitacora['imagen'];?>); background-position:center; background-size:cover;">
</div>
<span style="color:#960"><?php echo fecha($fecha); ?>.- </span>
<?php echo $contenido; ?>


<?php  

echo establecerTextos("Productos/Hospederos", "cat_productos", $arreglo_productos, $database_rari_coneccion, $rari_coneccion);

echo establecerTextos("Agentes", "cat_agentes", $arreglo_agentes, $database_rari_coneccion, $rari_coneccion);



?>
<h3>Localización</h3> 
 <?php echo obtenerLocalizacionComunicado( $database_rari_coneccion, $rari_coneccion, $row_det_bitacora['id'],true); ?>
 
<h3>Enlaces</h3> 
<?php 
for($i=0; $i<count($arreglo_enlaces); $i++){
	echo "<a href='".$arreglo_enlaces[$i]."'  TARGET='_blank'>".$arreglo_enlaces[$i]."</a><br/>";
}

?>
 
 
<div style="width:100%; height:130px;"></div>
</div>




</div>
</div>
<div class="bannerPie" style="width:100%; display:none; min-width:900px; border-top:1px groove #ccc; bottom:0; background-color:#333; overflow:auto; position:fixed; height:120px; ">
<table align="center"><tr><td>
<?php include('php/consultaNoticiasTOP.php'); ?>
</td></tr></table>
</div>



</body>
</html>