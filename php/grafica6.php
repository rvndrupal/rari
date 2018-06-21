<?php
	require_once('php/consultasGraficos.php');
	require_once ('libs/jpgraph/jpgraph.php');
	require_once ('libs/jpgraph/jpgraph_bar.php');
	require_once ('libs/jpgraph/jpgraph_pie.php');
	require_once ('libs/jpgraph/jpgraph_pie3d.php');

	function obtenerGraficoAreas($idArea, $fechaInicio, $fechaFin, $grafica, $database_rari_coneccion, $rari_coneccion)
	{
		$result=obtenerAreas($idArea, $fechaInicio, $fechaFin, $database_rari_coneccion, $rari_coneccion);
		$datay=$result[0];
		//var_dump($datay);

		//$data = array(40,60,21,33);

		if ($datay!=null) 
		{
			/*
			$graph = new PieGraph(350, 220, 'auto');

			$theme_class= new OceanTheme;
			$graph->SetTheme($theme_class);

			$b1plot = new PiePlot3D($data);
			$graph->Add($b1plot);
			$b1plot->ShowBorder();
			$b1plot->SetColor('black');
			$b1plot->ExplodeSlice(1);*/

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

			$b1plot->SetFillGradient("orange", "blue", GRAD_HOR);
			$b1plot->SetWidth(13);
			$graph->xaxis->SetLabelAngle(50);
			$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,9);

			clearstatcache();
			if (file_exists('tmps/graf6.jpeg')) 
			{
				unlink('tmps/graf6.jpeg');
			}
			clearstatcache();
			$graph->Stroke("tmps/graf6.jpeg");
		} 
		else 
		{
			copy("tmps/nograf.jpg", "tmps/graf6.jpeg");
		}
	}
?>