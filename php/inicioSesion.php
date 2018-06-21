<?php
	if (!function_exists('GetSQLValueString')) 
	{
		function GetSQLValueString($theValue, $theType, $theDefinedValue = '', $theNotDefinedValue = '') 
		{
			if (PHP_VERSION < 6) 
			{
				$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}

			$theValue = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

			switch ($theType) 
			{
				case 'text':
					$theValue = ($theValue != '') ? '\'' . $theValue . '\'' : 'NULL';
					break;    
				case 'long':
				case 'int':
					$theValue = ($theValue != '') ? intval($theValue) : 'NULL';
					break;
				case 'double':
					$theValue = ($theValue != '') ? doubleval($theValue) : 'NULL';
					break;
				case 'date':
					$theValue = ($theValue != '') ? '\'' . $theValue . '\'' : 'NULL';
					break;
				case 'defined':
					$theValue = ($theValue != '') ? $theDefinedValue : $theNotDefinedValue;
					break;
			}
			return $theValue;
		}
	}
?>
<?php
	// *** Validate request to login to this site.
	if (!isset($_SESSION)) 
	{
		session_start();
	}

	$loginFormAction = $_SERVER['PHP_SELF'];
	if (isset($_GET['accesscheck'])) 
	{
		$_SESSION['PrevUrl'] = $_GET['accesscheck'];
	}

	if (isset($_POST['usuario'])) 
	{
		$loginUsername=$_POST['usuario'];
		$password=$_POST['password'];
		$MM_fldUserAuthorization = '';
		$MM_redirectLoginSuccess = 'bienvenido.php';
		//$MM_redirectLoginSuccess = 'principal.php';
		$MM_redirectLoginFailed = 'index.php';
		//$MM_redirectLoginFailed = 'principal.php';
		$MM_redirecttoReferrer = false;
		mysql_select_db($database_rari_coneccion, $rari_coneccion);
  
		$LoginRS__query=sprintf('SELECT id, nombre, apellido, idArea, idRol, nivel, acceso_login, acceso_password FROM tbl_usuarios WHERE acceso_login=%s AND acceso_password=%s AND intentos < 5 and estatus = 1',
		GetSQLValueString($loginUsername, 'text'), GetSQLValueString(md5($password), 'text')); 
   
		$LoginRS = mysql_query($LoginRS__query, $rari_coneccion) or die(mysql_error());
		$row_user = mysql_fetch_assoc($LoginRS);
		$user=$row_user['id'];
		$loginFoundUser = mysql_num_rows($LoginRS);
		if ($loginFoundUser) 
		{
			$loginStrGroup = '';
			$actualizaUser=sprintf('Update rari.tbl_usuarios set intentos = 0 where acceso_login=%s', GetSQLValueString($loginUsername, 'text'));
			$actualizar = mysql_query($actualizaUser, $rari_coneccion) or die(mysql_error());
         
			if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
			//declare two session variables and assign them
			$_SESSION['MM_Username'] = $loginUsername;
			$_SESSION['MM_UserGroup'] = $loginStrGroup;
			$_SESSION['nombre'] = $row_user['nombre'].' '.$row_user['apellido'];
			$_SESSION['area'] = $row_user['idArea'];
			$_SESSION['idRol'] = $row_user['idRol'];
			$_SESSION['nivel'] = $row_user['nivel'];
			$_SESSION['id'] = $row_user['id'];
			$_SESSION['ultimoAcceso']= date('Y-n-j H:i:s');

			if (isset($_SESSION['PrevUrl']) && false) 
			{
				$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
			}
			
			if ($_SESSION['idRol'] == '5')
			{
				$MM_redirectLoginSuccess = 'principal.php';		
			}
			
			header('Location: ' . $MM_redirectLoginSuccess.'?user='.$user );
		}
		else 
		{
			$validarUsuario =sprintf('select intentos, estatus from tbl_usuarios where acceso_login=%s', GetSQLValueString($loginUsername, 'text'));
			$intentoRS = mysql_query($validarUsuario, $rari_coneccion) or die(mysql_error());
			$row_intento = mysql_fetch_assoc($intentoRS);
			$intento = $row_intento['intentos'];
			$estatus = $row_intento['estatus'];
			if($estatus === '1')
			{
				if ($intento < 5 || $intento == null)
				{
					$actualizaUser=sprintf('Update rari.tbl_usuarios set intentos = %s where acceso_login=%s', GetSQLValueString($intento + 1, 'int'), GetSQLValueString($loginUsername, 'text'));
					$actualizar = mysql_query($actualizaUser, $rari_coneccion) or die(mysql_error());
					echo '<script type=\'text/javascript\'>alert(\'Contraseña incorrecta. Después de '.(5 - $intento).' intento(s) el usuario será bloqueado.\');</script>';
				}
				else
				{
					echo '<script type=\'text/javascript\'>alert(\'Por seguridad se ha bloqueado su usuario, favor de contactar con el administrador.\');</script>';
				}
			}
			else if($estatus === '2')
			{
				echo '<script type=\'text/javascript\'>alert(\'Su usuario ha sido desactivado\');</script>';
			}
			else
			{
				echo '<script type=\'text/javascript\'>alert(\'Usuario incorrecto. Favor de verificarlo.\');</script>';
			}
			// header("Location: ". $MM_redirectLoginFailed );
		}
	}
?>