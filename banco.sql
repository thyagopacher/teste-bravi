create database contato;
use contato;
CREATE TABLE pessoa (
    id int NOT NULL AUTO_INCREMENT,
    nome varchar(255) NOT NULL default '',
    telefone varchar(11),
    email varchar(255) NOT NULL default '',
  	whatsapp varchar(11) NOT NULL default '',
  	data timestamp default current_timestamp(),
    PRIMARY KEY (id)
);

insert into `pessoa` (`data`, `email`, `id`, `nome`, `telefone`, `whatsapp`) values ('2021-09-08 18:11:37', 'thyago.pacher@gmail.com', 1, 'Thyago Henrique Pacher', '42991046063', '33333333333');

