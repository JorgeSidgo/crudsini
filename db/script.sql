drop database if exists crudsini;
create database crudsini;
use crudsini;

-- ===========================================================================
-- TABLAS
-- ===========================================================================

create table usuario (
    codigoUsuario int primary key unique auto_increment,
    nombre varchar(50),
    apellido varchar(50),
    nomUsuario varchar(75),
    email varchar(100),
    pass varchar(75),
    codigoAuth int,
    codigoRol int
);

create table rol (
    codigoRol int primary key unique auto_increment,
    descRol varchar(25)
);

create table authUsuario(
	codigoAuth int primary key unique auto_increment,
    descAuth varchar(25)
);

create table clientes(
	codigoCliente int primary key unique auto_increment,
    nombreCliente varchar(50),
    direccion varchar(100),
    telefono varchar(20)
);

-- ===========================================================================
-- RELACIONES
-- ===========================================================================

alter table usuario add constraint fk_usuario_rol foreign key (codigoRol) references rol(codigoRol);
alter table usuario add constraint fk_usuario_auth foreign key (codigoAuth) references authUsuario(codigoAuth);

-- ===========================================================================
-- DATOS
-- ===========================================================================

# Rol
insert into rol values (null, 'Administrador');
insert into rol values (null, 'Solicitante');

# Auth (Autorización del Usuario)
insert into authUsuario values (null, 'Autorizado');
insert into authUsuario values (null, 'Esperando Autorizacion');

insert into clientes values(null,'Telefónica','San Salvador','2314-1231');
insert into clientes values(null,'YKK','Santa Ana','2451-2312');
insert into clientes values(null,'Don Pollo','Santa Tecla','2451-6969');
# Usuario

insert into usuario values (null, 'Karla Guadalupe', 'Arevalo Vega', 'kgarevalo', 'kgarevalo@deloitte.com', 'Deloite123!', 1, 1);
insert into usuario values (null, 'Jorge Luis', 'Sidgo Pimentel', 'jlsidgo', 'jlsidgo@deloitte.com', 'Deloite123!', 1, 1);
insert into usuario values (null, 'John', 'Doe', 'johndoe', 'johndoe@deloitte.com', 'Deloite123!', 2, 2);

delimiter $$
create procedure registrarUsuario(
	in nom varchar(50),
    in ape varchar(50),
    in us varchar(50),
    in correo varchar(75),
    in contra varchar(50),
    in rol int
)
begin
	insert into usuario values (null, nom, ape, us, correo, contra, 2, rol);
end
$$

delimiter $$
create procedure editarUsuario(
	in nom varchar(50),
    in ape varchar(50),
    in us varchar(50),
    in correo varchar(75),
    in rol int,
    in idUser int
)
begin
	update usuario
    set nombre = nom, apellido = ape, nomUsuario = us, email = correo, codigoRol = rol
    where codigoUsuario = idUser;
end
$$

delimiter $$
create procedure mostrarUsuarios()
begin
	select u.*, r.descRol, a.descAuth
	from usuario u
	inner join rol r on r.codigoRol = u.codigoRol
	inner join authUsuario a on a.codigoAuth = u.codigoAuth;
end
$$

delimiter $$
create procedure mostrarClientes()
begin
	select * from clientes;
end
$$

-- drop table clientes;
call mostrarClientes();
call mostrarUsuarios();