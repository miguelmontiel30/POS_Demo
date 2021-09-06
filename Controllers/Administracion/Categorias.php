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

    case 'insertar_nueva_categoria':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos            
        $nombre_categoria = $_POST['nombre_categoria'];
        $descripcion_categoria = $_POST['descripcion_categoria'];
        $estado_categoria = $_POST['estado_categoria'];

        $datos_a_insertar = [$nombre_categoria, $descripcion_categoria, $estado_categoria];

        $consulta = 'INSERT INTO categorias (nombre_categoria, descripcion_categoria, id_estado) 
        VALUES (?, ?, ?);';

        // echo $consulta;

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $datos_a_insertar)) {
            if (isset($respuesta_bd)) { // SE INSERTO CORRECTAMENTE
                $mensaje['respuesta'] = 'Insertado Correctamente';
            }
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar la categoria';
        }

        break;

    case 'consultar_categorias':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT categorias.id_categoria, categorias.nombre_categoria, categorias.descripcion_categoria, estados.estado
                    FROM categorias
                    INNER JOIN estados ON categorias.id_estado = estados.id_estado
                    WHERE categorias.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['categorias'] = $datos;
                $mensaje['estado'] = 'Tiene categorias';
            }
        } else {
            $mensaje['estado'] = 'Sin categorias';
        }

        break;

    case 'actualizar_categoria':

        // Parametros recibidos            
        $nombre_categoria = $_POST['nombre_categoria'];
        $descripcion_categoria = $_POST['descripcion_categoria'];
        $id_estado_categoria = $_POST['id_estado_categoria'];
        $id_categoria = $_POST['id_categoria'];

        $datos_a_actualizar = [$nombre_categoria, $descripcion_categoria, $id_estado_categoria, $id_categoria];

        $consulta = 'UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ?, id_estado = ?  WHERE id_categoria = ?;';

        // echo $consulta;                

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $datos_a_actualizar)) {

            // print_r($respuesta_bd);
            
            $mensaje['respuesta'] = 'Actualizado Correctamente';
            
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE

            print_r($respuesta_bd);
            $mensaje['estado'] = 'Lo sentimos, no se ha podido actualizar';
        }

        break;

    case 'eliminar_categoria':

        // Parametros recibidos
        $id_categoria[0] = $_POST['id_categoria'];

        $consulta = 'UPDATE categorias SET id_estado = "2" WHERE id_categoria = ?;';

        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $id_categoria)) {
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
