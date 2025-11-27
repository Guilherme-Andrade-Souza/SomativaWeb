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
in p_senha varchar(32),
in p_email varchar(255)
)
begin
insert into login(nome, usuario, senha, email) values(p_nome, p_usuario, p_senha, p_email);
end$$

delimiter ;