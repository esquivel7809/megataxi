<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Menu Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Menu
 * @author		Jorge serrano
 * @link		
 */

class Menu{
    
        public $idmodulo=0;
        public $idsubmodulo=0;
        public $nombremodulo='';
        public $nombresubmodulo='';
        public $idperfilusuario=0;
        public $CI='';

	public function __construct($config= array())
	{ //print_r($config);
            $this->CI =& get_instance();
            $this->CI->load->model('Menu_model');
            
            if (count($config) > 0)
            {
                    $this->initialize($config);
            }
	}

	public function initialize($config = array())
	{
            $defaults = array(
                'idperfilusuario'			=> 0
            );

            foreach ($defaults as $key => $val)
            {
                    if (isset($config[$key]))
                    {
                            $this->$key = $config[$key];
                    }
                    else
                    {
                            $this->$key = $val;
                    }
            }
        }


        public function menuModulosHTML5($moduloactual=0)
        {
            $menu=$this->CI->Menu_model->listarModulos();
            $modulo="";
			$modulo.="<ul class='nav main'>";
			$modulo.="<li><a href='".$onclickinicio."'><b>inicio</b></a></li>";
            if(!empty($menu))
            {
                $onclickinicio=site_url("modulos/inicio");
                foreach($menu as $modulos)
                {
                    $modulo.="<li><a href='#'>".html_entity_decode($modulos['nombremodulo'])."</a>";
                    $modulo.=$this->menuSubmodulosHTML5_($modulos['idmodulo'],$modulos['carpetamodulo']);
                    $modulo.="</li>";
                    next($menu);
                }
            }
			$onclicksalir=site_url("inicio/index/salida");
			$modulo.="<li><a href='".$onclicksalir."' onclick=''><b>salir</b></a></li>";
			$modulo.="</ul>";

            return $modulo;
        }
        public function menuSubmodulosHTML5($idmodulo,$carpetamodulo)
        {
            $menu=$this->CI->Menu_model->listarSubmodulos($idmodulo);
            $submodulo="";
            if(!empty($menu))
            {
                $submodulo.="<div class='dropdown'><ul>";
                foreach($menu as $modulos)
                {
                    $controlador = substr($modulos['urlsubmodulo'], -4, 4) == '.php' ? substr($modulos['urlsubmodulo'], 0, -4) : $modulos['urlsubmodulo'];
                    $onclick=site_url($carpetamodulo.'/'.$controlador);
                    //$onclick='abrirAjax("contenido", "'.$carpetamodulo.'/'.$modulos['urlsubmodulo'].'","idsubmoduloactual='.$modulos['idsubmodulo'].'&mod='.$idmodulo.'&cp='.$carpetamodulo.'","1")';
                    //$submodulo.="<li class='meta-links'><a href='#' onclick='abrirAjax('contenido','".URL_MODULOS_PATH."".$carpetamodulo."/".$modulos['urlsubmodulo']."','idsubmoduloactual=".$modulos['idsubmodulo']."&mod=".$idmodulo."&cp=".$carpetamodulo."','1');' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
                    $submodulo.="<li class='meta-links'><a href='".$onclick."' onclick='' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
                    next($menu);
                }
                $submodulo.="</ul></div>";
            }
            return $submodulo;
        }
        public function menuSubmodulosHTML5_($idmodulo,$carpetamodulo)
        {
            $menu=$this->CI->Menu_model->listarSubmodulos($idmodulo);
            $submodulo="";
            if(!empty($menu))
            {
                $submodulo.="<div class='dropdown'><ul>";
                foreach($menu as $modulos)
                {
                    $controlador = substr($modulos['urlsubmodulo'], -4, 4) == '.php' ? substr($modulos['urlsubmodulo'], 0, -4) : $modulos['urlsubmodulo'];
                    //$onclick=site_url('index.php/'.$carpetamodulo.'/'.$controlador.'');
                    //$onclick='abrirAjax("#contenido", "'.$carpetamodulo.'/'.$controlador.'","idsubmoduloactual='.$modulos['idsubmodulo'].'&mod='.$idmodulo.'")';
                    $onclick='abrirAjax("#contenido", "'.site_url($carpetamodulo.'/'.$controlador).'","idsubmoduloactual='.$modulos['idsubmodulo'].'&mod='.$idmodulo.'")';
                    //$submodulo.="<li class='meta-links'><a href='#' onclick='abrirAjax('contenido','".URL_MODULOS_PATH."".$carpetamodulo."/".$modulos['urlsubmodulo']."','idsubmoduloactual=".$modulos['idsubmodulo']."&mod=".$idmodulo."&cp=".$carpetamodulo."','1');' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
                    $submodulo.="<li class='meta-links'><a href='#' onclick='".$onclick."' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
                    next($menu);
                }
                $submodulo.="</ul></div>";
            }
            return $submodulo;
        }


}
// END Menu Class

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */
