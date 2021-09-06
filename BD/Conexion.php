<?php

require "Config.php";

/* Signos usados para identificar los conceptos utilizados en los comentarios
        () Para describir a una funcion
        {} Para describir un ciclo
        >> Para describir parametros de una funcion
        @@ Para describir un valor que devuelve una funcion

        // Para una simple descripción o alguna parte de codigo que este comentado
*/

class Conexion
{

    // Declaracion de variables
    private $conexion;

    /** () Se ejecuta al momento de ser instanciada la clase 
     * y ejecutara automaticamente la funcion conectar() 
     */
    public function __construct()
    {
        $this->conectar();
    }

    /** () Para realizar la conexion a la BD
     * 
     * >> Parametros: Los parametros usados en esta funcion son invocados
     * desde otro archivo; 'config.php'
     */
    private function conectar()
    {

        // Uso de try{} y catch{} para capturar los posibles errores que ocurran
        try {
            $mbd = new PDO('mysql:host=127.0.0.1;dbname=' . BD . ';charset=utf8', USER, PASS);
            // $mbd = new PDO('mysql:host=localhost:3308;dbname='.BD.';charset=utf8', USER, PASS);
            $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) { // En caso de algún error
            echo "No hay una conexion con la BD";
            die();
        }

        // Pasar el valor de conexion a una variable global privada
        $this->conexion = $mbd;
    }

    /** () Para retornar la variable $conexion que contiene la conexion a la BD
     * 
     * @@ conexion: conexion a la BD
     */
    public function getConexion()
    {
        return $this->conexion;
    }
}
