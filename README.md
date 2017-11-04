# formDin

![Logo formDin](https://raw.githubusercontent.com/bjverde/formDin/master/base/imagens/formdin_logo.png)

formDin ou Formulário Dinâmico - Framework PHP para desenvolvimento rápido de sistemas web. Essa versão é **Fork do FormDin 4 do [portal do software publico.](https://softwarepublico.gov.br/social/formdin)**


## Sobre o Software

Criado por Luís Eugênio Barbosa para aumentar a velocidade de desenvolvimento no IBAMA.

O FormDin compõe-se por um conjunto de componentes de software, que proveem uma arquitetura básica para o desenvolvimento de aplicações web baseadas em um menu principal, formulários de entrada de dados e relatórios. 

A estrutura da aplicação utilizada pelo FormDin é composta por três classes a saber: TApplication, TForm e TPDOConnection. Elas são responsáveis pela implementação do padrão MVC ( Model, View e Controller). A classe TApplication (controller) é a responsável por receber as requisições e executar as ações pertinentes. A classe TForm ( view ) é a responsável pela criação dos formulários de entrada de dados. A classe TPDOConnection (model) é a responsável em recuperar e gravar as informações no banco de dados.

O FormDin inciou em 2004, a versão 4 é baseada nas idéias do [Adianti Framework do Pablo Dall'Oglio](http://www.adianti.com.br/framework-library).  

### Comparação radipa FormDin x Adianti

O FormDin ficou congelado por alguns anos sem melhorias ou correções, a versão atual está praticamente congelada em 2012. O Adianti continou evoluindo e tem muito mais recursos. Programadores menos experientes o FormDin pode ser melhor que o Adianti por ser mais simples exigindo um curva menor de aprendizagem.


## Sobre as branchs
* Master - tem as modificações e novidades
* copyLEB - copia de versão original, congelada e sem alterações. Conforme Luís Eugênio Barbosa
* UTF-8 - Um tentativa para deixar o projeto com o formato UTF-8. 
* ANSI - Uma copia do master

## Informações

* arquivos do projeto
    * ANSI
    * retorno do carro formato Windows
* PHP 5.4.x ou superior

### Bibliotecas utilizadas
* fPDF 1.81
* Ckeditor 3
* JQuery 1.6

## Instalação.

Baixe o projeto em coloque um servidor PHP.

### O que tem em cada pasta
* appexemplo_form_alone - exemplo de uma pagina sem sistema.
* appexemplo_v1.0 - Exemplos simples de quase todos os recurso possíveis.
* appexemplo_v2.0 - Exemplo de uma sistema conectando no mysql com telas totalmente funcionais. EM CONSTRUÇÃO
* appexemplo_v2.5 - Mesmo sistema que a versão 2.0 só que com o todo controle de acesso e segurança. EM CONSTRUÇÃO
* base - é o local onde toda a magica acontece. Aquim tem o FormDin propriamente dito.
* documents - Documentos e informações.
* modelo_banco_exemplos - todos os scripts do MySQL para funcionar os exemplos 2.0 e 2.5

## Versões
* 4.1.0 - 31/10/2017 tag v4.1.0 com paginação via SQL para o MySQL
* 4.0.0 - Versão orignal, Brach copyLEB 
