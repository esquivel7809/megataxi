<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submodulo extends CI_Controller {

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
        $this->load->library('funciones');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idsubmodulo']))
            {
                terminar_session();
            }
            else
            {
                $this->load->library('tabla');
            }
        }
        else
        {
            terminar_session();
        }
    }

	public function index()
	{
        $data['vista_contenido_mod']=array("administracion/submodulo_view");
        
        $jsbuscar = "buscaRegistro('".site_url('administracion/data/busquedasubmodulo')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Submodulos','#busqueda')";
        
        /***  Se consultan los permisos para la botoneria    ***/
        
        $sqlPermisos="SELECT modificar,consultar,eliminar
        			  FROM   perfilsubmodulo 
        			  WHERE	 idperfilusuario='".$_SESSION['idperfilactual']."' AND 
        			  		 idsubmodulo='".$_SESSION['idsubmoduloactual']."'";
        $consultaPersmisos = $this->db->query($sqlPermisos);
        
        $rowPermisos=$consultaPersmisos->row();
        $consultaPersmisos->free_result();
        $param= array('modificar' => $rowPermisos->modificar,'consultar' => $rowPermisos->consultar ,'eliminar' => $rowPermisos->eliminar);
        $this->load->library('botoneria',$param);
        
        $datoidmodulo = "";
        $existeinfo = 0;
        
        if(!empty($this->arrayRequest['idsubmodulo']))
        {
            $this->tabla->settabla('submodulo');
            $condSubmodulo=array('idsubmodulo'=>$this->arrayRequest['idsubmodulo']);
            $datosVehiculo = $this->tabla->consultarDatos("idsubmodulo,nombresubmodulo,urlsubmodulo,idmodulo",$condSubmodulo,"","","","");
            $existeinfo = 1;
            $data['datoidsubmodulo'] = $datosVehiculo[0]['idsubmodulo'];
            $data['datonombresubmodulo'] = html_entity_decode($datosVehiculo[0]['nombresubmodulo']);
            $data['datourlsubmodulo'] = html_entity_decode($datosVehiculo[0]['urlsubmodulo']);
            $datoidmodulo = $datosVehiculo[0]['idmodulo'];
            
        }
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        /**** se consultan los modulos ***/
        $consultaModulos = $this->db->query('SELECT idmodulo,nombremodulo FROM modulo ORDER BY nombremodulo DESC');
        foreach ($consultaModulos->result_array() as $filaModulo)
        {
            $arrayModulos[]=$filaModulo;
        }
        $consultaModulos->free_result();
        $data['modulos']=$this->funciones->crearCombo($arrayModulos,$datoidmodulo,'idmodulo','nombremodulo');
        /**************/
        
        $this->load->view('include/plantilla3',$data);
    }
    
    
    public function registro()
    {
        $this->tabla->settabla('submodulo');
        $arraypost=$this->input->post();
        
        $campos['nombresubmodulo']  =   $arraypost['nombresubmodulo'];
        $campos['urlsubmodulo']     =   $arraypost['urlsubmodulo'];
        $campos['idmodulo']         =   $arraypost['idmodulo'];
        
        if($arraypost["Guardar"]=="Guardar")
        {
            $campos['idsubmodulo']  =   $this->tabla->MaximoDato("idsubmodulo") + 1;
            $this->tabla->agregarDatosMinus($campos);
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idsubmodulo' => $arraypost['idsubmodulo']);
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
/* End of file submodulo.php */
/* Location: ./application/controllers/administracion/submodulo.php */