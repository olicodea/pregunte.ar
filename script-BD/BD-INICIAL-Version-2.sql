CREATE DATABASE IF NOT EXISTS preguntear;
USE preguntear;

CREATE TABLE rol(
  idRol int PRIMARY KEY AUTO_INCREMENT,
  descripcion varchar(50) NOT NULL
);

INSERT INTO rol (descripcion) VALUES ('Jugador'), ('Editor'), ('Admin'), ('NoValidado');

CREATE TABLE usuario (
  idUsuario int PRIMARY KEY AUTO_INCREMENT,
  nombreCompleto varchar(100) NOT NULL,
  fechaDeNacimiento date NOT NULL,
  genero varchar(50) NOT NULL,
  pais varchar(50) NOT NULL,
  ciudad varchar(100) NOT NULL,
  mail varchar(50) NOT NULL,
  nombreDeUsuario varchar(50) NOT NULL,
  contrasenia varchar(50) NOT NULL,
  fotoDePerfil varchar(255) NOT NULL,
  idRol int NOT NULL,
  FOREIGN KEY (idRol) REFERENCES rol(idRol)
);

INSERT INTO usuario (nombreCompleto, fechaDeNacimiento, genero, pais, ciudad, mail, nombreDeUsuario, contrasenia, fotoDePerfil, idRol) VALUES
('Juan Ignacio', '2004-06-01', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'joliva@mail.com', 'joliva', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.jpg', 1),
('Nicolas Villafañe', '2003-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'nvilla@mail.com', 'nvilla', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1),
('Mariano Soto', '2002-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'msoto@mail.com', 'msoto', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1),
('Cristian Medina', '2001-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'cmedina@mail.com', 'cmedina', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1),
('Sebastian Tarifa', '2000-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'starifa@mail.com', 'starifa', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1)
;

# Todas las contraseñas son = 'Prueba123/'

CREATE TABLE respuesta (
  idRespuesta int PRIMARY KEY AUTO_INCREMENT,
  respuestaA varchar(100) DEFAULT NULL,
  respuestaB varchar(100) DEFAULT NULL,
  respuestaC varchar(100) DEFAULT NULL,
  respuestaCorrecta varchar(100) DEFAULT NULL
);

INSERT INTO respuesta (respuestaA, respuestaB, respuestaC, respuestaCorrecta) VALUES
('Pete Sampras y Roger Federer', 'Roger Federer y Novak Djokovic', 'Jimmy Connors y Andre Agassi', 'Rafa Nadal y Novak Djokovic'),
('Alemania', 'Francia', 'Italia', 'Argentina');

CREATE TABLE dificultad (
  idDificultad int PRIMARY KEY AUTO_INCREMENT,
  descripcion varchar(50) NOT NULL
);

INSERT INTO dificultad (descripcion) VALUES
("FÁCIL"), ("MEDIA"), ("DIFÍCIL");

CREATE TABLE ranking (
  idRanking int PRIMARY KEY AUTO_INCREMENT,
  puntaje int NOT NULL,
  puesto int NOT NULL,
  idUsuario int NOT NULL,
  FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

INSERT INTO ranking (puntaje, puesto, idUsuario) VALUES
(100, 1, 1);

CREATE TABLE categoria_preguntas (
  idCategoria int PRIMARY KEY AUTO_INCREMENT,
  descripcion varchar(50) NOT NULL,
  color varchar(50) NOT NULL
);

INSERT INTO categoria_preguntas (descripcion, color) VALUES
("Deportes", "#ec4899");

CREATE TABLE pregunta (
  idPregunta int PRIMARY KEY AUTO_INCREMENT,
  pregunta varchar(255) NOT NULL,
  idDificultad int NOT NULL,
  idCategoria int NOT NULL,
  idUsuario int NOT NULL,
  idRespuesta int NOT NULL,
  FOREIGN KEY (idDificultad) REFERENCES dificultad(idDificultad),
  FOREIGN KEY (idCategoria) REFERENCES categoria_preguntas(idCategoria),
  FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
  FOREIGN KEY (idRespuesta) REFERENCES respuesta(idRespuesta)
);

INSERT INTO pregunta (pregunta, idDificultad, idCategoria, idUsuario, idRespuesta) VALUES
('¿Quienes son los tenistas con más títulos de Grand Slam en la historia del tenis masculino?', 1, 1, 1, 1),
('¿Quién ganó la Copa del Mundo de Fútbol en 2022?', 1, 1, 1, 2);

CREATE TABLE estado_pregunta (
  idEstado int PRIMARY KEY AUTO_INCREMENT,
  idPregunta int NOT NULL,
  descripcion varchar(50) NOT NULL,
  FOREIGN KEY (idPregunta) REFERENCES pregunta(idPregunta)
);

INSERT INTO estado_pregunta (idPregunta, descripcion) VALUES
(1, "ACEPTADA");

CREATE TABLE partida(
  idPartida int PRIMARY KEY AUTO_INCREMENT,
  idUsuario int NOT NULL,
  puntaje int NOT NULL,
  #idPregunta int NOT NULL,
  cantidadDeRespuestasAcertadas int NOT NULL,
  duracion time NOT NULL,
  FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

INSERT INTO partida (idUsuario, puntaje, cantidadDeRespuestasAcertadas, duracion) VALUES
(1, 40, 15, 500);

CREATE TABLE estadisticas_jugadores (
  idEstadistica int PRIMARY KEY AUTO_INCREMENT,
  idUsuario int NOT NULL,
  idPartida int NOT NULL,
  FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
  FOREIGN KEY (idPartida) REFERENCES partida(idPartida)
);

INSERT INTO estadisticas_jugadores(idUsuario, idPartida) VALUES
(1, 1);

CREATE TABLE pregunta_respondida (
  idPreguntaRespondida int PRIMARY KEY AUTO_INCREMENT,
  idPregunta int NOT NULL,
  idUsuario int NOT NULL,
  FOREIGN KEY (idPregunta) REFERENCES pregunta(idPregunta),
  FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

INSERT INTO pregunta_respondida (idPregunta, idUsuario) VALUES
(2, 1);

CREATE TABLE validaciones (
	idValidacion int PRIMARY KEY AUTO_INCREMENT,
    codigo varchar(255) NOT NULL,
    idUsuario int NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);