<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tarjetacontrol extends CI_Controller {
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
		//cargamos el modelo de la refrendacion
        $this->load->model('Refrendacion_model');
		$this->load->library('funciones');
		$this->load->library('tabla');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idrefrendacion']) && !isset($this->arrayRequest['idconductor']))
            {
                //terminar_session();
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
    * Muestra el formulario de registro de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("imprimir/tarjetacontrol_imp_view");
		
		//inicializamos variables
        $datofecharefrendacion = date('d/m/Y');
        $datohorarefrendacion = date('H:i:s');
		$datoidtipodocumento = "";
		$idrefrendacion=$this->arrayRequest['idrefrendacion'];
		if(!empty($idrefrendacion))
		{
			//se consultan los datos del conductor
			$datosRefrendacion = $this->Refrendacion_model->cons_dat_refrendacion($idrefrendacion);
			
            $existeinfo = 1;
            $data['datonombrecompleto']     =   html_entity_decode($datosRefrendacion[0]['nombrecompleto']);
			$data['datodireccion']     =   html_entity_decode($datosRefrendacion[0]['direccion']);
			$data['datocelular']    =   (!empty($datosRefrendacion[0]['celular'])) ? $datosRefrendacion[0]['celular'] : "" ;
			$data['datotelefonofijo']    =   (!empty($datosRefrendacion[0]['telefonofijo'])) ? $datosRefrendacion[0]['telefonofijo'] : "" ;
			$datoidtipodocumento            =   $datosRefrendacion[0]['idtipodocumento'];
			$data['datonumerodocumento']    =   $datosRefrendacion[0]['numerodocumento'];
			$data['datofechanacimiento']    =   $this->funciones->convertirFormatoFecha($datosRefrendacion[0]['fechanacimiento'],'aaaa-mm-dd','dd/mm/aaaa');
			$data['datonombregruposanguineo']    =   $datosRefrendacion[0]['nombregruposanguineo'];
			$data['datonumerointerno']        =   $datosRefrendacion[0]['numerointerno'];
			$data['datoplaca']        =   $datosRefrendacion[0]['placa'];
			$data['datonumerolicenciaconductor']        =   $datosRefrendacion[0]['numerolicenciaconductor'];
			$data['datonombremunicipio']     =   html_entity_decode($datosRefrendacion[0]['nombremunicipio']);
			$data['datonumerorevision']        =   $datosRefrendacion[0]['numerorevision'];
			$data['datorevision_fechafinal']        =   $datosRefrendacion[0]['revision_fechafinal'];
			
			$data['datonombrecategoria']     =   html_entity_decode($datosRefrendacion[0]['nombrecategoria']);
			$data['datonombreorganismo']     =   html_entity_decode($datosRefrendacion[0]['nombreorganismo']);
			$data['datofechavencimiento']     =   $this->funciones->convertirFormatoFecha($datosRefrendacion[0]['fechavencimiento'],'aaaa-mm-dd','dd/mm/aaaa');
			
			
			//$data['datofechavencimiento']        =   $datosRefrendacion[0]['fechavencimiento'];
			$data['datonumerosoat']        =   $datosRefrendacion[0]['numerosoat'];
			$data['datosoat_fechafinal']        =   $this->funciones->convertirFormatoFecha($datosRefrendacion[0]['soat_fechafinal'],'aaaa-mm-dd','dd/mm/aaaa');
			
			// se consultan los tipos de documentos 
			$consultaTipodocumentos = $this->db->query('SELECT abreviatura FROM tipodocumento WHERE idtipodocumento="'.$datoidtipodocumento.'" ');
			foreach ($consultaTipodocumentos->result_array() as $filaTipodocumento)
			{
				$arrayTipodocumentos[]=$filaTipodocumento;
			}
			$consultaTipodocumentos->free_result();
			$data['tipodocumento']=$arrayTipodocumentos[0]['abreviatura'];
			///
			// se consultan los tipos de documentos 
			$consultaMeses = $this->db->query('SELECT * FROM meses');
			foreach ($consultaMeses->result_array() as $filaMeses)
			{
				$arrayMeses[$filaMeses['idmeses']]=$filaMeses['nombremeses'];
			}
			$consultaMeses->free_result();
			$data['meses']=$arrayMeses;
			
		}
		$nombrearchivo="Tarjeta_de_control_".$data['datoplaca']."_".date('YmdHis').".pdf";
		$html=$this->load->view("imprimir/tarjetacontrol_imp_view",$data, true);
		generar_pdf($html, $nombrearchivo);
    }

}
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/tarjetacontrol.php */