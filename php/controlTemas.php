<?php 

	$color_vegetal_primario='#006838';
	$color_vegetal_secundario='#009345';

	$color_animal_primario='#BE1E2D';
	$color_animal_secundario='#EE1E2D';

	$color_inocuidad_primario='#F6921E';
	$color_inocuidad_secundario='#FAAF40';

	$color_inspeccion_primario='#262261';
	$color_inspeccion_secundario='#652D90';

	$color_sanidad_primario='#1B75BB';
	$color_sanidad_secundario='#26A9E0';

	$color_noticias_primario='#F05A28';
	$color_noticias_secundario='#ec6b33';

	$etiquetaHospedero='';

	$modulo='';

	//Se hace modificación, para que considere la nueva funcionalidad de seguimiento. LVC. 16-Octubre-2017.
	//if($pagina=='form')
	if(($pagina=='form') or ($pagina=='seguimiento'))
	{
		if(isset($_GET['mod']))
			$modulo=$_GET['mod'];
		else
			$modulo=$_SESSION['area'];

		$etiqueta='';
		$imagenModulo='';
		$imagenModuloPeq='';

		$color_principal='#37ad53';
		$color_secundario='#37bd53';
		if($modulo==0)
		{
			$color_principal='#888';
			$color_secundario='#555';
			$etiqueta='General';
			$imagenModulo='salud_vegetal.png';
			$imagenModuloPeq='general.png';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		}
		else if($modulo==1)
		{ 
			$color_principal=$color_vegetal_primario;
			$color_secundario=$color_vegetal_secundario;
			$etiqueta='Sanidad vegetal';
			$imagenModulo='salud_vegetal.png';
			$imagenModuloPeq='salud_vegetal_peq.png';
			$etiquetaHospedero='Hospedero';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		} 
		else if($modulo==2)
		{ 
			$color_principal=$color_animal_primario;
			$color_secundario=$color_animal_secundario;
			$etiqueta='Salud animal';
			$imagenModuloPeq='salud_animal_peq.png';
			$imagenModulo='salud_animal.png';
			$etiquetaHospedero='Fuente de infección';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		}
		else if($modulo==3)
		{ 
			$color_principal=$color_inocuidad_primario;
			$color_secundario=$color_inocuidad_secundario;
			$etiqueta='Inocuidad Agroalimentaria';
			$imagenModuloPeq='inocuidad_peq.png';
			$imagenModulo='inocuidad.png';
			$etiquetaHospedero='Producto';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		} 
		else if($modulo==4)
		{ 
			$color_principal=$color_inspeccion_primario;
			$color_secundario=$color_inspeccion_secundario;
			$etiqueta='Inspección fitozoosanitaria';
			$imagenModuloPeq='inspeccion_peq.png';
			$imagenModulo='inspeccion.png';
			$etiquetaHospedero='Producto';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		} 
		else if($modulo==5)
		{ 
			$color_principal=$color_sanidad_primario;
			$color_secundario=$color_sanidad_secundario;
			$etiqueta='Sanidad acuicola y pesquera';
			$imagenModuloPeq='sanidad_acuicola_peq.png';
			$imagenModulo='sanidad_acuicola.png';
			$etiquetaHospedero='Hospedero/Especie';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		} 
		else if($modulo==6)
		{ 
			$color_principal=$color_noticias_primario;
			$color_secundario=$color_noticias_secundario;
			$etiqueta='Comunicados Internacionales';
			$imagenModuloPeq='noticias_peq.png';
			$imagenModulo='noticias.png';
			$etiquetaHospedero='Hospedero/Especie/Productos';
			establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq); 
		}	
		else
		{
			$GoTo = 'index.php';
			header(sprintf('Location: %s', $GoTo));
		}  
	}
	else if(!isset($_GET['mod'])&&$pagina=='form')
	{
		$GoTo = 'index.php';			
		header(sprintf('Location: %s', $GoTo));
	}

	function establecerTema($color_principal, $color_secundario,$imagenModulo,$imagenModuloPeq)
	{
		echo '
			<style>	
				.fila:hover
				{
					color:#FFF;
					background-color: '.$color_principal.';
				}
				.popup
				{
					box-shadow:1px 1px 10px '.$color_principal.';
					-moz-box-shadow:1px 1px 10px '.$color_principal.';
					-webkit-box-shadow:1px 1px 10px '.$color_principal.';
					border:3px solid '.$color_principal.';
				}	
				.imagen-modulo
				{
					background-image:url(imagenes/'.$imagenModulo.');
				}
				#imagen-cuadro-peq
				{
					background-image:url(imagenes/'.$imagenModuloPeq.');
				}
				#volver-menu
				{
					cursor:pointer; background-color:#333333; width:20%;
				}
				#volver-menu:hover
				{
					cursor:pointer; background-color:#666666; width:20%;
				}
				.etiqueta
				{
					background-color:'.$color_principal.';
				}
				.etiqueta-completa
				{
					background-color:'.$color_principal.';
				}		
				.rectangulo-opciones
				{
					background-color:'.$color_principal.';
				}						
				.rectangulo-opciones:hover
				{
					background-color:'.$color_secundario.';
				}
				.cuadro-modulo
				{
					background-color:'.$color_principal.';
				}
				.cuadro-modulo-chico
				{
					background-color:'.$color_principal.';
				}					
			</style>';
	}

	function establecerColores($vegetal,$animal,$inocuidad,$inspeccion,$sanidad,$noticias)
	{
		$color_vegetal_primario=$vegetal;

		$color_animal_primario=$animal;

		$color_inocuidad_primario=$inocuidad;

		$color_inspeccion_primario=$inspeccion;

		$color_sanidad_primario=$sanidad;

		$color_noticias_primario=$noticias;
	
	
	   echo '
			<style>
				#cuadro-vegetal:hover
				{
					background-color:'.$color_vegetal_primario.';
				}	
				#cuadro-animal:hover
				{
					background-color: '.$color_animal_primario.';
				}	
				#cuadro-inocuidad:hover
				{
					background-color: '.$color_inocuidad_primario.';
				}	
				#cuadro-inspeccion:hover
				{
					background-color: '.$color_inspeccion_primario.';
				}	
				#cuadro-sanidad:hover
				{
					background-color: '.$color_sanidad_primario.';
				}	
				#cuadro-noticias:hover
				{
					background-color: '.$color_noticias_primario.';
				}
			</style>
			';
	}
?>