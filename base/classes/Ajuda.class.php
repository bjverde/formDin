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


if ( !defined('PASTA_BASE') )
	define('PASTA_BASE','base/');
class Ajuda {
	private $strNome=null;
	private $strRotulo=null; // pode ser uma imagem ou texto
	private $strTexto=null;
	private $intLargura=null;
	private $intAltura=null;
	private $strCorFundo=null;
	private $strCorFonte=null;
	private $strArquivoAjuda=null;
	private $strPacoteOracle=null;
	private $strColunaChave=null;
	private $strValorChave=null;
	private $strColunaAjuda;
	private $strPastaBase;
	private $strTitulo=null;

	public function __call( $strMethod, $arrParameters )
	{
		die("O método <b><blink>" . $strMethod . "</blink></b> não foi encontrado na classe <b>" . get_class($this) . "</b>. ");
	}

	public function __construct($strNome=null
										,$strRotulo=null
										,$strTexto=null
										,$intLargura=null
										,$intAltura=null
										,$strCorFundo=null
										,$strCorFonte=null
										,$strArquivoAjuda=null
										,$strPastaBase=null
										,$strPacoteOracle=null
										,$strColunaChave=null
										,$strValorChave=null
										,$strColunaAjuda=null
										,$strTitulo=null )
		{
			$this->setNome($strNome);
			$this->setRotulo($strRotulo);
			$this->setTexto($strTexto);
			$this->setLargura($intLargura);
			$this->setAltura($intAltura);
			$this->setCorFundo($strCorFundo);
			$this->setCorFonte($strCorFonte);
			$this->setArquivoAjuda($strArquivoAjuda);
			$this->setPacoteOracle($strPacoteOracle);
			$this->setColunaChave($strColunaChave);
			$this->setValorChave($strValorchave);
			$this->setColunaAjuda($strColunaAjuda);
			$this->setPastaBase($strPastaBase);
			$this->setTitulo($strTitulo);
		}
		public function setNome($strNome=null)
		{
			if( (string)$strNome == '')
			{
				$strNome = 'campo_ajuda_'.date('his');
				sleep(1);
			}
			$this->strNome = $strNome;
		}
		function getNome()
		{
			return $this->strNome;
		}
		//-------------------------------------------------------
		public function setRotulo($strRotulo=null)
		{
			$this->strRotulo = $strRotulo;
		}
		function getRotulo()
		{
			if((string)$this->strRotulo=='')
			{
				$this->strRotulo = PASTA_BASE.'imagens/ajuda.gif';
			}
			if( strpos( strtolower($this->strRotulo),'.gif')>0 )
			{
				// procurar a imagem nas pastas padrao
				$path='';
				if(!file_exists($this->strRotulo) )
				{
					$path = '../';
					if(!file_exists($path.$this->strRotulo) )
					{
					$path = '../../';
					}
				}
				$this->strRotulo = $path.$this->strRotulo;
			}
			return $this->strRotulo;
		}
		//-------------------------------------------------------
		public function setTexto($strTexto=null)
		{
			$this->strTexto = $strTexto;
		}
		function getTexto()
		{
			$texto =  str_replace("'","`",str_replace('"',"&quot;",str_replace(chr(10),'<br>',$this->strTexto)));
			$texto =  str_replace(chr(13),'',$texto);
			return $texto;
		}
		//-------------------------------------------------------
		public function setLargura($intLargura=null)
		{
			$this->intLargura = ((integer)$intLargura<1) ? 400  : (integer)$intLargura;
		}
		function getLargura()
		{
			return $this->intLargura;
		}
		//-------------------------------------------------------
		public function setAltura($intAltura=null)
		{
			$this->intAltura = ((integer)$intAltura<1) ? 200  : (integer)$intAltura;
		}
		function getAltura()
		{
			return $this->intAltura;
		}
		//-------------------------------------------------------
		public function setCorFundo($strCorFundo=null)
		{
			$this->strCorFundo = ((string)$strCorFundo=='') ? '#FFFFE4'  : (string)$strCorFundo;
		}
		function getCorFundo()
		{
			return $this->strCorFundo;
		}
		//-------------------------------------------------------
		public function setCorFonte($strCorFonte=null)
		{
			$this->strCorFonte = ((string)$strCorFonte=='') ? '#0000FF'  : (string)$strCorFonte;
		}
		function getCorFonte()
		{
			return $this->strCorFonte;
		}
		//-------------------------------------------------------
		public function setArquivoAjuda($strArquivoAjuda=null)
		{
			$this->strArquivoAjuda = (string)$strArquivoAjuda;
		}
		function getArquivoAjuda()
		{
			return $this->strArquivoAjuda;
		}
		//-------------------------------------------------------
		public function setPacoteOracle($strPacoteOracle=null)
		{
			$this->strPacoteOracle = (string)$strPacoteOracle;
		}
		function getPacoteOracle()
		{
			return $this->strNomePacote;
		}
		//-------------------------------------------------------
		public function setColunaChave($strColunaChave=null)
		{
			$this->strColunaChave = (string)$strColunaChave;
		}
		function getColunaChave()
		{
			return $this->strColunaChave;
		}
		//-------------------------------------------------------
		public function setColunaAjuda($strColunaAjuda=null)
		{
			$this->strColunaAjuda = (string)$strColunaAjuda;
		}
		function getColunaAjuda()
		{
			return $this->strColunaAjuda;
		}
		//-------------------------------------------------------
		public function setValorChave($strValorChave=null)
		{
			$this->strValorChave = (string)$strValorChave;
		}
		function getValorChave()
		{
			return $this->strValorChave;
		}
		//-------------------------------------------------------
		public function setPastaBase($strPastaBase=null) {
			if( (string)$strPastaBase<>'' ) {
				if( !file_exists($strPastaBase) ) {
					$strPastaBase = '../'.$strPastaBase;
				}
				if( !file_exists($strPastaBase) ){
					$strPastaBase = '../'.$strPastaBase;
				}
				if( !file_exists($strPastaBase) ){
					print 'Classe Ajuda: Não foi possível encotnrar a pasta base:'.$strPastaBase;
					return;
				}
			}
			$this->strPastaBase = ((string)$strPastaBase==null) ? PASTA_BASE : (string)$strPastaBase;
		}
		function getPastaBase()
		{
			return $this->strPastaBase;
		}
		//-------------------------------------------------------
		public function setTitulo($strTitulo=null)
		{
			$this->strTitulo = (string)$strTitulo;
		}
		function getTitulo()
		{
			return $this->strTitulo;
		}
		//----------------------------------------------------------
		public function getHtml()
		{
			$onClick = 'onClick="exibirAjuda('.
			$this->scape($this->getTexto()).','.
			$this->getLargura().','.
			$this->getAltura().','.
			$this->scape($this->getCorFundo()).','.
			$this->scape($this->getCorFonte()).','.
			$this->scape($this->getArquivoAjuda()).','.
			$this->scape($this->getPastaBase()).','.
			$this->scape($this->getPacoteOracle()).','.
			$this->scape($this->getColunaChave()).','.
			$this->scape($this->getValorChave()).','.
			$this->scape($this->getColunaAjuda()).','.
			$this->scape($this->getTitulo()).');"';
			$strRotulo = $this->getRotulo();
			if(strpos($strRotulo,'.gif') > 0 )
			{
				$strRetorno = '<img style="cursor:pointer;vertical-align:middle;" src="'.$this->getRotulo().'" '.$onClick.'>';
			}
			else
			{
				$strRetorno= '<a style="cursor:pointer;" href="#" '.$onClick.'>'.$strRotulo.'</a>'; //" onMouseOver="this.T_WIDTH=300;this.T_TEXTALIGN=\'left\';return escape('teste do campo ajuda para ver se funciona bem')">Clique aqui para Ajuda on-line</a></span>
			}
			return $strRetorno;
		}
		//------------------------------------------------------------------------------------
		public function scape($strValor)
		{
			if ((string)$strValor=='')
			{
				return 'null';
			}
			else
			{
				return "'".$strValor."'";
			}
		}
}
//$campoAjuda = new Ajuda();
////$campoAjuda->setRotulo('../imagens/ajuda.gif');
//
//print $campoAjuda->getHtml();
?>
