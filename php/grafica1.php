<?php
	require_once('php/consultasGraficos.php');
	require_once ('libs/jpgraph/jpgraph.php');
	require_once ('libs/jpgraph/jpgraph_bar.php');

	function obtenerGraficoBarras($idArea, $fechaInicio, $fechaFin, $grafica, $database_rari_coneccion, $rari_coneccion)
	{
		$result=obtenerComunicadosPorTipo($idArea,$fechaInicio,$fechaFin, $database_rari_coneccion, $rari_coneccion);
		$datay=$result[0];

		if($datay!=null)
		{
			$graph = new Graph(370,220,'auto');
			$graph->SetScale("textlin");

			$graph->yaxis->SetTickPositions(obtenerDiviciones($datay));
			$graph->SetBox(false);

			$graph->ygrid->SetFill(false);
			$graph->xaxis->SetTickLabels($result[1]);
			$graph->yaxis->HideLine(false);
			$graph->yaxis->HideTicks(false,false);

			$b1plot = new BarPlot($datay);
			
			$graph->Add($b1plot);

			$colores=array("#990000","#006600","#666666","#990000","#006600","#666666");

			$b1plot->SetColor("white");
			$b1plot->SetFillColor("#666");
			$b1plot->SetWidth(20);
			$graph->xaxis->SetLabelAngle(15);
			clearstatcache();
			if(file_exists ('tmps/graf2.jpeg'))
				unlink('tmps/graf2.jpeg');
			clearstatcache();
			$graph->Stroke("tmps/graf2.jpeg");			
		}
		else
		{
			copy("tmps/nograf.jpg","tmps/graf2.jpeg");
		}
	}
?>