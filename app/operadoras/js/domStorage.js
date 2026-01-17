/**
 * @author Jorge Serrano
 */
domStorage = {
    count: 0,

    init: function() {
    	
    },
    
	storeMode: function(params)
	{
		for (domStorage.count in params) {
			var oJson =  [];
			
			//console.log(params[atenea.domStorage.count]);
			
			if (typeof params[domStorage.count].FilterMember == "undefined")			
				params[domStorage.count].FilterMember = "";

			if (params[domStorage.count].FilterMember == '') {
				//oJson = this.storeGetAll(params[atenea.domStorage.count].FilterPattern);
				//console.log("storeGetItem " + params[atenea.domStorage.count].KeyIDPattern);
				oJson = this.storeGetItem(params[domStorage.count].KeyIDPattern);
			}
			else {
				//oJson = this.storeFilter(params[atenea.domStorage.count].FilterPattern, params[atenea.domStorage.count].FilterMember, params[atenea.domStorage.count].FilterValue);
				//console.log("storeFilter_v2 " + params[atenea.domStorage.count].KeyIDPattern);
				oJson = this.storeFilter_v2(params[domStorage.count].KeyIDPattern, params[domStorage.count].FilterMember, params[domStorage.count].FilterValue);
			}
				

			/*var groupname = 'Debug Local Retrieve';
			console.group(groupname);
			console.log(params[atenea.domStorage.count].KeyIDPattern + ' LocalStorage Count: '+ oJson.length, groupname);
			console.groupEnd();*/

			//$('.ui-loader').css('display', 'block');
			if (oJson === null)
				oJson = [];

			//console.log($(".ui-loader").attr("display"));
			if (parseInt(oJson.length) >= 1) {	
				//console.log("LOCAL: " + params[atenea.domStorage.count].KeyIDPattern);
				//console.log('Inicio Render: ' + new Date().toGMTString());
				//$(".ui-loader").attr("display","block");
				oElement = params[domStorage.count].object;
				
				if (params[domStorage.count].value !== undefined)
					sValue = params[domStorage.count].value;
				else
					sValue = '';
				
				if (params[domStorage.count].objectLabel !== undefined)
					$objectLabel = params[domStorage.count].objectLabel;
				else
					$objectLabel = '';
				
				if (params[domStorage.count].change !== undefined)
					bChange = true;
				else
					bChange = false;
				
				//console.log("ejecutando el render");
				
				if (typeof params[domStorage.count].objectRender == "undefined") {
					if (typeof params[domStorage.count].functionRun != "undefined") {
						//console.log("paso 001");
						//console.log(params[domStorage.count].KeyIDPattern);
						//console.log(oJson);
						var $oFunction = params[domStorage.count].functionRun;
						if (typeof $oFunction == "function" && oJson.length > 0) {
							$oFunction(oJson);
						}						
					}
				}
				else {
					domStorage._render(oElement, oJson, sValue, $objectRender_, $objectLabel, bChange);
				}
				
			}
			else {
				//$(".ui-loader").attr("display","block");
				//console.log('Inicio Carga: ' + new Date().toGMTString());
				//console.log("REMOTO: " + params[atenea.domStorage.count].KeyIDPattern);
				this.storeAddBatch(params);
			}
		}
	},
	
	storeFilter_v2: function (sIndex, sNameMember, sValue) {
		var jsonData = domStorage.storeGetItem(sIndex);
		var jsonResult_ = [];
		var value = '';
		
		if (jsonData === null)
			return jsonResult_;
		
		for (var i = 0; i < jsonData.length; i++) {
			value = jsonData[i][sNameMember];
			if (value.toString() == sValue.toString()){				
				jsonResult_.push(jsonData[i]);
			}
		}
		return jsonResult_;
	},

	storeGetItem: function (sIndex) {
		var result = JSON.parse(window.localStorage.getItem(sIndex));
		if (result === null)
			result = [];
		 
		return result;
	},
	storeGetFilterItem: function (sIndex, sNameMember, sValue) {
		var jsonResult_ = [];
		
		var jsonData = domStorage.storeGetItem(sIndex);
		for (var i = 0; i < jsonData.length; i++) {
			value = ''+jsonData[i][sNameMember];
			//console.log(value);
			//console.log(sValue);
			//console.log(value == sValue);
			if (value == sValue){				
				jsonResult_.push(jsonData[i]);
			}
		}
		return jsonResult_;
	},
	
	storeAddBatch: function(params) {
		//console.log("storeAddBatch");
		//this.storeRemoveAll();
		var url = params[domStorage.count].url;
		var sKeyIndexPattern = params[domStorage.count].KeyIndexPattern;
		var sKeyIDPattern = params[domStorage.count].KeyIDPattern;
		var sFilterPattern = params[domStorage.count].FilterPattern;
		var oElement = params[domStorage.count].object;
		var sNameMember = params[domStorage.count].FilterMember;
		var sFilterValue = params[domStorage.count].FilterValue;
		var sValue = params[domStorage.count].value;
		var $objectRender_ = params[domStorage.count].objectRender;
		var $objectLabel_ = params[domStorage.count].objectLabel;
		var $oFunction = params[domStorage.count].functionRun;
		var $oLoader = params[domStorage.count].loader;
		
		/*
		if (typeof params[domStorage.count].change == "undefined")
			var bChange = false;
		else
			var bChange = true;
*/
		// Mostrar el indicador 
		//if (typeof $oFunction != "undefined" && $oFunction != null) {
		//	$oLoader.show();	
		//}

		$.ajax({
		    url: url,
		    dataType: "json",
		    async: true,
		    cache: false,
		    success: function (data, status) {		    	
				domStorage.storeAdd_v2(data, sKeyIDPattern);
				var type = "";
				var oJson = [];
				if (sNameMember === '')
					oJson = domStorage.storeGetItem(sKeyIDPattern);
				else {
					oJson = domStorage.storeFilter_v2(sKeyIDPattern, sNameMember, sFilterValue);
				}
				
				if (++domStorage.count < params.length)
				{
					domStorage.storeAddBatch(params)
				}
				/*if (typeof $oFunction == "function" && oJson.length > 0) {
					$oFunction(oJson);
				}*/
				//ePharma.api.carga.actualizarIndicador(sKeyIDPattern);
				
				/*if (typeof $oFunction != "undefined") {
					$oLoader.hide();	
				}*/
		    }
		});
	},

	storeAdd_v2: function(data, sIndex) {
		window.localStorage.setItem(sIndex, JSON.stringify(data));
	},

};