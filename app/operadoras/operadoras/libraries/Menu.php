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
			$onclickinicio=site_url("modulos/inicio");
			$modulo.="<ul class='nav' id='side-menu'>";
			$modulo.="<li class='sidebar-search'>
				    <div class='input-group custom-search-form'>
				        <input type='text' class='form-control' placeholder='Busqueda...'>
				        <span class='input-group-btn'>
				            <button class='btn btn-default' type='button'>
				                <i class='fa fa-search'></i>
				            </button>
				        </span>
				    </div>
				</li>
				<li>
				    <a href='".$onclickinicio."'><i class='fa fa-dashboard fa-fw'></i> Dashboard</a>
				</li>";
            if(!empty($menu))
            {
                foreach($menu as $modulos)
                {
                    $modulo.="<li><a href='#'><i class='fa fa-bar-chart-o fa-fw'></i> ".html_entity_decode($modulos['nombremodulo'])."<span class='fa arrow'></span></a>";
                    $modulo.=$this->menuSubmodulosHTML5($modulos['idmodulo'],$modulos['carpetamodulo']);
                    $modulo.="</li>";
                    next($menu);
                }
            }
			$modulo.="</ul>";
            return $modulo;
        }
        public function menuSubmodulosHTML5($idmodulo,$carpetamodulo)
        {
            $menu=$this->CI->Menu_model->listarSubmodulos($idmodulo);
            $submodulo="";
            if(!empty($menu))
            {
                $submodulo.="<ul class='nav nav-second-level'>";
                foreach($menu as $modulos)
                {
                    $controlador = substr($modulos['urlsubmodulo'], -4, 4) == '.php' ? substr($modulos['urlsubmodulo'], 0, -4) : $modulos['urlsubmodulo'];
					$url = $carpetamodulo."/".$controlador;
					$submodulo.="<li><a href='#' class='abrirAjax' data-id='content' data-url='".$url."' data-mod='".$idmodulo."' data-sub='".$modulos['idsubmodulo']."' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
                    next($menu);
                }
                $submodulo.="</ul>";
            }
            return $submodulo;
        }


        public function menuModulosHorizontalHTML5($moduloactual=0)
        {
            $menu=$this->CI->Menu_model->listarModulos();
            $modulo="";
			$onclickinicio=site_url("modulos/inicio");
			$modulo.="<ul class='nav navbar-top-links navbar-left' id='side-menu'>";
			/*$modulo.="<li class='sidebar-search'>
				    <div class='input-group custom-search-form'>
				        <input type='text' class='form-control' placeholder='Busqueda...'>
				        <span class='input-group-btn'>
				            <button class='btn btn-default' type='button'>
				                <i class='fa fa-search'></i>
				            </button>
				        </span>
				    </div>
				</li>
				<li>
				    <a href='".$onclickinicio."'><i class='fa fa-dashboard fa-fw'></i> Dashboard</a>
				</li>";*/
			
            if(!empty($menu))
            {
                foreach($menu as $modulos)
                {
                    //$modulo.="<li><a href='#'><i class='fa fa-bar-chart-o fa-fw'></i> ".html_entity_decode($modulos['nombremodulo'])."<span class='fa arrow'></span></a>";
                    
                    $modulo.=$this->menuSubmodulosHorizontalHTML5($modulos['idmodulo'],$modulos['carpetamodulo']);
					
                    //$modulo.="</li>";
                    next($menu);
                }
            }
			$modulo.="</ul>";
            return $modulo;
        }
        public function menuSubmodulosHorizontalHTML5($idmodulo,$carpetamodulo)
        {
            $menu=$this->CI->Menu_model->listarSubmodulos($idmodulo);
            $submodulo="";
            if(!empty($menu))
            {
                //$submodulo.="<ul class='nav nav-second-level'>";
                foreach($menu as $modulos)
                {
                    $controlador = substr($modulos['urlsubmodulo'], -4, 4) == '.php' ? substr($modulos['urlsubmodulo'], 0, -4) : $modulos['urlsubmodulo'];
					$url = $carpetamodulo."/".$controlador;
					$submodulo.="<li><a href='".site_url($url)."'><i class='fa fa-user fa-fw'></i>";
					$submodulo.=html_entity_decode($modulos['nombresubmodulo']);
					//$submodulo.="<li><a href='#' class='abrirAjax' data-id='content' data-url='".$url."' data-mod='".$idmodulo."' data-sub='".$modulos['idsubmodulo']."' >".html_entity_decode($modulos['nombresubmodulo'])."</a></li>";
					$submodulo.="</a></li>";
                    next($menu);
                }
                //$submodulo.="</ul>";
            }
            return $submodulo;
        }


}
// END Menu Class

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */
