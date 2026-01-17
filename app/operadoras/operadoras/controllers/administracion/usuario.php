<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

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
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idusuario']))
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

	public function index()
	{
        $data['vista_contenido_mod']=array("administracion/usuario_view");
        
        $jsbuscar = "buscaRegistro('".site_url('administracion/data/busquedausuario')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Usuarios','#busqueda')";
        
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
        $datoidperfilusuario = "";
        
        $existeinfo = 0;
        
        if(!empty($this->arrayRequest['idusuario']))
        {
            $this->tabla->settabla('usuario');
            $condUsuario=array('idusuario'=>$this->arrayRequest['idusuario']);
            $datos = $this->tabla->consultarDatos("idusuario,loginusuario,idtipodocumento,numerodocumento,nombreusuario,telefonousuario,cargousuario,celularusuario,idperfilusuario,activo",$condUsuario,"","","","");
            $existeinfo = 1;
            $data['datoidusuario']      = $datos[0]['idusuario'];
            $data['datologinusuario']   = html_entity_decode($datos[0]['loginusuario']);
            $datoidtipodocumento        =   $datos[0]['idtipodocumento'];
            $data['datonumerodocumento']    = html_entity_decode($datos[0]['numerodocumento']);
            $data['datonombreusuario']  = html_entity_decode($datos[0]['nombreusuario']);
            $data['datotelefonousuario']= $datos[0]['telefonousuario'];
            $data['datocargousuario']   = $datos[0]['cargousuario'];
            $data['datocelularusuario'] = $datos[0]['celularusuario'];
            $datoidperfilusuario        =   $datos[0]['idperfilusuario'];
            if($datos[0]['activo']==1)$data['datoactivo'] = 'checked="checked"';
            $data['disabled']="disabled='disabled'";
        }
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        /**** se consultan los tipos de documentos ***/
        $consultaTipodocumentos = $this->db->query('SELECT idtipodocumento,nombretipodocumento,abreviatura FROM tipodocumento ORDER BY nombretipodocumento DESC');
        foreach ($consultaTipodocumentos->result_array() as $filaTipodocumento)
        {
            $arrayTipodocumentos[]=$filaTipodocumento;
        }
        $consultaTipodocumentos->free_result();
        $data['tipodocumento']=$this->funciones->crearCombo($arrayTipodocumentos,$datoidtipodocumento,'idtipodocumento','abreviatura');
        /**************/

        /**** se consultan los perfiles de usuario ***/
        $consultaPerfilusuario = $this->db->query('SELECT idperfilusuario,nombreperfilusuario FROM perfilusuario ORDER BY nombreperfilusuario DESC');
        foreach ($consultaPerfilusuario->result_array() as $filaPerfilusuario)
        {
            $arrayPerfilusuario[]=$filaPerfilusuario;
        }
        $consultaPerfilusuario->free_result();
        $data['perfilusuario']=$this->funciones->crearCombo($arrayPerfilusuario,$datoidperfilusuario,'idperfilusuario','nombreperfilusuario');
        /**************/
        $this->load->view('include/plantilla3',$data);
    }
    public function registro()
    {
        $this->tabla->settabla('usuario');
        $arraypost=$this->input->post();
        
        if(!empty($arraypost['contrasena']))
        {
            $campos['contrasena']   =   sha1(md5(trim(addslashes($arraypost['contrasena']))));                
        } 
        $campos['idtipodocumento']  =   $arraypost['idtipodocumento'];
        $campos['numerodocumento']  =   $arraypost['numerodocumento'];
        $campos['nombreusuario']    =   $arraypost['nombreusuario'];
        $campos['telefonousuario']  =   $arraypost['telefonousuario'];
        $campos['cargousuario']     =   $arraypost['cargousuario'];
        $campos['celularusuario']   =   $arraypost['celularusuario'];
        $campos['idperfilusuario']  =   $arraypost['idperfilusuario'];
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
            $campos['idusuario']  =   $this->tabla->MaximoDato("idusuario") + 1;
            $campos['loginusuario']     =   mb_strtolower($arraypost['loginusuario']);
            $this->tabla->agregarDatosMinus($campos);
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idusuario' => $arraypost['idusuario']);
            $this->tabla->actualizarDatosMinus($campos,$condicion);
            //print_r($campos);
        }
        $this->index();
		?>
		<script type="text/javascript">
			alert("<?=$this->tabla->mensaje?>");
		</script>
		<?php
    }
}
/* End of file usuario.php */
/* Location: ./application/controllers/administracion/usuario.php */