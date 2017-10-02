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

$frm = new TForm('Exemplo do Campo Cor',150,400);
$frm->setColumns(60); // define a largura da primeira coluna ( rotulos ) do formulário.
$frm->addColorPickerField('val_cor1','Cor 1:',false);
$frm->addColorPickerField('val_cor2','Cor 2:',false);
$frm->addColorPickerField('val_cor3','Cor 3:',false);
$arrDados = array();
//$arrDados = null;

$frm->addButton('Definir Cor',null,'btnX','definirCor()');
$frm->addButton('Limpar',null,'btnY','fwClearChildFields()');
$frm->setAction('Atualizar');
$frm->show();
?>
<script>
fwSetColorPicker('val_cor1','#ff0000');
fwSetColorPicker('val_cor2','#00ff00');
fwSetColorPicker('val_cor3','#0000ff');

function definirCor()
{
	fwSetColorPicker('val_cor1','#580000');
	fwSetColorPicker('val_cor2','#800080');
	fwSetColorPicker('val_cor3','#FF00FF');
}
</script>