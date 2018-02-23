<?PHP

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

session_start();
include('../classes/banco.inc');
//			header("Pragma: public");
//			header("Expires: 0");
//			header("Cache-Control: private");
//			header("Content-Type: text/plain; charset=utf-8");
$pacote  = $_REQUEST['nomePacote'];
$seq_imagem   = $_REQUEST['valor'];
$extensao = $_REQUEST['extensao'];
if( !file_exists($seq_imagem)){
	print 'arquivo '.$seq_imagem.' não encontrado';
	return;
}
if(!$extensao)
  $extensao='jpeg';

if( $pacote and strrpos($seq_imagem,'.') === false) {
	// $conn = OCILogon("SIFISC","SIFISCDES","DESENV");
	$conn = new Banco();
	$sql="begin :SAIDA:=".$pacote." (".$seq_imagem.",:IMG_LOB); end;";
	//$stmt=OCIParse($clientedb->link,$sql);
	//$stmt=OCIParse($conn,$sql);
	$stmt=OCIParse($conn->link,$sql);
	OCIBindByName($stmt, ':SAIDA',&$saida,150);
	$lob = ocinewdescriptor($conn->link, OCI_D_LOB);
//	$lob = ocinewdescriptor($conn, OCI_D_LOB);
	OCIBindByName($stmt, ':IMG_LOB', &$lob, -1, OCI_B_BLOB);
	@OCIExecute($stmt,OCI_DEFAULT);
	if($lob) {
		@$image = $lob->load();
		if($image) {
			header('Content-Type: image/'.$extensao);
			print $image;
		} else {
			print '<center>Imagem<br>não<br>cadastrada</center>';
		}
	}
} else {
	print '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td style="vertical-align:center;text-align:center;border:0px dashed silver;">';
	print '<img src="'.$seq_imagem.'" alt="imagem">';
	print '</td></tr></table>';

}
?>
