<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class Tabla {
    
		var $nombretabla="";
		var $banderalocal=0;
        var $mensaje="";
        
		public function __construct($param = NULL)
		{  //print_r($param);  echo"entro";
            if(!empty($param))
			$this->nombretabla=$param['tabla'];
            
            $this->CI =& get_instance();
            $this->CI->load->database();
            
		}//end function tabla
        
        function settabla($tabla)
        {
            if(!empty($tabla))
            $this->nombretabla=$tabla;
        }

        function getTabla()
        {
            return $this->nombretabla;
        }

        
		//Funcion que se encarga de realizar insert a la tabla indicada
		//los datos se agregan en mayusculas
		function agregarDatos($campos)
		{
            $fields="";
            $values="";
            $this->mensaje="No se Pudo Guardar";
			//global $db,$loginusuarioactual;
			if(!empty($campos))
			{
				$i=0;
				foreach($campos as $camp => $val)
				{
					if($i==0)
					{
						$fields.=$camp;
						//$values.="'".htmlentities(mb_strtoupper($val,'utf-8'))."'";
                        $values.="'".mb_strtoupper($val,'utf-8')."'";
						//$values.="'".$val."'";
					}
					else
					{
						$fields.=",".$camp;
						//$values.=",'".htmlentities(mb_strtoupper($val,'utf-8'))."'";
                        $values.=",'".mb_strtoupper($val,'utf-8')."'";
						//$values.=",'".$val."'";
					}
					$i++;
					next($campos);
				}
				$sqlAgregar="INSERT INTO ".$this->nombretabla." ( ".$fields.",fechacreacion,creadopor,fechaultmodificacion,modificadopor ) VALUES ( ".$values.",NOW(),'".$_SESSION['loginusuarioactual']."',NOW(),'".$_SESSION['loginusuarioactual']."' ) ";
				if($this->CI->db->query($sqlAgregar))
                {
                    $this->mensaje="Guardado con Exito";                    
    				$sql='INSERT INTO logtransacciones (fechatransaccion,horatransaccion,nombretabla,loginusuario,accion,querysql,ip)
    					  VALUES (CURDATE(),CURTIME(),"'.$this->nombretabla.'","'.$_SESSION['loginusuarioactual'].'","AGREGAR NUEVO DATO","'.$sqlAgregar.'","'.$_SERVER['REMOTE_ADDR'].'")';
    				$this->CI->db->query($sql);
                    
    				if($this->banderalocal==1)
    				{
    					$sql='INSERT INTO logquery (senteciaquery,estado,fechacreacion,creadopor)
    						  VALUES ("'.$sqlAgregar.'","0",NOW(),"'.$_SESSION['loginusuarioactual'].'")';
    					$db->query($sql);
    				}
                }
			}
            //return $this->mensaje;
		}

		//Funcion que se encarga de realizar insert a la tabla indicada
		//los datos se agregan tal como los digito el usuario
		function agregarDatosMinus($campos)
		{
			$this->mensaje="No se Pudo Guardar";
			if(!empty($campos))
			{
				$i=0;
				foreach($campos as $camp => $val)
				{
					if($i==0)
					{
						$fields.=$camp;
						//$values.="'".htmlentities($val)."'";
                        $values.="'".$val."'";
					}
					else
					{
						$fields.=",".$camp;
						//$values.=",'".htmlentities($val)."'";
                        $values.=",'".$val."'";
					}
					$i++;
					next($campos);
				}
				$sqlAgregar="INSERT INTO ".$this->nombretabla." ( ".$fields.",fechacreacion,creadopor,fechaultmodificacion,modificadopor ) VALUES ( ".$values.",NOW(),'".$_SESSION['loginusuarioactual']."',NOW(),'".$_SESSION['loginusuarioactual']."') ";
				if($queryresult=$this->CI->db->query($sqlAgregar))
                {
                    $this->mensaje="Guardado con Exito";
    				$sql='INSERT INTO logtransacciones (fechatransaccion,horatransaccion,nombretabla,loginusuario,accion,querysql,ip)
    					  VALUES (CURDATE(),CURTIME(),"'.$this->nombretabla.'","'.$_SESSION['loginusuarioactual'].'","AGREGAR NUEVO DATO","'.$sqlAgregar.'","'.$_SERVER['REMOTE_ADDR'].'")';
    				$this->CI->db->query($sql);
    				if($this->banderalocal==1)
    				{
    					$sql='INSERT INTO logquery (senteciaquery,estado,fechacreacion,creadopor)
    						  VALUES ("'.$sqlAgregar.'","0",NOW(),"'.$_SESSION['loginusuarioactual'].'")';
    					$this->CI->db->query($sql);
    				}
                }
			}
            //return $this->mensaje;
		}

		//Funcion que se encarga de realizar update a la tabla indicada
		//Se le indica los campos y la condicion a utilizar
		//los datos se actualizan en mayusculas
		function actualizarDatos($campos,$condicion)
		{
            $cond="";
            $values="";
            $this->mensaje="No se Pudo Actualizar";
			if(!empty($campos))
			{
				$i=0;
				foreach($campos as $camp => $val)
				{
					if($i==0)
					{
						//$values.=$camp." = '".htmlentities(mb_strtoupper($val,'utf-8'))."'";
                        $values.=$camp." = '".mb_strtoupper($val,'utf-8')."'";
					}
					else
					{
						//$values.=",".$camp." = '".htmlentities(mb_strtoupper($val,'utf-8'))."'";
                        $values.=",".$camp." = '".mb_strtoupper($val,'utf-8')."'";
					}
					$i++;
					next($campos);
				}
				$values.=',fechaultmodificacion=NOW(),modificadopor=\''.$_SESSION['loginusuarioactual'].'\' ';
				if(!empty($condicion))
				{
					$i=0;
					foreach($condicion as $camp => $val)
					{
						if($i==0)
						{
							$cond.=" WHERE ".$camp." = '".$val."'";
						}
						else
						{
							$cond.=" AND ".$camp." = '".$val."'";
						}
						$i++;
						next($condicion);
					}
				}
				$sqlActualizar="UPDATE ".$this->nombretabla." SET ".$values.$cond;
				if($this->CI->db->query($sqlActualizar))
                {
                    $this->mensaje="Actualizado con Exito";
                    //print_r($resul);
    				$sql='INSERT INTO logtransacciones (fechatransaccion,horatransaccion,nombretabla,loginusuario,accion,querysql,ip)
    					  VALUES (CURDATE(),CURTIME(),"'.$this->nombretabla.'","'.$_SESSION['loginusuarioactual'].'","ACTUALIZAR DATO","'.$sqlActualizar.'","'.$_SERVER['REMOTE_ADDR'].'")';
    				$this->CI->db->query($sql);
    				if($this->banderalocal==1)
    				{
    					$sql='INSERT INTO logquery (senteciaquery,estado,fechacreacion,creadopor)
    						  VALUES ("'.$sqlActualizar.'","0",NOW(),"'.$_SESSION['loginusuarioactual'].'")';
    					$this->CI->db->query($sql);
    				}
                }
			}
            //return $this->mensaje;
		}
		//Funcion que se encarga de realizar update a la tabla indicada
		//Se le indica los campos y la condicion a utilizar
		//los datos se actualizan tal como los digito el usuario
		function actualizarDatosMinus($campos,$condicion)
		{
			$this->mensaje="No se Pudo Actualizar";
			if(!empty($campos))
			{
				$i=0;
				foreach($campos as $camp => $val)
				{
					if($i==0)
					{
						//$values.=$camp." = '".htmlentities($val)."'";
                        $values.=$camp." = '".$val."'";
					}
					else
					{
						//$values.=",".$camp." = '".htmlentities($val)."'";
                        $values.=",".$camp." = '".$val."'";
					}
					$i++;
					next($campos);
				}
				$values.=',fechaultmodificacion=NOW(),modificadopor=\''.$_SESSION['loginusuarioactual'].'\' ';
				if(!empty($condicion))
				{
					$i=0;
					foreach($condicion as $camp => $val)
					{
						if($i==0)
						{
							$cond.=" WHERE ".$camp." = '".$val."'";
						}
						else
						{
							$cond.=" AND ".$camp." = '".$val."'";
						}
						$i++;
						next($condicion);
					}
				}
				$sqlActualizar="UPDATE ".$this->nombretabla." SET ".$values.$cond;
				if($this->CI->db->query($sqlActualizar))
                {
                    $this->mensaje="Actualizado con Exito";
    				$sql='INSERT INTO logtransacciones (fechatransaccion,horatransaccion,nombretabla,loginusuario,accion,querysql,ip)
    					  VALUES (CURDATE(),CURTIME(),"'.$this->nombretabla.'","'.$_SESSION['loginusuarioactual'].'","ACTUALIZAR DATO","'.$sqlActualizar.'","'.$_SERVER['REMOTE_ADDR'].'")';
    				$this->CI->db->query($sql);
    				if($this->banderalocal==1)
    				{
    					$sql='INSERT INTO logquery (senteciaquery,estado,fechacreacion,creadopor)
    						  VALUES ("'.$sqlActualizar.'","0",NOW(),"'.$_SESSION['loginusuarioactual'].'")';
    					$this->CI->db->query($sql);
    				}
                }
			}
            //return $this->mensaje;
		}
		
		//Funcion que se encarga de realizar update a la tabla indicada
		//Se le indica los campos y la condicion a utilizar
		function eliminarDatos($condicion)
		{
            $cond="";
			if(!empty($condicion))
			{
				$i=0;
				foreach($condicion as $camp => $val)
				{
					if($i==0)
					{
						$cond.=" WHERE ".$camp." = '".$val."'";
					}
					else
					{
						$cond.=" AND ".$camp." = '".$val."'";
					}
					$i++;
					next($condicion);
				}
				$sqlEliminar="DELETE FROM ".$this->nombretabla.$cond;
				$this->CI->db->query($sqlEliminar);
				$sql='INSERT INTO logtransacciones (fechatransaccion,horatransaccion,nombretabla,loginusuario,accion,querysql,ip)
					  VALUES (CURDATE(),CURTIME(),"'.$this->nombretabla.'","'.$_SESSION['loginusuarioactual'].'","ELIMINAR DATO","'.$sqlEliminar.'","'.$_SERVER['REMOTE_ADDR'].'")';
				$this->CI->db->query($sql);
				if($this->banderalocal==1)
				{
					$sql='INSERT INTO logquery (senteciaquery,estado,fechacreacion,creadopor)
						  VALUES ("'.$sqlEliminar.'","0",NOW(),"'.$_SESSION['loginusuarioactual'].'")';
					$this->CI->db->query($sql);
				}
			}
		}

		//Funcion que se encarga de realizar update a la tabla indicada
		//Se le indica los campos y la condicion a utilizar
		function consultarDatos($campos,$condicion="",$orden="",$RegistroInicia="",$RegistroCantidad="",$CondicionAdicional="")
		{
            $cond="";
            $Limit="";
			if(!empty($condicion))
			{
				$i=0;
				foreach($condicion as $camp => $val)
				{
					if($i==0)
					{
						$cond.=" WHERE ".$camp." = '".$val."'";
					}
					else
					{
						$cond.=" AND ".$camp." = '".$val."'";
					}
					$i++;
					next($condicion);
				}
			}
			if($orden!="")
			{
				$orden=" ORDER BY ".$orden;
			}
			$RegistroInicia=sprintf('%s',$RegistroInicia);
			$RegistroCantidad=sprintf('%s',$RegistroCantidad);
			if($RegistroInicia!="" && $RegistroCantidad!="")
			{
				$Limit=" LIMIT ".$RegistroInicia.",".$RegistroCantidad;
			}
			$sqlConsultar="SELECT ".$campos." FROM ".$this->nombretabla.$cond.' '.$CondicionAdicional.$orden.$Limit;
			$queryresult = $this->CI->db->query($sqlConsultar);
            foreach ($queryresult->result_array() as $row)
			{
				$consulta[]=$row;
			}
            $queryresult->free_result();
			return $consulta;
		}

		//Funcion que se encarga de realizar update a la tabla indicada
		//Se le indica los campos y la condicion a utilizar
		function cantidadDatos($campos,$condicion)
		{
            $cond="";
			if(!empty($condicion))
			{
				$i=0;
				foreach($condicion as $camp => $val)
				{
					if($i==0)
					{
						$cond.=" WHERE ".$camp." = '".$val."'";
					}
					else
					{
						$cond.=" AND ".$camp." = '".$val."'";
					}
					$i++;
					next($condicion);
				}
			}
			$sqlConsultar="SELECT ".$campos." FROM ".$this->nombretabla.$cond;
            $queryresult = $this->CI->db->query($sqlConsultar);
            
            return $queryresult->num_rows();
		}

		//Funcion que consulta el maximo registro de un campo determinado
		function MaximoDato($campo,$condicion)
		{
			global $db;
			if(!empty($condicion))
			{
				$i=0;
				foreach($condicion as $camp => $val)
				{
					if($i==0)
					{
						$cond.=" WHERE ".$camp." = '".$val."'";
					}
					else
					{
						$cond.=" AND ".$camp." = '".$val."'";
					}
					$i++;
					next($condicion);
				}
			}
			$sqlConsultar="SELECT MAX(".$campo.") AS ".$campo." FROM ".$this->nombretabla.$cond;
			$queryresult = $this->CI->db->query($sqlConsultar);
            $row = $queryresult->row_array();
            $queryresult->free_result();
            
            return $row[$campo]; 
		}
		function getMensaje(){
			return $this->mensaje;
		}
		
		function trans_start(){
			return $this->CI->db->trans_start();
		}
		function trans_complete(){
			return $this->CI->db->trans_complete();
		}
		function trans_status(){
			return $this->CI->db->trans_status();
		}
		function trans_off(){
			return $this->CI->db->trans_off();
		}

		
		
}//end clase Tabla
?>