<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comunicacionesdatos extends CI_Controller {
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
		$this->load->model('Vehiculo_model');
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
	public function index($array_datos)
	{
		//se pasa el mensaje al array final que sera pasado a la vista
		$data['mensaje_confirmacion']=$this->load->view('include/mensaje_confirmacion',$array_datos['mensaje']);
		
		//se configura la vista a mostrar
        $data['vista_contenido_mod']=array("comunicaciones/comunicacionesdatos_view");
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
		
		$idvehiculo=$this->arrayRequest['idvehiculo'];
		//se valida si viene el idvehiculo
		if(!empty($idvehiculo)){
			$data['datoidvehiculo'] = $idvehiculo;
			//se consultan todos los datos del vehiculo, ya se sabe que esta afiliado a comunicacion y esta activo
			$datosVehiculoArray = $this->Vehiculo_model->cons_datos_vehi($idvehiculo);
			
			$data['datoplaca']   				=   $datosVehiculoArray[0]['placa'];
			$data['datonombremarcavehiculo']    =   $datosVehiculoArray[0]['nombremarcavehiculo'];
			$data['datonombremodelo']    		=	$datosVehiculoArray[0]['nombremodelo'];
			
			//se consulta el consecutivo del carnet
			$this->tabla->settabla('carnetcomunicacion');
			$data['datonumerocarnet'] =   $this->tabla->MaximoDato("numerocarnet") + 1;
			//se configura la fecha actual para el carnet
			$data['datofechacarnet'] = date("d/m/Y");
			
			//se consultan los datos de los propietarios
			$datosVehiculoPropietarioArray = $this->Vehiculo_model->cons_datos_vehi_prop($idvehiculo);
			//print_r($datosVehiculoPropietarioArray); exit();
			if(!empty($datosVehiculoPropietarioArray)){
				$arrayVehiProp="";
				$x=0;
				//tiene propietario
				foreach ($datosVehiculoPropietarioArray as $row)
				{
					$arrayVehiProp[$x]['idvehiculopropietario'] = $row['idvehiculopropietario'];
					$arrayVehiProp[$x]['idconductor'] = $row['idconductor'];
					$arrayVehiProp[$x]['numerodocumento'] = $row['numerodocumento'];
					$arrayVehiProp[$x]['nombrecompleto'] = $row['nombrecompleto'];
					$x++;
				}
				$data['arrayVehiProp']= $arrayVehiProp;
			}else{
				//no tiene propietario
				$data['arrayVehiProp']= "";
			}
			
		}else{
			
		}
		
		/*
		// revisar para que es?
		if(!empty($array_datos['datos']))
		{
			foreach($array_datos['datos'] as $key => $valor )
			{
				$array["dato".$key]=$valor;
				${"dato".$key}=$valor;
			}
			$data = array_merge($data, $array);
		}
		*/
		
		//se guarda el html de los botones
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
		//se envian los datos y se muestra la vista
        $this->load->view('include/plantilla3',$data);
    }
        
        
    public function registro()
    {
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//print_r($arraypost); exit();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		//se inicializa la variable para el mensaje de error
		$mensajeError = "";
		$mensajeExito = "";
		$rollback=false;

        if($arraypost["Guardar"]=="Guardar")
        {
			//iniciamos la transanccion
			//$this->tabla->trans_start();
			$this->db->trans_begin();
			
			//################### se almacena el raditelefono #########################################
			//se setea la tabla a modificar
			$this->tabla->settabla('radiotelefono');
	
			$campos['idempresa']			=   $this->idempresa ;
			$campos['idmodeloradio']		=   $arraypost['idmodeloradio'];
			$campos['serieradiotelefono']   =   $arraypost['serieradiotelefono'];
			$campos['activo']       		=   1;
			
			//se consulta si el serial del raditotelefono ya esta en uso
            $condOtroSerial = array('serieradiotelefono' => $arraypost['serieradiotelefono'], 'idempresa'=> $this->idempresa, 'activo'=> '1');
            $arrayOtroSerial=$this->tabla->consultarDatos('*',$condOtroSerial);
			if(!empty($arrayOtroSerial)){
				//el serieradiotelefono ya esta asociado a otro vehiculo
				//$mensajeError .= "El numero de Serie ".$arraypost['serieradiotelefono']." ya esta en uso";
				//$rollback = true;
				
				//se actualiza el campo activo a cero de la tabla radiotelefono
				$camposSerial['activo']=0;
				$this->tabla->actualizarDatos($camposSerial,$condOtroSerial);
				
				//se inserta el registro 
				$idradiotelefono = 	   $this->tabla->MaximoDato("idradiotelefono") + 1;
				$campos['idradiotelefono']      = $idradiotelefono;
				$this->tabla->agregarDatos($campos);
				$mensajeExito.=$this->tabla->mensaje;
				
			}else{
				$idradiotelefono = 	   $this->tabla->MaximoDato("idradiotelefono") + 1;
				$campos['idradiotelefono']      = $idradiotelefono;
				$this->tabla->agregarDatos($campos);
				$mensajeExito.=$this->tabla->mensaje;
			}
			//##########################################################################################
			unset($campos); //[] = array();
			//########################## se asocia el vehiculo con el raditelefono #####################
			//se setea la tabla a modificar
			$this->tabla->settabla('vehiculoradiotelefono');
        
			//se consulta si el radiotelefono ya esta asociado a otro vehiculo
            $condicionOtroRadio = array('idradiotelefono' => $idradiotelefono, 'activo'=>'1', 'idempresa'=> $this->idempresa);
            $arrayOtroRadio=$this->tabla->consultarDatos('*',$condicionOtroRadio	);
			if(!empty($arrayOtroRadio)){
				//el radiotelefono ya esta asociado a otro vehiculo
				//$mensajeError .="El radiotelefono ya esta en uso";
				//$rollback = true;
				
				//se actualiza el campo activo a cero de la tabla radiotelefono
				$camposVehiculoradiotelefono['activo']=0;
				$this->tabla->actualizarDatos($camposVehiculoradiotelefono,$condicionOtroRadio);
				
				// se realiza el registro
				$idvehiculoradiotelefono =  $this->tabla->MaximoDato("idvehiculoradiotelefono") + 1;
				$campos['idvehiculoradiotelefono']      =   $idvehiculoradiotelefono;
				$campos['idvehiculo']   	=   $arraypost['idvehiculo'];
				$campos['idradiotelefono']	= $idradiotelefono;
				$campos['idempresa']		=   $this->idempresa ;
				$campos['activo']       	=   1;
				$this->tabla->agregarDatos($campos);
				$mensajeExito.=$this->tabla->mensaje;
				
			}else{
				$idvehiculoradiotelefono =  $this->tabla->MaximoDato("idvehiculoradiotelefono") + 1;
				$campos['idvehiculoradiotelefono']      =   $idvehiculoradiotelefono;
				$campos['idvehiculo']   	=   $arraypost['idvehiculo'];
				$campos['idradiotelefono']	= $idradiotelefono;
				$campos['idempresa']		=   $this->idempresa ;
				$campos['activo']       	=   1;
				$this->tabla->agregarDatos($campos);
				$mensajeExito.=$this->tabla->mensaje;
			}
			//##########################################################################################
			unset($campos);//$campos[] = array();
			//########################## se asocia el vehiculo con el mega #####################
			$this->tabla->settabla('vehiculomega');
			//se consulta si el mega ya esta asociado a otro vehiculo
            $condicionMegaAsociado = array('idvehiculoradiotelefono' => $idvehiculoradiotelefono, 'activo'=>'1', 'idempresa'=> $this->idempresa);
            $arrayMegaAsociado=$this->tabla->consultarDatos('*',$condicionMegaAsociado);
			if(!empty($arrayMegaAsociado)){
				//el vehiculo ya tiene asociado un mega
				//$mensajeError.="El vehiculo ya tiene un numero de Mega o EME asociado";
				//$rollback = true;
				
				//se actualiza el campo activo a cero de la tabla vehiculomega
				$camposVehiculomega['activo']=0;
				$this->tabla->actualizarDatos($camposVehiculomega,$condicionMegaAsociado);
				
				// se realiza el registro
				$idvehiculomega = $this->tabla->MaximoDato("idvehiculomega") + 1;
				$campos['idvehiculomega']      		= $idvehiculomega;
				$campos['idempresa']				=   $this->idempresa ;
				$campos['idvehiculoradiotelefono']  =   $idvehiculoradiotelefono;
				$campos['idmega']   				=   $arraypost['idmega'];
				$campos['activo']       			=   1; //por defecto se activa el mega
				$this->tabla->agregarDatos($campos);
				$mensajeExito.=$this->tabla->mensaje;

				
			}else{
				//se consulta si el mega ya esta asociado a otro vehiculo
/*
				$condicionOtroMega = array('idmega' => $arraypost['idmega'], 'activo'=>'1', 'idempresa'=> $this->idempresa);
				$arrayOtroMega=$this->tabla->consultarDatos('*',$condicionOtroMega);
				if(!empty($arrayOtroMega)){
					//el mega ya esta asociado a otro vehiculo
					$mensajeError.="El numero de Mega o EME ya esta en uso";
					$rollback = true;
				}else{
*/					
					$idvehiculomega = $this->tabla->MaximoDato("idvehiculomega") + 1;
					$campos['idvehiculomega']      		= $idvehiculomega;
					$campos['idempresa']				=   $this->idempresa ;
					$campos['idvehiculoradiotelefono']  =   $idvehiculoradiotelefono;
					$campos['idmega']   				=   $arraypost['idmega'];
					$campos['activo']       			=   1; //por defecto se activa el mega
					$this->tabla->agregarDatos($campos);
					$mensajeExito.=$this->tabla->mensaje;
//				}
			}

			//##########################################################################################			
			if($rollback){
				$array_datos['mensaje']['msg']= $mensajeError;
				$array_datos['mensaje']['class']="error";
				$array_datos['datos']=$arraypost;
				$this->db->trans_rollback();
			}else{

				unset($campos);//$campos[] = array();
				//########################## se almacena el carnet #####################
				//se setea la tabla a modificar
				$this->tabla->settabla('carnetcomunicacion');
		
				$campos['idvehiculoradiotelefono']  = $idvehiculoradiotelefono;
				$campos['idvehiculomega']  			= $idvehiculomega;
				$campos['idvehiculopropietario']  	=   $arraypost['idvehiculopropietario'];
				$campos['fechacarnet']    =   $this->funciones->convertirFormatoFecha($arraypost['fechacarnet']);
						 
				$campos['idcarnetcomunicacion'] =   $this->tabla->MaximoDato("idcarnetcomunicacion") + 1;
				$campos['numerocarnet']      	=   $this->tabla->MaximoDato("numerocarnet") + 1;
				$this->tabla->agregarDatos($campos);
				$mensajeExito=$this->tabla->mensaje;
				
				//terminamos la transaccion
				$array_datos['mensaje']['msg']= $mensajeExito;
				$array_datos['mensaje']['class']="exito";
				$this->db->trans_commit();
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