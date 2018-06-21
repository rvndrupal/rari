<?php
	// Valida si existe variables de sesión. LVC 4-Junio-2018
	if (!isset($_SESSION)) 
	{
		session_start();
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once('Connections/rari_coneccion.php'); ?>
<?php
	if (!function_exists("GetSQLValueString")) 
	{
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
			if (PHP_VERSION < 6) 
			{
				$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}

			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

			switch ($theType) 
			{
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;    
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					break;
				case "double":
					$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
					break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
					break;
			}
			return $theValue;
		}
	}

	if(isset($_GET['area'])&&isset($_GET['rol']))
	{
		//Se crearán unas modificaciones para implementar los permisos de usuarios. LVC 5-Junio-2018
		//Cambiará el nivel. Se usará uno para cada rol.
		
		$rol=$_GET['rol'];
		$area=$_GET['area'];		
		$irol=$_GET['irol'];
		
		if($rol!=1)
			$_GET['iarea']=$_GET['area'];
		
		/* Código original.
		if($irol==3)
			$_GET['inivel']=3;
		*/
		
		if($irol==1)
			$_GET['inivel']=1;
		else if($irol==2)
			$_GET['inivel']=2;
		else if($irol==3)
			$_GET['inivel']=3;
		else if($irol==4)
			$_GET['inivel']=4;
		else if($irol==5)
			$_GET['inivel']=5;
		
		$inivel=$_GET['inivel'];
		$iarea=$_GET['iarea'];		
		$inombre=$_GET['inombre'];
		$iapellidos=$_GET['iapellidos'];
		$iusuario=$_GET['iusuario'];
		$ipass=$_GET['contra'];
		
		$insertSQL ="INSERT INTO tbl_usuarios (idArea, idRol, nivel, acceso_login, acceso_password, nombre, apellido, idEstado, idMunicipio, sexo) VALUES (".$iarea.", ".$irol.", ".$inivel.", '".$iusuario."', '".md5($ipass)."', '".$inombre."', '".$iapellidos."',1,1,1)";
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($insertSQL, $rari_coneccion) or die(mysql_error());
	}

	if(isset($rol)&&isset($area))
	{
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$query_usuarios = "SELECT tbl_usuarios.id, tbl_usuarios.idArea, tbl_usuarios.idRol, tbl_usuarios.nivel, tbl_usuarios.nombre as nombreUsuario, tbl_usuarios.apellido, tbl_usuarios.dependencia, tbl_areas.color_p, tbl_roles.nombre as nombreRol, tbl_usuarios.estatus as estatus FROM tbl_usuarios inner join tbl_areas on tbl_usuarios.idArea=tbl_areas.id inner join tbl_roles on tbl_usuarios.idRol=tbl_roles.id";
		
		if($rol!=1)
		{
			$query_usuarios=$query_usuarios.' where tbl_usuarios.idArea='.$area.' ORDER BY nombreUsuario ASC';
		}
		else
		{ 
			$query_usuarios.' ORDER BY nombreUsuario ASC';
		}

		$usuarios = mysql_query($query_usuarios, $rari_coneccion) or die(mysql_error());
		$row_usuarios = mysql_fetch_assoc($usuarios);
		$totalRows_usuarios = mysql_num_rows($usuarios);
?>

<div class="recuadro-interior" style="color:#222">
	<table style="border:none;" width="98%" align="center">
		<tr style="border:1px solid">
			<td align="center">Nivel</td>
			<td align="center">Nombre</td>
			<td align="center">Rol</td>
			<td align="center">Area</td>
<?php if ($_SESSION['idRol'] == 1) {?>
			<td align="center">estatus</td>
<?php }?>
		</tr>
		<tr>
			<td colspan="5" align="center"><hr/></td>
		</tr>
<?php do { ?>
		<tr class="fila" onclick="_boton(<?php echo $row_usuarios['id']; ?>);">
			<td align="center"><?php echo $row_usuarios['nivel']; ?></td>
			<td><?php echo $row_usuarios['nombreUsuario'].' '.$row_usuarios['apellido']; ?></td>
			<td><?php echo $row_usuarios['nombreRol']; ?></td>
			<td style="color:#FFF;" bgcolor="<?php echo $row_usuarios['color_p']; ?>" align="center"><?php echo $row_usuarios['idArea']; ?></td>
<?php if ($_SESSION['idRol'] == 1) {?>
			<td><input type ="checkbox" name="estatus" id="<?php echo $row_usuarios['id']; ?>" <?php echo ($row_usuarios['estatus'] == 1) ? '':'checked';  ?>>Inactivo</input> </td>
<?php } ?>
		</tr>
<?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
	</table>    
</div>
		
<script type='text/javascript'>
	$('input[name=estatus]').click( function()
									{
										var id = $(this).attr('id');
										var estatus = $(this).attr('checked');
										// 		alert(id);
										// 		alert (estatus);

										if (estatus == "checked") 
										{
											estatus = "2";
										}
										else
										{
											estatus = "1";
										}
												 
										var ajax;
												
										ajax = ajaxFunction();
										ajax.open("POST", "actualizarUsuarios.php?id="+id+"&estatus="+ estatus , true);
										ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
										ajax.send(null);
										//  	    alert(id + estatus);

									});
</script>
<?php }?>