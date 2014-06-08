##################################
#                                #
#      Base de Datos Report      #
#                                #
##################################

# Establecemos zona horario por defecto.
SET time_zone = "-06:00";

# CREAMOS LA BASE DE DATOS EN CASO DE NO EXISTIR
CREATE DATABASE IF NOT EXISTS report CHARACTER SET latin1 COLLATE latin1_spanish_ci; 

# UTILIZAMODS DICHA BASE DE DATOS.
USE report;

# CREAMOS LA TABLA DE DEPARTAMENTOS
CREATE TABLE IF NOT EXISTS departament(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	departament VARCHAR(255) NOT NULL,
	extension SMALLINT(6) UNSIGNED ZEROFILL NOT NULL, 
	UNIQUE(departament)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# AGREGAMOS ALGUNOS DEPRTAMENTOS.
INSERT INTO departament (departament) VALUES
	('UTEyCV'),
	('Activo Fijo'),
	('Dirección'),
	('Subdirección'),
	('Gestión Escolar');

# CREAMOS LA TABLA DE TIPO DE USUARIOS DEL SYSMTEMA.
CREATE TABLE IF NOT EXISTS type(
	id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(255) NOT NULL,
	url VARCHAR(1000) NOT NULL,
	UNIQUE(type) 
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# AGREGAMOS ALGUNOS TIPOS DE USUARIO AL SYSTEMA.
INSERT INTO type (type, url)  VALUES 
	('Administrador', 'system/admi/'),
	('Cliente', 'system/client/employee/'),
	('Jefe de Academia', 'system/client/manager/'),
	('Técnico de Diseño', 'system/technical/design/'),
	('Técnico de Hardware', 'system/technical/hardware/'),
	('Técnico de Software', 'system/technical/software/');

# CREAMOS LA TABLA DE USUARIOS DEL SYSTEMA.
CREATE TABLE IF NOT EXISTS users(
	nombre VARCHAR(50) NOT NULL,
	apaterno VARCHAR(50) NOT NULL,
	amaterno VARCHAR(50) NOT NULL,
	username INT(10) UNSIGNED ZEROFILL NOT NULL PRIMARY KEY,
	password VARCHAR(255) NOT NULL,
	email VARCHAR(320) NOT NULL,
	departament SMALLINT(3) UNSIGNED NOT NULL REFERENCES departament(id),
	type SMALLINT(3) UNSIGNED NOT NULL REFERENCES type(id),
	authorized ENUM('true', 'false') NOT NULL DEFAULT 'false',
	UNIQUE(email)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;

# AGREGAMOS AL ADMINISTRADOR DEL SYSTEMA.
INSERt INTO users () VALUES
	('Cristian Gerardo', 'Jaramillo', 'Cruz', '2011081473', '5cbb02ecddbbef849a12b2dc477238aa', 'cristian_gerar@hotmail.com', '1', '1', 'true');

# CREAMOS LA TABLA DE CONECCIONES AL SYSTEMA.
CREATE TABLE IF NOT EXISTS connection(
	username INT(10) UNSIGNED ZEROFILL NOT NULL REFERENCES users(username),
	date_income DATE NOT NULL,
	time_income TIME NOT NULL,
	date_departure DATE NOT NULL,
	time_departure TIME NOT NULL,
	UNIQUE(username)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# AGREGAMOS AL ADMINISTRADOR REGISTRADO.
INSERT INTO connection (username) VALUES
	('2011081473');

# AGREGAMOS LA TABLA DE REPORTES.
CREATE TABLE IF NOT EXISTS report (
  	id smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  	client int(10) UNSIGNED zerofill NOT NULL REFERENCES users(username),
  	technical int(10) UNSIGNED zerofill NOT NULL REFERENCES users(username),
  	PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# CREAMOS LA TABLA CON LA DESCRIPCIÓN DE LOS REPORTES.
CREATE TABLE IF NOT EXISTS report_description (
	id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  	id_report SMALLINT(3) UNSIGNED NOT NULL REFERENCES report(id),
  	date_creation DATE NOT NULL,
  	time_creation TIME NOT NULL,
  	problem VARCHAR(255) NOT NULL,
  	date_eading DATE NOT NULL,
  	time_eading TIME NOT NULL,
  	response VARCHAR(255) NOT NULL,
  	evaluation VARCHAR(255) NOT NULL,
  	status SMALLINT(3) UNSIGNED NOT NULL REFERENCES status(id),
  	PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# CREAMOS LA TABLA CON LAS SOLICITUDES DEl DISEÑADOR.
CREATE TABLE IF NOT EXISTS design_description(
	id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
	id_design SMALLINT(3) UNSIGNED NOT NULL REFERENCES report(id),
	date_creation DATE NOT NULL,
  	time_creation TIME NOT NULL,
  	requirements VARCHAR(1024) NOT NULL,
  	date_eading DATE NOT NULL,
  	time_eading TIME NOT NULL,
  	response VARCHAR(255) NOT NULL,
  	evaluation VARCHAR(255) NOT NULL,
  	status SMALLINT(3) UNSIGNED NOT NULL REFERENCES status(id),
  	PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# CREAMOS LA TABLA CON lA COLLECIÓN DE IMAGENES
CREATE TABLE IF NOT EXISTS img_url(
	id SMALLINT(3) UNSIGNED NOT NULL REFERENCES design_description(id),
	description VARCHAR(255) NOT NULL DEFAULT 'Sin descrición',
	url VARCHAR(255) NOT NULL DEFAULT 'no_found.jpg'
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

# CREAMOS LA TABLA CON LOS ESTADOS DE UNA SOLICITUD.
CREATE TABLE IF NOT EXISTS status(
	id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
	status VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;