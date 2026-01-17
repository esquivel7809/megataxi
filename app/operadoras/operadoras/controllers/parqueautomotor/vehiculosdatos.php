<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehiculosdatos extends CI_Controller {
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
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idvehiculo']))
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
    * Muestra el formulario para el registro de los vehiculos
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
        $data['vista_contenido_mod']=array("parqueautomotor/vehiculosdatos_view");
        $jsbuscar = "buscaRegistro('".site_url('parqueautomotor/data/buscarvehiculo')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Vehiculos','#busqueda')";
        
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
        
        // se consultan las aseguradoras
		$arrayAseguradoras=$this->funciones->consAseguradora();
        $data['aseguradoras']=$this->funciones->crearCombo($arrayAseguradoras,'','idaseguradora','nombreaseguradora');
        // se consultan los cda 
		$arrayCda=$this->funciones->consCda("", "WHERE ciudadcda='IBAGUE'");
        $data['cda']=$this->funciones->crearCombo($arrayCda,'','idcda','nombrecda');
		if(!empty($array_datos['idvehiculo']))
		{
			$data['datoidvehiculo']=$array_datos['idvehiculo'];
			$data['datoplaca']=$array_datos['placa'];
			$data['datogrilla']=utf8_encode($this->funciones->consVehiculoseguros($array_datos['idvehiculo']));
		}
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		$array_datos['idvehiculo']=$arraypost['idvehiculo'];
		$array_datos['placa']=$arraypost['placa'];
		$campos['idvehiculo']   =   $arraypost['idvehiculo'];
		$campos['idempresa']   	=	$this->idempresa;
		switch($arraypost['Guardar'])
		{
			case("Guardar_soat"):
				//se setea la tabla a modificar
				$this->tabla->settabla('soat');
		
				$campos['idaseguradora']=   $arraypost['idaseguradorasoat'];
				$campos['numerosoat']   =   $arraypost['numerosoat'];
				$campos['fechainicial'] =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialsoat']);
				$campos['fechafinal']   =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalsoat']);
				$campos['activo']       =   1;
				
				//se consulta si el la placa ya existe
				$condicionOtroSoat = array('numerosoat' => $arraypost['numerosoat']);
				$arrayOtroSoat=$this->tabla->consultarDatos('*',$condicionOtroSoat);
				if(!empty($arrayOtroSoat)){
					//la placa ya esta registrada
					$array_datos['mensaje']['msg']="El numero de SOAT ".$arraypost['numerosoat']." ya esta registrado";
					$array_datos['mensaje']['class']="error";
				}else{
	
					//se inactivan los soat anteriores activo = 0
					$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo']);
					$camposInactiva['activo']   =  0;
					$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
					
					$campos['idsoat']      =   $this->tabla->MaximoDato("idsoat") + 1;
					$this->tabla->agregarDatos($campos);
					$array_datos['mensaje']['msg']=$this->tabla->mensaje;
					$array_datos['mensaje']['class']="exito";
				}
				
			break;
			case("Guardar_revision"):
				//se setea la tabla a modificar
				$this->tabla->settabla('revision');
				$campos['idcda']            =   $arraypost['idcda'];
				$campos['numerorevision']   =   $arraypost['numerorevision'];
				$campos['fechainicial']     =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialrevision']);
				$campos['fechafinal']       =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalrevision']);
				$campos['activo']           =   1;
				
				//se consulta si el la placa ya existe
				$condicionOtraRevision = array('numerorevision' => $arraypost['numerorevision']);
				$arrayOtraRevision=$this->tabla->consultarDatos('*',$condicionOtraRevision);
				if(!empty($arrayOtraRevision)){
					//la placa ya esta registrada
					$array_datos['mensaje']['msg']="El numero de revision ".$arraypost['numerorevision']." ya esta registrada";
					$array_datos['mensaje']['class']="error";
				}else{
	
					//se inactivan los soat anteriores activo = 0
					$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo']);
					$camposInactiva['activo']   =  0;
					$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
					
					$campos['idrevision']      =   $this->tabla->MaximoDato("idrevision") + 1;
					$this->tabla->agregarDatos($campos);
					$array_datos['mensaje']['msg']=$this->tabla->mensaje;
					$array_datos['mensaje']['class']="exito";
				}
			break;
			case("Guardar_tarjeta"):
				//se setea la tabla a modificar
				$this->tabla->settabla('tarjetaoperacion');
				$campos['numerotarjetaoperacion']   =   $arraypost['numerotarjetaoperacion'];
				$campos['fechainicial']             =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialopera']);
				$campos['fechafinal']               =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalopera']);
				$campos['activo']                   =   1;
				
				//se consulta si el numero de tarjeta de operacion ya existe
				$condicionOtraTarjeta = array('numerotarjetaoperacion' => $arraypost['numerotarjetaoperacion']);
				$arrayOtroTarjeta=$this->tabla->consultarDatos('*',$condicionOtraTarjeta);
				if(!empty($arrayOtroTarjeta)){
					//la tarjeta de operacion ya esta registrada
					$array_datos['mensaje']['msg']="El numero de tarjeta ".$arraypost['numerotarjetaoperacion']." ya esta registrada";
					$array_datos['mensaje']['class']="error";
				}else{
					//se inactivan las tarjetas de operacion anteriores activo = 0
					$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo']);
					$camposInactiva['activo']   =  0;
					$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
					
					$campos['idtarjetaoperacion']      =   $this->tabla->MaximoDato("idtarjetaoperacion") + 1;
					$this->tabla->agregarDatos($campos);
					$array_datos['mensaje']['msg']=$this->tabla->mensaje;
					$array_datos['mensaje']['class']="exito";
				}
			break;
			case("Guardar_contra"):
				//se setea la tabla a modificar
				$this->tabla->settabla('contractual');
				$campos['idaseguradora']    =   $arraypost['idaseguradoracontra'];
				$campos['numerocontractual']=   $arraypost['numerocontractual'];
				$campos['fechainicial']     =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialcontra']);
				$campos['fechafinal']       =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalcontra']);
				$campos['activo']           =   1;
				
				//se inactivan los Seg. Contractuales anteriores activo = 0
				$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo']);
				$camposInactiva['activo']   =  0;
				$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
				
				$campos['idcontractual']      =   $this->tabla->MaximoDato("idcontractual") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
				
			break;
			case("Guardar_extra"):
				//se setea la tabla a modificar
				$this->tabla->settabla('extracontractual');
				
				$campos['idaseguradora']            =   $arraypost['idaseguradoraextra'];
				$campos['numeroextracontractual']   =   $arraypost['numeroextracontractual'];
				$campos['fechainicial']             =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialextra']);
				$campos['fechafinal']               =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalextra']);
				$campos['activo']                   =   1;
				
				//se inactivan los Seg. Contractuales anteriores activo = 0
				$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo']);
				$camposInactiva['activo']   =  0;
				$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
				
				$campos['idextracontractual']      =   $this->tabla->MaximoDato("idextracontractual") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			
			break;
		}
		$this->index($array_datos);
    }
}
/* End of file vehiculos.php */
/* Location: ./application/controllers/paraqueautomotor/vehiculosdatos.php */