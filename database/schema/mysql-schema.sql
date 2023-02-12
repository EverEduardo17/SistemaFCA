/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `Academia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Academia` (
  `IdAcademia` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreAcademia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionAcademia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Coordinador` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdAcademia`),
  UNIQUE KEY `academia_nombreacademia_unique` (`NombreAcademia`),
  KEY `academia_coordinador_foreign` (`Coordinador`),
  KEY `academia_createdby_foreign` (`CreatedBy`),
  KEY `academia_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `academia_coordinador_foreign` FOREIGN KEY (`Coordinador`) REFERENCES `Academico` (`IdAcademico`),
  CONSTRAINT `academia_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `academia_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Academico` (
  `IdAcademico` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NoPersonalAcademico` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RfcAcademico` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdUsuario` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdAcademico`),
  UNIQUE KEY `academico_nopersonalacademico_unique` (`NoPersonalAcademico`),
  UNIQUE KEY `academico_rfcacademico_unique` (`RfcAcademico`),
  UNIQUE KEY `academico_idusuario_unique` (`IdUsuario`),
  KEY `academico_createdby_foreign` (`CreatedBy`),
  KEY `academico_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `academico_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `academico_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `academico_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Academico_Academia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Academico_Academia` (
  `Id_Academico_Academia` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdAcademico` bigint unsigned NOT NULL,
  `IdAcademia` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id_Academico_Academia`),
  UNIQUE KEY `academico_academia_idacademico_idacademia_unique` (`IdAcademico`,`IdAcademia`),
  KEY `academico_academia_idacademia_foreign` (`IdAcademia`),
  KEY `academico_academia_createdby_foreign` (`CreatedBy`),
  KEY `academico_academia_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `academico_academia_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `academico_academia_idacademia_foreign` FOREIGN KEY (`IdAcademia`) REFERENCES `Academia` (`IdAcademia`),
  CONSTRAINT `academico_academia_idacademico_foreign` FOREIGN KEY (`IdAcademico`) REFERENCES `Academico` (`IdAcademico`),
  CONSTRAINT `academico_academia_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Academico_Evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Academico_Evento` (
  `Id_Academico_Evento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdAcademico` bigint unsigned NOT NULL,
  `IdEvento` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id_Academico_Evento`),
  UNIQUE KEY `academico_evento_idacademico_idevento_unique` (`IdAcademico`,`IdEvento`),
  KEY `academico_evento_idevento_foreign` (`IdEvento`),
  KEY `academico_evento_createdby_foreign` (`CreatedBy`),
  KEY `academico_evento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `academico_evento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `academico_evento_idacademico_foreign` FOREIGN KEY (`IdAcademico`) REFERENCES `Academico` (`IdAcademico`),
  CONSTRAINT `academico_evento_idevento_foreign` FOREIGN KEY (`IdEvento`) REFERENCES `Evento` (`IdEvento`),
  CONSTRAINT `academico_evento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Baja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Baja` (
  `IdBaja` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `IdPeriodoBaja` bigint unsigned NOT NULL,
  `TipoBaja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdMotivo` bigint unsigned NOT NULL,
  `IdPeriodoTramite` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdBaja`),
  KEY `baja_idgrupo_foreign` (`IdGrupo`),
  KEY `baja_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `baja_idperiodobaja_foreign` (`IdPeriodoBaja`),
  KEY `baja_idmotivo_foreign` (`IdMotivo`),
  KEY `baja_idperiodotramite_foreign` (`IdPeriodoTramite`),
  KEY `baja_createdby_foreign` (`CreatedBy`),
  KEY `baja_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `baja_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `baja_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `baja_idmotivo_foreign` FOREIGN KEY (`IdMotivo`) REFERENCES `Motivo` (`IdMotivo`),
  CONSTRAINT `baja_idperiodobaja_foreign` FOREIGN KEY (`IdPeriodoBaja`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `baja_idperiodotramite_foreign` FOREIGN KEY (`IdPeriodoTramite`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `baja_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `baja_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Cambio_Grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cambio_Grupo` (
  `IdCambioGrupo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdGrupoOrigen` bigint unsigned NOT NULL,
  `IdGrupoDestino` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `IdPeriodoCambioGrupo` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdCambioGrupo`),
  KEY `cambio_grupo_idgrupoorigen_foreign` (`IdGrupoOrigen`),
  KEY `cambio_grupo_idgrupodestino_foreign` (`IdGrupoDestino`),
  KEY `cambio_grupo_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `cambio_grupo_idperiodocambiogrupo_foreign` (`IdPeriodoCambioGrupo`),
  KEY `cambio_grupo_createdby_foreign` (`CreatedBy`),
  KEY `cambio_grupo_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `cambio_grupo_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `cambio_grupo_idgrupodestino_foreign` FOREIGN KEY (`IdGrupoDestino`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `cambio_grupo_idgrupoorigen_foreign` FOREIGN KEY (`IdGrupoOrigen`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `cambio_grupo_idperiodocambiogrupo_foreign` FOREIGN KEY (`IdPeriodoCambioGrupo`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `cambio_grupo_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `cambio_grupo_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Cohorte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cohorte` (
  `IdCohorte` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreCohorte` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionCohorte` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdCohorte`),
  UNIQUE KEY `cohorte_nombrecohorte_unique` (`NombreCohorte`),
  KEY `cohorte_createdby_foreign` (`CreatedBy`),
  KEY `cohorte_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `cohorte_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `cohorte_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `DatosPersonales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DatosPersonales` (
  `IdDatosPersonales` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreDatosPersonales` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ApellidoPaternoDatosPersonales` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ApellidoMaternoDatosPersonales` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechaNacimientoDatosPersonales` date DEFAULT NULL,
  `Genero` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IdUsuario` bigint unsigned DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdDatosPersonales`),
  UNIQUE KEY `datospersonales_idusuario_unique` (`IdUsuario`),
  KEY `datospersonales_createdby_foreign` (`CreatedBy`),
  KEY `datospersonales_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `datospersonales_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `datospersonales_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `datospersonales_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Documento` (
  `IdDocumento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreDocumento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionDocumento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FormatoDocumento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdEvento` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdDocumento`),
  KEY `documento_idevento_foreign` (`IdEvento`),
  KEY `documento_createdby_foreign` (`CreatedBy`),
  KEY `documento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `documento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `documento_idevento_foreign` FOREIGN KEY (`IdEvento`) REFERENCES `Evento` (`IdEvento`),
  CONSTRAINT `documento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Empresa` (
  `IdEmpresa` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreEmpresa` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DireccionEmpresa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LocalidadEmpresa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TelefonoEmpresa` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmailEmpresa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ResponsableEmpresa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipoEmpresa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ActividadEmpresa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ClasificacionEmpresa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  UNIQUE KEY `empresa_nombreempresa_unique` (`NombreEmpresa`),
  KEY `empresa_createdby_foreign` (`CreatedBy`),
  KEY `empresa_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `empresa_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `empresa_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estudiante` (
  `IdEstudiante` bigint unsigned NOT NULL AUTO_INCREMENT,
  `MatriculaEstudiante` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdUsuario` bigint unsigned DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdEstudiante`),
  UNIQUE KEY `estudiante_matriculaestudiante_unique` (`MatriculaEstudiante`),
  UNIQUE KEY `estudiante_idusuario_unique` (`IdUsuario`),
  KEY `estudiante_createdby_foreign` (`CreatedBy`),
  KEY `estudiante_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `estudiante_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `estudiante_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `estudiante_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Evento` (
  `IdEvento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreEvento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionEvento` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Motivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EstadoEvento` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'POR APROBAR',
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdEvento`),
  KEY `evento_createdby_foreign` (`CreatedBy`),
  KEY `evento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `evento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `evento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Evento_Fecha_Sede`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Evento_Fecha_Sede` (
  `Id_Evento_Fecha_Sede` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdEvento` bigint unsigned NOT NULL,
  `IdFechaEvento` bigint unsigned NOT NULL,
  `IdSedeEvento` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id_Evento_Fecha_Sede`),
  UNIQUE KEY `evento_fecha_sede_idevento_idfechaevento_idsedeevento_unique` (`IdEvento`,`IdFechaEvento`,`IdSedeEvento`),
  KEY `evento_fecha_sede_idfechaevento_foreign` (`IdFechaEvento`),
  KEY `evento_fecha_sede_idsedeevento_foreign` (`IdSedeEvento`),
  KEY `evento_fecha_sede_createdby_foreign` (`CreatedBy`),
  KEY `evento_fecha_sede_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `evento_fecha_sede_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `evento_fecha_sede_idevento_foreign` FOREIGN KEY (`IdEvento`) REFERENCES `Evento` (`IdEvento`),
  CONSTRAINT `evento_fecha_sede_idfechaevento_foreign` FOREIGN KEY (`IdFechaEvento`) REFERENCES `FechaEvento` (`IdFechaEvento`),
  CONSTRAINT `evento_fecha_sede_idsedeevento_foreign` FOREIGN KEY (`IdSedeEvento`) REFERENCES `SedeEvento` (`IdSedeEvento`),
  CONSTRAINT `evento_fecha_sede_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Facultad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Facultad` (
  `IdFacultad` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreFacultad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ClaveFacultad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdFacultad`),
  UNIQUE KEY `facultad_clavefacultad_unique` (`ClaveFacultad`),
  KEY `facultad_createdby_foreign` (`CreatedBy`),
  KEY `facultad_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `facultad_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `facultad_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `FechaEvento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `FechaEvento` (
  `IdFechaEvento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `InicioFechaEvento` datetime NOT NULL,
  `FinFechaEvento` datetime NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdFechaEvento`),
  KEY `fechaevento_createdby_foreign` (`CreatedBy`),
  KEY `fechaevento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `fechaevento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `fechaevento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Grupo` (
  `IdGrupo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreGrupo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionGrupo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Sin descripción',
  `IdProgramaEducativo` bigint unsigned NOT NULL,
  `IdCohorte` bigint unsigned NOT NULL,
  `IdPeriodoInicio` bigint unsigned NOT NULL,
  `IdPeriodoActivo` bigint unsigned NOT NULL,
  `IdFacultad` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdGrupo`),
  KEY `grupo_idprogramaeducativo_foreign` (`IdProgramaEducativo`),
  KEY `grupo_idcohorte_foreign` (`IdCohorte`),
  KEY `grupo_idperiodoinicio_foreign` (`IdPeriodoInicio`),
  KEY `grupo_idperiodoactivo_foreign` (`IdPeriodoActivo`),
  KEY `grupo_idfacultad_foreign` (`IdFacultad`),
  KEY `grupo_createdby_foreign` (`CreatedBy`),
  KEY `grupo_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `grupo_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `grupo_idcohorte_foreign` FOREIGN KEY (`IdCohorte`) REFERENCES `Cohorte` (`IdCohorte`),
  CONSTRAINT `grupo_idfacultad_foreign` FOREIGN KEY (`IdFacultad`) REFERENCES `Facultad` (`IdFacultad`),
  CONSTRAINT `grupo_idperiodoactivo_foreign` FOREIGN KEY (`IdPeriodoActivo`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `grupo_idperiodoinicio_foreign` FOREIGN KEY (`IdPeriodoInicio`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `grupo_idprogramaeducativo_foreign` FOREIGN KEY (`IdProgramaEducativo`) REFERENCES `Programa_Educativo` (`IdProgramaEducativo`),
  CONSTRAINT `grupo_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Grupo_Estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Grupo_Estudiante` (
  `IdGrupoEstudiante` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipoTraslado` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdGrupoEstudiante`),
  KEY `grupo_estudiante_idgrupo_foreign` (`IdGrupo`),
  KEY `grupo_estudiante_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `grupo_estudiante_createdby_foreign` (`CreatedBy`),
  KEY `grupo_estudiante_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `grupo_estudiante_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `grupo_estudiante_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `grupo_estudiante_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `grupo_estudiante_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Modalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Modalidad` (
  `IdModalidad` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreModalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionModalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipoModalidad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdModalidad`),
  UNIQUE KEY `modalidad_nombremodalidad_unique` (`NombreModalidad`),
  KEY `modalidad_createdby_foreign` (`CreatedBy`),
  KEY `modalidad_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `modalidad_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `modalidad_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Motivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Motivo` (
  `IdMotivo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreMotivo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionMotivo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TipoBaja` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdMotivo`),
  UNIQUE KEY `motivo_nombremotivo_unique` (`NombreMotivo`),
  KEY `motivo_createdby_foreign` (`CreatedBy`),
  KEY `motivo_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `motivo_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `motivo_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Organizador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Organizador` (
  `IdOrganizador` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdAcademico` bigint unsigned NOT NULL,
  `IdEvento` bigint unsigned NOT NULL,
  `IdTipoOrganizador` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdOrganizador`),
  UNIQUE KEY `organizador_idacademico_idevento_idtipoorganizador_unique` (`IdAcademico`,`IdEvento`,`IdTipoOrganizador`),
  KEY `organizador_idevento_foreign` (`IdEvento`),
  KEY `organizador_idtipoorganizador_foreign` (`IdTipoOrganizador`),
  KEY `organizador_createdby_foreign` (`CreatedBy`),
  KEY `organizador_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `organizador_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `organizador_idacademico_foreign` FOREIGN KEY (`IdAcademico`) REFERENCES `Academico` (`IdAcademico`),
  CONSTRAINT `organizador_idevento_foreign` FOREIGN KEY (`IdEvento`) REFERENCES `Evento` (`IdEvento`),
  CONSTRAINT `organizador_idtipoorganizador_foreign` FOREIGN KEY (`IdTipoOrganizador`) REFERENCES `TipoOrganizador` (`IdTipoOrganizador`),
  CONSTRAINT `organizador_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Periodo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Periodo` (
  `IdPeriodo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombrePeriodo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaInicioPeriodo` date NOT NULL,
  `FechaFinPeriodo` date NOT NULL,
  `ActualPeriodo` tinyint(1) NOT NULL DEFAULT '0',
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPeriodo`),
  UNIQUE KEY `periodo_nombreperiodo_unique` (`NombrePeriodo`),
  KEY `periodo_createdby_foreign` (`CreatedBy`),
  KEY `periodo_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `periodo_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `periodo_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Permiso` (
  `IdPermiso` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ClavePermiso` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionPermiso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPermiso`),
  UNIQUE KEY `permiso_clavepermiso_unique` (`ClavePermiso`),
  KEY `permiso_createdby_foreign` (`CreatedBy`),
  KEY `permiso_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `permiso_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `permiso_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Practica_Estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Practica_Estudiante` (
  `IdPractica` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdEmpresa` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdPractica`),
  UNIQUE KEY `practica_estudiante_idtrayectoria_unique` (`IdTrayectoria`),
  KEY `practica_estudiante_idempresa_foreign` (`IdEmpresa`),
  KEY `practica_estudiante_createdby_foreign` (`CreatedBy`),
  KEY `practica_estudiante_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `practica_estudiante_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `practica_estudiante_idempresa_foreign` FOREIGN KEY (`IdEmpresa`) REFERENCES `Empresa` (`IdEmpresa`),
  CONSTRAINT `practica_estudiante_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `practica_estudiante_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Programa_Educativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Programa_Educativo` (
  `IdProgramaEducativo` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdFacultad` bigint unsigned NOT NULL,
  `NombreProgramaEducativo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AcronimoProgramaEducativo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdProgramaEducativo`),
  UNIQUE KEY `programa_educativo_nombreprogramaeducativo_unique` (`NombreProgramaEducativo`),
  UNIQUE KEY `programa_educativo_acronimoprogramaeducativo_unique` (`AcronimoProgramaEducativo`),
  KEY `programa_educativo_idfacultad_foreign` (`IdFacultad`),
  KEY `programa_educativo_createdby_foreign` (`CreatedBy`),
  KEY `programa_educativo_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `programa_educativo_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `programa_educativo_idfacultad_foreign` FOREIGN KEY (`IdFacultad`) REFERENCES `Facultad` (`IdFacultad`),
  CONSTRAINT `programa_educativo_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Reprobado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reprobado` (
  `IdReprobado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `IdPeriodo` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdReprobado`),
  KEY `reprobado_idgrupo_foreign` (`IdGrupo`),
  KEY `reprobado_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `reprobado_idperiodo_foreign` (`IdPeriodo`),
  KEY `reprobado_createdby_foreign` (`CreatedBy`),
  KEY `reprobado_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `reprobado_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `reprobado_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `reprobado_idperiodo_foreign` FOREIGN KEY (`IdPeriodo`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `reprobado_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `reprobado_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Role` (
  `IdRole` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ClaveRole` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionRole` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdRole`),
  UNIQUE KEY `role_claverole_unique` (`ClaveRole`),
  KEY `role_createdby_foreign` (`CreatedBy`),
  KEY `role_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `role_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `role_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Role_Permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Role_Permiso` (
  `Id_Role_Permiso` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdRole` bigint unsigned NOT NULL,
  `IdPermiso` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id_Role_Permiso`),
  UNIQUE KEY `role_permiso_idrole_idpermiso_unique` (`IdRole`,`IdPermiso`),
  KEY `role_permiso_idpermiso_foreign` (`IdPermiso`),
  KEY `role_permiso_createdby_foreign` (`CreatedBy`),
  KEY `role_permiso_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `role_permiso_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `role_permiso_idpermiso_foreign` FOREIGN KEY (`IdPermiso`) REFERENCES `Permiso` (`IdPermiso`),
  CONSTRAINT `role_permiso_idrole_foreign` FOREIGN KEY (`IdRole`) REFERENCES `Role` (`IdRole`),
  CONSTRAINT `role_permiso_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Role_Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Role_Usuario` (
  `Id_Role_Usuario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdRole` bigint unsigned NOT NULL,
  `IdUsuario` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id_Role_Usuario`),
  UNIQUE KEY `role_usuario_idrole_idusuario_unique` (`IdRole`,`IdUsuario`),
  KEY `role_usuario_idusuario_foreign` (`IdUsuario`),
  KEY `role_usuario_createdby_foreign` (`CreatedBy`),
  KEY `role_usuario_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `role_usuario_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `role_usuario_idrole_foreign` FOREIGN KEY (`IdRole`) REFERENCES `Role` (`IdRole`),
  CONSTRAINT `role_usuario_idusuario_foreign` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `role_usuario_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `SedeEvento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SedeEvento` (
  `IdSedeEvento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreSedeEvento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionSedeEvento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdSedeEvento`),
  UNIQUE KEY `sedeevento_nombresedeevento_unique` (`NombreSedeEvento`),
  KEY `sedeevento_createdby_foreign` (`CreatedBy`),
  KEY `sedeevento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `sedeevento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `sedeevento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Servicio_Estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Servicio_Estudiante` (
  `IdServicioSocial` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdEmpresa` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdServicioSocial`),
  UNIQUE KEY `servicio_estudiante_idtrayectoria_unique` (`IdTrayectoria`),
  KEY `servicio_estudiante_idempresa_foreign` (`IdEmpresa`),
  KEY `servicio_estudiante_createdby_foreign` (`CreatedBy`),
  KEY `servicio_estudiante_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `servicio_estudiante_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `servicio_estudiante_idempresa_foreign` FOREIGN KEY (`IdEmpresa`) REFERENCES `Empresa` (`IdEmpresa`),
  CONSTRAINT `servicio_estudiante_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `servicio_estudiante_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TipoDocumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TipoDocumento` (
  `Id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreTipoDocumento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionTipoDocumento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `tipodocumento_nombretipodocumento_unique` (`NombreTipoDocumento`),
  KEY `tipodocumento_createdby_foreign` (`CreatedBy`),
  KEY `tipodocumento_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `tipodocumento_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `tipodocumento_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `TipoOrganizador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TipoOrganizador` (
  `IdTipoOrganizador` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreTipoOrganizador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DescripcionTipoOrganizador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdTipoOrganizador`),
  UNIQUE KEY `tipoorganizador_nombretipoorganizador_unique` (`NombreTipoOrganizador`),
  KEY `tipoorganizador_createdby_foreign` (`CreatedBy`),
  KEY `tipoorganizador_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `tipoorganizador_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `tipoorganizador_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Titulacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Titulacion` (
  `IdTitulacion` bigint unsigned NOT NULL AUTO_INCREMENT,
  `PromedioEgreso` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaAplicacion` date DEFAULT NULL,
  `ResultadoExamen` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechaInicioTramite` date NOT NULL,
  `FechaFinTramite` date NOT NULL,
  `EstadoTitulacion` tinyint(1) NOT NULL,
  `MencionHonorifica` tinyint(1) NOT NULL,
  `IdModalidad` bigint unsigned NOT NULL,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `IdPeriodoEgreso` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdTitulacion`),
  KEY `titulacion_idmodalidad_foreign` (`IdModalidad`),
  KEY `titulacion_idgrupo_foreign` (`IdGrupo`),
  KEY `titulacion_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `titulacion_idperiodoegreso_foreign` (`IdPeriodoEgreso`),
  KEY `titulacion_createdby_foreign` (`CreatedBy`),
  KEY `titulacion_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `titulacion_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `titulacion_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `titulacion_idmodalidad_foreign` FOREIGN KEY (`IdModalidad`) REFERENCES `Modalidad` (`IdModalidad`),
  CONSTRAINT `titulacion_idperiodoegreso_foreign` FOREIGN KEY (`IdPeriodoEgreso`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `titulacion_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `titulacion_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Traslado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Traslado` (
  `IdTraslado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `TipoTraslado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Saliente',
  `Facultad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Campus` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdTrayectoria` bigint unsigned NOT NULL,
  `IdPeriodo` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdTraslado`),
  KEY `traslado_idgrupo_foreign` (`IdGrupo`),
  KEY `traslado_idtrayectoria_foreign` (`IdTrayectoria`),
  KEY `traslado_idperiodo_foreign` (`IdPeriodo`),
  KEY `traslado_createdby_foreign` (`CreatedBy`),
  KEY `traslado_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `traslado_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `traslado_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `traslado_idperiodo_foreign` FOREIGN KEY (`IdPeriodo`) REFERENCES `Periodo` (`IdPeriodo`),
  CONSTRAINT `traslado_idtrayectoria_foreign` FOREIGN KEY (`IdTrayectoria`) REFERENCES `Trayectoria` (`IdTrayectoria`),
  CONSTRAINT `traslado_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Trayectoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Trayectoria` (
  `IdTrayectoria` bigint unsigned NOT NULL AUTO_INCREMENT,
  `EstudianteRegular` tinyint(1) NOT NULL,
  `TotalPeriodos` int DEFAULT NULL,
  `IdGrupo` bigint unsigned NOT NULL,
  `IdEstudiante` bigint unsigned NOT NULL,
  `IdProgramaEducativo` bigint unsigned NOT NULL,
  `IdModalidad` bigint unsigned NOT NULL,
  `IdCohorte` bigint unsigned NOT NULL,
  `IdDatosPersonales` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint unsigned DEFAULT NULL,
  `UpdatedBy` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`IdTrayectoria`),
  KEY `trayectoria_idgrupo_foreign` (`IdGrupo`),
  KEY `trayectoria_idestudiante_foreign` (`IdEstudiante`),
  KEY `trayectoria_idprogramaeducativo_foreign` (`IdProgramaEducativo`),
  KEY `trayectoria_idmodalidad_foreign` (`IdModalidad`),
  KEY `trayectoria_idcohorte_foreign` (`IdCohorte`),
  KEY `trayectoria_iddatospersonales_foreign` (`IdDatosPersonales`),
  KEY `trayectoria_createdby_foreign` (`CreatedBy`),
  KEY `trayectoria_updatedby_foreign` (`UpdatedBy`),
  CONSTRAINT `trayectoria_createdby_foreign` FOREIGN KEY (`CreatedBy`) REFERENCES `Usuario` (`IdUsuario`),
  CONSTRAINT `trayectoria_idcohorte_foreign` FOREIGN KEY (`IdCohorte`) REFERENCES `Cohorte` (`IdCohorte`),
  CONSTRAINT `trayectoria_iddatospersonales_foreign` FOREIGN KEY (`IdDatosPersonales`) REFERENCES `DatosPersonales` (`IdDatosPersonales`),
  CONSTRAINT `trayectoria_idestudiante_foreign` FOREIGN KEY (`IdEstudiante`) REFERENCES `Estudiante` (`IdEstudiante`),
  CONSTRAINT `trayectoria_idgrupo_foreign` FOREIGN KEY (`IdGrupo`) REFERENCES `Grupo` (`IdGrupo`),
  CONSTRAINT `trayectoria_idmodalidad_foreign` FOREIGN KEY (`IdModalidad`) REFERENCES `Modalidad` (`IdModalidad`),
  CONSTRAINT `trayectoria_idprogramaeducativo_foreign` FOREIGN KEY (`IdProgramaEducativo`) REFERENCES `Programa_Educativo` (`IdProgramaEducativo`),
  CONSTRAINT `trayectoria_updatedby_foreign` FOREIGN KEY (`UpdatedBy`) REFERENCES `Usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuario` (
  `IdUsuario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DeletedAt` timestamp NULL DEFAULT NULL,
  `CreatedBy` bigint DEFAULT NULL,
  `UpdatedBy` bigint DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `usuario_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

