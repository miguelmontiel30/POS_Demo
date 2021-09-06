<?php


include('../../BD/Queries.php');

// DEFINICION DEL ASPECTO QUE TENDRA EL TITULO DE LA INTERFAZ Y LAFUNCION DEL BOTON
$button_interfaz;
$titulo_interfaz;

//SE CONSULTA SI HAY UN PARAMETRO ENVIADO (QUE EN DADO CASO QUE HAYA SE TRATA DE EDITAR UN REGISTRO)
if (isset($_GET['id_usuario'])) {

    // Creacion de objetos para instanciar Clases
    $queries = new Queries;

    $id_usuario[0] = $_GET['id_usuario'];
    // $id_categoria[0] = '4';

    $consulta = "SELECT usuarios.id_usuario, usuarios.nombre, usuarios.correo_electronico, usuarios.nombre_acceso,
                        usuarios.no_telefonico, usuarios.contrasena,
                        usuarios.id_estado, estados.estado,
                        tipo_usuarios.id_tipo_usuario, tipo_usuarios.tipo_usuario
                    FROM usuarios
                    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
                    INNER JOIN tipo_usuarios ON usuarios.id_tipo_usuario = tipo_usuarios.id_tipo_usuario
                    WHERE usuarios.id_usuario = ?;";

    // echo $consulta;

    if ($datos = $queries->ejecutarConsulta($consulta, $id_usuario)) {
        // print_r($datos[0]);

        //VACIAMOS LOS DATOS DEL cliente QUE SE VA A EDITAR
        $id_usuario = $datos[0]['id_usuario'];
        $nombre = $datos[0]['nombre'];
        $correo_electronico = $datos[0]['correo_electronico'];
        $no_telefonico = $datos[0]['no_telefonico'];
        $nombre_acceso = $datos[0]['nombre_acceso'];
        $contrasena = $datos[0]['contrasena'];
        $id_estado = $datos[0]['id_estado'];
        $id_tipo_usuario = $datos[0]['id_tipo_usuario'];


        $button_interfaz = '<button class="btn btn-outline-primary btn-block my-4 waves-effect z-depth-0" type="submit">
                                <i class="fas fa-save ml-1"></i>
                                Editar Usuario
                            </button>';

        $titulo_interfaz = 'Editar Usuario';
    } else {

        $mensaje['estado'] = 'Sin Usuarios';
    }
} else { //SI NO HAY DATOS ENVIADOS SE TRATA DE UN REGISTRO NUEVO

    $button_interfaz = '<button class="btn btn-outline-success btn-block my-4 waves-effect z-depth-0" type="submit">
                            <i class="fas fa-save ml-1"></i>
                            Crear Nuevo Usuario
                        </button>';

    $titulo_interfaz = 'Nuevo Usuario';
}

?>

<div class="container-fluid">

    <form class="card" id="form_usuario">

        <h3 class="text-center h3-responsive h3 my-3">
            <i style="font-size: 1.6rem;" class="fas fa-users ml-1"></i>
            <?php echo $titulo_interfaz; ?>
        </h3>

        <div class="card-body px-4">

            <!-- CONTENEDOR DE LOS DATOS DE Usuario -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-address-card mr-2"></i>Información del usuario
                </h4>

                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO Usuario -->
                <div class="row">

                    <!-- id_usuario ES UN INPUT OCULTO SIRVE PARA EDITAR EL usuario -->
                    <input type="hidden" id="id_usuario" value="<?php echo $id_usuario; ?>">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                            <label for="nombre" class="active">Nombre</label>
                        </div>
                    </div>
                    <!-- Nombre -->

                    <!-- Correo -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control" type="email" id="correo_electronico" name="correo_electronico" value="<?php echo $correo_electronico; ?>">
                            <label for="correo_electronico" class="active">Correo Electrónico</label>
                        </div>
                    </div>
                    <!-- Correo -->

                    <!-- Telefono -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control" type="text" id="no_telefonico" name="no_telefonico" value="<?php echo $no_telefonico; ?>">
                            <label for="no_telefonico" class="active">Telefono</label>
                        </div>
                    </div>
                    <!-- Telefono -->

                    <!-- Estado del Usuario -->
                    <div class="form-group col-md-6">
                        <select class="mdb-select md-form" id="id_estado_cliente" required>
                            <option value="" disabled selected>Estado del Usuario</option>
                            <option value="1" <?= $id_estado == '1' ? ' selected="selected"' : ''; ?>>Habilitado</option>
                            <option value="2" <?= $id_estado == '2' ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
                        </select>
                    </div>
                    <!-- Estado del Usuario -->

                </div>
                <!-- CONTENEDOR CON LOS DATOS DEL NUEVO Usuario -->

            </div>
            <!-- CONTENEDOR DE LOS DATOS DE Usuario -->

            <!-- CONTENEDOR CON LOS DATOS DE LA CUENTA -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-user-lock mr-2"></i>Datos de la cuenta
                </h4>

                <div class="row">

                    <!-- Nombre de Acceso -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control" type="text" id="nombre_acceso" name="nombre_acceso" value="<?php echo $nombre_acceso; ?>">
                            <label for="nombre_acceso" class="active">Nombre de Acceso</label>
                        </div>
                    </div>
                    <!-- Nombre de Acceso -->

                    <!-- Cargo del Usuario -->
                    <div class="form-group col-md-6">
                        <select class="mdb-select md-form" id="id_tipo_usuario" name="id_tipo_usuario">
                            <option value="" disabled selected>Cargo del Usuario</option>
                            <option value="1" <?= $id_tipo_usuario == '1' ? ' selected="selected"' : ''; ?>>Administrador</option>
                            <option value="2" <?= $id_tipo_usuario == '2' ? ' selected="selected"' : ''; ?>>Vendedor</option>
                        </select>
                    </div>
                    <!-- Cargo del Usuario -->

                    <!-- Contraseña -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control " type="password" id="contrasena" name="contrasena" value="<?php echo $contrasena; ?>">
                            <label for="contrasena" class="active">Contraseña</label>
                        </div>
                    </div>
                    <!-- Contraseña -->

                    <!-- Repetir Contraseña -->
                    <div class="col-md-6">
                        <div class="md-form">
                            <input class="form-control " type="password" id="repetir_contrasena" name="repetir_contrasena" value="<?php echo $contrasena; ?>">
                            <label for="repetir_contrasena" class="active">Repetir Contraseña</label>
                        </div>
                    </div>
                    <!-- Repetir Contraseña -->

                    <!-- <button class="btn btn-outline-info"><i class="far fa-unlock ml-1"></i> Cambiar Contraseña</button> -->

                </div>

            </div>
            <!-- CONTENEDOR CON LOS DATOS DE LA CUENTA -->

        </div>

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

        $("#form_usuario").on('submit', function(event) {
            // console.log("Entro");
            event.preventDefault();

            let id_usuario = ($('#id_usuario').val() == '' || $('#id_usuario').val() == null) ?
                'Guardar Usuario' :
                $('#id_usuario').val();

            // console.log(id_categoria);

            if (id_usuario == 'Guardar Usuario') {
                insertarUsuario();
            } else {
                actualizarUsuario();
            }

        });

    });

    function insertarUsuario() {

        // console.log("inserta");
        
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
                funcion: 'insertar_nuevo_usuario',
                nombre: nombre,
                correo_electronico: correo_electronico,
                no_telefonico: no_telefonico,
                nombre_acceso: nombre_acceso,
                contrasena: contrasena,
                id_estado: id_estado,
                id_tipo_usuario: id_tipo_usuario
            }
        }).done(function(respuesta_servidor) {
            console.log(respuesta_servidor);
            let respuesta_usuario = JSON.parse(respuesta_servidor);

            if (respuesta_usuario.respuesta == 'Insertado Correctamente') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'El usuario ha sido dada de alta'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Usuarios');
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
        }).done(function(respuesta_servidor) {
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

    $("#regresar").on('click', function(e) {
        e.preventDefault();
        cambiarVentana('Views/Administracion/Usuarios');
    });
</script>