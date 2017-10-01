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

//require_once 'base/classes/webform/TForm.class.php';

$frm = new TForm( 'Confirmar Pagamento Anvisa' , 260 , 635 );
$frm->setAction( 'Gravar,Limpar' );

$frm->addGroupField( 'grupo_confirma_pagamento' , 'Confirmar Pagamento Anvisa' , NULL , NULL , FALSE );
$frm->addTextField( 'num_ret' , 'N° Ret:' , 10 , TRUE , 10 )->setEnabled( FALSE );
$frm->addTextField( 'des_ret_registro_especial_temp' , 'Descrição do Ret:' , 80 , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'nom_pessoa' , 'Nome da Pessoa:' , 80 , FALSE )->setEnabled( FALSE );
$frm->addCpfCnpjField( 'cpf_cnpj' , 'CPF/CNPJ' , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'end_pessoa' , 'Endereço da Pessoa' , 80 , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'des_bairro' , 'Bairro da Pessoa' , 80 , FALSE )->setEnabled( FALSE );
$frm->addDateField( 'dat_sit_anvisa_pago' , 'Dat. Pagamento' , TRUE );
$frm->closeGroup();

// consulta dinamica por numero de registro
$frm->setOnlineSearch('num_ret'
	, 'AGROTOXICO.PK_REGISTRO_ESPECIAL_TEMP.LIST_RET'
 	, 'NUM_RET|Nº Ret:|10'
 	, 'NUM_RET'
 	, TRUE
	, TRUE
 	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP|Nº Ret,DES_RET_REGISTRO_ESPECIAL_TEMP|Descrição do Ret'
	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP|num_ret,DES_RET_REGISTRO_ESPECIAL_TEMP|des_ret_registro_especial_temp,NOM_PESSOA|nom_pessoa,NUM_CPF_CNPJ|cpf_cnpj,END_PESSOA|end_pessoa,DES_BAIRRO|des_bairro,DAT_SIT_ANVISA_PAGO|dat_sit_anvisa_pago'
 	, 'Consulta por Nº Ret.'
	, 'Registros Encontrados'
 	, NULL
 	, 400
 	, 900
 	, "Consultar"
 	, NULL
 	, NULL
 	, 20
 	, TRUE
 	, NULL
 	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP');

switch ( $acao )
{
  case 'Gravar':
    
    // verifica se a pessoa está tentando executar a mesma ação
    if ( isset( $_SESSION[ 'token' ] ) and ( $_SESSION[ 'token' ] == md5( serialize( $_POST ) ) ) )
    {
      $frm->addJavascript( "alert('Gravação já foi Realizada!');" );
      break;
    } # end iF;
    
    // verifica a validação dos campos.
    if ( $frm->validate() )
    {
      // pega os campos do formulário que vai ser enviado ao pacote para atualizar os dados.
      $bvars = $frm->createBvars( 'num_ret,dat_sit_anvisa_pago' );
      
      // antes de executar pacote é criado a session[token] para verificação antes
      $_SESSION[ 'token' ]  = md5( serialize( $_POST ) );
           
      if( !$arrErro = executarPacote( 'AGROTOXICO.PK_REGISTRO_ESPECIAL_TEMP.ALT_CONFIRM_PAGAMENTO' , $bvars , 0 ) ) 
      {
        $frm->setPopUpMessage('Objeto Gravado com Sucesso!');
        $frm->clearFields();
      }
      else
      {
        $frm->setMessage( $arrErro );
      } # end iF;
      
    } # end iF;
    
    break;
  case 'Limpar':

    //limpando os campos do formulário
	$frm->clearFields();
    
    break;
} # end switch

$frm->show();

?>
