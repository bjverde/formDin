<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	</head>
	<body>
		<h1>ATENÇÃO SIGA AS INFORMAÇÕES ABAIXO</h1>
		<br> 
		<br>Bem vindo ao <?php echo SYSTEM_NAME ?>
		<br>
		<br><b>Esse sistema só irá funcionar depois de criar o banco de exemplo com MySQl.</b>
		<br>
		<br>Execute os scripts abaixo e na ordem via MySql WorkBench ou phpMyAdmin
		<ol>
            <li><a href="https://github.com/bjverde/formDin/blob/master/modelo_banco_exemplos/01_script_criacao_banco.sql">modelo_banco_exemplos/01_script_criacao_banco.sql</a></li>
            <li><a href="https://github.com/bjverde/formDin/blob/master/modelo_banco_exemplos/02_script_inclusao_dados.sql">modelo_banco_exemplos/02_script_inclusao_dados.sql</a></li>
            <li><a href="https://github.com/bjverde/formDin/blob/master/modelo_banco_exemplos/03_script_usuario_banco.sql">modelo_banco_exemplos/03_script_usuario_banco.sql</a></li>
            <li>Se o servidor MySql não for Localhost, altere o arquivo includes/config_conexao.php linha 14 para o seu servidor.</li>
        </ol>
		<br>
		<br>
	</body>
</html>
