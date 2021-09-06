<!-- CONTENEDOR GENERAL DE LA INTERFAZ -->
<div class="container-fluid">

    <!-- TARJETA DE NUEVO PRODCUTO -->
    <form id="form_producto" class="card">

        <h3 class="text-center h3-responsive h3 my-3">
            <i style="font-size: 1.6rem;" class="fas fa-boxes-alt ml-1"></i>
            Alta Producto
        </h3>

        <!-- CONTENEDOR DEL LOS INPUTS -->
        <div class="card-body px-4">

            <!-- CONTENEDOR DE LOS DATOS DE PRODUCTO -->
            <div class="container-fluid p-0">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-box mr-2"></i>Información del producto
                </h4>

                <div class="row">

                    <div class="container-fluid">

                        <div class="row">

                            <!-- Nombre -->
                            <div class="col-12 col-md-6">
                                <div class="md-form">
                                    <label for="nombre_producto">Nombre</label>
                                    <input type="text" class="form-control" name="nombre_producto" id="nombre_producto"
                                        length="50">
                                </div>
                            </div>
                            <!-- Nombre -->

                            <!-- Modelo -->
                            <div class="col-12 col-md-6">
                                <div class="md-form">
                                    <label for="modelo_producto">Modelo o Marca</label>
                                    <input type="text" class="form-control" name="modelo_producto" id="modelo_producto"
                                        length="50">
                                </div>
                            </div>
                            <!-- Modelo -->

                            <!-- Stock o existencias -->
                            <div class="col-12 col-md-4">
                                <div class="md-form">
                                    <label for="stock_existencias">Stock o existencias</label>
                                    <input type="number" class="form-control" name="stock_existencias"
                                        id="stock_existencias" length="10">
                                </div>
                            </div>
                            <!-- Stock o existencias -->

                            <!-- Stock mínimo -->
                            <div class="col-12 col-md-4">
                                <div class="md-form">
                                    <label for="stock_minimo">Stock mínimo</label>
                                    <input type="number" class="form-control" name="stock_minimo" id="stock_minimo"
                                        length="10">
                                </div>
                            </div>
                            <!-- Stock mínimo -->

                            <!-- Presentación del producto -->
                            <div class="col-12 col-md-4 form-group">
                                <select class="mdb-select md-form" name="id_tipo_presentacion"
                                    id="id_tipo_presentacion">
                                    <option value="" selected="">Presentación del producto</option>
                                    <option value="">Otro</option>
                                </select>
                            </div>
                            <!-- Presentación del producto -->

                            <!-- Precio de compra -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="md-form">
                                    <label for="precio_compra">Precio de compra</label>
                                    <input type="number" class="form-control" name="precio_compra" value=""
                                        id="precio_compra" length="10">
                                </div>
                            </div>
                            <!-- Precio de compra -->

                            <!-- Precio de venta -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="md-form">
                                    <label for="precio_venta">Precio de venta</label>
                                    <input type="number" class="form-control" name="precio_venta" value=""
                                        id="precio_venta" length="10">
                                </div>
                            </div>
                            <!-- Precio de venta -->

                            <!-- Precio de mayoreo -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="md-form">
                                    <label for="precio_mayoreo">Precio de mayoreo</label>
                                    <input type="number" class="form-control" name="precio_mayoreo" value=""
                                        id="precio_mayoreo" length="10">
                                </div>
                            </div>
                            <!-- Precio de mayoreo -->

                            <!-- Descuento (%) en venta -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="md-form">
                                    <label for="porcentaje_descuento">Descuento (%) en venta</label>
                                    <input type="number" class="form-control" name="porcentaje_descuento"
                                        id="porcentaje_descuento" length="10">
                                </div>
                            </div>
                            <!-- Descuento (%) en venta -->

                        </div>

                    </div>

                </div>

            </div>
            <!-- CONTENEDOR DE LOS DATOS DE PRODUCTO -->

            <!-- CONTENEDOR DE LOS DATOS DE VENCIMIENTO DEL PRODUCTO -->
            <div class="container-fluid p-0 mt-3">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-calendar-alt mr-2"></i>Vencimiento del producto
                </h4>

                <div class="container-fluid">

                    <div class="row">

                        <!-- RADIO BUTTONS -->
                        <div class="col-12 col-md-6">

                            <div class="form-check mt-3">
                                <input type="radio" class="form-check-input" id="vencimiento_1" name="vencimiento" value="1">
                                <label class="form-check-label" for="vencimiento_1">Si vence</label>
                            </div>

                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="vencimiento_2" name="vencimiento" value="2" checked>
                                <label class="form-check-label" for="vencimiento_2">No vence</label>
                            </div>

                        </div>
                        <!-- RADIO BUTTONS -->

                        <!-- Fecha de vencimiento -->
                        <div class="col-12 col-md-6 mt-3">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="fecha_vencimiento" class="bmd-label-static">Fecha de vencimiento</label>
                                <input type="date" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento"
                                    value="">
                            </div>
                        </div>
                        <!-- Fecha de vencimiento -->

                    </div>

                </div>


            </div>
            <!-- CONTENEDOR DE LOS DATOS DE VENCIMIENTO DEL PRODUCTO -->

            <!-- CONTENEDOR DE LOS DATOS DE Proveedor, Categoría Y Estado -->
            <div class="container-fluid p-0 mt-3">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-truck-loading mr-2"></i>Proveedor, Categoría Y Estado
                </h4>

                <div class="container row">

                    <!-- Proveedor -->
                    <div class="col-12 col-md-4">
                        <select class="mdb-select md-form" name="id_proveedor" id="id_proveedor">
                            <option value="" selected="">Seleccione un Proveedor</option>
                        </select>
                    </div>
                    <!-- Proveedor -->

                    <!-- Categoría -->
                    <div class="col-12 col-md-4">
                        <select class="mdb-select md-form" name="id_categoria" id="id_categoria">
                            <option value="" selected="">Seleccione una Categoría</option>
                        </select>
                    </div>
                    <!-- Categoría -->

                    <!-- Estado -->
                    <div class="col-12 col-md-4">
                        <select class="mdb-select md-form" name="id_estado" id="id_estado">
                            <option value="" selected>Estado del producto</option>
                            <option value="1">Habilitado</option>
                            <option value="2">Deshabilitado</option>
                        </select>
                    </div>
                    <!-- Estado -->
                </div>
            </div>
            <!-- CONTENEDOR DE LOS DATOS DE Proveedor, Categoría Y Estado -->

            <!-- CONTENEDOR DE LA SUBIDA DE IMAGEN DEL PRODUCTO -->
            <div class="container-fluid p-0 mt-3">

                <h4 class="h4 h4-responsive mr-auto">
                    <i class="fas fa-image mr-2"></i>Foto o imagen del producto
                </h4>

                <div class="md-form">

                    <div class="file-field big">

                        <a class="btn-floating btn-lg primary-color-dark mt-0 float-left">
                            <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
                            <input type="file" multiple>
                        </a>

                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Subir Imagen">
                        </div>

                    </div>

                    <small class="text-muted ml-3">
                        Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo 2MB.
                        Resolución recomendada 300px X 300px o superior manteniendo el aspecto cuadrado
                        (1:1)
                    </small>
                </div>

            </div>
            <!-- CONTENEDOR DE LA SUBIDA DE IMAGEN DEL PRODUCTO -->

        </div>
        <!-- CONTENEDOR DEL LOS INPUTS -->

        <!-- CONTENEDOR DEL BOTON DE GUARDAR PRODUCTO -->
        <div class="container-fluid">
            <button class="btn btn-outline-success btn-block my-4 waves-effect z-depth-0" type="submit">
                <i class="fas fa-save ml-1"></i>
                Crear Nuevo Producto
            </button>
        </div>
        <!-- CONTENEDOR DEL BOTON DE GUARDAR PRODUCTO -->

    </form>
    <!-- TARJETA DE NUEVO PRODCUTO -->

</div>
<!-- CONTENEDOR GENERAL DE LA INTERFAZ -->

<script type="text/javascript" src="/demo_ferreteria/js/productos/producto.js"></script>