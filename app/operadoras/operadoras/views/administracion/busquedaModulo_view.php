<script type="text/javascript">
$(document).ready(function(){

	$.get(site_url+'/administracion/data/consultarmodulo', function(data){ 
		console.log(site_url+'/administracion/data/consultarmodulo');
		console.log(data);
	    $("#busquedamodulo").typeahead({ source:data });
	},'json');
	
/*
	$('#busquedamodulo').typeahead({
		name: 'busquedamodulo',
		remote : site_url+'/administracion/data/consultarmodulo'
	});
*/
});
</script>
<style>
.typeahead-devs, .tt-hint {
border: 2px solid #CCCCCC;
border-radius: 8px 8px 8px 8px;
font-size: 24px;
height: 45px;
line-height: 30px;
outline: medium none;
padding: 8px 12px;
width: 400px;
}

.tt-dropdown-menu {
width: 400px;
margin-top: 5px;
padding: 8px 12px;
background-color: #fff;
border: 1px solid #ccc;
border: 1px solid rgba(0, 0, 0, 0.2);
border-radius: 8px 8px 8px 8px;
font-size: 18px;
color: #111;
background-color: #F1F1F1;
}
</style>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Modal title</h4>
	</div>
	<div class="modal-body">
	    <div class="form-group">
	        <div class="col-xs-12">
	            <input type="text" class="form-control typeahead" name="busquedamodulo" id="busquedamodulo" title="Carpeta Modulo" placeholder="Digite Nombre del Modulo" />
	        </div>
	    </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save changes</button>
	</div>
	
