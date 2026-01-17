<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Funciones {
/**********************************************************************************/    
	public function __construct()
	{
        $this->CI =& get_instance();
        $this->CI->load->library('tabla');
		$this->idempresa=$this->CI->session->userdata('idempresaactual');
        //$this->CI->load->database();
	}
    
	function eliminarblancos($cadena)
	{
		$cadena = stripslashes($cadena);
		$cadena = trim($cadena);
		$cadena = preg_replace('/\s(?=\s)/', '', $cadena);
		$cadena = addslashes($cadena);
		//$cadena = htmlentities($cadena);
		return $cadena;
	}
    
	//Funcion que...
	function crearCombo($ListaDatos,$ValorCombo,$NombreValor,$NombreMostrar)
	{
	   $html="";
		$html='<option value="0">Seleccione...</option>';
		if(!empty($ListaDatos))
		{
			foreach($ListaDatos as $Dato)
			{
				if(!empty($Dato['pordefecto']))
				{
					if($ValorCombo!="")
					{
						if($Dato[$NombreValor]==$ValorCombo)
							$html.= '<option selected value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
						else
							$html.= '<option value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
					}
					else
					{
						if($Dato['pordefecto']=="1")
							$html.= '<option selected value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
						else
							$html.= '<option value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
					}
				}
				else
				{
					if($Dato[$NombreValor]==$ValorCombo)
						$html.= '<option selected value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
					else
						$html.= '<option value="'.$this->eliminarblancos($Dato[$NombreValor]).'">'.html_entity_decode($Dato[$NombreMostrar]).'</option>';
				}
				next($ListaDatos);
			}
		}
        return $html;
	}
    public function convRequest($arrayRequest)
    { //print_r($arrayRequest)."< /br>";
        foreach($arrayRequest as $Variable => $Valor)
        {
        	$Cadena[$Variable] = $this->eliminarblancos($Valor);
        	${$Variable} = $this->eliminarblancos($Valor);
            //echo"</br>".$Variable." ".$Valor;
        }
        if(!empty($mod))
        	$_SESSION['idmoduloactual']=$mod;
        if(!empty($idsubmoduloactual))
        	$_SESSION['idsubmoduloactual']=$idsubmoduloactual;
        
        return $Cadena;
    }
    
	function crearComboTabla($nombreTabla,$valorActual="")
	{
	   $html="";
        //global $db,$tabla;
        $$nombreTabla=$this->CI->tabla($nombreTabla);
        $lista=$$nombreTabla->consultarDatos('id'.$nombreTabla.',nombre'.$nombreTabla,'','nombre'.$nombreTabla.' ASC');
        $html=$this->crearCombo($lista,$valorActual,'id'.$nombreTabla,'nombre'.$nombreTabla);
        return $html;
	}
    
	function nombreDato($nombretabla,$campoid,$camponombre,$valorid)
	{
		//global $tabla;
		//$$nombretabla=new tabla($nombretabla);
        $this->CI->tabla->settabla($nombretabla);
		if(!empty($campoid))
		{
			$i=0;
			foreach($campoid as $dato)
			{
				$Condicion[$dato]=$valorid[$i];
				$i++;
			}
		}
        $nombre = $this->CI->tabla->consultarDatos($camponombre,$Condicion);
		//$nombre=$$nombretabla->consultarDatos($camponombre,$Condicion,'');
		return $nombre[0][$camponombre];
	}
    function consultarlicencia($idconductor)
    {
        $msg="entro";
        $this->CI->tabla->settabla('licenciaconductor');
        $condicion['idconductor']=$idconductor;
        
        $cantidadDatos = $this->CI->tabla->cantidadDatos('*',$condicion);
        if($cantidadDatos > 0)
        {
            $datosConductor = $this->CI->tabla->consultarDatos('*',$condicion);
            if($datosConductor[0]['fechavencimiento'] <= date('Y-m-d'))
            {
                $msg="Licencia vencida";
            }
        }
        else
        {
            $msg="No Tiene Licencias Asociadas";
        }
        return $msg;
        
    }
    
	function convertirFormatoFecha($fecha,$formin='dd/mm/aaaa',$formout='aaaa-mm-dd')
	{  
		if($fecha!="")
		{
			if($formin=="dd/mm/aaaa" || $formin=="dd/mm/yyyy")
			{
				$fecha=split("/",$fecha);
			}
			else if($formin=="aaaa-mm-dd" || $formin=="yyyy-mm-dd")
			{
				$fecha=split("-",$fecha);
				$ano=$fecha[0];
				$fecha[0]=$fecha[2];
				$fecha[2]=$ano;
			}
			if($formout=="dd/mm/aaaa" || $formout=="dd/mm/yyyy")
			{
				if($fecha[0]<10)
					$fecha[0]="0".sprintf("%d",$fecha[0]);
				if($fecha[1]<10)
					$fecha[1]="0".sprintf("%d",$fecha[1]);
				$fecha=$fecha[0].'/'.$fecha[1].'/'.$fecha[2];
			}
			else if($formout=="dd-mm-aaaa" || $formout=="dd-mm-yyyy")
			{
				if($fecha[0]<10)
					$fecha[0]="0".sprintf("%d",$fecha[0]);
				if($fecha[1]<10)
					$fecha[1]="0".sprintf("%d",$fecha[1]);
				$fecha=$fecha[0].'-'.$fecha[1].'-'.$fecha[2];
			}
			else if($formout=="aaaa-mm-dd" || $formout=="yyyy-mm-dd")
			{
				if($fecha[0]<10)
					$fecha[0]="0".sprintf("%d",$fecha[0]);
				if($fecha[1]<10)
					$fecha[1]="0".sprintf("%d",$fecha[1]);
				$fecha=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
			}
			if($fecha=='0000-00-00' || $fecha=='00/00/0000')
			{
				$fecha="";
			}
			return($fecha);
		}
	}
    /**
    * Consulta las aseguradoras, si se envia el idaseguradora se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consAseguradora($idaseguradora="")
	{
		$condicion = array();
		if(!empty($idaseguradora) && $idaseguradora!=0)
		{
			$condicion['idaseguradora']=$idaseguradora;
		}
		$this->CI->tabla->settabla('aseguradora');
		$arrayAseguradora = $this->CI->tabla->consultarDatos('idaseguradora, codigoaseguradora, nombreaseguradora',$condicion,"codigoaseguradora ASC");
		return $arrayAseguradora;
	}
    /**
    * Consulta los modelos, si se envia el idmodelo se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consModelo($idmodelo="")
	{
		$condicion = array();
		if(!empty($idmodelo) && $idmodelo!=0)
		{
			$condicion['idmodelo']=$idmodelo;
		}
		$this->CI->tabla->settabla('modelo');
		$arrayModelo = $this->CI->tabla->consultarDatos('idmodelo,nombremodelo',$condicion,"nombremodelo DESC");
		return $arrayModelo;
	}
	
    /**
    * Consulta las marcas de los vehiculos, si se envia el idmarcavehiculo se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consMarcavehiculo($idmarcavehiculo="")
	{
		$condicion = array();
		if(!empty($idmarcavehiculo) && $idmarcavehiculo!=0)
		{
			$condicion['idmarcavehiculo']=$idmarca;
		}
		$this->CI->tabla->settabla('marcavehiculo');
		$arrayMarcavehiculo = $this->CI->tabla->consultarDatos('idmarcavehiculo,nombremarcavehiculo',$condicion,"nombremarcavehiculo ASC");
		return $arrayMarcavehiculo;
	}
    /**
    * Consulta los meses, si se envia el idmeses se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consMeses($idmeses="")
	{
		$condicion = array();
		if(!empty($idmeses) && $idmeses!=0)
		{
			$condicion['idmeses']=$idmeses;
		}
		$this->CI->tabla->settabla('meses');
		$arrayMeses = $this->CI->tabla->consultarDatos('idmeses AS id, nombremeses',$condicion);
		return $arrayMeses;
	}
    /**
    * Consulta los tipos de vehiculos, si se envia el idtipovehiculo se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consTipovehiculo($idtipovehiculo="")
	{
		$condicion = array();
		if(!empty($idtipovehiculo) && $idtipovehiculo!=0)
		{
			$condicion['idtipovehiculo']=$idtipovehiculo;
		}
		$this->CI->tabla->settabla('tipovehiculo');
		$arrayTipovehiculo = $this->CI->tabla->consultarDatos('idtipovehiculo AS id, nombretipovehiculo',$condicion);
		return $arrayTipovehiculo;
	}
    /**
    * Consulta los cda, si se envia el idcda se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consCda($idcda="", $condAdicional="")
	{
		$condicion = array();
		if(!empty($idcda) && $idcda!=0)
		{
			$condicion['idcda']=$idcda;
		}
		$this->CI->tabla->settabla('cda');
		$arrayCda = $this->CI->tabla->consultarDatos('idcda, codigocda, nombrecda',$condicion,'nombrecda ASC',"","", $condAdicional);
		return $arrayCda;
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
    public function consVehiculoseguros($idvehiculo)
    {
        $html="";
        
		$sql="SELECT v.placa, v.activo, s.numerosoat, s.fechainicial AS soat_fechainicial, s.fechafinal AS soat_fechafinal,
					 c.numerocontractual, c.fechainicial AS cont_fechainicial, c.fechafinal AS cont_fechafinal,
					 ec.numeroextracontractual, ec.fechainicial AS extra_fechainicial, ec.fechafinal AS extra_fechafinal,
					 r.numerorevision , r.fechainicial AS revi_fechainicial, r.fechafinal AS revi_fechafinal, 
					 mv.nombremarcavehiculo, v.numerointerno, top.numerotarjetaoperacion, top.fechainicial AS top_fechainicial,
					 top.fechafinal AS top_fechafinal,
					 asoat.nombreaseguradora AS aseg_soat, acontra.nombreaseguradora AS aseg_contra, 
					 aextra.nombreaseguradora AS aseg_extra, cdarev.nombrecda AS cda_rev 
			  FROM	 vehiculo as v
			  LEFT JOIN soat as s ON s.idvehiculo = v.idvehiculo AND s.activo='1'
			  LEFT JOIN aseguradora as asoat ON asoat.idaseguradora= s.idaseguradora
			  LEFT JOIN contractual as c ON c.idvehiculo = v.idvehiculo AND c.activo='1'
			  LEFT JOIN aseguradora as acontra ON acontra.idaseguradora= c.idaseguradora
			  LEFT JOIN extracontractual as ec ON ec.idvehiculo = v.idvehiculo AND ec.activo='1' 
			  LEFT JOIN aseguradora as aextra ON aextra.idaseguradora= ec.idaseguradora
			  LEFT JOIN revision as r ON r.idvehiculo = v.idvehiculo AND r.activo='1'
			  LEFT JOIN cda as cdarev ON cdarev.idcda= r.idcda
			  LEFT JOIN tarjetaoperacion as top ON top.idvehiculo = v.idvehiculo AND top.activo='1'
			  LEFT JOIN marcavehiculo as mv ON mv.idmarcavehiculo = v.idmarcavehiculo 
			  WHERE  v.idvehiculo = '".$idvehiculo."' AND v.idempresa='".$this->idempresa."' AND v.activo='1'
			  LIMIT 0 , 1";
        $consultaVehiculo= $this->CI->db->query($sql);
        $html.="<ul class='result_seguros'>
				<li class='titulo'>Doc.</li>
				<li class='titulo'>CDA o Aseg.</li>
				<li class='titulo'>Número</li>
				<li class='titulo'>Fecha Inicial</li>
				<li class='titulo'>Fecha Final</li>";
				
		$class[0]="vencido";
		$class[1]="actualizado";
        foreach ($consultaVehiculo->result_array() as $row)
        {
			//validamos el SOAT
			$html.="<li>SOAT</li>";
			if(empty($row['numerosoat']))   
			{
				//no tiene SOAT registrado
				$html.="<li class='vacio'>No tiene registrado SOAT</li>";
			}
			else
			{
				$class="actualizado";
				$html.="<li>".html_entity_decode($row['aseg_soat'])."</li>";
				$html.="<li>".html_entity_decode($row['numerosoat'])."</li>";
				$html.="<li>".html_entity_decode($row['soat_fechainicial'])."</li>";
				if($row['soat_fechafinal'] <= date('Y-m-d'))
				{
					$class="vencido";
				}
				$html.="<li class='".$class."'>".html_entity_decode($row['soat_fechafinal'])."</li>";
			}
			
			//validamos el REVISIÓN
			$html.="<li>REVISIÓN</li>";
			if(empty($row['numerorevision']))   
			{
				//no tiene revision registrado
				$html.="<li class='vacio'>No tiene registrado REVISIÓN</li>";
			}
			else
			{
				$class="actualizado";
				$html.="<li>".html_entity_decode($row['cda_rev'])."</li>";
				$html.="<li>".html_entity_decode($row['numerorevision'])."</li>";
				$html.="<li>".html_entity_decode($row['revi_fechainicial'])."</li>";
				if($row['revi_fechafinal'] <= date('Y-m-d'))
				{
					$class="vencido";
				}
				$html.="<li class='".$class."'>".html_entity_decode($row['revi_fechafinal'])."</li>";
			}
			
			//validamos el TARJETA
			$html.="<li>TARJETA</li>";
			if(empty($row['numerotarjetaoperacion']))   
			{
				//no tiene TARJETA registrado
				$html.="<li class='vacio'>No tiene registrado TARJETA</li>";
			}
			else
			{
				$class="actualizado";
				$html.="<li>&nbsp;</li>";
				$html.="<li>".html_entity_decode($row['numerotarjetaoperacion'])."</li>";
				$html.="<li>".html_entity_decode($row['top_fechainicial'])."</li>";
				if($row['top_fechafinal'] <= date('Y-m-d'))
				{
					$class="vencido";
				}
				$html.="<li class='".$class."'>".html_entity_decode($row['top_fechafinal'])."</li>";
			}
			//validamos el CONTRACTUAL
			$html.="<li>CONTRACTUAL</li>";
			if(empty($row['numerocontractual']))   
			{
				//no tiene CONTRACTUAL registrado
				$html.="<li class='vacio'>No tiene registrado CONTRACTUAL</li>";
			}
			else
			{
				$class="actualizado";
				$html.="<li>".html_entity_decode($row['aseg_contra'])."</li>";
				$html.="<li>".html_entity_decode($row['numerocontractual'])."</li>";
				$html.="<li>".html_entity_decode($row['cont_fechainicial'])."</li>";
				if($row['cont_fechafinal'] <= date('Y-m-d'))
				{
					$class="vencido";
				}
				$html.="<li class='".$class."'>".html_entity_decode($row['cont_fechafinal'])."</li>";
			}
			
			//validamos el EXTRA-CONTRACTUAL
			$html.="<li>EXTRA-CONTRACTUAL</li>";
			if(empty($row['numeroextracontractual']))   
			{
				//no tiene EXTRA-CONTRACTUAL registrado
				$html.="<li class='vacio'>No tiene registrado EXTRA-CONTRACTUAL</li>";
			}
			else
			{
				$class="actualizado";
				$html.="<li>".html_entity_decode($row['aseg_extra'])."</li>";
				$html.="<li>".html_entity_decode($row['numeroextracontractual'])."</li>";
				$html.="<li>".html_entity_decode($row['extra_fechainicial'])."</li>";
				if($row['extra_fechafinal'] <= date('Y-m-d'))
				{
					$class="vencido";
				}
				$html.="<li class='".$class."'>".html_entity_decode($row['extra_fechafinal'])."</li>";
			}
        }
        $html.="</ul>";
        return $html;
    }
    /**
    * Consulta los municipios, si se envia el idcda se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consMunicipio($idmunicipio="")
	{
		$datolugar = "";
		if(!empty($idmunicipio) && $idmunicipio!=0)
		{
			/** se consulta el nombre de departamento y municipio para el lugar de expedicion del documento**/
			$sqllugar="SELECT m.idmunicipio, m.nombremunicipio,d.nombredepartamento
				  FROM	 municipio as m
				  INNER JOIN departamento as d ON m.iddepartamento=d.iddepartamento
				  WHERE  m.idmunicipio ='".$idmunicipio."'
				  LIMIT 0 , 1";
			$consultalugar	=   $this->CI->db->query($sqllugar);
			$datolugar		=   $consultalugar->row();
		}
		return $datolugar;
	}
    /**
    * Consulta los conductores y vehiculos, segun el idvehiculoconductor
    *
    * @access public
    * @param int
    * @return object
    */
	function consVehiculoconductor($idvehiculoconductor="")
	{
		$dato = "";
		if(!empty($idvehiculoconductor) && $idvehiculoconductor!=0)
		{
			// se consulta el nombre del conductor y la placa
			$sql="SELECT vc.idvehiculoconductor, v.placa, c.nombrecompleto
				  FROM	 vehiculoconductor as vc
				  INNER JOIN vehiculo as v ON v.idvehiculo=vc.idvehiculo
				  INNER JOIN conductor as c ON c.idconductor=vc.idconductor				  
				  WHERE  vc.idvehiculoconductor ='".$idvehiculoconductor."' AND vc.idempresa='".$this->idempresa."' 
				  LIMIT 0 , 1";
			$consulta	=   $this->CI->db->query($sql);
			$dato		=   $consulta->row();
		}
		return $dato;
	}
    /**
    * Consulta los contratantes de las planillas
    *
    * @access public
    * @param int
    * @return array
    */
	function consContratante($idcontratante="")
	{
		$array="";
		$condicion = array();
		$condicion['idcontratante']=$this->idempresa;
		if(!empty($idcontratante) && $idcontratante!=0)
		{
			$condicion['idcontratante']=$idcontratante;
		}
		$this->CI->tabla->settabla('contratante');
		$array = $this->CI->tabla->consultarDatos('idcontratante, idtipodocumento, numerodocumento, nombrecompleto, direccion, telefonofijo', $condicion, 'nombrecompleto ASC');
		return $array;
	}
	
	function ReplaceHTMLSpecialCharacters ($strHtml)
	{
		$strHtml = str_replace('&', '&', $strHtml);
		$strHtml = str_replace("'", '\'', $strHtml);
		$strHtml = str_replace('"', '\"', $strHtml);
		$strHtml = str_replace('<', '<', $strHtml);
		$strHtml = str_replace('>', '>', $strHtml);
		$strHtml = str_replace('“', '"', $strHtml);
		$strHtml = str_replace('”', '"', $strHtml);
		return $strHtml;
	}
	
	function UnHmlSpecialchars ($string)
	{
		$string = str_replace('&', '&', $string);
		$string = str_replace("'", '\'', $string);
		$string = str_replace('"', '\"', $string);
		$string = str_replace('<', '<', $string);
		$string = str_replace('>', '>', $string);
		return $string;
	}

    /**
    * Consulta las Empresas
    *
    * @access public
    * @param int
    * @return array
    */
	function consEmpresa($idempresa="")
	{
		$array="";
		$condicion = array();
		if(!empty($idempresa) && $idempresa!=0)
		{
			$condicion['idempresa']=$idempresa;
		}
		$this->CI->tabla->settabla('empresa');
		$array = $this->CI->tabla->consultarDatos('idempresa, nombreempresa', $condicion, 'nombreempresa ASC');
		return $array;
	}

    /**
    * Consulta los conductores , segun el idconductor
    *
    * @access public
    * @param int
    * @return object
    */
	function consConductor($idconductor="")
	{
		$dato = "";
		if(!empty($idconductor) && $idconductor!=0)
		{
			// se consulta el nombre del conductor y la placa
			$sql="SELECT c.*
				  FROM	 conductor as c
				  WHERE  c.idconductor ='".$idconductor."' AND c.idempresa='".$this->idempresa."' 
				  LIMIT 0 , 1";
			$consulta	=   $this->CI->db->query($sql);
			$dato		=   $consulta->row();
		}
		return $dato;
	}

    /**
    * Consulta los categorias, si se envia el idcategoria se consulta solo ese id
    *
    * @access public
    * @param int
    * @return array
    */
	function consCategoria($idcategoria="", $condAdicional="")
	{
		$array="";
		$condicion = array();
		if(!empty($idcategoria) && $idcategoria!=0)
		{
			$condicion['idcategoria']=$idcategoria;
		}
		$this->CI->tabla->settabla('categoria');
		$array = $this->CI->tabla->consultarDatos('idcategoria, nombrecategoria',$condicion,'nombrecategoria ASC',"","",$condAdicional);
		return $array;
	}

    /**
    * Consulta los organismos , segun el idorganismo
    *
    * @access public
    * @param int
    * @return object
    */
	function consOrganismo($idorganismo="")
	{
		$dato = "";
		if(!empty($idorganismo) && $idorganismo!=0)
		{
			// se consulta el nombre del conductor y la placa
			$sql="SELECT o.*
				  FROM	 organismo as o
				  WHERE  o.idorganismo ='".$idorganismo."'
				  LIMIT 0 , 1";
			$consulta	=   $this->CI->db->query($sql);
			$dato		=   $consulta->row();
		}
		return $dato;
	}
	
    /**
    * Consulta los datos de los vehiculos y sus propietarios, utilizado en la consulta para la impresion del
	* formato de renovacion de tarjeta de operacion
    *
    * @access public
    * @param int
    * @return object
    */
	function consVehiculoPropietario($idvehiculo="")
	{
		$dato = "";
		if(!empty($idvehiculo) && $idvehiculo!=0)
		{
			// se consulta el nombre del conductor y la placa
	        $sql="SELECT v.idvehiculo, c.idconductor, v.placa, v.numeromotor, v.numerochasis, v.numerointerno,
				  mv.nombremarcavehiculo, m.nombremodelo, tv.nombretipovehiculo, tv.cantidadpasajeros, c.nombrecompleto
        	  FROM	 vehiculo as v
              LEFT JOIN vehiculopropietario as vp ON vp.idvehiculo = v.idvehiculo AND vp.activo='1'
              LEFT JOIN conductor as c ON c.idconductor = vp.idconductor 
			  LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo = v.idmarcavehiculo 
			  LEFT JOIN modelo AS m ON m.idmodelo = v.idmodelo
			  LEFT JOIN tipovehiculo AS tv ON  tv.idtipovehiculo = v.idtipovehiculo
        	  WHERE  (v.idvehiculo = '".$idvehiculo."') AND v.idempresa='".$this->idempresa."' AND v.activo='1'
        	  LIMIT 0 , 20";
			$consulta	=   $this->CI->db->query($sql);
			$dato		=   $consulta->row();
		}
		return $dato;
	}
    /**
    * Consulta los id de todos los vehiculos afiliados a empresa, utilizado en la consulta para la impresion del
	* formato de renovacion de tarjeta de operacion
    *
    * @access public
    * @param int
    * @return object
    */
	function consVehiculosEmpresa()
	{
		$dato = "";
		// se consulta el nombre del conductor y la placa
		$sql="SELECT v.idvehiculo
		  FROM	 vehiculo as v
		  WHERE  v.idempresa='".$this->idempresa."' AND empresa='1' AND v.activo='1'
		  ";
		$consulta	=   $this->CI->db->query($sql);
		//$dato		=   $consulta->row();
		return $consulta;
	}
    /**
    * Consulta los datos de los vehiculos y sus propietarios, utilizado en la consulta para la impresion del
	* formato de renovacion de tarjeta de operacion
    *
    * @access public
    * @param int
    * @return object
    */
	function consVehiculoPropietarioContratoAfil($idvehiculopropietario="")
	{
		$dato = "";
		if(!empty($idvehiculopropietario) && $idvehiculopropietario!=0)
		{
			// se consulta el nombre del conductor y la placa
	        $sql="SELECT c.nombrecompleto, c.numerodocumento, mun.nombremunicipio, dep.nombredepartamento, c.direccion,
				  c.telefonofijo, c.celular, mv.nombremarcavehiculo, v.numerointerno, v.placa, m.nombremodelo, 
				  tv.nombretipovehiculo, v.numeromotor, v.numerochasis
        	  FROM	 vehiculopropietario as vp
              LEFT JOIN vehiculo as v ON v.idvehiculo = vp.idvehiculo 
              LEFT JOIN conductor as c ON c.idconductor = vp.idconductor 
			  LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo = v.idmarcavehiculo 
			  LEFT JOIN modelo AS m ON m.idmodelo = v.idmodelo
			  LEFT JOIN tipovehiculo AS tv ON  tv.idtipovehiculo = v.idtipovehiculo
			  LEFT JOIN municipio AS mun ON mun.idmunicipio = c.idlugarexpedicion
			  LEFT JOIN departamento AS dep ON dep.iddepartamento = mun.iddepartamento
        	  WHERE  (vp.idvehiculopropietario = '".$idvehiculopropietario."') AND v.idempresa='".$this->idempresa."' AND v.activo='1' AND vp.activo='1'
        	  LIMIT 0 , 20";
			$consulta	=   $this->CI->db->query($sql);
			$dato		=   $consulta->row();
		}
		return $dato;
	}

    /**
    * Consulta los id de todos los propietarios de los vehiculos afiliados a empresa, utilizado en la consulta para la impresion del
	* formato de afiliacion
	*
    * @access public
    * @param int
    * @return object
    */
	function consVehiculosFormatoAfil()
	{
		$dato = "";
		// se consulta el nombre del conductor y la placa
        $sql="SELECT vp.idvehiculopropietario, v.placa, c.numerodocumento, c.nombrecompleto
        	  FROM	vehiculopropietario AS vp
			  INNER JOIN vehiculo AS v ON v.idvehiculo = vp.idvehiculo
			  INNER JOIN conductor AS c ON c.idconductor = vp.idconductor
        	  WHERE v.idempresa='".$this->idempresa."' AND v.empresa='1' AND v.activo='1' AND vp.activo='1'
        	  GROUP BY v.placa";
		$consulta	=   $this->CI->db->query($sql);
		//$dato		=   $consulta->row();
		return $consulta;
	}

}
?>