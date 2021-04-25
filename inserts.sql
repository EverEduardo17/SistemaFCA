<-- TODO: Agregar "Role_Usuario" con el usuario del profe -->
<-- TODO: Faltan permisos, no están todos vinculados o faltan algunos -->
INSERT INTO `Permiso`(`IdPermiso`, `ClavePermiso`, `DescripcionPermiso`, `CreatedAt`, `UpdatedAt`, `DeletedAt`, `CreatedBy`, `UpdatedBy`) VALUES
(73, "eventoestado-listar", "eventoestado-listar", current_timestamp, current_timestamp, null, 1, 1),
(74, "eventoestado-crear", "eventoestado-crear", current_timestamp, current_timestamp, null, 1, 1),
(75, "eventoestado-leer", "eventoestado-editar", current_timestamp, current_timestamp, null, 1, 1),
(76, "eventoestado-editar", "eventoestado-leer", current_timestamp, current_timestamp, null, 1, 1),
(77, "eventoestado-eliminar", "eventoestado-eliminar", current_timestamp, current_timestamp, null, 1, 1),
(78, "eventoestado-aprobar", "eventoestado-aprobar", current_timestamp, current_timestamp, null, 1, 1);

INSERT INTO `role_permiso`(`IdRole`, `IdPermiso`, `CreatedAt`, `UpdatedAt`, `DeletedAt`, `CreatedBy`, `UpdatedBy`) VALUES
(1, 73, current_timestamp, current_timestamp, null, 1, 1),
(1, 74, current_timestamp, current_timestamp, null, 1, 1),
(1, 75, current_timestamp, current_timestamp, null, 1, 1),
(1, 76, current_timestamp, current_timestamp, null, 1, 1),
(1, 77, current_timestamp, current_timestamp, null, 1, 1),
(1, 78, current_timestamp, current_timestamp, null, 1, 1);


INSERT INTO `Permiso`(`IdPermiso`, `ClavePermiso`, `DescripcionPermiso`, `CreatedAt`, `UpdatedAt`, `DeletedAt`, `CreatedBy`, `UpdatedBy`) VALUES
(79, "academias-listar", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(80, "academias-crear", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(81, "academias-leer", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(82, "academias-editar", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(83, "academias-eliminar", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(84, "academia-academico-crear", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(85, "academia-academico-eliminar", "academias-listar", current_timestamp, current_timestamp, null, 1, 1),
(86, "sedes-listar", "sedes-listar", current_timestamp, current_timestamp, null, 1, 1),
(87, "sedes-crear", "sedes-listar", current_timestamp, current_timestamp, null, 1, 1),
(88, "sedes-leer", "sedes-listar", current_timestamp, current_timestamp, null, 1, 1),
(89, "sedes-editar", "sedes-listar", current_timestamp, current_timestamp, null, 1, 1),
(90, "sedes-eliminar", "sedes-listar", current_timestamp, current_timestamp, null, 1, 1),
(91, "facultades-listar", "facultades-listar", current_timestamp, current_timestamp, null, 1, 1),
(92, "facultades-crear", "facultades-listar", current_timestamp, current_timestamp, null, 1, 1),
(93, "facultades-leer", "facultades-listar", current_timestamp, current_timestamp, null, 1, 1),
(94, "facultades-editar", "facultades-listar", current_timestamp, current_timestamp, null, 1, 1),
(95, "facultades-eliminar", "facultades-listar", current_timestamp, current_timestamp, null, 1, 1),
(96, "tipoorganizador-listar", "tipoorganizador-listar", current_timestamp, current_timestamp, null, 1, 1),
(98, "tipoorganizador-leer", "tipoorganizador-listar", current_timestamp, current_timestamp, null, 1, 1),
(101, "academicos-listar", "academicos-listar", current_timestamp, current_timestamp, null, 1, 1),
(102, "academicos-crear", "academicos-listar", current_timestamp, current_timestamp, null, 1, 1),
(103, "academicos-leer", "academicos-listar", current_timestamp, current_timestamp, null, 1, 1),
(104, "academicos-editar", "academicos-listar", current_timestamp, current_timestamp, null, 1, 1),
(105, "academicos-eliminar", "academicos-listar", current_timestamp, current_timestamp, null, 1, 1),
(106, "eventos-listar", "eventos-listar", current_timestamp, current_timestamp, null, 1, 1),
(107, "eventos-crear", "eventos-listar", current_timestamp, current_timestamp, null, 1, 1),
(108, "eventos-leer", "eventos-listar", current_timestamp, current_timestamp, null, 1, 1),
(109, "eventos-editar", "eventos-listar", current_timestamp, current_timestamp, null, 1, 1),
(110, "eventos-eliminar", "eventos-listar", current_timestamp, current_timestamp, null, 1, 1),
(111, "fechaevento-listar", "fechaevento-listar", current_timestamp, current_timestamp, null, 1, 1),
(112, "fechaevento-crear", "fechaevento-listar", current_timestamp, current_timestamp, null, 1, 1),
(113, "fechaevento-leer", "fechaevento-listar", current_timestamp, current_timestamp, null, 1, 1),
(114, "fechaevento-editar", "fechaevento-listar", current_timestamp, current_timestamp, null, 1, 1),
(115, "fechaevento-eliminar", "fechaevento-listar", current_timestamp, current_timestamp, null, 1, 1),
(116, "responsable-listar", "responsable-listar", current_timestamp, current_timestamp, null, 1, 1),
(117, "responsable-crear", "responsable-listar", current_timestamp, current_timestamp, null, 1, 1),
(118, "responsable-leer", "responsable-listar", current_timestamp, current_timestamp, null, 1, 1),
(119, "responsable-editar", "responsable-listar", current_timestamp, current_timestamp, null, 1, 1),
(120, "responsable-eliminar", "responsable-listar", current_timestamp, current_timestamp, null, 1, 1),
(121, "participantes-listar", "participantes-listar", current_timestamp, current_timestamp, null, 1, 1),
(122, "participantes-crear", "participantes-listar", current_timestamp, current_timestamp, null, 1, 1),
(123, "participantes-leer", "participantes-listar", current_timestamp, current_timestamp, null, 1, 1),
(124, "participantes-editar", "participantes-listar", current_timestamp, current_timestamp, null, 1, 1),
(125, "participantes-eliminar", "participantes-listar", current_timestamp, current_timestamp, null, 1, 1),
(126, "documentos-listar", "documentos-listar", current_timestamp, current_timestamp, null, 1, 1),
(127, "documentos-crear", "documentos-listar", current_timestamp, current_timestamp, null, 1, 1),
(128, "documentos-leer", "documentos-listar", current_timestamp, current_timestamp, null, 1, 1),
(129, "documentos-editar", "documentos-listar", current_timestamp, current_timestamp, null, 1, 1),
(130, "documentos-eliminar", "documentos-listar", current_timestamp, current_timestamp, null, 1, 1);

INSERT INTO `role_permiso`(`IdRole`, `IdPermiso`, `CreatedAt`, `UpdatedAt`, `DeletedAt`, `CreatedBy`, `UpdatedBy`) VALUES
(1, 79, current_timestamp, current_timestamp, null, 1, 1),
(1, 80, current_timestamp, current_timestamp, null, 1, 1),
(1, 81, current_timestamp, current_timestamp, null, 1, 1),
(1, 82, current_timestamp, current_timestamp, null, 1, 1),
(1, 83, current_timestamp, current_timestamp, null, 1, 1),
(1, 84, current_timestamp, current_timestamp, null, 1, 1),
(1, 85, current_timestamp, current_timestamp, null, 1, 1),
(1, 86, current_timestamp, current_timestamp, null, 1, 1),
(1, 87, current_timestamp, current_timestamp, null, 1, 1),
(1, 88, current_timestamp, current_timestamp, null, 1, 1),
(1, 89, current_timestamp, current_timestamp, null, 1, 1),
(1, 90, current_timestamp, current_timestamp, null, 1, 1),
(1, 91, current_timestamp, current_timestamp, null, 1, 1),
(1, 92, current_timestamp, current_timestamp, null, 1, 1),
(1, 93, current_timestamp, current_timestamp, null, 1, 1),
(1, 94, current_timestamp, current_timestamp, null, 1, 1),
(1, 95, current_timestamp, current_timestamp, null, 1, 1),
(1, 96, current_timestamp, current_timestamp, null, 1, 1),
(1, 98, current_timestamp, current_timestamp, null, 1, 1),
(1, 101, current_timestamp, current_timestamp, null, 1, 1),
(1, 102, current_timestamp, current_timestamp, null, 1, 1),
(1, 103, current_timestamp, current_timestamp, null, 1, 1),
(1, 104, current_timestamp, current_timestamp, null, 1, 1),
(1, 105, current_timestamp, current_timestamp, null, 1, 1),
(1, 106, current_timestamp, current_timestamp, null, 1, 1),
(1, 107, current_timestamp, current_timestamp, null, 1, 1),
(1, 108, current_timestamp, current_timestamp, null, 1, 1),
(1, 109, current_timestamp, current_timestamp, null, 1, 1),
(1, 110, current_timestamp, current_timestamp, null, 1, 1),
(1, 111, current_timestamp, current_timestamp, null, 1, 1),
(1, 112, current_timestamp, current_timestamp, null, 1, 1),
(1, 113, current_timestamp, current_timestamp, null, 1, 1),
(1, 114, current_timestamp, current_timestamp, null, 1, 1),
(1, 115, current_timestamp, current_timestamp, null, 1, 1),
(1, 116, current_timestamp, current_timestamp, null, 1, 1),
(1, 117, current_timestamp, current_timestamp, null, 1, 1),
(1, 118, current_timestamp, current_timestamp, null, 1, 1),
(1, 119, current_timestamp, current_timestamp, null, 1, 1),
(1, 120, current_timestamp, current_timestamp, null, 1, 1),
(1, 121, current_timestamp, current_timestamp, null, 1, 1),
(1, 122, current_timestamp, current_timestamp, null, 1, 1),
(1, 123, current_timestamp, current_timestamp, null, 1, 1),
(1, 124, current_timestamp, current_timestamp, null, 1, 1),
(1, 125, current_timestamp, current_timestamp, null, 1, 1),
(1, 126, current_timestamp, current_timestamp, null, 1, 1),
(1, 127, current_timestamp, current_timestamp, null, 1, 1),
(1, 128, current_timestamp, current_timestamp, null, 1, 1),
(1, 129, current_timestamp, current_timestamp, null, 1, 1),
(1, 130, current_timestamp, current_timestamp, null, 1, 1);
