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

//error_reporting(E_ALL);
//error_reporting(E_ALL);
//include('base/classes/FormDin3.class.php');
//include('base/classes/FormDin3.func.inc');
//$a = '08005200222';
//print substr($a,0,4);// . "<BR>" 
//print substr($a,4,3) ;
//print substr($a,7);
//PRINT '<HR>';
//die('fim');

/*
$arrCampos['Salario'] = new CampoDecimal('Salario','Salário:');
$arrCampos['valor'] = new CampoInteiro('valor','Valor:',true,null,1,100,null,3,null,false,'1 a 100',null,null,null,null,true);
$arrCampos['inteiro'] = new CampoInteiro('inteiro','Inteiro:',true,null,null,null,null,10,10);
$arrCampos['tipo'] 	= new CampoSelect('tipo','Tipo:',false,null,array(10=>'Um', 30=>'Dois',20=>'Tres'),null,null,null,null,null,null,null,null,null,null,null,3);
$arrCampos['fone'] 	= new CampoFoneFax('fone','Fone:');
$arrCampos['ajuda_imagem'] 	= new CampoAjuda('ajuda_imagem','','<table border=1><th>Nada</hr><tr><td>do que foi será</td></tr></table>',true,null,null,null,null,null,null,null,null,'AJUDA ON-LINE');
$arrCampos['ajuda_arquivo']	= new CampoAjuda('ajuda_arquivo','','',null,'base/exemplos/ajuda.txt');
*/


$frm = new FormDin3($arrCampos,'Exempo FormDin 3',$_POST);
$frm->adicionarCampoArquivo('nom_arquivo','Anexo:',null,null,'xls,doc,pdf,txt',60);

//$frm->adicionarCampoFoneFax('num_fone','Telefone:',true);
/*
$frm->adicionarGrupo('Grupo 1','gp1',null,null,null,'gpx');
	$frm->adicionarCampoTexto('campo1','Nome:',50);
	$frm->adicionarCampoTexto('campo2','Nome:',50);
	$frm->adicionarCampoTexto('campo3','Nome:',50);
$frm->adicionarGrupo('Grupo 2','gp2',null,null,null,'gpy');
	$frm->adicionarCampoTexto('campo4','Nome:',50);
	$frm->adicionarCampoTexto('campo5','Nome:',50);
	$frm->adicionarCampoTexto('campo6','Nome:',50);
$frm->adicionarGrupo('Grupo 3','gp3');
	$frm->adicionarCampoTexto('campo7','Nome:',50);
	$frm->adicionarCampoTexto('campo8','Nome:',50);
	$frm->adicionarCampoTexto('campo9','Nome:',50);
$frm->javaScript[] = 'abreFechaGrupo(null,"gpx");';
  */

/*
$frm->botaoAcao[''] 		= array('Gravar');
$frm->setEvento('Gravar',	array('onClick'=>"conf();return false;"));
$frm->campos['tipo'] 		= new CampoSelect('tipo','Tipo:',false,null,array(10=>'Um', 30=>'Dois',20=>'Tres'),null,null,'Utilize a tecla CTRL para Marcar/Desmacar a(s) opção(ões)',null,null,null,null,null,null,'',null,3);
$frm->adicionarArquivoJsCss('base/js/jquery/jquery.meio.mask.min.js');
$frm->campos['sac']			= new CampoTexto('sac','SAC:',null,null,null,11,15);
$frm->javaScript[] = 'jQuery("#sac").setMask("9999 999 9999");';

$frm->adicionarCampoFoneFax('num_fone','Telefone:');

$frm->adicionarCampoDecimal('val_salario1','Salário1:',true,null,true,1,10,20);
$frm->adicionarCampoDecimal('val_salario2','Salário2:',true,null,true,2,10,20);
$frm->adicionarCampoDecimal('val_salario3','Salário3:',true,null,true,3,10,20);
$frm->adicionarCampoDecimal('val_salario4','Salário4:',true,null,true,4,10,20);



$frm->adicionarCampoInteiro('qtd_salario','Quantidade8:',true,1,null,8,15,true);
$frm->adicionarCampoInteiro('qtd_salario2','Quantidade2:',true,1,null,2,15,true);
$frm->adicionarCampoInteiro('qtd_salario3','Quantidade3:',true,1,null,3,15,true);
$frm->adicionarCampoInteiro('qtd_salario4','Quantidade4:',true,1,null,4,15,true);
$frm->adicionarCampoInteiro('qtd_salario5','Quantidade5:',true,1,null,5,15,true);
$frm->adicionarCampoTexto('msg','Msg:',100,50);
*/



/*
$frm->adicionarCampoSelect('cod_uf','Uf:');
$frm->adicionarCampoSelect('cod_municipio','Munipio:',null,null,null,null,null,null,null,20);
$frm->combinarSelects('cod_uf','cod_municipio','UF_MUNICIPIO');
$res=null;
$res['COD_UF'][] = 12;
$res['COD_MUNICIPIO'][] = array('1200054','1200138');
$frm->atualizarCampos($res);
$frm->set('cod_uf',12);
$frm->set('cod_municipio',$res['COD_MUNICIPIO']);
$frm->set('cod_municipio',$res['COD_MUNICIPIO'][0] );
*/
/*
$res['TIPO'][0] = NULL;
$res['TIPO'][1] = 20;
$res['TIPO'][2] = 30;
$frm->set('tipo', $res['TIPO'] );
*/

/*
$frm->adicionarCampoTexto('campo1','Campo1',30);
$frm->adicionarCampoTexto('campo2','Campo2',30);
$frm->adicionarCampoTexto('campo3','Campo3',30);

$res['CAMPO1'][] = 111;
$res['CAMPO2'][] = 22222222;
$res['CAMPO3'][] = 33333333;
$frm->atualizarCampos($res,'campo3','campo3');
*/

if($_POST['formDinAcao'] == 'Gravar')
{
	
	$bvars = $frm->criarBvars('nom_arquivo');
	d($bvars);
	//print_r($frm->get('nom_arquivo'));
	/*
	$frm->validar();
	$frm->protegerCampos('cod_municipio');
	$bvars = $frm->criarBvars('cod_municipio,val_salario,num_fone');
	//d($bvars);
	//d($frm->get('cod_uf'));
	//d($_POST);
	*/
}
//d($frm->get('cod_municipio'));

//$frm->set('num_fone','08005200222');

//$frm->set('Salario','-10');
$frm->botaoAcao[''] 		= array('Gravar');
echo $frm->criarForm();
//print_r($_POST);
?>
<script>
function conf()
{
	confirmar('Tem certeza?',simCallBack,naoCallBack);
}
function simCallBack()
{
	//alert('Sim');	
	formDinFazer('Gravar');
}
function naoCallBack()
{
	alert('Não');	
}
</script>
