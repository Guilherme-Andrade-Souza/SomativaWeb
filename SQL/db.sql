-- Criação do banco de dados somativa_web e suas tabelas

create database somativa_web;
use somativa_web;
create table login(
id_login int primary key auto_increment,
nome varchar(180) not null,
usuario varchar(100)not null,
senha varchar(255)not null,
email varchar(255)
);
create table cartas(
id_cartas int primary key auto_increment,
nome varchar(150) not null,
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

-- Criação de triggers e procedures
delimiter $$

create trigger trg_before_insert_pedidos_cartas
before insert on pedidos_cartas
for each row
begin
    if (select quantidade from cartas where id_cartas = new.cartas_id_cartas) < new.quantidade_cartas then
        signal sqlstate '45000'
        set message_text = 'Estoque insuficiente para a carta selecionada.';
    end if;
end$$

create trigger trg_after_insert_pedidos_cartas
after insert on pedidos_cartas
for each row
begin
    update cartas
    set quantidade = quantidade - new.quantidade_cartas
    where id_cartas = new.cartas_id_cartas;
end$$

delimiter ;

delimiter $$

create procedure criar_login(
in p_nome varchar(180),
in p_usuario varchar(100),
in p_senha varchar(255),
in p_email varchar(255)
)
begin
insert into login(nome, usuario, senha, email) values(p_nome, p_usuario, p_senha, p_email);
end$$

delimiter ;

-- Inserção de dados iniciais
USE somativa_web;

-- Senha padrão para todos os usuários: 'password' (hash gerado com bcrypt)
INSERT INTO login (nome, usuario, senha, email) VALUES
('Administrador', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@pwebtcgcards.com'),
('João Silva', 'joao', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'joao@email.com'),
('Maria Santos', 'maria', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'maria@email.com')
ON DUPLICATE KEY UPDATE nome=VALUES(nome);

INSERT INTO cartas (nome, raridade, quantidade, valor) VALUES
('Mega Lucario EX', 'Comum', 15, 29.90),
('Mega Lucario EX', 'Incomum', 5, 59.90),
('Mega Lucario EX', 'Super Rara', 3, 149.90),
('Mega Lucario EX', 'Rara', 8, 45.50),
('Magician of Chaos', 'Ultra Rara', 2, 199.90),
('Magician of Chaos', 'Super Rara', 4, 79.90),
('Magician of Chaos', 'Comum', 1, 299.90),
('Magician of Chaos', 'Incomum', 20, 2.50),
('K9-17 Izuna', 'Incomum', 15, 5.00),
('K9-17 Izuna', 'Comum', 4, 99.99),
('Blaster,Dragon Ruler of Infernos', 'Comum', 100, 4.90),
('Tidal, Dragon Ruler of Waterfall','Comum',20 , 4.90),
("Chaos Ruler, The Chaotic Magical Dragon", "Comum", 03, 300.90),
("Red Eyes Black Dragon","Comum",42, 9.99),
("Number 62: Galaxy-Eyes Prime Photon Dragon","Comum",19, 20.99),
("Mega Manetric EX","Comum", 99, 2.00),
("Mega Manetric EX","Raro", 20, 17.00),
("Mega Kangaskhan EX","Comum", 31, 3.00),
("Mega Kangaskhan EX", "Raro", 11, 30.00),
("Mega Kangaskhan EX", "Super Raro", 3, 60.00)
ON DUPLICATE KEY UPDATE nome=VALUES(nome);

-- Criação de usuários no Banco de Dados

create user "admin"@"localhost" identified by "U7d*ki1$Pm";
grant all privileges on somativa_web.* to "admin"@"localhost";


create user "user"@"localhost" identified by "U&c56xLW%m";
grant select, insert, delete, update on somativa_web.* to "user"@"localhost";
flush privileges;
