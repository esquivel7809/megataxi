<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Conductores extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idconductor']))
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
        $data['vista_contenido_mod']=array("conductores/conductores_view");
    
        $jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarconductor')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Conductores','#busqueda')";
        
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
        $datoidgenero = "";
        $datoidgruposanguineo = "";
        
        $existeinfo = 0;
        $condConductor="";
        
        $data['datorutafoto'] = "<div class='upload_button'></div>";
    
        if(!empty($this->arrayRequest['idconductor']) || !empty($this->arrayRequest['numerodocumento']))
        {
            $this->tabla->settabla('conductor');
            if(!empty($this->arrayRequest['idconductor']))
            {
                $condConductor=array('idconductor'=>$this->arrayRequest['idconductor']);
            }
            else
            {
                $condConductor=array('numerodocumento'=>$this->arrayRequest['numerodocumento']);
            }
            $datosConductor = $this->tabla->consultarDatos("*",$condConductor,"","","","");
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
            
            $data['datoidconductor']        =   $datosConductor[0]['idconductor'];
            $datoidtipodocumento            =   $datosConductor[0]['idtipodocumento'];
            $data['datonumerodocumento']    =   $datosConductor[0]['numerodocumento'];
            $data['datoidlugarexpedicion']  =   $datosConductor[0]['idlugarexpedicion'];
            
            if($datosConductor[0]['idlugarexpedicion'] != 0)
            {
                /** se consulta el nombre de departamento y municipio para el lugar de expedicion del documento**/
                $sqllugarexpedicion="SELECT m.nombremunicipio,d.nombredepartamento
                	  FROM	 municipio as m
                      INNER JOIN departamento as d ON m.iddepartamento=d.iddepartamento
                	  WHERE  m.idmunicipio ='".$datosConductor[0]['idlugarexpedicion']."%'
                	  LIMIT 0 , 5";
                $consultalugarexpedicion        =   $this->db->query($sqllugarexpedicion);
                $datolugarexpedicion            =   $consultalugarexpedicion->row();
                $data['datolugarexpedicion']    =   $datolugarexpedicion->nombremunicipio." - ".$datolugarexpedicion->nombredepartamento;
            }
            
            $data['datoprimernombre']       =   html_entity_decode($datosConductor[0]['primernombre']);
            $data['datosegundonombre']      =   html_entity_decode($datosConductor[0]['segundonombre']);
            $data['datoprimerapellido']     =   html_entity_decode($datosConductor[0]['primerapellido']);
            $data['datosegundoapellido']    =   $datosConductor[0]['segundoapellido'];
    
            /****se inicializa la foto**********/
            
//            echo base_url()."img/transporte/conductores/".$datosConductor[0]['rutafoto'];
//            if(!empty($datosConductor[0]['rutafoto']) && file_exists(base_url()."img/transporte/conductores/".$datosConductor[0]['rutafoto']))
            if(!empty($datosConductor[0]['rutafoto']))
            {
                //if(is_writable(base_url()."img/conductores/".$datosConductor[0]['rutafoto']))
                //{ echo base_url()."img/conductores/".$datosConductor[0]['rutafoto'];
                    $data['datorutafoto'] = "<div id='upload_button'><img height='170px' width='135px' src='".base_url()."img/transporte/conductores/".$datosConductor[0]['rutafoto']."' /></div>"; 
                //}
            }
            else
            {
                $data['datorutafoto'] = "<div class='upload_imagen' id='upload_button'></div>";
            }
            /**************/
            
            $data['datodireccion']          =   html_entity_decode($datosConductor[0]['direccion']);
            $data['datotelefonofijo']       =   $datosConductor[0]['telefonofijo'];
            $data['datocelular']            =   $datosConductor[0]['celular'];
            $data['datoemail']              =   html_entity_decode($datosConductor[0]['email']);
            $data['datofechanacimiento']    =   $this->funciones->convertirFormatoFecha($datosConductor[0]['fechanacimiento'],"aaaa-mm-dd","dd/mm/aaaa");
			$data['datoedad']    =	$this->calcular_edad($this->funciones->convertirFormatoFecha($datosConductor[0]['fechanacimiento'],"aaaa-mm-dd","dd-mm-aaaa")); // Resultado: 21
            
            $data['datoidlugarnacimiento']  =   $datosConductor[0]['idlugarnacimiento'];
            if($datosConductor[0]['idlugarnacimiento'] != 0)
            {
                /** se consulta el nombre de departamento y municipio para el lugar de nacimiento **/
                $sqllugarnacimiento="SELECT m.nombremunicipio,d.nombredepartamento
                	  FROM	 municipio as m
                      INNER JOIN departamento as d ON m.iddepartamento=d.iddepartamento
                	  WHERE  m.idmunicipio ='".$datosConductor[0]['idlugarnacimiento']."%'
                	  LIMIT 0 , 5";
                $consultalugarnacimiento = $this->db->query($sqllugarnacimiento);
                $datolugarnacimiento = $consultalugarnacimiento->row();
                $data['datolugarnacimiento']    = $datolugarnacimiento->nombremunicipio." - ".$datolugarnacimiento->nombredepartamento;
            }
                                
            $datoidgenero = $datosConductor[0]['idgenero'];
            $datoidgruposanguineo = $datosConductor[0]['idgruposanguineo'];
            
            if($datosConductor[0]['conductor']==1)$data['datoconductor'] = 'checked="checked"';
            if($datosConductor[0]['propietario']==1)$data['datopropietario'] = 'checked="checked"';
            $data['datonumerohv']   =   $datosConductor[0]['numerohv'];
            if($datosConductor[0]['activo']==1)$data['datoactivo'] = 'checked="checked"';
    
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
        
        /************/
        
        /**** se consultan los tipos de documentos ***/
        $consultaTipodocumentos = $this->db->query('SELECT idtipodocumento,nombretipodocumento,abreviatura FROM tipodocumento WHERE idtipodocumento IN(2,3,5,8) ORDER BY nombretipodocumento DESC');
        foreach ($consultaTipodocumentos->result_array() as $filaTipodocumento)
        {
            $arrayTipodocumentos[]=$filaTipodocumento;
        }
        $consultaTipodocumentos->free_result();
        $data['tipodocumento']=$this->funciones->crearCombo($arrayTipodocumentos,$datoidtipodocumento,'idtipodocumento','abreviatura');
        /**************/
        
        /**** se consultan los generos ***/
        $consultaGeneros = $this->db->query('SELECT idgenero,nombregenero, abreviaturagenero FROM genero ORDER BY nombregenero ASC');
        foreach ($consultaGeneros->result_array() as $filaGenero)
        {
            $arrayGeneros[]=$filaGenero;
        }
        $consultaGeneros->free_result();
        $data['genero']=$this->funciones->crearCombo($arrayGeneros,$datoidgenero,'idgenero','nombregenero');
        /**************/
        
        /**** se consultan los grupos sanguineos ***/
        $consultaGruposanguineos = $this->db->query('SELECT idgruposanguineo, nombregruposanguineo FROM gruposanguineo');
        foreach ($consultaGruposanguineos->result_array() as $filaGruposanguineo)
        {
            $arrayGruposanguineos[]=$filaGruposanguineo;
        }
        $consultaGruposanguineos->free_result();
        $data['gruposanguineo']=$this->funciones->crearCombo($arrayGruposanguineos,$datoidgruposanguineo,'idgruposanguineo','nombregruposanguineo');
        /**************/
            
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
        $this->tabla->settabla('conductor');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
		
        
		$campos['idempresa']		=   $this->idempresa ;
        $campos['idlugarexpedicion']=   $arraypost['idlugarexpedicion'];
        $campos['primernombre']     =   $arraypost['primernombre'];
        $campos['segundonombre']    =   $arraypost['segundonombre'];
        $campos['primerapellido']   =   $arraypost['primerapellido'];
        $campos['segundoapellido']  =   $arraypost['segundoapellido'];
        $nomcom="";
        if(!empty($arraypost['primernombre'])) $nomcom.=$arraypost['primernombre'];
        if(!empty($arraypost['segundonombre'])) $nomcom.=" ".$arraypost['segundonombre'];
        if(!empty($arraypost['primerapellido'])) $nomcom.=" ".$arraypost['primerapellido'];
        if(!empty($arraypost['segundoapellido'])) $nomcom.=" ".$arraypost['segundoapellido'];
        
        $campos['nombrecompleto']  =   $nomcom;
        $campos['direccion']        =   $arraypost['direccion'];
        $campos['telefonofijo']     =   $arraypost['telefonofijo'];
        $campos['celular']          =   $arraypost['celular'];
        $campos['email']            =   $arraypost['email'];
        $campos['idgruposanguineo'] =   $arraypost['idgruposanguineo'];

        $campos['fechanacimiento']  =   $this->funciones->convertirFormatoFecha($arraypost['fechanacimiento']);
        $campos['idlugarnacimiento']=   $arraypost['idlugarnacimiento'];
        $campos['idgenero']         =   $arraypost['idgenero'];
        $campos['numerohv']         =   $arraypost['numerohv'];
        
        if($arraypost['conductor']=='on')
        {
        	$campos['conductor']=1;
        }
        else
        {
        	$campos['conductor']=0;
        }
        if($arraypost['propietario']=='on')
        {
        	$campos['propietario']=1;
        }
        else
        {
        	$campos['propietario']=0;
        }
        if($arraypost['activo']=='on')
        {
        	$campos['activo']=1;
        }
        else
        {
        	$campos['activo']=0;
        }
                 
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si el numero de documento existe
            $condicionOtroDoc = array('numerodocumento' => $arraypost['numerodocumento'], 'idempresa'=> $this->idempresa);
            $arrayOtroDoc=$this->tabla->consultarDatos('*',$condicionOtroDoc);
			if(!empty($arrayOtroDoc)){
				$activo=($arrayOtroDoc[0]['activo']==1)? "Activo" : "Inactivo";
				//la placa ya esta registrada
				$array_datos['mensaje']['msg']="El documento ".$arraypost['numerodocumento']." ya esta registrado, y esta ".$activo;
				$array_datos['mensaje']['class']="error";
				$array_datos['datos']=$arraypost;
			}else{
				$campos['idconductor']      =   $this->tabla->MaximoDato("idconductor") + 1;
				$campos['idtipodocumento']  =   $arraypost['idtipodocumento'];
				$campos['numerodocumento']  =   $arraypost['numerodocumento'];
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idconductor' => $arraypost['idconductor']);
            $this->tabla->actualizarDatos($campos,$condicion);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
	/*
	* calcula la edad segun la fecha de nacimiento
	*
	*
	*/
	function calcular_edad($fecha){
		$dias = explode("-", $fecha, 3);
		$dias = mktime(0,0,0,$dias[1],$dias[0],$dias[2]);
		$edad = (int)((time()-$dias)/31556926 );
		return $edad;
	}
    
}
/* End of file conductores.php */
/* Location: ./application/controllers/conductores/conductores.php */