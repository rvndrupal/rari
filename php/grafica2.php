<?php





require_once ('libs/jpgraph/jpgraph.php');
require_once ('libs/jpgraph/jpgraph_bar.php');
require_once ('libs/jpgraph/jpgraph_line.php');


function obtenerStackEstados($idArea,$fI,$fF,$database_rari_coneccion, $rari_coneccion)
{

$infoEstados=obtenerPrimerosEstados($idArea,$fI,$fF,$database_rari_coneccion, $rari_coneccion);

if($infoEstados!=null)
{

$idsEstados=$infoEstados[0];
$nombresEstados=$infoEstados[1];

$alertas=array();
$informacion=array();
$cancelacion=array();
$cuarentenas=array();
$retenciones=array();
$noticias=array();

$totales=array(0,0,0,0,0,0);

$nombresTipos=obtenerNombresSinOrden("cat_comunicados", $database_rari_coneccion, $rari_coneccion);;

for($i=0;$i<count($idsEstados);$i++)
{
	$dataAlertas=obtenercomunicadosPorTipoYEdo($idArea,$idsEstados[$i],$fI,$fF,$database_rari_coneccion, $rari_coneccion);
	
	$alertas[$i]=$dataAlertas[0];
	$cuarentenas[$i]=$dataAlertas[1];
$informacion[$i]=$dataAlertas[2];
$noticias[$i]=$dataAlertas[3];
$cancelacion[$i]=$dataAlertas[4];
$retenciones[$i]=$dataAlertas[5];

$totales[0]=$totales[0]+$dataAlertas[0];
$totales[1]=$totales[1]+$dataAlertas[1];
$totales[2]=$totales[2]+$dataAlertas[2];
$totales[3]=$totales[3]+$dataAlertas[3];
$totales[4]=$totales[4]+$dataAlertas[4];
$totales[5]=$totales[5]+$dataAlertas[5];	
	}

$max=0;

for($i=0; $i<count($totales); $i++)
{
	if($totales[$i]>$max)
		$max=$totales[$i];
}

if($max>3)
{

$graph = new Graph(750,300,'auto');
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(obtenerDiviciones($totales));

$tiposComunicados=$nombresEstados;


$graph->SetBox(false);


$graph->xaxis->SetTickLabels($tiposComunicados);

$barraAlertas = new BarPlot($alertas);
$barraInformacion = new BarPlot($informacion);
$barraCancelacion = new BarPlot($cancelacion);

$barraCuarentenas = new BarPlot($cuarentenas);
$barraRetenciones = new BarPlot($retenciones);
$barraNoticias = new BarPlot($noticias);







$gbbplot = new AccBarPlot(array($barraAlertas,$barraCuarentenas, $barraInformacion ,$barraNoticias,$barraCancelacion,$barraRetenciones));


$graph->Add($gbbplot);




$barraAlertas->SetColor("#990000");
$barraAlertas->SetFillColor("#990000");
$barraAlertas->SetLegend("Alertas");

$barraInformacion->SetColor("#fbbd00");
$barraInformacion->SetFillColor("#fbbd00");
$barraInformacion->SetLegend("Información");

$barraCancelacion->SetColor("#7e7e7e");
$barraCancelacion->SetFillColor("#7e7e7e");
$barraCancelacion->SetLegend("Rechazo");

$barraCuarentenas->SetColor("#643200");
$barraCuarentenas->SetFillColor("#643200");
$barraCuarentenas->SetLegend("Cuarentena");

$barraRetenciones->SetColor("#7e629f");
$barraRetenciones->SetFillColor("#7e629f");
$barraRetenciones->SetLegend("Retención");

$barraNoticias->SetColor("#4aa9c3");
$barraNoticias->SetFillColor("#4aa9c3");
$barraNoticias->SetLegend("Noticias");


$graph->legend->SetFrameWeight(1);
$graph->legend->SetColumns(6);
$graph->legend->SetColor('#4E4E4E','#CCC');


//$graph->img->SetAngle(90); 

if(file_exists ('tmps/graf3.jpeg'))
unlink('tmps/graf3.jpeg');
$graph->Stroke("tmps/graf3.jpeg");
}
else
{
	copy("tmps/nograf.jpg","tmps/graf3.jpeg");
	}
}
else
{
	copy("tmps/nograf.jpg","tmps/graf3.jpeg");
	}
	
}

?>