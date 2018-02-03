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
 * Este programa é distribuí1do na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licen?a Pública Geral GNU/LGPL em portugu?s
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

class Tb_blobDAO extends TPDOConnection {

	public static function insert( Tb_blobVO $objVo )
	{
		if( $objVo->getId_blob() ) {
			return self::update($objVo);
		}

        // para mysql
        //$values = array(  $objVo->getNome_arquivo(), file_get_contents($objVo->getTempName()) );
		//self::executeSql("insert into tb_blob (nome_arquivo,conteudo_arquivo) values (?,?)",$values);


		// para sqlite
       	$query = self::prepare("insert into tb_blob (nome_arquivo,conteudo_arquivo) values (?,?)");
       	
       	$fileName = $objVo->getNome_arquivo();
       	$fileOpen = fopen( $objVo->getTempName(), "rb");
       	
       	$query->bindParam(1, $fileName, PDO::PARAM_STR);
       	$query->bindParam(2, $fileOpen, PDO::PARAM_LOB);
		$query->execute();

	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_blob where id_blob = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_blob
								,nome_arquivo
								,conteudo_arquivo
								from tb_blob where id_blob = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_blob
								,nome_arquivo
								from tb_blob'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Tb_blobVO $objVo )
	{
		$values = array( $objVo->getNome_arquivo()
						,$objVo->getConteudo_arquivo()
						,$objVo->getId_blob() );
		return self::executeSql('update tb_blob set
								 nome_arquivo = ?
								,conteudo_arquivo = ?
								where id_blob = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>