<!-- Carga CSS con estilos para gráficas. Desarrollado por Rodrigo Villanueva. 6-Junio-2018 -->
<link rel="stylesheet" href="/src/css/graficas.css">
<?php 
	if(isset($_POST['date0'])&&isset($_POST['date1'])&&isset($_POST['area']))
	{
		require_once('Connections/rari_coneccion.php');
		date_default_timezone_set('America/Mexico_City');
		require_once('php/grafica.php'); ?>
<?php 	require_once('php/grafica1.php'); ?>
<?php 	require_once('php/grafica2.php'); ?>
<?php 	require_once('php/grafica3.php');
		//Código nuevo. Se agregan referencias para nuevas gráficas. LVC - RV 6-Junio-2018
		require_once('php/grafica4.php'); 
		require_once('php/grafica5.php'); 
		require_once('php/grafica6.php'); 
		require_once ('libs/jpgraph/jpgraph.php');
		require_once ('libs/jpgraph/jpgraph_bar.php');

		$fechaI=$_POST['date0'];
		$fechaF=$_POST['date1'];
		//$fechaE="2014-04-02";
		$area=$_POST['area'];
				
		$datosArea=consultarNombreArea($area,$database_rari_coneccion, $rari_coneccion);

		obtenerGraficoCircular($area, $fechaI, $fechaF, 0, $database_rari_coneccion, $rari_coneccion);
		obtenerGraficoCircular($area, $fechaI, $fechaF, 1, $database_rari_coneccion, $rari_coneccion);
		obtenerGraficoCircular($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
		obtenerGraficoBarras($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);
		obtenerStackEstados($area,$fechaI, $fechaF,$database_rari_coneccion, $rari_coneccion);
		
		//grafica 4
		obtenerGraficoEmitidos($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);

		//grafica 5
		obtenerGraficoEstatus($area, $fechaI, $fechaF, 2, $database_rari_coneccion, $rari_coneccion);

		//grafico 6
		obtenerGraficoAreas($area, $fechaI, $fechaF, 0, $database_rari_coneccion, $rari_coneccion);
	}
?>
<!-- Código nuevo. Funcionalidad de gráficas. LVC y RV 6-Junio-2018 -->
<?php
	mostrarGra();
	sleep(.5); 

	function mostrarGra()
	{
		$comArea= $_POST['comArea'];
		
		if($comArea=='ttCU')
		{
			echo'  
				<div class="graf1" width="100%">
					<span  class="titgraf">
						Tipos de comunicados
					</span>
					<br/>
					<img src="tmps/graf2.jpeg?'.rand(1, 2000).'" width="85%" height="360"/>
				</div>   
				<div class="graf2" width="100%">
					<span  class="titgraf">
						Tipos de comunicados
					</span>
					<br/>
					<img src="tmps/gTipoComunicados.jpeg?'.rand(1, 2000).'" width="95%" height="400"/>
				</div>';
		}
		
		if ($comArea=="ccPE") 
		{
			echo' 
				<div class="graf3" width="100%">
					<span  class="titgraf">
						Comunicados por estado
					</span>
					<br/>
					<img src="tmps/graf3.jpeg?'.rand(1, 2000).'" width="95%" height="560"/>
				</div>';
		} 
 
		if($comArea=="ccEM")
        {
			echo'
				<div class="graf4" width="100%">
					<span  class="titgraf">
						Cantidad de Comunicados Emitidos
					</span>
					<br/>
					<img src="tmps/graf4.jpeg?'.rand(1, 2000).'" width="95%" height="600"/>
				</div>';
		}

		//para todos          
        if($comArea=="todos")
        {
			echo'  
				<div class="graf1" width="100%">
					<span  class="titgraf">
						Tipos de comunicados
					</span>
					<br/>
					<img src="tmps/graf2.jpeg?'.rand(1, 2000).'" width="95%" height="360"/>
                </div>
				<div class="graf2" width="100%">
					<span  class="titgraf">
						Tipos de comunicados
					</span>
					<br/>
					<img src="tmps/gTipoComunicados.jpeg?'.rand(1, 2000).'" width="95%" height="400"/>
				</div>
				<div class="graf3" width="100%">
					<span  class="titgraf">
						Comunicados por estado
					</span>
					<br/>
					<img src="tmps/graf3.jpeg?'.rand(1, 2000).'" width="95%" height="560"/>
				</div>
				<div class="graf4" width="100%">
					<span  class="titgraf">
						Cantidad de Comunicados Emitidos
					</span>
					<br/>
					<img src="tmps/graf4.jpeg?'.rand(1, 2000).'" width="95%" height="600"/>                
				</div>
				<div class="gra_riesgo" width="100%">                
					<br>
					<img src="tmps/gNivelRiesgo.jpeg?'.rand(1, 2000).'" width="470" height="320"/>
				</div>
				<span  class="titgraf">
					Comunicados por nivel de Riesgo
				</span>
				<div class="graf6" width="100%">                
					<br>
					<img src="tmps/graf5.jpeg?'.rand(1, 2000).'" width="850" height="520"/>
                </div>
				<span  class="titgraf">
					Catálogo por estatus
                </span>
				<div class="graf5" width="100%">                
					<br>
					<img src="tmps/gNivelAlerta.jpeg?'.rand(1, 2000).'" width="470" height="320"/>
                </div>
                <span  class="titgraf">
					Comunicados por nivel de Alerta
                </span>
                <div class="graf8" width="100%">                
					<br>
					<img src="tmps/graf6.jpeg?'.rand(1, 2000).'" width="900" height="500"/>
                </div>
                <span  class="titgraf">
					Catálogo por Areas
                </span>';
		}  
        
		//todos
        //Comunicados por nivel de Riesgo grafica 
        if ($comArea=="ccRE") 
		{
			echo'  
				<div class="gra_riesgo" width="100%">                
					<br>
					<img src="tmps/gNivelRiesgo.jpeg?'.rand(1, 2000).'" width="470" height="320"/>
				</div>
				<span  class="titgraf">
					Comunicados por nivel de Riesgo
                </span>';
		}     
              
		//Comunicados por nivel de Riesgo grafica 
		if ($comArea=="ccAL") 
		{
			echo'  
				<div class="graf5" width="100%">
					<br>
					<img src="tmps/gNivelAlerta.jpeg?'.rand(1, 2000).'" width="470" height="320"/>
                </div>
                <span  class="titgraf">
					Comunicados por nivel de Alerta
                </span>';
		}   
              
        //Comunicados por nivel de Riesgo grafica 5
        if ($comArea=="ccES") 
		{
			echo'  
				<div class="graf7" width="100%">
					<br>
					<img src="tmps/graf5.jpeg?'.rand(1, 2000).'" width="850" height="520"/>
				</div>
                <span  class="titgraf">
					Catálogo por estatus
                </span>';
        }

		//Comunicados por nivel de Riesgo grafica 6
        if ($comArea=="ccAA") 
		{
			echo'
				<div class="graf8" width="100%">
					<br>
					<img src="tmps/graf6.jpeg?'.rand(1, 2000).'" width="900" height="500"/>
                </div>
                <span  class="titgraf">
					Catálogo por Areas
                </span>';
        }
	}//funcion general
?>

<!-- Código original. Se detecta que la funcionalidad está hardcodeada. Se comenta todo el código y se cambia por código funcional. LVC 6-Junio-2018

<table width="100%" align="center">
	<tr>
		<td align="center" width="50%">
			<span style="color:#999; margin-bottom::3px;">
				Tipos de comunicados
			</span>
			<br/>
			<img src="tmps/graf2.jpeg" width="370" height="220"/>
		</td>
		<td align="center" width="50%" style="border-left:#999 dashed 1px;">
			<span style="color:#999; margin-bottom::3px;">
				Tipos de comunicados
			</span>
			<br/>
			<img src="tmps/gTipoComunicados.jpeg" width="370" height="220"/>
		</td>
	</tr>
	<tr >
		<td align="center" colspan="2">
			<div style="height:10px; width:100%;"></div>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<span style="color:#999; margin-top:-15px;">
				Comunicados por estados<br/>
			</span>
			<img src="tmps/graf3.jpeg" width="700" height="300"/>
		</td>
	</tr>
	<tr >
		<td align="center" colspan="2">
			<div style="height:10px; width:100%;"></div>
		</td>
	</tr>
	<tr >
		<td align="center" style="border-top:#999 dashed 1px;">
			<img src="tmps/gNivelRiesgo.jpeg" width="370" height="220"/>
			<br/>
			<span style="color:#999; margin-top:-25px;">
				Comunicados por nivel de riesgo
			</span>
		</td>
		<td align="center" style="border-top:#999 dashed 1px;">
			<img src="tmps/gNivelAlerta.jpeg" width="370" height="220"/>
			<br/>
			<span style="color:#999; margin-top:-25px;">
				Comunicados por nivel de alerta
			</span>
		</td>
	</tr>
</table>
<?php // }?>