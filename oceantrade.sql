
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
    sku INT UNIQUE NOT NULL,
    fechacrea DATE NOT NULL,
    fechamod DATE NOT NULL CHECK (fechamod >= fechacrea),
    total INT(5) NOT NULL CHECK (total >= 0),
    cantidad TINYINT(2) NOT NULL CHECK (cantidad >= 0),
    FOREIGN KEY (idus) REFERENCES cliente(idus)
);

-- Tabla metodopago
CREATE TABLE metodopago (
    idpago INT AUTO_INCREMENT PRIMARY KEY,
    proveedor VARCHAR(40) NOT NULL,
    estado  ENUM('activo', 'inactivo') NOT NULL
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
    activo ENUM('sí', 'no') DEFAULT 'si'
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
    tipo_stock ENUM('unidad','cantidad'),
    FOREIGN KEY (idemp) REFERENCES empresa(idemp)
);

-- Tabla compra
CREATE TABLE compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idpago INT UNIQUE NOT NULL,
    estado ENUM('Completado', 'Pendiente', 'Cancelado') NOT NULL,
    direccion VARCHAR(50) NOT NULL,
    FOREIGN KEY (idpago) REFERENCES metodopago(idpago)
);

-- Tabla vehiculo
CREATE TABLE vehiculo (
    idv INT AUTO_INCREMENT PRIMARY KEY,
    capacidad INT(6) NOT NULL CHECK (capacidad > 0),
    modelo VARCHAR(20) NOT NULL,
    tipo ENUM('electrico', 'hibrido', 'termico') NOT NULL,
    marca VARCHAR(20) NOT NULL,
    estado ENUM('disponible', 'mantenimiento', 'uso') DEFAULT 'disponible',
    hcarbono INT(6) DEFAULT 0 CHECK (hcarbono >= 0)
);

-- Tabla pagina
CREATE TABLE pagina (
    url VARCHAR(255) PRIMARY KEY,
    estado ENUM('activo', 'mantenimiento') DEFAULT 'activo'
);

-- Tabla envio
CREATE TABLE envio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idv INT UNIQUE NOT NULL,
    fecsa DATE NOT NULL,
    fecen DATE NOT NULL CHECK (fecen >= fecsa),
    FOREIGN KEY (idv) REFERENCES vehiculo(idv)
);

-- Tabla centrorecibo
CREATE TABLE centrorecibo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telefono VARCHAR(18) UNIQUE NOT NULL,
    FOREIGN KEY (id) REFERENCES compra(id)
);

-- Tabla inicia
CREATE TABLE inicia (
    id INT,
    idpago INT,
    PRIMARY KEY (id, idpago),
	FOREIGN KEY (idpago) REFERENCES metodopago(idpago),
    FOREIGN KEY (id) REFERENCES compra(id)
);

-- Tabla cierra
CREATE TABLE cierra (
    idpago INT,
    idcarrito INT,
    PRIMARY KEY (idpago, idcarrito),
    FOREIGN KEY (idpago) REFERENCES metodopago(idpago),
    FOREIGN KEY (idcarrito) REFERENCES carrito(idcarrito)
);

-- Tabla transporta
CREATE TABLE transporta (
    id INT,
    idv INT,
    PRIMARY KEY (id, idv),
    FOREIGN KEY (id) REFERENCES compra(id),
    FOREIGN KEY (idv) REFERENCES vehiculo(idv)
);



-- Tabla recibe
CREATE TABLE recibe (
    idus INT,
    id INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    PRIMARY KEY (idus, id),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (id) REFERENCES compra(id)
);

-- Tabla retira
CREATE TABLE retira (
    idus INT,
    id INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    PRIMARY KEY (idus, id),
    FOREIGN KEY (idus) REFERENCES cliente(idus),
    FOREIGN KEY (id) REFERENCES compra(id)
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
