-- Crear tabla tipo_documento
CREATE TABLE IF NOT EXISTS tipo_documento (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) DEFAULT NULL,
  descripcion VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (id)
);

-- Crear tabla sexo
CREATE TABLE IF NOT EXISTS sexo (
  id INT NOT NULL AUTO_INCREMENT,
  descripcion VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
);

-- Crear tabla grupo_sanguineo
CREATE TABLE IF NOT EXISTS grupo_sanguineo (
  id INT NOT NULL AUTO_INCREMENT,
  grupo VARCHAR(3) NOT NULL,
  PRIMARY KEY (id)
);

-- Crear tabla personas
CREATE TABLE IF NOT EXISTS personas (
  id INT NOT NULL AUTO_INCREMENT,
  primer_nombre VARCHAR(50) NOT NULL,
  segundo_nombre VARCHAR(50),
  primer_apellido VARCHAR(50) NOT NULL,
  segundo_apellido VARCHAR(50),
  tipo_documento_id INT NOT NULL,
  numero_documento VARCHAR(20) NOT NULL UNIQUE,
  sexo_id INT NOT NULL,
  grupo_sanguineo_id INT,
  fecha_nacimiento DATE,
  PRIMARY KEY (id),
  FOREIGN KEY (tipo_documento_id) REFERENCES tipo_documento(id),
  FOREIGN KEY (sexo_id) REFERENCES sexo(id),
  FOREIGN KEY (grupo_sanguineo_id) REFERENCES grupo_sanguineo(id)
);

-- Crear tabla programa_formacion
CREATE TABLE IF NOT EXISTS programa_formacion (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);

-- Crear tabla aprendices
CREATE TABLE IF NOT EXISTS aprendices (
  id INT NOT NULL AUTO_INCREMENT,
  persona_id INT NOT NULL,
  programa_formacion_id INT NOT NULL,
  numero_ficha VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (persona_id) REFERENCES personas(id),
  FOREIGN KEY (programa_formacion_id) REFERENCES programa_formacion(id)
);