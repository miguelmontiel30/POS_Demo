CREATE DATABASE IF NOT EXISTS demo_ferreteria;
USE demo_ferreteria;


---------------------------------------
---------------------------------------
CREATE TABLE estados(
    id_estado INT(10) ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY
    estado VARCHAR(20) NOT NULL
)


---------------------------------------
---------------------------------------
CREATE TABLE categorias (
	id_categoria INT(5) UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre_categoria VARCHAR(20) NOT NULL,
	descripcion_categoria VARCHAR(30) NOT NULL,
	id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
)

CREATE TABLE domicilio_proveedor (
    id_domicilio_proveedor int(10) UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY,
    calle varchar(30) NOT NULL,
    no_exterior varchar(40) NOT NULL,
    no_interior varchar(45) NOT NULL,
    colonia varchar(45) NOT NULL,
    ciudad varchar(45) NOT NULL,
    estado varchar(45) NOT NULL,
    codigo_postal varchar(7) NOT NULL
);

CREATE TABLE proveedores (
    id_proveedor int(10) UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre_proveedor varchar(30) NOT NULL,
    correo_proveedor varchar(40) NOT NULL,
    telefono_proveedor varchar(45) NOT NULL,
    rfc_proveedor varchar(45) NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    id_domicilio_proveedor INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_domicilio_proveedor) REFERENCES domicilio_proveedor(id_domicilio_proveedor),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

CREATE TABLE domicilio_cliente (
    id_domicilio_cliente int(10) UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY,
    calle varchar(30) NOT NULL,
    no_exterior varchar(40) NOT NULL,
    no_interior varchar(45) NOT NULL,
    colonia varchar(45) NOT NULL,
    ciudad varchar(45) NOT NULL,
    estado varchar(45) NOT NULL,
    codigo_postal varchar(7) NOT NULL
);

CREATE TABLE clientes (
    id_cliente int(10) UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre_cliente varchar(30) NOT NULL,
    correo_cliente varchar(40) NOT NULL,
    telefono_cliente varchar(45) NOT NULL,
    rfc_cliente varchar(45) NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    id_domicilio_cliente INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_domicilio_cliente) REFERENCES domicilio_cliente(id_domicilio_cliente),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);


CREATE TABLE tipo_usuarios(
    id_tipo_usuario INT(2) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,
    tipo_usuario varchar (20)    
);


CREATE TABLE usuarios (
    id_usuario INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(50) NULL,
    no_telefonico CHAR(10) NULL,
    correo_electronico VARCHAR(70) NULL,
    nombre_acceso VARCHAR(70) NOT NULL,
    contrasena VARCHAR(20) NOT NULL,
    foto_perfil VARCHAR(100) NULL,
    id_tipo_usuario INT(2) ZEROFILL NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuarios(id_tipo_usuario),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);


CREATE TABLE tipo_presentaciones(
    id_tipo_presentacion INT(5) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_presentacion VARCHAR(15) NOT NULL
);

INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Unidad');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Libra');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Kilogramo');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Caja');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Paquete');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Lata');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Galon');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Botella');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Tira');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Sobre');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Bolsa');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Saco');
INSERT INTO tipo_presentaciones(nombre_presentacion) VALUES('Tarjeta');

CREATE TABLE productos (
    id_producto INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_producto VARCHAR(50) NULL,
    modelo_producto VARCHAR(50) NULL,
    stock_existencias CHAR(10) NULL,
    stock_minimo CHAR(10) NULL,
    precio_compra CHAR(10) NOT NULL,
    precio_venta FLOAT(10) NOT NULL,
    precio_mayoreo FLOAT(10) NOT NULL,
    porcentaje_descuento FLOAT(10) NOT NULL,
    vencimiento CHAR(1) NOT NULL,
    fecha_vencimiento DATE NULL.
    id_tipo_presentacion INT(5) ZEROFILL NOT NULL,
    id_proveedor INT(10) ZEROFILL NOT NULL,
    id_categoria INT(5) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_tipo_presentacion) REFERENCES tipo_presentaciones(id_tipo_presentacion),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

CREATE TABLE almacen (
    id_almacen INT(5) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,   
    nombre_almacen VARCHAR(50) NULL,        
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

CREATE TABLE orden_compra (
    id_orden_compra INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,       
    fecha_compra DATE NOT NULL,        
    id_proveedor INT(10) ZEROFILL NOT NULL,
    id_almacen INT(5) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,    
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor),
    FOREIGN KEY (id_almacen) REFERENCES almacen(id_almacen),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)    
);

CREATE TABLE detalle_orden_compra_temp (
    id_detalle_orden_compra_temp INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,   
    cantidad_compra CHAR(10) NULL,    
    precio_compra CHAR(10) NOT NULL,
    precio_venta FLOAT(10) NOT NULL,
    precio_mayoreo FLOAT(10) NOT NULL,    
    id_producto INT(10) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

CREATE TABLE detalle_orden_compra (
    id_detalle_orden_compra INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,   
    cantidad_compra CHAR(10) NULL,    
    precio_compra CHAR(10) NOT NULL,
    precio_venta FLOAT(10) NOT NULL,
    precio_mayoreo FLOAT(10) NOT NULL,    
    id_orden_compra INT(10) ZEROFILL NOT NULL,
    id_producto INT(10) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_orden_compra) REFERENCES orden_compra(id_orden_compra),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);


CREATE TABLE ventas (
    id_venta INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,       
    fecha_venta DATE NOT NULL,        
    descuento_venta CHAR(3) NULL,        
    total_pagado FLOAT(10) NOT NULL,
    id_cliente INT(10) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,    
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)    
);

CREATE TABLE detalle_venta_temp (
    id_detalle_venta_temp INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,   
    cantidad_vendida CHAR(10) NULL,    
    precio_venta CHAR(10) NOT NULL,    
    id_producto INT(10) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

CREATE TABLE detalle_venta (
    id_detalle_venta INT(10) ZEROFILL AUTO_INCREMENT PRIMARY KEY NOT NULL,   
    cantidad_vendida CHAR(10) NULL,    
    precio_venta CHAR(10) NOT NULL,    
    id_venta INT(10) ZEROFILL NOT NULL,
    id_producto INT(10) ZEROFILL NOT NULL,
    id_estado INT(10) UNSIGNED ZEROFILL NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);

