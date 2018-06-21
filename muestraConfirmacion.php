<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php 

	$q=$_POST['q'];
	
	if ($q != "")
	{
		echo '<tr><td colspan="3" align="right">Repite Contraseña:<input type="password" id="txtPass1" name="txtPass1" style="width:290px;" /></td></tr>';
	}
	else
	{
		echo '';
	}
		
?>