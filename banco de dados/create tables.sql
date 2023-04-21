drop FUNCTION public.fnc_dominio_s_n;

CREATE FUNCTION public.fnc_dominio_s_n (
  in_coluna_dominio character varying
)
RETURNS text
AS
$body$
DECLARE
  v_retorno TEXT;
BEGIN

	v_retorno :=
    				case
                    	when in_coluna_dominio = 'S' then 'Sim'
                        when in_coluna_dominio = 'N' then 'Não'
    				else
                    	Null
    				end;

  	return v_retorno;
exception
    when others then
		return '';

END;
$body$
LANGUAGE plpgsql;

select  'S'   as codigo , 
		'Sim' as descricao
union
select  'N'   , 
		'Não' 

drop table public.tb_login ;

CREATE TABLE public.tb_login (
	id_login 			serial4 	NOT NULL,
	tx_primeiro_nome 	varchar(50) NOT NULL,
	tx_segundo_nome 	varchar(50) NOT NULL,
	tx_login 			varchar(20) NOT NULL,
	tx_senha 			varchar(100) NOT NULL,
	st_administrador 	bpchar(1) NOT NULL DEFAULT 'N',
	dt_cadastro 		timestamp NOT NULL DEFAULT now(),
	dt_alteracao 		timestamp NULL,
	st_ativo 			char(1) NOT NULL DEFAULT 'S',
	st_excluido 		char(1) NOT NULL DEFAULT 'N',
	CONSTRAINT ck_login_st_administrador CHECK ((st_administrador 	= ANY (ARRAY['S', 'N']))),
	CONSTRAINT ck_login_st_ativo 		 CHECK ((st_ativo   		= ANY (ARRAY['S', 'N']))),
	CONSTRAINT ck_login_st_excluido 	 CHECK ((st_excluido 		= ANY (ARRAY['S', 'N']))),
	CONSTRAINT pk_login_id_login 		 PRIMARY KEY (id_login),
	CONSTRAINT uq_login_tx_login_st_excluido UNIQUE (tx_login, st_excluido)
);


INSERT INTO public.tb_login (tx_primeiro_nome,tx_segundo_nome,tx_login,tx_senha,st_administrador,dt_cadastro,dt_alteracao,st_ativo) VALUES
	 ('Fábio','Oliveira','fabio.oliveira',md5('cofipe'),'S','2023-04-03 21:12:15.116385','2023-04-03 22:03:57.038478','S');

update tb_login set tx_senha = md5('123456')
where id_login = 2

select * from tb_conta_receita tcr 

drop table tb_conta_receita;
create table tb_conta_receita
(
	id_conta_receita     serial4 not null,
	tx_nome              varchar(20) not null,
	tx_descricao		 varchar(500) not null,
	dt_cadastro 		 timestamp NOT NULL DEFAULT now(),
	st_ativo 			 char(1) not null default 'S',
	st_excluido 		 char(1) not null default 'N',
constraint pk_conta_receita primary key (id_conta_receita),
constraint ck_conta_receita_st_ativo check (st_ativo    in ('S', 'N')),
constraint ck_conta_receita_st_excluido check (st_excluido in ('S', 'N')),
constraint uq_conta_receita_tx_nome_st_excluido unique (tx_nome, st_excluido)
);

drop table tb_conta_receita_saldo;
create table tb_conta_receita_saldo
(
	id_conta_receita_saldo  serial4 not null,
	id_conta_receita 	 	int not null,
	dt_data              	date not null,
	tx_descricao		 	varchar(500) not null,
	vl_valor		 		varchar(500) not null,
	dt_cadastro 		 	timestamp NOT NULL DEFAULT now(),
constraint pk_conta_receita_saldo primary key (id_conta_receita_saldo),
constraint fk_conta_receita_saldo_conta_receita foreign key (id_conta_receita) references tb_conta_receita (id_conta_receita)
);

drop table tb_conta_despesa;
create table tb_conta_despesa
(
	id_conta_despesa     serial4 not null,
	tx_nome              varchar(20) not null,
	tx_descricao		 varchar(500) not null,
	dt_cadastro 		 timestamp NOT NULL DEFAULT now(),
	st_ativo 			 char(1) not null default 'S',
	st_excluido 		 char(1) not null default 'N',
constraint pk_conta_despesa primary key (id_conta_despesa),
constraint ck_conta_despesa_st_ativo check (st_ativo    in ('S', 'N')),
constraint ck_conta_despesa_st_excluido check (st_excluido in ('S', 'N')),
constraint uq_conta_despesa_tx_nome_st_excluido unique (tx_nome, st_excluido)
);



INSERT INTO public.tb_conta_receita_saldo (id_conta_receita, dt_data, tx_descricao, vl_valor, dt_cadastro) VALUES(1, '2023-04-01', 'salário abril',1200.00, now());

SELECT 	sd.id_conta_receita_saldo, 
		sd.id_conta_receita, 
		ct.tx_nome,
		ct.tx_descricao,
		sd.dt_data, 
		sd.tx_descricao, 
		sd.vl_valor,
		sd.dt_cadastro 
FROM public._conta_receita_saldo sd
	inner join tb_conta_receita ct on ct.id_conta_receita = sd.id_conta_receita 


with tmp as
(
SELECT 	lc.id_lancamento, 
		--lc.id_conta_receita, 
		rc.tx_nome,
		--lc.id_conta_despesa, 
		ds.tx_nome,
		lc.id_usuario, 
		lc.observacao, 
		lc.dt_data,
		sd.vl_valor::float as vl_saldo,
		lc.valor    
FROM public.tb_lancamento lc
	inner join tb_conta_receita 		rc on rc.id_conta_receita = lc.id_conta_receita
	left  join tb_conta_receita_saldo 	sd on sd.id_conta_receita = rc.id_conta_receita 
	inner join tb_conta_despesa 		ds on ds.id_conta_despesa = lc.id_conta_despesa 
	inner join tb_login 				lg on lg.id_login 		  = lc.id_usuario 
	)
SELECT 	t1.dt_data, 
		t1.valor, 
		t1.vl_saldo - SUM(T2.valor) tt,
		t1.vl_saldo
FROM  tmp AS t1
	left JOIN tb_lancamento AS t2 on t1.dt_data >= t2.dt_data --and t1.id_lancamento > t2.id_lancamento 
GROUP by t1.dt_data,
		 t1.vl_saldo,
		 t1.valor 
ORDER BY dt_data  ASC


SELECT 	t1.id_lancamento, 
		t1.dt_data, 
		t1.valor, 
		SUM(T2.valor) as Soma
FROM  tb_lancamento AS t1
	INNER JOIN tb_lancamento AS t2 on t1.dt_data >= t2.dt_data --and t1.id_lancamento > t2.id_lancamento 
GROUP by t1.id_lancamento, 
		 t1.dt_data, 
		 t1.valor 
ORDER BY 1 ASC
	
SELECT 	lc.id_lancamento, 
		lc.id_conta_receita, 
		rc.tx_nome,
		lc.id_conta_despesa, 
		ds.tx_nome,
		lc.id_login , 
		concat(lg.tx_primeiro_nome,' ',lg.tx_segundo_nome) as tx_login_nome,
		lc.ds_observacao,
		concat('Código:', lc.id_lancamento , ' na Data: ', lc.dt_data::date , ' R$: ', lc.vl_valor   ) as tx_observacao_informativo,
		lc.dt_data,
		lc.vl_valor    
FROM public.tb_lancamento lc
	inner join tb_conta_receita 		rc on rc.id_conta_receita = lc.id_conta_receita
--	left  join tb_conta_receita_saldo 	sd on sd.id_conta_receita = rc.id_conta_receita 
	inner join tb_conta_despesa 		ds on ds.id_conta_despesa = lc.id_conta_despesa 
	inner join tb_login 				lg on lg.id_login 		  = lc.id_login 

	
	
create table tb_lancamento
(
   id_lancamento     serial4  not null,
   id_conta_receita  int,
   id_conta_despesa  int,
   id_login          int,
   dt_data        	 timestamp,
   vl_valor          numeric(18,2),
   ds_observacao     varchar(255),
constraint pk_lancamento primary key (id_lancamento),
constraint fk_lancamento_conta_receita 	foreign key (id_conta_receita) references tb_conta_receita (id_conta_receita),
constraint fk_lancamento_conta_despesa 	foreign key (id_conta_despesa) references tb_conta_despesa (id_conta_despesa),
constraint fk_lancamento_login 			foreign key (id_login) references tb_login (id_login)
);

INSERT INTO public.tb_lancamento (id_conta_receita, id_conta_despesa, id_login, ds_observacao, dt_data,  vl_valor) VALUES(1, 1, 1, 'teste crédito', now(),  100);
INSERT INTO public.tb_lancamento (id_conta_receita, id_conta_despesa, id_login, ds_observacao, dt_data,  vl_valor) VALUES(1, 2, 1, 'teste crédito', now(),  200);
INSERT INTO public.tb_lancamento (id_conta_receita, id_conta_despesa, id_login, ds_observacao, dt_data,  vl_valor) VALUES(1, 3, 1, 'teste crédito', now(),  300);

	
	
SELECT 	id_lancamento, 
		id_conta_receita, 
		id_conta_despesa, 
		dt_data, 
		vl_valor
FROM public.tb_lancamento



	

	
	
	
	
	
	