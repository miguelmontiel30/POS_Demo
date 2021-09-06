<?php

require_once ('Conexion.php');

// header("Content-Type: application/json; charset=UTF-8");

/* Signos usados para identificar los conceptos utilizados en los comentarios
        () Para describir a una funcion
        {} Para describir un ciclo
        >> Para describir parametros de una funcion
        @@ Para describir un valor que devuelve una funcion
        [TYPE] Para saber el tipo de variable que se esta usando en la funcion
        // Para una simple descripción o alguna parte de codigo que este comentado
*/

class Queries{

    // Declaracion de variables
    private $conexion;
    private $info;

    /** () según el total de parametros, retornar signos de interrogacion concatenados y separados por una ','
     * 
     * >> total_parametros: El valor total de los parametros - [Int]
     * @@ signos: signos de interrogación concatenados, ejemplo: ?,?,?,... - [String]
    */
    public function calcularNumSignos($total_parametros){
        $signos = "";
        /** {} Para recorrer el total de parametros. 
         * Por cada parametro, sera concatenado un ? en la variable $signos
        */
        for ($num=0; $num < $total_parametros; $num++) { 
            $signos .= '?,';
        }

        // Eliminar la ultima coma de nuestra cadena
        $signos = substr($signos, 0, -1);
        
        // Valor retornado
        return $signos;
    }

    /** () Se ejecutara al momento de ser instanciada la clase 
     * para crear la conexion a la BD
    */
    public function __construct() {
        $this->conexion = new Conexion(); // Se crea un objeto para instansiar la clase

        // se iguala el valor que devuelve la funcion getConexion() en la variable $conexion
        $this->conexion = $this->conexion->getConexion(); 
    }

    /** () para ejecutar un procedimiento almacenado (SELECT, INSERT, UPDATE, DELETE) 
     *        
     * >> procedure: debe ser Únicamente el nombre del Procedimiento - [String]
     * >> parametros: debe ser un Array con todos los valores que va a llevar el procedimiento, ejemplo;
     *    ['Pablo','Cruz',... ] o Array('Pablo', 'Cruz',... ) - [Array]
     * @@ info: los registros encontrados convertidos en JSON - [Object]
    */
    public function ejecutarProcedure($procedure, $parametros){        
        // Calcular el total de parametros
        $total_parametros = count($parametros);

        // Numero de signos de ? para concatenar la sentencia -> CALL <name>(?,?,?...); <-
        $signos = $this->calcularNumSignos($total_parametros);

        // Se concatena la Sentencia que se va a ejecutar
        $sentencia = "CALL $procedure($signos);";
                
        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran
            
            $statement = $this->conexion->prepare($sentencia); // Preparar la sentencia para ejcutar el procedimiento
            
            $statement->execute($parametros); // finalmente se ejecuta 
            
            // Pasar los registros en aregglos
            $this->info = $statement->fetchAll(PDO::FETCH_ASSOC);                   

        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // echo "{Error: 'Ups! No se pudo realizar la operacion...'},";            
            /*** Informacion para insertar en caso de un error */
            // echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine();   

            return false;         
        }

        // Valor retornado
        return $this->info;
    }

    /** () para ejecutar una consulta normal
     */

    function ejecutarConsulta($sentencia, $parametros){

        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran

            $resultado = $this->conexion->prepare($sentencia);
            
            $resultado->execute($parametros);

            $respuesta_bd = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // Registrar errores en la BD     
            //  echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine(); 
            return false;               
        }

        return $respuesta_bd;
    }    
    
    function ejecutarConsultaSimple($sentencia){

        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran

            $resultado = $this->conexion->prepare($sentencia);
            
            $resultado->execute();

            $respuesta_bd = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // Registrar errores en la BD     
            //  echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine(); 
            return false;               
        }

        return $respuesta_bd;
    }    

    /** () para ejecutar una consulta normal
     */

    function ejecutarQuery($sentencia, $parametros){

        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran

            $resultado = $this->conexion->prepare($sentencia);

            // return $parametros;
            
            $resultado->execute($parametros);

            $respuesta_bd = $resultado->rowCount();
        
        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // Registrar errores en la BD     
            //  echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine(); 
            return false;               
        }

        return $respuesta_bd;
    } 
    
    /** () para ejecutar una consulta normal
     */

    function RegistrosSimples($sentencia){

        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran

            $resultado = $this->conexion->prepare($sentencia);

            // return $parametros;
            
            $resultado->execute();

            $respuesta_bd = $resultado->rowCount();
        
        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // Registrar errores en la BD     
            //  echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine(); 
            return false;               
        }

        return $respuesta_bd;
    } 
    

    /**
     * FUNCION QUE DEVULVE EL ULTIMO ID INSERTADO EN LA BD
     */
    function obtenerUltimoID($sentencia, $parametros){

        try { // Uso de try{} y catch{} para capturar los posibles errores que ocurran

            $resultado = $this->conexion->prepare($sentencia);

            // return $parametros;
            
            $resultado->execute($parametros);

            $respuesta_bd = $this->conexion->lastInsertId();
        
        } catch (PDOException $e) {     // En caso  de algun error con la BD
            // Registrar errores en la BD     
            //  echo $e->getMessage();
            // echo '<br>';
            // echo $e->getFile();
            // echo '<br>';
            // echo $e->getLine(); 
            return false;               
        }

        return $respuesta_bd;
    } 

    function __destruct() {
        $this->conexion = null; // Cerrar la conexion cundo ya no haya referencias al objeto
    }

}
// $foto = null;
// $array = array('Pedro', 'Garcia','1234567890', 2, 'Pabito', '87654321', $foto);
// $array = array('Pedro', '1234567890');
// $array = ['pablocm1747@gmail.com'];
// $querys = new Querys;
// $consulta = "SELECT COUNT(*) AS usuario_registrado FROM usuarios WHERE correo_electronico = ?;";
// $valido = $querys->ejecutarConsulta($consulta, $array);

// print_r($valido);
// // echo "<br>";
// // print_r($info);
// if( isset($valido[0]['respuest']) ){
//     echo "Excelente";
// }else{
//     echo $valido[0]['respuesta'];    
// }

// // $datos = json_decode($valido, true); // Decodificar un Objeto JSON a un Array

//         // Valores obtenidos del procedimiento
//     echo    $r_id_usuario = $valido[0]['id_usuario'];         
//     echo    $r_nombre = $valido[0]['nombre'];
//     echo    $r_apellido = $valido[0]['apellido'];         
//     echo    $r_numero_telefonico = $datos[0]['no_telefonico']; 
//     echo    $r_tipo_usuario = $datos[0]['tipo_usuario']; 
//     echo    $r_nombre_usuario = $datos[0]['nombre_usuario'];         
//     echo    $r_contrasena = $datos[0]['contrasenia']; 

// $prueba = new Queries();

// $dato[0] = 'administrador';

// $resultado = $prueba->ejecutarConsulta('SELECT * FROM usuarios WHERE nombre = ?;', $dato);
// print_r($resultado);
?>