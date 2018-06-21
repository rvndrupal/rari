<?php 
require_once('../Connections/rari_coneccion.php');

if(isset($_POST['cantidad'])&&isset($_POST['area']))
{
	$ultimo=$_POST['cantidad'];
	$inicio=$_POST['cantidad'];
	$registros=10;
	
	$area=1;
	
	if($_POST['area']!="")
	{
	
	
	$texto=base64_decode(base64_decode($_POST['area']));
	if($texto=="Sanidad Vegetal")
	{
		$area=1;
	}
	else if($texto=="Salud Animal"){
		$area=2;
		}
	else if($texto=="Inocuidad Agroalimentaria"){
		$area=3;
		}
	else if($texto=="Inspección fitozoosanitaria"){
		$area=4;
		}
	else if($texto=="Sanidad acuicola y pesquera"){
		$area=5;
		}
	else if($_POST['area']=="not_inter"){
	$texto="Comunicados Internacionales";
	$area=6;}
	else {
		$MM_restrictGoTo = "index.php";
	 header("Location: ". $MM_restrictGoTo);
	}
	
	}
	
	
	
	
	
	$det_bitacoraSQL="select tbl_comunicado.id, tbl_comunicado.imagen, tbl_comunicado.titulo, tbl_comunicado.fecha, tbl_comunicado.resumen, tbl_usuarios.nombre, tbl_usuarios.apellido from tbl_comunicado inner join tbl_usuarios on tbl_comunicado.idUsuario=tbl_usuarios.id where autorizacion=1 and tbl_comunicado.idArea=".$area." order by fecha desc "." LIMIT ".$inicio.",".$registros;


//echo '<tr><td>'.$texto.'</td></tr>';


	mysql_select_db($database_rari_coneccion, $rari_coneccion);
  	$det_bitacora = mysql_query($det_bitacoraSQL, $rari_coneccion) or die(mysql_error());
	?>
	
    <?php while($row_det_bitacora = mysql_fetch_assoc($det_bitacora)){
	$id= base64_encode(base64_encode($row_det_bitacora['id']));
	$ultimo++;
	?>
<tr >
<td><img src="archivos_alertas/imagenes/<?php echo $row_det_bitacora['imagen'];?>" width="80px" height="auto" style="height:auto !important" /></td><td>
<a href="verComunicado.php?r=<?php echo $id ?>" class="titls"><span style="color:#C30; font-size:20px;"><?php echo $row_det_bitacora['titulo'];?></span></a><br/> 

<span style="color:#aaa; font-size:12px;"><?php echo fecha($row_det_bitacora['fecha']);?></span>.- 
<?php echo recortarTexto(strip_tags($row_det_bitacora['resumen']),420);?> <br/><span style="color:#aaa; font-size:12px;">por <?php echo utf8_encode($row_det_bitacora['nombre']." ".$row_det_bitacora['apellido']);?></span></td>
</tr>

<?php }
echo "¬".$ultimo;
//
?>
    
	
	<?php
	}

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