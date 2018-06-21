/*================================================================================
 * @nombre: controlador-publico
 * @autor: Tomás Arturo Martínez Hernández (facebook.com/cazapachangas)
 * @demo: http://www.rari-senasica.gob.mx
 * @version: 1.0
 * @descripcion: Controlador de elementos ne l.
 ================================================================================*/

var barra_log_oculta=false; var noti_actual="#n_not1"; var animando=true;

var objetos=new Array();
var hayNoticias;
//var notic=null;

;(function($) {
	$( window ).load(function() {
		

			var a=0;
		var g=true;
		$('div.noticia-uis').each(function () {
			objetos[a]=new noticia($(this));
			objetos[a].mostrado=g;
			g=!g;
			a++;
       	});
		
		hayNoticias=objetos.length>0;
	
	/*
		$( window ).resize(function() {
			//alert('Hellow');
	  		if($( window ).width()>400&&hayNoticias){
				//alert("Hellow");
			$('div.bannerPie').slideDown(100);
			}
		});*/
	
		if(hayScroll()&&hayNoticias)
			$('div.bannerPie').slideDown(100);
		
		
		
		$(window).scroll(function(){
			if (($(window).height() + $(window).scrollTop())>= ($(document).height()-10)&&hayNoticias) 
				$('div.bannerPie').slideDown(100);
			else
				$('div.bannerPie').slideUp(100);
			
		});

		
	
		

		
		$( "#rari" ).click(function() {
			if(!barra_log_oculta){
				$("#divLogin").slideDown();
				barra_log_oculta=true;
			}
			else{
				$("#divLogin").slideUp();
				barra_log_oculta=false;
			}
		});
		
		function animarUIS(){
			while(true){
				for(var ij=0; ij<objetos.length; ij++){
					Concurrent.Thread.sleep(300);
					objetos[ij].animar();
				}
				Concurrent.Thread.sleep(5000);
			}
		}
		Concurrent.Thread.create(animarUIS);
		
	function hayScroll() {
  var docHeight = $(document).height();
  var scrolle    = $(window).height() + $(window).scrollTop();
  return (docHeight == scrolle);
} 
		
		});		 
})(jQuery);





	