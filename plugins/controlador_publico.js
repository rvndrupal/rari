/*================================================================================
 * @nombre: controlador-publico
 * @autor: Tomás Arturo Martínez Hernández (facebook.com/cazapachangas)
 * @demo: http://www.rari-senasica.gob.mx
 * @version: 1.0
 * @descripcion: Controlador de elementos en el sitio público de RARI-SENASICA.
 ================================================================================*/



var barra_log_oculta=false; var noti_actual="#n_not1"; var animando=true;

var bandera=true;

var objetos=new Array();
//var notic=null;popupSuscribirse


			var forma;	

;(function($) {
	$( window ).load(function() {
		
		forma=new formulario($("#frm_suscripcion"),$("#divSusc"),$("#divLoadSusc"),$("#popupSuscribirse"));	
		
		$('#cerrarPOPUP').click(function(){
			//$('#popupSuscribirse').delay(10000).hide();
			//$('#popupSuscribirse').bPopup().close();
		});
		
		$("#divLoadSusc").click(function(){
			forma.revertirAnimacion();
		});
		
		
		$('#btnSusc').click(function(){
			forma.enviar('php/registrarSuscriptor.php');
		});
		
		
		$('#ingresar').click(function() {
			
			if(!bandera)
				return false;
				
			
			
            $('#cargando').show();
			bandera=false;
			//return false;
        });
		
		
		$("#suscribirse").bind('click', function(e) { 
		e.preventDefault();
		$('#popupSuscribirse').show();
		
		 /*
		$('#popupSuscribirse').bPopup({
            easing: 'easeOutBack',
            speed: 500,
            transition: 'slideIn',
				   transitionClose: 'slideBack',
			onOpen: function() {
				
				
				
            },
            onClose: function() {
				
            }
        	}); */
		});	
		
		
		var a=0;
		var g=true;
		$('div.noticia-uis').each(function () {
			objetos[a]=new noticia_uis($(this));
			objetos[a].mostrado=g;
			g=!g;
			a++;
       	});
		
		$('#n_nacioneales').hover(
			function(){
				$("#corriendo").val('0');
			},
			function(){
				$("#corriendo").val('1');
			});
		
		$('#tbl_noticias tr').click(function (){
			var fila="#n_"+$(this).attr("id");
			mostrarItem(fila);
			$(this).find('div.selector').show("bounce", { times:3 }, 200);
			});
	
		function mostrarItem(fila)
		{
			if(fila!=noti_actual){
				$(noti_actual).fadeOut(200);
				noti_actual=fila;			
				$(noti_actual).delay(400).fadeIn();
				$('div.selector').hide();
			}
		}
		
		$("div.tab").click(function(){
			$("div.tab").css("border-bottom","#eee solid 3px");
			$('div.desc').hide();
			var id=$(this).attr("id");
			$('#'+id).css("border-bottom","#27C54A solid 3px");
			var tiempo=400;
			switch(id){
				case 'tabAlerta':
					$('#alertasDesc').fadeIn(tiempo);
					break;
				case 'tabCuarentena':
					$('#cuarentenasDesc').fadeIn(tiempo);
					break;
				case 'tabInformacion':
					$('#informacionesDesc').fadeIn(tiempo);
					break;
				case 'tabNoticia':
					$('#noticiasDesc').fadeIn(tiempo);
					break;
				case 'tabRechazo':
					$('#cancelacionesDesc').fadeIn(tiempo);
					break;
				case 'tabRetencion':
					$('#retencionesDesc').fadeIn(tiempo);
					break;
			}
		});
		
		//.dblclick(
		
		
		$( "#rari" ).dblclick(function() {
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
		
		function animarSlider(){
			var items="";
			$('#tbl_noticias tr').each(function () {
				if(items!="")
					items+=",";
        		items+=$(this).attr("id");
       			});
				
			var arreglo=items.split(',');
			
			if(arreglo.length>1)
				while (true){
					
					for(var i=0; i<arreglo.length; i++){
						var correr=$("#corriendo").val();
						if(correr=='1')
							$('#'+arreglo[i]).trigger("click");
						else
							i--;
						
						
						//notic.animar();
						Concurrent.Thread.sleep(7000);
						
					}
				}
		}
		
		Concurrent.Thread.create(animarSlider);
		Concurrent.Thread.create(animarUIS);
		
		});		 
})(jQuery);





