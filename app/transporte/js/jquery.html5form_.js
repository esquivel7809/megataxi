/*
 *  Html5 Form Plugin - jQuery plugin
 *  HTML5 form Validation form Internet Explorer & Firefox
 *  Version 1.1  / English
 *  
 *  written by Jorge Serrano
 *  http://www.jossof.com
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
                responseDiv : '#contenido',
                messagesDiv : '#respuesta',
                labels : 'show',
                colorOn : '#000000', 
                colorOff : '#a1a1a1', 
                action : $(this).attr('action'),
                messages : false,
                emptyMessage : false,
                emailMessage : false,
                allBrowsers : false 
            };   
            var opts = $.extend({}, defaults, options);
            
            //Filters latest WebKit versions only 
            if(!opts.allBrowsers){
                if($.browser.webkit && parseInt($.browser.version)>=533){
                    return false;
                }
            }
                        
            //Private properties
            var form = $(this);
            var required = new Array();
            var email = new Array();
             

            //Setup color & placeholder function
            function fillInput(input){
                if(input.attr('placeholder') && input.val()=='' ){ //alert(input.val());
                    input.val(input.attr('placeholder'));
                    //input.css('color', opts.colorOff);
					input.css('border', 'solid 1px #EB1818;');
                    if($.browser.mozilla){
                        input.css('-moz-box-shadow', 'none');   
                    }
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
            if(opts.labels=='hide'){
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
                //alert(this.getAttribute('name')+' '+this.getAttribute('required'));
                //Setting color & placeholder
                fillInput($(this));
                
                //Make array of required inputs
                if(this.getAttribute('required')!=null){ //alert(this.getAttribute('name')+' '+this.getAttribute('required'));
                    required[i]=$(this);
                }
                
                //Make array of Email inputs               
                $('input').filter(this).each(function(){ 
                    if(this.getAttribute('type')=='email'){
                        email[i]=$(this);
                    }
                });
                           
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
            $.each($(':submit', this), function() { 
                $(this).bind('click', function(ev){
                    /*
                    var otrosDatos = new Array();
                    $.each($(':submit, :button, :disabled',form), function(){
                        otrosDatos[$(this).attr('name')]=$(this).attr('value');
                    }); //alert(otrosDatos);
                    */
            		var urldisabled="&";
            		$(':disabled').each(function() {
            			urldisabled+=$(this).attr('name')+"="+$(this).attr('value')+"&";
            		});
                                       
                    var emptyInput=null;
                    var emailError=null;
                    var input = $(':input:visible:not(:button, :submit, :radio, :checkbox, select)', form); //alert(input);
                    
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
                                $(opts.messagesDiv).html('<p>Il campo '+$(this).attr('title')+' Ã© richiesto.</p>');
                            }
                            else if(opts.messages=='de'){
                               //German empty message
                               $(opts.messagesDiv).html('<p>'+$(this).attr('title')+' ist ein Pflichtfeld.</p>');
                            }
                            else if(opts.messages=='fr'){
                               //Frech empty message
                               $(opts.messagesDiv).html('<p>Le champ '+$(this).attr('title')+' est requis.</p>');
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
                        
                        //Clear all empty value fields before Submit 
                        $(input).each(function(){ //alert($(this).attr("id"));
                            if($(this).val()==$(this).attr('placeholder')){ 
                                $(this).val('');
                            }
                        }); 
                        //Submit data by Ajax
                        if(opts.async){ 
                            var formData=$(form).serialize(); //alert(formData); //alert(otrosDatos);
                            formData+=urldisabled;
                            formData+= 'Guardar=' + $("#Guardar").attr('value');
                            $.ajax({
                                url : opts.action,
                                type : opts.method,
                                data : formData,
                                success : function(data){
                                    if(opts.responseDiv){ //alert(data);
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
							fillInput($(emptyInput));
                        }
                        else if(emailError){
                            //Customized email error messages (Spanish, English, Italian, German, French)
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