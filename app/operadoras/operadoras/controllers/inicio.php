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
		$this->load->library('funciones');
		$this->load->library('mailer');
		$this->load->helper('email');
		$this->load->library('tabla');
	}

	public function index($salida='')
	{
		if(!empty($salida))
		{
			$this->session->destroy();
		}
		//$this->load->database();

		$data['vista_contenido']="inicio_view";
        // se consultan las empresas
		$arrayEmpresas=$this->funciones->consEmpresa();
		$empresas['0']='Selecione Empresa';
		foreach ($arrayEmpresas as $fila)
		{
			$empresas[$fila['idempresa']]=$fila['nombreempresa'];
		}
		$data['empresas']=$empresas;
		$data['inicio']=site_url("inicio/index");
		$this->load->view('include/plantilla1',$data);
	}
	public function registro($nitempresa){
		$data['vista_contenido']="registro_view";
		$data['nitempresa']=$nitempresa;
		$data['inicio']=site_url("inicio/index");
		$this->load->view('include/plantilla1',$data);
	}
	public function guardar_registro(){
		//se setea la tabla a modificar
        $this->tabla->settabla('empresa');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		
        if (valid_email($this->input->post('email')))
        {
	        if($arraypost["registrar"]=="registrar")
	        {
	        	//$token = strtolower(md5(sha1($arraypost['nitempresa'])));
	        	
	        	$idempresa = $this->tabla->MaximoDato("idempresa") + 1;
	        	$campos['idempresa'] = $idempresa;
		        $campos['nitempresa']=   $arraypost['nitempresa'];
		        $campos['nombreempresa']     =   $arraypost['empresa'];
		        $campos['emailempresa']    =   $arraypost['email'];
	        	$this->tabla->agregarDatosMinus($campos);
				
				$this->tabla->settabla('registrodemo');
				unset($campos);
				$token = strtolower(md5(sha1($arraypost['nitempresa'].date("YmdHis"))));
		        $campos['idempresa']=   $idempresa;
		        $campos['token']     = $token;
				$this->tabla->agregarDatosMinus($campos);
				

				$mail = new PHPMailer();
				$mail->SMTPDebug = 1;
				$mail->IsSMTP();  // telling the class to use SMTP
				$mail->IsHTML(true);
				$mail->SMTPAuth   = true;                // enable SMTP authentication
				$mail->SMTPSecure ="ssl";
				$mail->Port       = 465;                  // set the SMTP port
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->Username   = "info@jossof.com"; // SMTP account username
				$mail->Password   = "juan26saian";     // SMTP account password
				$mail->From = "info@jossof.com"; // email a enviar el mensaje
				//$mail->FromName = $arraypost['empresa']." desde Sigitrans";
				$mail->FromName = "Sigitrans - Jossof"; //quien remite
				$mail->Subject = " Registro en Sigitrans";
				$mail->AddAddress($arraypost['email']);
				//$mail->AddBCC("jorge_software2005@hotmail.com");
				
				$mensaje = "Bienvenido a SIGITRANS para activar su cuenta por favor haga click en activar cuenta 
							<a href='".site_url('inicio/activarcuenta/'.$token)."'>activar cuenta </a><br/ >";
				
				$mail->Body = wordwrap($mensaje , 100);
				if(!$mail->Send())
				{
					$msg = "No se pudo enviar. ";
					$msg .="Mailer Error: " . $mail->ErrorInfo;
					$mail->ClearAllRecipients ();
					$mail->ClearReplyTos ();
				}
				else
				{
					$msg ="Un E-Mail ha sido enviado a ".$arraypost['email'].", por favor revise su bandeja de entrada o spam.";
				}
				unset($mail);
				unset($mensaje);
				$mail = new PHPMailer();
				$mail->SMTPDebug = 1;
				$mail->IsSMTP();  // telling the class to use SMTP
				$mail->IsHTML(true);
				$mail->SMTPAuth   = true;                // enable SMTP authentication
				$mail->SMTPSecure ="ssl";
				$mail->Port       = 465;                  // set the SMTP port
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->Username   = "info@jossof.com"; // SMTP account username
				$mail->Password   = "juan26saian";     // SMTP account password
				$mail->From = "info@jossof.com"; // email a enviar el mensaje
				$mail->FromName = "Sigitrans - Jossof"; //quien remite
				$mail->Subject = $arraypost['empresa']." se registro en Sigitrans";
				$mail->AddAddress("jorge_software2005@hotmail.com");
				
				$mensaje = "Bienvenido a SIGITRANS para activar su cuenta por favor haga click en activar cuenta 
							<a href='".site_url('inicio/activarcuenta/'.$token)."'>activar cuenta </a><br/ >";
				$mensaje .= "<br/ > Nombre: ".$arraypost['empresa'];
				$mensaje .= "<br/ > Email: ".$arraypost['email'];

				$mail->Body = wordwrap($mensaje , 100);
				if(!$mail->Send())
				{
					$msg_ = "No se pudo enviar. ";
					$msg_ .="Mailer Error: " . $mail->ErrorInfo;
					$mail->ClearAllRecipients ();
					$mail->ClearReplyTos ();
				}
				else
				{
					$msg_ ="Un E-Mail ha sido enviado a ".$arraypost['email'].", por favor revise su bandeja de entrada o spam.";
				}

			}
		}
        else
        {
			$msg="La cuenta de E-Mail, no es valida.";
            //echo 'El email no es válido.';
        }
		$data['vista_contenido']="registro_view";
		$data['msg']=$msg;
		$data['inicio']=site_url("inicio/index");
		$this->load->view('include/plantilla1',$data);
	}
	public function activarcuenta($token){
		//se setea la tabla a modificar
        $this->tabla->settabla('registrodemo');
        $cond = array('token' => $token, 'utilizado' => 0 );
        $arrayToken=$this->tabla->consultarDatos('*',$cond);
		if(!empty($arrayToken)){
			//se actualiza el registro en la tabla registrodemo
			$campos['utilizado']  = 1;
            $condicion = array('id' => $arrayToken[0]['id']);
            $this->tabla->actualizarDatosMinus($campos,$condicion);
			
			//se inserta el registro en la tabla empresa
			unset($campos);unset($condicion);
			$this->tabla->settabla('empresa');			
			$campos['activo']  = 1;
            $condicion = array('idempresa' => $arrayToken[0]['idempresa']);
            $this->tabla->actualizarDatosMinus($campos,$condicion);
            
			//se consulta los datos de la empresa
	        $condE = array('idempresa' => $arrayToken[0]['idempresa'] );
	        $arrayEmpresa=$this->tabla->consultarDatos('*',$condE);
			
			//se crea el usuario para esa empresa
			unset($campos);unset($condicion);
			$this->tabla->settabla('usuario');			
			$campos['loginusuario']  = "prueba";
			$campos['contrasena']  = sha1(md5("prueba")); 
			$campos['nombreusuario']  = "Usuario de prueba";
			$campos['idperfilusuario']  = 4;
			$campos['activo']  = 1;
			$campos['idempresa']  = $arrayEmpresa[0]['idempresa'];
			$this->tabla->agregarDatosMinus($campos);
			
			//se crean los permisos sobre los modulos para esa empresa
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 5, "modificar"=> 1, "consultar"=> 0, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 6, "modificar"=> 1, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 7, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 8, "modificar"=> 1, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 9, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 14, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 15, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 16, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 17, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 18, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 19, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 20, "modificar"=> 1, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 21, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			$arrayperfilsubmodulo[]=array("idsubmodulo"=> 22, "modificar"=> 0, "consultar"=> 1, "eliminar"=> 0, "imprimir"=> 0);
			unset($campos);unset($condicion);
			$this->tabla->settabla('perfilsubmodulo');			
						
			foreach ($arrayperfilsubmodulo as $campos) {
				$campos["idperfilusuario"]=4;
				$campos["idempresa"]=$arrayEmpresa[0]['idempresa'];
				$this->tabla->agregarDatosMinus($campos);
				unset($campos);
			}
			
			//se envia un correo con los datos de ingreso a la plaaforma
			$mail = new PHPMailer();
			$mail->SMTPDebug = 1;
			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->IsHTML(true);
			$mail->SMTPAuth   = true;                // enable SMTP authentication
			$mail->SMTPSecure ="ssl";
			$mail->Port       = 465;                  // set the SMTP port
			$mail->Host       = "smtp.gmail.com"; // SMTP server
			$mail->Username   = "info@jossof.com"; // SMTP account username
			$mail->Password   = "juan26saian";     // SMTP account password
			$mail->From = "info@jossof.com"; // email a enviar el mensaje
			$mail->FromName = "Sigitrans - Jossof"; //quien remite
			$mail->Subject = " Activacion de cuenta exitoso en Sigitrans";
			$mail->AddAddress($arrayEmpresa[0]['emailempresa']);
			
			$mensaje = "Activacion de cuenta exitoso en SIGITRANS <br /><br />";
			$mensaje.= "DATOS DE INGRESO <br /><br />";
			$mensaje.= "<br/ > Url: ".site_url();
			$mensaje.= "<br/ > Usuario: prueba";
			$mensaje.= "<br/ > Contraseña: prueba";
			$mensaje.= "<br/ > NIT Empresa: ".$arrayEmpresa[0]['nitempresa'];
			
			
			$mail->Body = wordwrap($mensaje , 100);
			if(!$mail->Send())
			{
				$msg = "No se pudo enviar. ";
				$msg .="Mailer Error: " . $mail->ErrorInfo;
				$mail->ClearAllRecipients ();
				$mail->ClearReplyTos ();
			}
			else
			{
				$msg ="Un E-Mail ha sido enviado a ".$arrayEmpresa[0]['emailempresa'].", con los datos de ingreso a Sigitrans.";
			}

                        
            $mensaje="Cuenta activada con exito.";
		}
		else{
			$mensaje="No se pudo activar la cuenta.";
		}
		$data['vista_contenido']="inicio_view";
		$data['msg_activacion']=$mensaje;
		$data['msg_email']=$msg;
		$data['inicio']=site_url("inicio/index");
		$this->load->view('include/plantilla1',$data);
	}



	public function salida()
	{
		$this->session->destroy();
		redirect('/modulos/inicio/', 'refresh');
	}

}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */