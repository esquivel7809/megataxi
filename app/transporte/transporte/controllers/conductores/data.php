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
	/**
	 * Data::__construct()
	 * 
	 * @return void
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
            if(empty($this->arrayRequest['URL']) && !isset($this->arrayRequest['q']) && empty($this->arrayRequest['idtipodocumento']) && empty($this->arrayRequest['numerodocumento']))
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
	 * Data::index()
	 * 
	 * @return void
	 */
	public function index()
	{
		salida();
	}
    
    /**
     * Data::buscarconductor()
     * 
     * @return void
     */
    public function buscarconductor()
    {
        $this->load->view('conductores/busquedaConductores_view.php');
    }
	
    /**
     * Muestra pantalla para la busqueda de los conductores y los vehiculos asociados para refrendacion
     * 
     * @return void
     */
    public function buscarconductorrefrendacion()
    {
        $this->load->view('conductores/busquedaConductoresRefrendacion_view.php');
    }
    
    /**
     * Data::consultarconductor()
     * 
     * @return
     */
    public function consultarconductor()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idconductor, numerodocumento,primernombre, segundonombre, primerapellido, segundoapellido, conductor, nombrecompleto
        	  FROM	 conductor AS c
        	  WHERE  (c.numerodocumento LIKE '%".$q."%' OR c.primernombre  LIKE '%".$q."%' OR c.segundonombre LIKE '%".$q."%' OR c.primerapellido LIKE '%".$q."%' OR c.segundoapellido  LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%')
			  		  AND c.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idconductor']=html_entity_decode($row['idconductor']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
        	$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
	/**
	 * Consulta los conductores que tengan licencia de conduccion activa y que sean conductores
	 *
	 * Complemento para el plugin de Jquery autocompletar
	 *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
	 */
    public function consultarconductorlic()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT c.idconductor, numerodocumento, primernombre, segundonombre, primerapellido, segundoapellido, conductor, nombrecompleto, lc.fechavencimiento
        	  FROM	 conductor AS c
              INNER JOIN licenciaconductor AS lc ON lc.idconductor=c.idconductor
        	  WHERE  (c.numerodocumento LIKE '%".$q."%' OR c.primernombre  LIKE '%".$q."%' OR c.segundonombre LIKE '%".$q."%' OR c.primerapellido LIKE '%".$q."%' OR c.segundoapellido  LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%')
              AND c.idempresa='".$this->idempresa."' AND lc.activo='1' AND c.conductor='1'
        	  LIMIT 0 , 20";
        
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idconductor']=html_entity_decode($row['idconductor']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
        	$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            $row_['fechavencimiento']=html_entity_decode($row['fechavencimiento']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    /**
     * Data::consultarmunicipio()
     * 
     * @return
     */
    public function consultarmunicipio()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT m.iddepartamento,m.idmunicipio,m.nombremunicipio,d.nombredepartamento
        	  FROM	 municipio as m
              INNER JOIN departamento as d ON m.iddepartamento=d.iddepartamento
        	  WHERE  m.nombremunicipio LIKE '%".$q."%' OR m.idmunicipio LIKE '%".$q."%'
        	  LIMIT 0 , 20";
        
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
        	$row_['iddepartamento']=html_entity_decode($row['iddepartamento']);
        	$row_['idmunicipio']=html_entity_decode($row['idmunicipio']);
        	$row_['nombremunicipio']=html_entity_decode($row['nombremunicipio']);
            $row_['nombredepartamento']=html_entity_decode($row['nombredepartamento']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    /**
     * Data::subirfoto()
     * 
     * @return void
     */
    public function subirfoto()
    {
        $idtipodocumento=$this->arrayRequest['idtipodocumento'];
        $numerodocumento=$this->arrayRequest['numerodocumento'];
        
        $extension=explode(".",basename($_FILES['userfile']['name']));
        $sizefoto=$_FILES['userfile']['size'];
        $uploaddir = 'img/conductores/';
        $nombrearchivo=$idtipodocumento.$numerodocumento.date('dmYHis');
        $extensionarchivo='.'.strtolower($extension[1]);
        $uploadfile = $uploaddir.$nombrearchivo.$extensionarchivo;
        if (file_exists($uploadfile) == true)
        	unlink($uploadfile);
        if($sizefoto<=1048576)
        {
        	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
        	{
                $config['image_library'] = 'GD';
                $config['source_image'] = $uploadfile;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 336;
                $config['height'] = 448;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->tabla->settabla('conductor');
                $condicion = array(
                	'idtipodocumento'=>$idtipodocumento,
                	'numerodocumento'=>$numerodocumento
                );
                $campos = array(
                	'rutafoto'=>$nombrearchivo.$extensionarchivo
                );
                $this->tabla->actualizarDatosMinus($campos,$condicion);
                
                ?>
                <div id="upload_button"><img height="170px" width="135px" src="<?=base_url().$uploadfile;?>" alt=" " /></div>
                <?php
        	}
        	else
        	{
        		?>
        		<script type="text/javascript">
        			alert("Se presento un error al subir la foto.");
        		</script>
        		<?php
        	}
        }
        else
        {
        	?>
        	<script type="text/javascript">
        		alert("La imagen supera la dimension permitida (1 Mb)");
        	</script>
        	<div class="upload_button" id="upload_button"></div>
        	<?php
        }
        
        
    }
    public function consultarorganismos()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idorganismo, codigoorganismo, nombreorganismo
        	  FROM	 organismo
        	  WHERE  (codigoorganismo LIKE '%".$q."%' OR nombreorganismo  LIKE '%".$q."%')
        	  LIMIT 0 , 20";
        
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idorganismo']=html_entity_decode($row['idorganismo']);
            $row_['codigoorganismo']=html_entity_decode($row['codigoorganismo']);
        	$row_['nombreorganismo']=html_entity_decode($row['nombreorganismo']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
	/**
	 * Consulta solo los conductores que estan marcados como propietarios
	 *
	 * Complemento para el plugin de Jquery autocompletar
	 *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
	 */
    public function consultarpropietario()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idconductor, numerodocumento, nombrecompleto
        	  FROM	 conductor AS c
        	  WHERE  (c.numerodocumento LIKE '%".$q."%' OR c.primernombre  LIKE '%".$q."%' OR c.segundonombre LIKE '%".$q."%' OR c.primerapellido LIKE '%".$q."%' OR c.segundoapellido  LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%')
                    AND c.idempresa='".$this->idempresa."' AND c.propietario='1' AND c.activo='1'
        	  LIMIT 0 , 20";
        $consulta = $this->db->query($sql);
        foreach ($consulta->result_array() as $row)
        {
        	$row_['idconductor']=html_entity_decode($row['idconductor']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
        	$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
 
    /**
     * Data::consultarconductor()
     * 
     * @return
     */
    public function consultarconductorrefrendacion()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT r.idrefrendacion, r.fecharefrendacion, c.nombrecompleto, c.numerodocumento,
					 v.placa, vc.numerotarjeta, vc.idvehiculoconductor
        	  FROM	 vehiculoconductor AS vc
			  INNER JOIN conductor AS c ON c.idconductor=vc.idconductor
			  INNER JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
			  INNER JOIN refrendacion AS r ON r.idvehiculoconductor =  vc.idvehiculoconductor
        	  WHERE  (c.numerodocumento LIKE '%".$q."%' OR c.primernombre  LIKE '%".$q."%' 
			  		OR c.segundonombre LIKE '%".$q."%' OR c.primerapellido LIKE '%".$q."%' 
					OR c.segundoapellido  LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%'
					OR v.placa LIKE '%".$q."%' OR vc.numerotarjeta LIKE '%".$q."%')
					AND vc.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idrefrendacion']=html_entity_decode($row['idrefrendacion']);
            $row_['fecharefrendacion']=html_entity_decode($row['fecharefrendacion']);
			$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
			$row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['numerotarjeta']=html_entity_decode($row['numerotarjeta']);
			$row_['idvehiculoconductor']=html_entity_decode($row['idvehiculoconductor']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
	/**
	 * Consulta los datos de los contratantes para las planillas de viaje
	 *
	 *
	 * @access	privado, via Ajax
	 * @param	numerodocumento
	 * @return	json
	 */
    public function consultarcontratante()
    {
		$arraypost=$this->input->get();
        $sql="SELECT *
        	  FROM	 contratante AS cont
        	  WHERE  (cont.numerodocumento ='".$arraypost['numerodocumento']."')
			  		 AND cont.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 1";
        $consulta = $this->db->query($sql);
        foreach ($consulta->result_array() as $row)
        {
        	$row_['idcontratante']=html_entity_decode($row['idcontratante']);
			$row_['idtipodocumento']=html_entity_decode($row['idtipodocumento']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
        	$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            $row_['direccion']=html_entity_decode($row['direccion']);
        	$row_['telefonofijo']=html_entity_decode($row['telefonofijo']);
			$row_['existe']=true;
        }
        if(empty($row_))
        {
			$row_['existe']=false;
        }
		echo json_encode($row_);
    }
    /**
     * Data::buscarplanilla()
     * 
     * @return void
     */
    public function buscarplanilla()
    {
        $this->load->view('conductores/busquedaPlanillas_view.php');
    }
    /**
     * Data::consultarplanilla()
     * 
     * @return
     */
    public function consultarplanilla()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT p.idplanilla, p.numeroplanilla, v.placa, c.numerodocumento, c.nombrecompleto
        	  FROM	 planilla AS p
			  INNER JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor=p.idvehiculoconductor
			  INNER JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
			  INNER JOIN conductor AS c ON c.idconductor=vc.idconductor
        	  WHERE  (p.numeroplanilla LIKE '%".$q."%' OR v.placa  LIKE '%".$q."%' OR c.numerodocumento LIKE '%".$q."%')
			  		AND p.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idplanilla']=html_entity_decode($row['idplanilla']);
            $row_['numeroplanilla']=html_entity_decode($row['numeroplanilla']);
        	$row_['placa']=html_entity_decode($row['placa']);
			$row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
			$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
	
    /**
     * Data::buscarpasadoconductor()
     * 
     * @return void
     */
    public function buscarpasadoconductor()
    {
        $this->load->view('conductores/busquedaPasadoconductor_view.php');
    }
    /**
     * Data::consultarplanilla()
     * 
     * @return
     */
    public function consultarpasadoconductor()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT p.idpasadoconductor, p.idempresa, p.idconductor, p.numerocodigoconductor, c.nombrecompleto, c.numerodocumento
        	  FROM	 pasadoconductor AS p
			  INNER JOIN conductor AS c ON c.idconductor=p.idconductor
        	  WHERE  (p.numerocodigoconductor LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%' OR c.numerodocumento LIKE '%".$q."%')
			  		AND p.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idpasadoconductor']=html_entity_decode($row['idpasadoconductor']);
        	$row_['numerocodigoconductor']=html_entity_decode($row['numerocodigoconductor']);
			$row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
			$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }

    /**
     * Data::buscarpasadoconductor()
     * 
     * @return void
     */
    public function buscarlicenciaconductor()
    {
        $this->load->view('conductores/busquedaLicenciaconductor_view.php');
    }
    /**
     * Data::consultarplanilla()
     * 
     * @return
     */
    public function consultarlicenciaconductor()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT lc.idlicenciaconductor, lc.numerolicenciaconductor, c.nombrecompleto, c.numerodocumento
        	  FROM	 licenciaconductor AS lc
			  INNER JOIN conductor AS c ON c.idconductor=lc.idconductor
        	  WHERE  (lc.numerolicenciaconductor LIKE '%".$q."%' OR c.nombrecompleto  LIKE '%".$q."%' OR c.numerodocumento LIKE '%".$q."%')
			  		AND lc.idempresa='".$this->idempresa."' 
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idlicenciaconductor']=html_entity_decode($row['idlicenciaconductor']);
        	$row_['numerolicenciaconductor']=html_entity_decode($row['numerolicenciaconductor']);
			$row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
			$row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
	/**
	 * Devuelve una grilla con los datos de las licencias asociados a un conductor
	 *
	 * Acepta el id del conductor
	 *
	 * @access	privado, via Ajax
	 * @param	idconductor
	 * @return	html
	 */
    public function consultarlicencia($idconductor="")
    {
        $html="";
		if(empty($idconductor))
		{
			$idconductor=$this->arrayRequest['q'];
		}
        $sql="SELECT lc.idlicenciaconductor, lc.idconductor, lc.numerolicenciaconductor, lc.fechavencimiento
        	  FROM	 licenciaconductor as lc
        	  WHERE  (lc.idconductor = '".$idconductor."') AND lc.idempresa='".$this->idempresa."' AND lc.activo='1'
        	  LIMIT 0 , 1";
        
        $consulta= $this->db->query($sql);
		$html.="<ul class='licencias'><li class='titulo'>Licencias</li><li class='doc'>Nro. Licencia</li><li class='nom'>Fecha Vencimiento</li><li class='acc'>&nbsp;</li>";
        foreach ($consulta->result_array() as $row)
        {
            $html.="<li class='doc'> ".html_entity_decode($row['numerolicenciaconductor'])."</li>";
            $html.="<li class='nom'> ".html_entity_decode($row['fechavencimiento'])."</li>";
			$html.="<li class='acc'> &nbsp; </li>";
        }
		$html.="</ul>";
        echo $html;
    }

}
/* End of file data.php */
/* Location: ./application/controllers/condcutores/data.php */