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

date_default_timezone_set('America/Sao_Paulo');
  $frm = new TForm('Anexar');
  $frm->addSelectField('des_apoio', 'Apoio:', false, '=-- Selecione --,Alimentação,Março=Março', false);
  $frm->addSelectField('des_apoio2', 'Apoio:', false, 'APOIO|seq_apoio>5k', false);
  
 /*
  $sql = "select des_apoio from apoio where des_apoio = 'Alimentação'";
  $res = TPDOConnection::executeSql($sql);
  d($res);
 */
 
 /*
  $sql = "select des_apoio from apoio";
  $res = TPDOConnection::executeSql($sql);
  d($res);
 */
  
  /*
  $sql = "select des_apoio from apoio where des_apoio=?";
  $res = TPDOConnection::executeSql($sql,array('Alimentação'));
  d($res);
  */
  
  
  /*
  $sql = "select des_apoio from apoio";
  $res = TPDOConnection::executeSql($sql,array('1'));
  d($res);
  */
  
  
  
  //$frm->set('des_apoio','Alimentação');
  //$frm->update($res);
  
  // recuperar retorno do postgres
  
  /*
  $sql = "Insert into apoio (des_apoio) values ('".date("d-m-Y H:i:s", time())."') returning seq_apoio,des_apoio";
  $res = TPDOConnection::executeSql($sql);
  print '<br>Ultimo ID:'.$res['SEQ_APOIO'][0];
  */
  $array = array('31/12/2010','20/12/2010 13:00','luis','100.00');
  //d(TPDOConnection::encodeArray($array));
  /*
  d(TPDOConnection::formatDate('31/12/2010'));
  d(TPDOConnection::formatDate('31/12/2010','dmy'));
  d(TPDOConnection::formatDate('31/12/2010','ymd'));
  d(TPDOConnection::formatDate('2010/12/31','ymd'));
  d(TPDOConnection::formatDate('2010/12/31','dmy'));
  */
  
  /*print strpos('31/12/2010','/').'<br>';
  print strpos('01/12/2010','/',4).'<br>';
  */
  
  $frm->setAction('Atualizar');
  $frm->show();
