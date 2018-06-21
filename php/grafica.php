<?php
	require_once('php/consultasGraficos.php');
	require_once ('libs/jpgraph/jpgraph.php');
	require_once ('libs/jpgraph/jpgraph_pie.php');
	require_once ('libs/jpgraph/jpgraph_pie3d.php');

	function obtenerGraficoCircular($idArea, $fechaInicio, $fechaFin, $grafica, $database_rari_coneccion, $rari_coneccion)
	{
		if($grafica==0)
		{
			$colores=array('#990000','#fbbd00','#4aa9c3','#7e7e7e','#7e629f','#643200');
			$result=obtenerComunicadosPorTipo($idArea,$fechaInicio,$fechaFin, $database_rari_coneccion, $rari_coneccion);
			$data = $result[0];
			$leyendas=$result[1];
		}
		else if($grafica==1)
		{
			$colores=array('#990000','#006600','#666666','#FFCC33','#666666','#996600');
			$result=obtenerComunicadosPorNivelRiesgo('cat_nivel_riesgo','idNivelRiesgo',$idArea,$fechaInicio,$fechaFin, $database_rari_coneccion, $rari_coneccion);
			$data = $result[0];
			$leyendas=$result[1];
		}
		else if($grafica==2)
		{
			$colores=array('#990000','#006600','#666666','#FFCC33','#666666','#996600');
			$result=obtenerComunicadosPorNivelRiesgo('cat_nivel_alerta','idNivelAlerta',$idArea,$fechaInicio,$fechaFin, $database_rari_coneccion, $rari_coneccion);
			$data = $result[0];
			$leyendas=$result[1];
		}
		if($data!=null)
		{
			$graph = new PieGraph(350,220,'auto');

			$theme_class= new OceanTheme;
			$graph->SetTheme($theme_class);

			$p1 = new PiePlot3D($data);
			$graph->Add($p1);
			$p1->SetLegends($leyendas);
			$p1->ShowBorder();
			$p1->SetColor('#666666');
			//$p1->SetLegens(array("Alerta", "Cuarentena", "Información", "Noticia", "Rechazo", "Retención"));
			$p1->SetSliceColors($colores);
			$p1->ExplodeSlice(1);
			if(file_exists ( 'tmps/'.obntenerNombreDeGrafico($grafica).'.jpeg'))
				unlink('tmps/'.obntenerNombreDeGrafico($grafica).'.jpeg');
			$graph->Stroke('tmps/'.obntenerNombreDeGrafico($grafica).'.jpeg');
		}
		else
		{
			copy('tmps/nograf.jpg','tmps/'.obntenerNombreDeGrafico($grafica).'.jpeg');
		}
	}

	function obntenerNombreDeGrafico($grafico)
	{
		$graps=array('gTipoComunicados','gNivelRiesgo', 'gNivelAlerta');
		return $graps[$grafico];
	}
?>