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

if( !session_id() ) {
	session_start();
}
error_reporting ( 0 );

if ( $_REQUEST[ 'tamanhoMaxAlert' ] ) {
	$tamanho_msg = $_REQUEST[ 'tamanhoMaxAlert' ];
	$tamanhoKb = $_REQUEST[ 'tamanhoMaxBytes' ];
	$tamanho_max = $tamanhoKb;
}
else
{
	$tamanhoKb = $_SESSION[ 'frmFileAsync' ][ $_REQUEST[ 'name' ] ][ 'tamanhoKb' ];
	$tamanho_msg = ( $tamanhoKb > 1024 ? ( $tamanhoKb / 1024 ) . ' MB' : $tamanhoKb . ' KB' );
	$tamanho_max = 1024 * $tamanhoKb;
}
$tiposValidos   	= $_SESSION[ 'frmFileAsync' ][ $_REQUEST[ 'name' ] ][ 'tiposValidos' ];
$msgArquivoInvalido	= 'Apenas arquivos do tipo: '.$tiposValidos;
$tiposValidosRegexp = implode( '|', explode( ',', $_SESSION[ 'frmFileAsync' ][ $_REQUEST[ 'name' ] ][ 'tiposValidos' ] ) );
$callBack = $_REQUEST[ 'callBack' ];

if ( $_REQUEST[ 'messageInvalidFileType' ] )
{
	$msgArquivoInvalido = $_REQUEST[ 'messageInvalidFileType' ];
}

if ( class_exists( 'TElement' ) )
{
	$e = new TElement();
	$_REQUEST[ 'pastaBase' ] = ( isset( $_REQUEST[ 'pastaBase' ] ) && $_REQUEST[ 'pastaBase' ] ) ? $_REQUEST[ 'pastaBase' ] : $e->getBase();
	$e = null;
}
else
{
	$_REQUEST[ 'pastaBase' ] = ( isset( $_REQUEST[ 'pastaBase' ] ) && $_REQUEST[ 'pastaBase' ] ) ? $_REQUEST[ 'pastaBase' ] : 'base/';
}

$pastaBase = $_REQUEST[ 'pastaBase' ];

if ( isset( $_FILES[ 'arquivo' ] ) ) // file was send from browser
{
	// exibir a imagem de "processando"
	sleep ( 1 );

	//teste//local.xls
	$tmpDir = preg_replace( '/\/\//', '/', $pastaBase . '/tmp/' );

	switch( $_FILES[ 'arquivo' ][ 'error' ] )
	{
		case UPLOAD_ERR_OK:
			$filename = $_FILES[ 'arquivo' ][ 'name' ]; // file name
			$tempName = $tmpDir . 'upload_' . md5( session_id() . utf8_encode( utf8_decode( $filename ) ) );

			if ( file_exists( $tempName ) )
			{
				unlink ( $tempName );
			}

			if ( preg_match( '/\.php$/i', $filename ) > 0 )
			{
				$result = 'Por medidas de segurança arquivo com extensão .php não são permitidos.';
				break;
			}
			/*if( move_uploaded_file($_FILES['arquivo']['tmp_name'], $tempName ) )
					$result = 'OK';
			else if( move_uploaded_file($_FILES['arquivo']['tmp_name'], '../'.$tempName ) )
					$result = 'OK';
			else if( move_uploaded_file($_FILES['arquivo']['tmp_name'], '../../'.$tempName ) )
					$result = 'OK';
			else if( move_uploaded_file($_FILES['arquivo']['tmp_name'], '../../../'.$tempName ) )
					$result = 'OK';
			else
			{
				$result = 'Falha na copia do arquivo '.$tempName;
				break;
			}
			*/

			if ( move_uploaded_file( $_FILES[ 'arquivo' ][ 'tmp_name' ], $tempName ) )
			{
				$result = 'OK';
			}
			else
			{
				if ( !file_exists( $tempName ) )
				{
					$path = preg_replace( '/base\//', '', uploadGetBase() );

					if ( move_uploaded_file( $_FILES[ 'arquivo' ][ 'tmp_name' ], $path . $tempName ) )
					{
						$result = 'OK';
					}
					else
					{
						$result = 'Falha na copia do arquivo ' . $path . $tempName;
						break;
					}
				}
				else
				{
					$result = 'Falha na copia do arquivo ' . $tempName;
					break;
				}
			}

			//Remover arquivos antigos
			$t = time();
			//$h=opendir(getcwd().'/../tmp');
			$h = opendir( $tmpDir );

			while( $filetmp = readdir( $h ) )
			{
				if ( substr( $filetmp, 0, 7 ) == 'upload_' )
				{
					//$filepath=getcwd().'/../tmp/'.$filetmp;
					$filepath = $tmpDir . $filetmp;

					if ( $t - filemtime( $filepath ) > 1800 )
					{
						@unlink ( $filepath );
					}
				}
			}
			closedir ( $h );
			break;

		case UPLOAD_ERR_INI_SIZE:
			$result = 'Arquivo maior que configurado no php.ini';
			break;

		case UPLOAD_ERR_FORM_SIZE:
			$result = 'Arquivo maior que permitido (max. ' . $tamanho_msg . ')';
			break;

		case UPLOAD_ERR_PARTIAL:
			$result = 'Upload nao completou';
			break;

		case UPLOAD_ERR_NO_FILE:
			$result = 'Arquivo de upload nao encontrado';
			break;

		case UPLOAD_ERR_NO_TMP_DIR:
			$result = 'Pasta temporaria nao encontrada no servidor';
			break;

		case UPLOAD_ERR_CANT_WRITE:
			$result = 'Nao foi possivel gravar upload no servidor';
			break;

		case UPLOAD_ERR_EXTENSION:
			$result = 'Upload parado devido a extensao';
			break;

			default:
		$result = 'Erro de upload';
			break;
	}
}

if( isset( $_FILES['arquivo'] ) )
{
	if ( $_FILES[ 'arquivo' ][ 'size' ] > $tamanho_max )
	{
		$result = 'Arquivo maior que permitido (max. ' . $tamanho_msg . ')';
	}
}

function uploadGetBase()
{
	$base = '';

	for( $i = 0; $i < 10; $i++ )
	{
		$base = str_repeat( '../', $i ) . 'base/';

		if ( file_exists( $base ) )
		{
			$i = 1000;
			break;
		}
	}
	return $base;
}
?>

<!doctype html public "-//w3c//dtd html 4.0 strict//en" "http://www.w3.org/tr/html4/strict.dtd">
<html>
	<head>
		<style>
			html
				{
				width: 100%;
				height: 100%;
				margin: 0px;
				padding: 0px;
				}

			body
				{
				width: 100%;
				height: 100%;
				padding: 0px;
				margin: 0px;
				overflow: hidden;
				font-family: Arial, Helvetica, Geneva, Sans-Serif;
				background-color: transparent;
				}

			div#btnUpload
				{

				/* IMPORTANT STUFF */
				overflow: hidden;
				position: relative;
				cursor: pointer;
				/* SOME CUSTOM STYLING */
				color: blue;
				font-family: Arial, Helvetica, Geneva, Sans-Serif;
				width: 120px;
				padding-top: 2px;
				margin: 0px;
				text-align: center;
				border: 1px outset silver;
				font-weight: normal;
				font-size: 11px;
				background: #efefef;
				background-color: #E1E1E1;
				background: #ddd url("<?php print $pastaBase?>imagens/fwbuttonbg.gif" ) left center repeat-x;
				}

			div#btnUpload:hover
				{
				background: silver;
				cursor: pointer;
				color: blue;
				text-decoration: underline;
				background: #ddd url("<?php print $pastaBase?>imagens/fwbuttonbg.gif" ) left center repeat-y;
				}

			input#arquivo
				{
				height: 23px;
				cursor: pointer;
				position: absolute;
				top: 0px;
				right: 0px;
				font-size: 100px;
				z-index: 2;
				opacity: 0.0;                   /* Standard: FF gt 1.5, Opera, Safari */
				filter: alpha( opacity = 0 );   /* IE lt 8 */

				-ms-filter: "alpha(opacity=0)"; /* IE 8 */

				-khtml-opacity: 0.0;            /* Safari 1.x */

				-moz-opacity: 0.0;              /* FF lt 1.5, Netscape */
				}
		</style>

		<script type = "text/javascript">

		// função para detectar o browser
		function browser ()
		{
			var b = navigator.appName;
			var v = this.version = navigator.appVersion;
			var ua = navigator.userAgent.toLowerCase();
			this.v = parseInt(v);
			this.safari = ua.indexOf("safari")>-1; // always check for safari & opera
			this.opera = ua.indexOf("opera")>-1; // before ns or ie
			this.ns = !this.opera && !this.safari && (b=="Netscape");
			this.ie = !this.opera && (b=="Microsoft Internet Explorer");
			this.chrome = ua.indexOf('chrome')>-1; // check for google chrome
			this.gecko = ua.indexOf('gecko')>-1; // check for gecko engine
			if (this.ns) {
			   this.ns4 = (this.v==4);
			   this.ns6 = (this.v>=5);
			   this.b = "Netscape";
			}else if (this.ie) {
			   this.ie4 = this.ie5 = this.ie55 = this.ie6 = false;
			   if (v.indexOf('MSIE 4')>0) {this.ie4 = true; this.v = 4;}
			   else if (v.indexOf('MSIE 5')>0) {this.ie5 = true; this.v = 5;}
			   else if (v.indexOf('MSIE 5.5')>0) {this.ie55 = true; this.v = 5.5;}
			   else if (v.indexOf('MSIE 6')>0) {this.ie6 = true; this.v = 6;}
			   this.b = "MSIE";
			}else if (this.opera) {
			   this.v=parseInt(ua.substr(ua.indexOf("opera")+6,1)); // set opera version
			   this.opera6=(this.v>=6);
			   this.opera7=(this.v>=7);
			   this.b = "Opera";
			}else if (this.safari) {
			   this.ns6 = (this.v>=5); // ns6 compatible correct?
			   this.b = "Safari";
			}
			this.dom = (document.createElement && document.appendChild && document.getElementsByTagName)? true : false;
			this.def = (this.ie||this.dom);
			this.win32 = ua.indexOf("win")>-1;
			this.mac = ua.indexOf("mac")>-1;
			this.other = (!this.win32 && !this.mac);
			this.supported = (this.def||this.ns4||this.ns6||this.opera)? true:false;
		};
		var isIE = (document.all);
		/* This function is called when user selects file in file dialog */
		function jsUpload(upload_field)
		{
			try
			{
				window.parent.ajaxRequestCount++;
				if( window.parent.ajaxRequestCount < 1 )
				{
					window.parent.ajaxRequestCount = 1;
				}

			} catch(e) {alert(e.message)}


			// this is just an example of checking file extensions
			// if you do not need extension checking, remove
			// everything down to line
			// upload_field.form.submit();
			var re_text = /\.(<?php print $tiposValidosRegexp?>)$/i;
			// Extract filename. IE returns full path!
			var filename = upload_field.value.replace( /.*[/\\]/, "" );

			/* Checking file type */


			if ( filename.search(/\.php$/i) != -1 )
			{
				alert('Por medidas de sergurança, arquivos com extensão .php não são permitidos.');
				upload_field.form.reset();
				return false;
			}


			if (filename.search(re_text) == -1)
			{
				//alert("Apenas arquivos do tipo (<?php print $tiposValidos?>)");
				alert("<?php print $msgArquivoInvalido?>");
				upload_field.form.reset();
				return false;
			}

			var parDoc = window.parent.document;
			if ( parDoc.getElementById('<?php print $_REQUEST['name']?>') )
			{
				var campo;
				var campoDisabled;
				campo = parDoc.getElementById('<?php print $_REQUEST['name']?>');
				try {
					campoDisabled = parDoc.getElementById('<?php print $_REQUEST['name']?>_disabled');
				} catch(e){}
				if( campo )
				{
					campo.style.background = "url('<?php print $_REQUEST['pastaBase']?>imagens/carregando.gif') no-repeat right";
					//campo.style.backgroundPosition = "left";
					campo.value = filename;
				}
				if( campoDisabled )
				{
					campoDisabled.style.backgroundImage = campo.style.backgroundImage;
					campoDisabled.value = campo.value;
				}
				parDoc.getElementById('<?php print $_REQUEST['name']?>_size').value = -1;
			}
			upload_field.form.submit();
			upload_field.disabled = true;
			return true;
		}
		function jsOnLoad()
		{
			var nav = new browser();
	 		if( nav.chrome )
 			{
 				document.getElementById('arquivo').style.left = "0px";
			}
			var elem = document.getElementById('arquivo');
			var parDoc = window.parent.document;
			var campo = parDoc.getElementById('<?php print $_REQUEST['name']?>');
			var w;
			var campoDisabled;

			try
			{
				window.parent.ajaxRequestCount--;
			} catch(e) {}


			elem.disabled = false;
			if ( campo )
			{
				// encontrar a largura do campo para colocar a imagem no lado direito do campo
				try {
					campoDisabled = parDoc.getElementById('<?php print $_REQUEST['name']?>_disabled');
				} catch(e){}

				if( campoDisabled)
    			{
    				w = campoDisabled.style.width;
				}
				else
				{
    				w = campo.style.width;
				}
				if( w )
				{
					w = parseInt(w.replace(/[^0-9]/g,''))-20;
				}
				w = w || '100';
				if( campo )
				{
					campo.style.backgroundRepeat = "no-repeat";
					campo.style.backgroundPosition = w+"px 0px";
					campo.style.backgroundImage = "";
				}
				if ( campoDisabled)
				{
					campoDisabled.style.backgroundRepeat 	= campo.style.backgroundRepeat;
					campoDisabled.style.backgroundPosition 	= campo.style.backgroundPosition;
					campoDisabled.style.backgroundImage 	= campo.style.backgroundImage;
				}

<?php			if ( isset($result) && $result != 'OK')
				{
					echo 'alert("'.$result.'");'."\n";
?>
					try{
						//parDoc.getElementById('<?php print $_REQUEST['name']?>').style.backgroundImage = "url(<?php print $_REQUEST['pastaBase']?>/imagens/erro.gif)";
						campo.style.backgroundImage = "url(<?php print $_REQUEST['pastaBase']?>/imagens/erro.gif)";

					} catch( e ) {}
					if( campoDisabled )
					{
						//parDoc.getElementById('<?php print $_REQUEST['name']?>_disabled').style.backgroundImage = "url(<?php print $_REQUEST['pastaBase']?>/imagens/erro.gif)";
						campoDisabled.style.backgroundImage = "url(<?php print $_REQUEST['pastaBase']?>/imagens/erro.gif)";
					}

					parDoc.getElementById('<?php print $_REQUEST['name']?>_size').value = -1;
<?php			}
				else
				{
					if ( isset( $result) && $result === "OK" )
					{
?>
<?php
						$aFileParts = pathinfo( $filename );
						$extName 	= $aFileParts[ 'extension' ];
?>
						parDoc.getElementById('<?php print $_REQUEST['name']?>_size').value = <?php print '"'.$_FILES['arquivo']['size'].'";'."\n"?>
						parDoc.getElementById('<?php print $_REQUEST['name']?>_type').value = <?php print '"'.$_FILES['arquivo']['type'].'";'."\n"?>
						parDoc.getElementById('<?php print $_REQUEST['name']?>_temp_name').value = <?php print '"'.str_replace($_REQUEST['pastaBase'],'',$tempName).'";'."\n"?>
						parDoc.getElementById('<?php print $_REQUEST['name']?>_extension').value = <?php print '"'.$extName.'";'."\n"?>
						img = parDoc.getElementById('<?php print $_REQUEST['name']?>_btn_delete');
						try
						{
							if( img.getAttribute('src').indexOf('_disabled') != -1 )
							{
								img.setAttribute('src', img.getAttribute('src').replace('_disabled','') );
							}
						}catch(e){}
						<?php if( $callBack ){print 'try {parent.'.str_replace('()','',$callBack).'("'.$tempName.'","'.$filename.'","'.$_FILES['arquivo']['type'].'","'.$_FILES['arquivo']['size'].'","'.$extName.'");} catch(e){}';}?>
<?php				}
?>
					campo.style.backgroundImage = "";
					if( campoDisabled)
					{
						campoDisabled.style.backgroundImage = "";
					}
<?php			}
?>			}
		}
		function habilitarBotao(trueFalse)
		{
			document.getElementById('arquivo').disabled = ! trueFalse;
		}
		</script>
	</head>

	<body onload = "jsOnLoad()">
		<?php echo '<form action="' . $_SERVER[ "REQUEST_URI" ] . '" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="' . $tamanho_max . '" />
	<div id="btnUpload">
	<input type="file" name="arquivo" id="arquivo" onChange="jsUpload(this)" title="Clique aqui para selecionar um arquivo!">
	Selecionar Arquivo
	</div>
</form>'; ?>
	</body>
</html>