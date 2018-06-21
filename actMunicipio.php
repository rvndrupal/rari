<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once('Connections/rari_coneccion.php'); ?>

     
      <?php 
	  
		$q=$_POST['q'];
		
     	$mysql_obtener_municipios = "SELECT * FROM rari.tbl_municipios where idEstado = '".$q."';";
     	$municipios = mysql_query($mysql_obtener_municipios, $rari_coneccion) or die(mysql_error());
     	$row_municipios = mysql_fetch_assoc($municipios);
     	
     	do
		{
     		//echo '<option value="'.$row_municipios['id'].'" ' .(($row_municipios['id'] == $row_user['idMunicipio'])? "selected":"").' >'.$row_municipios['nombre'].'</option>';     			
			echo '<option value="'.$row_municipios['id'].'" ' .(($row_municipios['id'] == $q)? "selected":"").' >'.$row_municipios['nombre'].'</option>';     			
     	}
		while ($row_municipios = mysql_fetch_assoc($municipios));
     	
     
     ?>
     
