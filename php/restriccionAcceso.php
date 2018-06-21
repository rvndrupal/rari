<?php
	//Inicio de la sesión
	if (!isset($_SESSION)) 
	{
		session_start();
	}

	// ** Desconectar al usuario actual. **
	$logoutAction = $_SERVER['PHP_SELF'].'?doLogout=true';
	if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != ''))
	{
		$logoutAction .='&'. htmlentities($_SERVER['QUERY_STRING']);
	}

	if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=='true'))
	{
		//Variables de sesión limpias
		$_SESSION['MM_Username'] = NULL;
		$_SESSION['MM_UserGroup'] = NULL;
		$_SESSION['PrevUrl'] = NULL;
		unset($_SESSION['MM_Username']);
		unset($_SESSION['MM_UserGroup']);
		unset($_SESSION['PrevUrl']);
		unset($_SESSION['ultimoAcceso']);

		$logoutGoTo = 'index.php';
		if ($logoutGoTo) 
		{
			header("Location: $logoutGoTo");
			exit;
		}
	}

	$MM_restrictGoTo = 'index.php';

	if (!isset ($_SESSION['MM_Username']))
	{
		header('Location: '. $MM_restrictGoTo); 
	}
	else
	{
		$fechaOld= $_SESSION['ultimoAcceso'];
		$ahora = date('Y-n-j H:i:s');
		$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaOld));

		//Se incrementa tiempo de sesión, para capturar formulario. Se extiende a 20 minutos. LVC 11-Mayo-2018.
		//if($tiempo_transcurrido>= 900)
		if($tiempo_transcurrido>= 1200) 
		{ //comparamos el tiempo y verificamos si pasaron 10 minutos o mⳍ
			session_destroy(); // destruimos la sesi󮬠cerrar sesi󮠰or inactividad php
			header('Location: '. $MM_restrictGoTo);  //enviamos al usuario a la p⨩na principal
		}
		else 
		{ //sino, actualizo la fecha de la sesi󮍊			$_SESSION['ultimoAcceso'] = $ahora;
		}
	}

	if (!isset($_SESSION)) 
	{
		session_start();
	}
	$MM_authorizedUsers = '';
	$MM_donotCheckaccess = 'true';

	// *** Restringir y redireccionar acceso si es el caso
	function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) 
	{ 
		// Indica que el usuario es válido
		$isValid = False; 

		if (!empty($UserName)) 
		{
			$arrUsers = Explode(',', $strUsers); 
			$arrGroups = Explode(',', $strGroups); 
			if (in_array($UserName, $arrUsers)) 
			{
				$isValid = true; 
			} 
	 
			if (in_array($UserGroup, $arrGroups)) 
			{ 
				$isValid = true; 
			} 
			if (($strUsers == '') && true) 
			{ 
				$isValid = true; 
			} 
		} 
		return $isValid; 
	}

	//$MM_restrictGoTo = "index.php";
	$MM_restrictGoTo = 'principal.php';
/*	if (!((isset($_SESSION['MM_Username'])) && (isAuthorized('',$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) 
	{
		$MM_qsChar = '?';
		$MM_referrer = $_SERVER['PHP_SELF'];
		if (strpos($MM_restrictGoTo, '?')) $MM_qsChar = '&';
			if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
				$MM_referrer .= '?' . $_SERVER['QUERY_STRING'];
		
		$MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . 'accesscheck=' . urlencode($MM_referrer);
		header('Location: '. $MM_restrictGoTo); 
		exit;
	}
	*/	
?>