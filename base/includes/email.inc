<?php
// Mail Mine
//https://pear.php.net/package/Mail_Mime/
require_once('Mail.php');
require_once('Mail/mime.php');

Function enviarEmail( $email_remetente
							,$nome_remetente
							,$email_destinatario
							,$nome_destinatario
							,$assunto
							,$mensagem
							,$anexos
							,$host=null
							,$usuario=null
							,$senha=null
) {

//Tratando a acentuação do campo Nome Remetente($nome_remetente).
if ( utf8_encode($nome_remetente) != $nome_remetente )
    $nome_remetente = "=?iso8859-1?B?".base64_encode($nome_remetente)."?=";
//Tratando a acentuação do campo Nome Destinatário.
 if ( utf8_encode($nome_destinatario) != $nome_destinatario )
    $nome_destinatario = "=?iso8859-1?B?".base64_encode($nome_destinatario)."?=";

//$assunto = "Agendamento On-Line -  Acompanhamento da Solicitação";
//Tratando a acentuação do campo assunto(Subject) da Mala Direta.
if ( utf8_encode($assunto) != $assunto )
	$assunto = "=?iso8859-1?B?".base64_encode($assunto)."?=";

//$mensagem = "   Você está recebendo este e-mail para o acompanhamento de sua solicitação.";

//Montando o cabeçário da mensagem.
$headers['From']    = $nome_remetente.'<'.$email_remetente.'>';
$headers['To']      = $nome_destinatario.'<'.$email_destinatario.'>';
$headers['Subject'] = $assunto;
$headers['MIME-Version'] = '1.0';
$headers['Content-Type'] = 'TEXT/HTML; charset=ISO-8859-1';
$headers['Content-Transfer-Encoding'] = '8BIT';


// Criando uma nova instancia da classe mime
// https://pear.php.net/package/Mail_Mime/
$mime = new Mail_Mime();


// Se vc precisar anexar algum arquivo é aqui que vc faz. Basta colocar a pasta em que o arquivo está.
//$mime->addAttachment("../index.php");
if ($anexos){
	$mensagem.="\nAnexos:$anexos";
	$anexos = explode(',',$anexos);
	foreach ($anexos as $k=>$v) {
		if (file_exists($v)){
	 		$mime->addAttachment($v);
		} else {
			$mensagem.="\nArquivo:$v não encontrado para anexar";
		}
	}
}

// Setar aqui a mensagem de texto, que aparecerá nos webmails que não suportarem msg em formato HTML.
$mime->setTxtBody($mensagem);

//$mime->setHTMLBody();
//$mime->setHTMLBody('<html><body><img src="cab_email.jpg"/><br><br><strong>Kleber Ferreira Gomes</strong></body></html>');

//Aqui vc adiciona a imagem, pode ser um logo, ao cabeçalho do email.
//$mime->addHTMLImage($logotipo);

//Recuperando as informações do email
$corpo_msg = $mime->get();

//Montando o cabeçário.
$hdrs = $mime->headers($headers);

$config = null;
$config['host']		= isset($host)?$host:'relay.ibama.gov.br';
$config['auth'] 	= ( is_null($usuario) ? false: true );
$config['username']	= $usuario;
$config['password']	= $senha;

//Enviando a mensagem
$mail_object =& Mail::factory('smtp',$config);
$send = $mail_object->send($email_destinatario, $hdrs, $corpo_msg);
if($send)
 {
 	return null;
 }
 else
 {
 	return 'Mensagem NÃO foi enviada para '.$email_destinatario;
 }
}
?>