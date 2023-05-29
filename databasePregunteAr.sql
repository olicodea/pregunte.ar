USE [master]
GO
/****** Object:  Database [Pregunte.ar]    Script Date: 24/05/2023 11:11:26 ******/
CREATE DATABASE [Pregunte.ar]
 CONTAINMENT = NONE
 ON  PRIMARY
( NAME = N'Pregunte.ar', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER01\MSSQL\DATA\Pregunte.ar.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON
( NAME = N'Pregunte.ar_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER01\MSSQL\DATA\Pregunte.ar_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [Pregunte.ar] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [Pregunte.ar].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [Pregunte.ar] SET ANSI_NULL_DEFAULT OFF
GO
ALTER DATABASE [Pregunte.ar] SET ANSI_NULLS OFF
GO
ALTER DATABASE [Pregunte.ar] SET ANSI_PADDING OFF
GO
ALTER DATABASE [Pregunte.ar] SET ANSI_WARNINGS OFF
GO
ALTER DATABASE [Pregunte.ar] SET ARITHABORT OFF
GO
ALTER DATABASE [Pregunte.ar] SET AUTO_CLOSE OFF
GO
ALTER DATABASE [Pregunte.ar] SET AUTO_SHRINK OFF
GO
ALTER DATABASE [Pregunte.ar] SET AUTO_UPDATE_STATISTICS ON
GO
ALTER DATABASE [Pregunte.ar] SET CURSOR_CLOSE_ON_COMMIT OFF
GO
ALTER DATABASE [Pregunte.ar] SET CURSOR_DEFAULT  GLOBAL
GO
ALTER DATABASE [Pregunte.ar] SET CONCAT_NULL_YIELDS_NULL OFF
GO
ALTER DATABASE [Pregunte.ar] SET NUMERIC_ROUNDABORT OFF
GO
ALTER DATABASE [Pregunte.ar] SET QUOTED_IDENTIFIER OFF
GO
ALTER DATABASE [Pregunte.ar] SET RECURSIVE_TRIGGERS OFF
GO
ALTER DATABASE [Pregunte.ar] SET  DISABLE_BROKER
GO
ALTER DATABASE [Pregunte.ar] SET AUTO_UPDATE_STATISTICS_ASYNC OFF
GO
ALTER DATABASE [Pregunte.ar] SET DATE_CORRELATION_OPTIMIZATION OFF
GO
ALTER DATABASE [Pregunte.ar] SET TRUSTWORTHY OFF
GO
ALTER DATABASE [Pregunte.ar] SET ALLOW_SNAPSHOT_ISOLATION OFF
GO
ALTER DATABASE [Pregunte.ar] SET PARAMETERIZATION SIMPLE
GO
ALTER DATABASE [Pregunte.ar] SET READ_COMMITTED_SNAPSHOT OFF
GO
ALTER DATABASE [Pregunte.ar] SET HONOR_BROKER_PRIORITY OFF
GO
ALTER DATABASE [Pregunte.ar] SET RECOVERY FULL
GO
ALTER DATABASE [Pregunte.ar] SET  MULTI_USER
GO
ALTER DATABASE [Pregunte.ar] SET PAGE_VERIFY CHECKSUM
GO
ALTER DATABASE [Pregunte.ar] SET DB_CHAINING OFF
GO
ALTER DATABASE [Pregunte.ar] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF )
GO
ALTER DATABASE [Pregunte.ar] SET TARGET_RECOVERY_TIME = 60 SECONDS
GO
ALTER DATABASE [Pregunte.ar] SET DELAYED_DURABILITY = DISABLED
GO
ALTER DATABASE [Pregunte.ar] SET ACCELERATED_DATABASE_RECOVERY = OFF
GO
EXEC sys.sp_db_vardecimal_storage_format N'Pregunte.ar', N'ON'
GO
ALTER DATABASE [Pregunte.ar] SET QUERY_STORE = OFF
GO
USE [Pregunte.ar]
GO
/****** Object:  Table [dbo].[Categoria_Preguntas]    Script Date: 24/05/2023 11:11:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Categoria_Preguntas](
    [idCategoria] [int] NOT NULL,
    [descipcion] [varchar](50) NOT NULL,
    [color] [varchar](50) NOT NULL,
    CONSTRAINT [PK_Categoria_Preguntas] PRIMARY KEY CLUSTERED
(
[idCategoria] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Dificultad]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Dificultad](
    [idDificultad] [int] NOT NULL,
    [descripcion] [varchar](50) NOT NULL,
    CONSTRAINT [PK_Dificultad] PRIMARY KEY CLUSTERED
(
[idDificultad] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Estado_Pregunta]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Estado_Pregunta](
    [idEstado] [int] NOT NULL,
    [idPregunta] [int] NOT NULL,
    [descripcion] [varchar](50) NOT NULL,
    CONSTRAINT [PK_Estado_Pregunta] PRIMARY KEY CLUSTERED
(
[idEstado] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Partida]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Partida](
    [idPartida] [int] NOT NULL,
    [idUsuario] [int] NOT NULL,
    [puntaje] [int] NOT NULL,
    [idPregunta] [int] NOT NULL,
    [cantidadDeRespuestasAcertadas] [int] NOT NULL,
    [duracion] [datetime] NOT NULL,
     CONSTRAINT [PK_Partida] PRIMARY KEY CLUSTERED
    (
[idPartida] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Pregunta]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Pregunta](
    [idPregunta] [int] NOT NULL,
    [pregunta] [varchar](100) NULL,
    [idDificultad] [int] NOT NULL,
    [idCategoria] [int] NOT NULL,
    [idUsuario] [int] NOT NULL,
    [idRespuesta] [int] NOT NULL,
    CONSTRAINT [PK_Pregunta] PRIMARY KEY CLUSTERED
(
[idPregunta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Pregunta_Respondida]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Pregunta_Respondida](
    [idPreguntaRespondida] [int] NOT NULL,
    [idPregunta] [int] NOT NULL,
    [idUsuario] [int] NOT NULL,
     CONSTRAINT [PK_Pregunta_Respondida] PRIMARY KEY CLUSTERED
    (
[idPreguntaRespondida] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Ranking]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Ranking](
    [idRanking] [int] NOT NULL,
    [puntaje] [int] NOT NULL,
    [idUsuario] [int] NOT NULL,
    [idPartida] [int] NOT NULL,
     CONSTRAINT [PK_Ranking] PRIMARY KEY CLUSTERED
    (
[idRanking] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Respuesta]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Respuesta](
    [idRespuesta] [int] NOT NULL,
    [respuestaA] [varchar](100) NULL,
    [respuestaB] [varchar](100) NULL,
    [respuestaC] [varchar](100) NULL,
    [respuestaD] [varchar](100) NULL,
    [respuestaCorrecta] [bit] NULL,
    CONSTRAINT [PK_Respuesta] PRIMARY KEY CLUSTERED
(
[idRespuesta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Roles]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE [dbo].[Roles](
    [idRol] [int] NOT NULL,
    [descripcion] [varchar](50) NOT NULL,
    CONSTRAINT [PK_Roles] PRIMARY KEY CLUSTERED
(
[idRol] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY]
    GO
/****** Object:  Table [dbo].[Usuario]    Script Date: 24/05/2023 11:11:26 ******/
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
CREATE TABLE dbo.Usuario(
    idUsuario int NOT NULL,
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL,
    fechaDeNacimiento date NOT NULL,
    genero varchar(50) NOT NULL,
    pais varchar(50) NOT NULL,
    ciudad varchar(50) NOT NULL,
    mail varchar(50) NOT NULL,
    nombreDeUsuario varchar(50) NOT NULL,
    contraseña varchar(50) NOT NULL,
    fotoDePerfil image NOT NULL,
    idRol int NOT NULL,
    CONSTRAINT [PK_Usuario] PRIMARY KEY CLUSTERED
(
[idUsuario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
    ) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
    GO
ALTER TABLE [dbo].[Estado_Pregunta]  WITH CHECK ADD  CONSTRAINT [FK_Estado_Pregunta] FOREIGN KEY([idPregunta])
    REFERENCES [dbo].[Pregunta] ([idPregunta])
    GO
ALTER TABLE [dbo].[Estado_Pregunta] CHECK CONSTRAINT [FK_Estado_Pregunta]
    GO
ALTER TABLE [dbo].[Partida]  WITH CHECK ADD  CONSTRAINT [FK_Partida_Pregunta] FOREIGN KEY([idPregunta])
    REFERENCES [dbo].[Pregunta] ([idPregunta])
    GO
ALTER TABLE [dbo].[Partida] CHECK CONSTRAINT [FK_Partida_Pregunta]
    GO
ALTER TABLE [dbo].[Partida]  WITH CHECK ADD  CONSTRAINT [FK_Partida_Usuario] FOREIGN KEY([idUsuario])
    REFERENCES [dbo].[Usuario] ([idUsuario])
    GO
ALTER TABLE [dbo].[Partida] CHECK CONSTRAINT [FK_Partida_Usuario]
    GO
ALTER TABLE [dbo].[Pregunta]  WITH CHECK ADD  CONSTRAINT [FK_Pregunta_Respuesta] FOREIGN KEY([idRespuesta])
    REFERENCES [dbo].[Respuesta] ([idRespuesta])
    GO
ALTER TABLE [dbo].[Pregunta] CHECK CONSTRAINT [FK_Pregunta_Respuesta]
    GO
ALTER TABLE [dbo].[Pregunta]  WITH CHECK ADD  CONSTRAINT [FK_PreguntaCat] FOREIGN KEY([idCategoria])
    REFERENCES [dbo].[Categoria_Preguntas] ([idCategoria])
    GO
ALTER TABLE [dbo].[Pregunta] CHECK CONSTRAINT [FK_PreguntaCat]
    GO
ALTER TABLE [dbo].[Pregunta]  WITH CHECK ADD  CONSTRAINT [FK_PreguntaDif] FOREIGN KEY([idDificultad])
    REFERENCES [dbo].[Dificultad] ([idDificultad])
    GO
ALTER TABLE [dbo].[Pregunta] CHECK CONSTRAINT [FK_PreguntaDif]
    GO
ALTER TABLE [dbo].[Pregunta]  WITH CHECK ADD  CONSTRAINT [FK_Usuario_Pregunta] FOREIGN KEY([idUsuario])
    REFERENCES [dbo].[Usuario] ([idUsuario])
    GO
ALTER TABLE [dbo].[Pregunta] CHECK CONSTRAINT [FK_Usuario_Pregunta]
    GO
ALTER TABLE [dbo].[Pregunta_Respondida]  WITH CHECK ADD  CONSTRAINT [FK_PreguntaRespondida_Pregunta] FOREIGN KEY([idPregunta])
    REFERENCES [dbo].[Pregunta] ([idPregunta])
    GO
ALTER TABLE [dbo].[Pregunta_Respondida] CHECK CONSTRAINT [FK_PreguntaRespondida_Pregunta]
    GO
ALTER TABLE [dbo].[Pregunta_Respondida]  WITH CHECK ADD  CONSTRAINT [FK_PreguntaRespondida_Usuario] FOREIGN KEY([idUsuario])
    REFERENCES [dbo].[Usuario] ([idUsuario])
    GO
ALTER TABLE [dbo].[Pregunta_Respondida] CHECK CONSTRAINT [FK_PreguntaRespondida_Usuario]
    GO
ALTER TABLE [dbo].[Ranking]  WITH CHECK ADD  CONSTRAINT [FK_Ranking_Partida] FOREIGN KEY([idPartida])
    REFERENCES [dbo].[Partida] ([idPartida])
    GO
ALTER TABLE [dbo].[Ranking] CHECK CONSTRAINT [FK_Ranking_Partida]
    GO
ALTER TABLE [dbo].[Ranking]  WITH CHECK ADD  CONSTRAINT [FK_Ranking_Usuario] FOREIGN KEY([idUsuario])
    REFERENCES [dbo].[Usuario] ([idUsuario])
    GO
ALTER TABLE [dbo].[Ranking] CHECK CONSTRAINT [FK_Ranking_Usuario]
    GO
ALTER TABLE [dbo].[Usuario]  WITH CHECK ADD  CONSTRAINT [FK_Usuario_Roles] FOREIGN KEY([idRol])
    REFERENCES [dbo].[Roles] ([idRol])
    GO
ALTER TABLE [dbo].[Usuario] CHECK CONSTRAINT [FK_Usuario_Roles]
    GO
    USE [master]
    GO
ALTER DATABASE [Pregunte.ar] SET  READ_WRITE
GO