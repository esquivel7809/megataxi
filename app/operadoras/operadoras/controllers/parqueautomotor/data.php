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
        $this->load->library('funciones');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['URL']) && !isset($this->arrayRequest['q']) && empty($this->arrayRequest['idconductor']) && empty($this->arrayRequest['idvehiculo']))
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
        terminar_session();
    }
    
    
    /**
    * Muestra el formulario para la busqueda de vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscarvehiculo()
    {
        $this->load->view('parqueautomotor/busquedaVehiculos_view.php',$data);
    }
    
    
    /**
    * Devuelve los datos del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarvehiculo()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idvehiculo, placa, numerochasis
        	  FROM	 vehiculo AS v
        	  WHERE  (v.placa LIKE '%".$q."%' OR v.numerochasis  LIKE '%".$q."%' OR v.numeromotor LIKE '%".$q."%' OR v.numerolicencia LIKE '%".$q."%' OR v.numerointerno  LIKE '%".$q."%')
			  		 AND v.idempresa='".$this->idempresa."' AND v.activo='1'
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['placa']=html_entity_decode($row['placa']);
            $row_['numerochasis']=html_entity_decode($row['numerochasis']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Devuelve los datos del vehiculo
    * utilizado en autocompletar para el registro de los vehiculos
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarvehiculoall()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idvehiculo, placa, numerochasis
        	  FROM	 vehiculo AS v
        	  WHERE  (v.placa LIKE '%".$q."%' OR v.numerochasis  LIKE '%".$q."%' OR v.numeromotor LIKE '%".$q."%' OR v.numerolicencia LIKE '%".$q."%' OR v.numerointerno  LIKE '%".$q."%')
			  		 AND v.idempresa='".$this->idempresa."'
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['placa']=html_entity_decode($row['placa']);
            $row_['numerochasis']=html_entity_decode($row['numerochasis']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    /**
    * Devuelve los datos de los vehiculos y los conductores que estan asociados
    * utilizado en autocompletar
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultarvehiculoconductor()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT v.idvehiculo, c.idconductor, vc.idvehiculoconductor, v.placa, c.numerodocumento, c.primernombre,
                     c.segundonombre, c.primerapellido, c.segundoapellido, vc.numerotarjeta,
                     s.fechafinal AS vencimientosoat, ca.fechafinal AS vencimientocontractual, eca.fechafinal AS vencimientoextracontractual,
                     lc.fechavencimiento
        	  FROM	 vehiculoconductor as vc
              INNER JOIN vehiculo as v ON v.idvehiculo = vc.idvehiculo
              INNER JOIN conductor as c ON c.idconductor = vc.idconductor
              INNER JOIN soat AS s ON s.idvehiculo=v.idvehiculo
              INNER JOIN contractual AS ca ON ca.idvehiculo=v.idvehiculo
              INNER JOIN extracontractual AS eca ON eca.idvehiculo=v.idvehiculo
              INNER JOIN licenciaconductor AS lc ON lc.idconductor=c.idconductor
        	  WHERE  (c.numerodocumento LIKE '%".$q."%' OR c.primernombre  LIKE '%".$q."%' OR c.segundonombre LIKE '%".$q."%' OR c.primerapellido LIKE '%".$q."%' OR c.segundoapellido  LIKE '%".$q."%' OR vc.numerotarjeta  LIKE '%".$q."%')
			  		AND v.idempresa='".$this->idempresa."' AND v.activo='1'
        	  LIMIT 0 , 20";
        
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['idconductor']=html_entity_decode($row['idconductor']);
            $row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['idvehiculoconductor']=html_entity_decode($row['idvehiculoconductor']);
            $row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
            $row_['placa']=html_entity_decode($row['placa']);
        	$row_['nombrecompleto']=html_entity_decode($row['primernombre']." ".$row['segundonombre']." ".$row['primerapellido']." ".$row['segundoapellido']);
            $row_['numerotarjeta']=html_entity_decode($row['numerotarjeta']);
            $row_['vencimientosoat']=html_entity_decode($row['vencimientosoat']);
            $row_['vencimientocontractual']=html_entity_decode($row['vencimientocontractual']);
            $row_['vencimientoextracontractual']=html_entity_decode($row['vencimientoextracontractual']);
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
	 * Devuelve una grilla con los datos de los conductores asociados a un vehiculo
	 *
	 * Acepta el id del vehiculo
	 *
	 * @access	privado, via Ajax
	 * @param	idvehiculo
	 * @return	html
	 */
    public function consultarvehiculoconductorasociado()
    {
        $html="";
        $idconductor=$this->arrayRequest['idconductor'];
        $sql="SELECT v.idvehiculo, c.idconductor, v.placa, v.numerochasis, v.numeromotor, vc.activo, vc.numerotarjeta, c.nombrecompleto
        	  FROM	 vehiculoconductor as vc
              INNER JOIN vehiculo as v ON v.idvehiculo = vc.idvehiculo
              INNER JOIN conductor as c ON c.idconductor = vc.idconductor 
        	  WHERE  (vc.idconductor = '".$idconductor."') AND v.idempresa='".$this->idempresa."' AND v.activo='1'
        	  LIMIT 0 , 20";
        
        $consultaConductor = $this->db->query($sql);
        $html.="<table><tr><td>Placa</td><td>Nº Tarjeta</td><td>Nombre</td><td>Estado</td></tr>";
        foreach ($consultaConductor->result_array() as $row)
        {
            $activo="Inactivo";
            $html.="<tr>";
            $html.="<td>".html_entity_decode($row['placa'])."</td>";
            $html.="<td>".html_entity_decode($row['numerotarjeta'])."</td>";
            $html.="<td>".html_entity_decode($row['nombrecompleto'])."</td>";
            if($row['activo']==1)$activo = 'Activo';
            $html.="<td>".html_entity_decode($activo)."</td>";
            $html.="</tr>";
        }
        $html.="</table>";
        echo $html;
    }
    
	/**
	 * Devuelve una grilla con los datos de los vehiculos asociados a un propietario
	 *
	 * Acepta el id del vehiculo
	 *
	 * @access	privado, via Ajax
	 * @param	idvehiculo
	 * @return	html
	 */
    public function consultarvehiculopropietario()
    {
        $html="";
        
        $idvehiculo=$this->arrayRequest['idvehiculo'];
        $sql="SELECT v.idvehiculo, c.idconductor, v.placa, v.activo, c.nombrecompleto, c.numerodocumento, vp.idvehiculopropietario
        	  FROM	 vehiculopropietario as vp
              INNER JOIN vehiculo as v ON v.idvehiculo = vp.idvehiculo
              INNER JOIN conductor as c ON c.idconductor = vp.idconductor 
        	  WHERE  (vp.idvehiculo = '".$idvehiculo."') AND v.idempresa='".$this->idempresa."' AND vp.activo='1'
        	  LIMIT 0 , 20";
        
        $consultaConductor = $this->db->query($sql);
		//preparamos el javascript para proceder a actualizar el registro
		$html.="<script>
			$('b.remove').click(function(){
				if(confirm('Esta seguro que desea eliminar el propietario a este vehiculo')){
					abrirAjax('#contenido', '".site_url('parqueautomotor/vehiculopropietario/eliminar')."','idvehiculopropietario='+$(this).attr('id'));
				}
				})
		</script>";
		$html.="<ul class='propietarios'><li class='titulo'>Propietarios</li><li class='doc'>Nro. Documento</li><li class='nom'>Nombre</li><li class='acc'>Acción</li>";
        foreach ($consultaConductor->result_array() as $row)
        {
            $html.="<li class='doc'> ".$row['numerodocumento']."</li>";
            $html.="<li class='nom'> ".html_entity_decode($row['nombrecompleto'])."</li>";
			$html.="<li class='acc'> <b id='".$row['idvehiculopropietario']."'class='remove' tittle='Eliminar registro'></b></li>";
        }
		$html.="</ul>";
        echo $html;
    }
    
    /**
    * Devuelve los datos de los vehiculos que no estan asociados
    * utilizado en autocompletar
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultarvehiculonoasociado()
    {
        $q=$this->arrayRequest['q'];
        $idconductor=$this->arrayRequest['idconductor'];
/*        $sql="SELECT idvehiculo, placa, numerochasis
        	  FROM	 vehiculo
        	  WHERE  idvehiculo NOT IN (SELECT idvehiculo FROM vehiculoconductor WHERE idconductor='".$idconductor."')
        	  LIMIT 0 , 25";
*/
        $sql="SELECT v.idvehiculo, v.placa, v.numerochasis, s.fechafinal AS vencimientosoat, ca.fechafinal AS vencimientocontractual, eca.fechafinal AS vencimientoextracontractual
        	  FROM	 vehiculo AS v
              INNER JOIN soat AS s ON s.idvehiculo=v.idvehiculo
              INNER JOIN contractual AS ca ON ca.idvehiculo=v.idvehiculo
              INNER JOIN extracontractual AS eca ON eca.idvehiculo=v.idvehiculo
        	  WHERE  (v.placa LIKE '%".$q."%' OR v.numerochasis LIKE '%".$q."%') AND v.empresa='1'
              AND v.idempresa='".$this->idempresa."' AND s.activo='1' AND ca.activo='1' AND eca.activo='1' AND v.activo='1' 
        	  LIMIT 0 , 25";
              
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
            $row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['numerochasis']=html_entity_decode($row['numerochasis']);
            $row_['placa']=html_entity_decode($row['placa']);
            $row_['vencimientosoat']=html_entity_decode($row['vencimientosoat']);
            $row_['vencimientocontractual']=html_entity_decode($row['vencimientocontractual']);
            $row_['vencimientoextracontractual']=html_entity_decode($row['vencimientoextracontractual']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    /**
    * Consulta de vehiculos para el registro de radiotelefonos 
    * solo activos y que esten afiliados a comunicacion
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultarvehiculocomunicacion()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT *
        	  FROM	 vehiculo AS v
        	  WHERE (v.placa LIKE '%".$q."%' OR v.numerochasis  LIKE '%".$q."%' OR v.numeromotor LIKE '%".$q."%' OR v.numerolicencia LIKE '%".$q."%' OR v.numerointerno  LIKE '%".$q."%')
                   AND v.idempresa='".$this->idempresa."' AND v.activo='1' AND v.comunicacion='1'
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['placa']=html_entity_decode($row['placa']);
            $row_['numerochasis']=html_entity_decode($row['numerochasis']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
	/**
	 * Devuelve una grilla con los datos de los seguros de los vehiculos
	 *
	 * Acepta el id del vehiculo
	 *
	 * @access	privado, via Ajax
	 * @param	idvehiculo
	 * @return	html
	 */
    public function consultarvehiculoseguros()
    {
		$idvehiculo=$this->arrayRequest['idvehiculo'];
		$html=$this->funciones->consVehiculoseguros($idvehiculo);
		echo utf8_encode($html);
    }
    /**
    * Muestra el formulario para la busqueda de Soat de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscarsoat()
    {
        $this->load->view('parqueautomotor/busquedaSoat_view.php',$data);
    }
	
    /**
    * Devuelve los datos del Soat del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarsoat()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT s.idsoat, s.numerosoat, s.activo, v.placa
        	  FROM	 soat AS s
			  INNER JOIN vehiculo AS v ON v.idvehiculo=s.idvehiculo AND v.activo='1'
        	  WHERE  (v.placa LIKE '%".$q."%' OR s.numerosoat  LIKE '%".$q."%') AND s.idempresa='".$this->idempresa."'
			  ORDER BY s.activo DESC
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idsoat']=html_entity_decode($row['idsoat']);
            $row_['numerosoat']=html_entity_decode($row['numerosoat']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['activo']=(html_entity_decode($row['activo'])==0) ? "Inactivo" :"Activo";
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Muestra el formulario para la busqueda de las Revisiones de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscarrevision()
    {
        $this->load->view('parqueautomotor/busquedaRevision_view.php',$data);
    }
	
    /**
    * Devuelve los datos de las Revisiones del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarrevision()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT r.idrevision, r.numerorevision, r.activo, v.placa
        	  FROM	 revision AS r
			  INNER JOIN vehiculo AS v ON v.idvehiculo=r.idvehiculo AND v.activo='1'
        	  WHERE  (v.placa LIKE '%".$q."%' OR r.numerorevision  LIKE '%".$q."%') AND r.idempresa='".$this->idempresa."'
			  ORDER BY r.activo DESC
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idrevision']=html_entity_decode($row['idrevision']);
            $row_['numerorevision']=html_entity_decode($row['numerorevision']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['activo']=(html_entity_decode($row['activo'])==0) ? "Inactivo" :"Activo";
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Muestra el formulario para la busqueda de los Seguros Contractuales de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscarcontractual()
    {
        $this->load->view('parqueautomotor/busquedaContractual_view.php',$data);
    }
	
    /**
    * Devuelve los datos de los Seguros Contractuales del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarcontractual()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT c.idcontractual, c.numerocontractual, c.activo, v.placa
        	  FROM	 contractual AS c
			  INNER JOIN vehiculo AS v ON v.idvehiculo=c.idvehiculo AND v.activo='1'
        	  WHERE  (v.placa LIKE '%".$q."%' OR c.numerocontractual  LIKE '%".$q."%') AND c.idempresa='".$this->idempresa."'
			  ORDER BY c.activo DESC
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idcontractual']=html_entity_decode($row['idcontractual']);
            $row_['numerocontractual']=html_entity_decode($row['numerocontractual']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['activo']=(html_entity_decode($row['activo'])==0) ? "Inactivo" :"Activo";
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Muestra el formulario para la busqueda de los Seguros Extra-Contractuales de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscarextracontractual()
    {
        $this->load->view('parqueautomotor/busquedaExtracontractual_view.php',$data);
    }
	
    /**
    * Devuelve los datos de los Seguros Extra-Contractuales del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultarextracontractual()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT ec.idextracontractual, ec.numeroextracontractual, ec.activo, v.placa
        	  FROM	 extracontractual AS ec
			  INNER JOIN vehiculo AS v ON v.idvehiculo=ec.idvehiculo AND v.activo='1'
        	  WHERE  (v.placa LIKE '%".$q."%' OR ec.numeroextracontractual  LIKE '%".$q."%') AND ec.idempresa='".$this->idempresa."'
			  ORDER BY ec.activo DESC
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idextracontractual']=html_entity_decode($row['idextracontractual']);
            $row_['numeroextracontractual']=html_entity_decode($row['numeroextracontractual']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['activo']=(html_entity_decode($row['activo'])==0) ? "Inactivo" :"Activo";
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Muestra el formulario para la busqueda de los Seguros Extra-Contractuales de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function buscartarjeta()
    {
        $this->load->view('parqueautomotor/busquedaTarjeta_view.php',$data);
    }
	
    /**
    * Devuelve los datos de los Seguros Extra-Contractuales del vehiculo
    * utilizado en autocompletar
    *
	 * @access	privado, via Ajax
	 * @param	q
	 * @return	json
    */
    public function consultartarjeta()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT t.idtarjetaoperacion, t.numerotarjetaoperacion, t.activo, v.placa
        	  FROM	 tarjetaoperacion AS t
			  INNER JOIN vehiculo AS v ON v.idvehiculo=t.idvehiculo AND v.activo='1'
        	  WHERE  (v.placa LIKE '%".$q."%' OR t.numerotarjetaoperacion  LIKE '%".$q."%') AND t.idempresa='".$this->idempresa."'
			  ORDER BY t.activo DESC
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idtarjetaoperacion']=html_entity_decode($row['idtarjetaoperacion']);
            $row_['numerotarjetaoperacion']=html_entity_decode($row['numerotarjetaoperacion']);
			$row_['placa']=html_entity_decode($row['placa']);
			$row_['activo']=(html_entity_decode($row['activo'])==0) ? "Inactivo" :"Activo";
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
}
/* End of file data.php */
/* Location: ./application/controllers/paraqueautomotor/data.php */