<?php require_once('Connections/rari_coneccion.php'); ?>
<?php include('gestionCatalogos.php'); ?>

<?php
	header('Content-Type: text/html; charset=UTF-8');

	//Variable de búsqueda
	$palabraClave = isset($_POST['valorP']) ? $_POST['valorP'] : null;
	$numeroCatalogo = isset($_POST['valorC']) ? $_POST['valorC'] : null;
	$modulo = isset($_POST['valorM']) ? $_POST['valorM'] : null;
	$comunicado = isset($_POST['valorD']) ? $_POST['valorD'] : null;
	
	//Filtro anti-XSS
	$caracteres_malos = array('<', '>', '"', '\'', '/', '<', '>', '\'', '/');
	$caracteres_buenos = array('&lt;', '&gt;', '&quot;', '&#x27;', '&#x2F;', '&#060;', '&#062;', '&#039;', '&#047;');
	$palabraClave = str_replace($caracteres_malos, $caracteres_buenos, $palabraClave);
	$numeroCatalogo = str_replace($caracteres_malos, $caracteres_buenos, $numeroCatalogo);
	$modulo = str_replace($caracteres_malos, $caracteres_buenos, $modulo);
	$comunicado = str_replace($caracteres_malos, $caracteres_buenos, $comunicado);
	
	if($comunicado==null)
		echo obtenerCatalogoSelectF($numeroCatalogo,$database_rari_coneccion,$rari_coneccion,$modulo, null, $palabraClave);
	else
		echo obtenerCatalogoSelectF($numeroCatalogo,$database_rari_coneccion,$rari_coneccion,$modulo,$comunicado, $palabraClave);
	
?>
