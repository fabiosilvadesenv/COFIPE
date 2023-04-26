CREATE TABLE public.tb_login (
	id_login serial4 NOT NULL,
	tx_primeiro_nome varchar(50) NOT NULL,
	tx_segundo_nome varchar(50) NOT NULL,
	tx_login varchar(20) NOT NULL,
	tx_senha varchar(100) NOT NULL,
	st_administrador bpchar(1) NOT NULL DEFAULT 'N'::bpchar,
	dt_cadastro timestamp NOT NULL DEFAULT now(),
	dt_alteracao timestamp NULL,
	st_ativo bpchar(1) NOT NULL DEFAULT 'S'::bpchar,
	st_excluido bpchar(1) NOT NULL DEFAULT 'N'::bpchar,
	CONSTRAINT ck_login_st_administrador CHECK (((st_administrador)::text = ANY (ARRAY['S'::text, 'N'::text]))),
	CONSTRAINT ck_login_st_ativo CHECK (((st_ativo)::text = ANY (ARRAY['S'::text, 'N'::text]))),
	CONSTRAINT ck_login_st_excluido CHECK (((st_excluido)::text = ANY (ARRAY['S'::text, 'N'::text]))),
	CONSTRAINT pk_login_id_login PRIMARY KEY (id_login),
	CONSTRAINT uq_login_tx_login UNIQUE (tx_login, st_excluido)
);


CREATE TABLE public.tb_conta_receita (
	id_conta_receita serial4 NOT NULL,
	tx_nome varchar(20) NOT NULL,
	tx_descricao varchar(500) NOT NULL,
	dt_cadastro timestamp NOT NULL DEFAULT now(),
	st_ativo bpchar(1) NOT NULL DEFAULT 'S'::bpchar,
	st_excluido bpchar(1) NOT NULL DEFAULT 'N'::bpchar,
	CONSTRAINT ck_conta_receita_st_ativo CHECK ((st_ativo = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
	CONSTRAINT ck_conta_receita_st_excluido CHECK ((st_excluido = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
	CONSTRAINT pk_conta_receita PRIMARY KEY (id_conta_receita),
	CONSTRAINT uq_conta_receita_tx_nome_st_excluido UNIQUE (tx_nome, st_excluido)
);

CREATE TABLE public.tb_conta_receita_saldo (
	id_conta_receita_saldo serial4 NOT NULL,
	id_conta_receita int4 NOT NULL,
	dt_data date NOT NULL,
	tx_descricao varchar(500) NOT NULL,
	vl_valor numeric(18, 2) NOT NULL,
	dt_cadastro timestamp NOT NULL DEFAULT now(),
	CONSTRAINT pk_conta_receita_saldo PRIMARY KEY (id_conta_receita_saldo),
	CONSTRAINT fk_conta_receita_saldo_conta_receita FOREIGN KEY (id_conta_receita) REFERENCES public.tb_conta_receita(id_conta_receita)
);

CREATE TABLE public.tb_conta_despesa (
	id_conta_despesa serial4 NOT NULL,
	tx_nome varchar(20) NOT NULL,
	tx_descricao varchar(500) NOT NULL,
	dt_cadastro timestamp NOT NULL DEFAULT now(),
	st_ativo bpchar(1) NOT NULL DEFAULT 'S'::bpchar,
	st_excluido bpchar(1) NOT NULL DEFAULT 'N'::bpchar,
	CONSTRAINT ck_conta_despesa_st_ativo CHECK ((st_ativo = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
	CONSTRAINT ck_conta_despesa_st_excluido CHECK ((st_excluido = ANY (ARRAY['S'::bpchar, 'N'::bpchar]))),
	CONSTRAINT pk_conta_despesa PRIMARY KEY (id_conta_despesa),
	CONSTRAINT uq_conta_despesa_tx_nome_st_excluido UNIQUE (tx_nome, st_excluido)
);

CREATE TABLE public.tb_lancamento (
	id_lancamento serial4 NOT NULL,
	id_conta_receita int4 NULL,
	id_conta_despesa int4 NULL,
	id_login int4 NULL,
	dt_data date NULL,
	vl_valor numeric(18, 2) NULL,
	tx_observacao varchar(255) NULL,
	CONSTRAINT pk_lancamento PRIMARY KEY (id_lancamento),
	CONSTRAINT fk_lancamento_conta_despesa FOREIGN KEY (id_conta_despesa) REFERENCES public.tb_conta_despesa(id_conta_despesa),
	CONSTRAINT fk_lancamento_conta_receita FOREIGN KEY (id_conta_receita) REFERENCES public.tb_conta_receita(id_conta_receita),
	CONSTRAINT fk_lancamento_login FOREIGN KEY (id_login) REFERENCES public.tb_login(id_login)
);


CREATE OR REPLACE FUNCTION public.fnc_dominio_s_n(in_coluna_dominio character varying)
 RETURNS text
 LANGUAGE plpgsql
AS $function$
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
$function$
;




















