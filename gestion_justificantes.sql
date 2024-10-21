DROP DATABASE IF EXISTS gestion_justificantes;
CREATE DATABASE gestion_justificantes;
USE gestion_justificantes;

/* CREACIÓN DE LAS TABLAS */
CREATE TABLE `administrador` (
  `idAdmin` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreAdmin` varchar(50) NOT NULL,
  `apellidoAdmin` varchar(50) NOT NULL,
  `passAd` varchar(25) NOT NULL
);

CREATE TABLE `alumno` (
  `idAlumno` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreAlu` varchar(50) NOT NULL,
  `apellidoAlu` varchar(60) NOT NULL,
  `feNac` date NOT NULL,
  `matricula` varchar(25) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `confirmacionContra` varchar(15) NOT NULL
);  

CREATE TABLE `profesor` (
  `idProf` int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreProf` varchar(50) NOT NULL,
  `apellidoProf` varchar(50) NOT NULL,
  `passwordProf` varchar(25) NOT NULL,
  `correoElectronico` varchar(50) NOT NULL
);

CREATE TABLE `evidencia` (
  `idEvi` INT PRIMARY KEY AUTO_INCREMENT,
  `nomenclatura` VARCHAR(255) NOT NULL,
  `ruta` VARCHAR(255) NOT NULL
);

CREATE TABLE `motivo` (
  `idMotivo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `docSolicitado` varchar(200) NOT NULL
);

CREATE TABLE `justificante` (
  `idJusti` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `matricula` VARCHAR(25) NOT NULL,  -- Cambié la longitud de matricula a 25
  `cuatrimestre` INT NOT NULL,
  `grupo` VARCHAR(10) NOT NULL,
  `carrera` VARCHAR(100) NOT NULL,
  `periodo` VARCHAR(100) NOT NULL,
  `motivo` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `horaInicio` TIME NULL,
  `horaFin` TIME NULL,
  `ausenteTodoDia` BOOLEAN NOT NULL,
  `motivoExtra` VARCHAR(200) NULL,
  `estado` VARCHAR(50) DEFAULT 'Pendiente',
  `idEvi` INT,
  FOREIGN KEY (`idEvi`) REFERENCES `evidencia`(`idEvi`)
);

CREATE TABLE `justificante_profesor` (
  `idDetalle` INT PRIMARY KEY AUTO_INCREMENT,
  `idJusti` INT,
  `idProf` INT,
  FOREIGN KEY (`idJusti`) REFERENCES `justificante`(`idJusti`),
  FOREIGN KEY (`idProf`) REFERENCES `profesor`(`idProf`)
); 

-- Crear la tabla pdf_generado
CREATE TABLE pdf_generado (
    idPdf INT AUTO_INCREMENT PRIMARY KEY,          -- ID del archivo PDF generado
    idJusti INT NOT NULL,                          -- Referencia al justificante
    nombrePdf VARCHAR(255) NOT NULL,               -- Nombre del archivo PDF generado
    rutaPdf VARCHAR(255) NOT NULL,                 -- Ruta de almacenamiento del archivo
    fechaGeneracion DATETIME NOT NULL,             -- Fecha y hora de generación del PDF
    FOREIGN KEY (idJusti) REFERENCES justificante(idJusti) -- Llave foránea hacia la tabla justificante
);

/** INSERCIONES DE LAS TABLAS */
INSERT INTO `alumno` (`nombreAlu`, `apellidoAlu`, `feNac`, `matricula`, `contrasena`) VALUES
('Wendy', 'Moreno', '2004-08-05', 'MBWO220238', '123'),
('Dulce Yessenia', 'Villega Martinez', '2004-05-27', 'VMDO220377', '456'),
('Yatziry Amairani', 'Serrano Hernández', '2004-01-24', 'SHYO221058', '569'),
('Kevin', 'Trinidad Medina', '2004-02-10', 'TMK0220477', '785');

INSERT INTO `profesor` (`nombreProf`, `apellidoProf`, `passwordProf`, `correoElectronico`) VALUES
('Sandra Elizabeth', 'León Sosa', '1245', 'lsandra@upemor.edu.mx'),
('Deny Lizbeth', 'Hernández Rabadán', '7845', 'dhernandezr@upemor.edu.mx');

INSERT INTO `administrador` (`nombreAdmin`, `apellidoAdmin`, `passAd`) VALUES
('María Guadalupe', 'Ruiz Soto', '7845');

INSERT INTO `motivo` (`idMotivo`, `tipo`, `descripcion`, `docSolicitado`) VALUES
(1, 'Causa de fuerza mayor', 'Situaciones fuera del control del alumno como eventos imprevistos.', 'Fotografías tomadas al momento en un archivo PDF o documento que avale la falta (Todo en formato PDF).'),
(2, 'Enfermedad', 'Cuando un alumno se ve afectado por una enfermedad que le impide realizar sus actividades académicas', 'Recetas médicas, constancia, carnet o registro de cita (Todo en formato PDF).'),
(3, 'Problemas de Salud', 'El alumno tiene citas médicas o cita para análisis.', 'Recetas médicas, constancia, carnet, registro de cita y/o resultados de análisis (Todo en formato PDF).'),
(4, 'Accidente', 'Aplica para lesiones o daños que limitan temporalmente la capacidad del alumno de cumplir con las actividades o responsabilidades académicas.', 'Fotografías tomadas al momento, receta, constancia del IMSS o ISSTE en (Todo en archivo PDF).'),
(7, 'Trámite de carácter urgente', 'Trámite legal, gubernamental o personal, que el alumno no puede posponer', 'Documento proporcionado por la institución, fotografía de que asistió en el momento o documento de la cita (Todo en formato PDF).');
