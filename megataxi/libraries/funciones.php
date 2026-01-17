<?php
/*
A). En el agi se reciben como parametros el callerID, correspondiente 
    a id_cuenta en cuenta_sip y el numero de destino.

B). Teniendo el id_cuenta se identifica al cliente y al distribuidor. y se cargan
    sus respectivos datos.

C). si el numero marcado es 600 informarle al cliente acerca de su saldo.


D). Establecer los datos para tarifacion de la siguiente manera:
   
   1. identificar el indicativo acorde a el numero de destino ingresado
   
   
   2. si se encuentra una deficion en def_especial_c para ese indicativo.
      utilizar esta tarifa.

   EN OTRO CASO

   3. si se encuentra una deficion en def_especial_d para ese indicativo.. dar prioridad 
      a dicha tarifa Y saltar al paso 5.

   4. Acorde al no_plan del distribuidor y segun el valor de porcentaje en la tabla
      plan_distribuidor incrementar el valor hacia el destino.. previamente definido en
      el campo precio_costo de la tabla destino.


   5. Acorde al no_plan del cliente y segun el valor de porcentaje en la tabla
      plan_cliente incrementar el valor hacia el destino establecido anteriormente
      
      
*/

    
  
    
    
    
    class Persona{

/*        
        +-----------------+-------------+------+-----+---------+----------------+
| Field           | Type        | Null | Key | Default | Extra          |
+-----------------+-------------+------+-----+---------+----------------+
| id_cliente  *    | int(11)     | NO   | PRI | NULL    | auto_increment |
| id_distribuidor | int(11)     | NO   | MUL |         |                |
| no_plan      *   | bigint(20)  | NO   | MUL |         |                |
| nombre        *  | varchar(50) | NO   |     |         |                |
| direccion     *  | varchar(60) | NO   |     |         |                |
| telefonos   *    | varchar(30) | NO   |     |         |                |
| celular   *      | varchar(30) | NO   |     |         |                |
| id_ciudad   *    | int(11)     | NO   | MUL |         |                |
| usuario     *    | varchar(25) | NO   |     |         |                |
| clave        *   | varchar(25) | NO   |     |         |                |
| saldo      *     | int(11)     | NO   |     |         |                |
| estado      *    | tinyint(1)  | NO   |     |         |                |
| fax       *      | varchar(30) | NO   |     |         |                |
+-----------------+-------------+------+-----+---------+----------------+
13 rows in set (0.01 sec)

Campos en comun

id_persona
nombre
plan
direccion
telefono
celular
fax
id_ciudad
usuario
clave
saldo
estado


mysql> describe distribuidor;
+-----------------+-------------+------+-----+---------+----------------+
| Field           | Type        | Null | Key | Default | Extra          |
+-----------------+-------------+------+-----+---------+----------------+
| id_distribuidor * | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre          *| varchar(50) | NO   | MUL |         |                |
| direccion    *   | varchar(60) | NO   |     |         |                |
| telefonos    *   | varchar(30) | NO   |     |         |                |
| fax         *    | varchar(30) | NO   |     |         |                |
| celular    *     | varchar(30) | NO   |     |         |                |
| id_ciudad  *     | int(11)     | NO   | MUL |         |                |
| id_tipo         | int(11)     | NO   | MUL |         |                |
| saldo      *     | int(11)     | NO   |     |         |                |
| usuario    *     | varchar(25) | NO   |     |         |                |
| clave     *      | varchar(25) | NO   |     |         |                |
| estado      *    | tinyint(1)  | NO   |     |         |                |
| no_plan     *    | int(11)     | NO   | MUL |         |                |
| id_trunk        | int(11)     | NO   |     |         |                |
+-----------------+-------------+------+-----+---------+----------------+
13 rows in set (0.00 sec)
*/

    private $id_persona;
    private $nombre;
    private $direccion;
    private $telefono;
    private $celular;
    private $fax;
    private $id_ciudad;
    private $plan;
    private $usuario;
    private $clave;
    private $saldo;
    private $estado;
    private $link;


    public function __construct(/*id_persona,nombre,direccion,telefono,celular,fax,id_ciudad,id_plan,usuario,clave,saldo,estado*/){
        $this->$id_persona=func_get_arg(0);
        $this->$nombre=func_get_arg(1);
        $this->$direccion=func_get_arg(2);
        $this->$telefono=func_get_arg(3);
        $this->$celular=func_get_arg(4);
        $this->$fax=func_get_arg(5);
        $this->$id_ciudad=func_get_arg(6);
        $this->$plan=func_get_arg(7);
        $this->$usuario=func_get_arg(8);
        $this->$clave=func_get_arg(9);
        $this->$saldo=func_get_arg(10);
        $this->$estado=func_get_arg(11); 
        
    }

        
        public function set_link(){
            $this->link=func_get_arg(0); 
        }
        
        public function set_id(){
            $this->id_persona=func_get_arg(0); 
        }
        public function set_nombre(){
            $this->nombre=func_get_arg(0);          
        } 
        public function set_plan(){
            $this->plan=func_get_arg(0);           
        }
        public function set_direccion(){
            $this->direccion=func_get_arg(0);    
        }
        public function set_telefono(){
            $this->telefono=func_get_arg(0);
        }
        public function set_celular(){
            $this->celular=func_get_arg(0);            
        }
        public function set_fax(){
            $this->fax=func_get_arg(0);
        }
        public function set_id_ciudad(){
            $this->id_ciudad=func_get_arg(0);            
        }
        public function set_usuario(){
            $this->usuario=func_get_arg(0);            
        }
        public function set_clave(){
            $this->clave=func_get_arg(0);
        }
        public function set_saldo(){
            $this->saldo=func_get_arg(0);            
        }
        public function set_estado(){
            $this->estado=func_get_arg(0);                                    
        }
        
        public function get_link(){
            return $this->link;
        }
        
        public function get_id(){
            return $this->id_persona;  
        }
        public function get_nombre(){
            return $this->nombre;         
        }
        public function get_plan(){
            return $this->plan;
        }
        public function get_direccion(){
            return $this->direccion;                     
        }
        public function get_telefono(){
            return $this->telefono;   
        }
        public function get_celular(){
            return $this->celular;
        }
        public function get_fax(){
            return $this->fax;
        }
        public function get_id_ciudad(){
            return $this->id_ciudad;
        }
        public function get_usuario(){
            return $this->usuario;
        }
        public function get_clave(){
            return $this->clave;
        }
        public function get_saldo(){
            return $this->saldo;
        }
        public function get_estado(){
            return $this->estado;
        }

        
    }
    
    class Distribuidor extends Persona{
        
        //Estos son los atributos que tiene distribuidor que no tiene cliente
        private id_tipo;
        private id_trunk;
        
        public function __construct(){
            parent::__construct(func_get_arg(0),func_get_arg(1),func_get_arg(2),func_get_arg(3),func_get_arg(4),func_get_arg(5),func_get_arg(6),func_get_arg(7),func_get_arg(8),func_get_arg(9),func_get_arg(10),func_get_arg(11));
            $this->id_tipo=func_get_arg(12);
            $this->id_trunk=func_get_arg(13);           
        }

        public function registrar(){
            $sql="insert into distribuidor(nombre,direccion,fax,celular,id_ciudad,id_tipo,saldo,usuario,clave,no_plan,id_trunk) values('$this->nombre','$this->direccion','$this->fax','$this->celular','$this->id_ciudad','$this->id_tipo','$this->saldo','$this->usuario','$this->clave','$this->no_plan','$this->id_trunk')";
            if($result=mysql_query($sql,$this->link)){
                $sqlId="select LAST_INSERT_ID() as id from distribuidor";
                $resultId=mysql_query($sqlId,$this->link);
                $row_id=mysql_fetch_assoc($resultId);
            }
            return $row_id[id]?$row_id[id]:$result;
        }
        
        public function actualizar(){
            $sql="update distribuidor set nombre='$this->nombre', direccion='$this->direccion', fax='$this->fax', celular='$this->celular', id_ciudad='$this->id_ciudad', id_tipo='$this->id_tipo', saldo='$this->saldo', usuario='$this->usuario', clave='$this->clave', no_plan='$this->plan', id_trunk='$this->id_trunk' where distribuidor_id='$this->id_persona'";
            $result=mysql_query($sql,$this->link);
            return $result;
        }
        
        public function select_by_id(){
            $sql="select * from distribuidor where distribuidor_id='$this->id_persona'";
            $result=mysql_query($sql,$this->link);
            $object=mysql_fetch_object($result);
            
            $this->id_persona=$object->id_distribuidor;
            $this->nombre=$object->nombre;
            $this->direccion=$object->direccion;
            $this->telefono=$object->telefono;
            $this->celular=$object->celular;
            $this->fax=$object->fax;
            $this->id_ciudad=$object->id_ciudad;
            $this->plan=$object->no_plan;
            $this->usuario=$object->usuario;
            $this->clave=$object->clave;
            $this->saldo=$object->saldo;
            $this->estado=$object->estado;
            
            return $result;

        }
    }
    
   

	
    
    $SqlCuenta="select * from cuenta_sip where id_cuenta='".$CallerId."'";
    $ResultCuenta=mysql_query($SqlCuenta,$link);
    $ObjectCuenta=mysql_fetch_object($ResultCuenta);


function cliente($CallerId,$link){    
    $SqlCliente="select * from cliente";
}


?>