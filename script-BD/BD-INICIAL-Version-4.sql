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
respuestaD varchar(100) DEFAULT NULL,
respuestaCorrecta varchar(100) DEFAULT NULL
);

INSERT INTO respuesta (respuestaA, respuestaB, respuestaC, respuestaD, respuestaCorrecta) VALUES
('Pete Sampras y Roger Federer', 'Roger Federer y Novak Djokovic', 'Jimmy Connors y Andre Agassi', 'Rafa Nadal y Novak Djokovic', 'Rafa Nadal y Novak Djokovic'),
('Alemania', 'Francia', 'Italia', 'Argentina', 'Argentina'),
('Michael Phelps', 'Usain Bolt', 'Simone Biles', 'Carl Lewis', 'Michael Phelps'),
('Júpiter', 'Venus', 'Marte', 'Urano', 'Marte'),
('Protón', 'Neutrón', 'Electrón', 'Positrón', 'Electrón'),
('Diabetes', 'Asma', 'Artritis', 'Anemia', 'Artritis'),
('Winston Churchill', 'Joseph Stalin', 'Franklin D. Roosevelt', 'Adolf Hitler', 'Winston Churchill'),
('Mayas', 'Romanos', 'Egipcios', 'Persas', 'Egipcios'),
('Abraham Lincoln', 'George Washington', 'Thomas Jefferson', 'John F. Kennedy', 'George Washington'),
('Pablo Picasso', 'Vincent van Gogh', 'Leonardo Da Vinci', 'Claude Monet', 'Leonardo Da Vinci'),
('Wolfgang Amadeus Mozart', 'Ludwig van Beethoven', 'Johann Sebastian Bach', 'Frédéric Chopin', 'Ludwig van Beethoven'),
('La Venus de Milo', 'El David', 'El Pensador', 'El Cristo Redentor', 'El Cristo Redentor'),
('España', 'Portugal', 'Francia', 'Andorra', 'Francia'),
('Nilo', 'Amazonas', 'Misisipi', 'Yangsté', 'Amazonas'),
('México', 'Sudáfrica', 'Australia', 'Rusia', 'Rusia'),
('Microsoft', 'Apple', 'Google', 'Samsung', 'Apple'),
('USB', 'HDMI', 'NFC', 'LTE', 'NFC'),
('Facebook', 'Instagram', 'Twitter', 'Linkedin', 'Instagram'),
('Chris Hemsworth', 'Chris Evans', 'Tom Holland', 'Robert Downey Jr.', 'Robert Downey Jr.'),
('The Rolling Stones', 'Led Zeppelin', 'AC/DC', 'Queen', 'Led Zeppelin'),
('Joker', 'Parasite', '1917', 'The Shape of Water', 'Parasite'),
('Swift', 'Kotlin', 'C#', 'Python', 'Kotlin'),
('Herencia', 'Polimorfismo', 'Encapsulamiento', 'Abstracción', 'Herencia'),
('Git', 'SVN', 'Mercurial', 'CVS', 'Git');

CREATE TABLE dificultad (
idDificultad int PRIMARY KEY AUTO_INCREMENT,
descripcion varchar(50) NOT NULL
);

INSERT INTO dificultad (descripcion) VALUES ("FÁCIL"), ("MEDIA"), ("DIFÍCIL");

CREATE TABLE ranking (
idRanking int PRIMARY KEY AUTO_INCREMENT,
puntaje int NOT NULL,
puesto int NOT NULL,
idUsuario int NOT NULL,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

INSERT INTO ranking (puntaje, puesto, idUsuario) VALUES (100, 1, 1);

CREATE TABLE categoria_preguntas (
idCategoria int PRIMARY KEY AUTO_INCREMENT,
descripcion varchar(50) NOT NULL,
color varchar(50) NOT NULL
);

INSERT INTO categoria_preguntas (descripcion, color) VALUES
('Deportes', '#ec4899'),
('Ciencia', '#4868D9'),
('Historia', '#24BE87'),
('Arte', '#C9D844'),
('Geografia', '#D98E48'),
('Tenologia', '#2C39AE'),
('Entretenimiento', '#A88755'),
('Programacion', '#A62999');

CREATE TABLE estado_pregunta (
idEstadoPregunta int PRIMARY KEY AUTO_INCREMENT,
descripcion varchar(50) NOT NULL
);

INSERT INTO estado_pregunta (descripcion) VALUES ("ACEPTADA"), ("RECHAZADA"), ("PARA APROBAR");

CREATE TABLE pregunta (
idPregunta int PRIMARY KEY AUTO_INCREMENT,
pregunta varchar(255) NOT NULL,
idDificultad int NOT NULL,
idCategoria int NOT NULL,
idUsuario int NULL,
idRespuesta int NOT NULL,
idEstadoPregunta int NOT NULL,
FOREIGN KEY (idDificultad) REFERENCES dificultad(idDificultad),
FOREIGN KEY (idCategoria) REFERENCES categoria_preguntas(idCategoria),
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
FOREIGN KEY (idRespuesta) REFERENCES respuesta(idRespuesta),
FOREIGN KEY (idEstadoPregunta) REFERENCES estado_pregunta(idEstadoPregunta)
);

INSERT INTO pregunta (pregunta, idDificultad, idCategoria, idUsuario, idRespuesta, idEstadoPregunta) VALUES
('¿Quienes son los tenistas con más títulos de Grand Slam en la historia del tenis masculino?', 2, 1, 1, 1, 1),
('¿Quién ganó la Copa del Mundo de Fútbol en 2022?', 1, 1, 1, 2, 1),
('¿Quién tiene el récord de más medallas de oro olímpicas en la historia de los Juegos Olímpicos?', 2, 1, NULL, 3, 1),
('¿Cuál de los siguientes planetas del sistema solar es conocido como el planeta rojo?', 1, 2, NULL, 4, 1),
('¿Cuál de las siguientes partículas subatómicas tiene una carga eléctrica negativa?', 3, 2, NULL, 5, 1),
('¿Cuál de las siguientes enfermedades se caracteriza por la inflamación de las articulaciones?', 2, 2, NULL, 6, 1),
('¿Cuál de los siguientes líderes no estuvo involucrado en la Segunda Guerra Mundial?', 2, 3, NULL, 7, 1),
('¿Cuál de las siguientes civilizaciones fue conocida por construir las pirámides de Giza?', 2, 3, NULL, 8, 1),
('¿Quién fue el primer presidente de Estados Unidos?', 1, 3, NULL, 9, 1),
('¿Quién pintó la famosa obra "La última cena"?', 3, 4, NULL, 10, 1),
('¿Cuál de los siguientes compositores es conocido por su obra "La Quinta Sinfonía"?', 2, 4, NULL, 11, 1),
('¿Cuál de las siguientes esculturas famosas se encuentra en Río de Janeiro, Brasil?', 1, 4, NULL, 12, 1),
('¿Cuál de los siguientes países no forma parte de la península ibérica?', 2, 5, NULL, 13, 1),
('¿Cuál es el río más largo del mundo?', 3, 5, NULL, 14, 1),
('¿Cuál de los siguientes países se encuentra en Europa y Asia?', 1, 5, NULL, 15, 1),
('¿Cuál de las siguientes compañías es conocida por desarrollar el sistema operativo iOS?', 1, 6, NULL, 16, 1),
('¿Qué siglas representan la tecnología inalámbrica utilizada para conectar dispositivos a corta distancia?', 3, 6, NULL, 17, 1),
('¿Cuál de las siguientes redes sociales es conocida por compartir fotos y videos de corta duración?', 1, 6, NULL, 18, 1),
('¿Quién interpretó el papel de Iron Man en el Universo Cinematográfico de Marvel?', 1, 7, NULL, 19, 1),
('¿Cuál de las siguientes bandas de rock es conocida por su álbum "Stairway to Heaven"?', 2, 7, NULL, 20, 1),
('¿Cuál de las siguientes películas ganó el Premio de la Academia a la Mejor Película en el año 2020?', 3, 7, NULL, 21, 1),
('¿Qué lenguaje de programación se utiliza principalmente para desarrollar aplicaciones móviles en el sistema operativo Android?', 1, 8, NULL, 22, 1),
('¿Cuál de los siguientes conceptos de programación se refiere a la reutilización de código mediante la creación de plantillas predefinidas?', 3, 8, NULL, 23, 1),
('¿Cuál de las siguientes opciones es un sistema de control de versiones ampliamente utilizado en el desarrollo de software?', 2, 8, NULL, 24, 1);



CREATE TABLE partida(
idPartida int PRIMARY KEY AUTO_INCREMENT,
idUsuario int NOT NULL,
puntaje int NOT NULL,
#idPregunta int NOT NULL,
cantidadDeRespuestasAcertadas int NOT NULL,
duracion time NOT NULL,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

INSERT INTO partida (idUsuario, puntaje, cantidadDeRespuestasAcertadas, duracion) VALUES (1, 40, 15, 500);

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

INSERT INTO pregunta_respondida (idPregunta, idUsuario) VALUES (2, 1);

CREATE TABLE validaciones (
    idValidacion int PRIMARY KEY AUTO_INCREMENT,
    codigo varchar(255) NOT NULL,
    idUsuario int NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE reporte (
    idReporte int PRIMARY KEY AUTO_INCREMENT,
    idPregunta int NOT NULL,
    comentario varchar(255),
    FOREIGN KEY (idPregunta) REFERENCES pregunta(idPregunta)
);