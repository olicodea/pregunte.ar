CREATE DATABASE IF NOT EXISTS preguntear;
USE preguntear;

CREATE TABLE `rol` (
`idRol` int(11) PRIMARY KEY AUTO_INCREMENT,
`descripcion` varchar(50) NOT NULL
);

INSERT INTO `rol` (`idRol`, `descripcion`) VALUES
(1, 'Jugador'),
(2, 'Editor'),
(3, 'Admin'),
(4, 'NoValidado');

CREATE TABLE `usuario` (
`idUsuario` int(11) PRIMARY KEY AUTO_INCREMENT,
`nombreCompleto` varchar(100) NOT NULL,
`fechaDeNacimiento` date NOT NULL,
`genero` varchar(50) NOT NULL,
`pais` varchar(50) NOT NULL,
`ciudad` varchar(100) NOT NULL,
`mail` varchar(50) NOT NULL,
`nombreDeUsuario` varchar(50) NOT NULL,
`contrasenia` varchar(50) NOT NULL,
`fotoDePerfil` varchar(255) NOT NULL,
`idRol` int(11) NOT NULL,
`latitud` varchar(255) NOT NULL,
`longitud` varchar(255) NOT NULL,
`fechaUsuario` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idRol) REFERENCES rol(idRol)
);

INSERT INTO `usuario` (`nombreCompleto`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `mail`, `nombreDeUsuario`, `contrasenia`, `fotoDePerfil`, `idRol`, `latitud`, `longitud`, `fechaUsuario`)
VALUES
('Juan Ignacio', '2004-06-01', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'joliva@mail.com', 'joliva', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.jpg', 1, ' -34.629261', '-63.432884', '2021-06-22'),
('Nicolas Villafañe', '2003-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'nvilla@mail.com', 'nvilla', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1, ' -34.629261', '-63.432884', '2021-06-26'),
('Mariano Soto', '2002-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'msoto@mail.com', 'msoto', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1, ' -34.629261', '-63.432884', '2020-06-26'),
('Cristian Medina', '2001-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'cmedina@mail.com', 'cmedina', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 2, '-34.629261', '-63.432884', '2023-06-26'),
('Sebastian Tarifa', '2000-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'starifa@mail.com', 'starifa', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 3, '-34.629261', '-63.432884', '2023-03-20')
;

CREATE TABLE `estado_pregunta` (
`idEstadoPregunta` int(11) PRIMARY KEY AUTO_INCREMENT,
`descripcion` varchar(50) NOT NULL
);

INSERT INTO `estado_pregunta` (`idEstadoPregunta`, `descripcion`) VALUES
(1, 'ACEPTADA'),
(2, 'RECHAZADA'),
(3, 'PARA REVISAR'),
(4, 'ANULADA'),
(5, 'REPORTADA');

CREATE TABLE `categoria_preguntas` (
`idCategoria` int(11) PRIMARY KEY AUTO_INCREMENT,
`descripcion` varchar(50) NOT NULL,
`color` varchar(50) NOT NULL,
`idEstado` int NOT NULL,
FOREIGN KEY (idEstado) REFERENCES estado_pregunta(idEstadoPregunta)
);

INSERT INTO `categoria_preguntas` (`idCategoria`, `descripcion`, `color`, `idEstado`) VALUES
(1, 'Deportes', '#ec4899', 1),
(2, 'Ciencia', '#4868D9', 1),
(3, 'Historia', '#24BE87', 1),
(4, 'Arte', '#C9D844', 1),
(5, 'Geografia', '#D98E48', 1),
(6, 'Tecnologia', '#2C39AE', 1),
(7, 'Entretenimiento', '#A88755', 1),
(8, 'Programacion', '#A62999', 1);

CREATE TABLE `partida` (
`idPartida` int(11) PRIMARY KEY AUTO_INCREMENT,
`idUsuario` int(11) NOT NULL,
`puntaje` int(11) NOT NULL,
`cantidadDeRespuestasAcertadas` int(11) NOT NULL,
`duracion` int(11) NOT NULL,
`fechaPartida` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE `respuesta` (
`idRespuesta` int(11) PRIMARY KEY AUTO_INCREMENT,
`respuestaA` varchar(100) DEFAULT NULL,
`respuestaB` varchar(100) DEFAULT NULL,
`respuestaC` varchar(100) DEFAULT NULL,
`respuestaD` varchar(100) DEFAULT NULL,
`respuestaCorrecta` varchar(100) DEFAULT NULL
);


INSERT INTO `respuesta` (`respuestaA`, `respuestaB`, `respuestaC`, `respuestaD`, `respuestaCorrecta`) VALUES
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
                    ('Git', 'SVN', 'Mercurial', 'CVS', 'Rugby'),
                    ('Fútbol', 'Baloncesto', 'Rugby', 'Voleibol', 'Rugby'),
                    ('Golf', 'Hockey', 'Cricket', 'Polo', 'Golf'),
                    ('Hockey sobre hielo', 'Fútbol', 'Béisbol', 'Baloncesto', 'Hockey sobre hielo'),
                    ('Juegos Olímpicos', 'Copa Mundial de Fútbol', 'Super Bowl', 'Tour de Francia', 'Copa Mundial de Fútbol'),
                    ('Corea del Sur', 'China', 'Japón', 'Tailandia', 'Célula'),
                    ('Célula', 'Átomo', 'Molécula', 'Organismo', 'Célula'),
                    ('Oxígeno', 'Hidrógeno', 'Carbono', 'Hierro', 'Oxígeno'),
                    ('Protón', 'Electrón', 'Neutrón', 'Fotón', 'Protón'),
                    ('Producir energía', 'Transportar oxígeno', 'Regular el metabolismo', 'Almacenar información genética', 'Almacenar información genética'),
                    ('Corteza', 'Núcleo', 'Manto', 'Astenosfera', 'Corteza'),
                    ('1939', '1918', '1914', '1945', '1914'),
                    ('Imperio romano', 'Imperio mongol', 'Imperio británico', 'Imperio otomano', 'Imperio mongol'),
                    ('Estados Unidos', 'Rusia (Unión Soviética)', 'China', 'Reino Unido', 'Rusia (Unión Soviética)'),
                    ('1865', '1789', '1812', '1776', '1776'),
                    ('Vladimir Lenin', 'Joseph Stalin', 'Leon Trotsky', 'Karl Marx', 'Vladimir Lenin'),
                    ('Pablo Picasso', 'Leonardo da Vinci', 'Vincent van Gogh', 'Michelangelo Buonarroti', 'Leonardo da Vinci'),
                    ('Ludwig van Beethoven', 'Johann Sebastian Bach', 'Wolfgang Amadeus Mozart', 'Franz Schubert', 'Ludwig van Beethoven'),
                    ('La Venus de Milo', 'El David', 'La Estatua de la Libertad', 'El Partenón', 'El Partenón'),
                    ('Anton Chejov', 'Federico García Lorca', 'William Shakespeare', 'Tennessee Williams', 'William Shakespeare'),
                    ('Rusia', 'Canadá', 'China', 'Estados Unidos', 'Rusia'),
                    ('Los Andes', 'Los Alpes', 'El Himalaya', 'Las Montañas Rocosas', 'Los Andes'),
                    ('Océano Atlántico', 'Océano Pacífico', 'Océano Índico', 'Océano Ártico', 'Océano Pacífico'),
                    ('China', 'India', 'Estados Unidos', 'Brasil', 'India'),
                    ('Amazonas', 'Misisipi', 'Orinoco', 'Paraná', 'Misisipi'),
                    ('Microsoft', 'Apple', 'Google', 'IBM', 'Microsoft'),
                    ('Magnetismo', 'Láser', 'Electricidad estática', 'Memoria flash', 'Memoria flash'),
                    ('Disco duro', 'Memoria RAM', 'Procesador', 'Tarjeta gráfica', 'Disco duro'),
                    ('HDD', 'SSD', 'USB', 'RAM', 'HDD'),
                    ('Ethernet', 'Bluetooth', 'Wi-Fi', '4G', 'Ethernet'),
                    ('Daniel Radcliffe', 'Rupert Grint', 'Emma Watson', 'Tom Felton', 'Daniel Radcliffe')
;

CREATE TABLE `pregunta` (
                            `idPregunta` int(11) PRIMARY KEY AUTO_INCREMENT,
                            `pregunta` varchar(255) NOT NULL,
                            `idCategoria` int(11) NOT NULL,
                            `idUsuario` int(11) NOT NULL,
                            `idRespuesta` int(11) NOT NULL,
                            `idEstadoPregunta` int(11) NOT NULL,
                            `fechaPregunta` DATE DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (idCategoria) REFERENCES categoria_preguntas(idCategoria),
                            FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
                            FOREIGN KEY (idRespuesta) REFERENCES respuesta(idRespuesta),
                            FOREIGN KEY (idEstadoPregunta) REFERENCES estado_pregunta(idEstadoPregunta)
);

INSERT INTO `pregunta` (`pregunta`, `idCategoria`, `idUsuario`, `idRespuesta`, `idEstadoPregunta`) VALUES
                                                                                                       ('¿Quienes son los tenistas con más títulos de Grand Slam en la historia del tenis masculino?', 1, 1, 1, 1),
                                                                                                       ('¿Quién ganó la Copa del Mundo de Fútbol en 2022?', 1, 1, 2, 1),
                                                                                                       ('¿Quién tiene el récord de más medallas de oro olímpicas en la historia de los Juegos Olímpicos?', 1, 1, 3, 1),
                                                                                                       ('¿Cuál de los siguientes planetas del sistema solar es conocido como el planeta rojo?', 1, 2, 4, 1),
                                                                                                       ('¿Cuál de las siguientes partículas subatómicas tiene una carga eléctrica negativa?', 2, 2, 5, 1),
                                                                                                       ('¿Cuál de las siguientes enfermedades se caracteriza por la inflamación de las articulaciones?', 2, 2, 6, 1),
                                                                                                       ('¿Cuál de los siguientes líderes no estuvo involucrado en la Segunda Guerra Mundial?', 2, 3, 7, 1),
                                                                                                       ('¿Cuál de las siguientes civilizaciones fue conocida por construir las pirámides de Giza?', 2, 3, 8, 1),
                                                                                                       ('¿Quién fue el primer presidente de Estados Unidos?', 1, 3, 9, 1),
                                                                                                       ('¿Quién pintó la famosa obra \"La última cena\"?', 3, 4, 10, 1),
                                                                                                       ('¿Cuál de los siguientes compositores es conocido por su obra \"La Quinta Sinfonía\"?', 2, 4, 11, 1),
                                                                                                       ('¿Cuál de las siguientes esculturas famosas se encuentra en Río de Janeiro, Brasil?', 1, 4, 12, 1),
                                                                                                       ('¿Cuál de los siguientes países no forma parte de la península ibérica?', 2, 5, 13, 1),
                                                                                                       ('¿Cuál es el río más largo del mundo?', 3, 5, 14, 1),
                                                                                                       ('¿Cuál de los siguientes países se encuentra en Europa y Asia?', 1, 5, 15, 1),
                                                                                                       ('¿Cuál de las siguientes compañías es conocida por desarrollar el sistema operativo iOS?', 1, 5, 16, 1),
                                                                                                       ('¿Qué siglas representan la tecnología inalámbrica utilizada para conectar dispositivos a corta distancia?', 3, 5, 17, 1),
                                                                                                       ('¿Cuál de las siguientes redes sociales es conocida por compartir fotos y videos de corta duración?', 1, 5, 18, 1),
                                                                                                       ('¿Quién interpretó el papel de Iron Man en el Universo Cinematográfico de Marvel?', 7, 5, 19, 1),
                                                                                                       ('¿Cuál de las siguientes bandas de rock es conocida por su álbum \"Stairway to Heaven\"?', 7, 5, 20, 1),
                                                                                                       ('¿Cuál de las siguientes películas ganó el Premio de la Academia a la Mejor Película en el año 2020?', 7, 5, 21, 1),
                                                                                                       ('¿Qué lenguaje de programación se utiliza principalmente para desarrollar aplicaciones móviles en el sistema operativo Android?', 8, 5, 22, 1),
                                                                                                       ('¿Cuál de los siguientes conceptos de programación se refiere a la reutilización de código mediante la creación de plantillas predefinidas?', 8, 5, 23, 1),
                                                                                                       ('¿Cuál de las siguientes opciones es un sistema de control de versiones ampliamente utilizado en el desarrollo de software?', 8, 3, 24, 1),
                                                                                                       ('¿Cuál es el deporte que se juega en un campo rectangular dividido en dos mitades, y los equipos intentan llevar un balón ovalado hacia la zona de anotación del equipo contrario?', 1, 1, 25, 1),
                                                                                                       ('¿Qué deporte se juega golpeando una pelota con un palo en un campo con hoyos y se busca introducir la pelota en los hoyos con la menor cantidad de golpes posibles?', 1, 1, 26, 1),
                                                                                                       ('¿Cuál es el deporte más popular en Canadá?', 1, 1, 27, 1),
                                                                                                       ('¿Cuál es el evento deportivo más visto en el mundo?', 1, 1, 28, 1),
                                                                                                       ('¿Cuál es el país de origen del taekwondo?', 1, 1, 29, 1),
                                                                                                       ('¿Cuál es la unidad básica de la estructura de los seres vivos?', 2, 1, 30, 1),
                                                                                                       ('¿Cuál es el elemento químico más abundante en la Tierra?', 2, 1, 31, 1),
                                                                                                       ('¿Cuál es la partícula subatómica con carga positiva?', 2, 1, 32, 1),
                                                                                                       ('¿Cuál es la principal función del ADN en los seres vivos?', 2, 1, 33, 1),
                                                                                                       ('¿Cuál es la capa más externa de la Tierra?', 2, 1, 34, 1),
                                                                                                       ('¿En qué año comenzó la Primera Guerra Mundial?', 3, 1, 35, 1),
                                                                                                       ('¿Cuál fue el imperio más extenso de la historia?', 3, 1, 36, 1),
                                                                                                       ('¿Cuál fue el primer país en enviar un ser humano al espacio?', 3, 1, 37, 1),
                                                                                                       ('¿En qué año se firmó la Declaración de Independencia de Estados Unidos?', 3, 1, 38, 1),
                                                                                                       ('¿Quién fue el líder de la Revolución Rusa en 1917?', 3, 1, 39, 1),
                                                                                                       ('¿Quién pintó la famosa obra \"La Gioconda\"?', 4, 1, 40, 1),
                                                                                                       ('¿Cuál de los siguientes compositores es conocido por su obra \"La Novena Sinfonía\"?', 4, 1, 41, 1),
                                                                                                       ('¿Cuál de las siguientes esculturas famosas se encuentra en Atenas, Grecia?', 4, 1, 42, 1),
                                                                                                       ('¿Quién escribió la obra de teatro \"Romeo y Julieta\"?', 4, 1, 43, 1),
                                                                                                       ('¿Cuál de los siguientes países es el más grande del mundo por superficie?', 5, 1, 44, 1),
                                                                                                       ('¿Cuál es la cadena montañosa más larga del mundo?', 5, 1, 45, 1),
                                                                                                       ('¿Cuál es el océano más grande del mundo?', 5, 1, 46, 1),
                                                                                                       ('¿Cuál es el país más poblado del mundo?', 5, 1, 47, 1),
                                                                                                       ('¿Cuál de los siguientes ríos no pasa por América del Sur?', 5, 1, 48, 1),
                                                                                                       ('¿Cuál de las siguientes compañías es conocida por desarrollar el sistema operativo Windows?', 6, 1, 49, 1),
                                                                                                       ('¿Cuál de las siguientes tecnologías se utiliza para almacenar datos en discos de estado sólido (SSD)?', 6, 1, 50, 3),
                                                                                                       ('¿Cuál de los siguientes dispositivos se utiliza para almacenar información de forma permanente en una computadora?', 6, 1, 51, 1),
                                                                                                       ('¿Cuál de las siguientes tecnologías es utilizada para almacenar datos de forma permanente en discos magnéticos?', 6, 1, 52, 1),
                                                                                                       ('¿Cuál de las siguientes tecnologías se utiliza para la transmisión de datos a través de cables de cobre en redes de área local (LAN)?', 6, 1, 53, 1),
                                                                                                       ('¿Quién interpretó el papel de Harry Potter en las películas de la saga?', 7, 1, 54, 1)
;


CREATE TABLE `pregunta_respondida` (
                                       `idPreguntaRespondida` int(11) PRIMARY KEY AUTO_INCREMENT,
                                       `idPregunta` int(11) NOT NULL,
                                       `idUsuario` int(11) NOT NULL,
                                       `fueCorrecta` tinyint(4) NOT NULL,
                                       `reiniciada` tinyint(4) DEFAULT 0,
                                       FOREIGN KEY (idPregunta) REFERENCES pregunta(idPregunta),
                                       FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE `reporte` (
                           `idReporte` int(11) NOT NULL,
                           `idPregunta` int(11) NOT NULL,
                           `comentario` varchar(255) DEFAULT NULL,
                           FOREIGN KEY (idPregunta) REFERENCES pregunta(idPregunta)
);

CREATE TABLE `validaciones` (
                                `idValidacion` int(11) PRIMARY KEY AUTO_INCREMENT,
                                `codigo` varchar(255) NOT NULL,
                                `idUsuario` int(11) NOT NULL,
                                FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);


CREATE TABLE `partida_home` (
                                `idHome` int(11) PRIMARY KEY AUTO_INCREMENT,
                                `pregunta` varchar(200) NOT NULL,
                                `respuestaA` varchar(100) NOT NULL,
                                `respuestaB` varchar(100) NOT NULL,
                                `respuestaC` varchar(100) NOT NULL,
                                `respuestaD` varchar(100) NOT NULL,
                                `respuestaCorrecta` varchar(100) NOT NULL,
                                `idCategoria` int(11) NOT NULL,
                                FOREIGN KEY (idCategoria) REFERENCES categoria_preguntas(idCategoria)
);

INSERT INTO `partida_home` (`idHome`, `pregunta`, `respuestaA`, `respuestaB`, `respuestaC`, `respuestaD`, `respuestaCorrecta`, `idCategoria`) VALUES
    (1, '¿Qué jugador ha ganado el premio FIFA Balón de Oro más veces en la historia?', 'Lionel Messi', 'Cristiano Ronaldo', 'Diego Maradona', 'Pelé', 'Lionel Messi', 1),
    (2, '¿Cuál de los siguientes equipos ha ganado más veces la Liga de Campeones de la UEFA?', 'Barcelona', 'Real Madrid', 'Bayern Munich', 'AC Milan', 'Real Madrid', 1),
    (3, '¿Cuál de los siguientes países tiene la población más grande del mundo?', 'India', 'Estados Unidos', 'China', 'Brasil', 'China', 5),
    (4, '¿Cuál de las siguientes ciudades es la capital de Australia?', 'Sydney', 'Melbourne', 'Canberra', 'Perth', 'Canberra', 5),
    (5, '¿En qué año se firmó la Declaración de Independencia de los Estados Unidos?', '1789', '1812', '1865', '1776', '1776', 3),
    (6, '¿Quién fue el líder de la Revolución Rusa en 1917?', 'Joseph Stalin', 'Vladimir Lenin', 'Leon Trotsky', 'Nikita Khrushchev', 'Vladimir Lenin', 3),
    (7, '¿Cuál es el proceso mediante el cual las plantas convierten la luz solar en energía química?', 'Fotosíntesis', 'Respiración celular', 'Fermentación', 'Transpiración', 'Fotosíntesis', 2),
    (8, '¿Cuál es la ley de la física que establece que la energía no puede ser creada ni destruida, solo transformada de una forma a otra?', 'Ley de Ohm', 'Ley de Newton', 'Ley de la Conservación de la Energía', 'Ley de la Gravitación Universal', 'Ley de la Conservación de la Energía', 2);