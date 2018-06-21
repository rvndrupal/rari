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

	$iusuario=$_GET['iusuario'];
	$ipass=$_GET['contra'];
	$isexo=$_GET['isexo'];
	$fechaNac=$_GET['fechaNac'];
	$iestado=$_GET['iestado'];
	$imunicipio=$_GET['imunicipio'];
	$idependencia=$_GET['idependencia'];
	
	if ($ipass != null)
	{
		$updateSQL ="UPDATE tbl_usuarios SET  acceso_password = '".md5($ipass)."', sexo = ".$isexo.", fechaNacimiento = '".$fechaNac."', idEstado = ".$iestado.", idMunicipio = ".$imunicipio.", dependencia = '".$idependencia."' where acceso_login = '".$iusuario."'";
	}
	else
	{
		$updateSQL ="UPDATE tbl_usuarios SET  sexo = ".$isexo.", fechaNacimiento = '".$fechaNac."', idEstado = ".$iestado.", idMunicipio = ".$imunicipio.", dependencia = '".$idependencia."' where acceso_login = '".$iusuario."'";
	}
		
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
		$Result1 = mysql_query($updateSQL, $rari_coneccion) or die(mysql_error());
		
	?>

<div class="recuadro-interior" style="color:#222">
	<table style="border:none;" width="98%" align="center">
		<tr style="border:1px solid">			
		</tr>
		<tr>
			<td colspan="5" align="center">¡La actualización se ha realizado con éxito!</td>
		</tr>
		<tr class="fila" >
			<td align="center"><input type="button" value="Aceptar" id="pBtnAceptarEdit" onclick="location.href='../bienvenido.php'"></td>
			<td></td>
			<td></td>
			<td style="color:#FFF;" bgcolor="" align="center"></td>
        </tr>
    
    </table>
</div>