<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pasadoconductor extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idpasadoconductor']))
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
    * Muestra el formulario de registro de los certificados judiciales de los conductores
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
        $data['vista_contenido_mod']=array("conductores/pasadoconductor_view");
		
        $jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarpasadoconductor')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Certificados Judiciales','#busqueda')";
        
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
		
        $existeinfo = 0;
        
        if(!empty($this->arrayRequest['idpasadoconductor']))
        { 
            $this->tabla->settabla('pasadoconductor');
			$cond=array('idpasadoconductor'=>$this->arrayRequest['idpasadoconductor'], 'idempresa'=> $this->idempresa);
            $datosCons = $this->tabla->consultarDatos("*",$cond,"","","","");
			
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
            
			$data['datoidpasadoconductor']		=   $this->arrayRequest['idpasadoconductor'];
			$arrayConductor						=	$this->funciones->consConductor($datosCons[0]['idconductor']);
			$data['datoidconductor']  			=   $datosCons[0]['idconductor'];
			$data['datonombreconductor']  		=   $arrayConductor->nombrecompleto;
			$data['datonumerocodigoconductor']  =   $datosCons[0]['numerocodigoconductor'];
			$data['datofechaexpedicion']        =   $this->funciones->convertirFormatoFecha($datosCons[0]['fechaexpedicion'],"aaaa-mm-dd","dd/mm/aaaa");
			$data['datofechavencimiento']       =   $this->funciones->convertirFormatoFecha($datosCons[0]['fechavencimiento'],"aaaa-mm-dd","dd/mm/aaaa");

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
        
        $this->load->view('include/plantilla3',$data);
    }
    
    /**
    * Guarda la informacion de los certificados judiciales de los conductores
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('pasadoconductor');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		$array_datos['datos']=$arraypost;
		
        $campos['idconductor']              =   $arraypost['idconductor'];
		$campos['idempresa']				=   $this->idempresa ;
        $campos['numerocodigoconductor']    =   $arraypost['numerocodigoconductor'];
        $campos['fechaexpedicion']          =   $this->funciones->convertirFormatoFecha($arraypost['fechaexpedicion']);
        $campos['fechavencimiento']         =   $this->funciones->convertirFormatoFecha($arraypost['fechavencimiento']);
        $campos['activo']=1;
        
        if($arraypost["Guardar"]=="Guardar")
        {
            //se inactivan los certificados anteriores activo = 0
            $condicionInactiva = array('idconductor' => $arraypost['idconductor'], 'idempresa'=> $this->idempresa);
            $camposInactiva['activo']   =  0;
            $this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
            
            $campos['idpasadoconductor']      =   $this->tabla->MaximoDato("idpasadoconductor") + 1;
            $this->tabla->agregarDatos($campos);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idpasadoconductor' => $arraypost['idpasadoconductor'], 'idempresa'=> $this->idempresa);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
    
}
/* End of file pasadocondcutor.php */
/* Location: ./application/controllers/conductores/pasadocondcutor.php */