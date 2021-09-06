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

    case 'insertar_nuevo_proveedor':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                       
        $nombre_proveedor = $_POST['nombre_proveedor'];
        $correo_proveedor = $_POST['correo_proveedor'];
        $telefono_proveedor = $_POST['telefono_proveedor'];
        $rfc_proveedor = $_POST['rfc_proveedor'];
        $id_estado = $_POST['id_estado'];

        //DATOS DEL DOMICILIO DEL PROVEEDOR
        $id_domicilio_proveedor = $_POST['id_domicilio_proveedor'];
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $estado = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $no_interior = $_POST['no_interior'];
        $no_exterior = $_POST['no_exterior'];
        $codigo_postal = $_POST['codigo_postal'];

        $datos_a_insertar_domicilio = [$calle, $colonia, $estado, $ciudad, $no_interior, $no_exterior, $codigo_postal];

        $consulta_domicilio = 'INSERT INTO domicilio_proveedor (calle, colonia, estado, ciudad, 
        no_interior, no_exterior, codigo_postal)
        VALUES(?,?,?,?,?,?,?);';

        // echo $consulta_domicilio;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->obtenerUltimoID($consulta_domicilio, $datos_a_insertar_domicilio)) {

            $id_domicilio_proveedor = $respuesta_bd;

            $datos_a_insertar_proveedor = [$nombre_proveedor, $correo_proveedor, $telefono_proveedor, $rfc_proveedor, $id_estado, $id_domicilio_proveedor];

            // echo $id_domicilio_proveedor;

            $consulta_insertar_proveedor = 'INSERT INTO proveedores (nombre_proveedor, correo_proveedor, telefono_proveedor,
                                rfc_proveedor, id_estado, id_domicilio_proveedor)
                                VALUES (?,?,?,?,?,?);';

            if ($respuesta_bd = $querys->ejecutarQuery($consulta_insertar_proveedor, $datos_a_insertar_proveedor)) {
                $mensaje['respuesta'] = 'Insertado Correctamente';
            }else{

                $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el proveedor';
            }
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el domicilio';
        }

        break;

    case 'consultar_proveedores':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT proveedores.id_proveedor, proveedores.nombre_proveedor, proveedores.correo_proveedor, proveedores.rfc_proveedor,
                            estados.estado
                            FROM proveedores
                            INNER JOIN estados ON proveedores.id_estado = estados.id_estado
                            WHERE proveedores.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['proveedores'] = $datos;
                $mensaje['estado'] = 'Tiene proveedores';
            }
        } else {
            $mensaje['estado'] = 'Sin proveedores';
        }

        break;

    case 'actualizar_proveedor':

        // Parametros recibidos                
        $id_proveedor = $_POST['id_proveedor'];
        $nombre_proveedor = $_POST['nombre_proveedor'];
        $correo_proveedor = $_POST['correo_proveedor'];
        $telefono_proveedor = $_POST['telefono_proveedor'];
        $rfc_proveedor = $_POST['rfc_proveedor'];
        $id_estado = $_POST['id_estado'];

        //DATOS DEL DOMICILIO DEL PROVEEDOR
        $id_domicilio_proveedor = $_POST['id_domicilio_proveedor'];
        $calle = $_POST['calle'];
        $colonia = $_POST['colonia'];
        $estado = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $no_interior = $_POST['no_interior'];
        $no_exterior = $_POST['no_exterior'];
        $codigo_postal = $_POST['codigo_postal'];

        $datos_a_actualizar_domicilio = [$calle, $colonia, $estado, $ciudad, $no_interior, $no_exterior, $codigo_postal, $id_domicilio_proveedor];

        $consulta_domicilio = 'UPDATE domicilio_proveedor SET calle = ?, colonia = ?, estado = ?,
                                ciudad = ?, no_interior = ?, no_exterior = ?, codigo_postal = ?  WHERE id_domicilio_proveedor = ?;';

        // echo $consulta_domicilio;                

        // EVALUAMOS SI SE ACTUALIZA CORRECTAMENTE EL DOMICILIO DEL PROVEEDOR
        $respuesta_bd = $querys->ejecutarQuery($consulta_domicilio, $datos_a_actualizar_domicilio);

        $datos_a_actualizar_proveedor = [$nombre_proveedor, $correo_proveedor, $telefono_proveedor, $rfc_proveedor, $id_estado, $id_proveedor];

        // print_r($datos_a_actualizar_proveedor);

        $consulta_actualizar_proveedor = 'UPDATE proveedores SET nombre_proveedor = ?, correo_proveedor = ?, telefono_proveedor = ?,
                                rfc_proveedor = ?, id_estado = ? WHERE id_proveedor = ?;';

        // echo $consulta_actualizar_proveedor;

        $resultado_consulta = $querys->ejecutarQuery($consulta_actualizar_proveedor, $datos_a_actualizar_proveedor);
        $mensaje['respuesta'] = 'Proveedor Actualizado';
        // } else { //NO SE PUDO INSERTAR CORRECTAMENTE

        //     // print_r('respuesta_bd');
        //     $mensaje['estado'] = 'Lo sentimos, no se ha podido actualizar el proveedor';
        // }



        break;

    case 'eliminar_proveedor':

        // Parametros recibidos
        $id_proveedor[0] = $_POST['id_proveedor'];

        $consulta = 'UPDATE proveedores SET id_estado = "2" WHERE id_proveedor = ?;';

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $id_proveedor)) {
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
