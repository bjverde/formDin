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

class TZip extends ZipArchive
{
	private $files=null;
    private $tempFile;
	private $base;
	public function __construct()
	{
		// limpar arquivos temporários
		$e = new TElement();
		$this->base = $e->getBase();
		// limpa diretório temporário
		$t=time();
		$h=opendir($this->base."tmp");
		while($file=readdir($h)) {
    		if(substr($file,0,3)=='tmp')
			{
        		$path=$this->base.'tmp/'.$file;
        		if($t-filemtime($path)>300)
				{
					@unlink($path);
				}
    		}
		}
		closedir($h);
		// apagar arquivos temporários do diretorio tmp/ da aplicação
		$tempDir = './tmp/';
		if( file_exists('./tmp/'))
		{
			$h=opendir($tempDir);
			while($file=readdir($h)) {
    			if(substr($file,0,3)=='tmp')
				{
        			$path=$tempDir.$file;
        			if($t-filemtime($path)>300)
					{
						@unlink($path);
					}
    			}
			}
			closedir($h);
		}
	}
	public function zip($dir,$outFileName=null,$localDir=null)
	{
		if( !is_null($dir))
		{
			$this->files = $this->getFiles($dir);
		}
		if( ! is_array($this->files) || count($this->files)== 0 )
		{
			return null;
		}
		if( is_null( $outFileName ) )
		{

			if( !is_dir( $dir ))
			{
				$aFileParts = pathinfo($dir);
				$baseName = $aFileParts['basename'];
				$fileName = $aFileParts['filename'];
				$this->tempFile = $aFileParts['dirname'].'/tmp'.date('dmYhis').'.zip';
   				$outFileName = $this->tempFile;
			}
			else
			{
				$this->tempFile = preg_replace('/\/\//','/',$dir.'/tmp'.date('dmYhis').'.zip');
   				$outFileName = $this->tempFile;
			}
		}

		if( file_exists( $outFileName))
		{
			@unlik($outFileName);
		}
		$this->open( $outFileName,ZIPARCHIVE::CREATE);
		{
			/*
			if( $x == ZipArchive::ER_MEMORY)
			{
				die('Está utilizando a memoria');
			}
			else
			{
				echo $x;
			}
			die();
			 *
			 */

			$i = 1;
			foreach($this->files as $file)
			{
				if( $i++==100)
				{
					$i=1;
					$this->close();
					$this->open( $outFileName,ZIPARCHIVE::CREATE);

				}
				$this->addFile( str_replace('//','/'
					,$file)
					,( is_null($localDir) ? $file: str_replace($localDir,'', str_replace('//','/',$file ) ) ) ) ;
			}
			$this->close();
		}
		if( file_exists( $outFileName ))
		{
			if( !is_null($this->tempFile) )
			{
				return $outFileName;
			}
			return true;
		}
		return false;

	}
	protected function getFiles($dir)
	{
		$dir = preg_replace('/\/\//','/',$dir);
		if( ! is_dir($dir)  )
		{
			if( !file_exists( $dir ))
			{
				return null;
			}
			else
			{
				$this->files[] = $dir;
				return $this->files;
			}
		}
		$aDir = scandir( $dir );
		foreach($aDir as $d)
		{
			if( $d !='.' && $d !='..'  )
			{
				if( is_dir( $dir.'/'.$d ) )
				{
					$this->getFiles($dir.'/'.$d);
				}
				else
				{
					$this->files[] = str_replace('//','/',$dir.'/'.$d);
				}
			}
		}
		return $this->files;
	}
}
?>