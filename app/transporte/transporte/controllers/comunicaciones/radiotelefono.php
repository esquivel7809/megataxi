<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Radiotelefono extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/conductores/conductores
	 *	- or -
	 * 		http://example.com/index.php/conductores/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/conductores/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
        parent::__construct();
        $this->load->library('funciones');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idradiotelefono']))
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
	public function index($array_datos)
	{
		//se pasa el mensaje al array final que sera pasado a la vista
		$data['mensaje_confirmacion']=$this->load->view('include/mensaje_confirmacion',$array_datos['mensaje']);
		//se configura la vista a mostrar
        $data['vista_contenido_mod']=array("comunicaciones/radiotelefono_view");
        //$jsbuscar = "buscaRegistro('".base_url()."index.php/conductores/data/buscarconductor','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Conductores','#busqueda')";
        
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
		if(!empty($array_datos['datos']))
		{
			foreach($array_datos['datos'] as $key => $valor )
			{
				$array["dato".$key]=$valor;
				${"dato".$key}=$valor;
			}
			$data = array_merge($data, $array);
		}
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        $this->load->view('include/plantilla3',$data);
    }
        
        
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('radiotelefono');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		$campos['idempresa']			=   $this->idempresa ;
        $campos['idmodeloradio']		=   $arraypost['idmodeloradio'];
        $campos['serieradiotelefono']   =   $arraypost['serieradiotelefono'];
        $campos['activo']       		=   1;
        
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el serial del raditotelefono ya esta en uso
            $condOtroSerial = array('serieradiotelefono' => $arraypost['serieradiotelefono'], 'idempresa'=> $this->idempresa);
            $arrayOtroSerial=$this->tabla->consultarDatos('*',$condOtroSerial);
			if(!empty($arrayOtroSerial)){
				//el mega ya esta asociado a otro vehiculo
				$array_datos['mensaje']['msg']="El numero de Serie ".$arraypost['serieradiotelefono']." ya esta en uso";
				$array_datos['mensaje']['class']="error";
				$array_datos['datos']=$arraypost;
			}else{
	
				$campos['idradiotelefono']      =   $this->tabla->MaximoDato("idradiotelefono") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idradiotelefono' => $arraypost['idradiotelefono']);
            //$this->tabla->actualizarDatos($campos,$condicion);
			//$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			//$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
    
}
/* End of file vehiculoradiotelefono.php */
/* Location: ./application/controllers/comunicaciones/radiotelefono.php */