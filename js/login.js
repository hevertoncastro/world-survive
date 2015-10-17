//PEGA VALOR DE GET RES
var getUrl = function getParameterByName(name){
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	results = regex.exec(location.search);
	return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

//SUBMIT COM ENTER
$("input").bind("keydown", function(event) {
	// track enter key
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if (keycode == 13) { // keycode for enter key
	// force the 'Enter Key' to implicitly click the Update button
	$('.btn-send').click();
	return false;
	} else  {
	return true;
	}
});

//RETORNA RESPOSTA
returnError = function(item, message){

	//ADD BORDA VERMELHA
	$("#"+item).addClass("invalid");
	//ADD ESTILO DE ALERTA NA RESPOSTA
	$(".response").addClass("warning");
	//PREENCHE RESPOSTA E MOSTRA
	$(".response p").html(message);
	$(".response").show("slow");

	//FOCA NO CAMPO
    setTimeout(function(){

    	$('html, body').animate({
		    scrollTop: $("#"+item).offset().top
		    
		}, 700);
		$("#"+item).focus();

    }, 2000);
    

    //ESCONVE AVISO APÓS DELAY
    setTimeout(function(){

    	$(".response").hide("slow");
    	$("#"+item).removeClass("invalid");

    }, 3000);
}