/*================================================================================
 * @nombre: controlador-publico
 * @autor: Tomás Arturo Martínez Hernández (facebook.com/cazapachangas)
 * @demo: http://www.rari-senasica.gob.mx
 * @version: 1.0
 * @descripcion: Controlador de elementos ne l.
 ================================================================================*/

;(function($) {
	$(function() {
		
  var forma=new formulario($('#frm_suscripcion'),$('#formularioDiv'),$('#fff'));
  
  $('#btnSusc').click(function(){
 // alert("Oli");
 
 var AP=$('#apPaterno').val();
 var co=$('#correo').val();
 var no=$('#nombre').val();
 var expresion = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
 if((co.match(expresion) == null) ? false : true){
	 if(AP!=""&&co!=""&&no!="")
	  forma.enviar('php/registrarSuscriptor.php');
	  else
	  alert("Debe llenar todos los campos del formulario!!");
 }else
	 alert("Revise el formato del correo electrónico");
  });
	
		});		 
})(jQuery);





