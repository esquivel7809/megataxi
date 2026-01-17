<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

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
        if(consultar_session()){
	        $this->load->library('funciones');
            $this->load->database();
            $this->load->library('tabla');
	        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
			$this->idempresa=getIdempresaactual();
			$this->idsubmoduloactual=$this->arrayRequest['idsubmoduloactual'];
            if(empty($this->arrayRequest['URL']) && !isset($this->arrayRequest['q']) && empty($this->arrayRequest['idsubmodulo']))
            {
                //terminar_session();
            }
        }
    }

	public function index()
	{
        terminar_session();
    }
    
    public function busquedamodulo()
    {
        $this->load->view('administracion/busquedaModulo_view.php');
    }
    
    public function consultarmodulo()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idmodulo, nombremodulo
        	  FROM	 modulo
        	  WHERE  nombremodulo LIKE '%".$q."%'
        	  LIMIT 0 , 25";
        $consultaModulo = $this->db->query($sql);
        foreach ($consultaModulo->result_array() as $row)
        {
            $row_['idmodulo']=html_entity_decode($row['idmodulo']);
            $row_['nombremodulo']=html_entity_decode($row['nombremodulo']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    public function busquedasubmodulo()
    {
        $this->load->view('administracion/busquedaSubmodulo_view.php');
    }
    
    public function consultarsubmodulo()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT sm.idsubmodulo, sm.nombresubmodulo, sm.urlsubmodulo, m.idmodulo, m.nombremodulo
        	  FROM	 submodulo AS sm
              INNER JOIN modulo AS m ON m.idmodulo=sm.idmodulo 
        	  WHERE  sm.nombresubmodulo LIKE '%".$q."%' OR m.nombremodulo LIKE '%".$q."%'
        	  LIMIT 0 , 25";
        $consultaSubmodulo = $this->db->query($sql);
        foreach ($consultaSubmodulo->result_array() as $row)
        {
            $row_['idsubmodulo']=html_entity_decode($row['idsubmodulo']);
            $row_['nombresubmodulo']=html_entity_decode($row['nombresubmodulo']);
            $row_['urlsubmodulo']=html_entity_decode($row['urlsubmodulo']);
            $row_['idmodulo']=html_entity_decode($row['idmodulo']);
            $row_['nombremodulo']=html_entity_decode($row['nombremodulo']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }

    public function busquedausuario()
    {
        $this->load->view('administracion/busquedaUsuario_view.php');
    }
    
    public function consultarusuario()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idusuario, loginusuario, nombreusuario, numerodocumento
        	  FROM	 usuario
        	  WHERE  nombreusuario LIKE '%".$q."%' OR numerodocumento LIKE '%".$q."%'
        	  LIMIT 0 , 25";
        $consultaUsuario = $this->db->query($sql);
        foreach ($consultaUsuario->result_array() as $row)
        {
            $row_['idusuario']=html_entity_decode($row['idusuario']);
            $row_['loginusuario']=html_entity_decode($row['loginusuario']);
            $row_['nombreusuario']=html_entity_decode($row['nombreusuario']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    public function busquedaperfil()
    {
        $this->load->view('administracion/busquedaPerfil_view.php');
    }
    
    public function consultarperfil()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idperfilusuario, nombreperfilusuario
        	  FROM	 perfilusuario
        	  WHERE  nombreperfilusuario LIKE '%".$q."%'
        	  LIMIT 0 , 25";
        $consultaPerfil = $this->db->query($sql);
        foreach ($consultaPerfil->result_array() as $row)
        {
            $row_['idperfilusuario']=html_entity_decode($row['idperfilusuario']);
            $row_['nombreperfilusuario']=html_entity_decode($row['nombreperfilusuario']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    
    public function listasubmodulos()
    {
        $URL=$this->arrayRequest['URL'];
        $arrayURL=split('&',$URL);
        $array=split('=',$arrayURL[0]);
        $idperfilusuario=$array[1];
        
        $html="";
        $archivo=site_url('administracion/data/procesaperfilmodulos');
        $onclick="cambiar_estado(this,'".$archivo."')";
        $this->tabla->settabla('modulo');
        
        $datosModulo = $this->tabla->consultarDatos("idmodulo,nombremodulo","","nombremodulo");
        if(!empty($datosModulo))
        {
        	$html.= '<table>';
        	$html.= '<tr><td colspan="3">&nbsp;</td></tr>';
        	$html.= '<tr class="titulo"><th>M&oacute;dulos</th><th colspan="4">Subm&oacute;dulos</th></tr>';
            foreach($datosModulo as $modulo)
            {
                $html.= '<tr>';
                $html.= '<td align="left">'.html_entity_decode($modulo['nombremodulo']).'</td>';
                $this->tabla->settabla('submodulo');
                $condSubmodulo['idmodulo']=$modulo['idmodulo'];
                $datosSubmodulo = $this->tabla->consultarDatos("idsubmodulo,nombresubmodulo",$condSubmodulo,"nombresubmodulo");
                if(!empty($datosSubmodulo))
                {
                    $html.= '<td><table class="submodulo">';
                    $html.= '<tr>';
                    $html.= '<th class="nombre_sub">&nbsp;</th>';
                    $html.= '<th class="item" align="center" width="10px" class="" title="Modificar">Mod.</th>';
                    $html.= '<th class="item" align="center" width="10px" class="" title="Consultar">Con.</th>';
                    $html.= '<th class="item" align="center" width="10px" class="" title="Eliminar">Elim.</th>';
					$html.= '<th class="item" align="center" width="10px" class="" title="Imprimir">Impr.</th>';
                    $html.= '</tr>';
                    foreach($datosSubmodulo as $submodulo)
                    {
                        $checkedmodificar="";
                        $checkedconsultar="";
                        $checkedeliminar="";
						$checkedimprimir="";
						
                        $condPerfil['idperfilusuario']=$idperfilusuario;
                        $condPerfil['idsubmodulo']=$submodulo['idsubmodulo'];
						
                        $Camposperfil="modificar,consultar,eliminar,imprimir";
						
                        $this->tabla->settabla('perfilsubmodulo');
                        $datosPerfilsubmodulo = $this->tabla->consultarDatos($Camposperfil,$condPerfil);
                        
                        if($datosPerfilsubmodulo['0']['modificar']==1)
                        	$checkedmodificar='checked="checked"';
                        if($datosPerfilsubmodulo['0']['consultar']==1)
                        	$checkedconsultar='checked="checked"';
                        if($datosPerfilsubmodulo['0']['eliminar']==1)
                        	$checkedeliminar='checked="checked"';
                        if($datosPerfilsubmodulo['0']['imprimir']==1)
                        	$checkedimprimir='checked="checked"';
                            
                        $html.= '<tr>';
                        $html.= '<td align="left" class="">'.html_entity_decode($submodulo['nombresubmodulo']).'</td>';
                        $html.= '<td align="center"><input style="cursor:pointer" id="modificar-'.$idperfilusuario.'-'.$modulo['idmodulo'].'-'.$submodulo['idsubmodulo'].'" type="checkbox" '.$checkedmodificar.' onclick="'.$onclick.'"/></td>';
                        $html.= '<td align="center"><input style="cursor:pointer" id="consultar-'.$idperfilusuario.'-'.$modulo['idmodulo'].'-'.$submodulo['idsubmodulo'].'" type="checkbox" '.$checkedconsultar.' onclick="'.$onclick.'"/></td>';
                        $html.= '<td align="center"><input style="cursor:pointer" id="eliminar-'.$idperfilusuario.'-'.$modulo['idmodulo'].'-'.$submodulo['idsubmodulo'].'" type="checkbox" '.$checkedeliminar.' onclick="'.$onclick.'"/></td>';
						$html.= '<td align="center"><input style="cursor:pointer" id="imprimir-'.$idperfilusuario.'-'.$modulo['idmodulo'].'-'.$submodulo['idsubmodulo'].'" type="checkbox" '.$checkedimprimir.' onclick="'.$onclick.'"/></td>';
                        $html.= '</tr>';
                        next($datosSubmodulo);
                    }
                    $html.= '</table></td>';
                }
                $html.= '</tr>';
                next($datosModulo);
            }
            $html.= '<tr><td colspan="2" align="center" style="padding:5px;">';
            $html.= '</table>';
        }
        echo $html;
    }

    public function procesaperfilmodulos()
    {
        $idperfilusuario=$this->arrayRequest['idperfilusuario'];
        $idsubmodulo=$this->arrayRequest['idsubmodulo'];
        $campo=$this->arrayRequest['campo'];
        $modi=$this->arrayRequest['modi'];
		$campos['idempresa']=$this->idempresa;
        //print_r($this->arrayRequest);
        
        $this->tabla->settabla('perfilsubmodulo');
        $condPerfil['idperfilusuario']=$idperfilusuario;
        $condPerfil['idsubmodulo']=$idsubmodulo;
		$condPerfil['idempresa']=$this->idempresa;
        
        $cantidad = $this->tabla->cantidadDatos("*",$condPerfil);
        
        $campos['idperfilusuario']=$idperfilusuario;
        $campos['idsubmodulo']=$idsubmodulo;
        $campos[$campo]=$modi;
        if($cantidad>0)
        {
        	//actulizar
            
        	$datosPerfilsubmodulo[$campo]=$modi;
        	$this->tabla->actualizarDatosMinus($campos,$condPerfil);
        }
        else
        {
        	//insertar
        	$this->tabla->agregarDatosMinus($campos);
        }
		?>
		<script type="text/javascript">
			alert("<?=$this->tabla->mensaje?>");
		</script>
		<?php
    }
}
/* End of file data.php */
/* Location: ./application/controllers/administracion/data.php */