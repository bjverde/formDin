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

class Tb_pedido_itemDAO extends TPDOConnection {
	
	public static function insert( Tb_pedido_itemVO $objVo ) {
		if( $objVo->getId_item() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getId_pedido()
						, $objVo->getProduto()
						, $objVo->getQuantidade()
						, $objVo->getPreco()
						);
		return self::executeSql('insert into tb_pedido_item(
								 id_pedido
								,produto
								,quantidade
								,preco
								) values (?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_pedido_item where id_item = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_item
								,id_pedido
								,produto
								,quantidade
								,preco
								from tb_pedido_item where id_item = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_item
								,id_pedido
								,produto
								,quantidade
								,preco
								from tb_pedido_item'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_pedido_itemVO $objVo )
	{
		$values = array( $objVo->getId_pedido()
						,$objVo->getProduto()
						,$objVo->getQuantidade()
						,$objVo->getPreco()
						,$objVo->getId_item() );
		return self::executeSql('update tb_pedido_item set
								 id_pedido = ?
								,produto = ?
								,quantidade = ?
								,preco = ?
								where id_item = ?',$values);
	}
	//--------------------------------------------------------------------------------
    public static function select_itens_pedido($id_pedido = null)
	{
		$dados = self::executeSql('select id_item,produto,quantidade,preco,quantidade*preco as total from tb_pedido_item where id_pedido = ?',array($id_pedido) );
		return $dados;
	}
}