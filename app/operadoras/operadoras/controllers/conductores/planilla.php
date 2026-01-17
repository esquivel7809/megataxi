<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Planilla extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idplanilla']))
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
    * Muestra el formulario de registro de los conductores
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
        $data['vista_contenido_mod']=array("conductores/planilla_view");
    
        $jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarplanilla')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Planillas','#busqueda')";
        
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
        
        $datoidtipodocumento = "";
        
        $existeinfo = 0;
        
        if(!empty($this->arrayRequest['idplanilla']))
        { 
            $this->tabla->settabla('planilla');
			$cond=array('idplanilla'=>$this->arrayRequest['idplanilla'], 'idempresa'=> $this->idempresa);
            $datosCons = $this->tabla->consultarDatos("*",$cond,"","","","");
			
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
            
			$data['datoidplanilla']		=   $this->arrayRequest['idplanilla'];
            $data['datoidorigen']   =   $datosCons[0]['idorigen'];
			// se consultan el municipio de origen
			$arrayMunicipio=$this->funciones->consMunicipio($datosCons[0]['idorigen']);
			$data['datolugarorigen']    =   $arrayMunicipio->nombremunicipio." - ".$arrayMunicipio->nombredepartamento;
			$data['datonumeroplanilla']     =   $datosCons[0]['numeroplanilla'];
			$data['datofechainicio']        =   $this->funciones->convertirFormatoFecha($datosCons[0]['fechainicio'],"aaaa-mm-dd","dd/mm/aaaa");
			//$data['datoiddestino']        	=   $datosCons[0]['iddestino']; // se oculta el 02 abril de 2014
			//$data['datociudaddestino']        	=   $datosCons[0]['ciudaddestino']; //se coloca para poder guardar varias ciudades de destino

			if(!empty($datosCons[0]['iddestino']) && $datosCons[0]['iddestino']!=0){
				// se consultan el municipio de destino
				$arrayMunicipio=array();
				$arrayMunicipio=$this->funciones->consMunicipio($datosCons[0]['iddestino']);
				$data['datolugardestino']    =   $arrayMunicipio->nombremunicipio." - ".$arrayMunicipio->nombredepartamento;
			}else{
				$data['datolugardestino']    = 	$datosCons[0]['ciudaddestino'];
			} echo $data['datolugardestino'];
			$data['datofecharegreso']       =   $this->funciones->convertirFormatoFecha($datosCons[0]['fecharegreso'],"aaaa-mm-dd","dd/mm/aaaa");
			$data['datoidcontratante']      =   $datosCons[0]['idcontratante'];
			$arrayContratante=$this->funciones->consContratante($datosCons[0]['idcontratante']);
			$datoidtipodocumento = $arrayContratante[0]["idtipodocumento"];
			$data['datonumerodocumento']=	$arrayContratante[0]["numerodocumento"];
			$data['datonombrecompleto']	=	$arrayContratante[0]["nombrecompleto"];
			$data['datodireccion']		=	$arrayContratante[0]["direccion"];
			$data['datotelefonofijo']	=	$arrayContratante[0]["telefonofijo"];
			$data['datocantidadpasajeros']  =   $datosCons[0]['cantidadpasajeros'];
			$data['datoidvehiculoconductor']=   $datosCons[0]['idvehiculoconductor'];
			$arrayVehiculoconductor=$this->funciones->consVehiculoconductor($datosCons[0]['idvehiculoconductor']);
			$data['datovehiculoconductor']=	$arrayVehiculoconductor->placa." - ".$arrayVehiculoconductor->nombrecompleto;
        }
		else
		{
			if(!empty($array_datos['datos']))
			{
				foreach($array_datos['datos'] as $key => $valor )
				{
					$array["dato".$key]=$valor;
					${"dato".$key}=$valor;
				}
				$data = array_merge($data, $array);
			}
		}
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        //se consultan los tipos de documentos 
        $consultaTipodocumentos = $this->db->query('SELECT idtipodocumento,nombretipodocumento,abreviatura FROM tipodocumento WHERE idtipodocumento IN(2,3,5,8) ORDER BY nombretipodocumento DESC');
        foreach ($consultaTipodocumentos->result_array() as $filaTipodocumento)
        {
            $arrayTipodocumentos[]=$filaTipodocumento;
        }
        $consultaTipodocumentos->free_result();
        $data['tipodocumento']=$this->funciones->crearCombo($arrayTipodocumentos,$datoidtipodocumento,'idtipodocumento','abreviatura');
        $this->load->view('include/plantilla3',$data);
    }
    
    /**
    * Guarda la informacion de los conductores
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('planilla');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
        
        $campos['idempresa']=   $this->idempresa ;
		$campos['numeroplanilla']=   $arraypost['numeroplanilla'];
        $campos['idorigen']     =   $arraypost['idorigen'];
		$campos['fechainicio']  =   $this->funciones->convertirFormatoFecha($arraypost['fechainicio']);
        //$campos['iddestino']     =   $arraypost['iddestino'];
		$campos['ciudaddestino'] =   $arraypost['lugardestino']; //se coloca para poder guardar varias ciudades de destino
		$campos['fecharegreso']  =   $this->funciones->convertirFormatoFecha($arraypost['fecharegreso']);
		//si esta vacio se procede a guardar los datos del contratante
		if(empty($arraypost['idcontratante']))
		{
			//se setea la tabla a modificar
			$this->tabla->settabla('contratante');
			//se valida si existe el contratante
            $condOtroContra= array('numerodocumento' => $arraypost['numerodocumento'], 'idempresa'=> $this->idempresa);
            $arrayOtroContra=$this->tabla->consultarDatos('*',$condOtroContra);
			if(empty($arrayOtroContra))
			{
				$camposContra['idcontratante']  =   $this->tabla->MaximoDato("idcontratante") + 1;
				$camposContra['idempresa']=   $this->idempresa ;
				$camposContra['idtipodocumento']=   $arraypost['idtipodocumento'];
				$camposContra['numerodocumento']=   $arraypost['numerodocumento'];
				$camposContra['nombrecompleto']	=   $arraypost['nombrecompleto'];
				$camposContra['direccion']		=   $arraypost['direccion'];
				$camposContra['telefonofijo']	=   $arraypost['telefonofijo'];
				//se guardan los datos del contratante
				$this->tabla->agregarDatos($camposContra);
				
				$arraypost['idcontratante']=$camposContra['idcontratante'];
			}
			else
			{
				$arraypost['idcontratante']="";
			}
		}
        $campos['idcontratante']    	=   $arraypost['idcontratante'];
        $campos['cantidadpasajeros']   	=   $arraypost['cantidadpasajeros'];
        $campos['idvehiculoconductor']  =   $arraypost['idvehiculoconductor'];
		
		//se setea la tabla a modificar
        $this->tabla->settabla('planilla');
		
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el numero de documento existe
            $condOtraPlanilla = array('numeroplanilla' => $arraypost['numeroplanilla'], 'idempresa'=> $this->idempresa);
            $arrayOtraPla=$this->tabla->consultarDatos('*',$condOtraPlanilla);
			if(!empty($arrayOtraPla)){
				//la placa ya esta registrada
				$array_datos['mensaje']['msg']="La planilla número ".$arraypost['numeroplanilla']." ya esta registrada";
				$array_datos['mensaje']['class']="error";
				$array_datos['datos']=$arraypost;
			}else{
				$campos['idplanilla']  =   $this->tabla->MaximoDato("idplanilla") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idplanilla' => $arraypost['idplanilla']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
}
/* End of file conductores.php */
/* Location: ./application/controllers/conductores/planilla.php */