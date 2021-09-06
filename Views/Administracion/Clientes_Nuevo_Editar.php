<?php


include('../../BD/Queries.php');

// DEFINICION DEL ASPECTO QUE TENDRA EL TITULO DE LA INTERFAZ Y LAFUNCION DEL BOTON
$button_interfaz;
$titulo_interfaz;

//SE CONSULTA SI HAY UN PARAMETRO ENVIADO (QUE EN DADO CASO QUE HAYA SE TRATA DE EDITAR UN REGISTRO)
if (isset($_GET['id_cliente'])) {

    // Creacion de objetos para instanciar Clases
    $queries = new Queries;

    $id_cliente[0] = $_GET['id_cliente'];
    // $id_categoria[0] = '4';

    $consulta = "SELECT clientes.id_cliente, clientes.nombre_cliente, clientes.correo_cliente, 
                    clientes.telefono_cliente, clientes.rfc_cliente,
                    domicilio_cliente.id_domicilio_cliente, domicilio_cliente.calle, domicilio_cliente.colonia,
                    domicilio_cliente.no_exterior, domicilio_cliente.no_interior, domicilio_cliente.ciudad, 
                    domicilio_cliente.estado, domicilio_cliente.codigo_postal,
                    estados.id_estado, estados.estado AS 'estado_cliente'
                    FROM clientes
                    INNER JOIN estados ON clientes.id_estado = estados.id_estado
                    INNER JOIN domicilio_cliente ON clientes.id_domicilio_cliente = domicilio_cliente.id_domicilio_cliente
                    WHERE clientes.id_cliente = ?;";

    // echo $consulta;

    if ($datos = $queries->ejecutarConsulta($consulta, $id_cliente)) {
        // print_r($datos[0]);

        //VACIAMOS LOS DATOS DEL cliente QUE SE VA A EDITAR
        $id_cliente = $datos[0]['id_cliente'];
        $nombre_cliente = $datos[0]['nombre_cliente'];
        $correo_cliente = $datos[0]['correo_cliente'];
        $telefono_cliente = $datos[0]['telefono_cliente'];
        $rfc_cliente = $datos[0]['rfc_cliente'];
        $id_estado = $datos[0]['id_estado'];

        //DATOS DEL DOMICILIO DEL cliente
        $id_domicilio_cliente = $datos[0]['id_domicilio_cliente'];
        $calle = $datos[0]['calle'];
        $colonia = $datos[0]['colonia'];
        $estado = $datos[0]['estado'];
        $ciudad = $datos[0]['ciudad'];
        $no_interior = $datos[0]['no_interior'];
        $no_exterior = $datos[0]['no_exterior'];
        $codigo_postal = $datos[0]['codigo_postal'];

        $button_interfaz = '<button class="btn btn-outline-primary btn-block my-4 waves-effect z-depth-0" type="submit">
                                <i class="fas fa-save ml-1"></i>
                                Editar Cliente
                            </button>';

        $titulo_interfaz = 'Editar Cliente';
    } else {

        $mensaje['estado'] = 'Sin clientes';
    }
} else { //SI NO HAY DATOS ENVIADOS SE TRATA DE UN REGISTRO NUEVO

    $button_interfaz = '<button class="btn btn-outline-success btn-block my-4 waves-effect z-depth-0" type="submit">
                            <i class="fas fa-save ml-1"></i>
                            Crear Nuevo Cliente
                        </button>';

    $titulo_interfaz = 'Nuevo cliente';
}

?>
<div class="container-fluid">

    <form class="card" id="form_cliente">

        <h3 class="text-center h3-responsive h3 my-3">
            <i style="font-size: 1.6rem;" class="fas fa-truck-loading ml-1"></i>
            <?php echo $titulo_interfaz; ?>
        </h3>

        <div class="card-body px-4">

            <!-- CONTENEDOR DE LOS DATOS DE CONTACTO Y BANCARIOS -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="far fa-address-card mr-2"></i>Datos del Cliente
                </h4>

                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO cliente -->
                <div class="row">

                    <!-- ID_cliente ES UN INPUT OCULTO SIRVE PARA EDITAR EL cliente -->
                    <input type="hidden" id="id_cliente" value="<?php echo $id_cliente; ?>">

                    <!-- Nombre -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <input class="form-control" type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo $nombre_cliente; ?>" required>
                            <label for="nombre_cliente" class="active">Nombre</label>
                        </div>
                    </div>
                    <!-- Nombre -->

                    <!-- Correo -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="correo_cliente" class="active">Correo</label>
                            <input class="form-control" type="text" id="correo_cliente" name="correo_cliente" value="<?php echo $correo_cliente; ?>">
                        </div>
                    </div>
                    <!-- Correo -->

                    <!-- Telefono -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="telefono_cliente" class="active">Telefono</label>
                            <input class="form-control" type="text" id="telefono_cliente" name="telefono_cliente" value="<?php echo $telefono_cliente; ?>" required>
                        </div>
                    </div>
                    <!-- Telefono -->

                </div>
                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO cliente -->

                <!-- CONTENEDOR CON ESTADO Y RFC DEL cliente-->
                <div class="row">

                    <!-- ESTADO DEL cliente -->
                    <div class="form-group col-md-4">
                        <select id="id_estado_cliente" class="mdb-select md-form" required>
                            <option value="" disabled selected>Estado del cliente</option>
                            <option value="1" <?= $id_estado == '1' ? ' selected="selected"' : ''; ?>>Habilitado</option>
                            <option value="2" <?= $id_estado == '2' ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
                        </select>
                    </div>
                    <!-- ESTADO DEL cliente -->

                    <!-- RFC -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="rfc_cliente" class="active">RFC</label>
                            <input class="form-control" type="text" id="rfc_cliente" name="rfc_cliente" value="<?php echo $rfc_cliente; ?>">
                        </div>
                    </div>
                    <!-- RFC -->

                    <!-- Cuentas Bancarias -->
                    <!-- <div class="form-group col-md-3">
                <select class="mdb-select md-form" id="cuenta_bancaria" name="cuenta_bancaria">
                    <option value="" disabled selected>Cuentas Bancarias Disponibles</option>
                    <option value="">Ninguna cuenta</option>
                </select>
            </div> -->
                    <!-- Cuentas Bancarias -->

                </div>
                <!-- CONTENEDOR CON ESTADO Y RFC DEL cliente -->

            </div>
            <!-- CONTENEDOR DE LOS DATOS DE CONTACTO Y BANCARIOS -->

            <!-- CONTENEDOR CON LOS DATOS DEL DOMICILIO DEL NUEVO cliente -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="far fa-address-card mr-2"></i>Domicilio del Cliente
                </h4>

                <!-- CONTENEDOR DE CALLE, COLONIA Y CP -->
                <div class="row">

                    <!-- ID_CATEGORIA ES UN INPUT OCULTO SIRVE PARA EDITAR LA CATEGORIA -->
                    <input type="hidden" id="id_domicilio_cliente" value="<?php echo $id_domicilio_cliente; ?>">

                    <!-- Calle -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="calle" class="active">Calle</label>
                            <input class="form-control" type="text" id="calle" name="calle" value="<?php echo $calle; ?>">
                        </div>
                    </div>
                    <!-- Calle -->

                    <!-- Colonia -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="colonia" class="active">Colonia</label>
                            <input class="form-control" type="text" id="colonia" name="colonia" value="<?php echo $colonia; ?>">
                        </div>
                    </div>
                    <!-- Colonia -->

                    <!-- Código postal -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="codigo_postal" class="active">Código postal</label>
                            <input class="form-control" type="text" id="codigo_postal" name="codigo_postal" value="<?php echo $codigo_postal; ?>">
                        </div>
                    </div>
                    <!-- Código postal -->

                </div>
                <!-- CONTENEDOR DE CALLE, COLONIA Y CP -->

                <!-- NUMERO INTERIOR Y EXTERIOR -->
                <div class="row">

                    <!-- Numero Exterior -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <label for="no_exterior" class="active">Numero Exterior</label>
                            <input class="form-control" type="text" id="no_exterior" name="no_exterior" value="<?php echo $no_exterior; ?>">
                        </div>
                    </div>
                    <!-- Numero Exterior -->

                    <!-- Número Interior -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <label for="no_interior" class="active">Número Interior</label>
                            <input class="form-control" type="text" id="no_interior" name="no_interior" value="<?php echo $no_interior; ?>">
                        </div>
                    </div>
                    <!-- Número Interior -->

                </div>
                <!-- NUMERO INTERIOR Y EXTERIOR -->

                <!-- CONTENEDOR DE CIUDAD Y ESTADO -->
                <div class="row">

                    <!-- Ciudad -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <label for="ciudad" class="active">Ciudad</label>
                            <input class="form-control" type="text" id="ciudad" name="ciudad" value="<?php echo $ciudad; ?>">
                        </div>
                    </div>
                    <!-- Ciudad -->

                    <!-- Estado -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <label for="estado" class="active">Estado</label>
                            <input class="form-control" type="text" id="estado" name="estado" value="<?php echo $estado; ?>">
                        </div>
                    </div>
                    <!-- Estado -->

                    <div class="col-md-4 d-none">
                        <div class="md-form">
                            <label for="txt_delegacion">Delegación</label>
                            <input class="form-control" type="text" id="txt_delegacion" name="txt_delegacion" value="">
                        </div>
                    </div>

                </div>
                <!-- CONTENEDOR DE CIUDAD Y ESTADO -->

            </div>

        </div>
        <!-- CONTENEDOR CON LOS DATOS DEL DOMICILIO DEL NUEVO cliente -->

        <!-- CONTENEDOR DE LOS BOTONES -->
        <div class="container-fluid">

            <?php echo $button_interfaz; ?>

            <button id="regresar" class="btn btn-outline-danger btn-block my-4 waves-effect z-depth-0" type="button">
                <i class="fas fa-arrow-left ml-1"></i>
                Regresar
            </button>

        </div>
        <!-- CONTENEDOR DE LOS BOTONES -->

    </form>

</div>

<script>
    $(document).ready(function() {

        // INICIALIZACIONES DE LAS FUNCIONES DE LOS INPUTS CON MDBOOTSTRAP
        $('input').characterCounter();
        $('.mdb-select').materialSelect();

        $("#form_cliente").on('submit', function(event) {
            // console.log("Entro");
            event.preventDefault();

            let id_cliente = ($('#id_cliente').val() == '' || $('#id_cliente').val() == null) ?
                'Guardar Cliente' :
                $('#id_categoria').val();

            // console.log(id_categoria);

            if (id_cliente == 'Guardar Cliente') {
                insertarCliente();
            } else {
                actualizarCliente();
            }

        });

    });


    function insertarCliente() {

        // console.log("inserta");

        // OBTENEMOS LOS DATOS QUE VAMOS A INSERTAR
        let nombre_cliente = $("#nombre_cliente").val();
        let correo_cliente = $("#correo_cliente").val();
        let telefono_cliente = $("#telefono_cliente").val();
        let rfc_cliente = $("#rfc_cliente").val();
        let id_estado = $("#id_estado_cliente").val();

        //DATOS DEL DOMICILIO DEL cliente        

        let calle = ($("#calle").val() == '' || $("#calle").val() == null) ?
            'N/A' :
            $("#calle").val();

        let colonia = ($("#colonia").val() == '' || $("#colonia").val() == null) ?
            'N/A' :
            $("#colonia").val();

        let estado = ($("#estado").val() == '' || $("#estado").val() == null) ?
            'N/A' :
            $("#estado").val();

        let ciudad = ($("#ciudad").val() == '' || $("#ciudad").val() == null) ?
            'N/A' :
            $("#ciudad").val();

        let no_interior = ($("#no_interior").val() == '' || $("#no_interior").val() == null) ?
            'N/A' :
            $("#no_interior").val();

        let no_exterior = ($("#no_exterior").val() == '' || $("#no_exterior").val() == null) ?
            'N/A' :
            $("#no_exterior").val();

        let codigo_postal = ($("#codigo_postal").val() == '' || $("#codigo_postal").val() == null) ?
            'N/A' :
            $("#codigo_postal").val();

        $.ajax({
            method: "POST",
            url: "./Controllers/Administracion/Clientes.php",
            data: {
                funcion: 'insertar_nuevo_cliente',
                nombre_cliente: nombre_cliente,
                correo_cliente: correo_cliente,
                telefono_cliente: telefono_cliente,
                rfc_cliente: rfc_cliente,
                id_estado: id_estado,
                calle: calle,
                colonia: colonia,
                estado: estado,
                ciudad: ciudad,
                no_interior: no_interior,
                no_exterior: no_exterior,
                codigo_postal: codigo_postal
            }
        }).done(function(respuesta_servidor) {
            console.log(respuesta_servidor);
            let respuesta_categoria = JSON.parse(respuesta_servidor);

            if (respuesta_categoria.respuesta == 'Insertado Correctamente') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'El cliente ha sido dada de alta'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Clientes');
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

    function actualizarCliente() {

        // OBTENEMOS LOS DATOS QUE VAMOS A ACTUALIZAR
        let id_cliente = $("#id_cliente").val();
        let nombre_cliente = $("#nombre_cliente").val();
        let correo_cliente = $("#correo_cliente").val();
        let telefono_cliente = $("#telefono_cliente").val();
        let rfc_cliente = $("#rfc_cliente").val();
        let id_estado = $("#id_estado_cliente").val();

        //DATOS DEL DOMICILIO DEL cliente
        let id_domicilio_cliente = $("#id_domicilio_cliente").val();

        let calle = ($("#calle").val() == '' || $("#calle").val() == null) ?
            'N/A' :
            $("#calle").val();

        let colonia = ($("#colonia").val() == '' || $("#colonia").val() == null) ?
            'N/A' :
            $("#colonia").val();

        let estado = ($("#estado").val() == '' || $("#estado").val() == null) ?
            'N/A' :
            $("#estado").val();

        let ciudad = ($("#ciudad").val() == '' || $("#ciudad").val() == null) ?
            'N/A' :
            $("#ciudad").val();

        let no_interior = ($("#no_interior").val() == '' || $("#no_interior").val() == null) ?
            'N/A' :
            $("#no_interior").val();

        let no_exterior = ($("#no_exterior").val() == '' || $("#no_exterior").val() == null) ?
            'N/A' :
            $("#no_exterior").val();

        let codigo_postal = ($("#codigo_postal").val() == '' || $("#codigo_postal").val() == null) ?
            'N/A' :
            $("#codigo_postal").val();

        // console.log(id_cliente);
        // console.log(nombre_cliente);
        // console.log(correo_cliente);
        // console.log(telefono_cliente);
        // console.log(rfc_cliente);
        // console.log(id_estado);
        // console.log(id_domicilio_cliente);
        // console.log(calle);
        // console.log(colonia);
        // console.log(estado);
        // console.log(ciudad);
        // console.log(no_interior);
        // console.log(no_exterior);
        // console.log(codigo_postal);

        $.ajax({
            method: "POST",
            url: "./Controllers/Administracion/Clientes.php",
            data: {
                funcion: 'actualizar_cliente',
                id_cliente: id_cliente,
                nombre_cliente: nombre_cliente,
                correo_cliente: correo_cliente,
                telefono_cliente: telefono_cliente,
                rfc_cliente: rfc_cliente,
                id_estado: id_estado,
                id_domicilio_cliente: id_domicilio_cliente,
                calle: calle,
                colonia: colonia,
                estado: estado,
                ciudad: ciudad,
                no_interior: no_interior,
                no_exterior: no_exterior,
                codigo_postal: codigo_postal
            }
        }).done(function(respuesta_servidor) {
            // console.log(respuesta_servidor);
            let respuesta_cliente = JSON.parse(respuesta_servidor);

            if (respuesta_cliente.respuesta == 'Cliente Actualizado') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'El cliente ha sido actualizado'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Clientes');
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

    $("#regresar").on('click', function(e) {
        e.preventDefault();
        cambiarVentana('Views/Administracion/Clientes');
    });
</script>