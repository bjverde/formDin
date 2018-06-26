# formDin

![Logo formDin](https://raw.githubusercontent.com/bjverde/formDin/master/base/imagens/formdin_logo.png)

FormDin or Dynamic Form is a simple php Framework for creating web system quickly and easily.

FormDin ou Formulário Dinâmico é um Framework php simples para criar sistema web de forma rápida e fácil.

Essa versão é **Fork do FormDin 4 do [portal do software publico.](https://softwarepublico.gov.br/social/formdin)**


## Sobre o Software

Criado por Luís Eugênio Barbosa para aumentar a velocidade de desenvolvimento no IBAMA.

O FormDin compõe-se por um conjunto de componentes de software, que proveem uma arquitetura básica para o desenvolvimento de aplicações web baseadas em um menu principal, formulários de entrada de dados e relatórios. 

A estrutura da aplicação utilizada pelo FormDin é composta por três classes a saber: TApplication, TForm e TPDOConnection. Elas são responsáveis pela implementação do padrão MVC ( Model, View e Controller). A classe TApplication (controller) é a responsável por receber as requisições e executar as ações pertinentes. A classe TForm ( view ) é a responsável pela criação dos formulários de entrada de dados. A classe TPDOConnection (model) é a responsável em recuperar e gravar as informações no banco de dados.

O FormDin iniciou em 2004, a versão 4 é baseada nas ideias do [Adianti Framework do Pablo Dall'Oglio](http://www.adianti.com.br/framework-library). 


![Tela formDin 4.1.5 App01](https://raw.githubusercontent.com/bjverde/formDin/utf8/documents/img/screenshot-2018-2-4_APPEV1_01.png)


![Tela formDin 4.1.5 App02](https://raw.githubusercontent.com/bjverde/formDin/utf8/documents/img/screenshot-2018-2-4_APPEV2_01.png)

### Comparação rápida FormDin x Adianti

O FormDin ficou congelado por alguns anos sem melhorias ou correções, a versão atual está praticamente congelada em 2012. O Adianti continuou evoluindo e tem muito mais recursos. Programadores menos experientes o FormDin pode ser melhor que o Adianti por ser mais simples exigindo um curva menor de aprendizagem.

## Ambiente formDin
Além do FormDin existem mais dois projetos intimamente ligados.

* [SysGen](https://github.com/bjverde/sysgen) – uma gerador de sistema para FormDin 
* [formDocker](https://github.com/bjverde/formDocker) – arquivos do Docker Compose para levantar tudo que precisa para rodar o formDin em poucos comandos.

## Sobre as branchs
* Master - tem as modificações e novidades
* copyLEB - copia de versão original, congelada e sem alterações. Conforme Luís Eugênio Barbosa
Informações [sobre outras branchs veja na wiki](https://github.com/bjverde/formDin/wiki/Informa%C3%A7%C3%B5es-t%C3%A9cnicas-e-Arquitetura#sobre-as-branchs)

## Informações

* arquivos do projeto
    * UTF-8 
    * retorno do carro formato Windows
* PHP 5.4.x ou superior (compativel como 7.1.19)

![Logo PHP&](https://files.phpclasses.org/files/blog/file/php7.png)

### Bibliotecas utilizadas
* fPDF 1.81
* PHPUnit
* CaptchaSecurityImages 
* JQuery 1.6
* [jQuery UI Layout Plug-in](http://layout.jquery-dev.com/demos.cfm)
* Ckeditor 3.6
* TinyMCE 3.3.4 (2010-04-27)

## Instalação.

[Wiki com informações completas e detalhadas](https://github.com/bjverde/formDin/wiki)

**Visão geral da instalação**
1. Tenha um Servidor xAMP (x = sistema operacional, A = Apache, M = MySQL, P = PHP), recomendável xDebug para ambiente de desenvolvimento.
2. Descompactar o projeto em um pasta.
3. Rodar os script SQL da pasta modelo_banco_exemplos
4. Acessar as pastas appexemplo_v para ver os exemplos.

[Manual antigo para instalação](https://github.com/bjverde/formDin/blob/master/documents/Manual_Instalacao_FormDin.pdf)

### O que tem em cada pasta
* appexemplo_form_alone - exemplo de uma pagina sem sistema.
* appexemplo_v1.0 - Exemplos simples de quase todos os recurso possíveis.
* appexemplo_v2.0 - Exemplo de uma sistema conectando no mysql com telas totalmente funcionais. EM CONSTRUÇÃO
* appexemplo_v2.5 - Mesmo sistema que a versão 2.0 só que com o todo controle de acesso e segurança. EM CONSTRUÇÃO
* base - é o local onde toda a magica acontece. Aquim tem o FormDin propriamente dito.
* documents - Documentos e informações.
* modelo_banco_exemplos - todos os scripts do MySQL para funcionar os exemplos 2.0 e 2.5
* phpunit-code-coverage - cobertura de codigo dos testes unitarios 

## Versões
[See the full list of abstracts on the wiki](https://github.com/bjverde/formDin/wiki/Vers%C3%B5es-e-versionamento)
[View the full list of versions](https://github.com/bjverde/formDin/releases)

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

* [4.2.1 - 2018/03/03 tag v4.2.1](https://github.com/bjverde/formDin/releases/tag/v4.2.1)
   * :hammer: **SPECIAL VERSION** alterações feitas para trabalhar com o [SysGen (um gerador de sistema para formDin)](https://github.com/bjverde/sysgen)
   * :bug: diversas correções de bugs
   * :memo: melhoria na documentação
   
* [4.2.0 - 2018/03/08 tag v4.2.0](https://github.com/bjverde/formDin/releases/tag/v4.2.0)
   * :hammer: **SPECIAL VERSION** files in UTF8 format.
   * :hammer: code generator of the CRUD screen of a database entity.
   * :hammer: Error messages in class TFile.
   * :white_check_mark: 114 PHPUnit tests
   * :art: small improvement of css

* [4.0.0 - 2017/09/22 tag v4.0.0](https://github.com/bjverde/formDin/releases/tag/v4.0.0) 
   * Versão orignal, conforme enviado pelo Luís Eugênio Barbosa exite uma copia na Brach copyLEB 
