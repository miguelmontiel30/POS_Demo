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

    case 'insertar_nuevo_cliente':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                       
        $nombre_cliente = $_POST['nombre_cliente'];
        $correo_cliente = $_POST['correo_cliente'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $rfc_cliente = $_POST['rfc_cliente'];
        $id_estado = $_POST['id_estado'];

        //DATOS DEL DOMICILIO DEL cliente
        $id_domicilio_cliente = $_POST['id_domicilio_cliente'];
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $estado = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $no_interior = $_POST['no_interior'];
        $no_exterior = $_POST['no_exterior'];
        $codigo_postal = $_POST['codigo_postal'];

        $datos_a_insertar_domicilio = [$calle, $colonia, $estado, $ciudad, $no_interior, $no_exterior, $codigo_postal];

        $consulta_domicilio = 'INSERT INTO domicilio_cliente (calle, colonia, estado, ciudad, 
        no_interior, no_exterior, codigo_postal)
        VALUES(?,?,?,?,?,?,?);';

        // echo $consulta_domicilio;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->obtenerUltimoID($consulta_domicilio, $datos_a_insertar_domicilio)) {

            $id_domicilio_cliente = $respuesta_bd;

            $datos_a_insertar_cliente = [$nombre_cliente, $correo_cliente, $telefono_cliente, $rfc_cliente, $id_estado, $id_domicilio_cliente];

            // echo $id_domicilio_cliente;

            $consulta_insertar_cliente = 'INSERT INTO clientes (nombre_cliente, correo_cliente, telefono_cliente,
                                rfc_cliente, id_estado, id_domicilio_cliente)
                                VALUES (?,?,?,?,?,?);';

            if ($respuesta_bd = $querys->ejecutarQuery($consulta_insertar_cliente, $datos_a_insertar_cliente)) {
                $mensaje['respuesta'] = 'Insertado Correctamente';
            }else{

                $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el cliente';
            }
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el domicilio';
        }

        break;

    case 'consultar_clientes':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT clientes.id_cliente, clientes.nombre_cliente, clientes.correo_cliente, clientes.rfc_cliente,
                            estados.estado
                            FROM clientes
                            INNER JOIN estados ON clientes.id_estado = estados.id_estado
                            WHERE clientes.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['clientes'] = $datos;
                $mensaje['estado'] = 'Tiene clientes';
            }
        } else {
            $mensaje['estado'] = 'Sin clientes';
        }

        break;

    case 'actualizar_cliente':

        // Parametros recibidos                
        $id_cliente = $_POST['id_cliente'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $correo_cliente = $_POST['correo_cliente'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $rfc_cliente = $_POST['rfc_cliente'];
        $id_estado = $_POST['id_estado'];

        //DATOS DEL DOMICILIO DEL cliente
        $id_domicilio_cliente = $_POST['id_domicilio_cliente'];
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $estado = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $no_interior = $_POST['no_interior'];
        $no_exterior = $_POST['no_exterior'];
        $codigo_postal = $_POST['codigo_postal'];

        $datos_a_actualizar_domicilio = [$calle, $colonia, $estado, $ciudad, $no_interior, $no_exterior, $codigo_postal, $id_domicilio_cliente];

        $consulta_domicilio = 'UPDATE domicilio_cliente SET calle = ?, colonia = ?, estado = ?,
                                ciudad = ?, no_interior = ?, no_exterior = ?, codigo_postal = ?  WHERE id_domicilio_cliente = ?;';

        // echo $consulta_domicilio;                

        // EVALUAMOS SI SE ACTUALIZA CORRECTAMENTE EL DOMICILIO DEL cliente
        $respuesta_bd = $querys->ejecutarQuery($consulta_domicilio, $datos_a_actualizar_domicilio);

        $datos_a_actualizar_cliente = [$nombre_cliente, $correo_cliente, $telefono_cliente, $rfc_cliente, $id_estado, $id_cliente];

        // print_r($datos_a_actualizar_cliente);

        $consulta_actualizar_cliente = 'UPDATE clientes SET nombre_cliente = ?, correo_cliente = ?, telefono_cliente = ?,
                                rfc_cliente = ?, id_estado = ? WHERE id_cliente = ?;';

        // echo $consulta_actualizar_cliente;

        $resultado_consulta = $querys->ejecutarQuery($consulta_actualizar_cliente, $datos_a_actualizar_cliente);
        $mensaje['respuesta'] = 'Cliente Actualizado';
        // } else { //NO SE PUDO INSERTAR CORRECTAMENTE

        //     // print_r('respuesta_bd');
        //     $mensaje['estado'] = 'Lo sentimos, no se ha podido actualizar el cliente';
        // }



        break;

    case 'eliminar_cliente':

        // Parametros recibidos
        $id_cliente[0] = $_POST['id_cliente'];

        $consulta = 'UPDATE clientes SET id_estado = "2" WHERE id_cliente = ?;';

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $id_cliente)) {
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
