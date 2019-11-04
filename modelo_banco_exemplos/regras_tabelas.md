# Regras de Banco
Essas regras devem ser usadas em todos os bancos, porém os tipos são do MySql 5.6

## Regras para tabelas

Formato: ```[<PREFIXO>_]<NOME_TABELA>```

* Utilizar o caractere underline "_" como separador entre palavras.
* Utilizar o seguinte padrão de prefixos:

### Tabelas Gerais
Tabelas relacionadas ao negócio ou requisitos do sistema, utilizadas diretamente pelas aplicações. Tabelas de tipos e associativas modeladas para atender o negócio também devem ser criadas sem prefixos. 

* pessoa
* marca
* telefone

### Tabela de Históricos
Tabelas de históricos para dados de registro temporal. 

* H_ENDERECO_ALTERACAO

### Tabelas de Log

Tabelas de log de auditoria, deve repetir o mesmo nome da tabela auditada após o prefixo. 

* L_COMPRAS

## Regras das VIEWs

 Formato: ```<PREFIXO>_<NOME_VIEW>```

* Utilizar o caractere underline "_" como separador entre palavras.
* Utilizar o prefixo VW



## Regras de campos

* Formato: ```<prefixo><NomeColuna>```
* Utilizar a notação lowerCamelCase (o prefixo em Minúsculas e as palavras seguintes iniciadas com a primeira letra em Maiúscula, unidas sem espaços ou separadores).
* Todo nome de coluna deverá iniciar por um prefixo padrão para designar a categoria à qual pertence o item de dado, conforme tabela abaixo:

Prefixo | Descrição | Tipo | Exemplo
---- | ---- | ---- | ----
id |	Identificador - Chave primária artificial da tabela, geralmente implementada como Identity. As colunas de FK recebem o mesmo nome da coluna PK da tabela-pai (tabela referenciada). Opcionalmente o nome poderá ser complementado com um Sufixo para melhor identificação de seu propósito ou relação com a tabela-pai. O sufixo é utilizado principalmente nos casos em que a tabela possuir mais de uma FK com uma mesma tabela-pai. Por exemplo, uma entidade Pessoa modelada com duas FKs para tabela de UF, criadas como idUFNascimento e idUFResidencia para diferenciá-las.|INT |idFeito, idTipoAssunto, idGrupoDistribuicaoUnidade
cd |	Código - Codificações de objetos resultantes de padrões, domínios ou convenções definidos externamente e com os quais o sistema precisa manter a conformidade. 	| Caractere ou Numérico 	|cdMunicipioIBGE, cdDDI, cdPaisISO
dt |	Data com ou sem hora  |	DATETIME |	dtNascimento, dtInclusao
hr| Horário | TIME | hrInclusao, hrPedido
nm| Nome de algo | VARCHAR | nmPessoa
ds| Descrição - Texto livro para algo mais completo | VARCHAR | dsObservacao
st| Status - Indicador de estado/situação de um objeto com valores do tipo SIM/NÃO.  | CHAR | stAtivo
