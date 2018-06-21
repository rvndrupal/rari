/*================================================================================
 * @nombre: controlador-publico
 * @autor: Tomás Arturo Martínez Hernández (facebook.com/cazapachangas)
 * @demo: http://www.rari-senasica.gob.mx
 * @version: 1.0
 * @descripcion: Controlador de elementos ne l.
 ================================================================================*/

var c=false;
;(function($) {
	$( window ).load(function() {
		
		pedir(0,$("#modulo").val());
		
		$("#vermas").click(function(){
			pedir($("#total").val(),$("#modulo").val());
		});	
		
		function scrolle() {
    $('html,body').animate({
        scrollTop: $("#vermas").offset().top
    }, 900);
}


function agregarNoticiasATabla(data, valor){
	$("#comunicados > tbody:last").append(data);
	var res=parseInt(valor)-parseInt($("#total").val());
	
	
	
	
	$("#total").val(valor);
	
	if(c)
	scrolle();
	
	if(parseInt(res)<10)
	$("#vermas").hide();
	c=true;
}


function pedir(cant,ar){
//alert(ar);
    $.ajax({
				type: "POST",
				url:"php/historico.php",
				data: { cantidad : cant, area:ar},
				success: function(data){
				
				var arrayResult=data.split("¬")
				
				if(arrayResult[0]!="")
				agregarNoticiasATabla(arrayResult[0],arrayResult[1]);
				},
				error: function(data){
				
				window.location.href ='index.php';
					
				}
			});

}
		
	});		 
})(jQuery);





	