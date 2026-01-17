<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehiculomega extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idvehiculoradiotelefono']))
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
        $data['vista_contenido_mod']=array("comunicaciones/vehiculomega_view");
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
        $this->tabla->settabla('vehiculomega');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		
        
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el mega ya esta asociado a otro vehiculo
            $condicionMegaAsociado = array('idvehiculoradiotelefono' => $arraypost['idvehiculoradiotelefono'], 'activo'=>'1', 'idempresa'=> $this->idempresa);
            $arrayMegaAsociado=$this->tabla->consultarDatos('*',$condicionMegaAsociado);
			if(!empty($arrayMegaAsociado)){
				//el vehiculo ya tiene asociado un mega
				$array_datos['mensaje']['msg']="El vehiculo ya tiene un numero de Mega o EME asociado";
				$array_datos['mensaje']['class']="error";
				$array_datos['datos']=$arraypost;
			}else{
				//se consulta si el mega ya esta asociado a otro vehiculo
				$condicionOtroMega = array('idmega' => $arraypost['idmega'], 'activo'=>'1', 'idempresa'=> $this->idempresa);
				$arrayOtroMega=$this->tabla->consultarDatos('*',$condicionOtroMega);
				if(!empty($arrayOtroMega)){
					//el mega ya esta asociado a otro vehiculo
					$array_datos['mensaje']['msg']="El numero de Mega o EME ya esta en uso";
					$array_datos['mensaje']['class']="error";
					$array_datos['datos']=$arraypost;
				}else{
					$campos['idvehiculomega']      		=   $this->tabla->MaximoDato("idvehiculomega") + 1;
					$campos['idempresa']				=   $this->idempresa ;
					$campos['idvehiculoradiotelefono']  =   $arraypost['idvehiculoradiotelefono'];
					$campos['idmega']   				=   $arraypost['idmega'];
					$campos['activo']       			=   1; //por defecto se activa el mega
					$this->tabla->agregarDatos($campos);
					$array_datos['mensaje']['msg']=$this->tabla->mensaje;
					$array_datos['mensaje']['class']="exito";
				}
			}
        }
		/*
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idvehiculoradiotelefono' => $arraypost['idvehiculoradiotelefono']);
            //$this->tabla->actualizarDatos($campos,$condicion);
        }
		*/
        $this->index($array_datos);
    }
    
}
/* End of file vehiculoradiotelefono.php */
/* Location: ./application/controllers/conductores/vehiculomega.php */