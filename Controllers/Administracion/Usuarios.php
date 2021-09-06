<?php


include('../../BD/Queries.php');



// Obtener los valores por metodo POST    
if (isset($_POST['funcion'])) {
    $funcion = $_POST['funcion'];
}

// $funcion = 'actualizar_ingrediente';


// Creacion de objetos para instanciar Clases
$querys = new Queries;
$mensaje;


// ejecutara el código segun el parametro que reciba
switch ($funcion) {

    case 'insertar_nuevo_usuario':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                           
        $nombre = $_POST['nombre'];
        $correo_electronico = $_POST['correo_electronico'];
        $no_telefonico = $_POST['no_telefonico'];
        $nombre_acceso = $_POST['nombre_acceso'];
        $contrasena = $_POST['contrasena'];
        $id_estado = $_POST['id_estado'];
        $id_tipo_usuario = $_POST['id_tipo_usuario'];

        $datos_a_insertar_usuario = [$nombre, $correo_electronico, $no_telefonico, $nombre_acceso, $contrasena, $id_estado, $id_tipo_usuario];

        $consulta_usuario = 'INSERT INTO usuarios (nombre, correo_electronico, no_telefonico, nombre_acceso, 
        contrasena, id_estado, id_tipo_usuario)
        VALUES(?,?,?,?,?,?,?);';

        // echo $consulta_usuario;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->ejecutarQuery($consulta_usuario, $datos_a_insertar_usuario)) {

            $mensaje['respuesta'] = 'Insertado Correctamente';

        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el usuario';
        }

        break;

    case 'consultar_usuarios':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT usuarios.id_usuario, usuarios.nombre, 
                            usuarios.id_estado, estados.estado,
                            tipo_usuarios.id_tipo_usuario, tipo_usuarios.tipo_usuario
                    FROM usuarios
                    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
                    INNER JOIN tipo_usuarios ON usuarios.id_tipo_usuario = tipo_usuarios.id_tipo_usuario
                    WHERE usuarios.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['usuarios'] = $datos;
                $mensaje['estado'] = 'Tiene usuarios';
            }
        } else {
            $mensaje['estado'] = 'Sin usuarios';
        }

        break;

    case 'actualizar_usuario':

        // Parametros recibidos                
        $id_usuario = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $correo_electronico = $_POST['correo_electronico'];
        $no_telefonico = $_POST['no_telefonico'];
        $nombre_acceso = $_POST['nombre_acceso'];
        $contrasena = $_POST['contrasena'];
        $id_estado = $_POST['id_estado'];
        $id_tipo_usuario = $_POST['id_tipo_usuario'];


        $datos_a_insertar_usuario = [$nombre, $correo_electronico, $no_telefonico, $nombre_acceso, $contrasena, $id_estado, $id_tipo_usuario, $id_usuario];

        $consulta_domicilio = 'UPDATE usuarios SET nombre = ?, correo_electronico = ?, no_telefonico = ?,
                                nombre_acceso = ?, contrasena = ?, id_estado = ?, id_tipo_usuario = ?  WHERE id_usuario = ?;';

        // echo $consulta_domicilio;                

        // EVALUAMOS SI SE ACTUALIZA CORRECTAMENTE EL DOMICILIO DEL cliente
        if ($respuesta_bd = $querys->ejecutarQuery($consulta_domicilio, $datos_a_insertar_usuario)) {

            $mensaje['respuesta'] = 'Usuario Actualizado';
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE

            // print_r('respuesta_bd');
            $mensaje['estado'] = 'Lo sentimos, no se ha podido actualizar el usuario';
        }



        break;

    case 'eliminar_usuario':

        // Parametros recibidos
        $id_usuario[0] = $_POST['id_usuario'];

        $consulta = 'UPDATE usuarios SET id_estado = "2" WHERE id_usuario = ?;';

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $id_usuario)) {
            if (isset($respuesta_bd)) { // SE INSERTO CORRECTAMENTE
                $mensaje['respuesta'] = 'Eliminado Correctamente';
            }
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se ha podido actualizar';
        }
        break;

    default:
        # code...
        break;
}

print json_encode($mensaje, JSON_UNESCAPED_UNICODE);
