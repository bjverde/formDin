# formDin

![Logo formDin](https://raw.githubusercontent.com/bjverde/formDin/master/base/imagens/formdin_logo.png)


FormDin or Dynamic Form is a simple php Framework for creating web system quickly and easily.
This version is a **FormDin 4 Fork from [Brazilian Public Software Portal.](https://softwarepublico.gov.br/social/formdin)**

*unfortunately the documentation in English is not complete. The first language is Brazilian Portuguese. Translations are made as soon as possible.*


## About

Created in 2004 by Luís Eugênio Barbosa to increase the speed of development in IBAMA. Version 4 is based on the ideas of the [Adianti Framework of Pablo Dall'Oglio](http://www.adianti.com.br/framework-library).

FormDin is made up of a set of software components that provide a basic architecture for developing web applications based on a main menu, data entry forms, and reports.

The application structure used by FormDin consists of three classes namely: TApplication, TForm and TPDOConnection. They are responsible for implementing the MVC (Model, View and Controller) standard. The TApplication (controller) class is responsible for receiving the requisitions and performing the relevant actions. The TForm class (view) is responsible for creating the data entry forms. The TPDOConnection (model) class is responsible for retrieving and writing information to the database.

## Environment formDin

In addition to FormDin there are two more closely linked projects.

* [SysGen](https://github.com/bjverde/sysgen) – A System Generator for FormDin
* [formDocker](https://github.com/bjverde/formDocker) – files from Docker Compose to raise everything you need to run formDin in a few commands. 


[Read de Ebook - Learning formDin in steps. Translate By Google Translate](https://translate.googleusercontent.com/translate_c?depth=1&rurl=translate.google.com.br&sl=pt-BR&sp=nmt4&tl=en&u=https://github.com/bjverde/formDin/wiki&xid=17259,15700022,15700124,15700149,15700186,15700190,15700201,15700237,15700242&usg=ALkJrhhZbfs18JT-mbUzWhN0PRRStza9cA)

---

FormDin ou Formulário Dinâmico é um Framework php simples para criar sistema web de forma rápida e fácil.
Essa versão é um **Fork do FormDin 4 do [portal do Software Publico Brasileiro.](https://softwarepublico.gov.br/social/formdin)**


## Sobre o Software

Criado em 2004 por Luís Eugênio Barbosa para aumentar a velocidade de desenvolvimento no IBAMA. A versão 4 é baseada nas ideias do [Adianti Framework do Pablo Dall'Oglio](http://www.adianti.com.br/framework-library). 

O FormDin compõe-se por um conjunto de componentes de software, que proveem uma arquitetura básica para o desenvolvimento de aplicações web baseadas em um menu principal, formulários de entrada de dados e relatórios. 

A estrutura da aplicação utilizada pelo FormDin é composta por três classes a saber: TApplication, TForm e TPDOConnection. Elas são responsáveis pela implementação do padrão MVC ( Model, View e Controller). A classe TApplication (controller) é a responsável por receber as requisições e executar as ações pertinentes. A classe TForm ( view ) é a responsável pela criação dos formulários de entrada de dados. A classe TPDOConnection (model) é a responsável em recuperar e gravar as informações no banco de dados.


![Tela formDin 4.1.5 App01](https://raw.githubusercontent.com/bjverde/formDin/utf8/documents/img/screenshot-2018-2-4_APPEV1_01.png)


![Tela formDin 4.1.5 App02](https://raw.githubusercontent.com/bjverde/formDin/utf8/documents/img/screenshot-2018-2-4_APPEV2_01.png)


## Ambiente formDin
Além do FormDin existem mais dois projetos intimamente ligados.

* [SysGen](https://github.com/bjverde/sysgen) – uma gerador de sistema para FormDin 
* [formDocker](https://github.com/bjverde/formDocker) – arquivos do Docker Compose para levantar tudo que precisa para rodar o formDin em poucos comandos.

## Informações

![Logo PHP 7.3&](https://raw.githubusercontent.com/bjverde/formDin/master/base/imagens/php73_jeqlk3.png)

* arquivos do projeto
    * UTF-8 
    * retorno do carro formato Windows
* Compatível PHP **7.3.x,** 7.2.x, 7.1.x, 7.0.x e 5.6.x

Veja na Wiki 

[Informações completas e detalhas sobre](https://github.com/bjverde/formDin/wiki/Informa%C3%A7%C3%B5es-t%C3%A9cnicas):
* Branchs
* Banco de Dados
* Bibliotes utilizadas
* [Arquitetura do formDin](https://github.com/bjverde/formDin/wiki/Arquitetura-do-formDin)


## Instalação.

[Wiki com informações completas e detalhadas](https://github.com/bjverde/formDin/wiki)

## Versões
[See the full list of abstracts on the wiki](https://github.com/bjverde/formDin/wiki/Vers%C3%B5es-e-versionamento)

* [4.3.1 - 2019/03/11 tag v4.3.1](https://github.com/bjverde/formDin/releases/tag/v4.3.1)
   * :bug: #132 - Fixed Encoding on SQL Server 
   * :bug: #133 - Fixed Encoding on MySQL with Linux
   * :bug: #134 - Fixed js fwAtualizarCampos

* [4.3.0 - 2019/03/06 tag v4.3.0](https://github.com/bjverde/formDin/releases/tag/v4.3.0)
   * :hammer: #122 - create setResponsiveMode 
   * :hammer: #126 - PDF Títulos e Receber Parâmetros
   * :bug: #124 - MySQL Correção UTF8
   * :bug: #128 - MySQL Correção busca caracteres  

* [4.2.6 - 2018/11/30 tag v4.2.6](https://github.com/bjverde/formDin/releases/tag/v4.2.6)
   * :bug: FixBugs to Work with PHP 7.2.X
   * :bug: Erro Grid Mongo
   * :bug: Notice PHP 7.2.X, TGrid
   * :hammer: Busca cep com Via cep
   * :memo: update app exemplos 2.5

* [4.0.0 - 2017/09/22 tag v4.0.0](https://github.com/bjverde/formDin/releases/tag/v4.0.0) 
   * Versão orignal, conforme enviado pelo Luís Eugênio Barbosa exite uma copia na Brach copyLEB 
