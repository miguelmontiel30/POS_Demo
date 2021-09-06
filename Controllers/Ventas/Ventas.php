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

    case 'insertar_compra':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                           
        $fecha_compra = $_POST['fecha_compra'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_almacen = $_POST['id_almacen'];
        $id_estado = 1;

        $consulta_insertar_orden_compra = 'INSERT INTO orden_compra(fecha_compra, id_proveedor, id_almacen, id_estado) VALUES(?,?,?,?);';

        $datos_a_insertar = [
            $fecha_compra,
            $id_proveedor,
            $id_almacen,
            $id_estado
        ];

        if ($respuesta_bd = $querys->obtenerUltimoID($consulta_insertar_orden_compra, $datos_a_insertar)) {

            $id_orden_compra[0] = $respuesta_bd;

            $mensaje['respuesta'] = 'Insertado Correctamente';

            //COPIAMOS LOS DATOS TEMPORALES A LA ORDEN DE COMPRA NORMAL
            $consulta_detalle_orden_compra = 'INSERT INTO detalle_orden_compra (cantidad_compra, precio_compra, precio_venta, precio_mayoreo, id_orden_compra, id_estado, id_producto)
                                                SELECT cantidad_compra, precio_compra, precio_venta, precio_mayoreo, ? ,id_estado, id_producto 
                                                FROM detalle_orden_compra_temp 
                                                WHERE detalle_orden_compra_temp.id_estado = 1;';

            // SI SE DUPLICARON CORRECTAMENTE LOS REGISTROS ACTUALIZAMOS LOS DATOS TEMPORALES E INSERTAMOS LOS DATOS DE LA COMPRA
            if ($respuesta_bd = $querys->ejecutarQuery($consulta_detalle_orden_compra, $id_orden_compra)) {

                $consulta_actualizar_temporales = 'UPDATE detalle_orden_compra_temp SET id_estado = "2";';

                // SI SE ACTUALIZARON CORRECTAMENTE LOS REGISTROS TEMPORALES INSERTA LA ORDEN DE COMPRA 
                if ($respuesta_bd = $querys->RegistrosSimples($consulta_actualizar_temporales)) {
                } else {
                    $mensaje['estado'] = 'Lo sentimos, no se pudieron actualizar los datos';
                }
            } else { //NO SE PUDO INSERTAR CORRECTAMENTE

                $mensaje['estado'] = 'Lo sentimos, no se pudieron duplicar los datos';
            }
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar la orden de compra';
        }

        break;
    case 'insertar_venta_temporal':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                           
        $cantidad_venta = $_POST['cantidad_venta'];        
        $precio_venta = $_POST['precio_venta'];
        $id_estado = 1;
        $id_producto = $_POST['id_producto'];

        $datos_a_insertar = [
            $cantidad_venta,
            $precio_venta,
            $id_estado,
            $id_producto
        ];

        // print_r($datos_a_insertar);

        $consulta = 'INSERT INTO detalle_venta_temp
                                        ( 
                                            cantidad_venta,                                            
                                            precio_venta,                                            
                                            id_estado,
                                            id_producto
                                        )
                    VALUES(?,?,?,?);';

        // echo $consulta;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $datos_a_insertar)) {

            $mensaje['respuesta'] = 'Insertado Correctamente';
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el producto';
        }

        break;
    case 'consultar_venta_temporal':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT productos.id_producto, productos.nombre_producto, productos.modelo_producto,
                            estados.estado,
                            detalle_venta_temp.cantidad_vendida, detalle_venta_temp.precio_venta                            
                    FROM detalle_venta_temp
                    INNER JOIN productos ON detalle_venta_temp.id_producto = productos.id_producto                    
                    INNER JOIN estados ON productos.id_estado = estados.id_estado                    
                    WHERE detalle_venta_temp.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['productos'] = $datos;
                $mensaje['estado'] = 'Tiene productos';
            }
        } else {
            $mensaje['estado'] = 'Sin productos';
        }

        break;
    case 'consultar_historial_compras':

        // $id_local[0] = $_SESSION['local']['id_local'];        

        $consulta = "SELECT orden_compra.id_orden_compra, orden_compra.fecha_compra, 
                            COUNT(detalle_orden_compra.id_orden_compra) AS 'no_productos',
                            SUM(detalle_orden_compra.precio_compra * detalle_orden_compra.cantidad_compra ) AS 'total_productos',		 
                            estados.estado,
                            proveedores.nombre_proveedor,
                            almacen.nombre_almacen
                    FROM orden_compra
                    INNER JOIN detalle_orden_compra ON orden_compra.id_orden_compra = detalle_orden_compra.id_orden_compra
                    INNER JOIN estados ON orden_compra.id_estado = estados.id_estado
                    INNER JOIN proveedores ON orden_compra.id_proveedor = proveedores.id_proveedor
                    INNER JOIN almacen ON orden_compra.id_almacen = almacen.id_almacen
                    WHERE orden_compra.id_estado = 1 AND detalle_orden_compra.id_estado = 1
                    GROUP BY detalle_orden_compra.id_orden_compra;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsultaSimple($consulta)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['ordenes_compra'] = $datos;
                $mensaje['estado'] = 'Tiene ordenes de compra';
            }
        } else {
            $mensaje['estado'] = 'Sin ordenes de compra';
        }

        break;

    default:
        # code...
        break;
}

print json_encode($mensaje, JSON_UNESCAPED_UNICODE);
