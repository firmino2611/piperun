create database mobi_erp;

use mobi_erp;

create table users (
    id int primary key auto_increment,
    name varchar(250) not null,
    email varchar(150) unique,
    password varchar(64)
);

create table cash_flows (
    id int primary key auto_increment,
    value decimal(10, 2) not null,
    expire_date date not null, # data de vencimento
    info text,
    realized bool default false, # se já foi pago
    output bool not null, #o tipo do fluxo, se é entrada ou saída

    user_id int,
    foreign key user_id references users(id)
);

create table nfe (
    id int primary key auto_increment,
    number int not null,
    value decimal(10, 2) not null,
    type varchar(25) not null, # comissoes, vendas ou servicos
    link text, # caminho para o arquivo da nota
    throw bool default true,

    client_id int,
    cash_flow_id int,
    user_id int,
    tribute_id int,

    foreign key client_id references clients(id),
    foreign key cash_flow_id references cash_flows(id),
    foreign key user_id references users(id),
    foreign key tribute_id references tributes(id)
);

