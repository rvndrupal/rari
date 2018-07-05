<?php
$hostname_rari_coneccion = "localhost";
$database_rari_coneccion = "rari";
$username_rari_coneccion = "rodrigo";//Usuario administrador xammp
$password_rari_coneccion = "rorro";//Usuario administrador xammp
$rari_coneccion = mysql_pconnect($hostname_rari_coneccion, $username_rari_coneccion, $password_rari_coneccion) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_set_charset("utf8", $rari_coneccion);
?>


