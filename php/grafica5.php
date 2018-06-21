<?php
	require_once('php/consultasGraficos.php');
	require_once ('libs/jpgraph/jpgraph.php');
	require_once ('libs/jpgraph/jpgraph_bar.php');

	function obtenerGraficoEstatus($idArea, $fechaInicio, $fechaFin, $grafica, $database_rari_coneccion, $rari_coneccion)
	{
		$result=obtenerEstatus($idArea,$fechaInicio,$fechaFin, $database_rari_coneccion, $rari_coneccion);
		$datay=$result[0];
	
		if($datay!=null)
		{
			$graph = new Graph(870,820,'auto');
			$graph->SetScale("textlin");

			$graph->yaxis->SetTickPositions(obtenerDiviciones($datay));
			$graph->SetBox(false);

			$graph->ygrid->SetFill(false);
			$graph->xaxis->SetTickLabels($result[1]);
			$graph->yaxis->HideLine(false);
			$graph->yaxis->HideTicks(false,false);

			$b1plot = new BarPlot($datay);
			
			$graph->Add($b1plot);

			//$colores=array("#990000","#006600","#666666","#990000","#006600","#666666");
			$colores=array("#BE81F7","#E3CEF6","#666666","#990000","#006600","#666666");

			$b1plot->SetFillGradient("yellow", "blue", GRAD_HOR);
			$b1plot->SetWidth(13);
			$graph->xaxis->SetLabelAngle(40);
			$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,9);

			clearstatcache();
			if(file_exists ('tmps/graf5.jpeg'))
				unlink('tmps/graf5.jpeg');
			clearstatcache();
			$graph->Stroke("tmps/graf5.jpeg");
		}
		else
		{
			copy("tmps/nograf.jpg","tmps/graf5.jpeg");
		}
	}
?>