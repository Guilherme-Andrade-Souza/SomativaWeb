create database somativa_web;
use somativa_web;
create table login(
id_login int primary key auto_increment,
nome varchar(180) not null,
usuario varchar(100)not null,
senha varchar(32)not null,
email varchar(255)
);
create table cartas(
id_cartas int primary key auto_increment,
nome varchar(100) not null,
raridade varchar(90) not null,
quantidade int unsigned,
valor double
);
create table contato(
id_contato int primary key auto_increment,
login_id_login int,
mensagem text,
assunto varchar(45),
telefone varchar(45),
foreign key (login_id_login) references login(id_login)
);
create table pedidos(
id_pedidos int primary key auto_increment,
login_id_login int,
data_pedidos date not null,
total_pedidos double,
foreign key (login_id_login) references login(id_login)
);
create table pedidos_cartas(
pedidos_id_pedidos int,
cartas_id_cartas int,
quantidade_cartas int unsigned,
foreign key (pedidos_id_pedidos) references pedidos(id_pedidos),
foreign key (cartas_id_cartas) references cartas(id_cartas)
);
