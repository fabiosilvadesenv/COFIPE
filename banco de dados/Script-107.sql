
--drop table tb_login
create table tb_login (
    id_login 		 serial,
    tx_primeiro_nome varchar(50) not null,
    tx_segundo_nome  varchar(50) not null,
    tx_login 		 varchar(20) not null,
    tx_senha 		 varchar(100) not null,
    st_administrador char(1) 	default 'N' not null,
    dt_cadastro 	 timestamp  default now() not null,
    dt_alteracao 	 timestamp ,
    st_ativo 		 char(1) default 'S' not null,
    constraint pk_login_id_login primary key (id_login),
    constraint ck_login_st_administrador check  (st_administrador in ('S','N')),
	constraint ck_login_st_ativo 		 check  (st_ativo 		  in ('S','N')),
	constraint uq_login_tx_login 		 unique (tx_senha)
)


ALTER TABLE cofipe.tbl_login COMMENT='Representa a tabela de usuários. Apenas dois tipo de usuários é possivel, administrador sim ou não.';
ALTER TABLE cofipe.tbl_login MODIFY COLUMN id_login int(11) auto_increment NOT NULL COMMENT 'chave primaria da tabela auto incremento';

insert into tb_login (tx_primeiro_nome,tx_segundo_nome,tx_login,tx_senha,st_administrador ) values ('Fábio','Oliveira','fabio.oliveira',md5('1234'),'S')

update tb_login set tx_senha = md5('1234') where tx_login = 'fabio.oliveira'


SELECT	id_login,
                                                            st_administrador,
                                                            tx_primeiro_nome,
                                                            tx_segundo_nome,
                                                            tx_login
													FROM tb_login c