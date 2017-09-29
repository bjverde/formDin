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

class TbTesteDAO extends TPDOConnection
{
	public function tbTesteDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( TbTesteVO $objVo )
	{
		if( $objVo->getId() )
		{
			return $this->update($objVo);
		}
		$values = array(  $objVo->getNome_teste() 
						, $objVo->getData_teste() 
						, $objVo->getNumero_teste() 
						);
		return self::executeSql('insert into tbTeste(
								 nome_teste
								,data_teste
								,numero_teste
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tbTeste where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id
								,nome_teste
								,data_teste
								,numero_teste
								from tbTeste where id = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id
								,nome_teste
								,data_teste
								,numero_teste
								from tbTeste'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( TbTesteVO $objVo )
	{
		$values = array( $objVo->getNome_teste()
						,$objVo->getData_teste()
						,$objVo->getNumero_teste()
						,$objVo->getId() );
		return self::executeSql('update tbTeste set 
								 nome_teste = ?
								,data_teste = ?
								,numero_teste = ?
								where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>
