var eltexto = ".megaii-tab, h2:not(.acc), h3:not(.acc), .styletitle, .ltabs-tab, .mod_events_latest_noevents, label, strong,"; //strong
    eltexto += "#section-id-1604688400963 ul li, #sppb-addon-1603479065845 ul li , ul li p, span, p, .item-desc, .item-description, .mvc_peopleTable > tbody > tr > td, .yt-accordion-inner, .panel-body, .input_modal, .tipo_modal, h1,h2,table tr th,table tr td";
function lectura(complemento, elTexto) {
    responsiveVoice.cancel();
    var texto = elTexto;
    responsiveVoice.speak(complemento + texto, "Spanish Latin American Female", {volume: 100});
}
jQuery(document).ready(function(){
	jQuery("#switchHear").css("z-index","999999");
	var data_url =  jQuery("#switchHear").attr("data_url");
	var url_img_off = data_url+"img/icon-ear-off.jpg";
	var url_img_on = data_url+"img/icon-ear-on.jpg";

	if (localStorage.sonido === undefined) {
	   localStorage.sonido="false";
	}
	if(localStorage.sonido == "false"){
		estado_son = 0;
		jQuery('#switchHear').css( 'background-image', 'url('+url_img_on+')' );
		jQuery("#switchHear").attr("data", estado_son);
	}else if(localStorage.sonido == "true"){
		estado_son = 1;
		jQuery('#switchHear').css( 'background-image', 'url('+url_img_off+')' );
		jQuery("#switchHear").attr("data", estado_son);
	}
		jQuery('#bannerIzquierdo').mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	    		lectura("", "Descargue la APP del Poder Judicial");
	    	}
	    });
	    jQuery('#bannerDerecho').mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	    		lectura("", "Realice su denuncia");
	    	}
	    });
		jQuery('a').mouseenter(function() {
			var estado =  jQuery("#switchHear").attr("data");
			if(estado == 1){
	            if(typeof jQuery(this).attr('title') === 'undefined')
	                lectura("Enlace a ", jQuery(this).text());
	            else
	                lectura("Enlace a ", jQuery(this).attr('title'));
	        }
	    });
		jQuery('img').mouseenter(function() {
			var estado =  jQuery("#switchHear").attr("data");
			if(estado == 1){
		        lectura("Imagen de ", jQuery(this).attr('alt'));
	    	}
	    });

	    jQuery(eltexto).mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	        	lectura("", jQuery(this).text());
	    	}
	    });

	    jQuery('input[type=button], input[type=submit]').mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	    		lectura("", jQuery(this).val());
	    	}
	    });
	    jQuery('._switchHear').mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	    		lectura("", "Habilitar/deshabilitar lectura de contenido");
	    	}
	    });

	    jQuery('.input_modal').mouseenter(function() {
	    	var estado =  jQuery("#switchHear").attr("data");
	    	if(estado == 1){
	    		lectura("", "Ingrese su número de referencia");
	    	}
	    });
		jQuery("#switchHear").click(function(){

		var estado =  jQuery("#switchHear").attr("data");
		var data_url =  jQuery("#switchHear").attr("data_url");
		var url_img_off = data_url+"img/icon-ear-off.jpg";
		var url_img_on = data_url+"img/icon-ear-on.jpg";
		//estado 0 = sin sonido
		//estado 1 = con sonido
		if(estado == 0){
			//cambiar a 1
			jQuery("#switchHear").attr("data","1");
			jQuery('#switchHear').css( 'background-image', 'url('+url_img_off+')' );
			localStorage.sonido="true";


		}else{
			//cambiar a 0
			//jQuery("#prueba").attr("src","");
			jQuery("#switchHear").attr("data","0");
			jQuery('#switchHear').css( 'background-image', 'url('+url_img_on+')' );
			localStorage.sonido="false";
		}
	});
});
