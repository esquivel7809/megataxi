/*
 *  Html5 Form Plugin - jQuery plugin
 *  Version 1.5  / English
 *  
 *  Author: by Matias Mancini http://www.matiasmancini.com.ar
 *  http://www.matiasmancini.com.ar/jquery-plugin-validar-formularios-html5-con-ajax.html
 * 
 *  Copyright (c) 2010 Matias Mancini (http://www.matiasmancini.com.ar)
 *  Dual licensed under the MIT (MIT-LICENSE.txt)
 *  and GPL (GPL-LICENSE.txt) licenses.
 *
 *  Built for jQuery library
 *	http://jquery.com
 *
 */
(function($){
    $.fn.html5form = function(options){
        
        $(this).each(function(){
            
            //default configuration properties
            var defaults = {
                async : true,
                method : $(this).attr('method'), 
                responseDiv : '#contenido', //null,
				messagesDiv : '#respuesta',
                labels : 'show',
                colorOn : '#6b6764', //'#000000', 
                colorOff : '#b4b1af', //'#a1a1a1', 
                action : $(this).attr('action'),
                messages : 'es', //false,
                emptyMessage : false,
                emailMessage : 'Dirección de correo inválida', //false,
                allBrowsers : true
            };   
            var opts = $.extend({}, defaults, options);
            
            //Filter modern browsers 
            if(!opts.allBrowsers){
                //exit if Webkit > 533
                if($.browser.webkit && parseInt($.browser.version) >= 533){
                    return false;
                }
                //exit if Firefox > 4
                if($.browser.mozilla && parseInt($.browser.version) >= 2){
                    return false;   
                }
                //exit if Opera > 11
                if($.browser.opera && parseInt($.browser.version) >= 11){
                    return false;   
                }   
            }
                        
            //Private properties
            var form = $(this);
            var required = new Array();
            var email = new Array();

            //Setup color & placeholder function
            function fillInput(input){
                if(input.attr('placeholder') && input.val()=='' && input.attr('type') != 'password'){
                    //input.val(input.attr('placeholder'));
                    input.css('color', opts.colorOff);
                }else{
                    if(!input.data('value')){
                        if(input.val()!=''){
                            input.data('value', input.val());   
                        }
                    }else{
                        input.val(input.data('value'));
                    }   
                    //input.css('color', opts.colorOn);
					input.css('border', 'solid 1px #EB1818;');
                }
            }
            
            //Label hiding (if required)
            if(opts.labels == 'hide'){
                $(this).find('label').hide();   
            }
            
            //Select event handler (just colors)
            $.each($('select', this), function(){
                $(this).css('color', opts.colorOff);
                $(this).change(function(){
                    $(this).css('color', opts.colorOn);
                });
            });
                        
            //For each textarea & visible input excluding button, submit, radio, checkbox and select
            //$.each($(':input:visible:not(:button, :submit, :radio, :checkbox, select)', form), function(i) {
			$.each($(':input:visible:not(:button, :submit)', form), function(i) {
                
                //Setting color & placeholder
                fillInput($(this));

                //Make array of required inputs
                if(this.getAttribute('required')!=null){
                    required[i]=$(this);
                }
                
                //Make array of Email inputs               
                if(this.getAttribute('type')=='email'){
                    email[i]=$(this);
                }
                          
                //FOCUS event attach 
                //If input value == placeholder attribute will clear the field
                //If input type == url will not
                //In both cases will change the color with colorOn property                 
                $(this).bind('focus', function(ev){
                    ev.preventDefault();
                    if(this.value == $(this).attr('placeholder')){
                        if(this.getAttribute('type')!='url'){
                            $(this).attr('value', '');   
                        } 
                    }
                    $(this).css('color', opts.colorOn);
                });
                
                //BLUR event attach
                //If input value == empty calls fillInput fn
                //if input type == url and value == placeholder attribute calls fn too
                $(this).bind('blur', function(ev){
                    ev.preventDefault();
                    if(this.value == ''){
                        fillInput($(this));
                    }
                    else{
                        if((this.getAttribute('type')=='url') && ($(this).val()==$(this).attr('placeholder'))){
                            fillInput($(this));
                        }
                    }
                });
                
                //Limits content typing to TEXTAREA type fields according to attribute maxlength
                $('textarea').filter(this).each(function(){
                    if($(this).attr('maxlength')>0){
                        $(this).keypress(function(ev){
                            var cc = ev.charCode || ev.keyCode;
                            if(cc == 37 || cc == 39) {
                                return true;
                            }
                            if(cc == 8 || cc == 46) {
                                return true;
                            }
                            if(this.value.length >= $(this).attr('maxlength')){
                                return false;   
                            }
                            else{
                                return true;
                            }
                        });
                    }
                });
            });
			//se coloca el cursor en el primer elemento required del form
			var primerinput=required[0];
			$(primerinput).focus().select();

            //$.each($('input:submit, input:image, input:button', this), function() { 
			$.each($('input:submit', this), function() { 
                $(this).bind('click', function(ev){

                    var emptyInput=null;
                    var emailError=null;
                    var input = $(':input:visible:not(:button, :submit, :radio, :checkbox, select)', form);                    
                    
                    //Search for empty fields & value same as placeholder
                    //returns first input founded
                    //Add messages for multiple languages
                    $(required).each(function(key, value) { 
                        if(value==undefined){
                            return true;
                        }
                        if(($(this).val()==$(this).attr('placeholder')) || ($(this).val()=='') || ($(this).val()==0)){
                            emptyInput=$(this);
                            if(opts.emptyMessage){
                                //Customized empty message
                                $(opts.messagesDiv).html('<p>'+opts.emptyMessage+'</p>');
                            }
                            else if(opts.messages=='es'){
                                //Spanish empty message
                                //$(opts.messagesDiv).html('<p>El campo '+$(this).attr('title')+' es requerido.</p>');
								alert('El campo '+$(this).attr('title')+' es requerido.');
                            }
                            else if(opts.messages=='en'){
                                //English empty message
                                $(opts.messagesDiv).html('<p>The '+$(this).attr('title')+' field is required.</p>');
                            }
                            else if(opts.messages=='it'){
                                //Italian empty message
                                $(opts.messagesDiv).html('<p>Il campo '+$(this).attr('title')+' &eacute; richiesto.</p>');
                            }
                            else if(opts.messages=='de'){
                                //German empty message
                                $(opts.messagesDiv).html('<p>'+$(this).attr('title')+' ist ein Pflichtfeld.</p>');
                            }
                            else if(opts.messages=='fr'){
                                //Frech empty message
                                $(opts.messagesDiv).html('<p>Le champ '+$(this).attr('title')+' est requis.</p>');
                            }
                            else if(opts.messages=='nl' || opts.messages=='be'){
                                //Dutch messages
                                $(opts.messagesDiv).html('<p>'+$(this).attr('title')+' is een verplicht veld.</p>');
                            }
                            else if(opts.messages=='br'){
                               //Brazilian empty message
                               $(opts.messagesDiv).html('<p>O campo '+$(this).attr('title')+' &eacute; obrigat&oacute;rio.</p>');
                            }
                            else if(opts.messages=='br'){
                                $(opts.messagesDiv).html("<p>Insira um email v&aacute;lido por favor.</p>");
                            }                   
                            return false;
                        }
                    return emptyInput;
                    });
                        
                    //check email type inputs with regular expression
                    //return first input founded
                    $(email).each(function(key, value) {
                        if(value==undefined){
                            return true;
                        }
                        if($(this).val().search(/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/i)){
                            emailError=$(this);
                            return false;
                        }
                    return emailError;
                    });

                    //Submit form ONLY if emptyInput & emailError are null
                    //if async property is set to false, skip ajax
                    if(!emptyInput && !emailError){
						var urldisabled="&";
						$(':disabled').each(function() {
							urldisabled+=$(this).attr('name')+"="+$(this).attr('value')+"&";
						});
                        
                        //Clear all empty value fields before Submit 
                        $(input).each(function(){
                            if($(this).val()==$(this).attr('placeholder')){
                                $(this).val('');
                            }
                        }); 

                        //Submit data by Ajax
                        if(opts.async){ 
                            var formData=$(form).serialize();
                            formData+=urldisabled;
                            formData+= 'Guardar=' + $("#Guardar").attr('value');
                            $.ajax({
                                url : opts.action,
                                type : opts.method,
                                data : formData,
                                success : function(data){
                                    if(opts.responseDiv){
                                        $(opts.responseDiv).html(data);   
                                    }
                                    //Reset form
                                    $(input).val('');
                                    $.each(form[0], function(){
                                        fillInput($(this).not(':hidden, :button, :submit, :radio, :checkbox, select'));
                                        $('select', form).each(function(){
                                            $(this).css('color', opts.colorOff);
                                            $(this).children('option:eq(0)').attr('selected', 'selected');
                                        });
                                        $(':radio, :checkbox', form).removeAttr('checked');
                                    });  
                                }
                            });   
                        }
                        else{ 
                            $(form).submit();
                        }
                    }else{
                        if(emptyInput){
                            $(emptyInput).focus().select();              
                        }
                        else if(emailError){
                            //Customized email error messages (Spanish, English, Italian, German, French, Dutch)
                            if(opts.emailMessage){
                                $(opts.messagesDiv).html('<p>'+opts.emailMessage+'</p>');
                            }
                            else if(opts.messages=='es'){
                                $(opts.messagesDiv).html('<p>Ingrese una direcci&oacute;n de correo v&aacute;lida por favor.</p>');
                            }
                            else if(opts.messages=='en'){
                                $(opts.messagesDiv).html('<p>Please type a valid email address.</p>');
                            }
                            else if(opts.messages=='it'){
                                $(opts.messagesDiv).html("<p>L'indirizzo e-mail non &eacute; valido.</p>");
                            }
                            else if(opts.messages=='de'){
                                $(opts.messagesDiv).html("<p>Bitte eine g&uuml;ltige E-Mail-Adresse eintragen.</p>");
                            }
                            else if(opts.messages=='fr'){
                                $(opts.messagesDiv).html("<p>Entrez une adresse email valide s&rsquo;il vous plait.</p>");
                            }
                            else if(opts.messages=='nl' || opts.messages=='be'){
                                $(opts.messagesDiv).html('<p>Voert u alstublieft een geldig email adres in.</p>');
                            }
                            $(emailError).select();
                        }else{
                            alert('Unknown Error');                        
                        }
                    }
                    return false;
                });
            });
        });
    } 
})(jQuery);