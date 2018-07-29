# formDin

![Logo formDin](https://raw.githubusercontent.com/bjverde/formDin/master/base/imagens/formdin_logo.png)


FormDin or Dynamic Form is a simple php Framework for creating web system quickly and easily.
This version is a **FormDin 4 Fork from [Brazilian Public Software Portal.](https://softwarepublico.gov.br/social/formdin)**

*unfortunately the documentation in English is not complete. The first language is Brazilian Portuguese. Translations are made as far as possible.*


## About

Created in 2004 by Luís Eugênio Barbosa to increase the speed of development in IBAMA. Version 4 is based on the ideas of the [Adianti Framework of Pablo Dall'Oglio](http://www.adianti.com.br/framework-library).

FormDin is made up of a set of software components that provide a basic architecture for developing web applications based on a main menu, data entry forms, and reports.

The application structure used by FormDin consists of three classes namely: TApplication, TForm and TPDOConnection. They are responsible for implementing the MVC (Model, View and Controller) standard. The TApplication (controller) class is responsible for receiving the requisitions and performing the relevant actions. The TForm class (view) is responsible for creating the data entry forms. The TPDOConnection (model) class is responsible for retrieving and writing information to the database.


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

* arquivos do projeto
    * UTF-8 
    * retorno do carro formato Windows
* PHP 5.6.x ou superior (compativel como 7.2.0)
![Logo PHP&](https://files.phpclasses.org/files/blog/file/php7.png)

[Na Wiki terá informações completas e detalhas sobre](https://github.com/bjverde/formDin/wiki/Informações-técnicas-e-Arquitetura):
* Branchs
* Arquiteturas
* Bibliotes utilizadas


### Bibliotecas utilizadas
* fPDF 1.81
* PHPUnit
* CaptchaSecurityImages 
* JQuery 1.6
* [jQuery UI Layout Plug-in](http://layout.jquery-dev.com/demos.cfm)
* Ckeditor 3.6
* TinyMCE 3.3.4 (2010-04-27)
* [Font Awesome Icons 5.0.6](https://fontawesome.com/icons?d=gallery) 

## Instalação.

[Wiki com informações completas e detalhadas](https://github.com/bjverde/formDin/wiki)

## Versões
[See the full list of abstracts on the wiki](https://github.com/bjverde/formDin/wiki/Vers%C3%B5es-e-versionamento)

* [4.2.4 - 2018/06/17 tag v4.2.4](https://github.com/bjverde/formDin/releases/tag/v4.2.4)
   * :hammer: Work with Postgres SQL 10.4
   * :white_check_mark: 145 PHPUnit tests
   * :bug: Greater compatibility with php 7.2.4

* [4.2.3 - 2018/06/14 tag v4.2.3](https://github.com/bjverde/formDin/releases/tag/v4.2.3)
   * :hammer: Connect on more than database
   * :bug: Bug strtolower

* [4.2.2 - 2018/04/03 tag v4.2.2](https://github.com/bjverde/formDin/releases/tag/v4.2.2)
   * :hammer: novo metodo para trabalhar com data
   * :hammer: [consulta pagina aceitando Zero.](https://github.com/bjverde/formDin/commit/fb05317219c28e8b25aa9ee8f768989e2c44c86d)
   * :bug: 3 correções
   * :memo: melhoria na documentação interna

* [4.0.0 - 2017/09/22 tag v4.0.0](https://github.com/bjverde/formDin/releases/tag/v4.0.0) 
   * Versão orignal, conforme enviado pelo Luís Eugênio Barbosa exite uma copia na Brach copyLEB 
