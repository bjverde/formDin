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

/*
Módulo de cadastro de modulos
Autor: Luis Eugênio Barbosa
Data Inicio: 10-12-2009
*/

//include('../../classes/webform/TForm.class.php');
// campos do formulario
$frm =  new TForm('Cadastro de Módulos',500,620);
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_modulo');
$frm->addHiddenField('num_pessoa');
$des_titulo = $frm->addTextField('des_titulo'		,'Título'		,100,true,50);
$frm->addTextField('nom_fisico'		,'Nome Físico'	,200,true,60);
$frm->addSelectField('cod_situacao'	,'Situação'		,true);
$frm->addMemoField('des_observacao'	,'Observações'	,1000,false,50,2);
$frm->addMemoField('des_pendencia'	,'Pendências' 	,500,false,50,2);
$frm->addHtmlField('gride');
$frm->setAction('Gravar,Novo');

//$des_titulo->setHint('Hint do campo titulo');
//$frm->setHelpOnLine('Cadastro de Módulos',null,null,'cad_modulo.html');
//$frm->setEnabled(true);
$frm->setHint('Teste do hint do formulario');
// tratamento das acoes do formulario
switch($acao )
{
	//---------------------------------------------------------------------------------
	case 'Novo':
		$frm->clearFields(null,'seq_projeto');
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( $frm->validate() )
		{
			$frm->setValue('nom_fisico',strtolower($frm->getValue('nom_fisico')));
			$bvars = $frm->createBvars('seq_modulo,cod_situacao,des_titulo,des_observacao,des_pendencia,nom_fisico');
			$bvars['SEQ_PROJETO'] = PROJETO;
			if( !$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_MODULO',$bvars,-1) ) )
			{
				$frm->setValue('seq_modulo',$_POST['SEQ_MODULO']);

				// criar o arquivo no disco com um form vazio
				if( strpos( $frm->getValue('nom_fisico'),'/')===false && strpos( $frm->getValue('nom_fisico'),'.')===false )
				{
					$strArquivo = 'modulos/'.$frm->getValue('nom_fisico').'.inc';
					if( file_exists('modulos/') && !file_exists($strArquivo))
					{
						$strConteudo='<?php'."\n".'$frm = new TForm(\''.$frm->getValue('des_titulo').'\');'."\n".'$frm->setAction(\'Atualizar\');'."\n".'$frm->show();'."\n?>";
						umask(2);
						@touch ($strArquivo);
						// verificar se está aberto para escrita
						if ( is_writeable($strArquivo) )
						{
							if (!$handle = fopen($strArquivo, 'w+'))
							{
					    		fclose($handle);
		    					break;
							}
							if (!fwrite($handle, $strConteudo))
	    					{
	    						fclose($handle);
							}
					    }
					    @fclose($handle);
					}
				}
				$frm->clearFields(null,'seq_projeto,seq_modulo');
			}
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('seq_modulo');
		if(!$erro = recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO',$bvars,$res,-1))
		{
			$frm->update($res);
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_excluir':
		$bvars = $frm->createBvars('seq_modulo');
		if(!$erro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_MODULO',$bvars,-1))
		{
			$frm->clearFields(null,'seq_projeto');
		}
	break;
}
// criar o gride
$g = new TGrid('gd'
	,''
	,ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO'
	,null
	,'100%'
	,'SEQ_MODULO'
	,'SEQ_MODULO'
	);
$g->addColumn('DES_TITULO','Título');
$g->setCache(-1);
$g->addColumn('NOM_FISICO','Arquivo Php');
$g->setBvars(array('SEQ_PROJETO'=>PROJETO,'SIT_SISTEMA'=>'N'));
/*
$g->addButton('Alterar');
$g->addButton('Excluir');
*/
$frm->setValue('gride',$g->show(false));

// alimentar combo situacao
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_SITUACAO_MODULO',$bvars,$res));
$frm->setOptionsSelect('cod_situacao',$res,'DES_SITUACAO','COD_SITUACAO');
$frm->show();
?>
