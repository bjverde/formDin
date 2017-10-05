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

class Tb_pedido_itemVO
{
	private $id_item = null;
	private $id_pedido = null;
	private $produto = null;
	private $quantidade = null;
	private $preco = null;
	public function Tb_pedido_itemVO( $id_item=null, $id_pedido=null, $produto=null, $quantidade=null, $preco=null )
	{
		$this->setId_item( $id_item );
		$this->setId_pedido( $id_pedido );
		$this->setProduto( $produto );
		$this->setQuantidade( $quantidade );
		$this->setPreco( $preco );
	}
	//--------------------------------------------------------------------------------
	function setId_item( $strNewValue = null )
	{
		$this->id_item = $strNewValue;
	}
	function getId_item()
	{
		return $this->id_item;
	}
	//--------------------------------------------------------------------------------
	function setId_pedido( $strNewValue = null )
	{
		$this->id_pedido = $strNewValue;
	}
	function getId_pedido()
	{
		return $this->id_pedido;
	}
	//--------------------------------------------------------------------------------
	function setProduto( $strNewValue = null )
	{
		$this->produto = $strNewValue;
	}
	function getProduto()
	{
		return $this->produto;
	}
	//--------------------------------------------------------------------------------
	function setQuantidade( $strNewValue = null )
	{
		$this->quantidade = $strNewValue;
	}
	function getQuantidade()
	{
		return $this->tratarDecimal( $this->quantidade );
	}
	//--------------------------------------------------------------------------------
	function setPreco( $strNewValue = null )
	{
		$this->preco = $strNewValue;
	}
	function getPreco()
	{
		return $this->tratarDecimal( $this->preco );
	}
	//--------------------------------------------------------------------------------
	function tratarDecimal($valor=null)
	{
		// alterar a virgula por ponto nos campos decimais
		$posPonto = ( int ) strpos( $valor, '.' );
		$posVirgula = ( int ) strpos( $valor, ',' );

		if ( $posVirgula > $posPonto )
		{
			if ( $posPonto && $posVirgula && $posPonto > $posVirgula )
			{
				$valor = preg_replace( '/\,/', '', $valor );
			}
			else
			{
				$valor = preg_replace( '/,/', ' ', $valor );
				$valor = preg_replace( '/\./', '', $valor );
				$valor = preg_replace( '/ /', '.', $valor );
			}
		}
		return $valor;
	}
}
?>