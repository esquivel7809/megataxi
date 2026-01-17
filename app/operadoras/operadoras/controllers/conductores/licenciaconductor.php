<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Licenciaconductor extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idlicenciaconductor']))
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
    * Muestra el formulario de registro de las licencias de los conductores
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
        $data['vista_contenido_mod']=array("conductores/licenciaconductor_view");

        $jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarlicenciaconductor')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Licencias de los Conductores','#busqueda')";
        
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
		
		$datoidcategoria=0;
        $existeinfo = 0;
        
        if(!empty($this->arrayRequest['idlicenciaconductor']))
        { 
            $this->tabla->settabla('licenciaconductor');
			$cond=array('idlicenciaconductor'=>$this->arrayRequest['idlicenciaconductor'], 'idempresa'=> $this->idempresa);
            $datosCons = $this->tabla->consultarDatos("*",$cond,"","","","");
			
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
            
			$data['datoidlicenciaconductor']	=   $this->arrayRequest['idlicenciaconductor'];
			$data['datoidconductor']  			=   $datosCons[0]['idconductor'];
			$arrayConductor						=	$this->funciones->consConductor($datosCons[0]['idconductor']);
			$data['datonombreconductor']  		=   $arrayConductor->nombrecompleto;
			$data['datonumerolicenciaconductor']=   $datosCons[0]['numerolicenciaconductor'];
			$datoidcategoria					=   $datosCons[0]['idcategoria'];
			$data['datofechaexpedicion']        =   $this->funciones->convertirFormatoFecha($datosCons[0]['fechaexpedicion'],"aaaa-mm-dd","dd/mm/aaaa");
			$data['datofechavencimiento']       =   $this->funciones->convertirFormatoFecha($datosCons[0]['fechavencimiento'],"aaaa-mm-dd","dd/mm/aaaa");
			$data['datoidorganismo']			=   $datosCons[0]['idorganismo'];
			$arrayOrganismo						=	$this->funciones->consOrganismo($datosCons[0]['idorganismo']);
			$data['datonombreorganismo']		=   $arrayOrganismo->nombreorganismo;
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
		
        // se consultan las categorias
		$arrayCategorias=$this->funciones->consCategoria("","WHERE idcategoria IN('1','2','3','4','5','6','7','8')");
        $data['categorias']=$this->funciones->crearCombo($arrayCategorias, $datoidcategoria, 'idcategoria', 'nombrecategoria');
        
        $this->load->view('include/plantilla3',$data);
    }
    
    /**
    * Guarda la informacion de las licencias de los conductores
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('licenciaconductor');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		$array_datos['datos']=$arraypost;
        
        $campos['idconductor']              =   $arraypost['idconductor'];
		$campos['idempresa']   				=	$this->idempresa;
        $campos['numerolicenciaconductor']  =   $arraypost['numerolicenciaconductor'];
        $campos['fechaexpedicion']          =   $this->funciones->convertirFormatoFecha($arraypost['fechaexpedicion']);
        $campos['fechavencimiento']         =   $this->funciones->convertirFormatoFecha($arraypost['fechavencimiento']);
        $campos['idcategoria']              =   $arraypost['idcategoria'];
        $campos['idorganismo']              =   $arraypost['idorganismo'];
        $campos['activo']=1;
        
        if($arraypost["Guardar"]=="Guardar")
        {
            //se inactivan las licencias anteriores activo = 0
            $condicionInactiva = array('idconductor' => $arraypost['idconductor'], 'idempresa'=> $this->idempresa);
            $camposInactiva['activo']   =  0;
            $this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
            
            $campos['idlicenciaconductor']      =   $this->tabla->MaximoDato("idlicenciaconductor") + 1;
            $this->tabla->agregarDatos($campos);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";

        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idlicenciaconductor' => $arraypost['idlicenciaconductor']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        
        $this->index($array_datos);
    }
    
}
/* End of file licenciaconductor.php */
/* Location: ./application/controllers/conductores/licenciaconductor.php */