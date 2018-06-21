<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<?php require_once('Connections/rari_coneccion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
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

if(isset($_GET['id'])&&isset($_GET['estatus_comunicado']))
{

	$id=$_GET['id'];
	$estatus=$_GET['estatus_comunicado'];
	
	$updateSQL ="update tbl_comunicado set estatus_comunicado= " .$estatus. " where id= " .$id ;

    mysql_select_db($database_rari_coneccion, $rari_coneccion);
    $Result1 = mysql_query($updateSQL, $rari_coneccion) or die(mysql_error());
		
	}

	
	
?>

