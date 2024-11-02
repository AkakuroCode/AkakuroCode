create database oceantrade charset utf8mb4;

use oceantrade;

-- Tabla cliente
CREATE TABLE cliente (
    idus INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(15) NOT NULL,
    apellido VARCHAR(15) NOT NULL,
    fecnac DATE NOT NULL,
    direccion VARCHAR(30) NOT NULL,
    telefono VARCHAR(18) UNIQUE NOT NULL,
    email VARCHAR(30) UNIQUE NOT NULL,
    passw VARCHAR(255) NOT NULL,
    activo ENUM('sí', 'no') DEFAULT 'si'
);

-- Tabla carrito
CREATE TABLE carrito (
    idcarrito INT AUTO_INCREMENT PRIMARY KEY,
    idus INT UNIQUE NOT NULL,
    fechacrea DATE NOT NULL,
    fechamod DATE NOT NULL CHECK (fechamod >= fechacrea),
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (idus) REFERENCES cliente(idus)
);

-- Tabla metodopago
CREATE TABLE metodopago (
    idpago INT AUTO_INCREMENT PRIMARY KEY,
    proveedor VARCHAR(40) NOT NULL,
    estado  ENUM('activo', 'inactivo') DEFAULT 'activo' NOT NULL
);


-- Tabla empresa
CREATE TABLE empresa (
    idemp INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    direccion VARCHAR(50) NOT NULL,
    telefono INT(15) UNIQUE NOT NULL,
    email VARCHAR(30) UNIQUE NOT NULL,
    passw VARCHAR(255) NOT NULL,
    cuentabanco INT(15) UNIQUE NOT NULL,
    activo ENUM('si', 'no') DEFAULT 'si'
);

-- Tabla producto
CREATE TABLE producto (
    sku INT AUTO_INCREMENT PRIMARY KEY,
    idemp INT NOT NULL,
    nombre VARCHAR(10) NOT NULL,
    descripcion VARCHAR(255),
    estado ENUM('Nuevo', 'Usado') NOT NULL,
    origen ENUM('Nacional', 'Internacional') NOT NULL,
    precio INT(10) DEFAULT 1 NOT NULL CHECK (precio > 0) ,
    stock TINYINT(3) NOT NULL,
    imagen VARCHAR(255),
    visible TINYINT(1) DEFAULT 1,
    tipo_stock ENUM('unidad','cantidad') DEFAULT 'cantidad',
    FOREIGN KEY (idemp) REFERENCES empresa(idemp)
);

-- Tabla compra
CREATE TABLE compra (
    idcompra INT AUTO_INCREMENT PRIMARY KEY,
    idpago INT UNIQUE NOT NULL,
    estado ENUM('Completado', 'Pendiente', 'Cancelado') NOT NULL,
    tipo_entrega ENUM('Envio', 'Recibo') NOT NULL,
    FOREIGN KEY (idpago) REFERENCES metodopago(idpago)
);

-- Tabla detalle_carrito
CREATE TABLE detalle_carrito (
    iddetalle INT AUTO_INCREMENT PRIMARY KEY,
    idcarrito INT NOT NULL,
    sku INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (idcarrito) REFERENCES carrito(idcarrito),
    FOREIGN KEY (sku) REFERENCES producto(sku)
);

-- Tabla pagina
CREATE TABLE pagina (
    url VARCHAR(255) PRIMARY KEY,
    estado ENUM('activo', 'mantenimiento') DEFAULT 'activo'
);

-- Tabla envio
CREATE TABLE envio (
    idenvio INT AUTO_INCREMENT PRIMARY KEY,
    fecsa DATE NOT NULL,
    fecen DATE NOT NULL CHECK (fecen >= fecsa),
    FOREIGN KEY (idv) REFERENCES vehiculo(idv)
);

-- Tabla centrorecibo
CREATE TABLE centrorecibo (
    idrecibo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    telefono VARCHAR(18) UNIQUE NOT NULL,
);

-- Tabla inicia
CREATE TABLE inicia (
    idcompra INT,
    idpago INT,
    PRIMARY KEY (idcompra, idpago),
	FOREIGN KEY (idpago) REFERENCES metodopago(idpago),
    FOREIGN KEY (idcompra) REFERENCES compra(idcompra)
);

-- Tabla cierra
CREATE TABLE cierra (
    idpago INT,
    idcarrito INT,
    PRIMARY KEY (idpago, idcarrito),
    FOREIGN KEY (idpago) REFERENCES metodopago(idpago),
    FOREIGN KEY (idcarrito) REFERENCES carrito(idcarrito)
);


-- Tabla recibe
CREATE TABLE recibe (
    idus INT,
    idenvio INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    PRIMARY KEY (idus, idenvio),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (idenvio) REFERENCES envio(idenvio)
);

-- Tabla retira
CREATE TABLE retira (
    idus INT,
    idrecibo INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    PRIMARY KEY (idus, idrecibo),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (idrecibo) REFERENCES centrorecibo(idrecibo)
);

-- Tabla tiene
CREATE TABLE tiene (
    idus INT,
    idpago INT,
    PRIMARY KEY (idus, idpago),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (idpago) REFERENCES metodopago(idpago)
);

-- Tabla crea
CREATE TABLE crea (
    sku INT,
    idcarrito INT,
    PRIMARY KEY (sku, idcarrito),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (idcarrito) REFERENCES carrito(idcarrito)
);

-- Tabla elige
CREATE TABLE elige (
    sku INT,
    idus INT,
    favorito ENUM('Si', 'No'),
    PRIMARY KEY (sku, idus),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (idus) REFERENCES cliente(idus)
);

-- Tabla contiene
CREATE TABLE contiene (
    sku INT,
    url VARCHAR(255),
    PRIMARY KEY (sku, url),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (url) REFERENCES pagina(url)
);


-- Tabla gestiona
CREATE TABLE gestiona (
    idad INT,
    url VARCHAR(255),
    PRIMARY KEY (idad, url),
    FOREIGN KEY (url) REFERENCES pagina(url)
);

-- Tabla admin
CREATE TABLE admin (
    idad INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(30) UNIQUE NOT NULL,
    passw VARCHAR(255) NOT NULL
);

-- Tabla historial_login
CREATE TABLE historial_login (
    idLogin INT AUTO_INCREMENT PRIMARY KEY,
    idus INT,
    idemp INT,
    fecha DATE NOT NULL ,
    hora TIME NOT NULL,
    url VARCHAR(255),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (idemp) REFERENCES empresa(idemp),
    FOREIGN KEY (url) REFERENCES pagina(url)
    
);

-- Tabla categoria
CREATE TABLE categoria (
    idcat INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion VARCHAR(255)
);

-- Tabla pertenece
CREATE TABLE pertenece (
    sku INT,
    idcat INT,
    PRIMARY KEY (sku, idcat),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (idcat) REFERENCES categoria(idcat)
);



CREATE TABLE producto_unitario (
    idunid INT AUTO_INCREMENT PRIMARY KEY,
    sku INT,
    codigo_unidad VARCHAR(50),
    estado ENUM('Disponible, Vendido'),
    FOREIGN KEY (sku) REFERENCES producto(sku)
);

CREATE TABLE ofertas (
  idof int(11) NOT NULL,
  sku int(11) DEFAULT NULL,
  porcentaje_oferta decimal(4,2) DEFAULT NULL,
  preciooferta decimal(10,2) DEFAULT NULL,
  fecha_inicio date DEFAULT NULL,
  fecha_fin date DEFAULT NULL,
  FOREIGN KEY (sku) REFERENCES producto(sku)
);

-- Tabla historial_compra
CREATE TABLE historial_compra (
    idhistorial INT PRIMARY KEY AUTO_INCREMENT,
    idus INT(11),
    sku INT(11),
    fecha DATE NOT NULL,
    total_compra DECIMAL(10,2) NOT NULL CHECK (total_compra > 0),
    estado ENUM('Completado', 'Pendiente', 'Cancelado') NOT NULL,
    codigo_unidad VARCHAR(50) UNIQUE,
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (idus) REFERENCES cliente(idus)
);

-- Tabla venta
CREATE TABLE venta (
    idventa INT PRIMARY KEY AUTO_INCREMENT,
    idemp INT(11),
    sku INT(11),
    fecha DATE NOT NULL,
    total_venta DECIMAL(10,2) NOT NULL CHECK (total_venta > 0),
    FOREIGN KEY (sku) REFERENCES producto(sku),
    FOREIGN KEY (idemp) REFERENCES empresa(idemp)
);

 -- Tabla detalle_recibo
CREATE TABLE detalle_recibo (
    idcompra INT PRIMARY KEY,
    estado ENUM('Pendiente', 'Completado') DEFAULT 'Pendiente' NOT NULL,
    total_compra DECIMAL(10,2),
    FOREIGN KEY (idcompra) REFERENCES compra(idcompra)
);

-- Tabla detalle_envio
CREATE TABLE detalle_envio (
    idcompra INT PRIMARY KEY,
    direccion VARCHAR(255) NOT NULL,
    estado ENUM('Pendiente', 'Completado') DEFAULT 'Pendiente' NOT NULL,
    total_compra DECIMAL(10,2),
    FOREIGN KEY (idcompra) REFERENCES compra(idcompra)
);

-- Tabla maneja
CREATE TABLE maneja (
    idcompra INT,
    idenvio INT,
    PRIMARY KEY (idcompra, idenvio),
    FOREIGN KEY (idcompra) REFERENCES detalle_envio(idcompra),
    FOREIGN KEY (idenvio) REFERENCES envio(idenvio)
);

-- Tabla especifica
CREATE TABLE especifica (
    idcompra INT,
    idrecibo INT,
    PRIMARY KEY (idcompra, idrecibo),
    FOREIGN KEY (idcompra) REFERENCES detalle_recibo(idcompra),
    FOREIGN KEY (idrecibo) REFERENCES centrorecibo(idrecibo)
);


/* Valores para rellenar tablas */

INSERT INTO categoria (nombre, descripcion) VALUES
('vehículos', 'Productos relacionados con vehículos y transporte'),
('electrodomésticos', 'Aparatos eléctricos para el hogar'),
('hogar', 'Productos para el hogar y decoración'),
('oficina', 'Equipos y suministros para la oficina'),
('librería', 'Artículos de librería y papelería'),
('belleza', 'Productos para el cuidado personal y belleza'),
('bebés', 'Artículos para el cuidado de bebés'),
('juguetes', 'Juguetes y entretenimiento para niños'),
('deportes', 'Equipos y accesorios deportivos'),
('música', 'Instrumentos musicales y accesorios'),
('tecnología', 'Artículos tecnológicos y dispositivos electrónicos'),
('celulares', 'Teléfonos móviles y accesorios'),
('herramientas', 'Herramientas y equipos de construcción');

INSERT INTO metodopago (proveedor) VALUES
('Tarjeta de Crédito'),
('PayPal'),

INSERT INTO centrorecibo (nombre, telefono) VALUES 
('Centro de Recibo - Tres Cruces', '+598 2901 1234'),
('Centro de Recibo - Unión', '+598 2506 5678'),
('Centro de Recibo - Portones Shopping', '+598 2604 9876'),
('Centro de Recibo - Prado', '+598 2336 1122'),
('Centro de Recibo - Ciudad Vieja', '+598 2915 4455');

