CREATE DATABASE ChileteFarmacia;
USE ChileteFarmacia;

/**
  * Personal
  * Medicos
  */
CREATE TABLE planillas_personal (
	personalid INT(11) NOT NULL auto_increment PRIMARY KEY,
    dniPersonal CHAR(11) NOT NULL,
	nombres VARCHAR(255) NOT NULL,
	apellidoPaterno VARCHAR(100) NOT NULL,
    apellidoMaterno VARCHAR(100) NOT NULL,
    fechaNac DATE NOT NULL,
    generoPersonal INT(11) DEFAULT NULL,
    estadoCivil INT(11) DEFAULT NULL,
    rolePersonal INT(11) DEFAULT NULL,
    estadoPersonal INT(1) NOT NULL
);

CREATE TABLE planillas_medicos (
	medicoid INT(11) NOT NULL auto_increment PRIMARY KEY,
    numColegiatura CHAR(22) NOT NULL,
	nombres VARCHAR(255) NOT NULL,
	apellidoPaterno VARCHAR(100) NOT NULL,
    apellidoMaterno VARCHAR(100) NOT NULL,
    especialidad VARCHAR(255) DEFAULT NULL,
    direccion VARCHAR(400) DEFAULT NULL,
    telefono CHAR(9) DEFAULT NULL,
    estadoMedico INT(1) NOT NULL
);

/**
  * Usuario
  */
CREATE TABLE admin_usuario (
	usuarioid INT(11) NOT NULL auto_increment PRIMARY KEY,
    usuario CHAR(50) NOT NULL,
    passUser CHAR(100) NOT NULL,
    personalid INT(11) NOT NULL,
    emailPersonal VARCHAR(255) DEFAULT NULL,
    estadoUsuario INT(1) NOT NULL
);

/**
  * TABLAS VARIOS
  */
CREATE TABLE utiles_tabla_varios (
	tablaid INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tablaNombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL,
	estadoTabla INT(1) NOT NULL,
    UNIQUE KEY (tablaNombre)
);

CREATE TABLE utiles_tabla_varios_detalle (
	detalleid INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombreDetalle VARCHAR(255) NOT NULL,
    ordenDetalle INT(11) DEFAULT NULL,
    tablaid INT(11) NOT NULL,
    FOREIGN KEY (tablaid) REFERENCES utiles_tabla_varios(tablaid)
);

/**
  * COMERCIAL
  */
CREATE TABLE comercial_locales (
	localid INT(11) PRIMARY KEY auto_increment NOT NULL,
    nombreLocal CHAR(255) NOT NULL,
    phonesLocal CHAR(255) DEFAULT NULL,
    emailLocal CHAR(255) DEFAULT NULL,
    direccionLocal CHAR(255) DEFAULT NULL,
    tipoLocal INT(11) DEFAULT NULL,
    activeLocal INT(1) NOT NULL
);
CREATE TABLE comercial_cliente (
	clienteid INT(11) PRIMARY KEY auto_increment NOT NULL,
    tipodoc INT(11) NOT NULL,
    documento CHAR(22) NOT NULL,
    razonsocial VARCHAR(255) NOT NULL,
    direccion_fiscal VARCHAR(255) DEFAULT NULL,
    emailCliente VARCHAR(100) DEFAULT NULL,
    phoneCliente VARCHAR(20) DEFAULT NULL,
    estadoCliente INT(1) NOT NULL
);
CREATE TABLE comercial_proveedor(
	auxiliarid INT(11) PRIMARY KEY auto_increment NOT NULL,
    tipodoc INT(11) NOT NULL,
    documento CHAR(22) NOT NULL,
    razonsocial VARCHAR(255) NOT NULL,
    direccion_fiscal VARCHAR(255) DEFAULT NULL,
    emailAux VARCHAR(100) DEFAULT NULL,
    phoneAux VARCHAR(20) DEFAULT NULL,
    paisAux INT(11) NOT NULL,
    tipoAux INT(11) NOT NULL,
    estadoAux INT(1) NOT NULL
);
/**
  * ALMACEN
  */ 
CREATE TABLE almacen_producto (
	productoid INT(11) PRIMARY KEY auto_increment NOT NULL,
    nameProduct CHAR(255) NOT NULL,
    descripcionProduct CHAR(255) DEFAULT NULL,
    codeAlmacen CHAR(255) DEFAULT NULL,
    codeBarras CHAR(255) DEFAULT NULL,
    categoryProduct INT(11) DEFAULT NULL,
    unidadProducto INT(11) NOT NULL,
    marcaProducto INT(11) DEFAULT NULL,
    modeloProducto INT(11) DEFAULT NULL,
    statusProducto INT(1) NOT NULL
);















