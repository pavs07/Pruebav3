
-- SCRIPT DE CREACIÓN DE BASE DE DATOS
-- Proyecto: Prueba V3
-- Autor: Pablo Valdivia
-- Descripción: Crea la base de datos y tablas necesarias


-- 1️ Crear base de datos (solo si no existe)
CREATE DATABASE pruebav3;
\c pruebav3;


-- 2️ CREACIÓN DE TABLAS


-- Tabla: bodega
CREATE TABLE bodega (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla: moneda
CREATE TABLE moneda (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL
);

-- Tabla: sucursales
CREATE TABLE sucursales (
    id SERIAL PRIMARY KEY,
    id_bodega INT REFERENCES bodega(id),
    nombre VARCHAR(100) NOT NULL
);

-- Tabla: producto
CREATE TABLE producto (
    codigo VARCHAR(50) PRIMARY KEY NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    precio NUMERIC(10,2) NOT NULL,
    moneda VARCHAR(50),
    bodega VARCHAR(100),
    sucursal VARCHAR(100),
    descripcion TEXT,
    materiales TEXT
);


-- 3 INSERCIÓN DE DATOS BASE


-- Datos: bodega
INSERT INTO bodega (nombre) VALUES
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

-- Datos: moneda
INSERT INTO moneda (codigo) VALUES
('USD'),
('CLP'),
('ARS');

-- Datos: sucursales
INSERT INTO sucursales (id_bodega, nombre) VALUES
(1, 'Sucursal Central 1'),
(1, 'Sucursal Central 2'),
(2, 'Sucursal Norte 1'),
(2, 'Sucursal Norte 2'),
(3, 'Sucursal Sur 1'),
(3, 'Sucursal Sur 2');

-- La tabla producto queda vacía intencionalmente
-- para que los productos se inserten desde la aplicación.

-- Para verificar:
-- SELECT * FROM bodega;
-- SELECT * FROM moneda;
-- SELECT * FROM sucursales;
-- SELECT * FROM producto;

-- Fin del script