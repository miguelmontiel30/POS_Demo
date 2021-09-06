<?php


include('../../BD/Queries.php');

// DEFINICION DEL ASPECTO QUE TENDRA EL TITULO DE LA INTERFAZ Y LAFUNCION DEL BOTON
$button_interfaz;
$titulo_interfaz;

//SE CONSULTA SI HAY UN PARAMETRO ENVIADO
if (isset($_GET['id_categoria'])) {

    // Creacion de objetos para instanciar Clases
    $queries = new Queries;

    $id_categoria[0] = $_GET['id_categoria'];
    // $id_categoria[0] = '4';

    $consulta = "SELECT categorias.id_categoria, categorias.nombre_categoria, categorias.descripcion_categoria, estados.estado, estados.id_estado
                    FROM categorias
                    INNER JOIN estados ON categorias.id_estado = estados.id_estado
                    WHERE categorias.id_categoria = ?;";

    // echo $consulta;

    if ($datos = $queries->ejecutarConsulta($consulta, $id_categoria)) {
        // print_r($datos[0]);

        //VACIAMOS LOS DATOS DE LA CATEGORIA QUE SE VA A EDITAR
        $id_categoria = $datos[0]['id_categoria'];
        $nombre_categoria = $datos[0]['nombre_categoria'];
        $descripcion_categoria = $datos[0]['descripcion_categoria'];
        $id_estado = $datos[0]['id_estado'];

        $button_interfaz = '<button class="btn btn-outline-primary btn-block my-4 waves-effect z-depth-0" onClick="editarCategoria()">
                                <i class="fas fa-save ml-1"></i>
                                Editar Categoria
                            </button>';

        $titulo_interfaz = 'Editar Categoria';
    } else {

        $mensaje['estado'] = 'Sin categorias';
    }
} else {

    $button_interfaz = '<button class="btn btn-outline-success btn-block my-4 waves-effect z-depth-0" type="submit">
                            <i class="fas fa-save ml-1"></i>
                            Crear Nueva Categoria
                        </button>';

    $titulo_interfaz = 'Nueva Categoria';
}

?>

<!-- CONTENEDOR GENERAL DE LA VISTA -->
<div class="container-fluid" style="height: 100hv; margin-bottom: 5rem;">

    <div class="card">

        <div class="card-body">

            <h2 class="h2-responsive text-center card-title">
                <strong> <i style="font-size: 1.6rem;" class="fas fa-tags ml-1"></i> <?php echo $titulo_interfaz; ?></strong>
            </h2>


            <!-- FORMULARIO DE REGISTRO DE CATEGORIAS -->
            <div class="container mt-4">

                <h4 class="text-left">
                    <i class="far fa-tasks ml-1"></i>
                    Datos de la Categoría
                </h4>

                <!-- Form -->
                <form id="form_categoria" class="text-center" style="color: #757575;" action="#!">

                    <!-- ID_CATEGORIA ES UN INPUT OCULTO SIRVE PARA EDITAR LA CATEGORIA -->
                    <input type="hidden" id="id_categoria" value="<?php echo $id_categoria; ?>">

                    <!-- NOMBRE Y ESTADO DE LA CATEGORIA -->
                    <div class="row">

                        <!-- Nombre de la Categoría -->
                        <div class="col-md-6 col-12">
                            <div class="md-form input-with-post-icon">
                                <i class="fas fa-tags input-prefix"></i>
                                <input type="text" value="<?php echo $nombre_categoria; ?>" name="nombre_categoria" id="nombre_categoria" length="20" class="form-control validate" required>
                                <label class="active" for="nombre_categoria" data-error="Incorrecto" data-success="Correcto">Nombre de
                                    la Categoría</label>
                            </div>
                        </div>

                        <!-- ESTADO DE LA CATEGORIA -->
                        <div class="col-md-6 col-12">
                            <select class="mdb-select md-form validate" name="estado_categoria" id="estado_categoria" required>
                                <option value="" disabled selected>Estado de la Categoria</option>
                                <option value="1" <?= $id_estado == '1' ? ' selected="selected"' : ''; ?>>Habilitado</option>
                                <option value="2" <?= $id_estado == '2' ? ' selected="selected"' : ''; ?>>Deshabilitado</option>
                            </select>
                        </div>

                        <!-- DESCRIPCION de la Categoría -->
                        <div class="col-12">

                            <!-- <div class="form-group green-border-focus">
                                <label for="descripcion_categoria">Descripción de la Categoría</label>
                                <textarea  class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                            </div> -->

                            <div class="md-form">
                                <textarea value="" name="descripcion_categoria" id="descripcion_categoria" class="form-control md-textarea validate" length="30" rows="1"><?php echo $descripcion_categoria; ?></textarea>
                                <label for="descripcion_categoria active">Descripción de la Categoría</label>
                            </div>

                        </div>

                    </div>
                    <!-- NOMBRE Y ESTADO DE LA CATEGORIA -->


                    <?php echo $button_interfaz; ?>

                    <button id="regresar" class="btn btn-outline-danger btn-block my-4 waves-effect z-depth-0" type="button">
                        <i class="fas fa-arrow-left ml-1"></i>
                        Regresar
                    </button>

                </form>
                <!-- Form -->

            </div>
            <!-- FORMULARIO DE REGISTRO DE CATEGORIAS -->

        </div>

    </div>

</div>
<!-- CONTENEDOR GENERAL DE LA VISTA -->


<script>
    $(document).ready(function() {

        // INICIALIZAMOS LOS COMPONENTES 
        $('input, textarea').characterCounter();
        $('.mdb-select').materialSelect();

        $("#form_categoria").on('submit', function(event) {

            event.preventDefault();

            let id_categoria = ($('#id_categoria').val() == '' || $('#id_categoria').val() == null) ?
                'Guardar Categoria' :
                $('#id_categoria').val();

            // console.log(id_categoria);

            if (id_categoria == 'Guardar Categoria') {
                insertarCategoria();
            } else {
                actualizarCategoria();
            }

        });

    });


    function insertarCategoria() {

        // OBTENEMOS LOS DATOS QUE VAMOS A INSERTAR
        let nombre_categoria = $("#nombre_categoria").val();
        let estado_categoria = $("#estado_categoria").val();

        let descripcion_categoria = ($("#descripcion_categoria").val() == '' || $("#descripcion_categoria").val() == null) ?
            'Sin Descripcion' :
            $("#descripcion_categoria").val();

        $.ajax({
            method: "POST",
            url: "./Controllers/Administracion/Categorias.php",
            data: {
                funcion: 'insertar_nueva_categoria',
                nombre_categoria: nombre_categoria,
                descripcion_categoria: descripcion_categoria,
                estado_categoria: estado_categoria
            }
        }).done(function(respuesta_servidor) {
            console.log(respuesta_servidor);
            let respuesta_categoria = JSON.parse(respuesta_servidor);

            if (respuesta_categoria.respuesta == 'Insertado Correctamente') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'La Nueva Categoria ha sido dada de alta'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Categorias');
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

    function actualizarCategoria() {

        // OBTENEMOS LOS DATOS QUE VAMOS A ACTUALIZAR
        let nombre_categoria = $("#nombre_categoria").val();
        let id_estado_categoria = $("#estado_categoria").val();
        let id_categoria = $("#id_categoria").val();

        let descripcion_categoria = ($("#descripcion_categoria").val() == '' || $("#descripcion_categoria").val() == null) ?
            'Sin Descripcion' :
            $("#descripcion_categoria").val();

        // console.log(nombre_categoria);
        // console.log(estado_categoria);
        // console.log(id_categoria);
        // console.log(descripcion_categoria);

        $.ajax({
            method: "POST",
            url: "./Controllers/Administracion/Categorias.php",
            data: {
                funcion: 'actualizar_categoria',
                nombre_categoria: nombre_categoria,
                descripcion_categoria: descripcion_categoria,
                id_estado_categoria: id_estado_categoria,
                id_categoria: id_categoria
            }
        }).done(function(respuesta_servidor) {
            console.log(respuesta_servidor);
            let respuesta_categoria = JSON.parse(respuesta_servidor);

            if (respuesta_categoria.respuesta == 'Actualizado Correctamente') {

                Swal.fire({
                    icon: 'success',
                    title: '¡Correcto!',
                    text: 'La Categoria ha sido actualizada'
                });

                setTimeout(() => {
                    cambiarVentana('Views/Administracion/Categorias');
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
        cambiarVentana('Views/Administracion/Categorias');
    });
</script>