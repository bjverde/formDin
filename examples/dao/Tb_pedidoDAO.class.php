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

class Tb_pedidoDAO extends TPDOConnection
{
	public function tb_pedidoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Tb_pedidoVO $objVo )
	{

		if( $objVo->getId_pedido() != 'Novo' )
		{
			return self::update($objVo);
		}
		$values = array( $objVo->getData_pedido()
						, $objVo->getNome_comprador()
						, $objVo->getForma_pagamento()
						);
		self::executeSql('insert into tb_pedido(
								 data_pedido
								,nome_comprador
								,forma_pagamento
								) values (?,?,?)', $values );
		return  self::executeSql('select last_insert_rowid() as ID_PEDIDO');
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_pedido where id_pedido = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_pedido
								,data_pedido
								,nome_comprador
								,forma_pagamento
								from tb_pedido where id_pedido = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_pedido
								,data_pedido
								,nome_comprador
								,forma_pagamento
								from tb_pedido'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_pedidoVO $objVo )
	{
		$values = array( $objVo->getData_pedido()
						,$objVo->getnome_comprador()
						,$objVo->getForma_pagamento()
						,$objVo->getId_pedido() );
		return self::executeSql('update tb_pedido set
								 data_pedido = ?
								,nome_comprador = ?
								,forma_pagamento = ?
								where id_pedido = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>