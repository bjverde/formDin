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

  $frm = new TForm('Cadastro Exemplo',300);
  $frm->setColumns(array(150,200,300));
  
  $frm->addHiddenField('seq_fruta');
  $frm->addTextField('nom_fruta','Nome:',50,true,50);
  $frm->addNumberField('val_fruta','Preço:',10,true,2);
  $frm->addDateField('dat_compra','Aquisição:',true);
  
  $frm->addSelectField('sit_cancelado','Cancelado:',true);
  $frm->addMemoField('obs_fruta','Observação:',200,false,50,5);
  
  
  $frm->setAction('Gravar,Limpar');
 switch($acao)
  {
  	  case 'Limpar':
  	  	$frm->clearFields();
  	  break;
  	  //-----------------------------------------------------------------------
  	  case 'Gravar':
		if( $frm->validate())
		{
			$bvars = $frm->createBvars('seq_fruta,nom_fruta,val_fruta,seq_moeda,dat_compra,sit_cancelado,obs_fruta');
			if( !$frm->addError( executarPacote('TESTE.PKG_FRUTA.INC_ALT', $bvars ) ) )
			{
				$frm->setMessage('Gravação ok');
				//$frm->clearFields();
				$frm->setValue('seq_fruta',$bvars['SEQ_FRUTA']);
			}
		}
  	  //-----------------------------------------------------------------------
  	  case 'Excluir':
 			$bvars = $frm->createBvars('seq_fruta');
			$frm->addError( executarPacote('TESTE.PKG_FRUTA.EXC', $bvars));
			$frm->clearFields();
  	  break;
  	  //------------------------------------------------------------------------
  	  case 'Alterar':
  			$bvars = $frm->createBvars('seq_fruta');
			$frm->addError( recuperarPacote('TESTE.PKG_FRUTA.SEL', $bvars,$res,-1));
			$frm->update($res);
  	  break;
  	  //------------------------------------------------------------------------
		
  }
  $frm->show();
?>
