<?php
/* Original
$hostname_rari_coneccion = "10.24.17.54";
$database_rari_coneccion = "rari";
$username_rari_coneccion = "rari_user";
$password_rari_coneccion = "rari_app";
$rari_coneccion = mysql_pconnect($hostname_rari_coneccion, $username_rari_coneccion, $password_rari_coneccion) or trigger_error(mysql_error(),E_USER_ERROR); 
*/


$hostname_rari_coneccion = "localhost";
$database_rari_coneccion = "rari";//local
//$hostname_rari_coneccion = "10.24.17.54";//Productivo
//$username_rari_coneccion = "rari_user";
//$password_rari_coneccion = "rari_app";
//$username_rari_coneccion = "root";//Usuario administrador local
//$password_rari_coneccion = "admin";//Usuario administrador local
$username_rari_coneccion = "rodrigo";//Usuario administrador xammp
$password_rari_coneccion = "rorro";//Usuario administrador xammp
$rari_coneccion = mysql_pconnect($hostname_rari_coneccion, $username_rari_coneccion, $password_rari_coneccion) or trigger_error(mysql_error(),E_USER_ERROR);

//$rari_coneccion->set_charset("utf8");
mysql_set_charset("utf8", $rari_coneccion);
?>