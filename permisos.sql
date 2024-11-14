-- Crear usuarios
CREATE USER 'dba_user'@'%' IDENTIFIED BY 'password_dba';
CREATE USER 'dev_user'@'%' IDENTIFIED BY 'password_dev';
CREATE USER 'app_user'@'%' IDENTIFIED BY 'password_app';
CREATE USER 'auditor_user'@'%' IDENTIFIED BY 'password_audit';
CREATE USER 'guest_user'@'%' IDENTIFIED BY 'password_guest';


-- Los permisos deben asignarse separados por un FLUSH PRIVILEGES

-- Asignar permisos al DBA
GRANT ALL PRIVILEGES ON oceantrade.* TO 'dba_user'@'%';

-- Asignar permisos al Desarrollador
GRANT CREATE, ALTER, SELECT, INSERT, UPDATE, DELETE ON oceantrade.* TO 'dev_user'@'%';

-- Asignar permisos al Usuario de Aplicación
GRANT SELECT, INSERT, UPDATE, DELETE ON oceantrade.* TO 'app_user'@'%';

-- Asignar permisos al Auditor
GRANT SELECT ON oceantrade.* TO 'auditor_user'@'%';

 -- Asignar permisos al Usuario Invitado
GRANT SELECT ON oceantrade.producto TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.ofertas TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.producto_unitario TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.categoria TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.pertenece TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.cliente TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.empresa TO 'guest_user'@'%';
GRANT SELECT ON oceantrade.admin TO 'guest_user'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;
