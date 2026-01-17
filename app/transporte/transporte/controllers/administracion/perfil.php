<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idperfilusuario']))
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
        $data['vista_contenido_mod']=array("administracion/perfil_view");
        
        $jsbuscar = "buscaRegistro('".site_url('administracion/data/busquedaperfil')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Perfiles de Usuario','#busqueda')";
        
        
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
        if(!empty($this->arrayRequest['idperfilusuario']))
        {
            $this->tabla->settabla('perfilusuario');
            $condPerfilUsuario=array('idperfilusuario'=>$this->arrayRequest['idperfilusuario']);
            $datosVehiculo = $this->tabla->consultarDatos("idperfilusuario,nombreperfilusuario",$condPerfilUsuario,"","","","");
            $existeinfo = 1;
            $data['datoidperfilusuario']    = $datosVehiculo[0]['idperfilusuario'];
            $data['datonombreperfilusuario']= $datosVehiculo[0]['nombreperfilusuario'];
            
            $data['jsmodulos'] = "buscaRegistro('".site_url('administracion/data/listasubmodulos')."','idperfilusuario=".$this->arrayRequest['idperfilusuario']."',450,700,'Lista de Modulos','#busqueda')";
            
        }
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        $this->load->view('include/plantilla3',$data);
    }
    
    
    public function registro()
    {
        $this->tabla->settabla('perfilusuario');
        $arraypost=$this->input->post();
        
        $campos['nombreperfilusuario']     =   $arraypost['nombreperfilusuario'];
        
        if($arraypost["Guardar"]=="Guardar")
        {
            $campos['idperfilusuario']       =   $this->tabla->MaximoDato("idperfilusuario") + 1;
            $this->tabla->agregarDatosMinus($campos);
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idperfilusuario' => $arraypost['idperfilusuario']);
            $this->tabla->actualizarDatosMinus($campos,$condicion);
        }
        //echo"entro";
        $this->index();
		?>
		<script type="text/javascript">
			alert("<?=$this->tabla->mensaje?>");
		</script>
		<?php
    }
    
}
/* End of file perfil.php */
/* Location: ./application/controllers/administracion/perfil.php */