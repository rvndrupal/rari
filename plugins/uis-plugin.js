/*================================================================================
 * @nombre: uis-plugin
 * @autor: Tomás Arturo Martínez Hernández (facebook.com/cazapachangas)
 * @demo: http://www.rari-senasica.gob.mx
 * @version: 1.0
 * @descripción: Clase que controla un mini-slider con dos capas mostrandolas de
 					manera intercalada al invocar la función animar.
 * @parametros: Recibe un objeto jQuery que contiene los divs que se mostrarán de
 					forma intercalada. class="ima" y class="cont"
 ================================================================================*/
 

 
	var noticia_uis=function (elemento){	
		this.obj=elemento;
		this.capa_uno=this.obj.find('div.ima');
		this.capa_dos=this.obj.find('div.cont');
		this.capa_uno.hide();
		this.capa_dos.hide();
		this.mostrado=true;
		
		this.animar=function(){
			if(this.mostrado){
				this.capa_dos.hide("bounce", { times:2 }, 200);
				this.capa_uno.delay(300).show("bounce", { times:3 }, 200);
			}else{
				this.capa_uno.hide("slide", { direction: "right" }, 200);
				this.capa_dos.delay(300).show("slide", { direction: "up" }, 400);
			}
			this.mostrado=!this.mostrado;
		}
	}
	
	
	var noticia=function (elemento){	
		this.obj=elemento;
		this.capa_uno=this.obj.find('div.ima');
		this.capa_dos=this.obj.find('div.cont');
		this.capa_uno.hide();
		this.capa_dos.hide();
		this.mostrado=true;
		
		this.animar=function(){
			if(this.mostrado){
				this.capa_dos.hide("slide", { direction: "right" }, 200);
				this.capa_uno.delay(300).show("slide", { direction: "up" }, 400);
			}else{
				this.capa_uno.hide("slide", { direction: "right" }, 200);
				this.capa_dos.delay(300).show("slide", { direction: "up" }, 400);
			}
			this.mostrado=!this.mostrado;
		}
	}
	
	var formulario=function(forma,divCont,contenedor){
		this.form=forma;
		this.Contenedor=divCont;
		this.Contenido=contenedor;
		
		this.animarEnvio=function(){
		
				this.Contenedor.delay(500).hide("slide", { direction: "right" }, 200);
		}
		
		
		this.enviar=function(_URL){
			this.animarEnvio();
			var elemento=this.Contenido;
			//var cerrarPopu=this.cerrarPopup();
			
			elemento.html("<h2>Cargando... Por favor espere!</h2>");
			$.ajax({
				type: "POST",
				url:_URL,
				data: this.form.serialize(),
				success: function(data){
					elemento.css("background-image","");
					elemento.html(data);
					
					//setTimeout("",10000);
					//sleep(5000)
					//cerrarPopu();
				},
				error: function(data){
					elemento.html("<h2>Lo sentimos, no se pudo completar la acción. Inténtelo de nuevo más tarde.</h2>");
					//revertir(true);
				}
			});
		}
	}
	
function sleep(miliseconds) {
           var currentTime = new Date().getTime();

           while (currentTime + miliseconds >= new Date().getTime()) {
           }
       }
	
