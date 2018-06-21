<?php

//require_once ('libs/jpgraph/jpgraph.php');
//require_once ('libs/jpgraph/jpgraph_pie.php');
//require_once ('libs/jpgraph/jpgraph_pie3d.php');


require_once ('libs/jpgraph/jpgraph.php');
require_once ('libs/jpgraph/jpgraph_bar.php');


$datay=array(62,105,85,50,85,50);

$graph = new Graph(220,200,'auto');
$graph->SetScale("textlin");


$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);




$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('A','B','C','D','E','F'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
//$graph->img->SetAngle(240); 


$b1plot = new BarPlot($datay);


$graph->Add($b1plot);


$colores=array("#990000","#006600","#666666","#990000","#006600","#666666");


$b1plot->SetColor("white");
$b1plot->SetFillColor("#0066CC");
$b1plot->SetWidth(15);
$graph->xaxis->SetLabelAngle(50);

try{
unlink('tmps/graf4.jpeg');
}catch(Exception $exeption){}
$graph->Stroke("tmps/graf4.jpeg");


?>