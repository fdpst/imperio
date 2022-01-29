-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-04-2021 a las 07:05:22
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chicharro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  `cat_profit` decimal(5,2) DEFAULT NULL,
  `imagen_url` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `orden`, `cat_profit`, `imagen_url`, `created_at`, `updated_at`) VALUES
(3, 'Alimentación', 1, '20.00', '1596831553_5f2db74128311.jpeg', '2020-08-08 02:19:13', '2021-03-31 13:55:55'),
(4, 'Alcohol', 2, '7.00', '1617198450_60647d72b71ad.jpeg', '2020-08-28 02:22:07', '2021-04-19 16:50:06'),
(5, 'Bonus', 3, '4.00', '1618401404_6076d87c353a0.jpeg', '2021-04-14 11:56:44', '2021-04-14 11:56:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_postal` int(5) DEFAULT NULL,
  `provincia_id` int(4) DEFAULT NULL,
  `localidad` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `dni`, `email`, `telefono`, `direccion`, `codigo_postal`, `provincia_id`, `localidad`, `created_at`, `updated_at`) VALUES
(8, 'cliente nuevo', '246127', NULL, NULL, 'calle 14 56 56', NULL, NULL, NULL, '2020-08-18 19:42:18', '2020-08-18 19:42:18'),
(9, 'cliente nuevo', '123', 'mail@mail.com', '12565', 'direccion calle 5', 5001, 2, 'localidad', '2020-08-28 20:40:28', '2020-08-28 20:40:28'),
(10, 'pepe', '444685946', NULL, NULL, 'londres', NULL, NULL, NULL, '2021-03-29 07:55:15', '2021-03-29 07:55:15'),
(11, 'Moments 1984 S.L.', '44444444k', 'a@a.com', '666666666', 'londres 26', 46023, 1, 'provincia uno', '2021-03-29 07:56:28', '2021-03-30 10:22:52'),
(12, 'pepe perz', '44444445k', 'a@a.com', '65465564', 'aqui', 3181, 1, 'aa', '2021-04-12 12:37:02', '2021-04-12 12:37:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_vacaciones`
--

DROP TABLE IF EXISTS `empleado_vacaciones`;
CREATE TABLE IF NOT EXISTS `empleado_vacaciones` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `empleado_id` int(11) NOT NULL,
  `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cif` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cita_id` int(11) NOT NULL,
  `turno_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_recibida`
--

DROP TABLE IF EXISTS `factura_recibida`;
CREATE TABLE IF NOT EXISTS `factura_recibida` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_factura` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `total` double(11,2) NOT NULL,
  `url` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'temporal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `factura_recibida`
--

INSERT INTO `factura_recibida` (`id`, `cliente`, `numero_factura`, `total`, `url`, `created_at`, `updated_at`) VALUES
(2, 'dos', '0506', 50.00, '1597428073_5f36d169c7e2f.png', '2020-08-15 00:01:13', '2020-08-15 00:01:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_legal`
--

DROP TABLE IF EXISTS `informacion_legal`;
CREATE TABLE IF NOT EXISTS `informacion_legal` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `informacion_legal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informacion_legal`
--

INSERT INTO `informacion_legal` (`id`, `informacion_legal`, `created_at`, `updated_at`) VALUES
(1, 'Aristoi Academy\nC/ Foguerer 5 \n03012 Alicante\nB42667824', '2020-06-13 21:12:57', '2020-06-13 21:16:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cita_id` int(11) DEFAULT NULL,
  `concepto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

DROP TABLE IF EXISTS `iva`;
CREATE TABLE IF NOT EXISTS `iva` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `iva` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`id`, `iva`, `created_at`, `updated_at`) VALUES
(1, 21, '2020-08-11 04:40:51', '2020-08-11 04:40:51'),
(2, 10, '2020-08-11 04:40:57', '2020-08-11 04:40:57'),
(3, 4, '2020-08-11 04:41:02', '2020-08-11 04:44:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2020_05_11_113931_create_empleado_table', 2),
(5, '2020_05_11_133144_create_servicio_table', 3),
(7, '2020_05_11_151137_create_eventos_table', 4),
(9, '2020_05_13_082309_create_turno_table', 5),
(11, '2020_05_14_122151_create_agenda_table', 6),
(12, '2020_05_17_151507_create_cliente_table', 7),
(14, '2020_05_20_001241_create_stock_table', 8),
(16, '2020_05_24_130559_create_empleado_vacaciones_table', 10),
(17, '2020_05_26_071521_create_tipo_table', 11),
(19, '2020_05_26_114837_create_empresa_table', 13),
(21, '2020_05_26_181957_create_recibo_table', 15),
(22, '2020_05_26_184454_create_recibo_stock_tabla', 16),
(23, '2018_08_08_100000_create_telescope_entries_table', 17),
(24, '2020_06_01_001721_create_cita_table', 18),
(25, '2020_06_01_213559_create_hora_dia_table', 19),
(26, '2020_05_23_140745_create_agenda_stock_table', 20),
(27, '2020_06_08_133212_create_dias_inactivos_table', 21),
(28, '2020_06_12_193708_create_informacion_legal_table', 21),
(29, '2020_06_13_222504_create_factura_emitida_table', 22),
(31, '2020_06_14_160547_create_ingresos_table', 23),
(32, '2020_07_02_153741_create_provincia_table', 24),
(34, '2020_05_25_123741_create_factura_table', 25),
(35, '2020_08_07_003045_create_factura_producto_table', 26),
(37, '2020_08_07_183713_create_categoria_table', 27),
(38, '2020_08_10_221825_create_iva_table', 28),
(39, '2020_08_16_203930_create_nro_ticket_table', 29),
(40, '2020_08_16_204026_create_nro_factura_table', 29),
(42, '2020_08_19_005326_create_presupuesto_table', 30),
(46, '2020_09_17_132138_create_venta_nro_ticket_id_table', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nro_factura`
--

DROP TABLE IF EXISTS `nro_factura`;
CREATE TABLE IF NOT EXISTS `nro_factura` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `nro_factura`
--

INSERT INTO `nro_factura` (`id`, `venta_id`, `nro_factura`, `created_at`, `updated_at`) VALUES
(9, 16, 2, '2020-09-17 06:23:05', '2020-09-17 06:23:05'),
(10, 17, 3, '2020-09-17 06:32:03', '2020-09-17 06:32:03'),
(11, 18, 4, '2020-09-17 06:32:25', '2020-09-17 06:32:25'),
(12, 19, 5, '2020-09-17 06:32:45', '2020-09-17 06:32:45'),
(13, 20, 6, '2020-09-17 06:44:57', '2020-09-17 06:44:57'),
(14, 25, 7, '2020-09-17 06:49:03', '2020-09-17 06:49:04'),
(15, 26, 8, '2020-09-17 17:08:14', '2020-09-17 17:08:14'),
(16, 27, 9, '2020-09-17 17:45:02', '2020-09-17 17:45:02'),
(17, 28, 10, '2020-09-17 17:45:23', '2020-09-17 17:45:23'),
(18, 29, 11, '2020-09-17 17:46:29', '2020-09-17 17:46:29'),
(19, 30, 12, '2020-09-17 17:48:01', '2020-09-17 17:48:01'),
(20, 31, 13, '2020-09-17 17:48:27', '2020-09-17 17:48:27'),
(21, 32, 14, '2020-09-17 17:49:41', '2020-09-17 17:49:41'),
(22, 33, 15, '2020-09-17 17:52:59', '2020-09-17 17:52:59'),
(23, 34, 16, '2020-09-17 17:54:12', '2020-09-17 17:54:12'),
(24, 35, 17, '2020-09-17 17:54:21', '2020-09-17 17:54:21'),
(25, 39, 18, '2020-09-17 17:56:16', '2020-09-17 17:56:16'),
(26, 41, 18, '2021-03-29 09:36:19', '2021-03-29 09:36:19'),
(32, 53, 19, '2021-03-29 13:57:20', '2021-03-29 13:57:20'),
(46, 69, 20, '2021-03-29 15:03:59', '2021-03-29 15:03:59'),
(52, 75, 21, '2021-03-29 16:47:15', '2021-03-29 16:47:15'),
(62, 85, 22, '2021-03-30 09:06:08', '2021-03-30 09:06:08'),
(63, 86, 23, '2021-03-30 09:23:33', '2021-03-30 09:23:33'),
(64, 87, 24, '2021-03-30 09:23:35', '2021-03-30 09:23:35'),
(65, 88, 25, '2021-03-30 09:45:13', '2021-03-30 09:45:13'),
(77, 103, 26, '2021-03-30 13:56:13', '2021-03-30 13:56:13'),
(108, 102, 28, '2021-03-30 15:21:58', '2021-03-30 15:21:58'),
(109, 290, 28, '2021-04-07 16:35:27', '2021-04-07 16:35:27'),
(111, 299, 29, '2021-04-08 15:10:24', '2021-04-08 15:10:24'),
(112, 301, 30, '2021-04-08 15:15:10', '2021-04-08 15:15:10'),
(113, 313, 31, '2021-04-08 16:21:45', '2021-04-08 16:21:45'),
(114, 320, 32, '2021-04-08 16:47:35', '2021-04-08 16:47:35'),
(115, 340, 33, '2021-04-09 07:30:25', '2021-04-09 07:30:25'),
(116, 342, 34, '2021-04-09 07:32:04', '2021-04-09 07:32:04'),
(117, 345, 35, '2021-04-09 07:33:45', '2021-04-09 07:33:45'),
(118, 346, 36, '2021-04-09 07:34:59', '2021-04-09 07:34:59'),
(121, 353, 37, '2021-04-09 08:39:12', '2021-04-09 08:39:12'),
(122, 356, 38, '2021-04-09 08:41:58', '2021-04-09 08:41:58'),
(123, 359, 39, '2021-04-09 08:46:30', '2021-04-09 08:46:30'),
(124, 362, 40, '2021-04-12 10:06:04', '2021-04-12 10:06:04'),
(125, 449, 41, '2021-04-12 14:06:02', '2021-04-12 14:06:02'),
(126, 454, 42, '2021-04-12 14:12:32', '2021-04-12 14:12:32'),
(127, 458, 43, '2021-04-12 14:24:49', '2021-04-12 14:24:49'),
(128, 484, 44, '2021-04-12 15:10:02', '2021-04-12 15:10:02'),
(129, 491, 45, '2021-04-12 15:25:16', '2021-04-12 15:25:16'),
(130, 497, 46, '2021-04-12 15:31:11', '2021-04-12 15:31:11'),
(131, 512, 47, '2021-04-12 16:06:04', '2021-04-12 16:06:04'),
(132, 536, 48, '2021-04-13 15:01:10', '2021-04-13 15:01:10'),
(133, 538, 49, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(134, 542, 50, '2021-04-13 16:41:46', '2021-04-13 16:41:46'),
(135, 541, 51, '2021-04-15 11:42:51', '2021-04-15 11:42:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nro_ticket`
--

DROP TABLE IF EXISTS `nro_ticket`;
CREATE TABLE IF NOT EXISTS `nro_ticket` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nro_ticket`
--

INSERT INTO `nro_ticket` (`id`, `venta_id`, `created_at`, `updated_at`) VALUES
(8, 36, '2020-09-17 17:55:29', '2020-09-17 17:55:29'),
(9, 37, '2020-09-17 17:55:42', '2020-09-17 17:55:42'),
(10, 38, '2020-09-17 17:55:58', '2020-09-17 17:55:58'),
(11, 40, '2021-03-29 07:03:53', '2021-03-29 07:03:53'),
(12, 55, '2021-03-29 13:57:31', '2021-03-29 13:57:31'),
(13, 100, '2021-03-30 11:53:06', '2021-03-30 11:53:06'),
(14, 101, '2021-03-30 11:53:25', '2021-03-30 11:53:25'),
(15, 102, '2021-03-30 11:53:36', '2021-03-30 11:53:36'),
(16, 158, '2021-03-30 16:26:58', '2021-03-30 16:26:58'),
(17, 160, '2021-03-31 14:46:18', '2021-03-31 14:46:18'),
(31, 178, '2021-03-31 15:26:11', '2021-03-31 15:26:11'),
(32, 179, '2021-03-31 15:26:51', '2021-03-31 15:26:51'),
(46, 193, '2021-03-31 15:58:54', '2021-03-31 15:58:54'),
(50, 197, '2021-03-31 16:14:03', '2021-03-31 16:14:03'),
(62, 211, '2021-03-31 16:28:36', '2021-03-31 16:28:36'),
(63, 212, '2021-03-31 16:29:38', '2021-03-31 16:29:38'),
(99, 248, '2021-03-31 17:01:05', '2021-03-31 17:01:05'),
(100, 249, '2021-03-31 17:02:56', '2021-03-31 17:02:56'),
(101, 250, '2021-04-01 07:25:30', '2021-04-01 07:25:30'),
(102, 251, '2021-04-01 07:26:16', '2021-04-01 07:26:16'),
(103, 252, '2021-04-01 07:41:47', '2021-04-01 07:41:47'),
(104, 253, '2021-04-01 07:45:56', '2021-04-01 07:45:56'),
(105, 254, '2021-04-01 07:53:31', '2021-04-01 07:53:31'),
(106, 255, '2021-04-01 07:55:39', '2021-04-01 07:55:39'),
(107, 256, '2021-04-01 07:56:03', '2021-04-01 07:56:03'),
(108, 257, '2021-04-01 07:59:23', '2021-04-01 07:59:23'),
(109, 258, '2021-04-01 07:59:23', '2021-04-01 07:59:23'),
(110, 259, '2021-04-01 07:59:40', '2021-04-01 07:59:40'),
(111, 260, '2021-04-01 08:05:46', '2021-04-01 08:05:46'),
(112, 261, '2021-04-01 08:09:05', '2021-04-01 08:09:05'),
(113, 262, '2021-04-01 08:15:44', '2021-04-01 08:15:44'),
(114, 263, '2021-04-01 08:17:24', '2021-04-01 08:17:24'),
(115, 264, '2021-04-01 08:17:40', '2021-04-01 08:17:40'),
(116, 265, '2021-04-01 08:17:58', '2021-04-01 08:17:58'),
(117, 266, '2021-04-01 08:18:16', '2021-04-01 08:18:16'),
(118, 267, '2021-04-01 08:18:35', '2021-04-01 08:18:35'),
(119, 268, '2021-04-01 08:18:54', '2021-04-01 08:18:54'),
(120, 269, '2021-04-01 08:19:11', '2021-04-01 08:19:11'),
(121, 270, '2021-04-01 08:25:21', '2021-04-01 08:25:21'),
(122, 271, '2021-04-01 08:26:00', '2021-04-01 08:26:00'),
(123, 272, '2021-04-01 08:26:00', '2021-04-01 08:26:00'),
(124, 273, '2021-04-01 08:37:19', '2021-04-01 08:37:19'),
(125, 274, '2021-04-01 08:37:53', '2021-04-01 08:37:53'),
(126, 275, '2021-04-01 08:40:40', '2021-04-01 08:40:40'),
(127, 276, '2021-04-01 08:41:06', '2021-04-01 08:41:06'),
(128, 277, '2021-04-01 08:42:52', '2021-04-01 08:42:52'),
(129, 278, '2021-04-01 08:43:18', '2021-04-01 08:43:18'),
(130, 279, '2021-04-01 08:43:44', '2021-04-01 08:43:44'),
(131, 280, '2021-04-01 08:43:55', '2021-04-01 08:43:55'),
(132, 281, '2021-04-01 08:45:44', '2021-04-01 08:45:44'),
(135, 289, '2021-04-01 12:06:04', '2021-04-01 12:06:04'),
(136, 292, '2021-04-08 10:27:22', '2021-04-08 10:27:22'),
(137, 293, '2021-04-08 11:14:56', '2021-04-08 11:14:56'),
(138, 294, '2021-04-08 11:22:06', '2021-04-08 11:22:06'),
(139, 295, '2021-04-08 13:33:33', '2021-04-08 13:33:33'),
(140, 296, '2021-04-08 13:33:48', '2021-04-08 13:33:48'),
(141, 297, '2021-04-08 13:34:03', '2021-04-08 13:34:03'),
(142, 298, '2021-04-08 15:09:53', '2021-04-08 15:09:53'),
(143, 300, '2021-04-08 15:14:01', '2021-04-08 15:14:01'),
(144, 303, '2021-04-08 15:19:49', '2021-04-08 15:19:49'),
(145, 304, '2021-04-08 15:42:34', '2021-04-08 15:42:34'),
(146, 305, '2021-04-08 15:42:48', '2021-04-08 15:42:48'),
(147, 306, '2021-04-08 16:12:46', '2021-04-08 16:12:46'),
(148, 307, '2021-04-08 16:13:09', '2021-04-08 16:13:09'),
(149, 308, '2021-04-08 16:14:38', '2021-04-08 16:14:38'),
(150, 309, '2021-04-08 16:16:20', '2021-04-08 16:16:20'),
(151, 310, '2021-04-08 16:17:29', '2021-04-08 16:17:29'),
(152, 311, '2021-04-08 16:17:47', '2021-04-08 16:17:47'),
(153, 312, '2021-04-08 16:19:39', '2021-04-08 16:19:39'),
(154, 314, '2021-04-08 16:23:35', '2021-04-08 16:23:35'),
(155, 315, '2021-04-08 16:25:09', '2021-04-08 16:25:09'),
(156, 316, '2021-04-08 16:25:59', '2021-04-08 16:25:59'),
(157, 317, '2021-04-08 16:26:09', '2021-04-08 16:26:09'),
(158, 318, '2021-04-08 16:27:02', '2021-04-08 16:27:02'),
(159, 319, '2021-04-08 16:40:53', '2021-04-08 16:40:53'),
(160, 321, '2021-04-08 16:48:44', '2021-04-08 16:48:44'),
(161, 322, '2021-04-08 16:49:01', '2021-04-08 16:49:01'),
(162, 323, '2021-04-08 16:49:48', '2021-04-08 16:49:48'),
(163, 324, '2021-04-08 16:50:24', '2021-04-08 16:50:24'),
(164, 325, '2021-04-08 16:50:51', '2021-04-08 16:50:51'),
(165, 326, '2021-04-08 16:51:43', '2021-04-08 16:51:43'),
(166, 327, '2021-04-08 16:52:07', '2021-04-08 16:52:07'),
(167, 328, '2021-04-08 16:52:45', '2021-04-08 16:52:45'),
(168, 329, '2021-04-08 16:57:04', '2021-04-08 16:57:04'),
(169, 330, '2021-04-08 16:57:42', '2021-04-08 16:57:42'),
(170, 331, '2021-04-08 16:58:32', '2021-04-08 16:58:32'),
(171, 332, '2021-04-08 16:59:43', '2021-04-08 16:59:43'),
(172, 333, '2021-04-08 17:01:06', '2021-04-08 17:01:06'),
(173, 334, '2021-04-08 17:01:58', '2021-04-08 17:01:58'),
(174, 335, '2021-04-08 17:02:08', '2021-04-08 17:02:08'),
(175, 336, '2021-04-08 17:02:36', '2021-04-08 17:02:36'),
(176, 337, '2021-04-09 07:14:23', '2021-04-09 07:14:23'),
(177, 338, '2021-04-09 07:23:52', '2021-04-09 07:23:52'),
(178, 339, '2021-04-09 07:28:50', '2021-04-09 07:28:50'),
(179, 341, '2021-04-09 07:31:24', '2021-04-09 07:31:24'),
(180, 344, '2021-04-09 07:32:49', '2021-04-09 07:32:49'),
(181, 348, '2021-04-09 07:35:18', '2021-04-09 07:35:18'),
(182, 349, '2021-04-09 08:06:50', '2021-04-09 08:06:50'),
(183, 352, '2021-04-09 08:38:52', '2021-04-09 08:38:52'),
(184, 354, '2021-04-09 08:39:40', '2021-04-09 08:39:40'),
(185, 355, '2021-04-09 08:41:42', '2021-04-09 08:41:42'),
(186, 360, '2021-04-12 10:04:15', '2021-04-12 10:04:15'),
(187, 361, '2021-04-12 10:05:18', '2021-04-12 10:05:18'),
(188, 363, '2021-04-12 10:06:48', '2021-04-12 10:06:48'),
(189, 364, '2021-04-12 10:08:22', '2021-04-12 10:08:22'),
(190, 365, '2021-04-12 10:12:44', '2021-04-12 10:12:44'),
(191, 366, '2021-04-12 10:13:15', '2021-04-12 10:13:15'),
(192, 367, '2021-04-12 10:17:34', '2021-04-12 10:17:34'),
(193, 368, '2021-04-12 10:17:52', '2021-04-12 10:17:52'),
(194, 369, '2021-04-12 10:19:16', '2021-04-12 10:19:16'),
(195, 370, '2021-04-12 10:19:38', '2021-04-12 10:19:38'),
(196, 371, '2021-04-12 10:20:05', '2021-04-12 10:20:05'),
(197, 372, '2021-04-12 10:20:41', '2021-04-12 10:20:41'),
(198, 373, '2021-04-12 10:20:56', '2021-04-12 10:20:56'),
(199, 374, '2021-04-12 10:21:18', '2021-04-12 10:21:18'),
(200, 375, '2021-04-12 10:23:34', '2021-04-12 10:23:34'),
(201, 376, '2021-04-12 10:24:14', '2021-04-12 10:24:14'),
(202, 377, '2021-04-12 10:24:41', '2021-04-12 10:24:41'),
(203, 378, '2021-04-12 10:25:11', '2021-04-12 10:25:11'),
(204, 379, '2021-04-12 10:26:03', '2021-04-12 10:26:03'),
(205, 380, '2021-04-12 10:26:29', '2021-04-12 10:26:29'),
(206, 381, '2021-04-12 10:26:59', '2021-04-12 10:26:59'),
(207, 382, '2021-04-12 10:27:17', '2021-04-12 10:27:17'),
(208, 383, '2021-04-12 10:28:03', '2021-04-12 10:28:03'),
(209, 384, '2021-04-12 10:28:39', '2021-04-12 10:28:39'),
(210, 385, '2021-04-12 10:29:12', '2021-04-12 10:29:12'),
(211, 386, '2021-04-12 10:29:34', '2021-04-12 10:29:34'),
(212, 387, '2021-04-12 10:31:18', '2021-04-12 10:31:18'),
(213, 388, '2021-04-12 10:32:08', '2021-04-12 10:32:08'),
(214, 389, '2021-04-12 10:32:23', '2021-04-12 10:32:23'),
(215, 390, '2021-04-12 10:32:43', '2021-04-12 10:32:43'),
(216, 391, '2021-04-12 10:34:31', '2021-04-12 10:34:31'),
(217, 392, '2021-04-12 10:35:36', '2021-04-12 10:35:36'),
(218, 393, '2021-04-12 10:36:27', '2021-04-12 10:36:27'),
(219, 394, '2021-04-12 10:37:45', '2021-04-12 10:37:45'),
(220, 395, '2021-04-12 10:38:17', '2021-04-12 10:38:17'),
(221, 396, '2021-04-12 10:39:15', '2021-04-12 10:39:15'),
(222, 397, '2021-04-12 10:39:27', '2021-04-12 10:39:27'),
(223, 398, '2021-04-12 10:39:51', '2021-04-12 10:39:51'),
(224, 399, '2021-04-12 10:40:05', '2021-04-12 10:40:05'),
(225, 400, '2021-04-12 10:40:25', '2021-04-12 10:40:25'),
(226, 401, '2021-04-12 10:41:03', '2021-04-12 10:41:03'),
(227, 402, '2021-04-12 10:41:13', '2021-04-12 10:41:13'),
(228, 403, '2021-04-12 10:49:54', '2021-04-12 10:49:54'),
(229, 404, '2021-04-12 10:51:53', '2021-04-12 10:51:53'),
(230, 405, '2021-04-12 10:55:06', '2021-04-12 10:55:06'),
(231, 406, '2021-04-12 10:56:05', '2021-04-12 10:56:05'),
(232, 407, '2021-04-12 10:57:43', '2021-04-12 10:57:43'),
(233, 408, '2021-04-12 11:01:04', '2021-04-12 11:01:04'),
(234, 409, '2021-04-12 11:02:13', '2021-04-12 11:02:13'),
(242, 417, '2021-04-12 11:20:59', '2021-04-12 11:20:59'),
(243, 418, '2021-04-12 11:21:37', '2021-04-12 11:21:37'),
(262, 437, '2021-04-12 13:53:12', '2021-04-12 13:53:12'),
(263, 438, '2021-04-12 13:54:18', '2021-04-12 13:54:18'),
(264, 439, '2021-04-12 13:54:55', '2021-04-12 13:54:55'),
(265, 440, '2021-04-12 13:55:22', '2021-04-12 13:55:22'),
(266, 441, '2021-04-12 13:56:14', '2021-04-12 13:56:14'),
(267, 442, '2021-04-12 13:57:28', '2021-04-12 13:57:28'),
(268, 443, '2021-04-12 13:59:15', '2021-04-12 13:59:15'),
(269, 444, '2021-04-12 14:00:15', '2021-04-12 14:00:15'),
(270, 445, '2021-04-12 14:01:28', '2021-04-12 14:01:28'),
(271, 446, '2021-04-12 14:02:07', '2021-04-12 14:02:07'),
(272, 447, '2021-04-12 14:02:53', '2021-04-12 14:02:53'),
(273, 448, '2021-04-12 14:04:27', '2021-04-12 14:04:27'),
(274, 450, '2021-04-12 14:08:14', '2021-04-12 14:08:14'),
(275, 451, '2021-04-12 14:11:26', '2021-04-12 14:11:26'),
(276, 452, '2021-04-12 14:12:07', '2021-04-12 14:12:07'),
(277, 455, '2021-04-12 14:12:39', '2021-04-12 14:12:39'),
(278, 456, '2021-04-12 14:13:21', '2021-04-12 14:13:21'),
(279, 457, '2021-04-12 14:24:32', '2021-04-12 14:24:32'),
(281, 461, '2021-04-12 14:29:25', '2021-04-12 14:29:25'),
(282, 462, '2021-04-12 14:30:21', '2021-04-12 14:30:21'),
(283, 463, '2021-04-12 14:30:41', '2021-04-12 14:30:41'),
(284, 464, '2021-04-12 14:31:17', '2021-04-12 14:31:17'),
(285, 465, '2021-04-12 14:33:56', '2021-04-12 14:33:56'),
(288, 468, '2021-04-12 14:40:37', '2021-04-12 14:40:37'),
(289, 469, '2021-04-12 14:52:09', '2021-04-12 14:52:09'),
(290, 470, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(291, 471, '2021-04-12 14:52:57', '2021-04-12 14:52:57'),
(292, 472, '2021-04-12 14:54:39', '2021-04-12 14:54:39'),
(293, 473, '2021-04-12 14:55:13', '2021-04-12 14:55:13'),
(294, 474, '2021-04-12 14:55:45', '2021-04-12 14:55:45'),
(295, 475, '2021-04-12 14:56:06', '2021-04-12 14:56:06'),
(296, 476, '2021-04-12 14:58:18', '2021-04-12 14:58:18'),
(297, 477, '2021-04-12 14:58:43', '2021-04-12 14:58:43'),
(298, 478, '2021-04-12 14:59:11', '2021-04-12 14:59:11'),
(299, 479, '2021-04-12 14:59:36', '2021-04-12 14:59:36'),
(300, 480, '2021-04-12 15:00:25', '2021-04-12 15:00:25'),
(301, 481, '2021-04-12 15:04:46', '2021-04-12 15:04:46'),
(302, 482, '2021-04-12 15:05:09', '2021-04-12 15:05:09'),
(303, 483, '2021-04-12 15:06:33', '2021-04-12 15:06:33'),
(304, 485, '2021-04-12 15:10:43', '2021-04-12 15:10:43'),
(305, 486, '2021-04-12 15:11:45', '2021-04-12 15:11:45'),
(306, 487, '2021-04-12 15:12:25', '2021-04-12 15:12:25'),
(307, 488, '2021-04-12 15:20:11', '2021-04-12 15:20:11'),
(308, 489, '2021-04-12 15:20:39', '2021-04-12 15:20:39'),
(309, 490, '2021-04-12 15:24:51', '2021-04-12 15:24:51'),
(310, 493, '2021-04-12 15:26:30', '2021-04-12 15:26:30'),
(311, 496, '2021-04-12 15:30:53', '2021-04-12 15:30:53'),
(312, 498, '2021-04-12 15:32:39', '2021-04-12 15:32:39'),
(313, 499, '2021-04-12 15:35:49', '2021-04-12 15:35:49'),
(314, 500, '2021-04-12 15:42:30', '2021-04-12 15:42:30'),
(315, 501, '2021-04-12 15:44:03', '2021-04-12 15:44:03'),
(316, 502, '2021-04-12 15:44:31', '2021-04-12 15:44:31'),
(317, 503, '2021-04-12 15:45:00', '2021-04-12 15:45:00'),
(318, 504, '2021-04-12 15:45:21', '2021-04-12 15:45:21'),
(319, 505, '2021-04-12 15:45:40', '2021-04-12 15:45:40'),
(320, 506, '2021-04-12 15:46:16', '2021-04-12 15:46:16'),
(321, 507, '2021-04-12 15:46:37', '2021-04-12 15:46:37'),
(322, 508, '2021-04-12 15:55:00', '2021-04-12 15:55:00'),
(323, 509, '2021-04-12 15:55:26', '2021-04-12 15:55:26'),
(324, 510, '2021-04-12 16:02:51', '2021-04-12 16:02:51'),
(325, 511, '2021-04-12 16:05:33', '2021-04-12 16:05:33'),
(326, 513, '2021-04-12 16:14:56', '2021-04-12 16:14:56'),
(327, 514, '2021-04-12 16:15:30', '2021-04-12 16:15:30'),
(328, 515, '2021-04-13 07:12:34', '2021-04-13 07:12:34'),
(329, 516, '2021-04-13 07:36:48', '2021-04-13 07:36:48'),
(330, 517, '2021-04-13 07:42:30', '2021-04-13 07:42:30'),
(331, 518, '2021-04-13 07:43:10', '2021-04-13 07:43:10'),
(332, 519, '2021-04-13 07:44:01', '2021-04-13 07:44:01'),
(333, 520, '2021-04-13 08:11:21', '2021-04-13 08:11:21'),
(334, 521, '2021-04-13 08:11:31', '2021-04-13 08:11:31'),
(335, 522, '2021-04-13 08:12:05', '2021-04-13 08:12:05'),
(336, 523, '2021-04-13 08:13:06', '2021-04-13 08:13:06'),
(337, 524, '2021-04-13 08:13:25', '2021-04-13 08:13:25'),
(338, 525, '2021-04-13 08:14:04', '2021-04-13 08:14:04'),
(339, 526, '2021-04-13 08:16:31', '2021-04-13 08:16:31'),
(340, 527, '2021-04-13 08:18:15', '2021-04-13 08:18:15'),
(341, 528, '2021-04-13 08:20:33', '2021-04-13 08:20:33'),
(342, 529, '2021-04-13 08:21:37', '2021-04-13 08:21:37'),
(343, 530, '2021-04-13 08:22:49', '2021-04-13 08:22:49'),
(344, 531, '2021-04-13 08:24:04', '2021-04-13 08:24:04'),
(345, 532, '2021-04-13 08:24:24', '2021-04-13 08:24:24'),
(346, 533, '2021-04-13 08:25:34', '2021-04-13 08:25:34'),
(347, 534, '2021-04-13 08:25:48', '2021-04-13 08:25:48'),
(348, 535, '2021-04-13 08:27:47', '2021-04-13 08:27:47'),
(349, 539, '2021-04-13 16:38:24', '2021-04-13 16:38:24'),
(350, 540, '2021-04-13 16:38:47', '2021-04-13 16:38:47'),
(351, 541, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(352, 543, '2021-04-15 11:43:30', '2021-04-15 11:43:30'),
(353, 544, '2021-04-15 11:45:16', '2021-04-15 11:45:16'),
(354, 545, '2021-04-15 11:45:52', '2021-04-15 11:45:52'),
(355, 546, '2021-04-15 11:46:18', '2021-04-15 11:46:18'),
(356, 547, '2021-04-15 11:47:02', '2021-04-15 11:47:02'),
(357, 548, '2021-04-15 13:17:05', '2021-04-15 13:17:05'),
(358, 549, '2021-04-15 13:19:00', '2021-04-15 13:19:00'),
(359, 550, '2021-04-15 13:20:47', '2021-04-15 13:20:47'),
(360, 551, '2021-04-15 13:21:17', '2021-04-15 13:21:17'),
(361, 552, '2021-04-15 13:21:51', '2021-04-15 13:21:51'),
(362, 553, '2021-04-15 13:22:12', '2021-04-15 13:22:12'),
(363, 554, '2021-04-15 13:22:43', '2021-04-15 13:22:43'),
(364, 555, '2021-04-15 13:23:50', '2021-04-15 13:23:50'),
(365, 556, '2021-04-15 13:24:30', '2021-04-15 13:24:30'),
(366, 557, '2021-04-15 13:25:11', '2021-04-15 13:25:11'),
(367, 558, '2021-04-15 13:25:32', '2021-04-15 13:25:32'),
(368, 559, '2021-04-15 13:25:45', '2021-04-15 13:25:45'),
(369, 560, '2021-04-15 13:25:58', '2021-04-15 13:25:58'),
(370, 561, '2021-04-15 13:29:19', '2021-04-15 13:29:19'),
(371, 562, '2021-04-15 13:31:21', '2021-04-15 13:31:21'),
(372, 563, '2021-04-15 13:32:01', '2021-04-15 13:32:01'),
(373, 564, '2021-04-15 13:32:38', '2021-04-15 13:32:38'),
(374, 565, '2021-04-15 13:33:07', '2021-04-15 13:33:07'),
(375, 566, '2021-04-15 13:34:10', '2021-04-15 13:34:10'),
(376, 567, '2021-04-15 13:34:29', '2021-04-15 13:34:29'),
(377, 568, '2021-04-15 13:35:53', '2021-04-15 13:35:53'),
(378, 569, '2021-04-15 13:36:21', '2021-04-15 13:36:21'),
(379, 570, '2021-04-15 13:37:21', '2021-04-15 13:37:21'),
(380, 571, '2021-04-15 13:47:50', '2021-04-15 13:47:50'),
(381, 572, '2021-04-15 13:50:42', '2021-04-15 13:50:42'),
(382, 573, '2021-04-15 13:51:26', '2021-04-15 13:51:26'),
(383, 574, '2021-04-15 13:52:31', '2021-04-15 13:52:31'),
(384, 575, '2021-04-15 13:53:28', '2021-04-15 13:53:28'),
(385, 576, '2021-04-15 13:55:38', '2021-04-15 13:55:38'),
(386, 577, '2021-04-15 13:57:44', '2021-04-15 13:57:44'),
(387, 578, '2021-04-15 13:58:40', '2021-04-15 13:58:40'),
(388, 579, '2021-04-15 13:59:40', '2021-04-15 13:59:40'),
(389, 580, '2021-04-15 14:02:03', '2021-04-15 14:02:03'),
(390, 581, '2021-04-15 14:02:37', '2021-04-15 14:02:37'),
(395, 586, '2021-04-15 14:07:27', '2021-04-15 14:07:27'),
(396, 587, '2021-04-15 14:09:15', '2021-04-15 14:09:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 1, 'my-app-token', 'deff37c4f0f4d4d6da39ffce6cd3bd54f3227b0092549debda290547f49bbfbf', '[\"*\"]', NULL, '2020-06-09 04:00:39', '2020-06-09 04:00:39'),
(2, 'App\\User', 1, 'my-app-token', '37ca0f920b991cb00226bb0fb80b81f7fea7c6d8e8ba52235fbe1a5a4a5f8361', '[\"*\"]', NULL, '2020-06-09 04:10:42', '2020-06-09 04:10:42'),
(3, 'App\\User', 1, 'my-app-token', 'cbdb114024d0db7708a4efc4e08e42ff07d059436a9701bea2cf8aa3f5237274', '[\"*\"]', NULL, '2020-06-09 04:16:58', '2020-06-09 04:16:58'),
(4, 'App\\User', 1, 'my-app-token', 'a7fc71e9163ac8ff5d5a674487d0b3254294ade29d1e6e28bbdf5fe2f75a094f', '[\"*\"]', NULL, '2020-06-12 06:06:37', '2020-06-12 06:06:37'),
(5, 'App\\User', 1, 'my-app-token', '6a80da7f8f61094aebd9ae15d24044b3e1e6ed39858f6911c7736d5e8562f5e7', '[\"*\"]', NULL, '2020-07-02 20:29:52', '2020-07-02 20:29:52'),
(6, 'App\\User', 1, 'my-app-token', '7cf2ab43f99829125cb207843580f90a287deea0f5285b68e5c211bfb72cbdea', '[\"*\"]', NULL, '2020-07-02 20:32:04', '2020-07-02 20:32:04'),
(7, 'App\\User', 1, 'my-app-token', '934cd13464584fb521662c65dbc42983a9af3d39b263b2a0d3bd9e62c2191acb', '[\"*\"]', NULL, '2020-07-02 20:32:12', '2020-07-02 20:32:12'),
(8, 'App\\User', 1, 'my-app-token', '93ecf0af91513e17b647832a617125c3bcbb946f762720cca6f8d0384ed01ffd', '[\"*\"]', NULL, '2020-07-02 20:32:42', '2020-07-02 20:32:42'),
(9, 'App\\User', 1, 'my-app-token', 'ba2d4d3ec10e469e6853502059329d43c6e902648f6a6d1fdb9c832a7bbf4ce8', '[\"*\"]', NULL, '2020-07-02 20:33:22', '2020-07-02 20:33:22'),
(10, 'App\\User', 1, 'my-app-token', '1a021db8e8e89e4c92ca23f8273b408c4c8492f05646542e4008b4e9c236a3f2', '[\"*\"]', NULL, '2020-09-16 05:11:46', '2020-09-16 05:11:46'),
(11, 'App\\User', 1, 'my-app-token', '7a2cff2eaf00b3de7752090f09b8ce0d53a1383b77a37ba3289eeb1344cb20fa', '[\"*\"]', NULL, '2020-09-17 05:56:03', '2020-09-17 05:56:03'),
(12, 'App\\User', 1, 'my-app-token', 'f6a9d410220dabc3f85fbada8d4697a818bbdc4c525888dc14417aae3d9da4bc', '[\"*\"]', NULL, '2021-03-26 11:51:22', '2021-03-26 11:51:22'),
(13, 'App\\User', 1, 'my-app-token', 'a7057c1ae1a667aee7bb16022fe93f6fee8e567418c23cd3dc068485f61dae65', '[\"*\"]', NULL, '2021-04-01 16:07:24', '2021-04-01 16:07:24'),
(14, 'App\\User', 1, 'my-app-token', '53ce29c95c5d2e6e7ee7c8ac2c1fce2f89931b66cb1a110dea72e8b8d5d1db9b', '[\"*\"]', NULL, '2021-04-09 07:06:10', '2021-04-09 07:06:10'),
(15, 'App\\User', 1, 'my-app-token', 'd28842c6905d0a9630007824d7efc53a0ac241efdf6bcaaa2eb7ff862e0447d0', '[\"*\"]', NULL, '2021-04-13 13:15:30', '2021-04-13 13:15:30'),
(16, 'App\\User', 1, 'my-app-token', 'bb3357613a1847c2eb671d0c23d423e95edc80c0ede5d649242e9a42e285457b', '[\"*\"]', NULL, '2021-04-14 16:42:00', '2021-04-14 16:42:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto`
--

DROP TABLE IF EXISTS `presupuesto`;
CREATE TABLE IF NOT EXISTS `presupuesto` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `sub_total` double(11,1) NOT NULL DEFAULT '0.0',
  `descuento` double(11,1) NOT NULL DEFAULT '0.0',
  `porcentaje_descuento` double(11,2) NOT NULL DEFAULT '0.00',
  `total` double(11,2) NOT NULL DEFAULT '0.00',
  `url_presupuesto` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

DROP TABLE IF EXISTS `provincia`;
CREATE TABLE IF NOT EXISTS `provincia` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'provincia uno', NULL, NULL),
(2, 'ejemplo dos', NULL, NULL),
(3, 'prueba tres', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

DROP TABLE IF EXISTS `recibo`;
CREATE TABLE IF NOT EXISTS `recibo` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `factura_id` int(11) DEFAULT NULL,
  `numero_recibo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `detalle` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `recibo`
--

INSERT INTO `recibo` (`id`, `factura_id`, `numero_recibo`, `proveedor`, `detalle`, `fecha`, `monto`, `created_at`, `updated_at`) VALUES
(1, NULL, '1', 's', NULL, '2021-04-19 00:00:00', 15, '2021-04-19 07:36:18', '2021-04-19 07:36:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo_stock`
--

DROP TABLE IF EXISTS `recibo_stock`;
CREATE TABLE IF NOT EXISTS `recibo_stock` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recibo_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `cantidad` double(11,2) NOT NULL,
  `precio` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `recibo_stock`
--

INSERT INTO `recibo_stock` (`id`, `recibo_id`, `stock_id`, `cantidad`, `precio`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 15.00, 15, '2021-04-19 07:36:18', '2021-04-19 07:36:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `iva_id` int(11) DEFAULT NULL,
  `codigo` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preciopvd` decimal(5,2) DEFAULT NULL,
  `preciopvdsiva` decimal(5,2) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  `preciosiva` decimal(5,2) DEFAULT NULL,
  `art_profit` decimal(5,2) DEFAULT NULL,
  `cantidad` double(11,2) NOT NULL,
  `imagen_url` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `categoria_id`, `iva_id`, `codigo`, `nombre`, `preciopvd`, `preciopvdsiva`, `precio`, `preciosiva`, `art_profit`, `cantidad`, `imagen_url`, `created_at`, `updated_at`) VALUES
(2, 3, 1, '00000001', 'Frutos secos 250gr', '22.00', '20.00', '30.00', '27.27', '10.00', 69.00, '1618821159_607d402795209.jpeg', '2020-08-25 01:21:59', '2021-04-21 16:53:23'),
(3, 3, 1, '00000002', 'Gominolas', '0.00', '0.00', '48.52', '32.13', '10.00', 54.00, '1618927027_607eddb3a3e91.jpeg', '2020-08-25 00:02:08', '2021-04-21 08:57:26'),
(4, 3, 1, '00000003', 'Papaya escarchada 250gr', '14.52', '12.00', '25.41', '21.00', '0.00', 55.00, '1617198393_60647d391249a.jpeg', '2020-08-23 19:56:57', '2021-04-21 15:16:33'),
(5, 3, 1, '00000004', 'Papaya escarchada 150gr', '46.00', '38.02', '69.46', '46.00', '10.00', 61.00, '1617198409_60647d49dcedf.jpeg', '2020-08-23 19:56:46', '2021-04-21 08:59:40'),
(6, 3, 1, '00000005', 'Mix fruta deshidratada', '49.00', '40.50', '73.99', '49.00', '10.00', 10.00, '1617198418_60647d52cc25d.jpeg', '2020-08-23 19:56:31', '2021-04-21 08:59:50'),
(7, 3, 2, '00000006', 'Frutos secos para ensalada', '14.00', '12.73', '22.90', '16.36', '10.00', 27.00, '1617198287_60647ccf64909.jpeg', '2020-08-19 01:29:18', '2021-04-21 09:00:09'),
(8, 3, 1, '00000007', 'Salmon marinado a la sal', '53.00', '43.80', '65.00', '43.05', '10.00', 17.00, '1617198279_60647cc75da51.jpeg', '2020-08-19 01:29:02', '2021-04-21 09:00:49'),
(9, 3, 2, '00000008', 'Avellanas', '17.00', '15.45', '26.60', '19.00', '10.00', 54.00, '1617198266_60647cbabab26.jpeg', '2020-08-19 01:28:42', '2021-04-21 09:03:44'),
(10, 3, 3, '00000009', 'Macedonia de frutas', '78.00', '75.00', '80.00', '59.70', '10.00', 51.00, '1617198306_60647ce2da950.jpeg', '2020-08-19 01:28:24', '2021-04-21 09:04:01'),
(11, 3, 2, '00000010', 'Burguer para compartir parejas', '35.00', '31.82', '42.00', '30.00', '10.00', 53.00, '1617198254_60647cae67643.jpeg', '2020-08-19 01:28:10', '2021-04-21 09:05:16'),
(12, 3, 1, '00000011', 'Preparado de especias para verduras', '46.00', '38.02', '56.00', '37.09', '10.00', 15.00, '1617198243_60647ca3bd243.jpeg', '2020-08-19 01:27:52', '2021-04-21 09:05:34'),
(13, 3, 1, '00000012', 'Preparado de quinoa con verduras', '26.00', '21.49', '32.00', '21.19', '10.00', 59.00, '1617198231_60647c9759284.jpeg', '2020-08-19 01:27:40', '2021-04-21 09:05:45'),
(14, 3, 3, '00000013', 'Preparado de lechuga mediterranea', '12.00', '11.54', '19.75', '14.74', '10.00', 27.00, '1617198218_60647c8a2f315.jpeg', '2020-08-17 02:19:58', '2021-04-21 09:07:32'),
(15, 3, 2, '00000014', 'Pure calabaza', '26.00', '23.64', '28.60', '20.43', '10.00', 10.00, '1617198208_60647c804f2e4.jpeg', '2020-08-11 05:52:02', '2021-04-21 09:06:04'),
(16, 3, 2, '00000015', 'Tartaleta de fruta', '14.00', '12.73', '17.60', '12.57', '10.00', 10.00, '1617198195_60647c7353aae.jpeg', '2020-08-08 02:19:31', '2021-04-21 09:07:43'),
(17, 4, 1, '00000016', 'Set vino empresa 8 Uds', '148.00', '122.31', '180.00', '127.66', '13.00', 52.00, '1617198557_60647ddd57004.jpeg', '2020-09-17 06:45:46', '2021-04-21 09:06:45'),
(18, 4, 1, '00000017', 'Elias mora Gran reserva 1982', '44.00', '36.36', '54.00', '38.30', '13.00', 84.00, '1617198549_60647dd51d6d4.jpeg', '2020-09-17 06:46:02', '2021-04-21 09:06:52'),
(19, 4, 1, '00000018', 'Vino Alicante', '19.00', '15.70', '23.00', '16.31', '13.00', 63.00, '1617198540_60647dcc799f5.jpeg', '2020-09-17 06:46:19', '2021-04-21 09:06:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.com', '2020-05-10 01:26:28', '$2y$10$joDZY50GdWW68I6TPRgNGucK8nc.jqtwCfKxS6HEOgONMEZRSTZ1y', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE IF NOT EXISTS `venta` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `total_sin_descuento` double(11,2) NOT NULL DEFAULT '0.00',
  `sub_total` double(11,2) NOT NULL DEFAULT '0.00',
  `descuento` double(11,2) NOT NULL DEFAULT '0.00',
  `porcentaje_descuento` double(11,2) NOT NULL DEFAULT '0.00',
  `iva` double(11,2) NOT NULL DEFAULT '0.00',
  `total` double(11,2) NOT NULL DEFAULT '0.00',
  `url_ticket` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_factura` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_presupuesto` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=588 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `cliente_id`, `total_sin_descuento`, `sub_total`, `descuento`, `porcentaje_descuento`, `iva`, `total`, `url_ticket`, `url_factura`, `url_presupuesto`, `created_at`, `updated_at`) VALUES
(437, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607450c89ca82.pdf', NULL, NULL, '2021-04-12 13:53:12', '2021-04-12 13:53:12'),
(438, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074510b1ff34.pdf', NULL, NULL, '2021-04-12 13:54:18', '2021-04-12 13:54:19'),
(439, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074512fbdfc7.pdf', NULL, NULL, '2021-04-12 13:54:55', '2021-04-12 13:54:56'),
(440, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6074514b0d086.pdf', NULL, NULL, '2021-04-12 13:55:22', '2021-04-12 13:55:23'),
(441, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6074517f48a54.pdf', NULL, NULL, '2021-04-12 13:56:14', '2021-04-12 13:56:15'),
(442, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '607451c902cf5.pdf', NULL, NULL, '2021-04-12 13:57:28', '2021-04-12 13:57:29'),
(443, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6074523408160.pdf', NULL, NULL, '2021-04-12 13:59:15', '2021-04-12 13:59:16'),
(444, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074526fce12c.pdf', NULL, NULL, '2021-04-12 14:00:15', '2021-04-12 14:00:16'),
(445, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607452b86fa89.pdf', NULL, NULL, '2021-04-12 14:01:28', '2021-04-12 14:01:28'),
(446, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607452df97908.pdf', NULL, NULL, '2021-04-12 14:02:07', '2021-04-12 14:02:07'),
(447, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074530d707b0.pdf', NULL, NULL, '2021-04-12 14:02:53', '2021-04-12 14:02:53'),
(448, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '6074536c467dd.pdf', NULL, NULL, '2021-04-12 14:04:27', '2021-04-12 14:04:28'),
(449, 11, 25.00, 20.66, 0.00, 0.00, 4.34, 25.00, NULL, '6078580b15464.pdf', NULL, '2021-04-12 14:06:02', '2021-04-15 15:13:15'),
(450, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074544e93b63.pdf', NULL, NULL, '2021-04-12 14:08:14', '2021-04-12 14:08:14'),
(451, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074550f5e402.pdf', NULL, NULL, '2021-04-12 14:11:26', '2021-04-12 14:11:27'),
(452, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074553773b59.pdf', NULL, NULL, '2021-04-12 14:12:07', '2021-04-12 14:12:07'),
(453, 11, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, NULL, NULL, '6074554a5cfad.pdf', '2021-04-12 14:12:26', '2021-04-12 14:12:26'),
(454, 11, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, NULL, '6074555106d52.pdf', NULL, '2021-04-12 14:12:32', '2021-04-12 14:12:33'),
(455, 11, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607455576b061.pdf', NULL, NULL, '2021-04-12 14:12:39', '2021-04-12 14:12:39'),
(456, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '60745581ace06.pdf', NULL, NULL, '2021-04-12 14:13:21', '2021-04-12 14:13:22'),
(457, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6074582123b86.pdf', NULL, NULL, '2021-04-12 14:24:32', '2021-04-12 14:24:33'),
(458, 11, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, NULL, '607458317466f.pdf', NULL, '2021-04-12 14:24:49', '2021-04-12 14:24:49'),
(459, 11, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, NULL, NULL, '60745838cf515.pdf', '2021-04-12 14:24:56', '2021-04-12 14:24:57'),
(461, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, NULL, NULL, '2021-04-12 14:29:25', '2021-04-12 14:29:25'),
(462, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, NULL, NULL, '2021-04-12 14:30:21', '2021-04-12 14:30:21'),
(463, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, NULL, NULL, '2021-04-12 14:30:41', '2021-04-12 14:30:41'),
(464, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, NULL, NULL, '2021-04-12 14:31:17', '2021-04-12 14:31:17'),
(465, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, NULL, NULL, '2021-04-12 14:33:56', '2021-04-12 14:33:56'),
(468, NULL, 121.00, 100.00, 0.00, 0.00, 21.00, 121.00, NULL, NULL, NULL, '2021-04-12 14:40:37', '2021-04-12 14:40:37'),
(469, NULL, 195.00, 161.16, 0.00, 0.00, 33.84, 195.00, '60745e99767c4.pdf', NULL, NULL, '2021-04-12 14:52:09', '2021-04-12 14:52:09'),
(470, NULL, 338.00, 287.27, 0.00, 0.00, 50.73, 338.00, '60745eae4792a.pdf', NULL, NULL, '2021-04-12 14:52:29', '2021-04-12 14:52:30'),
(471, NULL, 83.00, 70.08, 0.00, 0.00, 12.92, 83.00, '60745ec9a8923.pdf', NULL, NULL, '2021-04-12 14:52:57', '2021-04-12 14:52:58'),
(472, NULL, 107.00, 95.83, 0.00, 0.00, 11.17, 107.00, '60745f2f99b02.pdf', NULL, NULL, '2021-04-12 14:54:39', '2021-04-12 14:54:40'),
(473, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60745f5205a96.pdf', NULL, NULL, '2021-04-12 14:55:13', '2021-04-12 14:55:14'),
(474, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60745f718ce07.pdf', NULL, NULL, '2021-04-12 14:55:45', '2021-04-12 14:55:45'),
(475, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60745f873e94d.pdf', NULL, NULL, '2021-04-12 14:56:06', '2021-04-12 14:56:07'),
(476, NULL, 18.00, 16.36, 0.00, 0.00, 1.64, 18.00, '6074600aa11ae.pdf', NULL, NULL, '2021-04-12 14:58:18', '2021-04-12 14:58:19'),
(477, NULL, 23.00, 19.01, 0.00, 0.00, 3.99, 23.00, '607460239e7bb.pdf', NULL, NULL, '2021-04-12 14:58:43', '2021-04-12 14:58:43'),
(478, NULL, 293.00, 242.15, 0.00, 0.00, 50.85, 293.00, '6074603fbd8c1.pdf', NULL, NULL, '2021-04-12 14:59:11', '2021-04-12 14:59:12'),
(479, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60746058c0a57.pdf', NULL, NULL, '2021-04-12 14:59:36', '2021-04-12 14:59:37'),
(480, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '607460899a143.pdf', NULL, NULL, '2021-04-12 15:00:25', '2021-04-12 15:00:25'),
(481, NULL, 126.00, 107.02, 0.00, 0.00, 18.98, 126.00, '6074618e86975.pdf', NULL, NULL, '2021-04-12 15:04:46', '2021-04-12 15:04:46'),
(482, NULL, 58.00, 47.93, 0.00, 0.00, 10.07, 58.00, '607461a5e4267.pdf', NULL, NULL, '2021-04-12 15:05:09', '2021-04-12 15:05:10'),
(483, NULL, 308.00, 254.55, 0.00, 0.00, 53.45, 308.00, '607461fa07ba1.pdf', NULL, NULL, '2021-04-12 15:06:33', '2021-04-12 15:06:34'),
(484, 11, 157.00, 129.75, 0.00, 0.00, 27.25, 157.00, NULL, '607462caac5a6.pdf', NULL, '2021-04-12 15:10:02', '2021-04-12 15:10:03'),
(485, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '607462f365f34.pdf', NULL, NULL, '2021-04-12 15:10:43', '2021-04-12 15:10:43'),
(486, NULL, 35.00, 31.82, 0.00, 0.00, 3.18, 35.00, '6074633231f42.pdf', NULL, NULL, '2021-04-12 15:11:45', '2021-04-12 15:11:46'),
(487, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60746359a3a1d.pdf', NULL, NULL, '2021-04-12 15:12:25', '2021-04-12 15:12:25'),
(488, NULL, 66.00, 54.55, 0.00, 0.00, 11.45, 66.00, '6074652b736a9.pdf', NULL, NULL, '2021-04-12 15:20:11', '2021-04-12 15:20:11'),
(489, NULL, 157.00, 129.75, 0.00, 0.00, 27.25, 157.00, '60746547a4ec2.pdf', NULL, NULL, '2021-04-12 15:20:39', '2021-04-12 15:20:40'),
(490, NULL, 121.00, 100.00, 0.00, 0.00, 21.00, 121.00, '60746643927b2.pdf', NULL, NULL, '2021-04-12 15:24:51', '2021-04-12 15:24:51'),
(491, 11, 58.00, 47.93, 0.00, 0.00, 10.07, 58.00, NULL, '6074665cab49a.pdf', NULL, '2021-04-12 15:25:16', '2021-04-12 15:25:17'),
(492, 11, 187.00, 160.74, 0.00, 0.00, 26.26, 187.00, NULL, NULL, '60746667435b3.pdf', '2021-04-12 15:25:27', '2021-04-12 15:25:27'),
(493, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '607466a718e1c.pdf', NULL, NULL, '2021-04-12 15:26:30', '2021-04-12 15:26:31'),
(494, 11, 126.00, 107.02, 0.00, 0.00, 18.98, 126.00, NULL, NULL, '607466ee336e5.pdf', '2021-04-12 15:27:42', '2021-04-12 15:27:42'),
(495, 11, 101.00, 83.47, 0.00, 0.00, 17.53, 101.00, NULL, NULL, '607466ffb588e.pdf', '2021-04-12 15:27:59', '2021-04-12 15:28:00'),
(496, NULL, 101.00, 83.47, 0.00, 0.00, 17.53, 101.00, '607467ae24c7d.pdf', NULL, NULL, '2021-04-12 15:30:53', '2021-04-12 15:30:54'),
(497, 11, 202.00, 166.94, 0.00, 0.00, 35.06, 202.00, NULL, '607467bf7b128.pdf', NULL, '2021-04-12 15:31:11', '2021-04-12 15:31:12'),
(498, NULL, 101.00, 83.47, 0.00, 0.00, 17.53, 101.00, '6074681864404.pdf', NULL, NULL, '2021-04-12 15:32:39', '2021-04-12 15:32:40'),
(499, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '607468d61620b.pdf', NULL, NULL, '2021-04-12 15:35:49', '2021-04-12 15:35:50'),
(500, NULL, 66.00, 54.55, 0.00, 0.00, 11.45, 66.00, '60746a66a336c.pdf', NULL, NULL, '2021-04-12 15:42:30', '2021-04-12 15:42:30'),
(501, NULL, 66.00, 54.55, 0.00, 0.00, 11.45, 66.00, '60746ac3ddf25.pdf', NULL, NULL, '2021-04-12 15:44:03', '2021-04-12 15:44:04'),
(502, NULL, 99.00, 81.82, 0.00, 0.00, 17.18, 99.00, '60746ae0600a8.pdf', NULL, NULL, '2021-04-12 15:44:31', '2021-04-12 15:44:32'),
(503, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '60746afd0132e.pdf', NULL, NULL, '2021-04-12 15:45:00', '2021-04-12 15:45:01'),
(504, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '60746b11797c4.pdf', NULL, NULL, '2021-04-12 15:45:21', '2021-04-12 15:45:21'),
(505, NULL, 128.00, 118.62, 0.00, 0.00, 9.38, 128.00, '60746b24b07d7.pdf', NULL, NULL, '2021-04-12 15:45:40', '2021-04-12 15:45:41'),
(506, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60746b48d323c.pdf', NULL, NULL, '2021-04-12 15:46:16', '2021-04-12 15:46:17'),
(507, NULL, 68.00, 56.20, 0.00, 0.00, 11.80, 68.00, '60746b5e162a7.pdf', NULL, NULL, '2021-04-12 15:46:37', '2021-04-12 15:46:38'),
(508, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60746d555ab3f.pdf', NULL, NULL, '2021-04-12 15:55:00', '2021-04-12 15:55:01'),
(509, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60746d6e9b836.pdf', NULL, NULL, '2021-04-12 15:55:26', '2021-04-12 15:55:26'),
(510, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60746f2bb7a9b.pdf', NULL, NULL, '2021-04-12 16:02:51', '2021-04-12 16:02:52'),
(511, NULL, 198.00, 163.64, 0.00, 0.00, 34.36, 198.00, '60746fcd745d0.pdf', NULL, NULL, '2021-04-12 16:05:33', '2021-04-12 16:05:33'),
(512, 11, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, NULL, '60746fec0ade4.pdf', NULL, '2021-04-12 16:06:03', '2021-04-12 16:06:04'),
(513, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '6074720130a20.pdf', NULL, NULL, '2021-04-12 16:14:56', '2021-04-12 16:14:57'),
(514, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60747222a990e.pdf', NULL, NULL, '2021-04-12 16:15:30', '2021-04-12 16:15:31'),
(515, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60754462b0f0d.pdf', NULL, NULL, '2021-04-13 07:12:34', '2021-04-13 07:12:35'),
(516, NULL, 133.00, 109.92, 0.00, 0.00, 23.08, 133.00, '60754a10bcb02.pdf', NULL, NULL, '2021-04-13 07:36:48', '2021-04-13 07:36:49'),
(517, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60754b666f4dc.pdf', NULL, NULL, '2021-04-13 07:42:30', '2021-04-13 07:42:30'),
(518, NULL, 165.00, 136.36, 0.00, 0.00, 28.64, 165.00, '60754b8f1a22f.pdf', NULL, NULL, '2021-04-13 07:43:10', '2021-04-13 07:43:11'),
(519, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60754bc254857.pdf', NULL, NULL, '2021-04-13 07:44:01', '2021-04-13 07:44:02'),
(520, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60755229b927e.pdf', NULL, NULL, '2021-04-13 08:11:21', '2021-04-13 08:11:22'),
(521, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '6075523452afe.pdf', NULL, NULL, '2021-04-13 08:11:31', '2021-04-13 08:11:32'),
(522, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60755255741b0.pdf', NULL, NULL, '2021-04-13 08:12:05', '2021-04-13 08:12:05'),
(523, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607552935d713.pdf', NULL, NULL, '2021-04-13 08:13:06', '2021-04-13 08:13:07'),
(524, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607552a613f27.pdf', NULL, NULL, '2021-04-13 08:13:25', '2021-04-13 08:13:26'),
(525, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607552ccbfa84.pdf', NULL, NULL, '2021-04-13 08:14:04', '2021-04-13 08:14:05'),
(526, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6075535fd6317.pdf', NULL, NULL, '2021-04-13 08:16:31', '2021-04-13 08:16:32'),
(527, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '607553c7ae9d8.pdf', NULL, NULL, '2021-04-13 08:18:15', '2021-04-13 08:18:16'),
(528, NULL, 65.00, 53.72, 0.00, 0.00, 11.28, 65.00, '6075545252e2e.pdf', NULL, NULL, '2021-04-13 08:20:33', '2021-04-13 08:20:34'),
(529, NULL, 425.00, 351.24, 0.00, 0.00, 73.76, 425.00, '60755491a18a8.pdf', NULL, NULL, '2021-04-13 08:21:37', '2021-04-13 08:21:38'),
(530, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '607554da56df4.pdf', NULL, NULL, '2021-04-13 08:22:49', '2021-04-13 08:22:50'),
(531, NULL, 36.00, 29.75, 0.00, 0.00, 6.25, 36.00, '607555255fdf3.pdf', NULL, NULL, '2021-04-13 08:24:04', '2021-04-13 08:24:05'),
(532, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '607555393858f.pdf', NULL, NULL, '2021-04-13 08:24:24', '2021-04-13 08:24:25'),
(533, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6075557f414b6.pdf', NULL, NULL, '2021-04-13 08:25:34', '2021-04-13 08:25:35'),
(534, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6075558d0c023.pdf', NULL, NULL, '2021-04-13 08:25:48', '2021-04-13 08:25:49'),
(535, NULL, 33.00, 27.27, 0.00, 0.00, 5.73, 33.00, '60755603ef4b9.pdf', NULL, NULL, '2021-04-13 08:27:47', '2021-04-13 08:27:48'),
(536, 11, 180.00, 148.76, 0.00, 0.00, 31.24, 180.00, NULL, '6075b236693ef.pdf', NULL, '2021-04-13 15:01:10', '2021-04-13 15:01:10'),
(537, 11, 386.00, 326.41, 0.00, 0.00, 59.59, 386.00, NULL, NULL, '6075b31b7d62d.pdf', '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(538, 11, 327.00, 277.85, 0.00, 0.00, 49.15, 327.00, NULL, '6075b34bac807.pdf', NULL, '2021-04-13 15:05:47', '2021-04-13 15:05:48'),
(539, NULL, 79.00, 65.29, 0.00, 0.00, 13.71, 79.00, '6075c9008df1a.pdf', NULL, NULL, '2021-04-13 16:38:24', '2021-04-13 16:38:24'),
(540, NULL, 361.00, 305.62, 0.00, 0.00, 55.38, 361.00, '6075c91891909.pdf', NULL, NULL, '2021-04-13 16:38:47', '2021-04-13 16:38:49'),
(541, 11, 311.00, 266.45, 0.00, 0.00, 44.55, 311.00, '6075c946d57d6.pdf', '607826bb9aa65.pdf', NULL, '2021-04-13 16:39:34', '2021-04-15 11:42:52'),
(542, 11, 296.00, 244.63, 0.00, 0.00, 51.37, 296.00, NULL, '607823fe6686d.pdf', NULL, '2021-04-13 16:41:46', '2021-04-15 11:31:11'),
(543, 11, 144.00, 119.01, 0.00, 0.00, 24.99, 144.00, '607826e2e7972.pdf', '607d328845222.pdf', NULL, '2021-04-15 11:43:30', '2021-04-19 07:34:33'),
(544, NULL, 35.00, 31.82, 0.00, 0.00, 3.18, 35.00, '6078274d61e6d.pdf', NULL, NULL, '2021-04-15 11:45:16', '2021-04-15 11:45:17'),
(545, NULL, 35.00, 31.82, 0.00, 0.00, 3.18, 35.00, '607827712d1da.pdf', NULL, NULL, '2021-04-15 11:45:52', '2021-04-15 11:45:53'),
(546, NULL, 54.00, 44.63, 0.00, 0.00, 9.37, 54.00, '6078278b24411.pdf', NULL, NULL, '2021-04-15 11:46:18', '2021-04-15 11:46:19'),
(547, NULL, 35.00, 31.82, 0.00, 0.00, 3.18, 35.00, '607827b72c797.pdf', NULL, NULL, '2021-04-15 11:47:02', '2021-04-15 11:47:03'),
(548, NULL, 95.00, 81.40, 0.00, 0.00, 13.60, 95.00, '60783cd1b4e8b.pdf', NULL, NULL, '2021-04-15 13:17:05', '2021-04-15 13:17:06'),
(549, 11, 113.00, 96.94, 11.30, 10.00, 4.76, 101.70, '60783d44c3d69.pdf', NULL, NULL, '2021-04-15 13:19:00', '2021-04-15 13:19:01'),
(550, 11, 36.00, 25.29, 5.40, 15.00, 5.31, 30.60, '60783db043cde.pdf', NULL, NULL, '2021-04-15 13:20:47', '2021-04-15 13:20:48'),
(551, NULL, 180.00, 165.97, 0.00, 0.00, 14.03, 180.00, '60783dcde77aa.pdf', NULL, NULL, '2021-04-15 13:21:17', '2021-04-15 13:21:18'),
(552, NULL, 127.00, 117.79, 0.00, 0.00, 9.21, 127.00, '60783defa25a1.pdf', NULL, NULL, '2021-04-15 13:21:51', '2021-04-15 13:21:52'),
(553, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60783e0498c38.pdf', NULL, NULL, '2021-04-15 13:22:12', '2021-04-15 13:22:13'),
(554, NULL, 54.00, 22.31, 27.00, 50.00, 4.69, 27.00, '60783e240302c.pdf', NULL, NULL, '2021-04-15 13:22:43', '2021-04-15 13:22:44'),
(555, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '60783e6746474.pdf', NULL, NULL, '2021-04-15 13:23:50', '2021-04-15 13:23:51'),
(556, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60783e8eb9705.pdf', NULL, NULL, '2021-04-15 13:24:30', '2021-04-15 13:24:31'),
(557, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60783eb85262f.pdf', NULL, NULL, '2021-04-15 13:25:11', '2021-04-15 13:25:12'),
(558, NULL, 54.00, 44.63, 0.00, 0.00, 9.37, 54.00, '60783eccd72d8.pdf', NULL, NULL, '2021-04-15 13:25:32', '2021-04-15 13:25:33'),
(559, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60783eda68bbd.pdf', NULL, NULL, '2021-04-15 13:25:45', '2021-04-15 13:25:46'),
(560, NULL, 21.00, 19.09, 0.00, 0.00, 1.91, 21.00, '60783ee75d447.pdf', NULL, NULL, '2021-04-15 13:25:58', '2021-04-15 13:25:59'),
(561, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60783fb030ae7.pdf', NULL, NULL, '2021-04-15 13:29:19', '2021-04-15 13:29:20'),
(562, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6078402a16f20.pdf', NULL, NULL, '2021-04-15 13:31:21', '2021-04-15 13:31:22'),
(563, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '607840525471e.pdf', NULL, NULL, '2021-04-15 13:32:01', '2021-04-15 13:32:02'),
(564, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '607840770cef4.pdf', NULL, NULL, '2021-04-15 13:32:38', '2021-04-15 13:32:39'),
(565, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60784093bb630.pdf', NULL, NULL, '2021-04-15 13:33:07', '2021-04-15 13:33:08'),
(566, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '607840d2cfa05.pdf', NULL, NULL, '2021-04-15 13:34:10', '2021-04-15 13:34:11'),
(567, NULL, 133.00, 109.92, 0.00, 0.00, 23.08, 133.00, '607840e60061a.pdf', NULL, NULL, '2021-04-15 13:34:29', '2021-04-15 13:34:30'),
(568, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '6078413a40be6.pdf', NULL, NULL, '2021-04-15 13:35:53', '2021-04-15 13:35:54'),
(569, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60784155c7229.pdf', NULL, NULL, '2021-04-15 13:36:21', '2021-04-15 13:36:22'),
(570, NULL, 56.00, 46.28, 0.00, 0.00, 9.72, 56.00, '60784191b1457.pdf', NULL, NULL, '2021-04-15 13:37:21', '2021-04-15 13:37:22'),
(571, NULL, 21.00, 19.09, 0.00, 0.00, 1.91, 21.00, '60784406a5348.pdf', NULL, NULL, '2021-04-15 13:47:50', '2021-04-15 13:47:51'),
(572, NULL, 127.00, 108.18, 0.00, 0.00, 18.82, 127.00, '607844b36d9ba.pdf', NULL, NULL, '2021-04-15 13:50:42', '2021-04-15 13:50:43'),
(573, NULL, 240.00, 198.35, 0.00, 0.00, 41.65, 240.00, '607844df6059f.pdf', NULL, NULL, '2021-04-15 13:51:26', '2021-04-15 13:51:27'),
(574, NULL, 97.00, 80.17, 0.00, 0.00, 16.83, 97.00, '6078452059a5e.pdf', NULL, NULL, '2021-04-15 13:52:31', '2021-04-15 13:52:32'),
(575, NULL, 21.00, 19.09, 0.00, 0.00, 1.91, 21.00, '6078455923c76.pdf', NULL, NULL, '2021-04-15 13:53:28', '2021-04-15 13:53:29'),
(576, NULL, 21.00, 19.09, 0.00, 0.00, 1.91, 21.00, '607845db071e9.pdf', NULL, NULL, '2021-04-15 13:55:38', '2021-04-15 13:55:39'),
(577, NULL, 21.00, 19.09, 0.00, 0.00, 1.91, 21.00, '6078465970b8d.pdf', NULL, NULL, '2021-04-15 13:57:44', '2021-04-15 13:57:45'),
(578, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '60784691367d4.pdf', NULL, NULL, '2021-04-15 13:58:40', '2021-04-15 13:58:41'),
(579, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '607846cc7c4a6.pdf', NULL, NULL, '2021-04-15 13:59:40', '2021-04-15 13:59:40'),
(580, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '6078475c00dc8.pdf', NULL, NULL, '2021-04-15 14:02:03', '2021-04-15 14:02:04'),
(581, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '6078477d79bf5.pdf', NULL, NULL, '2021-04-15 14:02:36', '2021-04-15 14:02:37'),
(586, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '6078489fec16e.pdf', NULL, NULL, '2021-04-15 14:07:27', '2021-04-15 14:07:28'),
(587, NULL, 32.00, 26.45, 0.00, 0.00, 5.55, 32.00, '6078490bd0e7e.pdf', NULL, NULL, '2021-04-15 14:09:15', '2021-04-15 14:09:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_nro_ticket`
--

DROP TABLE IF EXISTS `venta_nro_ticket`;
CREATE TABLE IF NOT EXISTS `venta_nro_ticket` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `nro_ticket_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `venta_nro_ticket`
--

INSERT INTO `venta_nro_ticket` (`id`, `venta_id`, `nro_ticket_id`, `created_at`, `updated_at`) VALUES
(10, 39, 8, '2020-09-17 17:56:17', '2020-09-17 17:56:17'),
(11, 39, 9, '2020-09-17 17:56:17', '2020-09-17 17:56:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

DROP TABLE IF EXISTS `venta_producto`;
CREATE TABLE IF NOT EXISTS `venta_producto` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=662 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='utf8mb4_unicode_ci';

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`id`, `venta_id`, `producto_id`, `descripcion`, `cantidad`, `total`, `created_at`, `updated_at`) VALUES
(414, 437, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 13:53:12', '2021-04-12 13:53:12'),
(415, 438, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 13:54:18', '2021-04-12 13:54:18'),
(416, 439, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 13:54:55', '2021-04-12 13:54:55'),
(417, 440, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 13:55:22', '2021-04-12 13:55:22'),
(418, 441, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 13:56:14', '2021-04-12 13:56:14'),
(419, 442, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 13:57:28', '2021-04-12 13:57:28'),
(420, 443, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 13:59:15', '2021-04-12 13:59:15'),
(421, 444, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 14:00:15', '2021-04-12 14:00:15'),
(422, 445, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 14:01:28', '2021-04-12 14:01:28'),
(423, 446, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 14:02:07', '2021-04-12 14:02:07'),
(424, 447, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:02:53', '2021-04-12 14:02:53'),
(425, 448, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 14:04:27', '2021-04-12 14:04:27'),
(427, 450, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 14:08:14', '2021-04-12 14:08:14'),
(428, 451, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:11:26', '2021-04-12 14:11:26'),
(429, 452, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:12:07', '2021-04-12 14:12:07'),
(430, 453, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:12:26', '2021-04-12 14:12:26'),
(431, 454, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:12:32', '2021-04-12 14:12:32'),
(432, 455, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:12:39', '2021-04-12 14:12:39'),
(433, 456, 8, 'Salmon marinado a la sal', 1, 0, '2021-04-12 14:13:21', '2021-04-12 14:13:21'),
(434, 457, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:24:32', '2021-04-12 14:24:32'),
(435, 458, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:24:49', '2021-04-12 14:24:49'),
(436, 459, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:24:56', '2021-04-12 14:24:56'),
(437, 465, 1, 'Sandia cubitos', 1, 33, '2021-04-12 14:33:56', '2021-04-12 14:33:56'),
(440, 468, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 14:40:37', '2021-04-12 14:40:37'),
(441, 468, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:40:37', '2021-04-12 14:40:37'),
(442, 469, 8, 'Salmon marinado a la sal', 3, 585, '2021-04-12 14:52:09', '2021-04-12 14:52:09'),
(443, 470, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(444, 470, 11, 'Burguer para compartir parejas', 1, 43, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(445, 470, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(446, 470, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(447, 470, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(448, 470, 3, 'Gominolas', 1, 35, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(449, 470, 2, 'Frutos secos 250gr', 1, 25, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(450, 470, 6, 'Mix fruta deshidratada', 1, 60, '2021-04-12 14:52:29', '2021-04-12 14:52:29'),
(451, 471, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 14:52:57', '2021-04-12 14:52:57'),
(452, 471, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-12 14:52:57', '2021-04-12 14:52:57'),
(453, 472, 16, 'Tartaleta de fruta', 1, 20, '2021-04-12 14:54:39', '2021-04-12 14:54:39'),
(454, 472, 15, 'Pure calabaza', 1, 32, '2021-04-12 14:54:39', '2021-04-12 14:54:39'),
(455, 472, 14, 'Preparado de lechuga mediterranea', 1, 23, '2021-04-12 14:54:39', '2021-04-12 14:54:39'),
(456, 472, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-12 14:54:39', '2021-04-12 14:54:39'),
(457, 473, 1, 'Sandia cubitos', 1, 33, '2021-04-12 14:55:13', '2021-04-12 14:55:13'),
(458, 474, 1, 'Sandia cubitos', 1, 33, '2021-04-12 14:55:45', '2021-04-12 14:55:45'),
(459, 475, 1, 'Sandia cubitos', 0, 0, '2021-04-12 14:56:06', '2021-04-12 14:56:06'),
(460, 476, 7, 'Frutos secos para ensalada', 0, 0, '2021-04-12 14:58:18', '2021-04-12 14:58:18'),
(461, 477, 19, 'Vino Alicante', 0, 0, '2021-04-12 14:58:43', '2021-04-12 14:58:43'),
(462, 478, 4, 'Papaya escarchada 250gr', 0, 0, '2021-04-12 14:59:11', '2021-04-12 14:59:11'),
(463, 478, 18, 'Elias mora Gran reserva 1982', 0, 0, '2021-04-12 14:59:11', '2021-04-12 14:59:11'),
(464, 478, 17, 'Set vino empresa 8 Uds', 0, 0, '2021-04-12 14:59:11', '2021-04-12 14:59:11'),
(465, 478, 19, 'Vino Alicante', 0, 0, '2021-04-12 14:59:11', '2021-04-12 14:59:11'),
(466, 479, 12, 'Preparado de especias para verduras', 0, 0, '2021-04-12 14:59:36', '2021-04-12 14:59:36'),
(467, 480, 1, 'Sandia cubitos', 1, 33, '2021-04-12 15:00:25', '2021-04-12 15:00:25'),
(468, 481, 1, 'Sandia cubitos', 2, 132, '2021-04-12 15:04:46', '2021-04-12 15:04:46'),
(469, 481, 2, 'Frutos secos 250gr', 1, 25, '2021-04-12 15:04:46', '2021-04-12 15:04:46'),
(470, 481, 3, 'Gominolas', 1, 35, '2021-04-12 15:04:46', '2021-04-12 15:04:46'),
(471, 482, 1, 'Sandia cubitos', 1, 33, '2021-04-12 15:05:09', '2021-04-12 15:05:09'),
(472, 482, 2, 'Frutos secos 250gr', 1, 25, '2021-04-12 15:05:09', '2021-04-12 15:05:09'),
(473, 483, 1, 'Sandia cubitos', 2, 132, '2021-04-12 15:06:33', '2021-04-12 15:06:33'),
(474, 483, 8, 'Salmon marinado a la sal', 2, 260, '2021-04-12 15:06:33', '2021-04-12 15:06:33'),
(475, 483, 12, 'Preparado de especias para verduras', 2, 224, '2021-04-12 15:06:33', '2021-04-12 15:06:33'),
(476, 484, 4, 'Papaya escarchada 250gr', 0, 0, '2021-04-12 15:10:02', '2021-04-12 15:10:02'),
(477, 484, 8, 'Salmon marinado a la sal', 0, 0, '2021-04-12 15:10:02', '2021-04-12 15:10:02'),
(478, 484, 12, 'Preparado de especias para verduras', 0, 0, '2021-04-12 15:10:02', '2021-04-12 15:10:02'),
(479, 485, 1, 'Sandia cubitos', 0, 0, '2021-04-12 15:10:43', '2021-04-12 15:10:43'),
(480, 486, 3, 'Gominolas', 0, 0, '2021-04-12 15:11:45', '2021-04-12 15:11:45'),
(481, 487, 1, 'Sandia cubitos', 0, 0, '2021-04-12 15:12:25', '2021-04-12 15:12:25'),
(482, 488, 1, 'Sandia cubitos', 0, 0, '2021-04-12 15:20:11', '2021-04-12 15:20:11'),
(483, 489, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:20:39', '2021-04-12 15:20:39'),
(484, 489, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 15:20:39', '2021-04-12 15:20:39'),
(485, 489, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 15:20:39', '2021-04-12 15:20:39'),
(486, 490, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 15:24:51', '2021-04-12 15:24:51'),
(487, 490, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-12 15:24:51', '2021-04-12 15:24:51'),
(488, 491, 1, 'Sandia cubitos', 1, 33, '2021-04-12 15:25:16', '2021-04-12 15:25:16'),
(489, 491, 2, 'Frutos secos 250gr', 1, 25, '2021-04-12 15:25:16', '2021-04-12 15:25:16'),
(490, 492, 15, 'Pure calabaza', 1, 32, '2021-04-12 15:25:27', '2021-04-12 15:25:27'),
(491, 492, 11, 'Burguer para compartir parejas', 1, 43, '2021-04-12 15:25:27', '2021-04-12 15:25:27'),
(492, 492, 12, 'Preparado de especias para verduras', 2, 224, '2021-04-12 15:25:27', '2021-04-12 15:25:27'),
(493, 493, 1, 'Sandia cubitos', 1, 0, '2021-04-12 15:26:30', '2021-04-12 15:26:30'),
(494, 494, 1, 'Sandia cubitos', 2, 132, '2021-04-12 15:27:42', '2021-04-12 15:27:42'),
(495, 494, 2, 'Frutos secos 250gr', 1, 25, '2021-04-12 15:27:42', '2021-04-12 15:27:42'),
(496, 494, 3, 'Gominolas', 1, 35, '2021-04-12 15:27:42', '2021-04-12 15:27:42'),
(497, 495, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:27:59', '2021-04-12 15:27:59'),
(498, 495, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 15:27:59', '2021-04-12 15:27:59'),
(499, 496, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:30:53', '2021-04-12 15:30:53'),
(500, 496, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 15:30:53', '2021-04-12 15:30:53'),
(501, 497, 8, 'Salmon marinado a la sal', 2, 260, '2021-04-12 15:31:11', '2021-04-12 15:31:11'),
(502, 497, 4, 'Papaya escarchada 250gr', 2, 144, '2021-04-12 15:31:11', '2021-04-12 15:31:11'),
(503, 498, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:32:39', '2021-04-12 15:32:39'),
(504, 498, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-12 15:32:39', '2021-04-12 15:32:39'),
(505, 499, 1, 'Sandia cubitos', 1, 33, '2021-04-12 15:35:49', '2021-04-12 15:35:49'),
(506, 500, 1, 'Sandia cubitos', 2, 132, '2021-04-12 15:42:30', '2021-04-12 15:42:30'),
(507, 501, 1, 'Sandia cubitos', 2, 132, '2021-04-12 15:44:03', '2021-04-12 15:44:03'),
(508, 502, 1, 'Sandia cubitos', 3, 297, '2021-04-12 15:44:31', '2021-04-12 15:44:31'),
(509, 503, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:45:00', '2021-04-12 15:45:00'),
(510, 504, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:45:21', '2021-04-12 15:45:21'),
(511, 505, 1, 'Sandia cubitos', 1, 0, '2021-04-12 15:45:40', '2021-04-12 15:45:40'),
(512, 505, 10, 'Macedonia de frutas', 1, 0, '2021-04-12 15:45:40', '2021-04-12 15:45:40'),
(513, 506, 1, 'Sandia cubitos', 1, 0, '2021-04-12 15:46:16', '2021-04-12 15:46:16'),
(514, 507, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 15:46:37', '2021-04-12 15:46:37'),
(515, 507, 13, 'Preparado de quinoa con verduras', 1, 0, '2021-04-12 15:46:37', '2021-04-12 15:46:37'),
(516, 508, 1, 'Sandia cubitos', 1, 0, '2021-04-12 15:55:00', '2021-04-12 15:55:00'),
(517, 509, 1, 'Sandia cubitos', 1, 33, '2021-04-12 15:55:26', '2021-04-12 15:55:26'),
(518, 510, 1, 'Sandia cubitos', 1, 0, '2021-04-12 16:02:51', '2021-04-12 16:02:51'),
(519, 511, 1, 'Sandia cubitos', 6, 0, '2021-04-12 16:05:33', '2021-04-12 16:05:33'),
(520, 512, 1, 'Sandia cubitos', 1, 0, '2021-04-12 16:06:04', '2021-04-12 16:06:04'),
(521, 513, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-12 16:14:56', '2021-04-12 16:14:56'),
(522, 514, 1, 'Sandia cubitos', 1, 0, '2021-04-12 16:15:30', '2021-04-12 16:15:30'),
(523, 515, 1, 'Sandia cubitos', 1, 0, '2021-04-13 07:12:34', '2021-04-13 07:12:34'),
(524, 516, 2, 'Frutos secos 250gr', 4, 0, '2021-04-13 07:36:48', '2021-04-13 07:36:48'),
(525, 516, 1, 'Sandia cubitos', 1, 0, '2021-04-13 07:36:48', '2021-04-13 07:36:48'),
(526, 517, 1, 'Sandia cubitos', 1, 33, '2021-04-13 07:42:30', '2021-04-13 07:42:30'),
(527, 518, 1, 'Sandia cubitos', 5, 825, '2021-04-13 07:43:10', '2021-04-13 07:43:10'),
(528, 519, 1, 'Sandia cubitos', 1, 33, '2021-04-13 07:44:01', '2021-04-13 07:44:01'),
(529, 520, 1, 'Sandia cubitos', 1, 33, '2021-04-13 08:11:21', '2021-04-13 08:11:21'),
(530, 521, 1, 'Sandia cubitos', 1, 33, '2021-04-13 08:11:31', '2021-04-13 08:11:31'),
(531, 522, 1, 'Sandia cubitos', 1, 33, '2021-04-13 08:12:05', '2021-04-13 08:12:05'),
(532, 523, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:13:06', '2021-04-13 08:13:06'),
(533, 524, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:13:25', '2021-04-13 08:13:25'),
(534, 525, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:14:04', '2021-04-13 08:14:04'),
(535, 526, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:16:31', '2021-04-13 08:16:31'),
(536, 527, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:18:15', '2021-04-13 08:18:15'),
(537, 528, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 08:20:33', '2021-04-13 08:20:33'),
(538, 529, 8, 'Salmon marinado a la sal', 4, 1040, '2021-04-13 08:21:37', '2021-04-13 08:21:37'),
(539, 529, 1, 'Sandia cubitos', 5, 165, '2021-04-13 08:21:37', '2021-04-13 08:21:37'),
(540, 530, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-13 08:22:49', '2021-04-13 08:22:49'),
(541, 531, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-13 08:24:04', '2021-04-13 08:24:04'),
(542, 532, 1, 'Sandia cubitos', 1, 33, '2021-04-13 08:24:24', '2021-04-13 08:24:24'),
(543, 533, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-13 08:25:34', '2021-04-13 08:25:34'),
(544, 534, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-13 08:25:48', '2021-04-13 08:25:48'),
(545, 535, 1, 'Sandia cubitos', 1, 33, '2021-04-13 08:27:47', '2021-04-13 08:27:47'),
(546, 536, 17, 'Set vino empresa 8 Uds', 1, 180, '2021-04-13 15:01:10', '2021-04-13 15:01:10'),
(547, 537, 14, 'Preparado de lechuga mediterranea', 1, 23, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(548, 537, 16, 'Tartaleta de fruta', 1, 20, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(549, 537, 15, 'Pure calabaza', 1, 32, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(550, 537, 17, 'Set vino empresa 8 Uds', 1, 180, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(551, 537, 18, 'Elias mora Gran reserva 1982', 2, 216, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(552, 537, 19, 'Vino Alicante', 1, 23, '2021-04-13 15:04:59', '2021-04-13 15:04:59'),
(553, 538, 19, 'Vino Alicante', 1, 23, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(554, 538, 16, 'Tartaleta de fruta', 3, 180, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(555, 538, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(556, 538, 17, 'Set vino empresa 8 Uds', 1, 180, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(557, 538, 15, 'Pure calabaza', 1, 32, '2021-04-13 15:05:47', '2021-04-13 15:05:47'),
(558, 539, 19, 'Vino Alicante', 1, 23, '2021-04-13 16:38:24', '2021-04-13 16:38:24'),
(559, 539, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-13 16:38:24', '2021-04-13 16:38:24'),
(560, 540, 12, 'Preparado de especias para verduras', 2, 224, '2021-04-13 16:38:47', '2021-04-13 16:38:47'),
(561, 540, 8, 'Salmon marinado a la sal', 1, 65, '2021-04-13 16:38:47', '2021-04-13 16:38:47'),
(562, 540, 3, 'Gominolas', 2, 140, '2021-04-13 16:38:47', '2021-04-13 16:38:47'),
(563, 540, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-13 16:38:48', '2021-04-13 16:38:48'),
(564, 540, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-13 16:38:48', '2021-04-13 16:38:48'),
(565, 540, 6, 'Mix fruta deshidratada', 1, 60, '2021-04-13 16:38:48', '2021-04-13 16:38:48'),
(566, 541, 6, 'Mix fruta deshidratada', 1, 60, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(567, 541, 2, 'Frutos secos 250gr', 1, 25, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(568, 541, 12, 'Preparado de especias para verduras', 2, 224, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(569, 541, 7, 'Frutos secos para ensalada', 2, 72, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(570, 541, 11, 'Burguer para compartir parejas', 1, 43, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(571, 541, 3, 'Gominolas', 1, 35, '2021-04-13 16:39:34', '2021-04-13 16:39:34'),
(576, 542, 8, 'Salmon marinado a la sal', 2, 260, '2021-04-15 11:31:10', '2021-04-15 11:31:10'),
(577, 542, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-15 11:31:10', '2021-04-15 11:31:10'),
(579, 544, 3, 'Gominolas', 1, 35, '2021-04-15 11:45:16', '2021-04-15 11:45:16'),
(580, 545, 3, 'Gominolas', 1, 35, '2021-04-15 11:45:52', '2021-04-15 11:45:52'),
(581, 546, 18, 'Elias mora Gran reserva 1982', 1, 54, '2021-04-15 11:46:18', '2021-04-15 11:46:18'),
(582, 547, 3, 'Gominolas', 1, 35, '2021-04-15 11:47:02', '2021-04-15 11:47:02'),
(583, 548, 3, 'Gominolas', 1, 35, '2021-04-15 13:17:05', '2021-04-15 13:17:05'),
(584, 548, 6, 'Mix fruta deshidratada', 1, 60, '2021-04-15 13:17:05', '2021-04-15 13:17:05'),
(585, 549, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-15 13:19:00', '2021-04-15 13:19:00'),
(586, 549, 10, 'Macedonia de frutas', 1, 95, '2021-04-15 13:19:00', '2021-04-15 13:19:00'),
(587, 550, 4, 'Papaya escarchada 250gr', 1, 36, '2021-04-15 13:20:47', '2021-04-15 13:20:47'),
(588, 551, 3, 'Gominolas', 1, 35, '2021-04-15 13:21:17', '2021-04-15 13:21:17'),
(589, 551, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-15 13:21:17', '2021-04-15 13:21:17'),
(590, 551, 10, 'Macedonia de frutas', 1, 95, '2021-04-15 13:21:17', '2021-04-15 13:21:17'),
(591, 551, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:21:17', '2021-04-15 13:21:17'),
(592, 552, 10, 'Macedonia de frutas', 1, 95, '2021-04-15 13:21:51', '2021-04-15 13:21:51'),
(593, 552, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:21:51', '2021-04-15 13:21:51'),
(594, 553, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:22:12', '2021-04-15 13:22:12'),
(595, 554, 18, 'Elias mora Gran reserva 1982', 1, 54, '2021-04-15 13:22:43', '2021-04-15 13:22:43'),
(596, 555, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:23:50', '2021-04-15 13:23:50'),
(597, 556, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:24:30', '2021-04-15 13:24:30'),
(598, 557, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:25:11', '2021-04-15 13:25:11'),
(599, 558, 18, 'Elias mora Gran reserva 1982', 1, 54, '2021-04-15 13:25:32', '2021-04-15 13:25:32'),
(600, 559, 5, 'Papaya escarchada 150gr', 1, 56, '2021-04-15 13:25:45', '2021-04-15 13:25:45'),
(601, 560, 9, 'Avellanas', 1, 21, '2021-04-15 13:25:58', '2021-04-15 13:25:58'),
(602, 561, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:29:19', '2021-04-15 13:29:19'),
(603, 562, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:31:21', '2021-04-15 13:31:21'),
(604, 563, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:32:01', '2021-04-15 13:32:01'),
(605, 564, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:32:38', '2021-04-15 13:32:38'),
(606, 565, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:33:07', '2021-04-15 13:33:07'),
(607, 566, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:34:10', '2021-04-15 13:34:10'),
(608, 567, 19, 'Vino Alicante', 1, 23, '2021-04-15 13:34:29', '2021-04-15 13:34:29'),
(609, 567, 18, 'Elias mora Gran reserva 1982', 1, 54, '2021-04-15 13:34:29', '2021-04-15 13:34:29'),
(610, 567, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:34:29', '2021-04-15 13:34:29'),
(611, 568, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:35:53', '2021-04-15 13:35:53'),
(612, 569, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:36:21', '2021-04-15 13:36:21'),
(613, 570, 12, 'Preparado de especias para verduras', 1, 56, '2021-04-15 13:37:21', '2021-04-15 13:37:21'),
(614, 571, 9, 'Avellanas', 1, 21, '2021-04-15 13:47:50', '2021-04-15 13:47:50'),
(615, 572, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:50:42', '2021-04-15 13:50:42'),
(616, 572, 9, 'Avellanas', 1, 21, '2021-04-15 13:50:42', '2021-04-15 13:50:42'),
(617, 572, 5, 'Papaya escarchada 150gr', 1, 56, '2021-04-15 13:50:42', '2021-04-15 13:50:42'),
(618, 572, 7, 'Frutos secos para ensalada', 1, 18, '2021-04-15 13:50:42', '2021-04-15 13:50:42'),
(619, 573, 5, 'Papaya escarchada 150gr', 3, 504, '2021-04-15 13:51:26', '2021-04-15 13:51:26'),
(620, 573, 4, 'Papaya escarchada 250gr', 2, 144, '2021-04-15 13:51:26', '2021-04-15 13:51:26'),
(621, 574, 2, 'Frutos secos 250gr', 1, 25, '2021-04-15 13:52:31', '2021-04-15 13:52:31'),
(622, 574, 4, 'Papaya escarchada 250gr', 2, 144, '2021-04-15 13:52:31', '2021-04-15 13:52:31'),
(623, 575, 9, 'Avellanas', 1, 21, '2021-04-15 13:53:28', '2021-04-15 13:53:28'),
(624, 576, 9, 'Avellanas', 1, 21, '2021-04-15 13:55:38', '2021-04-15 13:55:38'),
(625, 577, 9, 'Avellanas', 1, 21, '2021-04-15 13:57:44', '2021-04-15 13:57:44'),
(626, 578, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:58:40', '2021-04-15 13:58:40'),
(627, 579, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 13:59:40', '2021-04-15 13:59:40'),
(628, 580, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 14:02:03', '2021-04-15 14:02:03'),
(629, 581, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 14:02:37', '2021-04-15 14:02:37'),
(636, 586, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 14:07:27', '2021-04-15 14:07:27'),
(637, 587, 13, 'Preparado de quinoa con verduras', 1, 32, '2021-04-15 14:09:15', '2021-04-15 14:09:15'),
(657, 449, 2, 'Frutos secos 250gr', 1, 25, '2021-04-15 15:13:15', '2021-04-15 15:13:15'),
(661, 543, 4, 'Papaya escarchada 250gr', 2, 144, '2021-04-19 07:34:31', '2021-04-19 07:34:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
