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
        $this->login=$this->session->userdata('loginusuarioactual');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            /*if(empty($this->arrayRequest['URL']) && empty($this->arrayRequest['q']) && empty($this->arrayRequest['idtipodocumento']) && empty($this->arrayRequest['numerodocumento']))
            {
                //terminar_session();
            }
            else
            {
                $this->load->library('tabla');
            }*/
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
	* Data::consultarvehiculo()
	*
	* Consulta los datos de los vehiculos que son afiliados a la empresa, utilizado en la busqueda de vehiculos 
	* para la impresion de del formato de la renovacion de la tarjeta de operacion
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarvehiculo()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idvehiculo, placa
        	  FROM	 vehiculo
        	  WHERE  (placa LIKE '%".$q."%') AND idempresa='".$this->idempresa."' AND empresa='1' AND activo='1'
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idvehiculo']);
            $row_['value']=html_entity_decode($row['placa']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultarvehiculoformatoafil()
	*
	* Consulta los datos de los vehiculos y sus propietarios que son afiliados a la empresa, utilizado en la busqueda de vehiculos 
	* para la impresion de del formato afiliacion
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarvehiculoformatoafil()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idvehiculopropietario, v.placa, c.numerodocumento, c.nombrecompleto
        	  FROM	vehiculopropietario AS vp
			  INNER JOIN vehiculo AS v ON v.idvehiculo = vp.idvehiculo
			  INNER JOIN conductor AS c ON c.idconductor = vp.idconductor
        	  WHERE (v.placa LIKE '%".$q."%' OR c.numerodocumento LIKE '%".$q."%' OR c.nombrecompleto LIKE '%".$q."%')
			  		AND v.idempresa='".$this->idempresa."' AND v.empresa='1' AND v.activo='1' AND vp.activo='1'
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idvehiculopropietario']);
            $row_['value']=html_entity_decode($row['placa']." ".$row['numerodocumento']." ".$row['nombrecompleto']);
            
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
/* Location: ./application/controllers/informes/data.php */