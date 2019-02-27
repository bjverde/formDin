<?php
// simulação de dados para o gride
$dados = null;
$dados['ID'][]    = 1;
$dados['NOME'][]  = 'Linha1';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['VALOR'][] = '7';


$dados['ID'][]    = 2;
$dados['NOME'][]  = 'Linha2';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'A';
$dados['VALOR'][] = '4';


$dados['ID'][]    = 3;
$dados['NOME'][]  = 'Linha3';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'função';
$dados['VALOR'][] = '5';

$dados['ID'][]    = 4;
$dados['NOME'][]  = 'Linha4';
$dados['ATIVO'][] = 'N';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '10';


$dados['ID'][]    = 5;
$dados['NOME'][]  = 'Linha5';
$dados['ATIVO'][] = 'S';
$dados['GRUPO'][] = 'C';
$dados['VALOR'][] = '3';


$frm = new TForm('Exmplo PDF 06 - Gride chamando PDF');

$html1 = '<b>ATENÇÃO</b>: Quando a ATIVO=N desativa os botões. Faz uso da função setVisible';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

$mixUpdateFields = 'ID|ID'
                  .',NOME|NOME'
                  .',ATIVO|ATIVO'
                  .',GRUPO|GRUPO'
                  .',VALOR|VALOR'
                  ;

$gride = new TGrid('gdTeste' // id do gride
                , 'Título do Gride' // titulo do gride
                );
$gride->addKeyField( 'ID' ); // chave primaria
$gride->setData( $dados ); // array de dados
$gride->setUpdateFields($mixUpdateFields);
                
$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$gride->addColumn('VALOR', 'Valor');

$gride->addButton('Imprimir', null, null, 'openModalPDF(ID,ID)');


$frm->addHtmlField('gride', $gride);

$frm->setAction('POST PAGINA');
$frm->show();


?>
<script>
function openModalPDF(campo,valor) {
	var dados = fwFV2O(campo,valor); // tranforma os parametros enviados pelo gride em um objeto 
	console.log(dados);
	var jsonParams = {"modulo" : "pdf/exe_pdf06.php"
		             ,"titulo" : "Mostra PDF "+dados['NOME'] 
		             ,"dados"  :dados
		            };
	fwShowPdf(jsonParams);
}
</script>
