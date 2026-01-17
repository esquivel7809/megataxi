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
    
    public function buscarregistroreporte()
    {
        $nombrecampoid      =   $this->arrayRequest['nombrecampoid'];
        $valordato          =   $this->arrayRequest['valordato'];
        $nombrecamponombre  =   $this->arrayRequest['nombrecamponombre'];
        //$listadato          =   $this->arrayRequest['listadato'];
        $listadato          =   $this->input->post('listadato');
        $otrasCondiciones   =   $this->arrayRequest['otrasCondiciones'];
        $tabla              =   $this->arrayRequest['tabla'];
        $capalista          =   $this->arrayRequest['capalista'];
        $capadato           =   $this->arrayRequest['capadato'];
        $nombrelistadato    =   $this->arrayRequest['nombrelistadato'];
                
        
        $Condicion="(".$nombrecampoid." LIKE '%$valordato%' OR ".$nombrecamponombre." LIKE '%$valordato%')";
        
        if($listadato!="")
        	$Condicion.=" AND ".$nombrecampoid." NOT IN (".stripslashes($listadato).")";
        
        $listadato = addslashes($listadato);
        //echo $listadato;
        if($otrasCondiciones!="")
            $Condicion.=" OR ".$otrasCondiciones." LIKE '%$valordato%'";
        	//$Condicion.=" AND ".$otrasCondiciones;
        
        if($valordato!="")
        {
        	$sql="SELECT ".$nombrecampoid.",".$nombrecamponombre."
        				  FROM	 ".$tabla."
        				  WHERE  ".$Condicion."
        				  ORDER BY ".$nombrecamponombre."
        				  LIMIT  0,15";
                          
            $consulta = $this->db->query($sql);
            if($consulta->num_rows()>0)
            {
                $i=0;
                echo '<table class="tablacapabusqueda" id="buscareporte'.$nombrecamponombre.'">';
                foreach ($consulta->result_array() as $row)
                {
        			echo '
        			<tr class="trcapabusqueda" id="trbusquedareporte'.$nombrecamponombre.$i.'" title="abrirAjax(\'#'.$capalista.'\',\''.site_url('informes/data/retornadatoreporte').'\',\'valodato='.html_entity_decode($row[$nombrecampoid]).'&nombrelistadato='.$nombrelistadato.'&listadato='.$listadato.'&tabla='.$tabla.'&nombrecampoid='.$nombrecampoid.'&nombrecamponombre='.$nombrecamponombre.'&capadato='.$capadato.'&capalista='.$capalista.'\',\'1\');document.getElementById(\''.$capadato.'\').style.display=\'none\'" onClick="abrirAjax(\'#'.$capalista.'\',\''.site_url('informes/data/retornadatoreporte').'\',\'valodato='.html_entity_decode($row[$nombrecampoid]).'&nombrelistadato='.$nombrelistadato.'&listadato='.$listadato.'&tabla='.$tabla.'&nombrecampoid='.$nombrecampoid.'&nombrecamponombre='.$nombrecamponombre.'&capadato='.$capadato.'&capalista='.$capalista.'\',\'1\');document.getElementById(\''.$capadato.'\').style.display=\'none\'" onmouseover="limpiarEstilo(\'buscareporte'.$nombrecamponombre.'\',\'trbusquedareporte'.$nombrecamponombre.$i.'\')">
        				<td nowrap align="left">'.html_entity_decode($row[$nombrecampoid])." ".html_entity_decode($row[$nombrecamponombre]).'</td>
        			</tr>
        			';
        			$i++;
        		}
        		echo '</table>';
            }
        }
    }
    
    
    public function retornadatoreporte()
    {
        $eliminacion        =   $this->arrayRequest['eliminacion'];
        //$listadato          =   $this->arrayRequest['listadato'];
        $listadato          =   $this->input->post('listadato');
        $valodato           =   $this->arrayRequest['valodato'];
        $nombrecampoid      =   $this->arrayRequest['nombrecampoid'];
        $nombrecamponombre  =   $this->arrayRequest['nombrecamponombre'];
        $tabla              =   $this->arrayRequest['tabla'];
        $nombrelistadato    =   $this->arrayRequest['nombrelistadato'];
        $capadato           =   $this->arrayRequest['capadato'];
        $capalista          =   $this->arrayRequest['capalista'];
        
        if($eliminacion==1)
        { 
        	$listadatotemp=split(",",str_replace("\\'","",$listadato));
        	$cant=count($listadatotemp);
        	$listadato="";
        	for($i=0;$i<$cant;$i++)
        	{
        		if(strcmp($listadatotemp[$i],$valodato)!=0)
        		{
        			if($listadato=="")
                    {
        				$listadato="'".$listadatotemp[$i]."'";
                    }
        			else
                    {
        				$listadato.=",'".$listadatotemp[$i]."'";
                    }
        		}
        	}
        }
        else
        {
        	$listadato=stripslashes($listadato);
        	$valodato="'".$valodato."'";
        	if($listadato!="")
        	{
        		if(strpos($listadato,$valodato)===false)
        			$listadato.=",".$valodato;
        	}
        	else
            {
        		$listadato=$valodato;
            }
        }
        if($listadato!="")
        {
        	$sqlDatos="SELECT ".$nombrecampoid.",".$nombrecamponombre."
        				   FROM	  ".$tabla."
        				   WHERE  ".$nombrecampoid." IN (".$listadato.")
        				   ORDER BY ".$nombrecamponombre;
            $queryresult = $this->db->query($sqlDatos);
        	if($queryresult->num_rows()>0)
        	{
        		$listadato1=str_replace("'","",$listadato);
        		echo '<table>';
                foreach($queryresult->result_array() as $row)
        		{
        			echo '
        			<tr class="trcapabusqueda1" style="cursor:pointer" title="Presione click para eliminar el criterio" onclick="abrirAjax_obj(\''.$capalista.'\',\''.site_url('informes/data/retornadatoreporte').'\',\'valodato='.html_entity_decode($row[$nombrecampoid]).'&nombrelistadato='.$nombrelistadato.'&listadato='.$listadato1.'&tabla='.$tabla.'&nombrecampoid='.$nombrecampoid.'&nombrecamponombre='.$nombrecamponombre.'&eliminacion=1&capadato='.$capadato.'&capalista='.$capalista.'\',\'1\');">
        				<td nowrap align="left">'.html_entity_decode($row[$nombrecampoid])." ".html_entity_decode($row[$nombrecamponombre]).'</td>
        			</tr>
        			';
        		}
        		echo '</table>';
        	}
        }
        ?>
        <script type="text/javascript">
        
        //cambiar("<?php echo $nombrelistadato; ?>","<?php echo $listadato?>");
        /*$(document).ready(function(){ 
            $("#<?php echo $nombrecampoid; ?>").attr("value","");
            $("#<?php echo $nombrelistadato; ?>").attr("value","<?php echo $listadato?>");
            //$("#<?=$nombrelistadato?>").focus();
            //$("#<?=$nombrelistadato?>").blur();
            });
            //alert("entro");
            */
        	document.getElementById('<?=$nombrecampoid?>').value="";
        	document.getElementById('<?=$nombrelistadato?>').value="<?=$listadato?>";
        	document.getElementById('<?=$nombrelistadato?>').focus();
        	document.getElementById('<?=$nombrelistadato?>').blur();
            
        </script>
        <?        
    }
	/**
	* Data::consultarconductor()
	*
	* Consulta los datos de los conductores, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarconductor()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idconductor, numerodocumento,primernombre, segundonombre, primerapellido, segundoapellido, conductor, nombrecompleto
        	  FROM	 conductor
        	  WHERE  (numerodocumento LIKE '%".$q."%' OR primernombre  LIKE '%".$q."%' OR segundonombre LIKE '%".$q."%' OR primerapellido LIKE '%".$q."%' OR segundoapellido  LIKE '%".$q."%' OR nombrecompleto  LIKE '%".$q."%')
        	  LIMIT 0 , 20";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idconductor']);
            $row_['value']=html_entity_decode($row['nombrecompleto']." ".$row['numerodocumento']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultargruposanguineo()
	*
	* Consulta los datos de los grupos sanguineos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultargruposanguineo()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idgruposanguineo, nombregruposanguineo
        	  FROM	 gruposanguineo
        	  WHERE  (nombregruposanguineo LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idgruposanguineo']);
            $row_['value']=html_entity_decode($row['nombregruposanguineo']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultargenero()
	*
	* Consulta los datos de los generos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultargenero()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idgenero, nombregenero
        	  FROM	 genero
        	  WHERE  (nombregenero LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idgenero']);
            $row_['value']=html_entity_decode($row['nombregenero']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }

	/**
	* Data::consultarvehiculo()
	*
	* Consulta los datos de los vehiculos, utilizado en la busqueda de los informes.
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
        	  WHERE  (placa LIKE '%".$q."%')
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
	* Data::consultarmarcavehiculo()
	*
	* Consulta los datos de las marcas de los vehiculos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarmarcavehiculo()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idmarcavehiculo, nombremarcavehiculo
        	  FROM	 marcavehiculo
        	  WHERE  (nombremarcavehiculo LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idmarcavehiculo']);
            $row_['value']=html_entity_decode($row['nombremarcavehiculo']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultarmodelo()
	*
	* Consulta los datos de las modelos de los vehiculos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarmodelo()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idmodelo, nombremodelo
        	  FROM	 modelo
        	  WHERE  (nombremodelo LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idmodelo']);
            $row_['value']=html_entity_decode($row['nombremodelo']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultaraseguradora()
	*
	* Consulta los datos de las aseguradoras de los vehiculos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultaraseguradora()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idaseguradora, nombreaseguradora, codigoaseguradora
        	  FROM	 aseguradora
        	  WHERE  (nombreaseguradora LIKE '%".$q."%' OR codigoaseguradora LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idaseguradora']);
            $row_['value']=html_entity_decode($row['nombreaseguradora']." ".$row['codigoaseguradora'] );
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultartipovehiculo()
	*
	* Consulta los datos de los tipos de vehiculos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultartipovehiculo()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idtipovehiculo, nombretipovehiculo
        	  FROM	 tipovehiculo
        	  WHERE  (nombretipovehiculo LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idtipovehiculo']);
            $row_['value']=html_entity_decode($row['nombretipovehiculo']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultarmeses()
	*
	* Consulta los datos de los meses, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarmeses()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idmeses, nombremeses
        	  FROM	 meses
        	  WHERE  (nombremeses LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idmeses']);
            $row_['value']=html_entity_decode($row['nombremeses']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	/**
	* Data::consultarcda()
	*
	* Consulta los datos de los meses, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarcda()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idcda, nombrecda, codigocda
        	  FROM	 cda
        	  WHERE  (nombrecda LIKE '%".$q."%' OR codigocda LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consultaConductor = $this->db->query($sql);
        foreach ($consultaConductor->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idcda']);
            $row_['value']=html_entity_decode($row['nombrecda']." ".$row['codigocda']);
            
        	$lista[]=$row_;
        }
        if(!empty($lista))
        {
        	echo json_encode($lista);
        }
        return $lista;
    }
	
	/**
	* Data::consultarnumeroplanilla()
	*
	* Consulta los datos de las aseguradoras de los vehiculos, utilizado en la busqueda de los informes.
	*
	* @access privado
	* @param string
	* @return json
	*/
    public function consultarnumeroplanilla()
    {
        $q=$this->arrayRequest['tag'];
        $sql="SELECT idplanilla, numeroplanilla
        	  FROM	 planilla
        	  WHERE  (numeroplanilla LIKE '%".$q."%')
        	  LIMIT 0 , 10";
        $consulta = $this->db->query($sql);
        foreach ($consulta->result_array() as $row)
        {
        	$row_['key']=html_entity_decode($row['idplanilla']);
            $row_['value']=html_entity_decode($row['numeroplanilla']);
            
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