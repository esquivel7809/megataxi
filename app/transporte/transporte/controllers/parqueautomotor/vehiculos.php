<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehiculos extends CI_Controller {
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
        $data['vista_contenido_mod']=array("parqueautomotor/vehiculos_view");
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
        
        $datoidmodelo = "";
        $datoidmarcavehiculo = "";
        $existeinfo = 0;
        $datoidrevisado = "";
        $condVehiculo="";
    
        if(!empty($this->arrayRequest['idvehiculo']) || !empty($this->arrayRequest['placa']))
        {
            $this->tabla->settabla('vehiculo');
            if(!empty($this->arrayRequest['idvehiculo']))
            {
                $condVehiculo=array('idvehiculo'=>$this->arrayRequest['idvehiculo'], 'idempresa'=> $this->idempresa);
            }
            else
            {
                $condVehiculo=array('placa'=>$this->arrayRequest['placa'], 'idempresa'=> $this->idempresa);
            }
            $datosVehiculo = $this->tabla->consultarDatos("*",$condVehiculo,"","","","");
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
            $data['datoidvehiculo']     = $datosVehiculo[0]['idvehiculo'];
            $data['datoplaca']          = html_entity_decode($datosVehiculo[0]['placa']);
            $datoidmodelo               = $datosVehiculo[0]['idmodelo'];
            $datoidmarcavehiculo        = $datosVehiculo[0]['idmarcavehiculo'];
            $data['datocilindraje']     = $datosVehiculo[0]['cilindraje'];
            $data['datonumerochasis']   = $datosVehiculo[0]['numerochasis'];
            $data['datonumeromotor']    = $datosVehiculo[0]['numeromotor'];
            $data['datonumerolicencia'] = $datosVehiculo[0]['numerolicencia'];
            $data['datofechamatricula'] = $this->funciones->convertirFormatoFecha($datosVehiculo[0]['fechamatricula'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datonumerointerno']  = $datosVehiculo[0]['numerointerno'];
            $datoidrevisado             = $datosVehiculo[0]['idrevisado'];
            $datoidtipovehiculo         = $datosVehiculo[0]['idtipovehiculo'];
            if($datosVehiculo[0]['asociado']==1)$data['datoasociado'] = 'checked="checked"';  
            if($datosVehiculo[0]['empresa']==1)$data['datoempresa'] = 'checked="checked"';
            if($datosVehiculo[0]['comunicacion']==1)$data['datocomunicacion'] = 'checked="checked"';
            if($datosVehiculo[0]['conduce']==1)$data['datoconduce'] = 'checked="checked"';
            $data['datoactivo'] = ' ';
            if($datosVehiculo[0]['activo']==1)$data['datoactivo'] = 'checked="checked"';
            
        }
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        /************/
        
        /**** se consultan los modelos ***/
		$arrayModelos=$this->funciones->consModelo();
        $data['modelos']=$this->funciones->crearCombo($arrayModelos,$datoidmodelo,'idmodelo','nombremodelo');
        /**************/
        
        /**** se consultan las marcas ***/
		$arrayMarcas=$this->funciones->consMarcavehiculo();
        $data['marcas']=$this->funciones->crearCombo($arrayMarcas,$datoidmarcavehiculo,'idmarcavehiculo','nombremarcavehiculo');
        /**************/
        
        /**** se consultan los meses ***/
		$arrayMeses=$this->funciones->consMeses();
        $data['meses']=$this->funciones->crearCombo($arrayMeses,$datoidrevisado,'id','nombremeses');
        /**************/
        
        /**** se consultan los tipos de vehiculos ***/
		$arrayTipovehiculos=$this->funciones->consTipovehiculo();
        $data['tipovehiculo']=$this->funciones->crearCombo($arrayTipovehiculos,$datoidtipovehiculo,'id','nombretipovehiculo');
        /**************/
        
        /*
        $tipoDocumento=new tabla('modelo');
        $condicionTipoDocumentoVictima="WHERE idtipodocumento NOT IN('5')";
        $listaTipoDocumento=$tipoDocumento->consultarDatos('*','','','','',$condicionTipoDocumentoVictima);
        */
    
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
		//se setea la tabla a modificar
        $this->tabla->settabla('vehiculo');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
        
		$campos['idempresa']   		=	$this->idempresa;
        $campos['idmodelo']         =   $arraypost['idmodelo'];
        $campos['numerochasis']     =   $arraypost['numerochasis'];
        $campos['numeromotor']      =   $arraypost['numeromotor'];
        $campos['cilindraje']       =   $arraypost['cilindraje'];
        $campos['fechamatricula']   =   $this->funciones->convertirFormatoFecha($arraypost['fechamatricula']);
        $campos['idrevisado']       =   $arraypost['idrevisado'];
        $campos['numerolicencia']   =   $arraypost['numerolicencia'];
        $campos['numerointerno']    =   $arraypost['numerointerno'];
        
        ($arraypost['asociado']=='on')? $campos['asociado']=1 : $campos['asociado']=0;
        ($arraypost['empresa']=='on')? $campos['empresa']=1 : $campos['empresa']=0;
        ($arraypost['comunicacion']=='on')? $campos['comunicacion']=1 : $campos['comunicacion']=0;
        ($arraypost['conduce']=='on')? $campos['conduce']=1 : $campos['conduce']=0;
		
        $campos['idtipovehiculo']   =   $arraypost['idtipovehiculo'];
        $campos['numeromega']       =   $arraypost['numeromega'];
        $campos['idmarcavehiculo']  =   $arraypost['idmarcavehiculo'];
        ($arraypost['activo']=='on')? $campos['activo']=1 : $campos['activo']=0;
        
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el la placa ya existe
            $condicionOtraPlaca = array('placa' => $arraypost['placa'], 'idempresa'=> $this->idempresa);
            $arrayOtroPlaca=$this->tabla->consultarDatos('*',$condicionOtraPlaca);
			if(!empty($arrayOtroPlaca)){
				$activo=($arrayOtroPlaca[0]['activo']==1)? "Activo" : "Inactivo";
				//la placa ya esta registrada
				$array_datos['mensaje']['msg']="La placa ".$arraypost['placa']." ya esta registrada, y el vehiculo esta ".$activo;
				$array_datos['mensaje']['class']="error";
			}else{
				$campos['idvehiculo']      =   $this->tabla->MaximoDato("idvehiculo") + 1;
				$campos['placa']            =   $arraypost['placa'];
				
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idvehiculo' => $arraypost['idvehiculo']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
}
/* End of file vehiculos.php */
/* Location: ./application/controllers/paraqueautomotor/vehiculos.php */