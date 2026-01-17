<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
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
			$this->load->library('tabla');
			$this->load->model('Usuario');
	        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
			$this->idempresa=getIdempresaactual();
			$this->idsubmoduloactual=$this->arrayRequest['idsubmoduloactual'];
			/*
            if(empty($this->idsubmoduloactual) && !isset($this->arrayRequest['idgarantia']))
            {
                terminar_session();
            }
			 * */
        }

        //$this->load->model('Usuario');
		//$this->load->model('Informes_model');
    }
	public function index()
	{
        //$login=$this->session->userdata('loginusuarioactual');
		//$idempresa=$this->session->userdata('idempresaactual');
        
        //if(!empty($login))
        //{
            $this->load->library('menu',array('idperfil'=>'getIdperfilactual()'));
            
            $data['vista_contenido_mod']=array("modulos/modulo_view");
            $data['menu']=$this->menu->menuModulosHTML5();
			$data['menuH']=$this->menu->menuModulosHorizontalHTML5();
			
            
            $datosempresa=$this->Usuario->datosEmpresa($this->idempresa);
            $data['nombreempresa']=$datosempresa['nombreempresa'];
            $data['nitempresa']=$datosempresa['nitempresa'];
            $data['direccionempresa']=$datosempresa['direccionempresa'];
            $data['telefonoempresa']=$datosempresa['telefonoempresa'];
            $data['rutalogo']=$datosempresa['rutalogo'];
			
			/*
			//se consultan los vencimientos de SOAT
			$soat_vencido=false;
            $html_soat.="<li class='active'>
				<h3>SOAT</h3>
				<div class='panel loading'>";
			//SOAT vencidos
			$datos_venc_soat=$this->Informes_model->cons_venc_soat(1);
			//si hay resultados se muestran
			if($datos_venc_soat->num_rows()>0){
				$html_soat.="<h4>Vencidos</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_soat->result_array() as $fila)
				{
					$html_soat.="<li>".$fila['placa']." - ".$fila['numerosoat']."</li>";
				}
				$datos_venc_soat->free_result();
				$html_soat.="</ul>";
				$soat_vencido=true;
			}
			//SOAT que vencen hoy
			$datos_venc_soat_hoy=$this->Informes_model->cons_venc_soat(2);
			//si hay resultados se muestran
			if($datos_venc_soat_hoy->num_rows()>0){
				$html_soat.="<h4>Vencen hoy</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_soat_hoy->result_array() as $fila)
				{
					$html_soat.="<li>".$fila['placa']." - ".$fila['numerosoat']."</li>";
				}
				$datos_venc_soat_hoy->free_result();
				$html_soat.="</ul>";
				$soat_vencido=true;
			}
			//SOAT que vencen mañana
			$datos_venc_soat_mañana=$this->Informes_model->cons_venc_soat(3);
			//si hay resultados se muestran
			if($datos_venc_soat_mañana->num_rows()>0){
				$html_soat.="<h4>Vencen mañana</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_soat_mañana->result_array() as $fila)
				{
					$html_soat.="<li>".$fila['placa']." - ".$fila['numerosoat']."</li>";
				}
				$datos_venc_soat_mañana->free_result();
				$html_soat.="</ul>";
				$soat_vencido=true;
			}
			if(!$soat_vencido){
				$html_soat.="<h4>No hay SOAT vencidos.</h4>";
			}
			$html_soat.="</div></li>";
			
			$data['html_venc_soat']=$html_soat;
			//fin consultan los vencimientos de SOAT
			
			//se consultan los vencimientos de las revisiones
			$revision_vencido=false;
            $html_revision.="<li class='active'>
				<h3>Revisión Tecnico-Mecanica</h3>
				<div class='panel loading'>";
			//Revisiones vencidas
			$datos_venc_revision=$this->Informes_model->cons_venc_revision(1);
			//si hay resultados se muestran
			if($datos_venc_revision->num_rows()>0){
				$html_revision.="<h4>Vencidas</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_revision->result_array() as $fila)
				{
					$html_revision.="<li>".$fila['placa']." - ".$fila['numerorevision']."</li>";
				}
				$datos_venc_revision->free_result();

				$html_revision.="</ul>";
				$revision_vencido=true;
			}
			//Revisiones que vencen hoy
			$datos_venc_revision_hoy=$this->Informes_model->cons_venc_revision(2);
			//si hay resultados se muestran
			if($datos_venc_revision_hoy->num_rows()>0){
				$html_revision.="<h4>Vencen hoy</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_revision_hoy->result_array() as $fila)
				{
					$html_revision.="<li>".$fila['placa']." - ".$fila['numerorevision']."</li>";
				}
				$datos_venc_revision_hoy->free_result();
				$html_revision.="</ul>";
				$revision_vencido=true;
			}
			//Revisiones que vencen mañana
			$datos_venc_revision_mañana=$this->Informes_model->cons_venc_revision(3);
			//si hay resultados se muestran
			if($datos_venc_revision_mañana->num_rows()>0){
				$html_revision.="<h4>Vencen mañana</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_revision_mañana->result_array() as $fila)
				{
					$html_revision.="<li>".$fila['placa']." - ".$fila['numerorevision']."</li>";
				}
				$datos_venc_revision_mañana->free_result();
				$html_revision.="</ul>";
				$revision_vencido=true;
			}
			if(!$revision_vencido){
				$html_revision.="<h4>No hay Revisiones vencidas.</h4>";
			}
			
			$html_revision.="</div></li>";
			
			$data['html_venc_revision']=$html_revision;
			//fin consultan los vencimientos de revisiones
			//se consultan los vencimientos de las licencias
			$licencia_vencida=false;
            $html_licencia.="<li class='active'>
				<h3>Licencia de Conduccíon</h3>
				<div class='panel loading'>";
			//Licencias vencidas
			$datos_venc_licencia=$this->Informes_model->cons_venc_licencia(1);
			//si hay resultados se muestran
			if($datos_venc_licencia->num_rows()>0){
				$html_licencia.="<h4>Vencidas</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_licencia->result_array() as $fila)
				{
					$html_licencia.="<li title='".$fila['nombrecompleto']."'>".$fila['abreviatura']." ".$fila['numerodocumento']." - ".$fila['numerolicenciaconductor']."</li>";
				}
				$datos_venc_licencia->free_result();
				$html_licencia.="</ul>";
				$licencia_vencida=true;
			}
			//Licencias que vencen hoy
			$datos_venc_licencia_hoy=$this->Informes_model->cons_venc_licencia(2);
			//si hay resultados se muestran
			if($datos_venc_licencia_hoy->num_rows()>0){
				$html_licencia.="<h4>Vencen hoy</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_licencia_hoy->result_array() as $fila)
				{
					$html_licencia.="<li title='".$fila['nombrecompleto']."'>".$fila['abreviatura']." ".$fila['numerodocumento']." - ".$fila['numerolicenciaconductor']."</li>";
				}
				$datos_venc_licencia_hoy->free_result();
				$html_licencia.="</ul>";
				$licencia_vencida=true;
			}
			//Licencias que vencen mañana
			$datos_venc_licencia_mañana=$this->Informes_model->cons_venc_licencia(3);
			//si hay resultados se muestran
			if($datos_venc_licencia_mañana->num_rows()>0){
				$html_licencia.="<h4>Vencen mañana</h4>
				<ul class='panel loading'>";
				foreach ($datos_venc_licencia_mañana->result_array() as $fila)
				{
					$html_licencia.="<li title='".$fila['nombrecompleto']."'>".$fila['abreviatura']." ".$fila['placa']." - ".$fila['numerorevision']."</li>";
				}
				$datos_venc_licencia_mañana->free_result();
				$html_licencia.="</ul>";
				$licencia_vencida=true;
			}
			if(!$licencia_vencida){
				$html_licencia.="<h4>No hay Licencias vencidas.</h4>";
			}
			
			//$html_licencia.="</div></li>";
			
			$data['html_venc_licencia']=$html_licencia;
			//fin consultan los vencimientos de revisiones
			*/
			//cargamos la vista final
            $this->load->view('include/plantilla2',$data);
        }
/**
        else
        {
            $this->session->destroy();
			redirect('inicio/', 'refresh');
        }
 
    }
 * **/
}
/* End of file inicio.php */
/* Location: ./application/controllers/modulos/inicio.php */