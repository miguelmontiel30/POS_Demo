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

    case 'insertar_nuevo_producto':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                           
        $nombre_producto = $_POST['nombre_producto'];
        $modelo_producto = $_POST['modelo_producto'];
        $stock_existencias = $_POST['stock_existencias'];
        $stock_minimo = $_POST['stock_minimo'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $precio_mayoreo = $_POST['precio_mayoreo'];
        $porcentaje_descuento = $_POST['porcentaje_descuento'];
        $vencimiento = $_POST['vencimiento'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];
        $id_tipo_presentacion = $_POST['id_tipo_presentacion'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_categoria = $_POST['id_categoria'];
        $id_estado = $_POST['id_estado'];

        $datos_a_insertar_producto = [
            $nombre_producto,
            $modelo_producto,
            $stock_existencias,
            $stock_minimo,
            $precio_compra,
            $precio_venta,
            $precio_mayoreo,
            $porcentaje_descuento,
            $vencimiento,
            $fecha_vencimiento,
            $id_tipo_presentacion,
            $id_proveedor,
            $id_categoria,
            $id_estado
        ];

        // print_r($datos_a_insertar_producto);

        $consulta = 'INSERT INTO productos( nombre_producto,
                                            modelo_producto,
                                            stock_existencias,
                                            stock_minimo,
                                            precio_compra,
                                            precio_venta,
                                            precio_mayoreo,
                                            porcentaje_descuento,
                                            vencimiento,
                                            fecha_vencimiento,
                                            id_tipo_presentacion,
                                            id_proveedor,
                                            id_categoria,
                                            id_estado)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);';

        // echo $consulta;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $datos_a_insertar_producto)) {

            $mensaje['respuesta'] = 'Insertado Correctamente';
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el producto';
        }

        break;
    case 'insertar_compra_temporal':

        //SE OBTIENE EL LOCAL QUE ADMINISTRA EL USUARIO            
        // $id_local = $_SESSION['local']['id_local'];

        // Parametros recibidos                           
        $cantidad_compra = $_POST['cantidad_compra'];
        $precio_compra = $_POST['precio_compra'];
        $precio_venta = $_POST['precio_venta'];
        $precio_mayoreo = $_POST['precio_mayoreo'];
        $id_estado = 1;
        $id_producto = $_POST['id_producto'];

        $datos_a_insertar = [
            $cantidad_compra,
            $precio_compra,
            $precio_venta,
            $precio_mayoreo,
            $id_estado,
            $id_producto
        ];

        // print_r($datos_a_insertar);

        $consulta = 'INSERT INTO detalle_orden_compra_temp
                                        ( 
                                            cantidad_compra,
                                            precio_compra,
                                            precio_venta,
                                            precio_mayoreo,
                                            id_estado,
                                            id_producto
                                        )
                    VALUES(?,?,?,?,?,?);';

        // echo $consulta;

        // SI SE INSERTO CORRECTAMENTE
        if ($respuesta_bd = $querys->ejecutarQuery($consulta, $datos_a_insertar)) {

            $mensaje['respuesta'] = 'Insertado Correctamente';
        } else { //NO SE PUDO INSERTAR CORRECTAMENTE
            $mensaje['estado'] = 'Lo sentimos, no se pudo insertar el producto';
        }

        break;

    

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_producto[0] = $_POST['id_producto'];;

        $consulta = "SELECT productos.*,
                            estados.estado,
                            tipo_presentaciones.nombre_presentacion,
                            proveedores.nombre_proveedor,
                            categorias.nombre_categoria
                    FROM productos
                    INNER JOIN estados ON productos.id_estado = estados.id_estado
                    INNER JOIN tipo_presentaciones ON productos.id_tipo_presentacion = tipo_presentaciones.id_tipo_presentacion
                    INNER JOIN proveedores ON productos.id_proveedor = proveedores.id_proveedor
                    INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria
                    WHERE productos.id_producto = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_producto)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['producto'] = $datos;
                $mensaje['estado'] = 'Producto Encontrado';
            }
        } else {
            $mensaje['estado'] = 'El producto no ha sido encontrado';
        }

        break;
    case 'consultar_almacenes':

        // $id_local[0] = $_SESSION['local']['id_local'];
        $id_estado[0] = '1';

        $consulta = "SELECT almacen.*, estados.estado                            
                    FROM almacen                                    
                    INNER JOIN estados ON almacen.id_estado = estados.id_estado                    
                    WHERE almacen.id_estado = ?;";

        // echo $consulta;

        if ($datos = $querys->ejecutarConsulta($consulta, $id_estado)) {
            if (isset($datos[0])) { // Ese usuario no esta registrado            
                $mensaje['almacenes'] = $datos;
                $mensaje['estado'] = 'Tiene almacenes';
            }
        } else {
            $mensaje['estado'] = 'Sin almacenes';
        }

        break;
    
    

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
