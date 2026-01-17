<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Esta clase es la encargada de crear los botones para los formularios que se utilicen en la
* aplicacion. Aparte de pintar los botones, tambien los valida deacuerdo a los permisos que tenga el usuario
* actualmente registrado. 
*
* @package     CodeIgniter
* @subpackage  Libraries
* @category    
* @author      Jorge Serrano
* @link        
*/
class Botoneria {
    
		var $modificar; //Variable que almacenar le valor del permiso de modificar
		var $consultar; //Variable que almacenar le valor del permiso de consultar
        var $eliminar; //Variable que almacenar le valor del permiso de eliminar
		var $visualizarmodificar = false; //Variable que me indica si visualizo o no los botones de modificacion de acuerdo a los permisos
		var $visualizarconsultar = false; //Variable que me indica si visualizo o no los botones de consulta de acuerdo a los permisos
        var $visualizareliminar  = false; //Variable que me indica si visualizo o no los botones de eliminacion de acuerdo a los permisos
		var $visualizarimprimir  = false; //Variable que me indica si visualizo o no los botones de impresion de acuerdo a los permisos

		/*
		botoneria($modificar,$consultar) : Funcion construcutora de la clase que recibe los
		valores de los permisos y deacuerdo a estos modifica las variable de visualizacion.
		ENTRADA
		$modificar  :  Variable que almacena el valor del permiso para modificar
		$consultar  :  Variable que almacena el valor del permiso para consultar
		*/
        public function __construct($parametros = NULL)
		//function botoneria($modificar,$consultar)
		{ //echo"entro";
        //print_r($parametros);
        /*
			echo $this->modificar=$parametros['modificar'];
			echo $this->consultar=$parametros['consultar'];
            echo $this->eliminar=$parametros['eliminar'];
          */  
			if($parametros['modificar'] ==1)
				$this->visualizarmodificar = true;
                
			if($parametros['consultar'] ==1)
				$this->visualizarconsultar = true;
                
			if($parametros['eliminar'] ==1)
				$this->visualizareliminar = true;
				
			if($parametros['imprimir'] ==1)
				$this->visualizarimprimir = true;
                
		}//end function botoneria

        /**
        * Funci�n se se encarga de visualizar los botones en los formularios principales de datos.
        * Solo muestra los botones habilitados de acuerdo a los permisos del usuario actual.
        * 
        * @param integer $existeinformacion
        * @param string $jsguardar
        * @param string $jsbuscar
        * @param string $jseliminar
        * @return html
        */
		function visualizaBotoneria($existeinformacion=0,$jsguardar="",$jsbuscar="",$jseliminar="",$imprimir="")
		{ //echo"entro";
            $html='';
			if($existeinformacion==1)
			{
                $nombreGuardar='Modificar';
			}
			else
			{
    			$nombreGuardar='Guardar';
			}
            
            if($this->visualizarmodificar)
    			$html.=' <button class="btn btn-primary" type="submit" id="Guardar" title="Guardar" name="Guardar" onclick="'.$jsguardar.'" >'.$nombreGuardar.'</button>';
                
            if($this->visualizarconsultar && !(empty($jsbuscar)))
    			$html.=' <button class="btn btn-primary" type="button" id="Buscar" title="Buscar" name="Buscar" data-url="" onclick="'.$jsbuscar.'" >Buscar</button>';
                
            if($this->visualizareliminar && $existeinformacion == 1 && !(empty($jseliminar)))
    			$html.=' <button class="btn btn-primary" type="button" id="Eliminar" title="Eliminar" name="Eliminar" onclick="'.$jseliminar.'" >Eliminar</button>';

            if($this->visualizarimprimir)
    			$html.=' <button class="btn btn-primary" type="submit" id="Imprimir" title="Imprimir" name="Imprimir" >Imprimir</button>';
            
            return $html;
		}
        /**
        * Funci�n se se encarga de visualizar los botones en los formularios principales de datos.
        * Solo muestra los botones habilitados de acuerdo a los permisos del usuario actual.
        * 
        * @param integer $existeinformacion
        * @param string $jsguardar
        * @param string $jsbuscar
        * @param string $jseliminar
        * @return html
        */
		function visualizaBotoneria_2($existeinformacion=0,$arrayParametros)
		{
            $html='';
			if($existeinformacion==1)
			{
                $nombreGuardar='Modificar';
			}
			else
			{
    			$nombreGuardar='Guardar';
			}
            
            if($this->visualizarmodificar)
    			$html.=' <button class="btn btn-primary" type="submit" id="Guardar" title="Guardar" name="Guardar" onclick="'.$jsguardar.'" >'.$nombreGuardar.'</button>';
                
            if( $this->visualizarconsultar ){
    			$html.=' <button class="btn btn-primary btnConsultar" type="button" id="consultar" title="Consultar" name="Consultar" data-url="'.site_url($arrayParametros['consultar']['url']).'" data-titulo="'.$arrayParametros['consultar']['titulo'].'" data-divbusqueda="'.$arrayParametros['consultar']['divbusqueda'].'"  >Consultar</button>';
			}
            if($this->visualizareliminar && $existeinformacion == 1 && !(empty($jseliminar)))
    			$html.=' <button class="btn btn-primary" type="button" id="Eliminar" title="Eliminar" name="Eliminar" onclick="'.$jseliminar.'" >Eliminar</button>';

            if($this->visualizarimprimir)
    			$html.=' <button class="btn btn-primary" type="submit" id="Imprimir" title="Imprimir" name="Imprimir" >Imprimir</button>';
            
            return $html;
		}

		/*
		visualizaBotoneriaDetalle($jsguardar="",$DeshabilitarRegistroInactivo="")
		Funci�n se se encarga de visualizar los botones en los formularios de detalles de datos.
		Solo muestrael boton guardar y lo visualiza unicamente si existen permisos de modificar.
		ENTRADA
		$jsguardar: Variable almacena las funciones javascript que lleva el boton Guardar en el Onclick
		$DeshabilitarRegistroInactivo: Variable que sirve de bandera para indicar si se debe deshabiliar 
			el boton en caso de que el formulario ya se encuentre restringido para modificaciones
		*/
		function visualizaBotoneriaDetalle($jsguardar="",$DeshabilitarRegistroInactivo="")
		{
			echo '
			<input '.$this->visualizarmodificar.'  style="cursor:pointer" type="button" title="Guardar" id="Guardar" name="Guardar" value="Guardar" onclick="'.$jsguardar.'" '.$DeshabilitarRegistroInactivo.' />
			';
		}

		/*
		visualizaBotoneriaParametros($jsguardar="",$jsbuscar="")
		Funci�n se se encarga de visualizar los botones en los formularios de parametrizacion de la aplicaion.
		Solo muestra los botones guardar y buscar y los visualiza de acuerdo a los permisos que tenga el usuario.
		ENTRADA
		$jsguardar: Variable almacena las funciones javascript que lleva el boton Guardar en el Onclick
		$jsbuscar:  Variable almacena las funciones javascript que lleva el boton Buscar en el Onclick
		*/
		function visualizaBotoneriaParametros($jsguardar="",$jsbuscar="",$ConsecutivoId="")
		{
			echo '<input '.$this->visualizarmodificar.' style="cursor:pointer" type="button" title="Guardar" id="Guardar" value="Guardar" onclick="'.$jsguardar.'" />';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			if($jsbuscar!="")
				echo '<input '.$this->visualizarconsultar.' style="cursor:pointer" type="button" title="Buscar" id="Buscar" name="Buscar" value="Buscar" onclick="'.$jsbuscar.'" />';
		}
        
        function prueba()
        {
            echo "esto es una prueba";
        } 
}//end clase botoneria
?>