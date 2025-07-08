-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-07-2025 a las 15:24:01
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clubicl_facilcontrol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acreditaciones`
--

CREATE TABLE `acreditaciones` (
  `id_a` int(11) NOT NULL,
  `plan` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `acreditaciones` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `acreditaciones`
--

INSERT INTO `acreditaciones` (`id_a`, `plan`, `acreditaciones`, `costo`, `estado`) VALUES
(1, 'PLAN FREE', 5, 0, 0),
(2, 'PLAN 10', 10, 350, 0),
(3, 'PLAN 15', 15, 360, 0),
(4, 'PLAN 20', 20, 370, 0),
(5, 'PLAN 30', 30, 380, 0),
(6, 'PLAN 50', 50, 390, 0),
(7, 'PLAN 100', 100, 400, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `idafp` int(10) NOT NULL,
  `afp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`idafp`, `afp`) VALUES
(1, 'Capital'),
(2, 'Cuprum'),
(3, 'Hábitat'),
(4, 'Modelo'),
(5, 'Plan Vital'),
(6, 'Provida'),
(7, 'Uno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos`
--

CREATE TABLE `autos` (
  `id_auto` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `tipo` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `siglas` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `control` int(11) NOT NULL,
  `motor` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `chasis` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `patente` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `puestos` int(11) NOT NULL,
  `url_foto` text COLLATE utf8_unicode_ci NOT NULL,
  `revision` date NOT NULL,
  `propietario` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `rut_propietario` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `fono_propietario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email_propietario` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sin_patente` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos_asignados`
--

CREATE TABLE `autos_asignados` (
  `id_aa` int(11) NOT NULL,
  `vehiculo` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `idbanco` int(10) NOT NULL,
  `banco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`idbanco`, `banco`) VALUES
(1, ' Banco Bci '),
(2, ' Banco de Chile '),
(3, ' Banco Estado '),
(4, ' Banco Santander '),
(5, ' Banco BICE '),
(6, ' Banco Condell '),
(7, ' Banco CrediChile '),
(8, ' Banco Edwards Citi '),
(9, ' Banco Falabella '),
(10, ' Banco Internacional '),
(11, ' Banco Itaú '),
(12, ' Banco Ripley '),
(13, ' Banco Security '),
(14, ' Scotiabank '),
(15, ' Credit Suisse '),
(16, ' Deutsche Bank '),
(17, ' MUFG Bank '),
(19, ' HSBC '),
(20, ' UBS ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `idcargo` int(10) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `estado` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`idcargo`, `cargo`, `estado`) VALUES
(1, 'Supervisor de Terreno', 1),
(2, 'Programación y Control', 1),
(3, 'Cartografía y Programación', 1),
(4, 'Capataz', 1),
(5, 'Ingeniero Entrenamiento', 1),
(6, 'Jornal', 1),
(7, 'Jornal Eléctrico', 1),
(8, 'Operador Excavadora', 1),
(9, 'Operador Motoniveladora', 1),
(10, 'Motosierrista', 1),
(11, 'Vigilante', 1),
(12, 'Motorista', 1),
(13, 'Chofer de Algible', 1),
(14, 'Jornal Alicador', 1),
(15, 'Tractorista', 1),
(16, 'Gerente de Operaciones', 1),
(17, 'Administración de Contrato', 1),
(18, 'Capataz Junior', 1),
(19, 'Prevencionista de Riesgo', 1),
(20, 'Chofer de Personal', 1),
(21, 'Asesor de Seguridad', 1),
(22, 'Operador Retroexcavadora', 1),
(23, 'Administrativo', 1),
(24, 'Chofer', 1),
(25, 'Jefe de Terreno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos_asignados`
--

CREATE TABLE `cargos_asignados` (
  `id_ca` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_com` int(11) NOT NULL,
  `id_obs` int(11) NOT NULL,
  `doc` text COLLATE utf8_unicode_ci NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL,
  `leer_mandante` int(11) NOT NULL DEFAULT '0',
  `leer_contratista` int(11) NOT NULL DEFAULT '0',
  `tipo` int(11) NOT NULL COMMENT '0: trabajador 1: vehiculo',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `user` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas`
--

CREATE TABLE `comunas` (
  `IdComuna` int(11) NOT NULL,
  `IdRegion` int(11) NOT NULL,
  `Comuna` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comunas`
--

INSERT INTO `comunas` (`IdComuna`, `IdRegion`, `Comuna`) VALUES
(1, 15, 'Arica'),
(2, 15, 'Camarones'),
(3, 15, 'Putre'),
(4, 15, 'General Lagos'),
(5, 1, 'Iquique'),
(6, 1, 'Camiña'),
(7, 1, 'Colchane'),
(8, 1, 'Huara'),
(9, 1, 'Pica'),
(10, 1, 'Pozo Almonte'),
(11, 1, 'Alto Hospicio'),
(12, 2, 'Antofagasta'),
(13, 2, 'Mejillones'),
(14, 2, 'Sierra Gorda'),
(15, 2, 'Taltal'),
(16, 2, 'Calama'),
(17, 2, 'Ollagüe'),
(18, 2, 'San Pedro de Atacama'),
(19, 2, 'Tocopilla'),
(20, 2, 'María Elena'),
(21, 3, 'Copiapó'),
(22, 3, 'Caldera'),
(23, 3, 'Tierra Amarilla'),
(24, 3, 'Chañaral'),
(25, 3, 'Diego de Almagro'),
(26, 3, 'Vallenar'),
(27, 3, 'Alto del Carmen'),
(28, 3, 'Freirina'),
(29, 3, 'Huasco'),
(30, 4, 'La Serena'),
(31, 4, 'Coquimbo'),
(32, 4, 'Andacollo'),
(33, 4, 'La Higuera'),
(34, 4, 'Paiguano'),
(35, 4, 'Vicuña'),
(36, 4, 'Illapel'),
(37, 4, 'Canela'),
(38, 4, 'Los Vilos'),
(39, 4, 'Salamanca'),
(40, 4, 'Ovalle'),
(41, 4, 'Combarbalá'),
(42, 4, 'Monte Patria'),
(43, 4, 'Punitaqui'),
(44, 4, 'Río Hurtado'),
(45, 5, 'Valparaíso'),
(46, 5, 'Casablanca'),
(47, 5, 'Concón'),
(48, 5, 'Juan Fernández'),
(49, 5, 'Puchuncaví'),
(50, 5, 'Quilpué'),
(51, 5, 'Quintero'),
(52, 5, 'Villa Alemana'),
(53, 5, 'Viña del Mar'),
(54, 5, 'Isla  de Pascua'),
(55, 5, 'Los Andes'),
(56, 5, 'Calle Larga'),
(57, 5, 'Rinconada'),
(58, 5, 'San Esteban'),
(59, 5, 'La Ligua'),
(60, 5, 'Cabildo'),
(61, 5, 'Papudo'),
(62, 5, 'Petorca'),
(63, 5, 'Zapallar'),
(64, 5, 'Quillota'),
(65, 5, 'Calera'),
(66, 5, 'Hijuelas'),
(67, 5, 'La Cruz'),
(68, 5, 'Limache'),
(69, 5, 'Nogales'),
(70, 5, 'Olmué'),
(71, 5, 'San Antonio'),
(72, 5, 'Algarrobo'),
(73, 5, 'Cartagena'),
(74, 5, 'El Quisco'),
(75, 5, 'El Tabo'),
(76, 5, 'Santo Domingo'),
(77, 5, 'San Felipe'),
(78, 5, 'Catemu'),
(79, 5, 'Llaillay'),
(80, 5, 'Panquehue'),
(81, 5, 'Putaendo'),
(82, 5, 'Santa María'),
(83, 6, 'Rancagua'),
(84, 6, 'Codegua'),
(85, 6, 'Coinco'),
(86, 6, 'Coltauco'),
(87, 6, 'Doñihue'),
(88, 6, 'Graneros'),
(89, 6, 'Las Cabras'),
(90, 6, 'Machalí'),
(91, 6, 'Malloa'),
(92, 6, 'Mostazal'),
(93, 6, 'Olivar'),
(94, 6, 'Peumo'),
(95, 6, 'Pichidegua'),
(96, 6, 'Quinta de Tilcoco'),
(97, 6, 'Rengo'),
(98, 6, 'Requínoa'),
(99, 6, 'San Vicente'),
(100, 6, 'Pichilemu'),
(101, 6, 'La Estrella'),
(102, 6, 'Litueche'),
(103, 6, 'Marchihue'),
(104, 6, 'Navidad'),
(105, 6, 'Paredones'),
(106, 6, 'San Fernando'),
(107, 6, 'Chépica'),
(108, 6, 'Chimbarongo'),
(109, 6, 'Lolol'),
(110, 6, 'Nancagua'),
(111, 6, 'Palmilla'),
(112, 6, 'Peralillo'),
(113, 6, 'Placilla'),
(114, 6, 'Pumanque'),
(115, 7, 'Santa Cruz'),
(116, 7, 'Talca'),
(117, 7, 'Constitución'),
(118, 7, 'Curepto'),
(119, 7, 'Empedrado'),
(120, 7, 'Maule'),
(121, 7, 'Pelarco'),
(122, 7, 'Pencahue'),
(123, 7, 'Río Claro'),
(124, 7, 'San Clemente'),
(125, 7, 'San Rafael'),
(126, 7, 'Cauquenes'),
(127, 7, 'Chanco'),
(128, 7, 'Pelluhue'),
(129, 7, 'Curicó'),
(130, 7, 'Hualañé'),
(131, 7, 'Licantén'),
(132, 7, 'Molina'),
(133, 7, 'Rauco'),
(134, 7, 'Romeral'),
(135, 7, 'Sagrada Familia'),
(136, 7, 'Teno'),
(137, 7, 'Vichuquén'),
(138, 7, 'Linares'),
(139, 7, 'Colbún'),
(140, 7, 'Longaví'),
(141, 7, 'Parral'),
(142, 7, 'Retiro'),
(143, 7, 'San Javier'),
(144, 7, 'Villa Alegre'),
(145, 7, 'Yerbas Buenas'),
(146, 8, 'Concepción'),
(147, 8, 'Coronel'),
(148, 8, 'Chiguayante'),
(149, 8, 'Florida'),
(150, 8, 'Hualqui'),
(151, 8, 'Lota'),
(152, 8, 'Penco'),
(153, 8, 'San Pedro de la Paz'),
(154, 8, 'Santa Juana'),
(155, 8, 'Talcahuano'),
(156, 8, 'Tomé'),
(157, 8, 'Hualpén'),
(158, 8, 'Lebu'),
(159, 8, 'Arauco'),
(160, 8, 'Cañete'),
(161, 8, 'Contulmo'),
(162, 8, 'Curanilahue'),
(163, 8, 'Los Álamos'),
(164, 8, 'Tirúa'),
(165, 8, 'Los Ángeles'),
(166, 8, 'Antuco'),
(167, 8, 'Cabrero'),
(168, 8, 'Laja'),
(169, 8, 'Mulchén'),
(170, 8, 'Nacimiento'),
(171, 8, 'Negrete'),
(172, 8, 'Quilaco'),
(173, 8, 'Quilleco'),
(174, 8, 'San Rosendo'),
(175, 8, 'Santa Bárbara'),
(176, 8, 'Tucapel'),
(177, 8, 'Yumbel'),
(178, 8, 'Alto Biobío'),
(179, 9, 'Chillán'),
(180, 9, 'Bulnes'),
(181, 9, 'Cobquecura'),
(182, 9, 'Coelemu'),
(183, 9, 'Coihueco'),
(184, 9, 'Chillán Viejo'),
(185, 9, 'El Carmen'),
(186, 9, 'Ninhue'),
(187, 9, 'Ñiquén'),
(188, 9, 'Pemuco'),
(189, 9, 'Pinto'),
(190, 9, 'Portezuelo'),
(191, 9, 'Quillón'),
(192, 9, 'Quirihue'),
(193, 9, 'Ránquil'),
(194, 9, 'San Carlos'),
(195, 9, 'San Fabián'),
(196, 9, 'San Ignacio'),
(197, 9, 'San Nicolás'),
(198, 9, 'Treguaco'),
(199, 9, 'Yungay'),
(200, 10, 'Temuco'),
(201, 10, 'Carahue'),
(202, 10, 'Cunco'),
(203, 10, 'Curarrehue'),
(204, 10, 'Freire'),
(205, 10, 'Galvarino'),
(206, 10, 'Gorbea'),
(207, 10, 'Lautaro'),
(208, 10, 'Loncoche'),
(209, 10, 'Melipeuco'),
(210, 10, 'Nueva Imperial'),
(211, 10, 'Padre Las Casas'),
(212, 10, 'Perquenco'),
(213, 10, 'Pitrufquén'),
(214, 10, 'Pucón'),
(215, 10, 'Saavedra'),
(216, 10, 'Teodoro Schmidt'),
(217, 10, 'Toltén'),
(218, 10, 'Vilcún'),
(219, 10, 'Villarrica'),
(220, 10, 'Cholchol'),
(221, 10, 'Angol'),
(222, 10, 'Collipulli'),
(223, 10, 'Curacautín'),
(224, 10, 'Ercilla'),
(225, 10, 'Lonquimay'),
(226, 10, 'Los Sauces'),
(227, 10, 'Lumaco'),
(228, 10, 'Purén'),
(229, 10, 'Renaico'),
(230, 10, 'Traiguén'),
(231, 10, 'Victoria'),
(232, 11, 'Valdivia'),
(233, 11, 'Corral'),
(234, 11, 'Futrono'),
(235, 11, 'La Unión'),
(236, 11, 'Lago Ranco'),
(237, 11, 'Lanco'),
(238, 11, 'Los Lagos'),
(239, 11, 'Máfil'),
(240, 11, 'Mariquina'),
(241, 11, 'Paillaco'),
(242, 11, 'Panguipulli'),
(243, 11, 'Río Bueno'),
(244, 12, 'Puerto Montt'),
(245, 12, 'Calbuco'),
(246, 12, 'Cochamó'),
(247, 12, 'Fresia'),
(248, 12, 'Frutillar'),
(249, 12, 'Los Muermos'),
(250, 12, 'Llanquihue'),
(251, 12, 'Maullín'),
(252, 12, 'Puerto Varas'),
(253, 12, 'Castro'),
(254, 12, 'Ancud'),
(255, 12, 'Chonchi'),
(256, 12, 'Curaco de Vélez'),
(257, 12, 'Dalcahue'),
(258, 12, 'Puqueldón'),
(259, 12, 'Queilén'),
(260, 12, 'Quellón'),
(261, 12, 'Quemchi'),
(262, 12, 'Quinchao'),
(263, 12, 'Osorno'),
(264, 12, 'Puerto Octay'),
(265, 12, 'Purranque'),
(266, 12, 'Puyehue'),
(267, 12, 'Río Negro'),
(268, 12, 'San Juan de la Costa'),
(269, 12, 'San Pablo'),
(270, 12, 'Chaitén'),
(271, 12, 'Futaleufú'),
(272, 12, 'Hualaihué'),
(273, 12, 'Palena'),
(274, 14, 'Coihaique'),
(275, 14, 'Lago Verde'),
(276, 14, 'Aisén'),
(277, 14, 'Cisnes'),
(278, 14, 'Guaitecas'),
(279, 14, 'Cochrane'),
(280, 14, 'O\'Higgins'),
(281, 14, 'Tortel'),
(282, 14, 'Chile Chico'),
(283, 14, 'Río Ibáñez'),
(284, 16, 'Punta Arenas'),
(285, 16, 'Laguna Blanca'),
(286, 16, 'Río Verde'),
(287, 16, 'San Gregorio'),
(288, 16, 'Cabo de Hornos'),
(289, 16, 'Antártica'),
(290, 16, 'Porvenir'),
(291, 16, 'Primavera'),
(292, 16, 'Timaukel'),
(293, 16, 'Natales'),
(294, 16, 'Torres del Paine'),
(295, 13, 'Santiago'),
(296, 13, 'Cerrillos'),
(297, 13, 'Cerro Navia'),
(298, 13, 'Conchalí'),
(299, 13, 'El Bosque'),
(300, 13, 'Estación Central'),
(301, 13, 'Huechuraba'),
(302, 13, 'Independencia'),
(303, 13, 'La Cisterna'),
(304, 13, 'La Florida'),
(305, 13, 'La Granja'),
(306, 13, 'La Pintana'),
(307, 13, 'La Reina'),
(308, 13, 'Las Condes'),
(309, 13, 'Lo Barnechea'),
(310, 13, 'Lo Espejo'),
(311, 13, 'Lo Prado'),
(312, 13, 'Macul'),
(313, 13, 'Maipú'),
(314, 13, 'Ñuñoa'),
(315, 13, 'Pedro Aguirre Cerda'),
(316, 13, 'Peñalolén'),
(317, 13, 'Providencia'),
(318, 13, 'Pudahuel'),
(319, 13, 'Quilicura'),
(320, 13, 'Quinta Normal'),
(321, 13, 'Recoleta'),
(322, 13, 'Renca'),
(323, 13, 'San Joaquín'),
(324, 13, 'San Miguel'),
(325, 13, 'San Ramón'),
(326, 13, 'Vitacura'),
(327, 13, 'Puente Alto'),
(328, 13, 'Pirque'),
(329, 13, 'San José de Maipo'),
(330, 13, 'Colina'),
(331, 13, 'Lampa'),
(332, 13, 'Tiltil'),
(333, 13, 'San Bernardo'),
(334, 13, 'Buin'),
(335, 13, 'Calera de Tango'),
(336, 13, 'Paine'),
(337, 13, 'Melipilla'),
(338, 13, 'Alhué'),
(339, 13, 'Curacaví'),
(340, 13, 'María Pinto'),
(341, 13, 'San Pedro'),
(342, 13, 'Talagante'),
(343, 13, 'El Monte'),
(344, 13, 'Isla de Maipo'),
(345, 13, 'Padre Hurtado'),
(346, 13, 'Peñaflor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas_copia`
--

CREATE TABLE `comunas_copia` (
  `IdComuna` int(11) NOT NULL,
  `IdRegion` int(11) NOT NULL,
  `Comuna` varchar(50) CHARACTER SET utf8 NOT NULL,
  `estadocomuna` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comunas_copia`
--

INSERT INTO `comunas_copia` (`IdComuna`, `IdRegion`, `Comuna`, `estadocomuna`) VALUES
(16, 15, 'Arica', 0),
(17, 15, 'Camarones', 0),
(18, 15, 'Putre', 0),
(19, 15, 'General Lagos', 0),
(20, 16, 'Iquique', 0),
(21, 16, 'Camiña', 0),
(22, 16, 'Colchane', 0),
(23, 16, 'Huara', 0),
(24, 16, 'Pica', 0),
(25, 16, 'Pozo Almonte', 0),
(26, 16, 'Alto Hospicio', 0),
(27, 2, 'Antofagasta', 0),
(28, 2, 'Mejillones', 0),
(29, 2, 'Sierra Gorda', 0),
(30, 2, 'Taltal', 0),
(31, 2, 'Calama', 0),
(32, 2, 'Ollagüe', 0),
(33, 2, 'San Pedro de Atacama', 0),
(34, 2, 'Tocopilla', 0),
(35, 2, 'María Elena', 0),
(36, 3, 'Copiapó', 0),
(37, 3, 'Caldera', 0),
(38, 3, 'Tierra Amarilla', 0),
(39, 3, 'Chañaral', 0),
(40, 3, 'Diego de Almagro', 0),
(41, 3, 'Vallenar', 0),
(42, 3, 'Alto del Carmen', 0),
(43, 3, 'Freirina', 0),
(44, 3, 'Huasco', 0),
(45, 4, 'La Serena', 0),
(46, 4, 'Coquimbo', 0),
(47, 4, 'Andacollo', 0),
(48, 4, 'La Higuera', 0),
(49, 4, 'Paiguano', 0),
(50, 4, 'Vicuña', 0),
(51, 4, 'Illapel', 0),
(52, 4, 'Canela', 0),
(53, 4, 'Los Vilos', 0),
(54, 4, 'Salamanca', 0),
(55, 4, 'Ovalle', 0),
(56, 4, 'Combarbalá', 0),
(57, 4, 'Monte Patria', 0),
(58, 4, 'Punitaqui', 0),
(59, 4, 'Río Hurtado', 0),
(60, 5, 'Valparaíso', 0),
(61, 5, 'Casablanca', 0),
(62, 5, 'Concón', 0),
(63, 5, 'Juan Fernández', 0),
(64, 5, 'Puchuncaví', 0),
(65, 5, 'Quilpué', 0),
(66, 5, 'Quintero', 0),
(67, 5, 'Villa Alemana', 0),
(68, 5, 'Viña del Mar', 0),
(69, 5, 'Isla  de Pascua', 0),
(70, 5, 'Los Andes', 0),
(71, 5, 'Calle Larga', 0),
(72, 5, 'Rinconada', 0),
(73, 5, 'San Esteban', 0),
(74, 5, 'La Ligua', 0),
(75, 5, 'Cabildo', 0),
(76, 5, 'Papudo', 0),
(77, 5, 'Petorca', 0),
(78, 5, 'Zapallar', 0),
(79, 5, 'Quillota', 0),
(80, 5, 'Calera', 0),
(81, 5, 'Hijuelas', 0),
(82, 5, 'La Cruz', 0),
(83, 5, 'Limache', 0),
(84, 5, 'Nogales', 0),
(85, 5, 'Olmué', 0),
(86, 5, 'San Antonio', 0),
(87, 5, 'Algarrobo', 0),
(88, 5, 'Cartagena', 0),
(89, 5, 'El Quisco', 0),
(90, 5, 'El Tabo', 0),
(91, 5, 'Santo Domingo', 0),
(92, 5, 'San Felipe', 0),
(93, 5, 'Catemu', 0),
(94, 5, 'Llaillay', 0),
(95, 5, 'Panquehue', 0),
(96, 5, 'Putaendo', 0),
(97, 5, 'Santa María', 0),
(98, 6, 'Rancagua', 0),
(99, 6, 'Codegua', 0),
(100, 6, 'Coinco', 0),
(101, 6, 'Coltauco', 0),
(102, 6, 'Doñihue', 0),
(103, 6, 'Graneros', 0),
(104, 6, 'Las Cabras', 0),
(105, 6, 'Machalí', 0),
(106, 6, 'Malloa', 0),
(107, 6, 'Mostazal', 0),
(108, 6, 'Olivar', 0),
(109, 6, 'Peumo', 0),
(110, 6, 'Pichidegua', 0),
(111, 6, 'Quinta de Tilcoco', 0),
(112, 6, 'Rengo', 0),
(113, 6, 'Requínoa', 0),
(114, 6, 'San Vicente', 0),
(115, 6, 'Pichilemu', 0),
(116, 6, 'La Estrella', 0),
(117, 6, 'Litueche', 0),
(118, 6, 'Marchihue', 0),
(119, 6, 'Navidad', 0),
(120, 6, 'Paredones', 0),
(121, 6, 'San Fernando', 0),
(122, 6, 'Chépica', 0),
(123, 6, 'Chimbarongo', 0),
(124, 6, 'Lolol', 0),
(125, 6, 'Nancagua', 0),
(126, 6, 'Palmilla', 0),
(127, 6, 'Peralillo', 0),
(128, 6, 'Placilla', 0),
(129, 6, 'Pumanque', 0),
(130, 6, 'Santa Cruz', 0),
(131, 7, 'Talca', 0),
(132, 7, 'Constitución', 0),
(133, 7, 'Curepto', 0),
(134, 7, 'Empedrado', 0),
(135, 7, 'Maule', 0),
(136, 7, 'Pelarco', 0),
(137, 7, 'Pencahue', 0),
(138, 7, 'Río Claro', 0),
(139, 7, 'San Clemente', 0),
(140, 7, 'San Rafael', 0),
(141, 7, 'Cauquenes', 0),
(142, 7, 'Chanco', 0),
(143, 7, 'Pelluhue', 0),
(144, 7, 'Curicó', 0),
(145, 7, 'Hualañé', 0),
(146, 7, 'Licantén', 0),
(147, 7, 'Molina', 0),
(148, 7, 'Rauco', 0),
(149, 7, 'Romeral', 0),
(150, 7, 'Sagrada Familia', 0),
(151, 7, 'Teno', 0),
(152, 7, 'Vichuquén', 0),
(153, 7, 'Linares', 0),
(154, 7, 'Colbún', 0),
(155, 7, 'Longaví', 0),
(156, 7, 'Parral', 0),
(157, 7, 'Retiro', 0),
(158, 7, 'San Javier', 0),
(159, 7, 'Villa Alegre', 0),
(160, 7, 'Yerbas Buenas', 0),
(161, 8, 'Concepción', 0),
(162, 8, 'Coronel', 0),
(163, 8, 'Chiguayante', 0),
(164, 8, 'Florida', 0),
(165, 8, 'Hualqui', 0),
(166, 8, 'Lota', 0),
(167, 8, 'Penco', 0),
(168, 8, 'San Pedro de la Paz', 0),
(169, 8, 'Santa Juana', 0),
(170, 8, 'Talcahuano', 0),
(171, 8, 'Tomé', 0),
(172, 8, 'Hualpén', 0),
(173, 8, 'Lebu', 0),
(174, 8, 'Arauco', 0),
(175, 8, 'Cañete', 0),
(176, 8, 'Contulmo', 0),
(177, 8, 'Curanilahue', 0),
(178, 8, 'Los Álamos', 0),
(179, 8, 'Tirúa', 0),
(180, 8, 'Los Ángeles', 0),
(181, 8, 'Antuco', 0),
(182, 8, 'Cabrero', 0),
(183, 8, 'Laja', 0),
(184, 8, 'Mulchén', 0),
(185, 8, 'Nacimiento', 0),
(186, 8, 'Negrete', 0),
(187, 8, 'Quilaco', 0),
(188, 8, 'Quilleco', 0),
(189, 8, 'San Rosendo', 0),
(190, 8, 'Santa Bárbara', 0),
(191, 8, 'Tucapel', 0),
(192, 8, 'Yumbel', 0),
(193, 8, 'Alto Biobío', 0),
(194, 8, 'Chillán', 0),
(195, 8, 'Bulnes', 0),
(196, 8, 'Cobquecura', 0),
(197, 8, 'Coelemu', 0),
(198, 8, 'Coihueco', 0),
(199, 8, 'Chillán Viejo', 0),
(200, 8, 'El Carmen', 0),
(201, 8, 'Ninhue', 0),
(202, 8, 'Ñiquén', 0),
(203, 8, 'Pemuco', 0),
(204, 8, 'Pinto', 0),
(205, 8, 'Portezuelo', 0),
(206, 8, 'Quillón', 0),
(207, 8, 'Quirihue', 0),
(208, 8, 'Ránquil', 0),
(209, 8, 'San Carlos', 0),
(210, 8, 'San Fabián', 0),
(211, 8, 'San Ignacio', 0),
(212, 8, 'San Nicolás', 0),
(213, 8, 'Treguaco', 0),
(214, 8, 'Yungay', 0),
(215, 9, 'Temuco', 0),
(216, 9, 'Carahue', 0),
(217, 9, 'Cunco', 0),
(218, 9, 'Curarrehue', 0),
(219, 9, 'Freire', 0),
(220, 9, 'Galvarino', 0),
(221, 9, 'Gorbea', 0),
(222, 9, 'Lautaro', 0),
(223, 9, 'Loncoche', 0),
(224, 9, 'Melipeuco', 0),
(225, 9, 'Nueva Imperial', 0),
(226, 9, 'Padre Las Casas', 0),
(227, 9, 'Perquenco', 0),
(228, 9, 'Pitrufquén', 0),
(229, 9, 'Pucón', 0),
(230, 9, 'Saavedra', 0),
(231, 9, 'Teodoro Schmidt', 0),
(232, 9, 'Toltén', 0),
(233, 9, 'Vilcún', 0),
(234, 9, 'Villarrica', 0),
(235, 9, 'Cholchol', 0),
(236, 9, 'Angol', 0),
(237, 9, 'Collipulli', 0),
(238, 9, 'Curacautín', 0),
(239, 9, 'Ercilla', 0),
(240, 9, 'Lonquimay', 0),
(241, 9, 'Los Sauces', 0),
(242, 9, 'Lumaco', 0),
(243, 9, 'Purén', 0),
(244, 9, 'Renaico', 0),
(245, 9, 'Traiguén', 0),
(246, 9, 'Victoria', 0),
(247, 14, 'Valdivia', 0),
(248, 14, 'Corral', 0),
(249, 14, 'Futrono', 0),
(250, 14, 'La Unión', 0),
(251, 14, 'Lago Ranco', 0),
(252, 14, 'Lanco', 0),
(253, 14, 'Los Lagos', 0),
(254, 14, 'Máfil', 0),
(255, 14, 'Mariquina', 0),
(256, 14, 'Paillaco', 0),
(257, 14, 'Panguipulli', 0),
(258, 14, 'Río Bueno', 0),
(259, 10, 'Puerto Montt', 0),
(260, 10, 'Calbuco', 0),
(261, 10, 'Cochamó', 0),
(262, 10, 'Fresia', 0),
(263, 10, 'Frutillar', 0),
(264, 10, 'Los Muermos', 0),
(265, 10, 'Llanquihue', 0),
(266, 10, 'Maullín', 0),
(267, 10, 'Puerto Varas', 0),
(268, 10, 'Castro', 0),
(269, 10, 'Ancud', 0),
(270, 10, 'Chonchi', 0),
(271, 10, 'Curaco de Vélez', 0),
(272, 10, 'Dalcahue', 0),
(273, 10, 'Puqueldón', 0),
(274, 10, 'Queilén', 0),
(275, 10, 'Quellón', 0),
(276, 10, 'Quemchi', 0),
(277, 10, 'Quinchao', 0),
(278, 10, 'Osorno', 0),
(279, 10, 'Puerto Octay', 0),
(280, 10, 'Purranque', 0),
(281, 10, 'Puyehue', 0),
(282, 10, 'Río Negro', 0),
(283, 10, 'San Juan de la Costa', 0),
(284, 10, 'San Pablo', 0),
(285, 10, 'Chaitén', 0),
(286, 10, 'Futaleufú', 0),
(287, 10, 'Hualaihué', 0),
(288, 10, 'Palena', 0),
(289, 11, 'Coihaique', 0),
(290, 11, 'Lago Verde', 0),
(291, 11, 'Aisén', 0),
(292, 11, 'Cisnes', 0),
(293, 11, 'Guaitecas', 0),
(294, 11, 'Cochrane', 0),
(295, 11, 'O\'Higgins', 0),
(296, 11, 'Tortel', 0),
(297, 11, 'Chile Chico', 0),
(298, 11, 'Río Ibáñez', 0),
(299, 12, 'Punta Arenas', 0),
(300, 12, 'Laguna Blanca', 0),
(301, 12, 'Río Verde', 0),
(302, 12, 'San Gregorio', 0),
(303, 12, 'Cabo de Hornos', 0),
(304, 12, 'Antártica', 0),
(305, 12, 'Porvenir', 0),
(306, 12, 'Primavera', 0),
(307, 12, 'Timaukel', 0),
(308, 12, 'Natales', 0),
(309, 12, 'Torres del Paine', 0),
(310, 1, 'Santiago', 1),
(311, 1, 'Cerrillos', 0),
(312, 1, 'Cerro Navia', 0),
(313, 1, 'Conchalí', 1),
(314, 1, 'El Bosque', 0),
(315, 1, 'Estación Central', 1),
(316, 1, 'Huechuraba', 1),
(317, 1, 'Independencia', 1),
(318, 1, 'La Cisterna', 1),
(319, 1, 'La Florida', 0),
(320, 1, 'La Granja', 1),
(321, 1, 'La Pintana', 0),
(322, 1, 'La Reina', 1),
(323, 1, 'Las Condes', 1),
(324, 1, 'Lo Barnechea', 1),
(325, 1, 'Lo Espejo', 0),
(326, 1, 'Lo Prado', 0),
(327, 1, 'Macul', 1),
(328, 1, 'Maipú', 0),
(329, 1, 'Ñuñoa', 1),
(330, 1, 'Pedro Aguirre Cerda', 1),
(331, 1, 'Peñalolén', 1),
(332, 1, 'Providencia', 1),
(333, 1, 'Pudahuel', 0),
(334, 1, 'Quilicura', 0),
(335, 1, 'Quinta Normal', 1),
(336, 1, 'Recoleta', 1),
(337, 1, 'Renca', 0),
(338, 1, 'San Joaquín', 1),
(339, 1, 'San Miguel', 1),
(340, 1, 'San Ramón', 1),
(341, 1, 'Vitacura', 1),
(342, 1, 'Puente Alto', 0),
(343, 1, 'Pirque', 0),
(344, 1, 'San José de Maipo', 0),
(345, 1, 'Colina', 0),
(346, 1, 'Lampa', 0),
(347, 1, 'Tiltil', 0),
(348, 1, 'San Bernardo', 0),
(349, 1, 'Buin', 0),
(350, 1, 'Calera de Tango', 0),
(351, 1, 'Paine', 0),
(352, 1, 'Melipilla', 0),
(353, 1, 'Alhué', 0),
(354, 1, 'Curacaví', 0),
(355, 1, 'María Pinto', 0),
(356, 1, 'San Pedro', 0),
(357, 1, 'Talagante', 0),
(358, 1, 'El Monte', 0),
(359, 1, 'Isla de Maipo', 0),
(360, 1, 'Padre Hurtado', 0),
(361, 1, 'Peñaflor', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_config` int(11) NOT NULL,
  `bd_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `bd_user` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `bd_pass` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_config`, `bd_name`, `url`, `bd_user`, `bd_pass`) VALUES
(1, 'clubicl_facilcontrol', 'facilcontrol.cl', 'clubicl', 'Arielg12345678!!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratistas`
--

CREATE TABLE `contratistas` (
  `id_contratista` int(10) NOT NULL,
  `giro` varchar(50) NOT NULL,
  `descripcion_giro` varchar(150) NOT NULL,
  `nombre_fantasia` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `direccion_empresa` varchar(50) NOT NULL,
  `dir_comercial_region` int(10) NOT NULL,
  `dir_comercial_comuna` int(10) NOT NULL,
  `administrador` varchar(50) NOT NULL,
  `fono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `representante` varchar(50) NOT NULL,
  `rut_rep` varchar(12) NOT NULL,
  `direccion_rep` varchar(50) NOT NULL,
  `region_rep` int(11) NOT NULL,
  `comuna_rep` int(11) NOT NULL,
  `estado_civil` varchar(10) NOT NULL,
  `url_logo` text NOT NULL,
  `doc_contratista1` text NOT NULL,
  `doc_contratista_mensuales` text NOT NULL,
  `doc_fechas_m` int(11) NOT NULL,
  `creado_contratista` datetime NOT NULL,
  `editado_contratista` datetime NOT NULL,
  `mandante` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `habilitada` int(11) NOT NULL COMMENT '0: habilitada 1: deshabilitada 2: deshabilitada',
  `eliminar` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `acreditada` int(11) NOT NULL,
  `multiple` int(11) NOT NULL,
  `dualidad` int(11) NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratistas_mandantes`
--

CREATE TABLE `contratistas_mandantes` (
  `idcm` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `doc_contratista` text COLLATE utf8_unicode_ci NOT NULL,
  `doc_extras` text COLLATE utf8_unicode_ci NOT NULL,
  `doc_contratista_mensuales` text COLLATE utf8_unicode_ci NOT NULL,
  `cant_doc` int(11) NOT NULL,
  `acreditada` int(11) NOT NULL,
  `plan` int(11) NOT NULL DEFAULT '1',
  `creado` date NOT NULL,
  `editado` date NOT NULL,
  `estado` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratistas_mandantes_copia`
--

CREATE TABLE `contratistas_mandantes_copia` (
  `idcm` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `doc_contratista` text COLLATE utf8_unicode_ci NOT NULL,
  `cant_doc` int(11) NOT NULL,
  `acreditada` int(11) NOT NULL,
  `creado` date NOT NULL,
  `editado` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contratistas_mandantes_copia`
--

INSERT INTO `contratistas_mandantes_copia` (`idcm`, `contratista`, `mandante`, `doc_contratista`, `cant_doc`, `acreditada`, `creado`, `editado`, `estado`) VALUES
(118, 166, 51, 'a:13:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:1:\"9\";i:9;s:2:\"10\";i:10;s:2:\"11\";i:11;s:2:\"12\";i:12;s:2:\"13\";}', 13, 1, '2023-03-30', '0000-00-00', 0),
(121, 166, 50, 'a:3:{i:0;s:1:\"2\";i:1;s:1:\"4\";i:2;s:1:\"6\";}', 3, 0, '2023-03-30', '0000-00-00', 0),
(122, 167, 52, 'a:3:{i:0;s:1:\"2\";i:1;s:1:\"4\";i:2;s:1:\"6\";}', 3, 0, '2023-03-31', '0000-00-00', 0),
(123, 167, 53, 'a:3:{i:0;s:1:\"9\";i:1;s:2:\"11\";i:2;s:2:\"13\";}', 3, 0, '2023-03-31', '0000-00-00', 0),
(124, 168, 50, 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";}', 5, 0, '2023-03-31', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id_contrato` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `nombre_contrato` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cargos` text COLLATE utf8_unicode_ci NOT NULL,
  `vehiculos` text COLLATE utf8_unicode_ci NOT NULL,
  `perfiles` text COLLATE utf8_unicode_ci NOT NULL,
  `perfiles_v` text COLLATE utf8_unicode_ci NOT NULL,
  `mandante` int(11) NOT NULL,
  `creado_contrato` datetime NOT NULL,
  `editado_contrato` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `aviso` int(11) DEFAULT '1',
  `noti` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL,
  `mensuales` int(11) NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_pagos`
--

CREATE TABLE `control_pagos` (
  `idcpagos` int(11) NOT NULL,
  `idcontratista` int(11) NOT NULL,
  `num_pago` int(11) NOT NULL,
  `mes` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `metodo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_pago` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '1-flow 2-transferencia',
  `banco` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha_creado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadrillas`
--

CREATE TABLE `cuadrillas` (
  `id_cuadrilla` int(11) NOT NULL,
  `cuadrilla` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `trabajadores` text COLLATE utf8_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `nombre_contrato` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `contrato` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `lider` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desvinculaciones`
--

CREATE TABLE `desvinculaciones` (
  `id_d` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1: contratista 2.contrato',
  `control` int(11) NOT NULL COMMENT '0: enviado 1: observacion 2: acreditada 3: reenviada',
  `verificado` int(11) NOT NULL,
  `url` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `fecha_desvinculado` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '1: en proceso 2: desvincularo 3: observacion',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc`
--

CREATE TABLE `doc` (
  `id_doc` int(10) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(5) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc`
--

INSERT INTO `doc` (`id_doc`, `documento`, `estado`) VALUES
(0, 'Contrato trabajo', 1),
(1, 'Entrega ODI', 1),
(2, 'Evaluación ODI', 1),
(3, 'Entrega EPP', 1),
(4, 'Entrega Riosh', 1),
(5, 'Evaluación Riosh', 1),
(6, 'Carnet de Identidad', 1),
(7, 'Exámenes Ocupacionales o pre-Ocupacionales', 1),
(8, 'Examen Psicosensotécnico', 1),
(9, 'Licencia conducir', 1),
(10, 'Curso 4x4', 1),
(11, 'Curso manejo defensiva', 1),
(12, 'Examen droga', 1),
(13, 'Certificado competencias', 1),
(14, 'Manejo sustancias  químicas', 1),
(15, 'Entrega reglamento contratista', 1),
(16, 'Evaluación reglamento contratista', 1),
(17, 'Licencia maquinaria pesada', 1),
(18, 'Licencia profesional', 1),
(19, 'Anexos contrato', 1),
(20, 'Finiquito Empleador Anterior', 1),
(21, 'Registro de Charla de Inducción a Empresa', 1),
(22, 'Registro de Difusión de Procedimiento de Trabajo', 1),
(23, 'Registro de Difusión de Plan de Emergencia', 1),
(24, 'Registro de Difusión de Matriz de Riesgo', 1),
(25, 'Evaluación de Procesimientos de Trabajo', 1),
(26, 'Evaluación del Plan de Emergencia', 1),
(27, 'Evaluación de la Matriz de Riesgo', 1),
(28, 'Certificado de antecedentes (Nacional o de País de Origen)', 1),
(29, 'Certificado de afiliación a AFP ', 1),
(30, 'Certificado de afiliación a Sistema de Salud. (Actualizado, no mayor a un mes)', 1),
(31, 'Hoja de Vida del Conductor o similar en caso de trabajadores extranjeros (Actualizado)', 1),
(32, 'Motoserristas: acreditación CORMA', 1),
(33, 'Trabajadores Extranjeros: VISA por contrato, residencia o permiso especial de trabajo', 1),
(35, 'Foto del trabajador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_extras`
--

CREATE TABLE `documentos_extras` (
  `id_de` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1: contratista 2: contratos 3: trabajador individual',
  `tipo_doc` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `acreditado` int(11) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: no recibido 1: recibido 2:observacion 3: acreditado',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `eliminar` int(11) NOT NULL,
  `usuario` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_trabajador_contratista`
--

CREATE TABLE `documentos_trabajador_contratista` (
  `id_dc` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_editado` datetime NOT NULL,
  `usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_vehiculo_contratista`
--

CREATE TABLE `documentos_vehiculo_contratista` (
  `id_dc` int(11) NOT NULL,
  `vehiculo` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_editado` datetime NOT NULL,
  `usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_autos`
--

CREATE TABLE `doc_autos` (
  `id_vdoc` int(11) NOT NULL,
  `documento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc_autos`
--

INSERT INTO `doc_autos` (`id_vdoc`, `documento`, `estado`) VALUES
(0, 'Certificado de inscripción (Padrón)', 0),
(1, 'Factura de Compra o Arriendo', 0),
(2, 'Revisión técnica', 0),
(3, 'Permiso circulación', 0),
(4, 'Seguro obligatorio', 0),
(5, 'Autorización transporte personal', 0),
(6, 'Certificado última mantención', 0),
(7, 'Certificado barras antivuelco', 0),
(8, 'Evidencia cuñas', 0),
(9, 'Manual operación', 0),
(10, 'Foto del vehiculo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_comentarios`
--

CREATE TABLE `doc_comentarios` (
  `id_dcom` int(11) NOT NULL,
  `id_dobs` int(11) NOT NULL,
  `doc` text COLLATE utf8_unicode_ci NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL,
  `leer_mandante` int(11) NOT NULL DEFAULT '0',
  `leer_contratista` int(11) NOT NULL DEFAULT '0',
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `noaplica` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `user` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_comentarios_desvinculaciones`
--

CREATE TABLE `doc_comentarios_desvinculaciones` (
  `id_dcom` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `id_des` int(11) NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL,
  `leer_mandante` int(11) NOT NULL DEFAULT '0',
  `leer_contratista` int(11) NOT NULL DEFAULT '0',
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: no precesada 1: procesada',
  `usuario` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_comentarios_extra`
--

CREATE TABLE `doc_comentarios_extra` (
  `id_dcome` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL,
  `leer_mandante` int(11) NOT NULL DEFAULT '0',
  `leer_contratista` int(11) NOT NULL DEFAULT '0',
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `usuario` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_comentarios_mensual`
--

CREATE TABLE `doc_comentarios_mensual` (
  `id_cm` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL,
  `leer_mandante` int(11) NOT NULL DEFAULT '0',
  `leer_contratista` int(11) NOT NULL DEFAULT '0',
  `trabajador` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mes` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `usuario` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_contratistas`
--

CREATE TABLE `doc_contratistas` (
  `id_cdoc` int(11) NOT NULL,
  `documento` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc_contratistas`
--

INSERT INTO `doc_contratistas` (`id_cdoc`, `documento`, `estado`) VALUES
(1, 'Reglamento Interno', 1),
(2, 'Entrega Reglamento DT', 1),
(3, 'Entrega Reglamento Seremi', 1),
(4, 'Certificado F30', 1),
(5, 'Certificado de Afiliación del Organismo Administrador de la Ley 16.744 (Mutualidad)', 1),
(6, 'Acta Constitución Comité Paritario', 1),
(7, 'Certificados EPP', 1),
(8, 'Plan de Emergencia (firmado por quien elaboró, revisó y aprobó)', 1),
(9, 'Plan H y S', 1),
(10, 'Recepción Reglamento Contratistas', 1),
(11, 'Resolución de Centralización Documentos Laborales F43', 1),
(12, 'Resolución Jornada Excepcional', 1),
(13, 'Matriz de Riesgo (firmado por quien elaboró, revisó y aptrobó)', 1),
(14, 'Acta de Entrega Firmada del Reglamento Especial de Mandante para Empresas Contratistas', 1),
(15, 'Acta de Entrega Firmada del Listado de Documentación a Solicitar por parte del Mandante', 1),
(16, 'Certificado de Siniestralidad (emitido por el Organismo Administrador)', 1),
(17, 'Tabla Informativa de la Empresa', 1),
(18, 'Listado de Maquinarias', 1),
(19, 'Listado de Vehículos', 1),
(20, 'Documentación de Maquinaria', 1),
(21, 'Documentación Vehículos', 1),
(22, 'Certificado de Mantención Maquinarias', 1),
(23, 'Certificado de Mantención Vehículos', 1),
(24, 'Listado de Operadores', 1),
(25, 'Listado de Choferes', 1),
(26, 'Procedimientos de Trabajo (Firmado por quien elaboró, revisó y aprobó)', 1),
(27, 'Certificado de Acreditación u Homologación para Laboratorios', 1),
(28, 'Licencias de Software', 1),
(29, 'Listado con nombre, apellidos, RUT y cargo de todos los trabajadores. Indicar si conduce vehículos.', 1),
(30, 'Organigrama de la Empresa (Incluir nombres y teléfonos de personas asociadas al servicio)', 1),
(31, 'Cronograma de trabajo, indicando plazos asociados', 1),
(32, 'Plan de Emergencia (Enfocado a la actividad a realizar)', 1),
(35, 'Matriz de Id. de aspectos y evaluación de impactos ambientales (si aplica)', 1),
(36, 'Herramientas de gestión (HCR, AST, Charla 5 minutos, Check List, Inspecciones, etc.)', 1),
(37, 'Protocolo de Seguridad Sanitaria Laboral por Covid-19', 1),
(38, 'Reglamento Especial para Empresas Contratistas si subcontratase actividades', 1),
(39, 'Certificados de equipos, herramientas y maquinas criticas', 1),
(40, 'Certificados de elementos de protección personal', 1),
(41, 'Inventario de sustancias peligrosas y Hojas de Datos de Seguridad (HDS)', 1),
(42, 'Declaración de primeros auxilios en terreno (estación de emergencia, botiquín, etc.)', 1),
(43, 'Programa de Control de Empresas Contratistas', 1),
(44, 'Registro recepción Plan SAQP de Seguridad y Salud Ocupacional de la Obra – Solo Proyectos en ejecución', 1),
(45, 'Registro de Reunión de Coordinación entre el Mandante y Representante Empresa Contratista', 1),
(46, 'Multas y Sanciones SAQP por incumplimientos y desviaciones (debe ser firmado en primera plana)', 1),
(47, 'Registro de Faena', 1),
(48, 'Contrato de Prestación de Servicio (Empresas Contratistas y Subcontratistas)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_desvinculaciones`
--

CREATE TABLE `doc_desvinculaciones` (
  `id_dobs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_mensuales`
--

CREATE TABLE `doc_mensuales` (
  `id_dm` int(11) NOT NULL,
  `documento` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc_mensuales`
--

INSERT INTO `doc_mensuales` (`id_dm`, `documento`, `estado`) VALUES
(1, 'Liquidación de sueldos', 0),
(2, 'Certificado de imposiciones', 0),
(3, 'Charlas de capacitación', 0),
(4, 'F30-1', 0),
(5, 'Documento 5', 0),
(6, 'Documento 6', 0),
(7, 'Documento 7', 0),
(8, 'Documento 8', 0),
(9, 'Documento 9', 0),
(10, 'Documento 10', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_observaciones`
--

CREATE TABLE `doc_observaciones` (
  `id_dobs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `urls` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_observaciones-copia`
--

CREATE TABLE `doc_observaciones-copia` (
  `id_dobs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `urls` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc_observaciones-copia`
--

INSERT INTO `doc_observaciones-copia` (`id_dobs`, `verificados`, `urls`, `contratista`, `mandante`, `control`, `estado`, `creado`, `editado`, `user`, `fecha`) VALUES
(99, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 182, 59, 0, 1, '2023-06-14 17:06:53', '0000-00-00 00:00:00', '55.555.555-5', '2023-06-14 17:06:53'),
(102, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 184, 56, 0, 1, '2023-06-19 17:06:40', '0000-00-00 00:00:00', '11.111.111-1', '2023-06-19 17:06:40'),
(103, 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";i:4;s:1:\"1\";}', '', 179, 63, 2, 0, '2023-06-20 11:06:47', '2023-06-20 12:06:05', '99.999.999-9', '2023-06-20 11:06:47'),
(104, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";i:4;s:1:\"0\";i:5;s:1:\"1\";}', '', 181, 63, 2, 0, '2023-06-20 11:06:48', '0000-00-00 00:00:00', '99.999.999-9', '2023-06-20 11:06:48'),
(106, 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"0\";i:4;s:1:\"0\";}', '', 179, 57, 2, 0, '2023-06-20 12:06:27', '2023-06-20 12:06:47', '22.222.222-2', '2023-06-20 12:06:27'),
(107, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 182, 57, 2, 1, '2023-07-27 12:07:21', '2023-07-27 12:07:12', '22.222.222-2', '2023-07-27 12:07:21'),
(109, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";}', '', 191, 66, 2, 1, '2023-08-14 06:08:12', '2023-08-14 07:08:28', '27.069.177-3', '2023-08-14 06:08:12'),
(110, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:55:\"doc/temporal/66/191/Reglamento Interno_26.342.101-9.pdf\";i:1;s:58:\"doc/temporal/66/191/Entrega Reglamento DT_26.342.101-9.pdf\";i:2;s:62:\"doc/temporal/66/191/Entrega Reglamento Seremi_26.342.101-9.pdf\";i:3;s:54:\"doc/temporal/66/191/Matriz de Riesgo_26.342.101-9.xlsx\";}', 191, 66, 0, 1, '2023-08-14 07:08:07', '2023-08-14 07:08:05', '27.069.177-3', '2023-08-14 07:08:07'),
(112, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:56:\"doc/validados/66/193/Reglamento Interno_77.666.196-1.pdf\";i:1;s:59:\"doc/validados/66/193/Entrega Reglamento DT_77.666.196-1.pdf\";i:2;s:63:\"doc/validados/66/193/Entrega Reglamento Seremi_77.666.196-1.pdf\";i:3;s:55:\"doc/validados/66/193/Matriz de Riesgo_77.666.196-1.xlsx\";}', 193, 66, 0, 1, '2023-08-14 08:08:44', '0000-00-00 00:00:00', '27.069.177-3', '2023-08-14 08:08:44'),
(113, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:2:{i:0;s:72:\"doc/validados/66/192/Recepción Reglamento Contratistas_26.125.821-8.pdf\";i:1;s:93:\"doc/validados/66/192/Resolución de Centralización Documentos Laborales F43_26.125.821-8.pdf\";}', 192, 66, 0, 1, '2023-08-14 08:08:22', '0000-00-00 00:00:00', '27.069.177-3', '2023-08-14 08:08:22'),
(114, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:55:\"doc/validados/68/194/Reglamento Interno_4.603.189-K.pdf\";i:1;s:58:\"doc/validados/68/194/Entrega Reglamento DT_4.603.189-K.pdf\";i:2;s:62:\"doc/validados/68/194/Entrega Reglamento Seremi_4.603.189-K.pdf\";i:3;s:54:\"doc/validados/68/194/Matriz de Riesgo_4.603.189-K.xlsx\";}', 194, 68, 2, 1, '2023-08-14 13:08:30', '2023-08-14 13:08:50', '25.224.512-K', '2023-08-14 13:08:30'),
(115, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"0\";i:4;s:1:\"0\";i:5;s:1:\"0\";}', '', 197, 67, 2, 0, '2023-08-15 15:08:11', '2023-08-15 18:08:21', '77.108.459-1', '2023-08-15 15:08:11'),
(116, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:74:\"doc/validados/67/191/Acta Constitución Comité Paritario_26.342.101-9.pdf\";i:1;s:54:\"doc/validados/67/191/Certificados EPP_26.342.101-9.pdf\";i:2;s:56:\"doc/validados/67/191/Plan de Emergencia_26.342.101-9.pdf\";i:3;s:48:\"doc/validados/67/191/Plan H y S_26.342.101-9.pdf\";}', 191, 67, 0, 1, '2023-08-16 02:08:09', '0000-00-00 00:00:00', '77.108.459-1', '2023-08-16 02:08:09'),
(117, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";}', 'a:3:{i:0;s:56:\"doc/validados/68/191/Reglamento Interno_26.342.101-9.pdf\";i:1;s:59:\"doc/validados/68/191/Entrega Reglamento DT_26.342.101-9.pdf\";i:2;s:55:\"doc/validados/68/191/Matriz de Riesgo_26.342.101-9.xlsx\";}', 191, 68, 0, 1, '2023-08-21 17:08:38', '0000-00-00 00:00:00', '25.224.512-K', '2023-08-21 17:08:38'),
(118, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:2:{i:0;s:55:\"doc/validados/56/194/Reglamento Interno_4.603.189-K.pdf\";i:1;s:53:\"doc/validados/56/194/Matriz de Riesgo_4.603.189-K.pdf\";}', 194, 56, 0, 1, '2023-09-05 18:09:17', '0000-00-00 00:00:00', '11.111.111-1', '2023-09-05 18:09:17'),
(119, 'a:10:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";}', 'a:10:{i:0;s:56:\"doc/validados/68/184/Reglamento Interno_13.921.268-1.pdf\";i:1;s:59:\"doc/validados/68/184/Entrega Reglamento DT_13.921.268-1.pdf\";i:2;s:63:\"doc/validados/68/184/Entrega Reglamento Seremi_13.921.268-1.pdf\";i:3;s:54:\"doc/validados/68/184/Certificados EPP_13.921.268-1.pdf\";i:4;s:56:\"doc/validados/68/184/Plan de Emergencia_13.921.268-1.pdf\";i:5;s:48:\"doc/validados/68/184/Plan H y S_13.921.268-1.pdf\";i:6;s:72:\"doc/validados/68/184/Recepción Reglamento Contratistas_13.921.268-1.pdf\";i:7;s:93:\"doc/validados/68/184/Resolución de Centralización Documentos Laborales F43_13.921.268-1.pdf\";i:8;s:69:\"doc/validados/68/184/Resolución Jornada Excepcional_13.921.268-1.pdf\";i:9;s:54:\"doc/validados/68/184/Matriz de Riesgo_13.921.268-1.pdf\";}', 184, 68, 2, 1, '2023-10-30 13:10:01', '2023-10-30 13:10:01', '25.224.512-K', '2023-10-30 13:10:01'),
(122, 'a:27:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"0\";i:5;s:1:\"0\";i:6;s:1:\"0\";i:7;s:1:\"0\";i:8;s:1:\"0\";i:9;s:1:\"0\";i:10;s:1:\"0\";i:11;s:1:\"0\";i:12;s:1:\"0\";i:13;s:1:\"0\";i:14;s:1:\"0\";i:15;s:1:\"0\";i:16;s:1:\"0\";i:17;s:1:\"0\";i:18;s:1:\"0\";i:19;s:1:\"0\";i:20;s:1:\"0\";i:21;s:1:\"0\";i:22;s:1:\"0\";i:23;s:1:\"0\";i:24;s:1:\"0\";i:25;s:1:\"0\";i:26;s:1:\"0\";}', '', 206, 89, 0, 0, '2024-05-10 15:05:21', '2024-08-28 13:08:00', '96.791.730-3', '2024-05-10 15:05:21'),
(124, 'a:10:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"1\";i:4;s:1:\"0\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"0\";i:8;s:1:\"0\";i:9;s:1:\"0\";}', '', 207, 66, 2, 0, '2024-08-03 19:08:47', '2024-09-08 03:09:11', '27.069.177-3', '2024-08-03 19:08:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_observaciones_copia`
--

CREATE TABLE `doc_observaciones_copia` (
  `id_dobs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `urls` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doc_observaciones_copia`
--

INSERT INTO `doc_observaciones_copia` (`id_dobs`, `verificados`, `urls`, `contratista`, `mandante`, `control`, `estado`, `creado`, `editado`, `user`, `fecha`) VALUES
(99, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 182, 59, 0, 1, '2023-06-14 17:06:53', '0000-00-00 00:00:00', '55.555.555-5', '2023-06-14 17:06:53'),
(102, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 184, 56, 0, 1, '2023-06-19 17:06:40', '0000-00-00 00:00:00', '11.111.111-1', '2023-06-19 17:06:40'),
(103, 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";i:4;s:1:\"1\";}', '', 179, 63, 2, 0, '2023-06-20 11:06:47', '2023-06-20 12:06:05', '99.999.999-9', '2023-06-20 11:06:47'),
(104, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";i:4;s:1:\"0\";i:5;s:1:\"1\";}', '', 181, 63, 2, 0, '2023-06-20 11:06:48', '0000-00-00 00:00:00', '99.999.999-9', '2023-06-20 11:06:48'),
(106, 'a:5:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"0\";i:4;s:1:\"0\";}', '', 179, 57, 2, 0, '2023-06-20 12:06:27', '2023-06-20 12:06:47', '22.222.222-2', '2023-06-20 12:06:27'),
(107, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";}', '', 182, 57, 2, 1, '2023-07-27 12:07:21', '2023-07-27 12:07:12', '22.222.222-2', '2023-07-27 12:07:21'),
(109, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"0\";}', '', 191, 66, 2, 1, '2023-08-14 06:08:12', '2023-08-14 07:08:28', '27.069.177-3', '2023-08-14 06:08:12'),
(110, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:55:\"doc/temporal/66/191/Reglamento Interno_26.342.101-9.pdf\";i:1;s:58:\"doc/temporal/66/191/Entrega Reglamento DT_26.342.101-9.pdf\";i:2;s:62:\"doc/temporal/66/191/Entrega Reglamento Seremi_26.342.101-9.pdf\";i:3;s:54:\"doc/temporal/66/191/Matriz de Riesgo_26.342.101-9.xlsx\";}', 191, 66, 0, 1, '2023-08-14 07:08:07', '2023-08-14 07:08:05', '27.069.177-3', '2023-08-14 07:08:07'),
(112, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:56:\"doc/validados/66/193/Reglamento Interno_77.666.196-1.pdf\";i:1;s:59:\"doc/validados/66/193/Entrega Reglamento DT_77.666.196-1.pdf\";i:2;s:63:\"doc/validados/66/193/Entrega Reglamento Seremi_77.666.196-1.pdf\";i:3;s:55:\"doc/validados/66/193/Matriz de Riesgo_77.666.196-1.xlsx\";}', 193, 66, 0, 1, '2023-08-14 08:08:44', '0000-00-00 00:00:00', '27.069.177-3', '2023-08-14 08:08:44'),
(113, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:2:{i:0;s:72:\"doc/validados/66/192/Recepción Reglamento Contratistas_26.125.821-8.pdf\";i:1;s:93:\"doc/validados/66/192/Resolución de Centralización Documentos Laborales F43_26.125.821-8.pdf\";}', 192, 66, 0, 1, '2023-08-14 08:08:22', '0000-00-00 00:00:00', '27.069.177-3', '2023-08-14 08:08:22'),
(114, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:55:\"doc/validados/68/194/Reglamento Interno_4.603.189-K.pdf\";i:1;s:58:\"doc/validados/68/194/Entrega Reglamento DT_4.603.189-K.pdf\";i:2;s:62:\"doc/validados/68/194/Entrega Reglamento Seremi_4.603.189-K.pdf\";i:3;s:54:\"doc/validados/68/194/Matriz de Riesgo_4.603.189-K.xlsx\";}', 194, 68, 2, 1, '2023-08-14 13:08:30', '2023-08-14 13:08:50', '25.224.512-K', '2023-08-14 13:08:30'),
(115, 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"0\";i:4;s:1:\"0\";i:5;s:1:\"0\";}', '', 197, 67, 2, 0, '2023-08-15 15:08:11', '2023-08-15 18:08:21', '77.108.459-1', '2023-08-15 15:08:11'),
(116, 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";}', 'a:4:{i:0;s:74:\"doc/validados/67/191/Acta Constitución Comité Paritario_26.342.101-9.pdf\";i:1;s:54:\"doc/validados/67/191/Certificados EPP_26.342.101-9.pdf\";i:2;s:56:\"doc/validados/67/191/Plan de Emergencia_26.342.101-9.pdf\";i:3;s:48:\"doc/validados/67/191/Plan H y S_26.342.101-9.pdf\";}', 191, 67, 0, 1, '2023-08-16 02:08:09', '0000-00-00 00:00:00', '77.108.459-1', '2023-08-16 02:08:09'),
(117, 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";}', 'a:3:{i:0;s:56:\"doc/validados/68/191/Reglamento Interno_26.342.101-9.pdf\";i:1;s:59:\"doc/validados/68/191/Entrega Reglamento DT_26.342.101-9.pdf\";i:2;s:55:\"doc/validados/68/191/Matriz de Riesgo_26.342.101-9.xlsx\";}', 191, 68, 0, 1, '2023-08-21 17:08:38', '0000-00-00 00:00:00', '25.224.512-K', '2023-08-21 17:08:38'),
(118, 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"1\";}', 'a:2:{i:0;s:55:\"doc/validados/56/194/Reglamento Interno_4.603.189-K.pdf\";i:1;s:53:\"doc/validados/56/194/Matriz de Riesgo_4.603.189-K.pdf\";}', 194, 56, 0, 1, '2023-09-05 18:09:17', '0000-00-00 00:00:00', '11.111.111-1', '2023-09-05 18:09:17'),
(119, 'a:10:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";}', 'a:10:{i:0;s:56:\"doc/validados/68/184/Reglamento Interno_13.921.268-1.pdf\";i:1;s:59:\"doc/validados/68/184/Entrega Reglamento DT_13.921.268-1.pdf\";i:2;s:63:\"doc/validados/68/184/Entrega Reglamento Seremi_13.921.268-1.pdf\";i:3;s:54:\"doc/validados/68/184/Certificados EPP_13.921.268-1.pdf\";i:4;s:56:\"doc/validados/68/184/Plan de Emergencia_13.921.268-1.pdf\";i:5;s:48:\"doc/validados/68/184/Plan H y S_13.921.268-1.pdf\";i:6;s:72:\"doc/validados/68/184/Recepción Reglamento Contratistas_13.921.268-1.pdf\";i:7;s:93:\"doc/validados/68/184/Resolución de Centralización Documentos Laborales F43_13.921.268-1.pdf\";i:8;s:69:\"doc/validados/68/184/Resolución Jornada Excepcional_13.921.268-1.pdf\";i:9;s:54:\"doc/validados/68/184/Matriz de Riesgo_13.921.268-1.pdf\";}', 184, 68, 2, 1, '2023-10-30 13:10:01', '2023-10-30 13:10:01', '25.224.512-K', '2023-10-30 13:10:01'),
(120, 'a:27:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";i:10;s:1:\"1\";i:11;s:1:\"1\";i:12;s:1:\"1\";i:13;s:1:\"1\";i:14;s:1:\"1\";i:15;s:1:\"1\";i:16;s:1:\"1\";i:17;s:1:\"1\";i:18;s:1:\"1\";i:19;s:1:\"1\";i:20;s:1:\"1\";i:21;s:1:\"1\";i:22;s:1:\"1\";i:23;s:1:\"1\";i:24;s:1:\"1\";i:25;s:1:\"1\";i:26;s:1:\"1\";}', 'a:27:{i:0;s:56:\"doc/validados/89/206/Reglamento Interno_77.557.731-2.pdf\";i:1;s:59:\"doc/validados/89/206/Entrega Reglamento DT_77.557.731-2.pdf\";i:2;s:63:\"doc/validados/89/206/Entrega Reglamento Seremi_77.557.731-2.pdf\";i:3;s:53:\"doc/validados/89/206/Certificado F30_77.557.731-2.pdf\";i:4;s:122:\"doc/validados/89/206/Certificado de Afiliación del Organismo Administrador de la Ley 16.744 (Mutualidad)_77.557.731-2.pdf\";i:5;s:104:\"doc/validados/89/206/Matriz de Riesgo (firmado por quien elaboró, revisó y aptrobó)_77.557.731-2.xlsx\";i:6;s:124:\"doc/validados/89/206/Acta de Entrega Firmada del Reglamento Especial de Mandante para Empresas Contratistas_77.557.731-2.pdf\";i:7;s:108:\"doc/validados/89/206/Certificado de Siniestralidad (emitido por el Organismo Administrador)_77.557.731-2.pdf\";i:8;s:111:\"doc/validados/89/206/Procedimientos de Trabajo (Firmado por quien elaboró, revisó y aprobó)_77.557.731-2.pdf\";i:9;s:138:\"doc/validados/89/206/Listado con nombre, apellidos, RUT y cargo de todos los trabajadores. Indicar si conduce vehículos._77.557.731-2.pdf\";i:10;s:128:\"doc/validados/89/206/Organigrama de la Empresa (Incluir nombres y teléfonos de personas asociadas al servicio)_77.557.731-2.pdf\";i:11;s:87:\"doc/validados/89/206/Cronograma de trabajo, indicando plazos asociados_77.557.731-2.pdf\";i:12;s:93:\"doc/validados/89/206/Plan de Emergencia (Enfocado a la actividad a realizar)_77.557.731-2.pdf\";i:13;s:113:\"doc/validados/89/206/Matriz de Id. de aspectos y evaluación de impactos ambientales (si aplica)_77.557.731-2.pdf\";i:14;s:123:\"doc/validados/89/206/Herramientas de gestión (HCR, AST, Charla 5 minutos, Check List, Inspecciones, etc.)_77.557.731-2.pdf\";i:15;s:91:\"doc/validados/89/206/Protocolo de Seguridad Sanitaria Laboral por Covid-19_77.557.731-2.pdf\";i:16;s:113:\"doc/validados/89/206/Reglamento Especial para Empresas Contratistas si subcontratase actividades_77.557.731-2.pdf\";i:17;s:95:\"doc/validados/89/206/Certificados de equipos, herramientas y maquinas criticas_77.557.731-2.pdf\";i:18;s:87:\"doc/validados/89/206/Certificados de elementos de protección personal_77.557.731-2.pdf\";i:19;s:109:\"doc/validados/89/206/Inventario de sustancias peligrosas y Hojas de Datos de Seguridad (HDS)_77.557.731-2.pdf\";i:20;s:125:\"doc/validados/89/206/Declaración de primeros auxilios en terreno (estación de emergencia, botiquín, etc.)_77.557.731-2.pdf\";i:21;s:82:\"doc/validados/89/206/Programa de Control de Empresas Contratistas_77.557.731-2.pdf\";i:22;s:144:\"doc/validados/89/206/Registro recepción Plan SAQP de Seguridad y Salud Ocupacional de la Obra – Solo Proyectos en ejecución_77.557.731-2.pdf\";i:23;s:129:\"doc/validados/89/206/Registro de Reunión de Coordinación entre el Mandante y Representante Empresa Contratista_77.557.731-2.pdf\";i:24;s:132:\"doc/validados/89/206/Multas y Sanciones SAQP por incumplimientos y desviaciones (debe ser firmado en primera plana)_77.557.731-2.pdf\";i:25;s:55:\"doc/validados/89/206/Registro de Faena_77.557.731-2.pdf\";i:26;s:115:\"doc/validados/89/206/Contrato de Prestación de Servicio (Empresas Contratistas y Subcontratistas)_77.557.731-2.pdf\";}', 206, 89, 0, 1, '2024-05-10 15:05:59', '0000-00-00 00:00:00', '96.791.730-3', '2024-05-10 15:05:59'),
(121, 'a:27:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";i:10;s:1:\"1\";i:11;s:1:\"1\";i:12;s:1:\"1\";i:13;s:1:\"1\";i:14;s:1:\"1\";i:15;s:1:\"1\";i:16;s:1:\"1\";i:17;s:1:\"1\";i:18;s:1:\"1\";i:19;s:1:\"1\";i:20;s:1:\"1\";i:21;s:1:\"1\";i:22;s:1:\"1\";i:23;s:1:\"1\";i:24;s:1:\"1\";i:25;s:1:\"1\";i:26;s:1:\"1\";}', 'a:27:{i:0;s:56:\"doc/validados/89/206/Reglamento Interno_77.557.731-2.pdf\";i:1;s:59:\"doc/validados/89/206/Entrega Reglamento DT_77.557.731-2.pdf\";i:2;s:63:\"doc/validados/89/206/Entrega Reglamento Seremi_77.557.731-2.pdf\";i:3;s:53:\"doc/validados/89/206/Certificado F30_77.557.731-2.pdf\";i:4;s:122:\"doc/validados/89/206/Certificado de Afiliación del Organismo Administrador de la Ley 16.744 (Mutualidad)_77.557.731-2.pdf\";i:5;s:104:\"doc/validados/89/206/Matriz de Riesgo (firmado por quien elaboró, revisó y aptrobó)_77.557.731-2.xlsx\";i:6;s:124:\"doc/validados/89/206/Acta de Entrega Firmada del Reglamento Especial de Mandante para Empresas Contratistas_77.557.731-2.pdf\";i:7;s:108:\"doc/validados/89/206/Certificado de Siniestralidad (emitido por el Organismo Administrador)_77.557.731-2.pdf\";i:8;s:111:\"doc/validados/89/206/Procedimientos de Trabajo (Firmado por quien elaboró, revisó y aprobó)_77.557.731-2.pdf\";i:9;s:138:\"doc/validados/89/206/Listado con nombre, apellidos, RUT y cargo de todos los trabajadores. Indicar si conduce vehículos._77.557.731-2.pdf\";i:10;s:128:\"doc/validados/89/206/Organigrama de la Empresa (Incluir nombres y teléfonos de personas asociadas al servicio)_77.557.731-2.pdf\";i:11;s:87:\"doc/validados/89/206/Cronograma de trabajo, indicando plazos asociados_77.557.731-2.pdf\";i:12;s:93:\"doc/validados/89/206/Plan de Emergencia (Enfocado a la actividad a realizar)_77.557.731-2.pdf\";i:13;s:113:\"doc/validados/89/206/Matriz de Id. de aspectos y evaluación de impactos ambientales (si aplica)_77.557.731-2.pdf\";i:14;s:123:\"doc/validados/89/206/Herramientas de gestión (HCR, AST, Charla 5 minutos, Check List, Inspecciones, etc.)_77.557.731-2.pdf\";i:15;s:91:\"doc/validados/89/206/Protocolo de Seguridad Sanitaria Laboral por Covid-19_77.557.731-2.pdf\";i:16;s:113:\"doc/validados/89/206/Reglamento Especial para Empresas Contratistas si subcontratase actividades_77.557.731-2.pdf\";i:17;s:95:\"doc/validados/89/206/Certificados de equipos, herramientas y maquinas criticas_77.557.731-2.pdf\";i:18;s:87:\"doc/validados/89/206/Certificados de elementos de protección personal_77.557.731-2.pdf\";i:19;s:109:\"doc/validados/89/206/Inventario de sustancias peligrosas y Hojas de Datos de Seguridad (HDS)_77.557.731-2.pdf\";i:20;s:125:\"doc/validados/89/206/Declaración de primeros auxilios en terreno (estación de emergencia, botiquín, etc.)_77.557.731-2.pdf\";i:21;s:82:\"doc/validados/89/206/Programa de Control de Empresas Contratistas_77.557.731-2.pdf\";i:22;s:144:\"doc/validados/89/206/Registro recepción Plan SAQP de Seguridad y Salud Ocupacional de la Obra – Solo Proyectos en ejecución_77.557.731-2.pdf\";i:23;s:129:\"doc/validados/89/206/Registro de Reunión de Coordinación entre el Mandante y Representante Empresa Contratista_77.557.731-2.pdf\";i:24;s:132:\"doc/validados/89/206/Multas y Sanciones SAQP por incumplimientos y desviaciones (debe ser firmado en primera plana)_77.557.731-2.pdf\";i:25;s:55:\"doc/validados/89/206/Registro de Faena_77.557.731-2.pdf\";i:26;s:115:\"doc/validados/89/206/Contrato de Prestación de Servicio (Empresas Contratistas y Subcontratistas)_77.557.731-2.pdf\";}', 206, 89, 0, 1, '2024-05-10 15:05:05', '0000-00-00 00:00:00', '96.791.730-3', '2024-05-10 15:05:05'),
(122, 'a:27:{i:0;s:1:\"0\";i:1;s:1:\"0\";i:2;s:1:\"0\";i:3;s:1:\"0\";i:4;s:1:\"0\";i:5;s:1:\"0\";i:6;s:1:\"0\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";i:10;s:1:\"1\";i:11;s:1:\"1\";i:12;s:1:\"1\";i:13;s:1:\"1\";i:14;s:1:\"1\";i:15;s:1:\"1\";i:16;s:1:\"1\";i:17;s:1:\"1\";i:18;s:1:\"1\";i:19;s:1:\"1\";i:20;s:1:\"1\";i:21;s:1:\"1\";i:22;s:1:\"1\";i:23;s:1:\"1\";i:24;s:1:\"1\";i:25;s:1:\"1\";i:26;s:1:\"1\";}', '', 206, 89, 2, 0, '2024-05-10 15:05:21', '0000-00-00 00:00:00', '96.791.730-3', '2024-05-10 15:05:21'),
(124, 'a:10:{i:0;s:1:\"1\";i:1;s:1:\"1\";i:2;s:1:\"1\";i:3;s:1:\"1\";i:4;s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"1\";i:7;s:1:\"1\";i:8;s:1:\"1\";i:9;s:1:\"1\";}', 'a:10:{i:0;s:55:\"doc/validados/66/207/Reglamento Interno_9.259.562-5.pdf\";i:1;s:58:\"doc/validados/66/207/Entrega Reglamento DT_9.259.562-5.pdf\";i:2;s:62:\"doc/validados/66/207/Entrega Reglamento Seremi_9.259.562-5.pdf\";i:3;s:52:\"doc/validados/66/207/Certificado F30_9.259.562-5.pdf\";i:4;s:121:\"doc/validados/66/207/Certificado de Afiliación del Organismo Administrador de la Ley 16.744 (Mutualidad)_9.259.562-5.pdf\";i:5;s:83:\"doc/validados/66/207/No_aplica_Acta Constitución Comité Paritario_9.259.562-5.pdf\";i:6;s:53:\"doc/validados/66/207/Certificados EPP_9.259.562-5.pdf\";i:7;s:103:\"doc/validados/66/207/Plan de Emergencia (firmado por quien elaboró, revisó y aprobó)_9.259.562-5.pdf\";i:8;s:47:\"doc/validados/66/207/Plan H y S_9.259.562-5.pdf\";i:9;s:71:\"doc/validados/66/207/Recepción Reglamento Contratistas_9.259.562-5.pdf\";}', 207, 66, 2, 1, '2024-08-03 19:08:47', '2024-08-03 23:08:01', '27.069.177-3', '2024-08-03 19:08:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_observaciones_extra`
--

CREATE TABLE `doc_observaciones_extra` (
  `id_dobse` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_subidos_contratista`
--

CREATE TABLE `doc_subidos_contratista` (
  `id_ds` int(11) NOT NULL,
  `documento` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `id_documento` int(11) NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `noaplica` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `epp`
--

CREATE TABLE `epp` (
  `id_epp` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `epp` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url_epp` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto_trabajador`
--

CREATE TABLE `foto_trabajador` (
  `id_ft` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `acreditado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mandantes`
--

CREATE TABLE `mandantes` (
  `id_mandante` int(10) NOT NULL,
  `giro` varchar(50) NOT NULL,
  `descripcion_giro` varchar(150) NOT NULL,
  `nombre_fantasia` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rut_empresa` varchar(12) NOT NULL,
  `rut_representante` varchar(12) NOT NULL,
  `representante_legal` varchar(50) NOT NULL,
  `dir_comercial_region` int(10) NOT NULL,
  `dir_comercial_comuna` int(10) NOT NULL,
  `dir_matriz_region` int(10) NOT NULL,
  `dir_matriz_comuna` int(10) NOT NULL,
  `direccion` text NOT NULL,
  `administrador` varchar(50) NOT NULL,
  `fono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` text NOT NULL,
  `multiple` int(11) NOT NULL,
  `dualidad` int(11) NOT NULL,
  `creado_mandante` datetime NOT NULL,
  `editado_mandante` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `usuario` varchar(20) NOT NULL,
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mandantes_copia`
--

CREATE TABLE `mandantes_copia` (
  `id_mandante` int(10) NOT NULL,
  `giro` varchar(50) NOT NULL,
  `descripcion_giro` varchar(150) NOT NULL,
  `nombre_fantasia` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rut_empresa` varchar(12) NOT NULL,
  `rut_representante` varchar(12) NOT NULL,
  `representante_legal` varchar(50) NOT NULL,
  `dir_comercial_region` int(10) NOT NULL,
  `dir_comercial_comuna` int(10) NOT NULL,
  `dir_matriz_region` int(10) NOT NULL,
  `dir_matriz_comuna` int(10) NOT NULL,
  `direccion` text NOT NULL,
  `administrador` varchar(50) NOT NULL,
  `fono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` text NOT NULL,
  `creado_mandante` datetime NOT NULL,
  `editado_mandante` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `mandantes_copia`
--

INSERT INTO `mandantes_copia` (`id_mandante`, `giro`, `descripcion_giro`, `nombre_fantasia`, `razon_social`, `rut_empresa`, `rut_representante`, `representante_legal`, `dir_comercial_region`, `dir_comercial_comuna`, `dir_matriz_region`, `dir_matriz_comuna`, `direccion`, `administrador`, `fono`, `email`, `logo`, `creado_mandante`, `editado_mandante`, `estado`, `eliminar`) VALUES
(55, 'Venta de comidas', 'Venta de alimentacion a empresas', 'Riescomida', 'Riesco spa', '33.333.333-3', '33.333.333-3', 'Carlos Inzunza', 6, 95, 6, 89, 'tres 3', 'Carlos Inzunza', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:13', '0000-00-00 00:00:00', 0, 0),
(56, 'comercializadora se alimentos', 'venta de alimento de mascotas', 'Clubi Mascotas', 'Clubi spa', '11.111.111-1', '11.111.111-1', 'Sebastian Troncoso Torres', 13, 308, 13, 308, 'Uno 1', 'Sebastian Troncoso', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:25', '0000-00-00 00:00:00', 0, 0),
(57, 'Taxis', 'servicio de transportes', 'Taxi xxx', 'Taxis spa', '22.222.222-2', '22.222.222-2', 'Patricio Carlos', 2, 16, 2, 18, 'Dos 2', 'Patricio Carlos', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:39', '0000-00-00 00:00:00', 0, 0),
(58, 'Cobranzas', 'Regulacion de cobros', 'xpress', 'Xpress spa', '44.444.444-4', '44.444.444-4', 'Carlos Diaz', 6, 87, 14, 278, 'Cuatro 4', 'Carlos Diaz', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:25', '0000-00-00 00:00:00', 0, 0),
(59, 'Limpieza de Piscinas', 'aseo de piscinas', 'Pio Limpiezas', 'Pio Ltda', '55.555.555-5', '55.555.555-5', 'Jorge Rojas', 4, 30, 10, 205, 'Cinco 5', 'Jorge Rojas', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:58', '0000-00-00 00:00:00', 0, 0),
(60, 'servicios varios', 'Aseo y limpieza', 'Aseo Sexy ', 'Aseo Sexy spa', '66.666.666-6', '66.666.666-6', 'Rosa Melo', 6, 96, 5, 45, 'Seis 6', 'Rosa Melo', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:42', '0000-00-00 00:00:00', 0, 0),
(61, 'Cobranzas', 'Regulacion de cobros', 'Paga YA', 'Paga Ya spa', '77.777.777-7', '77.777.777-7', 'Patricio Carlos', 8, 158, 10, 211, 'Siete 7', 'Patricio Carlos', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:28', '0000-00-00 00:00:00', 0, 0),
(62, 'Reparación Artículos electrónicos', 'Reparación y servicios', 'Arregla ME', 'Arreglo spa', '88.888.888-8', '88.888.888-8', 'Martin Damian', 10, 208, 4, 31, 'Ocho 8', 'Martin Damian', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:43', '0000-00-00 00:00:00', 0, 0),
(63, 'Reparaciones', 'Arreglo de casas', 'Che Maestro', 'Che Maestro y asociados', '99.999.999-9', '99.999.999-9', 'Federico Boludo', 13, 305, 10, 214, 'Nueve 9', 'Federico Boludo', '56989572907', 'spbeggars@gmail.com', '', '2023-05-16 17:05:44', '0000-00-00 00:00:00', 0, 0),
(66, 'Desarrollo de Sistemas', 'Programcion y desarrollo de sistemas informáticos', 'Desarrollo HL', 'Desarrollo HL', '27.069.177-3', '27.069.177-3', 'Helimir Lopez', 13, 295, 13, 295, 'Lord Cochrane 136', 'Helimir López', '56936450940', 'helimirlopez@gmail.com', '', '2023-08-14 02:08:23', '0000-00-00 00:00:00', 1, 0),
(67, 'Comercializadora de papeleria', 'Comercializacion de productos de papeleria', 'Inversiones HL', 'Inversiones HL', '77.108.459-1', '27.069.177-3', 'José López', 13, 307, 13, 307, 'El Olmos 4', 'José López', '56936450940', 'helimirlopez@gmail.com', '', '2023-08-14 02:08:07', '0000-00-00 00:00:00', 1, 0),
(68, 'servicios de todo', 'instalacion de sistemas de alta tension', 'aurora', 'aurorita', '25.224.512-K', '25.224.512-K', 'Ariel Guzman', 13, 309, 14, 279, '995333816', 'Ariel Guzman', '995333816', 'ariel@sefora.cl', 'img/mandantes/68/foto_25.224.512-K.jpg', '2023-08-14 13:08:50', '0000-00-00 00:00:00', 1, 0),
(69, 'Concesionaria ', 'Reparación, Conservación y Explotación de Obras Públicas', 'Canopsa', 'Sociedad Concesionaria Nuevo Camino Nogales Puchuncavi S.A', '76.449.868-2', '10.379.390-4', 'Raul Vitar Fajre', 13, 308, 13, 308, 'Cerro El Plomo 5855 Piso 16', 'Ariel Guzman Sardy', '56995333816', 'arielguzmansardy@gmail.com', '', '2023-11-22 15:11:17', '0000-00-00 00:00:00', 1, 0),
(70, 'Obras de Ingenieria', 'Torres de Alta Tensión', 'Elecnor', 'Elecnor Chile S.A.', '96.791.730-3', '24.097.337-5', 'Jaime Bengoa Tome', 13, 308, 13, 308, 'Avenida Apoquindo 4504 Of. 1602', 'Ariel Guzman Sardy', '', 'ariel@erachile.cl', '', '2024-03-25 11:03:15', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `autor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `receptor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `asunto` text COLLATE utf8_unicode_ci NOT NULL,
  `categoria` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensuales`
--

CREATE TABLE `mensuales` (
  `id_m` int(11) NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `iniciado` int(11) NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: no iniciado 1:iniciado 2:inactivo',
  `creado` date NOT NULL,
  `editado` date NOT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensuales_trabajador`
--

CREATE TABLE `mensuales_trabajador` (
  `id_tm` int(11) NOT NULL,
  `id_m` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `doc` int(11) NOT NULL,
  `verificado` int(11) NOT NULL,
  `enviado` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `mes` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `id_noti` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `user` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noaplica`
--

CREATE TABLE `noaplica` (
  `id_na` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `extra` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noaplica_trabajador`
--

CREATE TABLE `noaplica_trabajador` (
  `id_na` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noaplica_vehiculo`
--

CREATE TABLE `noaplica_vehiculo` (
  `id_na` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `vehiculo` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `siglas` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `control` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `creado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_noti` int(11) NOT NULL,
  `doc` int(11) NOT NULL,
  `notificacion` int(11) NOT NULL,
  `accion` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `user` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `idnoti` int(11) NOT NULL,
  `item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `envia` int(11) NOT NULL,
  `recibe` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `accion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `leido` int(11) NOT NULL DEFAULT '0',
  `procesada` int(11) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '1: contratista 2:trabajadores 3:vehiculos 4:mensuales',
  `fecha` datetime NOT NULL,
  `fecha_leida` datetime NOT NULL,
  `fecha_procesada` datetime NOT NULL,
  `control` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `documento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_noaplica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones_copia_08-05-23`
--

CREATE TABLE `notificaciones_copia_08-05-23` (
  `idnoti` int(11) NOT NULL,
  `item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nivel` int(11) NOT NULL,
  `envia` int(11) NOT NULL,
  `recibe` int(11) NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `accion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `leido` int(11) NOT NULL DEFAULT '0',
  `procesada` int(11) NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '0: lectura 1: accion',
  `fecha` datetime NOT NULL,
  `fecha_leida` datetime NOT NULL,
  `fecha_procesada` datetime NOT NULL,
  `control` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `documento` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `notificaciones_copia_08-05-23`
--

INSERT INTO `notificaciones_copia_08-05-23` (`idnoti`, `item`, `nivel`, `envia`, `recibe`, `mensaje`, `accion`, `url`, `leido`, `procesada`, `tipo`, `fecha`, `fecha_leida`, `fecha_procesada`, `control`, `estado`, `usuario`, `mandante`, `contratista`, `contrato`, `perfil`, `cargo`, `trabajador`, `documento`) VALUES
(3767, 'Gestion Documentos de Contratista', 2, 52, 174, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-03 05:05:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '27.069.177-3', 52, 174, 0, 0, 0, 0, ''),
(3768, 'Gestion Documentos de Contratista', 2, 52, 174, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Plan de Emergencia</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-03 05:05:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '27.069.177-3', 52, 174, 0, 0, 0, 0, ''),
(3769, 'Gestion Documentos de Contratista', 2, 52, 174, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-03 05:05:01', '2023-06-08 00:06:01', '0000-00-00 00:00:00', 'Plan H y S', 0, '27.069.177-3', 52, 174, 0, 0, 0, 0, ''),
(3773, 'Gestion Documentos de Contratista', 2, 52, 175, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-03 05:05:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '27.069.177-3', 52, 175, 0, 0, 0, 0, ''),
(3774, 'Gestion Documentos de Contratista', 2, 52, 175, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-03 05:05:53', '2023-06-08 00:06:19', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '27.069.177-3', 52, 175, 0, 0, 0, 0, ''),
(3777, 'Gestion Documentos de Contratista', 2, 53, 174, 'El Mandante <b>Inversiones HL</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditación de la contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-03 00:00:00', '2023-06-08 00:06:31', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '77.108.459-1', 53, 174, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(3778, 'Gestion Documentos de Contratista', 2, 53, 174, 'El Mandante <b>Inversiones HL</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-03 00:00:00', '2023-06-08 00:06:22', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '77.108.459-1', 53, 174, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(3819, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3820, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3821, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3822, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3823, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3824, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3825, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificados EPP para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3826, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Plan de Emergencia para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3827, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Plan H y S para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3828, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Recepción Reglamento Contratistas para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Recepción Reglamento Contratistas', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3829, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43 para la acreditacion de l', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3830, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3831, 'Gestion Documentos de Contratista', 2, 54, 176, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 09:05:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '15.716.559-3', 54, 176, 0, 0, 0, 0, ''),
(3845, 'Gestion Documentos de Contratista', 2, 54, 177, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 13:05:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 54, 177, 0, 0, 0, 0, ''),
(3846, 'Gestion Documentos de Contratista', 2, 54, 177, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 13:05:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 54, 177, 0, 0, 0, 0, ''),
(3847, 'Gestion Documentos de Contratista', 2, 54, 177, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 13:05:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 54, 177, 0, 0, 0, 0, ''),
(3848, 'Gestion Documentos de Contratista', 2, 54, 177, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-08 13:05:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 54, 177, 0, 0, 0, 0, ''),
(3896, 'Gestion Documentos de Contratista', 2, 56, 178, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 18:05:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 178, 0, 0, 0, 0, ''),
(3897, 'Gestion Documentos de Contratista', 2, 56, 178, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 18:05:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 178, 0, 0, 0, 0, ''),
(3898, 'Gestion Documentos de Contratista', 2, 56, 178, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 18:05:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 178, 0, 0, 0, 0, ''),
(3899, 'Gestion Documentos de Contratista', 2, 56, 178, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-16 18:05:32', '2023-06-06 14:06:05', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 178, 0, 0, 0, 0, ''),
(3900, 'Gestion Documentos de Contratista', 2, 56, 178, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 18:05:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 178, 0, 0, 0, 0, ''),
(3907, 'Gestion Documentos de Contratista', 2, 57, 178, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Plan de Emergencia</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '22.222.222-2', 57, 178, 0, 0, 0, 0, 'Plan de Emergencia'),
(3908, 'Gestion Documentos de Contratista', 2, 57, 178, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '22.222.222-2', 57, 178, 0, 0, 0, 0, 'Plan H y S'),
(3909, 'Gestion Documentos de Contratista', 2, 57, 178, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Recepción Reglamento Contratistas</b> para la acreditacion de la Contratista</b', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Recepción Reglamento Contratistas', 0, '22.222.222-2', 57, 178, 0, 0, 0, 0, 'Recepción Reglamento Contratistas'),
(3910, 'Gestion Documentos de Contratista', 2, 57, 178, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditacion ', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-16 00:00:00', '2023-05-31 13:05:07', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '22.222.222-2', 57, 178, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(3911, 'Gestion Documentos de Contratista', 2, 57, 178, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-16 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '22.222.222-2', 57, 178, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(3938, 'Gestion Documentos de Contratista', 2, 59, 178, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '55.555.555-5', 59, 178, 0, 0, 0, 0, 'Reglamento Interno'),
(3939, 'Gestion Documentos de Contratista', 2, 59, 178, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '55.555.555-5', 59, 178, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3940, 'Gestion Documentos de Contratista', 2, 59, 178, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '55.555.555-5', 59, 178, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3941, 'Gestion Documentos de Contratista', 2, 59, 178, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 00:00:00', '2023-05-31 13:05:55', '0000-00-00 00:00:00', 'Certificado F30', 0, '55.555.555-5', 59, 178, 0, 0, 0, 0, 'Certificado F30'),
(3942, 'Gestion Documentos de Contratista', 2, 59, 178, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 00:00:00', '2023-06-07 19:06:52', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '55.555.555-5', 59, 178, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(3943, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Reglamento Interno'),
(3944, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3945, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3946, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Certificado F30'),
(3947, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 00:00:00', '2023-05-31 12:05:37', '0000-00-00 00:00:00', 'Certificados EPP', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Certificados EPP'),
(3948, 'Gestion Documentos de Contratista', 2, 61, 178, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Plan de Emergencia</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 00:00:00', '2023-06-07 19:06:02', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '77.777.777-7', 61, 178, 0, 0, 0, 0, 'Plan de Emergencia'),
(3949, 'Gestion Documentos de Contratista', 2, 56, 179, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 10:05:15', '2023-06-06 15:06:26', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 179, 0, 0, 0, 0, ''),
(3950, 'Gestion Documentos de Contratista', 2, 56, 179, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 10:05:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 179, 0, 0, 0, 0, ''),
(3951, 'Gestion Documentos de Contratista', 2, 56, 179, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 10:05:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 179, 0, 0, 0, 0, ''),
(3952, 'Gestion Documentos de Contratista', 2, 56, 179, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-22 10:05:15', '2023-06-06 15:06:04', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 179, 0, 0, 0, 0, ''),
(3953, 'Gestion Documentos de Contratista', 2, 56, 179, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-22 10:05:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 179, 0, 0, 0, 0, ''),
(3954, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Reglamento Interno'),
(3955, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-06 15:06:07', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3956, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3957, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Certificado F30'),
(3958, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(3959, 'Gestion Documentos de Contratista', 2, 55, 179, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-08 14:06:40', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '33.333.333-3', 55, 179, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(3960, 'Gestion Documentos de Contratista', 2, 63, 179, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '99.999.999-9', 63, 179, 0, 0, 0, 0, 'Reglamento Interno'),
(3961, 'Gestion Documentos de Contratista', 2, 63, 179, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '99.999.999-9', 63, 179, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3962, 'Gestion Documentos de Contratista', 2, 63, 179, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '99.999.999-9', 63, 179, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3963, 'Gestion Documentos de Contratista', 2, 63, 179, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '99.999.999-9', 63, 179, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(3964, 'Gestion Documentos de Contratista', 2, 63, 179, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-06 15:06:26', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '99.999.999-9', 63, 179, 0, 0, 0, 0, 'Matriz de Riesgo'),
(3965, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 11:05:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3966, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 11:05:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3967, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 11:05:55', '2023-06-07 21:06:01', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3968, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 11:05:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3969, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 11:05:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3970, 'Gestion Documentos de Contratista', 2, 59, 180, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 11:05:55', '2023-05-31 13:05:46', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '55.555.555-5', 59, 180, 0, 0, 0, 0, ''),
(3971, 'Gestion Documentos de Contratista', 2, 61, 180, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '77.777.777-7', 61, 180, 0, 0, 0, 0, 'Reglamento Interno'),
(3972, 'Gestion Documentos de Contratista', 2, 61, 180, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '77.777.777-7', 61, 180, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3973, 'Gestion Documentos de Contratista', 2, 61, 180, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-05-31 13:05:27', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '77.777.777-7', 61, 180, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3974, 'Gestion Documentos de Contratista', 2, 62, 180, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '88.888.888-8', 62, 180, 0, 0, 0, 0, 'Reglamento Interno'),
(3975, 'Gestion Documentos de Contratista', 2, 62, 180, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-05-31 13:05:12', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '88.888.888-8', 62, 180, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3976, 'Gestion Documentos de Contratista', 2, 62, 180, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '88.888.888-8', 62, 180, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(3977, 'Gestion Documentos de Contratista', 2, 62, 180, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '88.888.888-8', 62, 180, 0, 0, 0, 0, 'Matriz de Riesgo'),
(3978, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3979, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3980, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3981, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3982, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3983, 'Gestion Documentos de Contratista', 2, 56, 181, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 12:05:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '11.111.111-1', 56, 181, 0, 0, 0, 0, ''),
(3984, 'Gestion Documentos de Contratista', 2, 57, 181, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '22.222.222-2', 57, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(3985, 'Gestion Documentos de Contratista', 2, 57, 181, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '22.222.222-2', 57, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3986, 'Gestion Documentos de Contratista', 2, 57, 181, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '22.222.222-2', 57, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3987, 'Gestion Documentos de Contratista', 2, 57, 181, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '22.222.222-2', 57, 181, 0, 0, 0, 0, 'Certificado F30'),
(3988, 'Gestion Documentos de Contratista', 2, 57, 181, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '22.222.222-2', 57, 181, 0, 0, 0, 0, 'Matriz de Riesgo'),
(3989, 'Gestion Documentos de Contratista', 2, 55, 181, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '33.333.333-3', 55, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(3990, 'Gestion Documentos de Contratista', 2, 55, 181, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '33.333.333-3', 55, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3991, 'Gestion Documentos de Contratista', 2, 55, 181, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '33.333.333-3', 55, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3992, 'Gestion Documentos de Contratista', 2, 55, 181, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Plan de Emergencia</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '33.333.333-3', 55, 181, 0, 0, 0, 0, 'Plan de Emergencia'),
(3993, 'Gestion Documentos de Contratista', 2, 55, 181, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '33.333.333-3', 55, 181, 0, 0, 0, 0, 'Plan H y S'),
(3994, 'Gestion Documentos de Contratista', 2, 58, 181, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '44.444.444-4', 58, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(3995, 'Gestion Documentos de Contratista', 2, 58, 181, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '44.444.444-4', 58, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(3996, 'Gestion Documentos de Contratista', 2, 58, 181, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '44.444.444-4', 58, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(3997, 'Gestion Documentos de Contratista', 2, 58, 181, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '44.444.444-4', 58, 181, 0, 0, 0, 0, 'Certificado F30'),
(3998, 'Gestion Documentos de Contratista', 2, 59, 181, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Plan de Emergencia</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '55.555.555-5', 59, 181, 0, 0, 0, 0, 'Plan de Emergencia'),
(3999, 'Gestion Documentos de Contratista', 2, 59, 181, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '55.555.555-5', 59, 181, 0, 0, 0, 0, 'Plan H y S'),
(4000, 'Gestion Documentos de Contratista', 2, 59, 181, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Recepción Reglamento Contratistas</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Recepción Reglamento Contratistas', 0, '55.555.555-5', 59, 181, 0, 0, 0, 0, 'Recepción Reglamento Contratistas'),
(4001, 'Gestion Documentos de Contratista', 2, 59, 181, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '55.555.555-5', 59, 181, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(4002, 'Gestion Documentos de Contratista', 2, 59, 181, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '55.555.555-5', 59, 181, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4003, 'Gestion Documentos de Contratista', 2, 60, 181, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '66.666.666-6', 60, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(4004, 'Gestion Documentos de Contratista', 2, 60, 181, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '66.666.666-6', 60, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4005, 'Gestion Documentos de Contratista', 2, 60, 181, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '66.666.666-6', 60, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4006, 'Gestion Documentos de Contratista', 2, 60, 181, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '66.666.666-6', 60, 181, 0, 0, 0, 0, 'Certificado F30'),
(4007, 'Gestion Documentos de Contratista', 2, 60, 181, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '66.666.666-6', 60, 181, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4008, 'Gestion Documentos de Contratista', 2, 61, 181, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '77.777.777-7', 61, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(4009, 'Gestion Documentos de Contratista', 2, 61, 181, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '77.777.777-7', 61, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4010, 'Gestion Documentos de Contratista', 2, 62, 181, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '88.888.888-8', 62, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(4011, 'Gestion Documentos de Contratista', 2, 62, 181, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '88.888.888-8', 62, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4012, 'Gestion Documentos de Contratista', 2, 62, 181, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '88.888.888-8', 62, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4013, 'Gestion Documentos de Contratista', 2, 62, 181, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '88.888.888-8', 62, 181, 0, 0, 0, 0, 'Certificado F30'),
(4014, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Reglamento Interno'),
(4015, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4016, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4017, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Certificado F30'),
(4018, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4019, 'Gestion Documentos de Contratista', 2, 63, 181, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '99.999.999-9', 63, 181, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(4020, 'Gestion Documentos de Contratista', 2, 57, 179, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '22.222.222-2', 57, 179, 0, 0, 0, 0, 'Reglamento Interno'),
(4021, 'Gestion Documentos de Contratista', 2, 57, 179, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '22.222.222-2', 57, 179, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4022, 'Gestion Documentos de Contratista', 2, 57, 179, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '22.222.222-2', 57, 179, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4023, 'Gestion Documentos de Contratista', 2, 57, 179, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '22.222.222-2', 57, 179, 0, 0, 0, 0, 'Certificado F30');
INSERT INTO `notificaciones_copia_08-05-23` (`idnoti`, `item`, `nivel`, `envia`, `recibe`, `mensaje`, `accion`, `url`, `leido`, `procesada`, `tipo`, `fecha`, `fecha_leida`, `fecha_procesada`, `control`, `estado`, `usuario`, `mandante`, `contratista`, `contrato`, `perfil`, `cargo`, `trabajador`, `documento`) VALUES
(4024, 'Gestion Documentos de Contratista', 2, 57, 179, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-06 15:06:39', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '22.222.222-2', 57, 179, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4025, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Reglamento Interno'),
(4026, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4027, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4028, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Certificado F30'),
(4029, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4030, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(4031, 'Gestion Documentos de Contratista', 2, 59, 179, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-06 15:06:39', '0000-00-00 00:00:00', 'Certificados EPP', 0, '55.555.555-5', 59, 179, 0, 0, 0, 0, 'Certificados EPP'),
(4032, 'Gestion Documentos de Contratista', 2, 61, 179, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '77.777.777-7', 61, 179, 0, 0, 0, 0, 'Reglamento Interno'),
(4033, 'Gestion Documentos de Contratista', 2, 61, 179, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '77.777.777-7', 61, 179, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4034, 'Gestion Documentos de Contratista', 2, 61, 179, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-08 14:06:59', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '77.777.777-7', 61, 179, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4035, 'Gestion Documentos de Contratista', 2, 56, 180, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-05-31 13:05:51', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 180, 0, 0, 0, 0, 'Reglamento Interno'),
(4036, 'Gestion Documentos de Contratista', 2, 56, 180, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 180, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4037, 'Gestion Documentos de Contratista', 2, 56, 180, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 180, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4038, 'Gestion Documentos de Contratista', 2, 56, 180, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 180, 0, 0, 0, 0, 'Certificado F30'),
(4039, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Reglamento Interno'),
(4040, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4041, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4042, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Certificado F30'),
(4043, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Certificados EPP'),
(4044, 'Gestion Documentos de Contratista', 2, 57, 180, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-07 21:06:13', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '22.222.222-2', 57, 180, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(4045, 'Gestion Documentos de Contratista', 2, 55, 180, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '33.333.333-3', 55, 180, 0, 0, 0, 0, 'Reglamento Interno'),
(4046, 'Gestion Documentos de Contratista', 2, 55, 180, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '33.333.333-3', 55, 180, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4047, 'Gestion Documentos de Contratista', 2, 55, 180, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '33.333.333-3', 55, 180, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(4048, 'Gestion Documentos de Contratista', 2, 55, 180, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '33.333.333-3', 55, 180, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(4049, 'Gestion Documentos de Contratista', 2, 55, 180, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-24 00:00:00', '2023-06-07 20:06:13', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '33.333.333-3', 55, 180, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4050, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4051, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4052, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4053, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4054, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4055, 'Gestion Documentos de Contratista', 2, 56, 182, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 13:05:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '11.111.111-1', 56, 182, 0, 0, 0, 0, ''),
(4056, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Reglamento Interno'),
(4057, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4058, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4059, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Certificado F30'),
(4060, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(4061, 'Gestion Documentos de Contratista', 2, 57, 182, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '22.222.222-2', 57, 182, 0, 0, 0, 0, 'Certificados EPP'),
(4062, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Reglamento Interno'),
(4063, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4064, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4065, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Certificado F30'),
(4066, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4067, 'Gestion Documentos de Contratista', 2, 59, 182, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '55.555.555-5', 59, 182, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4068, 'Gestion Documentos de Contratista', 2, 60, 182, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '66.666.666-6', 60, 182, 0, 0, 0, 0, 'Reglamento Interno'),
(4069, 'Gestion Documentos de Contratista', 2, 60, 182, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '66.666.666-6', 60, 182, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4070, 'Gestion Documentos de Contratista', 2, 60, 182, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '66.666.666-6', 60, 182, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4071, 'Gestion Documentos de Contratista', 2, 62, 182, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '88.888.888-8', 62, 182, 0, 0, 0, 0, 'Reglamento Interno'),
(4072, 'Gestion Documentos de Contratista', 2, 62, 182, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '88.888.888-8', 62, 182, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4073, 'Gestion Documentos de Contratista', 2, 62, 182, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '88.888.888-8', 62, 182, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4074, 'Gestion Documentos de Contratista', 2, 62, 182, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '88.888.888-8', 62, 182, 0, 0, 0, 0, 'Certificado F30'),
(4075, 'Gestion Documentos de Contratista', 2, 62, 182, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-24 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '88.888.888-8', 62, 182, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4076, 'Gestion Documentos de Contratista', 2, 56, 183, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 13:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 183, 0, 0, 0, 0, ''),
(4077, 'Gestion Documentos de Contratista', 2, 56, 183, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 13:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 183, 0, 0, 0, 0, ''),
(4078, 'Gestion Documentos de Contratista', 2, 56, 183, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 13:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 183, 0, 0, 0, 0, ''),
(4079, 'Gestion Documentos de Contratista', 2, 56, 183, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 13:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 183, 0, 0, 0, 0, ''),
(4080, 'Gestion Documentos de Contratista', 2, 56, 183, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 13:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 183, 0, 0, 0, 0, ''),
(4081, 'Gestion Documentos de Contratista', 2, 57, 183, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '22.222.222-2', 57, 183, 0, 0, 0, 0, 'Reglamento Interno'),
(4082, 'Gestion Documentos de Contratista', 2, 57, 183, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '22.222.222-2', 57, 183, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4083, 'Gestion Documentos de Contratista', 2, 57, 183, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '22.222.222-2', 57, 183, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4084, 'Gestion Documentos de Contratista', 2, 57, 183, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '22.222.222-2', 57, 183, 0, 0, 0, 0, 'Certificado F30'),
(4085, 'Gestion Documentos de Contratista', 2, 57, 183, 'El Mandante <b>Taxis spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '22.222.222-2', 57, 183, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4086, 'Gestion Documentos de Contratista', 2, 58, 183, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '44.444.444-4', 58, 183, 0, 0, 0, 0, 'Reglamento Interno'),
(4087, 'Gestion Documentos de Contratista', 2, 58, 183, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '44.444.444-4', 58, 183, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4088, 'Gestion Documentos de Contratista', 2, 58, 183, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '44.444.444-4', 58, 183, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4089, 'Gestion Documentos de Contratista', 2, 58, 183, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '44.444.444-4', 58, 183, 0, 0, 0, 0, 'Certificado F30'),
(4090, 'Gestion Documentos de Contratista', 2, 61, 183, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '77.777.777-7', 61, 183, 0, 0, 0, 0, 'Reglamento Interno'),
(4091, 'Gestion Documentos de Contratista', 2, 61, 183, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '77.777.777-7', 61, 183, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4092, 'Gestion Documentos de Contratista', 2, 61, 183, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '77.777.777-7', 61, 183, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4093, 'Gestion Documentos de Contratista', 2, 61, 183, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '77.777.777-7', 61, 183, 0, 0, 0, 0, 'Plan H y S'),
(4094, 'Gestion Documentos de Contratista', 2, 61, 183, 'El Mandante <b>Paga Ya spa</b> ha solicitado la gestion del documento <b>Recepción Reglamento Contratistas</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Recepción Reglamento Contratistas', 0, '77.777.777-7', 61, 183, 0, 0, 0, 0, 'Recepción Reglamento Contratistas'),
(4095, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Reglamento Interno'),
(4096, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4097, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4098, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Certificado F30'),
(4099, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4100, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(4101, 'Gestion Documentos de Contratista', 2, 63, 183, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-29 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '99.999.999-9', 63, 183, 0, 0, 0, 0, 'Certificados EPP'),
(4102, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4103, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4104, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4105, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado F30 para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4106, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4107, 'Gestion Documentos de Contratista', 2, 56, 184, 'El Mandante <b>Clubi spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 13:05:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '11.111.111-1', 56, 184, 0, 0, 0, 0, ''),
(4108, 'Gestion Documentos de Contratista', 2, 58, 184, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '44.444.444-4', 58, 184, 0, 0, 0, 0, 'Certificado F30'),
(4109, 'Gestion Documentos de Contratista', 2, 58, 184, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '44.444.444-4', 58, 184, 0, 0, 0, 0, 'Certificado Afiliación Mutual'),
(4110, 'Gestion Documentos de Contratista', 2, 58, 184, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Acta Constitución Comité Paritario</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Acta Constitución Comité Paritario', 0, '44.444.444-4', 58, 184, 0, 0, 0, 0, 'Acta Constitución Comité Paritario'),
(4111, 'Gestion Documentos de Contratista', 2, 58, 184, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '44.444.444-4', 58, 184, 0, 0, 0, 0, 'Certificados EPP'),
(4112, 'Gestion Documentos de Contratista', 2, 58, 184, 'El Mandante <b>Xpress spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '44.444.444-4', 58, 184, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4113, 'Gestion Documentos de Contratista', 2, 60, 184, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Plan H y S</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan H y S', 0, '66.666.666-6', 60, 184, 0, 0, 0, 0, 'Plan H y S'),
(4114, 'Gestion Documentos de Contratista', 2, 60, 184, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Recepción Reglamento Contratistas</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Recepción Reglamento Contratistas', 0, '66.666.666-6', 60, 184, 0, 0, 0, 0, 'Recepción Reglamento Contratistas'),
(4115, 'Gestion Documentos de Contratista', 2, 60, 184, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Resolución de Centralización Documentos Laborales F43</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución de Centralización Documentos Laborales F43', 0, '66.666.666-6', 60, 184, 0, 0, 0, 0, 'Resolución de Centralización Documentos Laborales F43'),
(4116, 'Gestion Documentos de Contratista', 2, 60, 184, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Resolución Jornada Excepcional</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Resolución Jornada Excepcional', 0, '66.666.666-6', 60, 184, 0, 0, 0, 0, 'Resolución Jornada Excepcional'),
(4117, 'Gestion Documentos de Contratista', 2, 60, 184, 'El Mandante <b>Aseo Sexy spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '66.666.666-6', 60, 184, 0, 0, 0, 0, 'Matriz de Riesgo'),
(4118, 'Gestion Documentos de Contratista', 2, 62, 184, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '88.888.888-8', 62, 184, 0, 0, 0, 0, 'Reglamento Interno'),
(4119, 'Gestion Documentos de Contratista', 2, 62, 184, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '88.888.888-8', 62, 184, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4120, 'Gestion Documentos de Contratista', 2, 62, 184, 'El Mandante <b>Arreglo spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '88.888.888-8', 62, 184, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4121, 'Gestion Documentos de Contratista', 2, 63, 184, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '99.999.999-9', 63, 184, 0, 0, 0, 0, 'Reglamento Interno'),
(4122, 'Gestion Documentos de Contratista', 2, 63, 184, 'El Mandante <b>Che Maestro y asociados</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '99.999.999-9', 63, 184, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4123, 'Gestion Documentos de Contratista', 2, 55, 184, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '33.333.333-3', 55, 184, 0, 0, 0, 0, 'Reglamento Interno'),
(4124, 'Gestion Documentos de Contratista', 2, 55, 184, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '33.333.333-3', 55, 184, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4125, 'Gestion Documentos de Contratista', 2, 55, 184, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '33.333.333-3', 55, 184, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4126, 'Gestion Documentos de Contratista', 2, 55, 184, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-30 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '33.333.333-3', 55, 184, 0, 0, 0, 0, 'Certificado F30'),
(4133, 'Gestion Documentos de Contratista', 2, 52, 185, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Reglamento Interno</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '27.069.177-3', 52, 185, 0, 0, 0, 0, ''),
(4134, 'Gestion Documentos de Contratista', 2, 52, 185, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '27.069.177-3', 52, 185, 0, 0, 0, 0, ''),
(4135, 'Gestion Documentos de Contratista', 2, 52, 185, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '27.069.177-3', 52, 185, 0, 0, 0, 0, ''),
(4136, 'Gestion Documentos de Contratista', 2, 52, 185, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '27.069.177-3', 52, 185, 0, 0, 0, 0, ''),
(4137, 'Gestion Documentos de Contratista', 2, 52, 185, 'El Mandante <b>Desarrollo HL</b> ha solicitado la gestion del documento <b>Certificado Afiliación Mutual</b> para la acreditacion de la Contratista.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-31 12:05:14', '2023-05-31 12:05:39', '0000-00-00 00:00:00', 'Certificado Afiliación Mutual', 0, '27.069.177-3', 52, 185, 0, 0, 0, 0, ''),
(4138, 'Gestion Documentos de Contratista', 2, 59, 186, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Reglamento Interno para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Reglamento Interno', 0, '55.555.555-5', 59, 186, 0, 0, 0, 0, ''),
(4139, 'Gestion Documentos de Contratista', 2, 59, 186, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Plan de Emergencia para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 12:05:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Plan de Emergencia', 0, '55.555.555-5', 59, 186, 0, 0, 0, 0, ''),
(4140, 'Gestion Documentos de Contratista', 2, 59, 186, 'El Mandante <b>Pio Ltda</b> ha solicitado la gestion del documento <b>Matriz de Riesgo para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-31 12:05:50', '2023-05-31 13:05:04', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '55.555.555-5', 59, 186, 0, 0, 0, 0, ''),
(4148, 'Gestion Documentos de Contratista', 2, 55, 186, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento DT</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Entrega Reglamento DT', 0, '33.333.333-3', 55, 186, 0, 0, 0, 0, 'Entrega Reglamento DT'),
(4149, 'Gestion Documentos de Contratista', 2, 55, 186, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Entrega Reglamento Seremi</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-31 00:00:00', '2023-05-31 13:05:01', '0000-00-00 00:00:00', 'Entrega Reglamento Seremi', 0, '33.333.333-3', 55, 186, 0, 0, 0, 0, 'Entrega Reglamento Seremi'),
(4150, 'Gestion Documentos de Contratista', 2, 55, 186, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Certificado F30</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificado F30', 0, '33.333.333-3', 55, 186, 0, 0, 0, 0, 'Certificado F30'),
(4151, 'Gestion Documentos de Contratista', 2, 55, 186, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Certificados EPP</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 0, 0, 1, '2023-05-31 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Certificados EPP', 0, '33.333.333-3', 55, 186, 0, 0, 0, 0, 'Certificados EPP'),
(4152, 'Gestion Documentos de Contratista', 2, 55, 186, 'El Mandante <b>Riesco spa</b> ha solicitado la gestion del documento <b>Matriz de Riesgo</b> para la acreditacion de la Contratista</b>.', 'Gestionar documentos', 'gestion_documentos.php', 1, 0, 1, '2023-05-31 00:00:00', '2023-05-31 13:05:01', '0000-00-00 00:00:00', 'Matriz de Riesgo', 0, '33.333.333-3', 55, 186, 0, 0, 0, 0, 'Matriz de Riesgo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE `observaciones` (
  `id_obs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `trabajador` int(50) NOT NULL,
  `perfil` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `codigo_verificacion` int(10) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones_vehiculo`
--

CREATE TABLE `observaciones_vehiculo` (
  `id_obs` int(11) NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `vehiculo` int(50) NOT NULL,
  `perfil` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `codigo_verificacion` int(10) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL,
  `idcontratista` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha_inicio_plan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_fin_plan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_plan_pago` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `enlace` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idpago`, `idcontratista`, `plan`, `monto`, `fecha_inicio_plan`, `fecha_fin_plan`, `fecha_plan_pago`, `fecha_creado`, `usuario`, `estado`, `enlace`) VALUES
(145, 241, 0, 0, '2025-04-25', '2025-05-25', '', '2025-04-25', '27.069.177-3', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `iso` char(2) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `iso`, `nombre`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(10) NOT NULL,
  `nombre_perfil` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_mandante` int(11) NOT NULL,
  `doc` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL COMMENT '0: trabajador 1:vehiculo',
  `estado` int(11) NOT NULL DEFAULT '1',
  `creado_perfil` datetime NOT NULL,
  `eliminar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_cargos`
--

CREATE TABLE `perfiles_cargos` (
  `id_perfil_cargo` int(11) NOT NULL,
  `cargos` text COLLATE utf8_unicode_ci NOT NULL,
  `perfiles` text COLLATE utf8_unicode_ci NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_cargos_copia`
--

CREATE TABLE `perfiles_cargos_copia` (
  `id_perfil_cargo` int(11) NOT NULL,
  `cargos` text COLLATE utf8_unicode_ci NOT NULL,
  `perfiles` text COLLATE utf8_unicode_ci NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `perfiles_cargos_copia`
--

INSERT INTO `perfiles_cargos_copia` (`id_perfil_cargo`, `cargos`, `perfiles`, `contrato`, `mandante`, `creado`, `editado`) VALUES
(26, 'a:4:{i:0;s:1:\"3\";i:1;s:1:\"5\";i:2;s:1:\"6\";i:3;s:1:\"9\";}', 'a:4:{i:0;s:2:\"58\";i:1;s:2:\"59\";i:2;s:2:\"59\";i:3;s:2:\"58\";}', 117, 14, '2022-03-11 02:03:23', '2022-03-15 05:03:06'),
(27, 'a:4:{i:0;s:1:\"5\";i:1;s:1:\"6\";i:2;s:2:\"17\";i:3;s:2:\"23\";}', 'a:4:{i:0;s:2:\"64\";i:1;s:2:\"60\";i:2;s:2:\"63\";i:3;s:2:\"63\";}', 118, 15, '2022-03-11 15:03:06', '2022-03-11 15:03:31'),
(32, 'a:5:{i:0;s:1:\"5\";i:1;s:1:\"7\";i:2;s:2:\"10\";i:3;s:2:\"11\";i:4;s:2:\"12\";}', 'a:5:{i:0;s:2:\"88\";i:1;s:2:\"89\";i:2;s:2:\"89\";i:3;s:2:\"89\";i:4;s:2:\"59\";}', 120, 14, '2022-03-15 03:03:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_vehiculos`
--

CREATE TABLE `perfiles_vehiculos` (
  `id_perfil_vehiculo` int(11) NOT NULL,
  `vehiculos` text COLLATE utf8_unicode_ci NOT NULL,
  `perfiles` text COLLATE utf8_unicode_ci NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periocidad`
--

CREATE TABLE `periocidad` (
  `id_periodo` int(11) NOT NULL,
  `periodo` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `periocidad`
--

INSERT INTO `periocidad` (`id_periodo`, `periodo`) VALUES
(1, 'Indefinido'),
(2, 'Fin de Año'),
(3, 'Último Día de caca mes'),
(4, 'Día 5 de cada mes'),
(5, 'Día 15 de cada mes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_valor`
--

CREATE TABLE `plan_valor` (
  `idplan` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `plan` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `duracion` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `plan_valor`
--

INSERT INTO `plan_valor` (`idplan`, `valor`, `plan`, `duracion`) VALUES
(1, 500, 'Plan Mensual', '30 dias'),
(2, 1000, 'Plan Trimestral', '3 meses'),
(3, 1500, 'Plan Semestral', '6 meses'),
(4, 2000, 'Plan Anual', '1 año');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `prueba` int(11) NOT NULL,
  `valor` text COLLATE utf8_unicode_ci NOT NULL,
  `valor2` text COLLATE utf8_unicode_ci NOT NULL,
  `valor3` text COLLATE utf8_unicode_ci NOT NULL,
  `valor4` text COLLATE utf8_unicode_ci NOT NULL,
  `valor5` text COLLATE utf8_unicode_ci NOT NULL,
  `valor6` text COLLATE utf8_unicode_ci NOT NULL,
  `valor7` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `IdRegion` int(11) NOT NULL,
  `Region` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`IdRegion`, `Region`, `orden`) VALUES
(1, 'Tarapacá', 2),
(2, 'Antofagasta', 3),
(3, 'Atacama', 4),
(4, 'Coquimbo', 5),
(5, 'Valparaíso', 6),
(6, 'Libertador General Bernardo O\'Higgins', 8),
(7, 'Maule', 9),
(8, 'Bio Bío', 10),
(9, 'Ñuble', 11),
(10, 'La Araucanía', 12),
(11, 'Los Ríos', 13),
(12, 'Los Lagos', 14),
(13, 'Metropolitana de Santiago', 7),
(14, 'Aisén del G. Carlos Ibánez del Campo', 15),
(15, 'Arica y Parinacota', 1),
(16, 'Magallanes y de la Antártica Chilena', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salud`
--

CREATE TABLE `salud` (
  `idsalud` int(11) NOT NULL,
  `institucion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `salud`
--

INSERT INTO `salud` (`idsalud`, `institucion`) VALUES
(1, 'FONASA'),
(2, 'Banmédica'),
(3, 'Colmena'),
(4, 'ConSalud'),
(5, 'MasVida'),
(6, 'Vida Tres'),
(7, 'Cruz Blanca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_s` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `trabajadores` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_autos`
--

CREATE TABLE `tipo_autos` (
  `id_ta` int(11) NOT NULL,
  `auto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `con_patente` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_autos`
--

INSERT INTO `tipo_autos` (`id_ta`, `auto`, `con_patente`, `estado`) VALUES
(1, 'Camioneta', 1, 0),
(2, 'Vehículo liviano', 1, 0),
(3, 'Camión 3/4', 1, 0),
(4, 'Camión', 1, 0),
(5, 'Carro', 1, 0),
(6, 'Bus traslado personal', 1, 0),
(7, 'Moto', 1, 0),
(8, 'Moto 4 ruedas', 1, 0),
(9, 'Tractor', 1, 0),
(10, 'Excavadora', 0, 0),
(11, 'Retroexcavadora', 0, 0),
(12, 'Cargador frontal', 0, 0),
(13, 'Yale', 0, 0),
(14, 'Grúa', 0, 0),
(15, 'Buldozer', 0, 0),
(16, 'Minicargador', 0, 0),
(17, 'Perforadora', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_epp`
--

CREATE TABLE `tipo_epp` (
  `id_tipo` int(11) NOT NULL,
  `nombre_epp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_epp`
--

INSERT INTO `tipo_epp` (`id_tipo`, `nombre_epp`, `estado`) VALUES
(1, 'tipo epp 1', 0),
(2, 'tipo epp 2', 0),
(3, 'tipo epp 3', 0),
(4, 'tipo epp 4', 0),
(5, 'tipo epp 5', 0),
(6, 'tipo epp 6', 0),
(7, 'tipo epp 7', 0),
(8, 'tipo epp 6', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `id_token` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `token` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(10) NOT NULL,
  `creado_token` datetime NOT NULL,
  `cerrado_token` datetime NOT NULL,
  `editado_token` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `idtrabajador` int(11) NOT NULL,
  `nombre1` varchar(50) NOT NULL,
  `nombre2` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `direccion1` varchar(50) NOT NULL,
  `direccion2` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `comuna` varchar(50) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dia` varchar(2) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `fnacimiento` varchar(10) NOT NULL,
  `estadocivil` varchar(20) NOT NULL,
  `tpantalon` varchar(10) NOT NULL,
  `tpolera` varchar(10) NOT NULL,
  `tzapatos` varchar(10) NOT NULL,
  `cargo` int(10) NOT NULL,
  `tipocargo` varchar(10) NOT NULL,
  `licencia` varchar(10) NOT NULL,
  `tipolicencia` varchar(10) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `acreditacion` int(10) NOT NULL DEFAULT '0',
  `adia` varchar(10) NOT NULL,
  `ames` varchar(10) NOT NULL,
  `aano` varchar(10) NOT NULL,
  `observacion` varchar(250) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `cuenta` varchar(50) NOT NULL,
  `tipocuenta` varchar(50) NOT NULL,
  `afp` varchar(50) NOT NULL,
  `salud` varchar(50) NOT NULL,
  `url_foto` text NOT NULL,
  `estado` int(10) NOT NULL COMMENT '0: activo 1: en proceso 2:desvinculado',
  `pcontrato1` varchar(50) NOT NULL,
  `pcontrato2` varchar(100) NOT NULL,
  `turno` varchar(100) NOT NULL DEFAULT 'NA',
  `contratista` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL,
  `validado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_acreditados`
--

CREATE TABLE `trabajadores_acreditados` (
  `id_ta` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos_mensuales` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos_extras` text COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `validez` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `vigente` int(11) NOT NULL,
  `url_foto` text COLLATE utf8_unicode_ci NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: acreditado 1:en proceso desvinculacion 2: desvilculado',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_asignados`
--

CREATE TABLE `trabajadores_asignados` (
  `id_asignados` int(11) NOT NULL,
  `trabajadores` int(11) NOT NULL,
  `cargos` int(11) NOT NULL,
  `perfiles` int(11) NOT NULL,
  `verificados` int(11) NOT NULL COMMENT '0: no validado 1:validado 2: en proceso',
  `foto_verificada` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `url_foto` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: activo 1: en proceso 2:desvinculado',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_asignados_copia`
--

CREATE TABLE `trabajadores_asignados_copia` (
  `id_asignados` int(11) NOT NULL,
  `trabajadores` text COLLATE utf8_unicode_ci NOT NULL,
  `cargos` text COLLATE utf8_unicode_ci NOT NULL,
  `verificados` text COLLATE utf8_unicode_ci NOT NULL,
  `contrato` text COLLATE utf8_unicode_ci NOT NULL,
  `mandante` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `trabajadores_asignados_copia`
--

INSERT INTO `trabajadores_asignados_copia` (`id_asignados`, `trabajadores`, `cargos`, `verificados`, `contrato`, `mandante`, `estado`, `creado`, `editado`, `user`) VALUES
(12, 'a:3:{i:0;s:2:\"16\";i:1;s:2:\"17\";i:2;s:2:\"18\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";}', '', '34', 24, 1, '2023-01-18 02:01:29', '0000-00-00 00:00:00', '27069177-3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_contratistas`
--

CREATE TABLE `trabajadores_contratistas` (
  `id_tc` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_contratista` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_desvinculados`
--

CREATE TABLE `trabajadores_desvinculados` (
  `id_ta` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `validez` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1' COMMENT '1: acreditado 0: desvilculado',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador_contratista`
--

CREATE TABLE `trabajador_contratista` (
  `id_tc` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador_desvinculado`
--

CREATE TABLE `trabajador_desvinculado` (
  `idtrabajador` int(11) NOT NULL,
  `nombre1` varchar(50) NOT NULL,
  `nombre2` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `rut` varchar(10) NOT NULL,
  `direccion1` varchar(50) NOT NULL,
  `direccion2` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `comuna` varchar(50) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dia` varchar(2) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `fnacimiento` varchar(10) NOT NULL,
  `estadocivil` varchar(20) NOT NULL,
  `tpantalon` varchar(10) NOT NULL,
  `tpolera` varchar(10) NOT NULL,
  `tzapatos` varchar(10) NOT NULL,
  `cargo` int(10) NOT NULL,
  `tipocargo` varchar(10) NOT NULL,
  `licencia` varchar(10) NOT NULL,
  `tipolicencia` varchar(10) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `acreditacion` int(10) NOT NULL DEFAULT '0',
  `adia` varchar(10) NOT NULL,
  `ames` varchar(10) NOT NULL,
  `aano` varchar(10) NOT NULL,
  `observacion` varchar(250) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `cuenta` varchar(50) NOT NULL,
  `tipocuenta` varchar(50) NOT NULL,
  `afp` varchar(50) NOT NULL,
  `salud` varchar(50) NOT NULL,
  `url_foto` text NOT NULL,
  `estado` int(10) NOT NULL DEFAULT '1',
  `pcontrato1` varchar(50) NOT NULL,
  `pcontrato2` varchar(100) NOT NULL,
  `turno` varchar(100) NOT NULL DEFAULT 'NA',
  `contratista` int(11) NOT NULL,
  `eliminar` int(11) NOT NULL,
  `validado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador_desvinculado_detalle`
--

CREATE TABLE `trabajador_desvinculado_detalle` (
  `id_dt` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `aprobado` int(11) NOT NULL,
  `creado` date NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `comentarios` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador_documentos_contratista`
--

CREATE TABLE `trabajador_documentos_contratista` (
  `id_dc` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nombre_user` varchar(50) NOT NULL,
  `usuario` text NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `nivel` int(10) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `raw` text NOT NULL,
  `doble` int(11) NOT NULL,
  `creado_user` datetime NOT NULL,
  `editado_user` datetime NOT NULL,
  `validado_user` datetime NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `nombre_user`, `usuario`, `email_user`, `nivel`, `pass`, `raw`, `doble`, `creado_user`, `editado_user`, `validado_user`, `estado`) VALUES
(1, 'Super Admin', '15.716.559-3', 'admin@proyecto.cl', 1, '$2y$10$EZq1FFF6miyCj07ZAYP8kel0AOxboAdN2i/I9b8S8xdfsgiaMiIeq', 'admin', 0, '2022-01-10 13:34:35', '0000-00-00 00:00:00', '2022-01-10 22:01:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_acreditados`
--

CREATE TABLE `vehiculos_acreditados` (
  `id_ta` int(11) NOT NULL,
  `vehiculo` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `documentos` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos_mensuales` text COLLATE utf8_unicode_ci NOT NULL,
  `documentos_extras` text COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `validez` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `vigente` int(11) NOT NULL,
  `url_foto` text COLLATE utf8_unicode_ci NOT NULL,
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: acreditado 1:en proceso desvinculacion 2: desvilculado',
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_asignados`
--

CREATE TABLE `vehiculos_asignados` (
  `id_asignados` int(11) NOT NULL,
  `vehiculos` int(11) NOT NULL,
  `cargos` int(11) NOT NULL,
  `perfiles` int(11) NOT NULL,
  `verificados` int(11) NOT NULL COMMENT '0: no validado 1:validado 2: en proceso',
  `contrato` int(11) NOT NULL,
  `mandante` int(11) NOT NULL,
  `contratista` int(11) NOT NULL,
  `url_foto` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL COMMENT '0: activo 1: en proceso 2:desvinculado',
  `creado` datetime NOT NULL,
  `editado` datetime NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acreditaciones`
--
ALTER TABLE `acreditaciones`
  ADD PRIMARY KEY (`id_a`);

--
-- Indices de la tabla `afp`
--
ALTER TABLE `afp`
  ADD PRIMARY KEY (`idafp`);

--
-- Indices de la tabla `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`id_auto`);

--
-- Indices de la tabla `autos_asignados`
--
ALTER TABLE `autos_asignados`
  ADD PRIMARY KEY (`id_aa`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`idbanco`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`idcargo`);

--
-- Indices de la tabla `cargos_asignados`
--
ALTER TABLE `cargos_asignados`
  ADD PRIMARY KEY (`id_ca`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_com`);

--
-- Indices de la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD PRIMARY KEY (`IdComuna`);

--
-- Indices de la tabla `comunas_copia`
--
ALTER TABLE `comunas_copia`
  ADD PRIMARY KEY (`IdComuna`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `contratistas`
--
ALTER TABLE `contratistas`
  ADD PRIMARY KEY (`id_contratista`),
  ADD KEY `mandante` (`mandante`);

--
-- Indices de la tabla `contratistas_mandantes`
--
ALTER TABLE `contratistas_mandantes`
  ADD PRIMARY KEY (`idcm`),
  ADD KEY `contratistas` (`contratista`),
  ADD KEY `mandantes` (`mandante`);

--
-- Indices de la tabla `contratistas_mandantes_copia`
--
ALTER TABLE `contratistas_mandantes_copia`
  ADD PRIMARY KEY (`idcm`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id_contrato`),
  ADD KEY `contratista_contrato` (`contratista`);

--
-- Indices de la tabla `control_pagos`
--
ALTER TABLE `control_pagos`
  ADD PRIMARY KEY (`idcpagos`),
  ADD KEY `contratista_pagos` (`idcontratista`);

--
-- Indices de la tabla `cuadrillas`
--
ALTER TABLE `cuadrillas`
  ADD PRIMARY KEY (`id_cuadrilla`),
  ADD KEY `contratista_cuadrillas` (`contratista`),
  ADD KEY `contrato_cuadrillas` (`contrato`),
  ADD KEY `mandante_cuadrillas` (`mandante`);

--
-- Indices de la tabla `desvinculaciones`
--
ALTER TABLE `desvinculaciones`
  ADD PRIMARY KEY (`id_d`),
  ADD KEY `trabajador_desvinculacion` (`trabajador`),
  ADD KEY `contrato_desvinculacion` (`contrato`),
  ADD KEY `contratista_desvinculacion` (`contratista`);

--
-- Indices de la tabla `doc`
--
ALTER TABLE `doc`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indices de la tabla `documentos_extras`
--
ALTER TABLE `documentos_extras`
  ADD PRIMARY KEY (`id_de`),
  ADD KEY `contrato_doc_extra` (`contrato`);

--
-- Indices de la tabla `documentos_trabajador_contratista`
--
ALTER TABLE `documentos_trabajador_contratista`
  ADD PRIMARY KEY (`id_dc`),
  ADD KEY `trabajador_documento` (`trabajador`);

--
-- Indices de la tabla `documentos_vehiculo_contratista`
--
ALTER TABLE `documentos_vehiculo_contratista`
  ADD PRIMARY KEY (`id_dc`),
  ADD KEY `auto_doc_contratista` (`vehiculo`);

--
-- Indices de la tabla `doc_autos`
--
ALTER TABLE `doc_autos`
  ADD PRIMARY KEY (`id_vdoc`);

--
-- Indices de la tabla `doc_comentarios`
--
ALTER TABLE `doc_comentarios`
  ADD PRIMARY KEY (`id_dcom`),
  ADD KEY `contratista_doc_comentarios` (`contratista`);

--
-- Indices de la tabla `doc_comentarios_desvinculaciones`
--
ALTER TABLE `doc_comentarios_desvinculaciones`
  ADD PRIMARY KEY (`id_dcom`),
  ADD KEY `contratista_doc_comentarios_desvinculaciones` (`contratista`);

--
-- Indices de la tabla `doc_comentarios_extra`
--
ALTER TABLE `doc_comentarios_extra`
  ADD PRIMARY KEY (`id_dcome`),
  ADD KEY `contratista_doc_comentarios_desvinculaciones_extra` (`contratista`);

--
-- Indices de la tabla `doc_comentarios_mensual`
--
ALTER TABLE `doc_comentarios_mensual`
  ADD PRIMARY KEY (`id_cm`),
  ADD KEY `contrato_doc_comentarios_desvinculaciones_mensual` (`contrato`);

--
-- Indices de la tabla `doc_contratistas`
--
ALTER TABLE `doc_contratistas`
  ADD PRIMARY KEY (`id_cdoc`);

--
-- Indices de la tabla `doc_desvinculaciones`
--
ALTER TABLE `doc_desvinculaciones`
  ADD PRIMARY KEY (`id_dobs`);

--
-- Indices de la tabla `doc_mensuales`
--
ALTER TABLE `doc_mensuales`
  ADD PRIMARY KEY (`id_dm`);

--
-- Indices de la tabla `doc_observaciones`
--
ALTER TABLE `doc_observaciones`
  ADD PRIMARY KEY (`id_dobs`),
  ADD KEY `contratista_doc_observaciones` (`contratista`);

--
-- Indices de la tabla `doc_observaciones-copia`
--
ALTER TABLE `doc_observaciones-copia`
  ADD PRIMARY KEY (`id_dobs`);

--
-- Indices de la tabla `doc_observaciones_copia`
--
ALTER TABLE `doc_observaciones_copia`
  ADD PRIMARY KEY (`id_dobs`);

--
-- Indices de la tabla `doc_observaciones_extra`
--
ALTER TABLE `doc_observaciones_extra`
  ADD PRIMARY KEY (`id_dobse`),
  ADD KEY `contratista_observaciones_extra` (`contratista`);

--
-- Indices de la tabla `doc_subidos_contratista`
--
ALTER TABLE `doc_subidos_contratista`
  ADD PRIMARY KEY (`id_ds`),
  ADD KEY `contratista_doc_subidos` (`contratista`);

--
-- Indices de la tabla `epp`
--
ALTER TABLE `epp`
  ADD PRIMARY KEY (`id_epp`),
  ADD KEY `contratista_epp` (`contratista`);

--
-- Indices de la tabla `foto_trabajador`
--
ALTER TABLE `foto_trabajador`
  ADD PRIMARY KEY (`id_ft`);

--
-- Indices de la tabla `mandantes`
--
ALTER TABLE `mandantes`
  ADD PRIMARY KEY (`id_mandante`);

--
-- Indices de la tabla `mandantes_copia`
--
ALTER TABLE `mandantes_copia`
  ADD PRIMARY KEY (`id_mandante`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indices de la tabla `mensuales`
--
ALTER TABLE `mensuales`
  ADD PRIMARY KEY (`id_m`),
  ADD KEY `contratista_mensuales` (`contratista`);

--
-- Indices de la tabla `mensuales_trabajador`
--
ALTER TABLE `mensuales_trabajador`
  ADD PRIMARY KEY (`id_tm`),
  ADD KEY `trabajador_mensuales` (`trabajador`);

--
-- Indices de la tabla `noaplica`
--
ALTER TABLE `noaplica`
  ADD PRIMARY KEY (`id_na`),
  ADD KEY `cantratista_noaplica` (`contratista`),
  ADD KEY `trabajador_noaplica` (`trabajador`);

--
-- Indices de la tabla `noaplica_trabajador`
--
ALTER TABLE `noaplica_trabajador`
  ADD PRIMARY KEY (`id_na`),
  ADD KEY `contratista_noaplica_trabajador` (`contratista`),
  ADD KEY `trabajador_noaplica_trabajador` (`trabajador`);

--
-- Indices de la tabla `noaplica_vehiculo`
--
ALTER TABLE `noaplica_vehiculo`
  ADD PRIMARY KEY (`id_na`),
  ADD KEY `contratista_noaplica_vehiculo` (`contratista`),
  ADD KEY `auto_noaplica_vehiculo` (`vehiculo`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_noti`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`idnoti`);

--
-- Indices de la tabla `notificaciones_copia_08-05-23`
--
ALTER TABLE `notificaciones_copia_08-05-23`
  ADD PRIMARY KEY (`idnoti`);

--
-- Indices de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD PRIMARY KEY (`id_obs`);

--
-- Indices de la tabla `observaciones_vehiculo`
--
ALTER TABLE `observaciones_vehiculo`
  ADD PRIMARY KEY (`id_obs`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`),
  ADD KEY `mandante_perfiles` (`id_mandante`);

--
-- Indices de la tabla `perfiles_cargos`
--
ALTER TABLE `perfiles_cargos`
  ADD PRIMARY KEY (`id_perfil_cargo`),
  ADD KEY `contrato_perfiles_cargo` (`contrato`);

--
-- Indices de la tabla `perfiles_cargos_copia`
--
ALTER TABLE `perfiles_cargos_copia`
  ADD PRIMARY KEY (`id_perfil_cargo`);

--
-- Indices de la tabla `perfiles_vehiculos`
--
ALTER TABLE `perfiles_vehiculos`
  ADD PRIMARY KEY (`id_perfil_vehiculo`),
  ADD KEY `contrato_perfiles_vehiclos` (`contrato`);

--
-- Indices de la tabla `periocidad`
--
ALTER TABLE `periocidad`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `plan_valor`
--
ALTER TABLE `plan_valor`
  ADD PRIMARY KEY (`idplan`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`prueba`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`IdRegion`);

--
-- Indices de la tabla `salud`
--
ALTER TABLE `salud`
  ADD PRIMARY KEY (`idsalud`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id_s`);

--
-- Indices de la tabla `tipo_autos`
--
ALTER TABLE `tipo_autos`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indices de la tabla `tipo_epp`
--
ALTER TABLE `tipo_epp`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id_token`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`idtrabajador`),
  ADD KEY `contratista_trabajador` (`contratista`);

--
-- Indices de la tabla `trabajadores_acreditados`
--
ALTER TABLE `trabajadores_acreditados`
  ADD PRIMARY KEY (`id_ta`),
  ADD KEY `contrato_trabajador_acreditado` (`contrato`);

--
-- Indices de la tabla `trabajadores_asignados`
--
ALTER TABLE `trabajadores_asignados`
  ADD PRIMARY KEY (`id_asignados`),
  ADD KEY `contrato_trabajador_asignado` (`contrato`);

--
-- Indices de la tabla `trabajadores_asignados_copia`
--
ALTER TABLE `trabajadores_asignados_copia`
  ADD PRIMARY KEY (`id_asignados`);

--
-- Indices de la tabla `trabajadores_contratistas`
--
ALTER TABLE `trabajadores_contratistas`
  ADD PRIMARY KEY (`id_tc`);

--
-- Indices de la tabla `trabajadores_desvinculados`
--
ALTER TABLE `trabajadores_desvinculados`
  ADD PRIMARY KEY (`id_ta`),
  ADD KEY `contrato_trabajadores_desvinculados` (`contrato`);

--
-- Indices de la tabla `trabajador_contratista`
--
ALTER TABLE `trabajador_contratista`
  ADD PRIMARY KEY (`id_tc`);

--
-- Indices de la tabla `trabajador_desvinculado`
--
ALTER TABLE `trabajador_desvinculado`
  ADD PRIMARY KEY (`idtrabajador`);

--
-- Indices de la tabla `trabajador_desvinculado_detalle`
--
ALTER TABLE `trabajador_desvinculado_detalle`
  ADD PRIMARY KEY (`id_dt`),
  ADD KEY `contrato_trabajador_desvinculado` (`contrato`);

--
-- Indices de la tabla `trabajador_documentos_contratista`
--
ALTER TABLE `trabajador_documentos_contratista`
  ADD PRIMARY KEY (`id_dc`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `vehiculos_acreditados`
--
ALTER TABLE `vehiculos_acreditados`
  ADD PRIMARY KEY (`id_ta`),
  ADD KEY `auto_acreditado` (`vehiculo`),
  ADD KEY `contratista_autos_acreditados` (`contratista`);

--
-- Indices de la tabla `vehiculos_asignados`
--
ALTER TABLE `vehiculos_asignados`
  ADD PRIMARY KEY (`id_asignados`),
  ADD KEY `auto_asignados` (`vehiculos`),
  ADD KEY `contratista_autos_asignados` (`contratista`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acreditaciones`
--
ALTER TABLE `acreditaciones`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `idafp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `autos`
--
ALTER TABLE `autos`
  MODIFY `id_auto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autos_asignados`
--
ALTER TABLE `autos_asignados`
  MODIFY `id_aa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `idbanco` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `idcargo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cargos_asignados`
--
ALTER TABLE `cargos_asignados`
  MODIFY `id_ca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comunas`
--
ALTER TABLE `comunas`
  MODIFY `IdComuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT de la tabla `comunas_copia`
--
ALTER TABLE `comunas_copia`
  MODIFY `IdComuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contratistas`
--
ALTER TABLE `contratistas`
  MODIFY `id_contratista` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT de la tabla `contratistas_mandantes`
--
ALTER TABLE `contratistas_mandantes`
  MODIFY `idcm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de la tabla `contratistas_mandantes_copia`
--
ALTER TABLE `contratistas_mandantes_copia`
  MODIFY `idcm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `control_pagos`
--
ALTER TABLE `control_pagos`
  MODIFY `idcpagos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `cuadrillas`
--
ALTER TABLE `cuadrillas`
  MODIFY `id_cuadrilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desvinculaciones`
--
ALTER TABLE `desvinculaciones`
  MODIFY `id_d` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc`
--
ALTER TABLE `doc`
  MODIFY `id_doc` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `documentos_extras`
--
ALTER TABLE `documentos_extras`
  MODIFY `id_de` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_trabajador_contratista`
--
ALTER TABLE `documentos_trabajador_contratista`
  MODIFY `id_dc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentos_vehiculo_contratista`
--
ALTER TABLE `documentos_vehiculo_contratista`
  MODIFY `id_dc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_autos`
--
ALTER TABLE `doc_autos`
  MODIFY `id_vdoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `doc_comentarios`
--
ALTER TABLE `doc_comentarios`
  MODIFY `id_dcom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_comentarios_desvinculaciones`
--
ALTER TABLE `doc_comentarios_desvinculaciones`
  MODIFY `id_dcom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_comentarios_extra`
--
ALTER TABLE `doc_comentarios_extra`
  MODIFY `id_dcome` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_comentarios_mensual`
--
ALTER TABLE `doc_comentarios_mensual`
  MODIFY `id_cm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_contratistas`
--
ALTER TABLE `doc_contratistas`
  MODIFY `id_cdoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `doc_desvinculaciones`
--
ALTER TABLE `doc_desvinculaciones`
  MODIFY `id_dobs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_mensuales`
--
ALTER TABLE `doc_mensuales`
  MODIFY `id_dm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `doc_observaciones`
--
ALTER TABLE `doc_observaciones`
  MODIFY `id_dobs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_observaciones-copia`
--
ALTER TABLE `doc_observaciones-copia`
  MODIFY `id_dobs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `doc_observaciones_copia`
--
ALTER TABLE `doc_observaciones_copia`
  MODIFY `id_dobs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `doc_observaciones_extra`
--
ALTER TABLE `doc_observaciones_extra`
  MODIFY `id_dobse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_subidos_contratista`
--
ALTER TABLE `doc_subidos_contratista`
  MODIFY `id_ds` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT de la tabla `epp`
--
ALTER TABLE `epp`
  MODIFY `id_epp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foto_trabajador`
--
ALTER TABLE `foto_trabajador`
  MODIFY `id_ft` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mandantes`
--
ALTER TABLE `mandantes`
  MODIFY `id_mandante` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `mandantes_copia`
--
ALTER TABLE `mandantes_copia`
  MODIFY `id_mandante` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensuales`
--
ALTER TABLE `mensuales`
  MODIFY `id_m` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensuales_trabajador`
--
ALTER TABLE `mensuales_trabajador`
  MODIFY `id_tm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noaplica`
--
ALTER TABLE `noaplica`
  MODIFY `id_na` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noaplica_trabajador`
--
ALTER TABLE `noaplica_trabajador`
  MODIFY `id_na` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noaplica_vehiculo`
--
ALTER TABLE `noaplica_vehiculo`
  MODIFY `id_na` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_noti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `idnoti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3345;

--
-- AUTO_INCREMENT de la tabla `notificaciones_copia_08-05-23`
--
ALTER TABLE `notificaciones_copia_08-05-23`
  MODIFY `idnoti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4153;

--
-- AUTO_INCREMENT de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  MODIFY `id_obs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `observaciones_vehiculo`
--
ALTER TABLE `observaciones_vehiculo`
  MODIFY `id_obs` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles_cargos`
--
ALTER TABLE `perfiles_cargos`
  MODIFY `id_perfil_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles_cargos_copia`
--
ALTER TABLE `perfiles_cargos_copia`
  MODIFY `id_perfil_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `perfiles_vehiculos`
--
ALTER TABLE `perfiles_vehiculos`
  MODIFY `id_perfil_vehiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periocidad`
--
ALTER TABLE `periocidad`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `plan_valor`
--
ALTER TABLE `plan_valor`
  MODIFY `idplan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `prueba` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `salud`
--
ALTER TABLE `salud`
  MODIFY `idsalud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_autos`
--
ALTER TABLE `tipo_autos`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipo_epp`
--
ALTER TABLE `tipo_epp`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id_token` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  MODIFY `idtrabajador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores_acreditados`
--
ALTER TABLE `trabajadores_acreditados`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores_asignados`
--
ALTER TABLE `trabajadores_asignados`
  MODIFY `id_asignados` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores_asignados_copia`
--
ALTER TABLE `trabajadores_asignados_copia`
  MODIFY `id_asignados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `trabajadores_contratistas`
--
ALTER TABLE `trabajadores_contratistas`
  MODIFY `id_tc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores_desvinculados`
--
ALTER TABLE `trabajadores_desvinculados`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajador_contratista`
--
ALTER TABLE `trabajador_contratista`
  MODIFY `id_tc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajador_desvinculado`
--
ALTER TABLE `trabajador_desvinculado`
  MODIFY `idtrabajador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajador_desvinculado_detalle`
--
ALTER TABLE `trabajador_desvinculado_detalle`
  MODIFY `id_dt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajador_documentos_contratista`
--
ALTER TABLE `trabajador_documentos_contratista`
  MODIFY `id_dc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT de la tabla `vehiculos_acreditados`
--
ALTER TABLE `vehiculos_acreditados`
  MODIFY `id_ta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos_asignados`
--
ALTER TABLE `vehiculos_asignados`
  MODIFY `id_asignados` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contratistas`
--
ALTER TABLE `contratistas`
  ADD CONSTRAINT `mandante` FOREIGN KEY (`mandante`) REFERENCES `mandantes` (`id_mandante`);

--
-- Filtros para la tabla `contratistas_mandantes`
--
ALTER TABLE `contratistas_mandantes`
  ADD CONSTRAINT `contratistas` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`),
  ADD CONSTRAINT `mandantes` FOREIGN KEY (`mandante`) REFERENCES `mandantes` (`id_mandante`);

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratista_contrato` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `control_pagos`
--
ALTER TABLE `control_pagos`
  ADD CONSTRAINT `contratista_pagos` FOREIGN KEY (`idcontratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `cuadrillas`
--
ALTER TABLE `cuadrillas`
  ADD CONSTRAINT `contratista_cuadrillas` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`),
  ADD CONSTRAINT `contrato_cuadrillas` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`),
  ADD CONSTRAINT `mandante_cuadrillas` FOREIGN KEY (`mandante`) REFERENCES `mandantes` (`id_mandante`);

--
-- Filtros para la tabla `desvinculaciones`
--
ALTER TABLE `desvinculaciones`
  ADD CONSTRAINT `contratista_desvinculacion` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`),
  ADD CONSTRAINT `contrato_desvinculacion` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`),
  ADD CONSTRAINT `trabajador_desvinculacion` FOREIGN KEY (`trabajador`) REFERENCES `trabajador` (`idtrabajador`);

--
-- Filtros para la tabla `documentos_extras`
--
ALTER TABLE `documentos_extras`
  ADD CONSTRAINT `contrato_doc_extra` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `documentos_trabajador_contratista`
--
ALTER TABLE `documentos_trabajador_contratista`
  ADD CONSTRAINT `trabajador_documento` FOREIGN KEY (`trabajador`) REFERENCES `trabajador` (`idtrabajador`);

--
-- Filtros para la tabla `documentos_vehiculo_contratista`
--
ALTER TABLE `documentos_vehiculo_contratista`
  ADD CONSTRAINT `auto_doc_contratista` FOREIGN KEY (`vehiculo`) REFERENCES `autos` (`id_auto`);

--
-- Filtros para la tabla `doc_comentarios`
--
ALTER TABLE `doc_comentarios`
  ADD CONSTRAINT `contratista_doc_comentarios` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `doc_comentarios_desvinculaciones`
--
ALTER TABLE `doc_comentarios_desvinculaciones`
  ADD CONSTRAINT `contratista_doc_comentarios_desvinculaciones` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `doc_comentarios_extra`
--
ALTER TABLE `doc_comentarios_extra`
  ADD CONSTRAINT `contratista_doc_comentarios_desvinculaciones_extra` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `doc_comentarios_mensual`
--
ALTER TABLE `doc_comentarios_mensual`
  ADD CONSTRAINT `contrato_doc_comentarios_desvinculaciones_mensual` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `doc_observaciones`
--
ALTER TABLE `doc_observaciones`
  ADD CONSTRAINT `contratista_doc_observaciones` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `doc_observaciones_extra`
--
ALTER TABLE `doc_observaciones_extra`
  ADD CONSTRAINT `contratista_observaciones_extra` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `doc_subidos_contratista`
--
ALTER TABLE `doc_subidos_contratista`
  ADD CONSTRAINT `contratista_doc_subidos` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `epp`
--
ALTER TABLE `epp`
  ADD CONSTRAINT `contratista_epp` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `mensuales`
--
ALTER TABLE `mensuales`
  ADD CONSTRAINT `contratista_mensuales` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `mensuales_trabajador`
--
ALTER TABLE `mensuales_trabajador`
  ADD CONSTRAINT `trabajador_mensuales` FOREIGN KEY (`trabajador`) REFERENCES `trabajador` (`idtrabajador`);

--
-- Filtros para la tabla `noaplica`
--
ALTER TABLE `noaplica`
  ADD CONSTRAINT `cantratista_noaplica` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`),
  ADD CONSTRAINT `trabajador_noaplica` FOREIGN KEY (`trabajador`) REFERENCES `trabajador` (`idtrabajador`);

--
-- Filtros para la tabla `noaplica_trabajador`
--
ALTER TABLE `noaplica_trabajador`
  ADD CONSTRAINT `contratista_noaplica_trabajador` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`),
  ADD CONSTRAINT `trabajador_noaplica_trabajador` FOREIGN KEY (`trabajador`) REFERENCES `trabajador` (`idtrabajador`);

--
-- Filtros para la tabla `noaplica_vehiculo`
--
ALTER TABLE `noaplica_vehiculo`
  ADD CONSTRAINT `auto_noaplica_vehiculo` FOREIGN KEY (`vehiculo`) REFERENCES `autos` (`id_auto`),
  ADD CONSTRAINT `contratista_noaplica_vehiculo` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `mandante_perfiles` FOREIGN KEY (`id_mandante`) REFERENCES `mandantes` (`id_mandante`);

--
-- Filtros para la tabla `perfiles_cargos`
--
ALTER TABLE `perfiles_cargos`
  ADD CONSTRAINT `contrato_perfiles_cargo` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `perfiles_vehiculos`
--
ALTER TABLE `perfiles_vehiculos`
  ADD CONSTRAINT `contrato_perfiles_vehiclos` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD CONSTRAINT `contratista_trabajador` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `trabajadores_acreditados`
--
ALTER TABLE `trabajadores_acreditados`
  ADD CONSTRAINT `contrato_trabajador_acreditado` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `trabajadores_asignados`
--
ALTER TABLE `trabajadores_asignados`
  ADD CONSTRAINT `contrato_trabajador_asignado` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `trabajadores_desvinculados`
--
ALTER TABLE `trabajadores_desvinculados`
  ADD CONSTRAINT `contrato_trabajadores_desvinculados` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `trabajador_desvinculado_detalle`
--
ALTER TABLE `trabajador_desvinculado_detalle`
  ADD CONSTRAINT `contrato_trabajador_desvinculado` FOREIGN KEY (`contrato`) REFERENCES `contratos` (`id_contrato`);

--
-- Filtros para la tabla `vehiculos_acreditados`
--
ALTER TABLE `vehiculos_acreditados`
  ADD CONSTRAINT `auto_acreditado` FOREIGN KEY (`vehiculo`) REFERENCES `autos` (`id_auto`),
  ADD CONSTRAINT `contratista_autos_acreditados` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);

--
-- Filtros para la tabla `vehiculos_asignados`
--
ALTER TABLE `vehiculos_asignados`
  ADD CONSTRAINT `auto_asignados` FOREIGN KEY (`vehiculos`) REFERENCES `autos` (`id_auto`),
  ADD CONSTRAINT `contratista_autos_asignados` FOREIGN KEY (`contratista`) REFERENCES `contratistas` (`id_contratista`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
