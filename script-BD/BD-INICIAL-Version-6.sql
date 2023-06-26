CREATE DATABASE IF NOT EXISTS preguntear;
USE preguntear;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `categoria_preguntas` (
`idCategoria` int(11) NOT NULL,
`descripcion` varchar(50) NOT NULL,
`color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `categoria_preguntas` (`idCategoria`, `descripcion`, `color`) VALUES
(1, 'Deportes', '#ec4899'),
(2, 'Ciencia', '#4868D9'),
(3, 'Historia', '#24BE87'),
(4, 'Arte', '#C9D844'),
(5, 'Geografia', '#D98E48'),
(6, 'Tecnologia', '#2C39AE'),
(7, 'Entretenimiento', '#A88755'),
(8, 'Programacion', '#A62999');


CREATE TABLE `dificultad` (
`idDificultad` int(11) NOT NULL,
`descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `dificultad` (`idDificultad`, `descripcion`) VALUES
(1, 'FÁCIL'),
(2, 'MEDIA'),
(3, 'DIFÍCIL');


CREATE TABLE `estadisticas_jugadores` (
`idEstadistica` int(11) NOT NULL,
`idUsuario` int(11) NOT NULL,
`idPartida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `estadisticas_jugadores` (`idEstadistica`, `idUsuario`, `idPartida`) VALUES (1, 1, 1);


CREATE TABLE `estado_pregunta` (
`idEstadoPregunta` int(11) NOT NULL,
`descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `estado_pregunta` (`idEstadoPregunta`, `descripcion`) VALUES
(1, 'ACEPTADA'),
(2, 'RECHAZADA'),
(3, 'PARA REVISAR'),
(4, 'ANULADA'),
(5, 'REPORTADA');

CREATE TABLE `partida` (
`idPartida` int(11) NOT NULL,
`idUsuario` int(11) NOT NULL,
`puntaje` int(11) NOT NULL,
`cantidadDeRespuestasAcertadas` int(11) NOT NULL,
`duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `partida` ADD `fechaPartida` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `duracion`;


INSERT INTO `partida` (`idPartida`, `idUsuario`, `puntaje`, `cantidadDeRespuestasAcertadas`, `duracion`) VALUES
(1, 1, 40, 15, 500),
(2, 6, 15, 3, 27129),
(3, 6, 5, 1, 7000);


CREATE TABLE `pregunta` (
`idPregunta` int(11) NOT NULL,
`pregunta` varchar(255) NOT NULL,
`idDificultad` int(11) NOT NULL,
`idCategoria` int(11) NOT NULL,
`idUsuario` int(11) DEFAULT NULL,
`idRespuesta` int(11) NOT NULL,
`idEstadoPregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `pregunta` ADD `fechaPregunta` DATE NULL DEFAULT CURRENT_TIMESTAMP AFTER `idEstadoPregunta`;


INSERT INTO `pregunta` (`idPregunta`, `pregunta`, `idDificultad`, `idCategoria`, `idUsuario`, `idRespuesta`, `idEstadoPregunta`) VALUES
(1, '¿Quienes son los tenistas con más títulos de Grand Slam en la historia del tenis masculino?', 2, 1, 1, 1, 5),
(2, '¿Quién ganó la Copa del Mundo de Fútbol en 2022?', 1, 1, 1, 2, 1),
(3, '¿Quién tiene el récord de más medallas de oro olímpicas en la historia de los Juegos Olímpicos?', 2, 1, 3, 3, 1),
(4, '¿Cuál de los siguientes planetas del sistema solar es conocido como el planeta rojo?', 1, 2, 4, 4, 1),
(5, '¿Cuál de las siguientes partículas subatómicas tiene una carga eléctrica negativa?', 3, 2, 5, 5, 1),
(6, '¿Cuál de las siguientes enfermedades se caracteriza por la inflamación de las articulaciones?', 2, 2, 5, 6, 1),
(7, '¿Cuál de los siguientes líderes no estuvo involucrado en la Segunda Guerra Mundial?', 2, 3, 4, 7, 1),
(8, '¿Cuál de las siguientes civilizaciones fue conocida por construir las pirámides de Giza?', 2, 3, 4, 8, 1),
(9, '¿Quién fue el primer presidente de Estados Unidos?', 1, 3, 2, 9, 1),
(10, '¿Quién pintó la famosa obra \"La última cena\"?', 3, 4, 3, 10, 1),
(11, '¿Cuál de los siguientes compositores es conocido por su obra \"La Quinta Sinfonía\"?', 2, 4, 3, 11, 1),
(12, '¿Cuál de las siguientes esculturas famosas se encuentra en Río de Janeiro, Brasil?', 1, 4, 3, 12, 1),
(13, '¿Cuál de los siguientes países no forma parte de la península ibérica?', 2, 5, 3, 13, 1),
(14, '¿Cuál es el río más largo del mundo?', 3, 5, 3, 14, 1),
(15, '¿Cuál de los siguientes países se encuentra en Europa y Asia?', 1, 5, 2, 15, 1),
(16, '¿Cuál de las siguientes compañías es conocida por desarrollar el sistema operativo iOS?', 1, 6, 1, 16, 1),
(17, '¿Qué siglas representan la tecnología inalámbrica utilizada para conectar dispositivos a corta distancia?', 3, 6, 1, 17, 1),
(18, '¿Cuál de las siguientes redes sociales es conocida por compartir fotos y videos de corta duración?', 1, 6, 1, 18, 1),
(19, '¿Quién interpretó el papel de Iron Man en el Universo Cinematográfico de Marvel?', 1, 7, 1, 19, 1),
(20, '¿Cuál de las siguientes bandas de rock es conocida por su álbum \"Stairway to Heaven\"?', 2, 7, 3, 20, 1),
(21, '¿Cuál de las siguientes películas ganó el Premio de la Academia a la Mejor Película en el año 2020?', 3, 7, 3, 21, 1),
(22, '¿Qué lenguaje de programación se utiliza principalmente para desarrollar aplicaciones móviles en el sistema operativo Android?', 1, 8, 3, 22, 1),
(23, '¿Cuál de los siguientes conceptos de programación se refiere a la reutilización de código mediante la creación de plantillas predefinidas?', 3, 8, 2, 23, 1),
(24, '¿Cuál de las siguientes opciones es un sistema de control de versiones ampliamente utilizado en el desarrollo de software?', 2, 8, 1, 24, 1),
(25, '¿Cuál es el deporte que se juega en un campo rectangular dividido en dos mitades, y los equipos intentan llevar un balón ovalado hacia la zona de anotación del equipo contrario?', 2, 1, 1, 25, 1),
(26, '¿Qué deporte se juega golpeando una pelota con un palo en un campo con hoyos y se busca introducir la pelota en los hoyos con la menor cantidad de golpes posibles?', 1, 1, 1, 26, 1),
(27, '¿Cuál es el deporte más popular en Canadá?', 1, 1, 1, 27, 1),
(28, '¿Cuál es el evento deportivo más visto en el mundo?', 1, 1, 1, 28, 1),
(29, '¿Cuál es el país de origen del taekwondo?', 1, 1, 1, 29, 1),
(30, '¿Cuál es la unidad básica de la estructura de los seres vivos?', 1, 1, 1, 30, 1),
(31, '¿Cuál es el elemento químico más abundante en la Tierra?', 1, 1, 1, 31, 1),
(32, '¿Cuál es la partícula subatómica con carga positiva?', 1, 1, 1, 32, 1),
(33, '¿Cuál es la principal función del ADN en los seres vivos?', 1, 1, 1, 33, 1),
(34, '¿Cuál es la capa más externa de la Tierra?', 1, 1, 1, 34, 1),
(35, '¿En qué año comenzó la Primera Guerra Mundial?', 1, 1, 1, 35, 1),
(36, '¿Cuál fue el imperio más extenso de la historia?', 1, 1, 1, 36, 1),
(37, '¿Cuál fue el primer país en enviar un ser humano al espacio?', 1, 1, 1, 37, 1),
(38, '¿En qué año se firmó la Declaración de Independencia de Estados Unidos?', 1, 1, 1, 38, 1),
(39, '¿Quién fue el líder de la Revolución Rusa en 1917?', 1, 1, 1, 39, 1),
(40, '¿Quién pintó la famosa obra \"La Gioconda\"?', 1, 1, 1, 40, 1),
(41, '¿Cuál de los siguientes compositores es conocido por su obra \"La Novena Sinfonía\"?', 1, 1, 1, 41, 1),
(42, '¿Cuál de las siguientes esculturas famosas se encuentra en Atenas, Grecia?', 1, 1, 1, 42, 1),
(43, '¿Quién escribió la obra de teatro \"Romeo y Julieta\"?', 1, 1, 1, 43, 1),
(44, '¿Cuál de los siguientes países es el más grande del mundo por superficie?', 1, 1, 1, 44, 1),
(45, '¿Cuál es la cadena montañosa más larga del mundo?', 1, 1, 1, 45, 1),
(46, '¿Cuál es el océano más grande del mundo?', 1, 1, 1, 46, 1),
(47, '¿Cuál es el país más poblado del mundo?', 1, 1, 1, 47, 1),
(48, '¿Cuál de los siguientes ríos no pasa por América del Sur?', 1, 1, 1, 48, 1),
(49, '¿Cuál de las siguientes compañías es conocida por desarrollar el sistema operativo Windows?', 1, 1, 1, 49, 1),
(50, '¿Cuál de las siguientes tecnologías se utiliza para almacenar datos en discos de estado sólido (SSD)?', 1, 1, 1, 50, 3),
(51, '¿Cuál de los siguientes dispositivos se utiliza para almacenar información de forma permanente en una computadora?', 1, 1, 1, 51, 1),
(52, '¿Cuál de las siguientes tecnologías es utilizada para almacenar datos de forma permanente en discos magnéticos?', 1, 1, 1, 52, 1),
(53, '¿Cuál de las siguientes tecnologías se utiliza para la transmisión de datos a través de cables de cobre en redes de área local (LAN)?', 1, 1, 1, 53, 1),
(54, '¿Quién interpretó el papel de Harry Potter en las películas de la saga?', 1, 1, 1, 54, 1),
(55, '¿Cuál de las siguientes bandas de rock es conocida por su canción \"Bohemian Rhapsody\"?', 1, 1, 1, 55, 1),
(56, '¿Cuál de las siguientes películas ganó el Premio de la Academia a la Mejor Película en el año 2019?', 1, 1, 1, 56, 1),
(57, '¿Cuál de las siguientes actrices interpretó el papel de Katniss Everdeen en la saga de películas \"Los juegos del hambre\"?', 1, 1, 1, 57, 1),
(58, '¿Cuál de los siguientes conceptos de programación se refiere a la reutilización de código mediante la creación de plantillas predefinidas?', 1, 1, 1, 58, 1),
(59, '¿Cuál de los siguientes lenguajes de programación se utiliza para desarrollar páginas web interactivas?', 1, 1, 1, 59, 1),
(60, '¿Cuál de los siguientes términos se refiere a un error en un programa que hace que no funcione correctamente?', 1, 1, 1, 60, 1),
(61, '¿Cuál de los siguientes lenguajes de programación es ampliamente utilizado para el desarrollo de aplicaciones móviles en el sistema operativo iOS?', 1, 1, 1, 61, 1),
(62, '¿Qué concepto de programación se utiliza para describir un conjunto de instrucciones que se ejecutan en secuencia para resolver un problema específico?', 1, 1, 1, 62, 1),
(63, 'Pregunta sugerida de historia??', 1, 3, 6, 65, 3);


CREATE TABLE `pregunta_respondida` (
`idPreguntaRespondida` int(11) NOT NULL,
`idPregunta` int(11) NOT NULL,
`idUsuario` int(11) NOT NULL,
`fueCorrecta` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `pregunta_respondida` (`idPreguntaRespondida`, `idPregunta`, `idUsuario`, `fueCorrecta`) VALUES
(1, 2, 1, 0),
(2, 15, 6, 1),
(3, 12, 6, 1),
(4, 18, 6, 1),
(5, 8, 6, 0),
(6, 23, 6, 1),
(7, 19, 6, 0);


CREATE TABLE `ranking` (
`idRanking` int(11) NOT NULL,
`puntaje` int(11) NOT NULL,
`puesto` int(11) NOT NULL,
`idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ranking` (`idRanking`, `puntaje`, `puesto`, `idUsuario`) VALUES (1, 100, 1, 1);


CREATE TABLE `reporte` (
`idReporte` int(11) NOT NULL,
`idPregunta` int(11) NOT NULL,
`comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `reporte` (`idReporte`, `idPregunta`, `comentario`) VALUES
(1, 1, 'Ahora es Novak Djokovic solo'),
(2, 1, 'Ahora es Djokovic'),
(3, 1, 'Esta desactualizada'),
(4, 23, 'Pregunta reportada');


CREATE TABLE `respuesta` (
`idRespuesta` int(11) NOT NULL,
`respuestaA` varchar(100) DEFAULT NULL,
`respuestaB` varchar(100) DEFAULT NULL,
`respuestaC` varchar(100) DEFAULT NULL,
`respuestaD` varchar(100) DEFAULT NULL,
`respuestaCorrecta` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `respuesta` (`idRespuesta`, `respuestaA`, `respuestaB`, `respuestaC`, `respuestaD`, `respuestaCorrecta`) VALUES
(1, 'Pete Sampras y Roger Federer', 'Roger Federer y Novak Djokovic', 'Jimmy Connors y Andre Agassi', 'Rafa Nadal y Novak Djokovic', 'Rafa Nadal y Novak Djokovic'),
(2, 'Alemania', 'Francia', 'Italia', 'Argentina', 'Argentina'),
(3, 'Michael Phelps', 'Usain Bolt', 'Simone Biles', 'Carl Lewis', 'Michael Phelps'),
(4, 'Júpiter', 'Venus', 'Marte', 'Urano', 'Marte'),
(5, 'Protón', 'Neutrón', 'Electrón', 'Positrón', 'Electrón'),
(6, 'Diabetes', 'Asma', 'Artritis', 'Anemia', 'Artritis'),
(7, 'Winston Churchill', 'Joseph Stalin', 'Franklin D. Roosevelt', 'Adolf Hitler', 'Winston Churchill'),
(8, 'Mayas', 'Romanos', 'Egipcios', 'Persas', 'Egipcios'),
(9, 'Abraham Lincoln', 'George Washington', 'Thomas Jefferson', 'John F. Kennedy', 'George Washington'),
(10, 'Pablo Picasso', 'Vincent van Gogh', 'Leonardo Da Vinci', 'Claude Monet', 'Leonardo Da Vinci'),
(11, 'Wolfgang Amadeus Mozart', 'Ludwig van Beethoven', 'Johann Sebastian Bach', 'Frédéric Chopin', 'Ludwig van Beethoven'),
(12, 'La Venus de Milo', 'El David', 'El Pensador', 'El Cristo Redentor', 'El Cristo Redentor'),
(13, 'España', 'Portugal', 'Francia', 'Andorra', 'Francia'),
(14, 'Nilo', 'Amazonas', 'Misisipi', 'Yangsté', 'Amazonas'),
(15, 'México', 'Sudáfrica', 'Australia', 'Rusia', 'Rusia'),
(16, 'Microsoft', 'Apple', 'Google', 'Samsung', 'Apple'),
(17, 'USB', 'HDMI', 'NFC', 'LTE', 'NFC'),
(18, 'Facebook', 'Instagram', 'Twitter', 'Linkedin', 'Instagram'),
(19, 'Chris Hemsworth', 'Chris Evans', 'Tom Holland', 'Robert Downey Jr.', 'Robert Downey Jr.'),
(20, 'The Rolling Stones', 'Led Zeppelin', 'AC/DC', 'Queen', 'Led Zeppelin'),
(21, 'Joker', 'Parasite', '1917', 'The Shape of Water', 'Parasite'),
(22, 'Swift', 'Kotlin', 'C#', 'Python', 'Kotlin'),
(23, 'Herencia', 'Polimorfismo', 'Encapsulamiento', 'Abstracción', 'Herencia'),
(24, 'Git', 'SVN', 'Mercurial', 'CVS', 'Rugby'),
(25, 'Fútbol', 'Baloncesto', 'Rugby', 'Voleibol', 'Rugby'),
(26, 'Golf', 'Hockey', 'Cricket', 'Polo', 'Golf'),
(27, 'Hockey sobre hielo', 'Fútbol', 'Béisbol', 'Baloncesto', 'Hockey sobre hielo'),
(28, 'Juegos Olímpicos', 'Copa Mundial de Fútbol', 'Super Bowl', 'Tour de Francia', 'Copa Mundial de Fútbol'),
(29, 'Corea del Sur', 'China', 'Japón', 'Tailandia', 'Célula'),
(30, 'Célula', 'Átomo', 'Molécula', 'Organismo', 'Célula'),
(31, 'Oxígeno', 'Hidrógeno', 'Carbono', 'Hierro', 'Oxígeno'),
(32, 'Protón', 'Electrón', 'Neutrón', 'Fotón', 'Protón'),
(33, 'Producir energía', 'Transportar oxígeno', 'Regular el metabolismo', 'Almacenar información genética', 'Almacenar información genética'),
(34, 'Corteza', 'Núcleo', 'Manto', 'Astenosfera', 'Corteza'),
(35, '1939', '1918', '1914', '1945', '1914'),
(36, 'Imperio romano', 'Imperio mongol', 'Imperio británico', 'Imperio otomano', 'Imperio mongol'),
(37, 'Estados Unidos', 'Rusia (Unión Soviética)', 'China', 'Reino Unido', 'Rusia (Unión Soviética)'),
(38, '1865', '1789', '1812', '1776', '1776'),
(39, 'Vladimir Lenin', 'Joseph Stalin', 'Leon Trotsky', 'Karl Marx', 'Vladimir Lenin'),
(40, 'Pablo Picasso', 'Leonardo da Vinci', 'Vincent van Gogh', 'Michelangelo Buonarroti', 'Leonardo da Vinci'),
(41, '\"Don Quijote de la Mancha\"', '\"Cien años de soledad\"', '\"Moby-Dick\"', '\"Ulises\"', '\"Don Quijote de la Mancha\"'),
(42, 'Ludwig van Beethoven', 'Johann Sebastian Bach', 'Wolfgang Amadeus Mozart', 'Franz Schubert', 'Ludwig van Beethoven'),
(43, 'La Venus de Milo', 'El David', 'La Estatua de la Libertad', 'El Partenón', 'El Partenón'),
(44, 'Anton Chejov', 'Federico García Lorca', 'William Shakespeare', 'Tennessee Williams', 'William Shakespeare'),
(45, 'Rusia', 'Canadá', 'China', 'Estados Unidos', 'Rusia'),
(46, 'Los Andes', 'Los Alpes', 'El Himalaya', 'Las Montañas Rocosas', 'Los Andes'),
(47, 'Océano Atlántico', 'Océano Pacífico', 'Océano Índico', 'Océano Ártico', 'Océano Pacífico'),
(48, 'China', 'India', 'Estados Unidos', 'Brasil', 'India'),
(49, 'Amazonas', 'Misisipi', 'Orinoco', 'Paraná', 'Misisipi'),
(50, 'Microsoft', 'Apple', 'Google', 'IBM', 'Microsoft'),
(51, 'Magnetismo', 'Láser', 'Electricidad estática', 'Memoria flash', 'Memoria flash'),
(52, 'Disco duro', 'Memoria RAM', 'Procesador', 'Tarjeta gráfica', 'Disco duro'),
(53, 'HDD', 'SSD', 'USB', 'RAM', 'HDD'),
(54, 'Ethernet', 'Bluetooth', 'Wi-Fi', '4G', 'Ethernet'),
(55, 'Daniel Radcliffe', 'Rupert Grint', 'Emma Watson', 'Tom Felton', 'Daniel Radcliffe'),
(56, 'Queen', 'The Beatles', 'Rolling Stones', 'U2', 'Queen'),
(57, 'Parasite', 'Joker', '1917', 'Once Upon a Time in Hollywood', 'Parasite'),
(58, 'Game of Thrones', 'Breaking Bad', 'Stranger Things', 'The Walking Dead', 'Game of Thrones'),
(59, 'Jennifer Lawrence', 'Emma Stone', 'Scarlett Johansson', 'Kristen Stewart', 'Jennifer Lawrence'),
(60, 'Programación orientada a objetos', 'Programación funcional', 'Programación estructurada', 'Programación modular', 'Programación orientada a objetos'),
(61, 'JavaScript', 'HTML', 'CSS', 'PHP', 'JavaScript'),
(62, 'Bug', 'Feature', 'Patch', 'Release', 'Bug'),
(63, 'Java', 'Swift', 'Python', 'C++', 'Swift'),
(64, 'Algoritmo', 'Variable', 'Función', 'Clase', 'Algoritmo'),
(65, 'Incorrecta primera', 'La correcta', 'Incorrecta segunda', 'Incorrecta tercera', 'La correcta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
                       `idRol` int(11) NOT NULL,
                       `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `rol` (`idRol`, `descripcion`) VALUES
(1, 'Jugador'),
(2, 'Editor'),
(3, 'Admin'),
(4, 'NoValidado');


CREATE TABLE `usuario` (
`idUsuario` int(11) NOT NULL,
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
`longitud` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `usuario` ADD `fechaUsuario` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `idRol`;


INSERT INTO `usuario` (`idUsuario`, `nombreCompleto`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `mail`, `nombreDeUsuario`, `contrasenia`, `fotoDePerfil`, `idRol`, `latitud`, `longitud`)
VALUES
(1, 'Juan Ignacio', '2004-06-01', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'joliva@mail.com', 'joliva', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.jpg', 1, ' -34.629261', '-63.432884'),
(2, 'Nicolas Villafañe', '2003-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'nvilla@mail.com', 'nvilla', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1, ' -34.629261', '-63.432884'),
(3, 'Mariano Soto', '2002-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'msoto@mail.com', 'msoto', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 1, ' -34.629261', '-63.432884'),
(4, 'Cristian Medina', '2001-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'cmedina@mail.com', 'cmedina', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 2, '-34.629261', '-63.432884'),
(5, 'Sebastian Tarifa', '2000-05-18', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'starifa@mail.com', 'starifa', 'efc91020c448e85a70aae9c2b9c8b8be', 'public/image/perfil.png', 3, '-34.629261', '-63.432884'),
(6, 'Prueba Test', '2023-05-11', 'Masculino', 'Argentina', 'Provincia de Buenos Aires', 'juoliva95@gmail.com', 'juoliva95', '7d697a1fb0f9a64435a0bf60eaf2ff00', 'public/image/juoliva95.png', 1, '-36.13400074926003', '-61.41139962500001');


CREATE TABLE `validaciones` (
`idValidacion` int(11) NOT NULL,
`codigo` varchar(255) NOT NULL,
`idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `partida_home` (
`idHome` int(11) NOT NULL,
`pregunta` varchar(200) NOT NULL,
`respuestaA` varchar(100) NOT NULL,
`respuestaB` varchar(100) NOT NULL,
`respuestaC` varchar(100) NOT NULL,
`respuestaD` varchar(100) NOT NULL,
`respuestaCorrecta` varchar(100) NOT NULL,
`idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `partida_home` (`idHome`, `pregunta`, `respuestaA`, `respuestaB`, `respuestaC`, `respuestaD`, `respuestaCorrecta`, `idCategoria`) VALUES
(1, '¿Qué jugador ha ganado el premio FIFA Balón de Oro más veces en la historia?', 'Lionel Messi', 'Cristiano Ronaldo', 'Diego Maradona', 'Pelé', 'Lionel Messi', 1),
(2, '¿Cuál de los siguientes equipos ha ganado más veces la Liga de Campeones de la UEFA?', 'Barcelona', 'Real Madrid', 'Bayern Munich', 'AC Milan', 'Real Madrid', 1),
(3, '¿Cuál de los siguientes países tiene la población más grande del mundo?', 'India', 'Estados Unidos', 'China', 'Brasil', 'China', 5),
(4, '¿Cuál de las siguientes ciudades es la capital de Australia?', 'Sydney', 'Melbourne', 'Canberra', 'Perth', 'Canberra', 5),
(5, '¿En qué año se firmó la Declaración de Independencia de los Estados Unidos?', '1789', '1812', '1865', '1776', '1776', 3),
(6, '¿Quién fue el líder de la Revolución Rusa en 1917?', 'Joseph Stalin', 'Vladimir Lenin', 'Leon Trotsky', 'Nikita Khrushchev', 'Vladimir Lenin', 3),
(7, '¿Cuál es el proceso mediante el cual las plantas convierten la luz solar en energía química?', 'Fotosíntesis', 'Respiración celular', 'Fermentación', 'Transpiración', 'Fotosíntesis', 2),
(8, '¿Cuál es la ley de la física que establece que la energía no puede ser creada ni destruida, solo transformada de una forma a otra?', 'Ley de Ohm', 'Ley de Newton', 'Ley de la Conservación de la Energía', 'Ley de la Gravitación Universal', 'Ley de la Conservación de la Energía', 2);


ALTER TABLE `categoria_preguntas`
    ADD PRIMARY KEY (`idCategoria`);

ALTER TABLE `dificultad`
    ADD PRIMARY KEY (`idDificultad`);

ALTER TABLE `estadisticas_jugadores`
    ADD PRIMARY KEY (`idEstadistica`),
    ADD KEY `idUsuario` (`idUsuario`),
    ADD KEY `idPartida` (`idPartida`);

ALTER TABLE `estado_pregunta`
    ADD PRIMARY KEY (`idEstadoPregunta`);

ALTER TABLE `partida`
    ADD PRIMARY KEY (`idPartida`),
    ADD KEY `idUsuario` (`idUsuario`);


ALTER TABLE `pregunta`
    ADD PRIMARY KEY (`idPregunta`),
    ADD KEY `idDificultad` (`idDificultad`),
    ADD KEY `idCategoria` (`idCategoria`),
    ADD KEY `idUsuario` (`idUsuario`),
    ADD KEY `idRespuesta` (`idRespuesta`),
    ADD KEY `idEstadoPregunta` (`idEstadoPregunta`);



ALTER TABLE `pregunta_respondida`
    ADD PRIMARY KEY (`idPreguntaRespondida`),
    ADD KEY `idPregunta` (`idPregunta`),
    ADD KEY `idUsuario` (`idUsuario`);

ALTER TABLE `ranking`
    ADD PRIMARY KEY (`idRanking`),
    ADD KEY `idUsuario` (`idUsuario`);

ALTER TABLE `reporte`
    ADD PRIMARY KEY (`idReporte`),
    ADD KEY `idPregunta` (`idPregunta`);

ALTER TABLE `respuesta`
    ADD PRIMARY KEY (`idRespuesta`);

ALTER TABLE `rol`
    ADD PRIMARY KEY (`idRol`);

ALTER TABLE `usuario`
    ADD PRIMARY KEY (`idUsuario`),
    ADD KEY `idRol` (`idRol`);

ALTER TABLE `validaciones`
    ADD PRIMARY KEY (`idValidacion`),
    ADD KEY `idUsuario` (`idUsuario`);

ALTER TABLE `partida_home`
    ADD PRIMARY KEY (`idHome`),
    ADD KEY `idCategoria` (`idCategoria`);

ALTER TABLE `categoria_preguntas`
    MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `dificultad`
    MODIFY `idDificultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `estadisticas_jugadores`
    MODIFY `idEstadistica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `estado_pregunta`
    MODIFY `idEstadoPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


ALTER TABLE `partida`
    MODIFY `idPartida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `pregunta`
    MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;


ALTER TABLE `pregunta_respondida`
    MODIFY `idPreguntaRespondida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `ranking`
    MODIFY `idRanking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `reporte`
    MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `respuesta`
    MODIFY `idRespuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;


ALTER TABLE `rol`
    MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `usuario`
    MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `validaciones`
    MODIFY `idValidacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `partida_home`
    MODIFY `idHome` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;



ALTER TABLE `estadisticas_jugadores`
    ADD CONSTRAINT `estadisticas_jugadores_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
    ADD CONSTRAINT `estadisticas_jugadores_ibfk_2` FOREIGN KEY (`idPartida`) REFERENCES `partida` (`idPartida`);

ALTER TABLE `partida`
    ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);


ALTER TABLE `pregunta`
    ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`idDificultad`) REFERENCES `dificultad` (`idDificultad`),
    ADD CONSTRAINT `pregunta_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria_preguntas` (`idCategoria`),
    ADD CONSTRAINT `pregunta_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
    ADD CONSTRAINT `pregunta_ibfk_4` FOREIGN KEY (`idRespuesta`) REFERENCES `respuesta` (`idRespuesta`),
    ADD CONSTRAINT `pregunta_ibfk_5` FOREIGN KEY (`idEstadoPregunta`) REFERENCES `estado_pregunta` (`idEstadoPregunta`);


ALTER TABLE `pregunta_respondida`
    ADD CONSTRAINT `pregunta_respondida_ibfk_1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`),
    ADD CONSTRAINT `pregunta_respondida_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);


ALTER TABLE `ranking`
    ADD CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

ALTER TABLE `reporte`
    ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`idPregunta`) REFERENCES `pregunta` (`idPregunta`);


ALTER TABLE `usuario`
    ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`);


ALTER TABLE `validaciones`
    ADD CONSTRAINT `validaciones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);


ALTER TABLE `partida_home`
    ADD CONSTRAINT `partida_home_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria_preguntas` (`idCategoria`);
COMMIT;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
