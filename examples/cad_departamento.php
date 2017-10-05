<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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

$frm = new TForm('Informações Iniciais',780,980);
//$frm = new TForm('Informações Iniciais 2');
//$frm->setFlat(true);
//$frm->setOverflowY(false);

$frm->addHiddenField('seq_documento');
$frm->addHiddenField('num_docibama');
$frm->addHiddenField('seq_andamento');
$frm->addHiddenField('nom_unidade_ibama');
$frm->addHiddenField('cod_unidade_ibama');


//$pc = $frm->addPageControl('pc');
//$aba = $pc->addPage('Cadastro',true,true,'abaX');
//$aba->setOverflowY(true);
//$aba->setHeight(120);

$frm->addHtmlField('gride_andamento_pessoal','gride',null,null);
$frm->addHtmlField('gride_andamento_unidade','gride',null,null);

switch($acao){
	case 'btngride_documentoVisualizar':
		$_SESSION[APLICATIVO]['seq_documento'] = $_POST['seq_documento'];
		$frm->redirect('detalhe_doc');
		break;

	case 'btngride_documentoAndamentoInt';
		$_SESSION[APLICATIVO]['seq_documento'] 			= $_POST['seq_documento'];
		$_SESSION[APLICATIVO]['num_docibama_formatado'] = $_POST['num_docibama'];
		$_SESSION[APLICATIVO]['seq_andamento'] 			= $_POST['seq_andamento'];
		$frm->redirect('cad_andamento_doc');
		break;

	case 'btngride_documentoAndamento';
		$_SESSION[APLICATIVO]['seq_documento']			= $_POST['seq_documento'];
		$_SESSION[APLICATIVO]['num_docibama_formatado'] = $_POST['num_docibama'];
		$frm->redirect('cad_andamento_externo_doc');
		break;

	case 'btngride_documentoLista';
		$_SESSION['RECIBO_ANDAMENTO']['nom_origem'] = $_POST['nom_unidade_ibama'];
		$_SESSION['RECIBO_ANDAMENTO']['seq_unidade_atual'] = $_POST['cod_unidade_ibama'];
		$frm->redirect('mov_grupo_documento',null,true);
		break;
}

// documentos com carga para pessoa logada
$bvars = array('NUM_PESSOA' =>$_SESSION[APLICATIVO]['login']['num_pessoa']);
//recuperarPacote('SISPROT.PKG_PROT_ANDAMENTO.SEL_TELA_INICIAL',$bvars,$resAndamentoPessoal,-1);
$g = new TGrid('gride_andamento_pessoal'
				,'Meus documentos'
				,$resAndamentoPessoal // resultados
				,200 // altura
				,null // largura
				,'SEQ_DOCUMENTO,NUM_DOCIBAMA,SEQ_ANDAMENTO','SEQ_DOCUMENTO,NUM_DOCIBAMA,SEQ_ANDAMENTO',null,null,null,null,null,'grideDrawButtonGeral');
$g->enableDefaultButtons(false);
$g->addColumn('NUM_DOCIBAMA','Número');
$g->addColumn('DES_ORIGEM','Origem');
$g->addColumn('NOM_PESSOA_ORIGEM','Remetente');
$g->addColumn('DES_CLASSIFICACAO','Assunto');
$g->addColumn('NUM_ORIGINAL','Nº Original');
$g->addColumn('DES_TIPO_DOCUMENTO','Tipo documento');
$g->addColumn('DES_ASSUNTO','Obs. documento');
$g->addColumn('NOM_MOVIMENTO','Movimento');
$g->addColumn('DAT_AND_INTERNO','Data');
$g->addColumn('DES_OBSERVACAO','Obs. andamento');
$g->addColumn('QTD_DIAS','Dia (s)',39,'center');
$g->addColumn('DAT_PRAZO','Prazo',39,'center');
$g->addButton('Visualizar','btngride_documentoVisualizar',null,null,null,'analise.gif');
$g->addButton('Andamento','btngride_documentoAndamentoInt',null,null,null,'retornar.gif');
$g->setOnDrawCell('grideDrawCelula');
$g->addFooter('<table border="0" style="float:left;border:none;" cellspacing="0" cellpadding="0">
		<tr>
		<td width="8" height="8" bgcolor="#FF6A6A"></td><td style="font-size:10px;">Prazos vencidos</td><td width="10px" ></td>
		</tr>
		</table>');
$frm->setValue('gride_andamento_pessoal',$g->show(false));

// documentos com carga para unidade da pessoa logada
$bvars = array('COD_DESTINO' =>$_SESSION[APLICATIVO]['login']['cod_unidade_ibama']);
//recuperarPacote('SISPROT.PKG_PROT_DOCUMENTO.SEL_TELA_GERAL',$bvars,$resAndamentoSetor,-1);
$g = new TGrid('gride_andamento_unidade'
				,'Documentos no meu setor'
				,$resAndamentoSetor // resultado
				,200 // altura
				,null // largura
				,'SEQ_DOCUMENTO,NUM_DOCIBAMA','SEQ_DOCUMENTO,NUM_DOCIBAMA',null,null,null,null,null,'grideDrawButton');
$g->enableDefaultButtons(false);
$g->addColumn('NUM_DOCIBAMA','Número',35);
$g->addColumn('DES_ASSUNTO','Assunto',300);
$g->addColumn('DES_TIPO_DOCUMENTO','Tipo Documento',100,'center');
$g->addColumn('DES_ORIGEM','Origem',55,'center');
$g->addColumn('NUM_ORIGINAL','Nº Original',null,'center');
$g->addColumn('SIT_CONFIRMADO','Lista Para Envio',80,'center');
$g->addColumn('QTD_DIAS','Dias no Setor',70,'center');
$g->addColumn('DAT_PRAZO','Prazo',39,'center');
$g->addButton('Visualizar','btngride_documentoVisualizar',null,null,null,'analise.gif');
$g->addButton('Andamento','btngride_documentoAndamento',null,null,null,'retornar.gif');
$g->setOnDrawCell('grideDrawCelula');
$g->addFooter('<table border="0" style="float:left;border:none;" cellspacing="0" cellpadding="0">
		<tr>
		<td width="8" height="8" bgcolor="#FF6A6A"></td><td style="font-size:10px;">Prazos vencidos</td><td width="10px" ></td>
		</tr>
		</table>');
$frm->setValue('gride_andamento_unidade',"<BR><HR><BR>".$g->show(false));

function grideDrawCelula($rowNum,$cell,$objColumn,$aData,$edit){
	if($aData['DAT_PRAZO'] != 'Sem Prazo' && $aData['DAT_PRAZO'] < 0 && $objColumn->getFieldName() == 'DAT_PRAZO')
	{
		$cell->setCss('background-color','#FF6A6A');
	}
}

// documentos com carga para unidade da pessoa logada
$bvars = array('COD_UNIDADE_IBAMA' =>$_SESSION[APLICATIVO]['login']['cod_unidade_ibama']);
//recuperarPacote('SISPROT.PKG_PROT_ANDAMENTO.SEL_DOC_GRUPO_SETOR',$bvars,$resAndamentoLista,-1);
$g = new TGrid('gride_andamento_lista'
				,'Lista de documentos pendentes de andamento'
				,$resAndamentoLista // resultado
				,70 // altura
				,930 // largura
				,'NOM_UNIDADE_IBAMA,COD_UNIDADE_IBAMA','NOM_UNIDADE_IBAMA,COD_UNIDADE_IBAMA',null,null,null,null,null,'grideDrawButton');
$g->enableDefaultButtons(false);
$g->addColumn('SIG_UNIDADE_DESTINO','Destino');
$g->addColumn('DAT_MOVIMENTO','Data da Movimentação');
$g->addButton('Andamento','btngride_documentoLista',null,null,null,'retornar.gif');
$frm->setValue('gride_andamento_lista',"<BR><HR><BR>".$g->show(false));

function grideDrawButton($rowNum,$button,$objColumn,$aData)
{
	if($aData['COD_TIPO_MOVIMENTO'] == 9){
		$button->setEnabled(false);
	}

}
function grideDrawButtonGeral($rowNum,$button,$objColumn,$aData)
{
	if($aData['ULTIMO_ANDAMENTO'] == 9){
		$button->setEnabled(false);
	}
}

$frm->show();
?>
