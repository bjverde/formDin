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
$dados['GRUPO'][] = 'C';
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


$frm = new TForm('Gride Draw 05 - addFooter e cor da linha', 700, 700);

$html1 = '<b>ATENÇÃO</b>: Quando a ATIVO=N desativa os botões. Faz uso da função setVisible'
         .'<br>Quando a ATIVO=S printa a linha.';
$frm->addHtmlField('html1', $html1, null, null, null, null)->setCss('border', '1px solid #ffeb3b')->setCss('background-color', '#ffffcc')->setCss('margin-bottom', '10px');

//----------------------------------------------------------------------
//----------------------------------------------------------------------
$gride = new TGrid('gdTeste' // id do gride
                , 'Título do Gride' // titulo do gride
                , $dados   // array de dados
                , null     // altura do gride
                , null     // largura do gride
                , 'ID');   // chave primaria

$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100);
$gride->addColumn('ATIVO', 'Ativo');
$gride->addColumn('GRUPO', 'grupo');
$gride->addColumn('VALOR', 'Valor');

$gride->addbutton('Alterar', $gride->getId() .'_alterar', null, null, null, 'alterar.gif', null, 'Alterar' );
$gride->addButton('Excluir', $gride->getId() .'_excluir', null, 'fwGridConfirmDelete()', null, 'lixeira.gif', null, 'Excluir' );
$gride->addButton('Detalhes', null, null, 'openModal(ICODIGO,ICODIGO)');

$gride->setOnDrawRow('grdAoDesenharLinha');
$gride->setOnDrawActionButton('confButton');

$gride->addFooter('<table border="0" style="float:left;border:none;" cellspacing="0" cellpadding="0">
					<tr>
						<td width="10px"></td>
						<td width="60px" height="8" bgcolor="#c7e7fd" style="font-size:10px;color:blue;">Demandado</td><td width="10px" ></td>
					</tr>
                 </table>');
$frm->addHtmlField('gride', $gride);


$frm->addHtmlField('html2', '<br><br>', null, null, null, null);
//----------------------------------------------------------------------
//----------------------------------------------------------------------
$gride = new TGrid('gdTeste2' // id do gride
                , 'Título do Gride 2' // titulo do gride
                , $dados   // array de dados
                , null     // altura do gride
                , null     // largura do gride
                , 'ID');   // chave primaria

$gride->addColumn('ID', 'id');
$gride->addColumn('NOME', 'Nome', 100);
$gride->addColumn('ATIVO', 'Ativo',null,'center');
$gride->addColumn('GRUPO', 'grupo',null,'center');
$gride->addColumn('VALOR', 'Valor');

$gride->addbutton('Alterar', $gride->getId() .'_alterar', null, null, null, 'alterar.gif', null, 'Alterar' );
$gride->addButton('Excluir', $gride->getId() .'_excluir', null, 'fwGridConfirmDelete()', null, 'lixeira.gif', null, 'Excluir' );

$colorQtdInscritos = '#009900';
$columnQtdInscritos = $gride->getColumn('ATIVO');
$columnQtdInscritos->setCss('color',$colorQtdInscritos); 
$msgPacientesInscritos = '<span style="color:'.$colorQtdInscritos.';"><strong>Pacientes inscritos(*):</strong> Quantidade de pacientes inscritos na prevenção.</span>';

$colorQtdInscricoes = '#b30000';
$columnQtdInscricoes = $gride->getColumn('GRUPO');
$columnQtdInscricoes->setCss('color',$colorQtdInscricoes); 
$msgNrInscricoes = '<br><span style="color:'.$colorQtdInscricoes.';"><strong>Nr. inscrições(*):</strong> Quantidade de pacientes inscritos multiplicado pelos horários escolhidos por eles na inscrição.</span>';    

$gride->addFooter($msgPacientesInscritos.$msgNrInscricoes);

$frm->addHtmlField('gride2', $gride);






$frm->setAction('POST PAGINA');
$frm->show();

function grdAoDesenharLinha($objLinha,$linhaNum,$res) {
    if ($res['ATIVO'] == 'S'){
        $objLinha->setCss('background-color','#c7e7fd')->setCss('color','blue'); //('background-color','#ffbbda')->setCss('color','#db49ac'); rosa
    }
}

function confButton($rowNum, TButton $button, $objColumn, $aData)
{
    if ($aData['ATIVO']=='N') {
        $Property = $button->getProperty('name');
        if($Property == 'gdTesteDetalhes'){
            $button->setVisible(false);
        }
    }
}

?>
<script>

//Window.keepMultiModalWindow=true;
function openModal(campo,valor) {
	var dados = fwFV2O(campo,valor); // tranforma os parametros enviados pelo gride em um objeto 
	
    fwModalBox(dados['SNOME'],'index.php?modulo=layouts.php',350,400,null,dados);
}
</script>
