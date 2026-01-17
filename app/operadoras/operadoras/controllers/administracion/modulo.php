<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
        parent::__construct();
        if(consultar_session()){
	        $this->load->library('funciones');
			$this->load->library('tabla');
			$this->load->model('tabla_model');
	        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
			$this->idempresa=getIdempresaactual();
			$this->idsubmoduloactual=$this->arrayRequest['idsubmoduloactual'];
            if(empty($this->idsubmoduloactual) && !isset($this->arrayRequest['idgarantia']))
            {
                terminar_session();
            }
        }
    }

	public function index()
	{
        $data['vista_contenido_mod']=array("administracion/modulo_view");
        
        $jsbuscar = "buscaRegistro('".site_url('administracion/data/busquedamodulo')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Modulos','#busqueda')";
        
        /***  Se consultan los permisos para la botoneria    ***/
        
        $sqlPermisos="SELECT modificar,consultar,eliminar
        			  FROM   perfilsubmodulo 
        			  WHERE	 idperfilusuario='".getIdperfilactual()."' AND 
        			  		 idsubmodulo='".$this->idsubmoduloactual."'";
        $consultaPersmisos = $this->db->query($sqlPermisos);
        
        $rowPermisos=$consultaPersmisos->row();
        $consultaPersmisos->free_result();
        $arrayParamPermisoBotoneria= array('modificar' => $rowPermisos->modificar,'consultar' => $rowPermisos->consultar ,'eliminar' => $rowPermisos->eliminar);
        $this->load->library('botoneria',$arrayParamPermisoBotoneria);
        
        $existeinfo = 0;
        if(!empty($this->arrayRequest['idmodulo']))
        {
            $this->tabla->settabla('modulo');
            $condModulo=array('idmodulo'=>$this->arrayRequest['idmodulo']);
            $datosVehiculo = $this->tabla->consultarDatos("idmodulo,nombremodulo,carpetamodulo,orden",$condModulo,"","","","");
            $existeinfo = 1;
            $data['datoidmodulo'] = $datosVehiculo[0]['idmodulo'];
            $data['datonombremodulo'] = $datosVehiculo[0]['nombremodulo'];
            $data['datocarpetamodulo'] = $datosVehiculo[0]['carpetamodulo'];
            $data['datoorden'] = $datosVehiculo[0]['orden'];
        }
        //$data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
		$arrayParamBotonConsultar["url"]='administracion/data/busquedamodulo';
		$arrayParamBotonConsultar["titulo"]='Busqueda de Modulos';
		$arrayParamBotonConsultar["divbusqueda"]='#busqueda';
		$arrayParamBotonConsultar["parametros"]=array();
        $arrayParametros["consultar"]=$arrayParamBotonConsultar;
		$data['botoneria']= $this->botoneria->visualizaBotoneria_2($existeinfo,$arrayParametros);
		$this->load->view('include/plantilla3',$data);
    }
    
    
    public function registro()
    {
        $this->tabla->settabla('modulo');
        //$arrayCadena=$this->funciones->convRequest($_REQUEST);
        $arraypost=$this->input->post();
        
        $campos['nombremodulo']     =   $arraypost['nombremodulo'];
        $campos['carpetamodulo']    =   $arraypost['carpetamodulo'];
        $campos['orden']            =   $arraypost['orden'];
        
        if($arraypost["Guardar"]=="Guardar")
        {
            $campos['idmodulo']       =   $this->tabla->MaximoDato("idmodulo") + 1;
            $this->tabla->agregarDatosMinus($campos);
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idmodulo' => $arraypost['idmodulo']);
            $this->tabla->actualizarDatosMinus($campos,$condicion);
        }
        $this->index();
		?>
		<script type="text/javascript">
			alert("<?=$this->tabla->mensaje?>");
		</script>
		<?php
    }
}
/* End of file modulo.php */
/* Location: ./application/controllers/administracion/modulo.php */