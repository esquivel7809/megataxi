<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Refrendacion extends CI_Controller {
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
		//cargamos el modelo de la refrendacion
        $this->load->model('Refrendacion_model');
		$this->load->library('funciones');
		$this->load->library('tabla');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idrefrendacion']) && !isset($this->arrayRequest['idconductor']))
            {
                //terminar_session();
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
    * Muestra el formulario de registro de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("conductores/refrendacion_view");
		$jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarconductorrefrendacion')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Conductores','#busqueda')";
        
        /***  Se consultan los permisos para la botoneria    ***/
        
        $sqlPermisos="SELECT modificar,consultar,eliminar
        			  FROM   perfilsubmodulo 
        			  WHERE	 idperfilusuario='".$_SESSION['idperfilactual']."' AND 
        			  		 idsubmodulo='".$_SESSION['idsubmoduloactual']."'";
        $consultaPersmisos = $this->db->query($sqlPermisos);
        
        $rowPermisos=$consultaPersmisos->row();
        $consultaPersmisos->free_result();
        //$param = array('modificar' => $rowPermisos->modificar,'consultar' => $rowPermisos->consultar ,'eliminar' => $rowPermisos->eliminar);
		$param = array('modificar' => 0,'consultar' => $rowPermisos->consultar ,'eliminar' => 0);
        $this->load->library('botoneria',$param);
		
		//inicializamos variables
        $datofecharefrendacion = date('d/m/Y');
        $datohorarefrendacion = date('H:i:s');
		$datoidtipodocumento = "";
		$idconductor=$this->arrayRequest['idconductor'];
		if(!empty($idconductor))
		{
			//se consultan los datos del conductor
			$datosConductor = $this->Refrendacion_model->cons_dat_cond_refre($idconductor);
			
            $existeinfo = 1;
            $data['datoidconductor']        =   $datosConductor[0]['idconductor'];
            $datoidtipodocumento            =   $datosConductor[0]['idtipodocumento'];
            $data['datonumerodocumento']    =   $datosConductor[0]['numerodocumento'];
			$data['datodireccion']          =   html_entity_decode($datosConductor[0]['direccion']);
			$data['datonombrecompleto']     =   html_entity_decode($datosConductor[0]['nombrecompleto']);
			$data['datonumerolicenciaconductor']    =   $datosConductor[0]['numerolicenciaconductor'];
			$data['datofechavencimientolic']   =   $datosConductor[0]['fechavencimiento'];
			$data['datoemail']    			=   $datosConductor[0]['email'];
			$data['datotelefonofijo']    	=   $datosConductor[0]['telefonofijo'];
			$data['datocelular']    		=   $datosConductor[0]['celular'];
			$data['datorutafoto']    		=   $datosConductor[0]['rutafoto'];
			
			// se consultan los tipos de documentos 
			$consultaTipodocumentos = $this->db->query('SELECT abreviatura FROM tipodocumento WHERE idtipodocumento="'.$datoidtipodocumento.'" ');
			foreach ($consultaTipodocumentos->result_array() as $filaTipodocumento)
			{
				$arrayTipodocumentos[]=$filaTipodocumento;
			}
			$consultaTipodocumentos->free_result();
			$data['tipodocumento']=$arrayTipodocumentos[0]['abreviatura'];
			///
			
			//consultamos los vehiculos asociados al conductor
			$datosVehConductor = $this->Refrendacion_model->cons_vehi_asoc_cond($idconductor);
			foreach ($datosVehConductor as $filaDatosVehConductor)
			{
				$array_es_refre=$this->Refrendacion_model->es_refre($filaDatosVehConductor['idvehiculoconductor']);
				if(!empty($array_es_refre)){
					$filaDatosVehConductor['refrendado']=true;
					$filaDatosVehConductor['idrefrendacion']=$array_es_refre[0]['idrefrendacion'];
					$filaDatosVehConductor['fecharefrendacion']=$array_es_refre[0]['fecharefrendacion'];
				}
				else{
					$filaDatosVehConductor['refrendado']=false;
					$filaDatosVehConductor['idrefrendacion']="";
				}
				$datosVehConductor_[]=$filaDatosVehConductor;
			}
			$data['datosVehConductor'] = $datosVehConductor_;
		}
		/*
        if(!empty($this->arrayRequest['idvehiculo']) || !empty($this->arrayRequest['placa']))
        {
            $this->tabla->settabla('vehiculo');
            if(!empty($this->arrayRequest['idvehiculo']))
            {
                $condVehiculo=array('idvehiculo'=>$this->arrayRequest['idvehiculo']);
            }
            else
            {
                $condVehiculo=array('placa'=>$this->arrayRequest['placa']);
            }
            $datosVehiculo = $this->tabla->consultarDatos("*",$condVehiculo,"","","","");
            $existeinfo = 1;
            $data['datoidvehiculoconductor']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoidrefrendacion']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoidconductor']     = $datosVehiculo[0]['idvehiculo'];
			$data['datonombreconductor']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoidvehiculo']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoplaca']     = $datosVehiculo[0]['datoplaca'];
			$datofecharefrendacion     = $this->funciones->convertirFormatoFecha($datosVehiculo[0]['fecharefrendacion'],"aaaa-mm-dd","dd/mm/aaaa");
			$datohorarefrendacion     = $datosVehiculo[0]['datohorarefrendacion'];
			
		}
        */
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        $data['datofecharefrendacion'] = $datofecharefrendacion;
        $data['datohorarefrendacion'] = $datohorarefrendacion;
        $data['datofechavencimiento'] = "05/".(date('m')+1)."/".date('Y');
        
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		$resp=0;
        $this->tabla->settabla('refrendacion');
        $arraypost=$this->input->post();
		$arraypuesto=explode("_",$arraypost["id_puesto"]);
		$arraypost['idvehiculoconductor']=$arraypuesto[0];
		$arraypost['puesto']=$arraypuesto[1];
        
        //$campos['consvehiculoconductor']=   $arraypost['consvehiculoconductor'];
        $campos['idvehiculoconductor']  =   $arraypost['idvehiculoconductor'];
		$campos['idempresa']=   $this->idempresa ;
        $campos['fecharefrendacion']    =   date('Y-m-d');
        $campos['horarefrendacion']     =   date('H:i:s');
        $campos['fechavencimiento']    =   $this->funciones->convertirFormatoFecha($arraypost['fechavencimiento']);
		$campos['puesto']     =   $arraypost['puesto'];
                 
        if($arraypost["Guardar"]=="Guardar")
        {
			$campos['idrefrendacion']  =   $this->tabla->MaximoDato("idrefrendacion") + 1;
            
            $sqlMaxconsvehiculoconductor="SELECT MAX(consvehiculoconductor) as consvehiculoconductor FROM refrendacion WHERE idvehiculoconductor= '".$arraypost['idvehiculoconductor']."' AND idempresa='".$this->idempresa."'";
            $ultimoConsvehiculoconductor=$this->db->query($sqlMaxconsvehiculoconductor);
            $rowConsvehiculoconductor = $ultimoConsvehiculoconductor->row();
            
            $campos['consvehiculoconductor']      =   $rowConsvehiculoconductor->consvehiculoconductor + 1;
            
            if($campos['consvehiculoconductor']>12)
            {
                $this->tabla->mensaje="No se pudo Guardar el Registro, Consecutivo de la Tarjeta Nº ".$arraypost['numerotarjeta']." Mayor a 12";
				$resp="";
            }
            else
            {
                $this->tabla->agregarDatos($campos);
				$resp=$campos['idrefrendacion'];
            }
        }
		//$resp_[]=$resp;
		echo $resp;
		//return($resp_);
        //$this->index();
		/*
		?>
		<script type="text/javascript">
			alert("<?=$this->tabla->mensaje?>");
		</script>
		<?php
		*/
    }
	
    /**
    * Guarda la informacion de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
    public function verTarjeton($idvehiculoconductor)
    {
		$data['vista_contenido_mod']=array("conductores/tarjeton_view");
		$data['idvehiculoconductor']=$idvehiculoconductor;
		
		//consultamos los vehiculos asociados al conductor
		$datosVehConductor = $this->Refrendacion_model->cons_dat_vehi_cond_all($idvehiculoconductor);
		foreach ($datosVehConductor as $filaDatosVehConductor)
		{
			$refrendar= true;
			//validamos el SOAT
			if(empty($filaDatosVehConductor['numerosoat']))
			{
				//no tiene SOAT registrado
				$mensaje.="no tiene registrado SOAT ";
				$refrendar= false;
			}
			else
			{
				if(strtotime($filaDatosVehConductor['soat_fechafinal']) <= strtotime(date('Y-m-d')))
				{
					//el SOAT esta vencido
					$mensaje.="el SOAT esta vencido ";
					$refrendar= false;
				}
			}
			//validamos el contractual
			if(empty($filaDatosVehConductor['numerocontractual'])) 
			{
				//no tiene contractual registrado
				$mensaje.="no tiene registrado seguro contractual ";
				$refrendar= false;
			}
			else
			{
				if($filaDatosVehConductor['cont_fechafinal'] <= date('Y-m-d'))
				{
					//el contractual esta vencido
					$mensaje.="el seguro contractual esta vencido ";
					$refrendar= false;
				}
			}
			//validamos el extracontractual
			if(empty($filaDatosVehConductor['numeroextracontractual']))  
			{
				//no tiene extracontractual registrado
				$mensaje.="no tiene registrado seguro extracontractual ";
				$refrendar= false;
			}
			else
			{
				if($filaDatosVehConductor['extra_fechafinal'] <= date('Y-m-d'))
				{
					//el extracontractual esta vencido
					$mensaje.="el seguro extracontractual esta vencido ";
					$refrendar= false;
				}
			}
			//validamos el revision
			if(empty($filaDatosVehConductor['numerorevision']))   
			{
				//no tiene revision registrado
				$mensaje.="no tiene registrado revision tecnicomecanica ";
				$refrendar= false;
			}
			else
			{
				if($filaDatosVehConductor['revi_fechafinal'] <= date('Y-m-d'))
				{
					//el revision esta vencido
					$mensaje.="la revision tecnico-mecanica esta vencida ";
					$refrendar= false;
				}
			}
			$data['datosNombre']=$filaDatosVehConductor['nombrecompleto'];
			$data['datosPlaca']=$filaDatosVehConductor['placa'];
		}
		//if($refrendar)
		//{
			//consultamos los vehiculos asociados al conductor
			$datosRefrendacion = $this->Refrendacion_model->cons_dat_refre($idvehiculoconductor);
		//}
		$data['datosRefrendacion']=$datosRefrendacion;
		
		// se consultan los meses
		$consultaMeses = $this->db->query('SELECT idmeses, nombremeses FROM meses ORDER BY idmeses ASC ');
		foreach ($consultaMeses->result_array() as $mes)
		{
			$datosMeses[$mes['idmeses']]=$mes['nombremeses'];
		}
		$consultaMeses->free_result();
		
		//consultamos la tabla meses
		$data['datosMeses']=$datosMeses;
		
		//aqui voy 
		
		
		$this->load->view('include/plantilla3',$data);		
	}
}
/* End of file refrendacion.php */
/* Location: ./application/controllers/conductores/refrendacion.php */