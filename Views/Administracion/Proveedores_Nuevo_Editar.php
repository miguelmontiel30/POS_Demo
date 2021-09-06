<?php


include('../../BD/Queries.php');

// DEFINICION DEL ASPECTO QUE TENDRA EL TITULO DE LA INTERFAZ Y LAFUNCION DEL BOTON
$button_interfaz;
$titulo_interfaz;

//SE CONSULTA SI HAY UN PARAMETRO ENVIADO (QUE EN DADO CASO QUE HAYA SE TRATA DE EDITAR UN REGISTRO)
if (isset($_GET['id_proveedor'])) {

    // Creacion de objetos para instanciar Clases
    $queries = new Queries;

    $id_proveedor[0] = $_GET['id_proveedor'];
    // $id_categoria[0] = '4';

    $consulta = "SELECT proveedores.id_proveedor, proveedores.nombre_proveedor, proveedores.correo_proveedor, 
                    proveedores.telefono_proveedor, proveedores.rfc_proveedor,
                    domicilio_proveedor.id_domicilio_proveedor, domicilio_proveedor.calle, domicilio_proveedor.colonia,
                    domicilio_proveedor.no_exterior, domicilio_proveedor.no_interior, domicilio_proveedor.ciudad, 
                    domicilio_proveedor.estado, domicilio_proveedor.codigo_postal,
                    estados.id_estado, estados.estado AS 'estado_proveedor'
                    FROM proveedores
                    INNER JOIN estados ON proveedores.id_estado = estados.id_estado
                    INNER JOIN domicilio_proveedor ON proveedores.id_domicilio_proveedor = domicilio_proveedor.id_domicilio_proveedor
                    WHERE proveedores.id_proveedor = ?;";

    // echo $consulta;

    if ($datos = $queries->ejecutarConsulta($consulta, $id_proveedor)) {
        // print_r($datos[0]);

        //VACIAMOS LOS DATOS DEL PROVEEDOR QUE SE VA A EDITAR
        $id_proveedor = $datos[0]['id_proveedor'];
        $nombre_proveedor = $datos[0]['nombre_proveedor'];
        $correo_proveedor = $datos[0]['correo_proveedor'];
        $telefono_proveedor = $datos[0]['telefono_proveedor'];
        $rfc_proveedor = $datos[0]['rfc_proveedor'];
        $id_estado = $datos[0]['id_estado'];

        //DATOS DEL DOMICILIO DEL PROVEEDOR
        $id_domicilio_proveedor = $datos[0]['id_domicilio_proveedor'];
        $calle = $datos[0]['calle'];
        $colonia = $datos[0]['colonia'];
        $estado = $datos[0]['estado'];
        $ciudad = $datos[0]['ciudad'];
        $no_interior = $datos[0]['no_interior'];
        $no_exterior = $datos[0]['no_exterior'];
        $codigo_postal = $datos[0]['codigo_postal'];

        $button_interfaz = '<button class="btn btn-outline-primary btn-block my-4 waves-effect z-depth-0" type="submit">
                                <i class="fas fa-save ml-1"></i>
                                Editar Proveedor
                            </button>';

        $titulo_interfaz = 'Editar Proveedor';
    } else {

        $mensaje['estado'] = 'Sin proveedores';
    }
} else { //SI NO HAY DATOS ENVIADOS SE TRATA DE UN REGISTRO NUEVO

    $button_interfaz = '<button class="btn btn-outline-success btn-block my-4 waves-effect z-depth-0" type="submit">
                            <i class="fas fa-save ml-1"></i>
                            Crear Nuevo Proveedor
                        </button>';

    $titulo_interfaz = 'Nuevo Proveedor';
}

?>
<div class="container-fluid">

    <form class="card" id="form_proveedor">

        <h3 class="text-center h3-responsive h3 my-3">
            <i style="font-size: 1.6rem;" class="fas fa-truck-loading ml-1"></i>
            <?php echo $titulo_interfaz; ?>
        </h3>

        <div class="card-body px-4">

            <!-- CONTENEDOR DE LOS DATOS DE CONTACTO Y BANCARIOS -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="far fa-address-card mr-2"></i>Datos del proveedor
                </h4>

                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO PROVEEDOR -->
                <div class="row">

                    <!-- ID_PROVEEDOR ES UN INPUT OCULTO SIRVE PARA EDITAR EL PROVEEDOR -->
                    <input type="hidden" id="id_proveedor" value="<?php echo $id_proveedor; ?>">

                    <!-- Nombre -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <input class="form-control" type="text" id="nombre_proveedor" name="nombre_proveedor" value="<?php echo $nombre_proveedor; ?>" required>
                            <label for="nombre_proveedor" class="active">Nombre</label>
                        </div>
                    </div>
                    <!-- Nombre -->

                    <!-- Correo -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="correo_proveedor" class="active">Correo</label>
                            <input class="form-control" type="text" id="correo_proveedor" name="correo_proveedor" value="<?php echo $correo_proveedor; ?>">
                        </div>
                    </div>
                    <!-- Correo -->

                    <!-- Telefono -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="telefono_proveedor" class="active">Telefono</label>
                            <input class="form-control" type="text" id="telefono_proveedor" name="telefono_proveedor" value="<?php echo $telefono_proveedor; ?>" required>
                        </div>
                    </div>
                    <!-- Telefono -->

                </div>
                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO PROVEEDOR -->

                <!-- CONTENEDOR CON ESTADO Y RFC DEL PROVEEDOR-->
                <div class="row">

                    <!-- ESTADO DEL PROVEEDOR -->
                    <div class="form-group col-md-4">
                        <select id="id_estado_proveedor" class="mdb-select md-form" required>
                            <option value="" disabled selected>Estado del Proveedor</option>
                            <option value="1" <?= $id_estado == '1' ? ' selected="selected"' : ''; ?>>Habilitado</option>
                            <option value="2" <?= $id_estado == '2' ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
                        </select>
                    </div>
                    <!-- ESTADO DEL PROVEEDOR -->

                    <!-- RFC -->
                    <div class="col-md-4">
                        <div class="md-form">
                            <label for="rfc_proveedor" class="active">RFC</label>
                            <input class="form-control" type="text" id="rfc_proveedor" name="rfc_proveedor" value="<?php echo $rfc_proveedor; ?>">
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
                <!-- CONTENEDOR CON ESTADO Y RFC DEL PROVEEDOR -->

            </div>
            <!-- CONTENEDOR DE LOS DATOS DE CONTACTO Y BANCARIOS -->

            <!-- CONTENEDOR CON LOS DATOS DEL DOMICILIO DEL NUEVO PROVEEDOR -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="far fa-address-card mr-2"></i>Domicilio del proveedor
                </h4>

                <!-- CONTENEDOR DE CALLE, COLONIA Y CP -->
                <div class="row">

                    <!-- ID_CATEGORIA ES UN INPUT OCULTO SIRVE PARA EDITAR LA CATEGORIA -->
                    <input type="hidden" id="id_domicilio_proveedor" value="<?php echo $id_domicilio_proveedor; ?>">

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
        <!-- CONTENEDOR CON LOS DATOS DEL DOMICILIO DEL NUEVO PROVEEDOR -->

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


        $("#form_proveedor").on('submit', function(event) {
            // console.log("Entro");
            event.preventDefault();

            let id_proveedor = ($('#id_proveedor').val() == '' || $('#id_proveedor').val() == null) ?
                'Guardar Proveedor' :
                $('#id_categoria').val();

            // console.log(id_categoria);

            if (id_proveedor == 'Guardar Proveedor') {
                insertarProveedor();
            } else {
                actualizarProveedor();
            }

        });

    });

    function insertarProveedor() {

        // console.log("inserta");

        // OBTENEMOS LOS DATOS QUE VAMOS A INSERTAR
        let nombre_proveedor = $("#nombre_proveedor").val();
        let correo_proveedor = $("#correo_proveedor").val();
        let telefono_proveedor = $("#telefono_proveedor").val();
        let rfc_proveedor = $("#rfc_proveedor").val();
        let id_estado = $("#id_estado_proveedor").val();

        //DATOS DEL DOMICILIO DEL PROVEEDOR        

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
            url: "./Controllers/Administracion/Proveedores.php",
            data: {
                funcion: 'insertar_nuevo_proveedor',
                nombre_proveedor: nombre_proveedor,
                correo_proveedor: correo_proveedor,
                telefono_proveedor: telefono_proveedor,
                rfc_proveedor: rfc_proveedor,
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
                    text: 'El proveedor ha sido dada de alta'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Proveedores');
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

    function actualizarProveedor() {

        // OBTENEMOS LOS DATOS QUE VAMOS A ACTUALIZAR
        let id_proveedor = $("#id_proveedor").val();
        let nombre_proveedor = $("#nombre_proveedor").val();
        let correo_proveedor = $("#correo_proveedor").val();
        let telefono_proveedor = $("#telefono_proveedor").val();
        let rfc_proveedor = $("#rfc_proveedor").val();
        let id_estado = $("#id_estado_proveedor").val();

        //DATOS DEL DOMICILIO DEL PROVEEDOR
        let id_domicilio_proveedor = $("#id_domicilio_proveedor").val();

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

        // console.log(id_proveedor);
        // console.log(nombre_proveedor);
        // console.log(correo_proveedor);
        // console.log(telefono_proveedor);
        // console.log(rfc_proveedor);
        // console.log(id_estado);
        // console.log(id_domicilio_proveedor);
        // console.log(calle);
        // console.log(colonia);
        // console.log(estado);
        // console.log(ciudad);
        // console.log(no_interior);
        // console.log(no_exterior);
        // console.log(codigo_postal);

        $.ajax({
            method: "POST",
            url: "./Controllers/Administracion/Proveedores.php",
            data: {
                funcion: 'actualizar_proveedor',
                id_proveedor: id_proveedor,
                nombre_proveedor: nombre_proveedor,
                correo_proveedor: correo_proveedor,
                telefono_proveedor: telefono_proveedor,
                rfc_proveedor: rfc_proveedor,
                id_estado: id_estado,
                id_domicilio_proveedor: id_domicilio_proveedor,
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
            let respuesta_proveedor = JSON.parse(respuesta_servidor);

            if (respuesta_proveedor.respuesta == 'Proveedor Actualizado') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'El proveedor ha sido actualizado'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Proveedores');
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
        cambiarVentana('Views/Administracion/Proveedores');
    });
</script>