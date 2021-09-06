$(document).ready(function () {

    // INICIALIZACIONES DE LAS FUNCIONES DE LOS INPUTS CON MDBOOTSTRAP
    $('input').characterCounter();
    $('.mdb-select').materialSelect();
    // $('.file-upload').file_upload();


    $("#form_producto").on('submit', function (event) {
        // console.log("Entro");
        event.preventDefault();

        let id_producto = ($('#id_producto').val() == '' || $('#id_producto').val() == null) ?
            'Guardar Producto' :
            $('#id_producto').val();

        // console.log(id_categoria);

        if (id_producto == 'Guardar Producto') {
            insertarProducto();
        } else {
            actualizarProducto();
        }

    });


    //LLENAMOS LOS SELECTS DE LA DATA CORRESPODIENTE
    llenarSelectProveedores();
    llenarSelectCategorias();
    llenarSelectPresentacionProducto();


});

function llenarSelectPresentacionProducto() {

    // VACIAMOS LA TABLA DE CONTENIDO
    $("#id_tipo_presentacion").empty();

    $.ajax({
        method: "POST",
        url: "./Controllers/Productos/Producto.php",
        data: {
            funcion: 'consultar_tipo_presentacion'
        }
    }).done(function (respuesta_servidor) {
        // console.log(respuesta_servidor);
        let datos_tipo_presentacion = JSON.parse(respuesta_servidor);
        // console.log(datos_categorias);

        if (datos_tipo_presentacion.estado = "Tiene tipos presentacion") {

            $("#id_tipo_presentacion").append('<option value="" selected="">Presentación del Producto</option>');
            
            datos_tipo_presentacion.presentaciones.forEach(presentacion => {
                
                $("#id_tipo_presentacion").append('<option value="' + presentacion.id_tipo_presentacion + '">' + presentacion.nombre_presentacion + '</option>');

            });

        } else {

        }
    });
}


function llenarSelectCategorias() {

    // VACIAMOS LA TABLA DE CONTENIDO
    $("#id_categoria").empty();

    $.ajax({
        method: "POST",
        url: "./Controllers/Administracion/Categorias.php",
        data: {
            funcion: 'consultar_categorias'
        }
    }).done(function (respuesta_servidor) {
        // console.log(respuesta_servidor);
        let datos_categorias = JSON.parse(respuesta_servidor);
        // console.log(datos_categorias);

        if (datos_categorias.estado = "Tiene categorias") {

            $("#id_categoria").append('<option value="" selected="">Seleccione una Categoria</option>');
            
            datos_categorias.categorias.forEach(categoria => {
                
                $("#id_categoria").append('<option value="' + categoria.id_categoria + '">' + categoria.nombre_categoria + '</option>');

            });

        } else {

        }
    });
}


function llenarSelectProveedores() {

    // VACIAMOS LA TABLA DE CONTENIDO
    $("#id_proveedor").empty();

    $.ajax({
        method: "POST",
        url: "./Controllers/Administracion/Proveedores.php",
        data: {
            funcion: 'consultar_proveedores'
        }
    }).done(function (respuesta_servidor) {

        // console.log(respuesta_servidor);
        let datos_proveedores = JSON.parse(respuesta_servidor);
        // console.log(datos_categorias);

        if (datos_proveedores.estado = "Tiene proveedores") {

            $("#id_proveedor").append('<option value="" selected="">Seleccione un Proveedor</option>');

            //RECORREMOS EL ARRAY E INSERTAMOS UN NUEVO ELEMENTO POR CADA PROVEEDOR
            datos_proveedores.proveedores.forEach(proveedor => {

                $("#id_proveedor").append('<option value="' + proveedor.id_proveedor + '">' + proveedor.nombre_proveedor + '</option>');
            });

        } else {
            console.log("dsa");
        }
    });
}


function insertarProducto() {

    // console.log("inserta");

    let nombre_producto = $("#nombre_producto").val();
    let modelo_producto = $("#modelo_producto").val();
    let stock_existencias = $("#stock_existencias").val();
    let stock_minimo = $("#stock_minimo").val();
    let precio_compra = $("#precio_compra").val();
    let precio_venta = $("#precio_venta").val();
    let precio_mayoreo = $("#precio_mayoreo").val();
    let porcentaje_descuento = $("#porcentaje_descuento").val();
    let vencimiento = $('input[name="vencimiento"]:checked').val();
    let fecha_vencimiento = ( $("#fecha_vencimiento").val() == '') ? '0000-00-00' : $("#fecha_vencimiento").val();
    let id_tipo_presentacion = $("#id_tipo_presentacion").val();
    let id_proveedor = $("#id_proveedor").val();
    let id_categoria = $("#id_categoria").val();
    let id_estado = $("#id_estado").val();    

    $.ajax({
        method: "POST",
        url: "./Controllers/Productos/Producto.php",
        data: {
            funcion: 'insertar_nuevo_producto',
            nombre_producto: nombre_producto,
            modelo_producto: modelo_producto,
            stock_existencias: stock_existencias,
            stock_minimo: stock_minimo,
            precio_compra: precio_compra,
            precio_venta: precio_venta,
            precio_mayoreo: precio_mayoreo,
            porcentaje_descuento: porcentaje_descuento,
            vencimiento: vencimiento,
            fecha_vencimiento: fecha_vencimiento,
            id_tipo_presentacion: id_tipo_presentacion,
            id_proveedor: id_proveedor,
            id_categoria: id_categoria,
            id_estado: id_estado
        }
    }).done(function (respuesta_servidor) {
        console.log(respuesta_servidor);
        let respuesta_producto = JSON.parse(respuesta_servidor);

        if (respuesta_producto.respuesta == 'Insertado Correctamente') {

            Swal.fire({
                icon: 'success',
                title: '¡Correcto!',
                text: 'El producto ha sido dada de alta'
            });

            setTimeout(() => {
                cambiarVentana('Views/Administracion/Productos');
            }, 1500);

        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Vaya!',
                text: 'No se ha insertado correctamente, verifique que los datos sean correctos.'
            });
        }
    });
}


function actualizarUsuario() {

    // OBTENEMOS LOS DATOS QUE VAMOS A ACTUALIZAR
    let id_usuario = $("#id_usuario").val();
    let nombre = $("#nombre").val();
    let correo_electronico = $("#correo_electronico").val();
    let no_telefonico = $("#no_telefonico").val();
    let id_estado = $("#id_estado_cliente").val();
    let nombre_acceso = $("#nombre_acceso").val();
    let contrasena = $("#contrasena").val();
    let id_tipo_usuario = $("#id_tipo_usuario").val();

    $.ajax({
        method: "POST",
        url: "./Controllers/Administracion/Usuarios.php",
        data: {
            funcion: 'actualizar_usuario',
            id_usuario: id_usuario,
            nombre: nombre,
            correo_electronico: correo_electronico,
            no_telefonico: no_telefonico,
            nombre_acceso: nombre_acceso,
            contrasena: contrasena,
            id_estado: id_estado,
            id_tipo_usuario: id_tipo_usuario
        }
    }).done(function (respuesta_servidor) {
        // console.log(respuesta_servidor);
        let respuesta_cliente = JSON.parse(respuesta_servidor);

        if (respuesta_cliente.respuesta == 'Usuario Actualizado') {

            Swal.fire({
                icon: 'success',
                title: '¡Correcto!',
                text: 'El usuario ha sido actualizado'
            });

            setTimeout(() => {
                cambiarVentana('Views/Administracion/Usuarios');
            }, 1500);

        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Vaya!',
                text: 'No se ha podido actualizar correctamente, verifique que los datos sean correctos.'
            });
        }
    });
}