<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Soat extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idsoat']))
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
    /**
    * Muestra el formulario para el registro del seguro soat de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
	public function index($array_datos)
	{
		//se pasa el mensaje al array final que sera pasado a la vista
		$data['mensaje_confirmacion']=$this->load->view('include/mensaje_confirmacion',$array_datos['mensaje']);
		//se configura la vista a mostrar
        $data['vista_contenido_mod']=array("parqueautomotor/soat_view");
		$jsbuscar = "buscaRegistro('".site_url('parqueautomotor/data/buscarsoat')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Soat','#busqueda')";
        
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
		
		$datoidaseguradora="";
		
        if( !empty($this->arrayRequest['idsoat']) )
        {
			$this->tabla->settabla('soat');
			$cond=array('idsoat'=>$this->arrayRequest['idsoat']);
            $datos= $this->tabla->consultarDatos("*",$cond,"","","","");
            $existeinfo = 1;
			$data['disabled']="disabled='disabled'";
            $data['datoidsoat']     = $datos[0]['idsoat'];
			
			//consultamos los datos del vehiculo
			$this->tabla->settabla('vehiculo');
			$condVehiculo=array('idvehiculo'=>$datos[0]['idvehiculo']);
			$datosVehiculo = $this->tabla->consultarDatos("idvehiculo, placa",$condVehiculo,"","","","");
            $data['datoidvehiculo']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoplaca']          = $datosVehiculo[0]['placa'];
						
            $datoidaseguradora          = $datos[0]['idaseguradora'];
            $data['datonumerosoat']     = $datos[0]['numerosoat'];
            $data['datofechainicial']   = $this->funciones->convertirFormatoFecha($datos[0]['fechainicial'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datofechafinal']     = $this->funciones->convertirFormatoFecha($datos[0]['fechafinal'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datoactivo'] = ($datos[0]['activo']==1) ? 'checked="checked"' : ' ';
			
		}
		
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        // se consultan las aseguradoras
		$arrayAseguradoras=$this->funciones->consAseguradora();
        $data['aseguradoras']=$this->funciones->crearCombo($arrayAseguradoras, $datoidaseguradora,'idaseguradora','nombreaseguradora');
		
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion del seguro soat de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('soat');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		
        $campos['idvehiculo']   =   $arraypost['idvehiculo'];
		$campos['idempresa']   =	$this->idempresa;
        $campos['idaseguradora']=   $arraypost['idaseguradorasoat'];
        $campos['numerosoat']   =   $arraypost['numerosoat'];
        $campos['fechainicial'] =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialsoat']);
        $campos['fechafinal']   =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalsoat']);
		$campos['activo'] = ( $arraypost['activo']=='on' ) ? 1 : 0 ;
        
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el SOAT ya existe
            $condicionOtroSoat = array('numerosoat' => $arraypost['numerosoat'], 'idempresa'=> $this->idempresa);
            $arrayOtroSoat=$this->tabla->consultarDatos('*',$condicionOtroSoat);
			if(!empty($arrayOtroSoat)){
				//la placa ya esta registrada
				$array_datos['mensaje']['msg']="El numero de SOAT ".$arraypost['numerosoat']." ya esta registrado";
				$array_datos['mensaje']['class']="error";
			}else{
				//se inactivan los soat anteriores activo = 0
				$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo'], 'idempresa'=> $this->idempresa);
				$camposInactiva['activo']   =  0;
				$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
				
				$campos['idsoat']      =   $this->tabla->MaximoDato("idsoat") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idsoat' => $arraypost['idsoat']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        
        $this->index($array_datos);
    }
    
}
/* End of file soat.php */
/* Location: ./application/controllers/parqueautomotor/soat.php */