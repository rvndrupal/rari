<?php 
if(isset($_GET['doc'])&&$_GET['doc']>0&&$_GET['doc']<6)
{



$enlace = "tmps/doc".$_GET['doc'].".docx"; 

header ("Content-Disposition: attachment; filename=doc".$_GET['doc'].".docx"); 

header ("Content-Type: application/octet-stream");

header ("Content-Length: ".filesize($enlace));

readfile($enlace);
}else{
echo '
<h1>El recurso que solició no fué encontrado</h1>
<a href="index.php">Volver al inicio</a>	';
}

?> 