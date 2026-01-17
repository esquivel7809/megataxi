<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehiculo_model extends CI_Model {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/validacion
	 *	- or -
	 * 		http://example.com/index.php/validacion/index
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
            // Llamando al contructor del Modelo
            parent::__construct();
            $this->load->database();
			$this->idempresa=$this->session->userdata('idempresaactual');
        }
		/**
		 * Devuelve los datos de un vehiculo en especifico
		 * 
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, desde controller
		 * @param	idvehiculo
		 * @return	array
		 */
		public function cons_datos_vehi($idvehiculo)
		{
			$array = "";
			if(!empty($idvehiculo)){
			$sql="SELECT *
				  FROM	 vehiculo AS v
				  INNER JOIN empresa AS em ON em.idempresa = v.idempresa
				  LEFT JOIN modelo AS mo ON mo.idmodelo= v.idmodelo
				  LEFT JOIN marcavehiculo as mv ON mv.idmarcavehiculo = v.idmarcavehiculo
				  LEFT JOIN meses AS re ON re.idmeses = v.idrevisado
				  LEFT JOIN tipovehiculo AS tv ON tv.idtipovehiculo= v.idtipovehiculo
				  WHERE  (v.idvehiculo = '".$idvehiculo."') AND v.idempresa='".$this->idempresa."'
				  LIMIT 0 , 2";
			
			$consulta = $this->db->query($sql);
			$array = $consulta->result_array();
			}
			return $array;
		}
		
		/**
		 * Devuelve los datos de los propietarios del vehiculo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	array
		 */
		public function cons_datos_vehi_prop($idvehiculo)
		{
			$array = "";
			if(!empty($idvehiculo)){
				$sql="SELECT vp.idvehiculopropietario, v.idvehiculo, c.idconductor, v.placa, v.activo, c.nombrecompleto
					  FROM	 vehiculopropietario AS vp
					  INNER JOIN vehiculo AS v ON v.idvehiculo = vp.idvehiculo
					  INNER JOIN conductor AS c ON c.idconductor = vp.idconductor 
					  WHERE  (vp.idvehiculo = '".$idvehiculo."') AND v.idempresa='".$this->idempresa."' AND vp.activo='1'
					  LIMIT 0 , 6";
				
				$consulta = $this->db->query($sql);
				$array = $consulta->result_array();
			}
			return $array;
		}






		
		///para borrar de aqui para abajo
		/**
		 * Devuelve los datos de los vehiculos como seguros y fechas de venc.
		 * vc activo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_vehi_cond_all($idvehiculoconductor)
		{
			if(!empty($idvehiculoconductor)){
			
			$sql="SELECT vc.idvehiculo, v.placa , s.numerosoat, s.fechainicial AS soat_fechainicial, s.fechafinal AS soat_fechafinal,
						 con.*, c.numerocontractual, c.fechainicial AS cont_fechainicial, c.fechafinal AS cont_fechafinal,
						 ec.numeroextracontractual, ec.fechainicial AS extra_fechainicial, ec.fechafinal AS extra_fechafinal,
						 r.numerorevision , r.fechainicial AS revi_fechainicial, r.fechafinal AS revi_fechafinal, 
						 rf.fecharefrendacion, v.activo, mv.nombremarcavehiculo, v.numerointerno
				  FROM	 vehiculoconductor as vc
				  INNER JOIN vehiculo as v ON v.idvehiculo = vc.idvehiculo
				  INNER JOIN conductor as con ON con.idconductor = vc.idconductor
				  LEFT JOIN soat as s ON s.idvehiculo = vc.idvehiculo 
				  LEFT JOIN contractual as c ON c.idvehiculo = vc.idvehiculo 
				  LEFT JOIN extracontractual as ec ON ec.idvehiculo = vc.idvehiculo 
				  LEFT JOIN revision as r ON r.idvehiculo = vc.idvehiculo 
				  LEFT JOIN marcavehiculo as mv ON mv.idmarcavehiculo = v.idmarcavehiculo 
				  LEFT JOIN refrendacion as rf ON rf.idvehiculoconductor = vc.idvehiculoconductor AND rf.activo='1'
				  WHERE  (vc.idvehiculoconductor = '".$idvehiculoconductor."') AND vc.idempresa='".$this->idempresa."' AND vc.activo='1'
				  GROUP BY v.placa
				  LIMIT 0 , 1";
			
			$consultaConductor = $this->db->query($sql);
			/*
			$html.="<table><tr><td colspan='3'>PROPIETARIOS</td></tr><tr><td>Placa</td><td>Nombre</td><td>Estado</td></tr>";
			foreach ($consultaConductor->result_array() as $row)
			{
				$activo="Inactivo";
				$html.="<tr>";
				$html.="<td>".html_entity_decode($row['placa'])."</td>";
				$html.="<td>".html_entity_decode($row['nombrecompleto'])."</td>";
				if($row['activo']==1)$activo = 'Activo';
				$html.="<td>".html_entity_decode($activo)."</td>";
				$html.="</tr>";
			}
			$html.="</table>";
			echo $html;
			*/
			return $consultaConductor->result_array();
			}
		}
		/**
		 * Devuelve los datos de los conductores para la refrendacion incluidos los datos de la licencia
		 * vc activo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_cond_refre($idconductor)
		{
			if(!empty($idconductor)){
			
			$sql="SELECT c.*, lc.numerolicenciaconductor, lc.fechaexpedicion, lc.fechavencimiento	
				  FROM	 conductor as c
				  LEFT JOIN licenciaconductor as lc ON lc.idconductor = c.idconductor AND lc.activo='1'
				  WHERE  (c.idconductor = '".$idconductor."') AND c.idempresa='".$this->idempresa."' AND c.activo='1'
				  LIMIT 0 , 1";
			
			$consultaConductor = $this->db->query($sql);
			return $consultaConductor->result_array();
			}
		}
		/**
		 * Devuelve los datos de los refrendaciones de los vehiculos
		 * vc activo
		 *
		 * Acepta el id del vehiculoconductor
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_refre($idvehiculoconductor)
		{
			if(!empty($idvehiculoconductor)){
			
			$sql="SELECT *
				  FROM	 refrendacion as r
				  WHERE  r.idvehiculoconductor = '".$idvehiculoconductor."' AND r.idempresa='".$this->idempresa."' ";
			
			$consultaVehiculoConductor = $this->db->query($sql);
			return $consultaVehiculoConductor->result_array();
			}
		}
		/**
		 * Devuelve los datos de los conductores para la refrendacion incluidos los datos de la licencia
		 * vc activo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_refrendacion($idrefrendacion)
		{
			if(!empty($idrefrendacion)){
			
			$sql="SELECT *, s.fechafinal AS soat_fechafinal, rev.fechafinal AS revision_fechafinal
				  FROM	 refrendacion as r
				  INNER JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor = r.idvehiculoconductor
				  INNER JOIN vehiculo as v ON v.idvehiculo = vc.idvehiculo
				  INNER JOIN conductor as con ON con.idconductor = vc.idconductor
				  LEFT JOIN gruposanguineo AS gs ON gs.idgruposanguineo = con.idgruposanguineo
				  LEFT JOIN licenciaconductor AS lc ON lc.idconductor = con.idconductor AND lc.activo=1
				  LEFT JOIN soat AS s ON s.idvehiculo = v.idvehiculo AND s.activo=1
				  LEFT JOIN revision AS rev ON rev.idvehiculo = v.idvehiculo AND rev.activo=1
				  LEFT JOIN categoria AS ca ON ca.idcategoria = lc.idcategoria
				  LEFT JOIN organismo AS org ON org.idorganismo = lc.idorganismo
				  LEFT JOIN municipio AS muni ON muni.idmunicipio = con.idlugarexpedicion
				  
				  WHERE  (r.idrefrendacion = '".$idrefrendacion."') AND r.idempresa='".$this->idempresa."'
				  LIMIT 0 , 1";
			
			$consultaConductor = $this->db->query($sql);
			return $consultaConductor->result_array();
			}
		}
		/**
		 * Devuelve un array si el conductor ha refrendado en el mes actual
		 *
		 * Acepta el id del vehiculoconductor
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculoconductor
		 * @param	fecha(anno-mm)
		 * @return	array()
		 */
		public function es_refre($idvehiculoconductor="",$fecha="")
		{
			if(!empty($idvehiculoconductor)){
				if(empty($fecha)){
					$fecha= date("Y-m");
				}
				$sql="SELECT *
					  FROM	 refrendacion as r
					  WHERE  r.idvehiculoconductor = '".$idvehiculoconductor."' AND r.fecharefrendacion LIKE '".$fecha."%' AND r.idempresa='".$this->idempresa."'
					  LIMIT 0, 1";
				$consultaVehiculoConductor = $this->db->query($sql);
				return $consultaVehiculoConductor->result_array();
			}
			else{
				return array();
			}
		}
		
		/**
		* Consulta de vehiculos que tienen asociado un radiotelefono (vehiculoradiotelefono)
		*
		* @access	privado, via Ajax
		* @param	q
		* @return	json
		*/
		public function consultavehiculoradiotelefono($idvehiculoradiotelefono="")
		{
			if(!empty($idvehiculoradiotelefono)){
				$sql="SELECT vr.idvehiculoradiotelefono, v.placa, r.serieradiotelefono, mv.nombremarcavehiculo,
							mo.nombremodelo, mar.nombremarcaradio, mr.nombremodeloradio, v.idvehiculo, me.numeromega,
							vm.idvehiculomega
					  FROM	 vehiculoradiotelefono AS vr
					  INNER JOIN vehiculo AS v ON v.idvehiculo=vr.idvehiculo
					  INNER JOIN radiotelefono AS r ON r.idradiotelefono=vr.idradiotelefono
					  LEFT JOIN vehiculomega AS vm ON vm.idvehiculoradiotelefono=vr.idvehiculoradiotelefono
					  LEFT JOIN mega AS me ON me.idmega=vm.idmega
					  LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
					  LEFT JOIN modelo AS mo ON mo.idmodelo=v.idmodelo
					  LEFT JOIN modeloradio AS mr ON mr.idmodeloradio=r.idmodeloradio
					  LEFT JOIN marcaradio AS mar ON mar.idmarcaradio=mr.idmarcaradio			  
					  WHERE vr.idvehiculoradiotelefono='".$idvehiculoradiotelefono."'
					  GROUP BY v.idvehiculo
					  LIMIT 0 , 1";
				$consultaVehiculo = $this->db->query($sql);
			return $consultaVehiculo->result_array();
			}
			else{
				return array();
			}
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
		public function consultarvehiculopropietariocarnet($idvehiculo)
		{
			$html="";
			$sql="SELECT v.idvehiculo, c.idconductor, v.placa, v.activo, c.nombrecompleto
				  FROM	 vehiculopropietario as vp
				  INNER JOIN vehiculo as v ON v.idvehiculo = vp.idvehiculo
				  INNER JOIN conductor as c ON c.idconductor = vp.idconductor 
				  WHERE  (vp.idvehiculo = '".$idvehiculo."') AND v.idempresa='".$this->idempresa."' AND vp.activo='1'
				  LIMIT 0 , 20";
			
			$consultaConductor = $this->db->query($sql);
			$entrar=true;
			if($consultaConductor->num_rows()>0)
			{
				
				$html.="<h2 class='subtitulo-modulo'> Datos de los Propietarios</h2>";
				$html.="<div>";
		
				foreach ($consultaConductor->result_array() as $row)
				{
					$checked=($entrar)? 'checked="checked"' : "" ;
					$html.="<div class='nomb_prop'>".html_entity_decode($row['nombrecompleto'])."</div>
							<div class='opcion_prop'><input type='radio' name='idvehiculopropietario' id='".$row['idconductor']."' placeholder='Propietario' tittle='Propietario' required='required' value='".$row['idconductor']."' ".$checked." /></div>";
					$entrar=false;
				}

				$html.="</div>";
			}
			else
			{
				$html.="<h2 class='subtitulo-modulo'> No hay Datos de los Propietarios</h2>";
			}
			return $html;
		}

		/**
		 * Devuelve los datos de para el carnet de comunicaciones
		 * vc activo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_carnetcomunicacion($idcarnetcomunicacion)
		{
			if(!empty($idcarnetcomunicacion))
			{
				$sql="SELECT vr.idvehiculoradiotelefono, v.placa, rt.serieradiotelefono, mv.nombremarcavehiculo,
							mo.nombremodelo, mar.nombremarcaradio, mr.nombremodeloradio, v.idvehiculo, meg.numeromega,
							vm.idvehiculomega, con.nombrecompleto, con.numerodocumento, mun.nombremunicipio,
							cm.numerocarnet, cm.fechacarnet, tv.nombretipovehiculo, tv.idtipovehiculo
					  FROM	 carnetcomunicacion AS cm
					  INNER JOIN vehiculoradiotelefono AS vr ON vr.idvehiculoradiotelefono=cm.idvehiculoradiotelefono
					  INNER JOIN radiotelefono AS rt ON rt.idradiotelefono=vr.idradiotelefono
					  INNER JOIN modeloradio AS mr ON mr.idmodeloradio=rt.idmodeloradio
					  INNER JOIN marcaradio AS mar ON mar.idmarcaradio=mr.idmarcaradio
					  INNER JOIN vehiculomega AS vm ON vm.idvehiculomega=cm.idvehiculomega
					  INNER JOIN mega AS meg ON meg.idmega=vm.idmega
					  INNER JOIN conductor as con ON con.idconductor = cm.idvehiculopropietario
					  LEFT JOIN municipio AS mun ON mun.idmunicipio=con.idlugarexpedicion
					  INNER JOIN vehiculo AS v ON v.idvehiculo=vr.idvehiculo
					  LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
					  LEFT JOIN tipovehiculo AS tv ON tv.idtipovehiculo=v.idtipovehiculo					  
					  LEFT JOIN modelo AS mo ON mo.idmodelo=v.idmodelo
					  WHERE cm.idcarnetcomunicacion='".$idcarnetcomunicacion."'
					  LIMIT 0 , 1";
				$consultaVehiculo = $this->db->query($sql);
			return $consultaVehiculo->result_array();
			}
			else{
				return array();
			}
		}
		/**
		 * Devuelve los datos de para el carnet de comunicaciones
		 * vc activo
		 *
		 * Acepta el id del vehiculo
		 *
		 * @access	privado, via Ajax
		 * @param	idvehiculo
		 * @return	html
		 */
		public function cons_dat_planilla($idplanilla)
		{
			if(!empty($idplanilla))
			{
				$sql="SELECT p.idplanilla, p.numeroplanilla, p.fechainicio, p.fecharegreso, p.cantidadpasajeros,
							muo.nombremunicipio AS lugarorigen, co.nombrecompleto AS nombrecontratante,
							td.idtipodocumento, td.abreviatura, co.numerodocumento AS numerocontratante, co.direccion, co.telefonofijo,
							v.placa, mv.nombremarcavehiculo, mo.nombremodelo, tv.nombretipovehiculo, so.numerosoat,
							ase.nombreaseguradora, top.numerotarjetaoperacion, c.nombrecompleto, c.numerodocumento,
							lc.numerolicenciaconductor, cat.nombrecategoria, emp.nombreempresa, emp.nitempresa, p.ciudaddestino
					  FROM	 planilla AS p
					  INNER JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor=p.idvehiculoconductor
					  INNER JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
					  INNER JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
					  INNER JOIN modelo AS mo ON mo.idmodelo=v.idmodelo
					  INNER JOIN tipovehiculo AS tv ON tv.idtipovehiculo=v.idtipovehiculo
					  INNER JOIN soat AS so ON so.idvehiculo=v.idvehiculo AND so.activo='1'
					  INNER JOIN aseguradora AS ase ON ase.idaseguradora=so.idaseguradora
					  INNER JOIN tarjetaoperacion AS top ON top.idvehiculo=v.idvehiculo AND top.activo='1'
					  INNER JOIN conductor AS c ON c.idconductor=vc.idconductor
					  INNER JOIN licenciaconductor AS lc ON lc.idconductor=c.idconductor AND lc.activo='1'
					  INNER JOIN categoria AS cat ON cat.idcategoria=lc.idcategoria
					  INNER JOIN municipio AS muo ON muo.idmunicipio=p.idorigen
					  INNER JOIN contratante AS co ON co.idcontratante=p.idcontratante
					  INNER JOIN empresa AS emp ON emp.idempresa=p.idempresa
					  INNER JOIN tipodocumento AS td ON td.idtipodocumento=co.idtipodocumento
					  WHERE p.idplanilla='".$idplanilla."' AND p.idempresa='".$this->idempresa."' 
					  LIMIT 0 , 1";
					  
					  //INNER JOIN municipio AS mud ON mud.idmunicipio=p.iddestino //
					  //mud.nombremunicipio AS lugardestino, 
				$consultaVehiculo = $this->db->query($sql);
			return $consultaVehiculo->result_array();
			}
			else{
				return array();
			}
		}

}
/* End of file usuario.php */
/* Location: ./application/models/refrendacion.php */
