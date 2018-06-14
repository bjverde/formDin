<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
 * Criado por Luís Eugênio Barbosa
 * Essa versão é um Fork https://github.com/bjverde/formDin
 *
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */


/*
 // script para a criação da tabela no sqlite
 CREATE TABLE [tb_arquivo] (
 [id_arquivo] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
 [nome_arquivo] varchar(200)  NULL
 )
 */

$fileFormat = 'jpg,txt,gif,doc,pdf,xls,odt';
$fileSize = '2M';

$frm = new TForm('Cadastro e Exibição de LOBS Salvando Caminho no Banco de Dados', 500);
$frm->addHiddenField('id_arquivo'); // coluna chave da tabela
$frm->addHtmlField('obs', '<center><h3><b>Este exemplo mostra como salvar o endereço do arquivo no banco de dados e depois visualiza-lo.<br>Está utilizando o banco de dados bdApoio.s3db ( SQLite ) e a tabela é a tb_arquivo.</b></h3></center>');

// campo para upload do arquivo
$frm->addHtmlField('html1', 'Arquivo de tamanho maximo de '.$fileSize.' e nos formatos: '.$fileFormat, null, 'Dica:', null, 300)->setCss('border', '1px dashed blue');
$frm->addFileField('conteudo_arquivo', 'Anexo:', false, $fileFormat, $fileSize, 60, null, null, 'aoAnexar');

// grupo para exibir as informações do arquivo selecionado
$frm->addGroupField('gpDadosArquivo', 'Informações do Arquivo')->setReadOnly(true);
    $frm->addTextField('nome_arquivo', 'Nome do Arquivo:', 60, false, 60);
    $frm->addTextField('tamanho_arquivo', 'Tamanho:', 10);
    $frm->addTextField('tipo_arquivo', 'Tipo:', 60);
$frm->closeGroup();

// criar os botões no rodapé do formulário
$frm->setAction('Salvar,Limpar');

$acao = isset($acao) ? $acao : null;
switch ($acao) {
    case 'Salvar':
        $vo = new Tb_arquivoVO();
        $frm->setVo($vo);
        $vo->setTempName($frm->getBase() . $_POST[ 'conteudo_arquivo_temp_name' ]);
        Tb_arquivoDAO::insert($vo);
        break;
    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;
    //--------------------------------------------------------------------
    case 'gdArquivos_excluir':
        Tb_arquivoDAO::delete($frm->get('id_arquivo'));
        break;
    //--------------------------------------------------------------------
}

// criar o gride com os arquivos já anexados
$dados = Tb_arquivoDAO::selectAll('nome_arquivo');
$g = new TGrid('gdArquivos', 'Arquivos Gravados', $dados, null, null, 'ID_ARQUIVO');
$g->addColumn('id_arquivo', 'Código', 100, 'center');
$g->addColumn('nome_arquivo', 'Nome do Arquivo', 3000);
$g->addColumn('imagem', 'Conteúdo', 100, 'center');
$g->setCreateDefaultEditButton(false); // não exibir o botão de edição no gride
$g->setOnDrawCell('configurarCelula'); // colocar uma imagem com o link para visualizar o conteudo do arquivo na coluna "imagem" do gride

// exibir o gride na tela dentro do campo html
$frm->addHtmlField('gride', $g);

// exibir o formulário
$frm->show();

// função chamada pela classe TGrid para manipulação dos dados das celulas
function configurarCelula($rowNum = null, $cell = null, $objColumn = null, $aData = null, $edit = null)
{
    // se for a coluna imagem, adicionar um botão
    if ($objColumn->getFieldName() == 'imagem') {
        $btn = new TButton('btn' . $rowNum, null, null, 'fwModalBox("Visualização do Arquivo","arquivos/'. $aData[ 'NOME_ARQUIVO' ] . '")', null, 'analise.gif', null, 'Visualizar o Arquivo');
        $cell->add($btn);
    }
}
?>

<script>
    function aoAnexar(temp, nome, tipo, tamanho)  {
        //alert( temp+'\n'+file+'\n'+type+'\n'+size);
        jQuery("#nome_arquivo").val(nome);
        jQuery("#tamanho_arquivo").val(tamanho);
        jQuery("#tipo_arquivo").val(tipo);

        if (tamanho > 0) {
            fwConfirm('Deseja visualizar o arquivo ' + nome, function(resposta) {
                if (resposta == true) {
                        fwShowTempFile(temp, tipo, nome);
                    }
                }
                );
            }
        }
</script>
