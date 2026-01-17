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
        if(!empty($login))
        {
            if(empty($this->arrayRequest['URL']) && !isset($this->arrayRequest['q']) && empty($this->arrayRequest['idconductor']))
            {
                terminar_session();
            }
            else
            {
                $this->load->database();
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
    
    public function consultarmodeloradio()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT mar.nombremarcaradio, mor.nombremodeloradio, mor.idmodeloradio
        	  FROM	 modeloradio AS mor
              LEFT JOIN marcaradio AS mar ON mar.idmarcaradio=mor.idmarcaradio
        	  WHERE  mar.nombremarcaradio LIKE '%".$q."%' OR mor.nombremodeloradio  LIKE '%".$q."%'
        	  LIMIT 0 , 25";
        $consulta = $this->db->query($sql);
        foreach ($consulta->result_array() as $row)
        {
            $row_['idmodeloradio']=html_entity_decode($row['idmodeloradio']);
            $row_['nombremarcaradio']=html_entity_decode($row['nombremarcaradio']);
            $row_['nombremodeloradio']=html_entity_decode($row['nombremodeloradio']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    public function consultarmega()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT idmega, numeromega, idcanal, activo
        	  FROM	 mega AS m
        	  WHERE  m.numeromega LIKE '%".$q."%' AND m.activo='0'
        	  LIMIT 0 , 25";
        $consulta = $this->db->query($sql);
        foreach ($consulta->result_array() as $row)
        {
            $row_['idmega']=html_entity_decode($row['idmega']);
            $row_['numeromega']=html_entity_decode($row['numeromega']);
            $row_['idcanal']=html_entity_decode($row['idcanal']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Consulta de vehiculos que tienen asociado un radiotelefono (vehiculoradiotelefono)
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultavehiculoradiotelefono()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT vr.idvehiculoradiotelefono, v.placa, r.serieradiotelefono, mv.nombremarcavehiculo,
					mo.nombremodelo, mar.nombremarcaradio, mr.nombremodeloradio, v.idvehiculo, me.numeromega
        	  FROM	 vehiculoradiotelefono AS vr
			  INNER JOIN vehiculo AS v ON v.idvehiculo=vr.idvehiculo
			  INNER JOIN radiotelefono AS r ON r.idradiotelefono=vr.idradiotelefono
			  LEFT JOIN vehiculomega AS vm ON vm.idvehiculoradiotelefono=vr.idvehiculoradiotelefono
			  LEFT JOIN mega AS me ON me.idmega=vm.idmega
			  LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
			  LEFT JOIN modelo AS mo ON mo.idmodelo=v.idmodelo
			  LEFT JOIN modeloradio AS mr ON mr.idmodeloradio=r.idmodeloradio
			  LEFT JOIN marcaradio AS mar ON mar.idmarcaradio=mr.idmarcaradio			  
        	  WHERE (v.placa LIKE '%".$q."%' OR r.serieradiotelefono  LIKE '%".$q."%')
                    AND v.activo='1' AND v.comunicacion='1'
			  GROUP BY v.idvehiculo
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idvehiculoradiotelefono']=html_entity_decode($row['idvehiculoradiotelefono']);
            $row_['serieradiotelefono']=html_entity_decode($row['serieradiotelefono']);
			$row_['nombremarcaradio']=html_entity_decode($row['nombremarcaradio']);
			$row_['nombremodeloradio']=html_entity_decode($row['nombremodeloradio']);
			$row_['idvehiculo']=html_entity_decode($row['idvehiculo']);
            $row_['placa']=html_entity_decode($row['placa']);
			$row_['nombremarcavehiculo']=html_entity_decode($row['nombremarcavehiculo']);
			$row_['nombremodelo']=html_entity_decode($row['nombremodelo']);
			$row_['numeromega']=html_entity_decode($row['numeromega']);
			
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    
    /**
    * Consulta de radiotelefonos registrados (radiotelefono)
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultaradiotelefono()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT r.idradiotelefono, r.serieradiotelefono, mr.nombremodeloradio, mar.nombremarcaradio
        	  FROM	 radiotelefono AS r
			  INNER JOIN modeloradio AS mr ON mr.idmodeloradio=r.idmodeloradio
			  INNER JOIN marcaradio AS mar ON mar.idmarcaradio=mr.idmarcaradio
        	  WHERE (r.serieradiotelefono LIKE '%".$q."%' OR mar.nombremarcaradio LIKE '%".$q."%' OR mr.nombremodeloradio LIKE '%".$q."%')
                    AND r.activo='1'
        	  LIMIT 0 , 25";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idradiotelefono']=html_entity_decode($row['idradiotelefono']);
            $row_['serieradiotelefono']=html_entity_decode($row['serieradiotelefono']);
            $row_['nombremodeloradio']=html_entity_decode($row['nombremodeloradio']);
			$row_['nombremarcaradio']=html_entity_decode($row['nombremarcaradio']);
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        
        return $lista;
    }
    /**
    * Consulta de los datos de los carnet de comunicacion (carnetcomunicacion)
    *
    * @access	privado, via Ajax
    * @param	q
    * @return	json
    */
    public function consultacarnetcomunicacion()
    {
        $q=$this->arrayRequest['q'];
        $sql="SELECT cc.idcarnetcomunicacion, cc.numerocarnet, cc.idvehiculopropietario, c.nombrecompleto,
					c.numerodocumento, v.placa 
        	  FROM	 carnetcomunicacion AS cc
			  INNER JOIN conductor AS c ON c.idconductor=cc.idvehiculopropietario
			  INNER JOIN vehiculoradiotelefono AS vr ON vr.idvehiculoradiotelefono=cc.idvehiculoradiotelefono
			  INNER JOIN vehiculo AS v ON v.idvehiculo=vr.idvehiculo
        	  WHERE (cc.numerocarnet LIKE '%".$q."%' OR c.nombrecompleto LIKE '%".$q."%' OR v.placa LIKE '%".$q."%')
        	  LIMIT 0 , 20";
        $consultaVehiculo = $this->db->query($sql);
        foreach ($consultaVehiculo->result_array() as $row)
        {
            $row_['idcarnetcomunicacion']=html_entity_decode($row['idcarnetcomunicacion']);
            $row_['numerocarnet']=html_entity_decode($row['numerocarnet']);
            $row_['nombrecompleto']=html_entity_decode($row['nombrecompleto']);
			$row_['numerodocumento']=html_entity_decode($row['numerodocumento']);
			$row_['placa']=html_entity_decode($row['placa']);
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
/* Location: ./application/controllers/comunicaciones/data.php */