
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

// evita confito do jquery com outras bibliotecas javascript
jQuery.noConflict();


/*
Fonte: http://jsfromhell.com/geral/event-listener
addEvent e removeEvent cross-browser.
addEvent(object: Object, event: String, handler: Function(e: Event): Boolean, [scope: Object = object]): Boolean
	Adiciona uma função que será disparada quando ocorrer determinado evento no objeto.
			object objeto que receberá o listener
			event nome do evento sem o prefixo "on" (click, mouseover, ...)
			handler
			função que será chamada quando o evento ocorrer, será enviado como argumento
				para esta função o objeto de evento, que além das propriedades normais, *sempre* irá conter:
					target: objeto que gerou o evento
					key: código do caractere em eventos de teclado
					stopPropagation: método para evitar a propagação do evento
					preventDefault: método para evitar que a ação default ocorra
				o preventDefault pode ser emulado retornando "false" na função
			scope escopo (quem o "this" irá referenciar dentro do handler) que será usado quando a função for chamada, o default é o objeto no primeiro argumento
removeEvent(object: Object, event: String, handler: function(e: Event): Boolean, [scope: Object = object]): Boolean
		Remove um listener previamente adicionado em um objeto e retorna true em caso de sucesso.
			object objeto que recebeu o listener
			event nome do evento sem o prefixo "on" (click, mouseover, ...)
			handler mesma função que foi atribuida no addEvent
			scope escopo em que a função foi adicionada, caso você tenha fornecido um escopo diferente no addEvent, é necessário que você passe como parâmetro o mesmo objeto, caso contrário a remoção do evento não será realizada
*/
addEvent = function(o, e, f, s){
	var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
	r[r.length] = [f, s || o], o[e] = function(e){
		try{
			(e = e || event).preventDefault || (e.preventDefault = function(){e.returnValue = false;});
			e.stopPropagation || (e.stopPropagation = function(){e.cancelBubble = true;});
			e.target || (e.target = e.srcElement || null);
			e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
		}catch(f){}
		for(d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false));
		return e = null, !!d;
	}
};
removeEvent = function(o, e, f, s){
	for(var i = (e = o["_on" + e] || []).length; i;)
		if(e[--i] && e[i][0] == f && (s || o) == e[i][1])
			return delete e[i];
	return false;
};
/*
site: http://jsfromhell.com/string/mask
String.mask(mask: String): String
			Retorna a string com a máscara já aplicada.
	mask
		máscara a ser utilizada
Observações
A máscara substitui as ocorrências de "#" pelos caracteres da string, sendo assim, se você precisar utilizar o caracter "#" como parte da máscara, basta "comentá-lo" com "\\", ex: "\\#".
A máscara é aplicada da esquerda para a direita, se a string contiver menos caracteres que a máscara, os caracteres "extras" da máscara serão ignorados.
Se a string contiver mais caracteres que a máscara, os caracteres restantes da string serão adicionados ao fim da máscara.
*/
String.prototype.mask = function(m)
{
	//"12345678900".mask("###.###.###,##") = 123.456.789,00
	//"1234".mask("x:##, y: ##") = x:12, y: 34
	//"TEST".mask("\#-#*#/#^#") = #-T*E/S^T
	var m, l = (m = m.split("")).length, s = this.split(""), j = 0, h = "";
	for(var i = -1; ++i < l;)
		if(m[i] != "#"){
			if(m[i] == "\\" && (h += m[++i])) continue;
			h += m[i];
			i + 1 == l && (s[j - 1] += h, h = "");
		}
		else{
			if(!s[j] && !(h = "")) break;
			(s[j] = h + s[j++]) && (h = "");
		}
	return s.join("") + h;
};
//------------------------------------------------------------------------------
/*
site:http://jsfromhell.com/string/extensoString.extenso([currency: Boolean = false]): String
	Retorna um número escrito por extenso em Português. Pode ser ou não em formato moeda.
	currency
		 indica se o valor será escrito como moeda, seu valor padrão é false.
*/
String.prototype.extenso = function(c){
	var ex = [
		["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
		["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
		["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
		["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão", "nonilhão", "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão", "sedecilhão", "septendecilhão", "octencilhão", "nonencilhão"]
	];
	var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "real", d = "centavo", sl;
	for(var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []){
		j && (n[j] = (+("." + n[j])).toFixed(Math.max(2, n[j].length)).slice(2, 4));
		if(!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length) continue;
		for(a = -1, l = v.length; ++a < l; t = ""){
			if(!(i = +v[a])) continue;
			i % 100 < 20 && (t += ex[0][i % 100]) ||
			i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
			s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
			((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
		}
		a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (+n[j + 1] > 0) || r.length) ? "" : ex[0][0]));
		a && r.push(a + (c ? (" " + (+v.join("") > 1 ? j ? d + "s" : ((n = (n = n + "").substr(n.length - 6)).length == 6 && !+n ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
	}
	return r.join(e);
}
//-------------------------------------------------------------------------------------
String.prototype.capitalize = function(){
	return this.replace(/\S+/g, function(a){
		return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase();
	});
};
//-------------------------------------------------------------------------------------
/*
fonte: http://jsfromhell.com/forms/masked-input
Classe para mascarar inputs (não funciona corretamente no opera).
Regras Padrões
	a = A-Z e 0-9
	A = A-Z, acentos e 0-9
	9 = 0-9
	C = A-Z e acentos
	c = A-Z
	* = qualquer coisa
Regras Especiais
	E = (Except) exceção
	O = (Only) somente
Criação de Máscaras
	Máscara simples:
	nesse tipo de máscara o usuário pode digitar no máximo a mesma
	quantidade de caracteres que a máscara contém.
	Exemplo:
	Telefone = (99)9999-9999
	Data = 99/99/9999
	Máscara especial "regra^exceções":
	esse tipo de máscara é composto por 2 partes, separadas por "^",
	o lado esquerdo especifica a regra e o direito as exceções para a regra selecionada.
	Exemplo:
	9^abc = a regra é aceitar somente números "9" e a exceção são os caracteres a, b e c
	c^123 = aceita somente caracteres de a-z e a exceção são os números 1, 2 e 3
	Uso das regras especiais:
	ela é semelhante a máscara especial, porém o lado esquerdo tem um significado diferente,
	podendo ser "E" (qualquer coisa, exceto...) ou "O" (somente...)
	Exemplo:
	E^abc: aceita qualquer coisa, menos a, b e c
	O^123: só permite os caracteres 1, 2 e 3
	EXEMPLO:
	var f = document.forms[0];
	MaskInput(f.fone, "(99)9999-9999");
	MaskInput(f.data, "99/99/9999");
	MaskInput(f.etc, "Cc99-*C");
	MaskInput(f.except, "E^abc");
	MaskInput(f.only, "O^abc");
	MaskInput(f.letra, "C^");
	MaskInput(f.letra2, "C^ ");
	MaskInput(f.numero, "9^abc");
*/
MaskInput = function(f, m){
	function mask(e){
		var patterns = {"1": /[A-Z]/i, "2": /[0-9]/, "4": /[\xC0-\xFF]/i, "8": /./ },
			rules = { "a": 3, "A": 7, "9": 2, "C":5, "c": 1, "*": 8};
		function accept(c, rule){
			for(var i = 1, r = rules[rule] || 0; i <= r; i<<=1)
				if(r & i && patterns[i].test(c))
					break;
				return i <= r || c == rule;
		}
		var k, mC, r, c = String.fromCharCode(k = e.key), l = f.value.length;
		(!k || k == 8 ? 1 : (r = /^(.)\^(.*)$/.exec(m)) && (r[0] = r[2].indexOf(c) + 1) + 1 ?
			r[1] == "O" ? r[0] : r[1] == "E" ? !r[0] : accept(c, r[1]) || r[0]
			: (l = (f.value += m.substr(l, (r = /[A|9|C|\*]/i.exec(m.substr(l))) ?
			r.index : l)).length) < m.length && accept(c, m.charAt(l))) || e.preventDefault();
	}
	for(var i in !/^(.)\^(.*)$/.test(m) && (f.maxLength = m.length), {keypress: 0, keyup: 1})
		addEvent(f, i, mask);
};
//-------------------------------------------------------------------------------------
/*
fonte:http://jsfromhell.com/string/trim
Remove caracteres indesejáveis à esquerda, direita ou ambos.
String.prototype.trim([chars: String = " "], [type: Integer = 0]): String
Remove caracteres na esquerda, direita ou ambos os lados da string.
	caracteres
		sequência de caracteres que deverão ser removidos
	type
		especifica onde irá ocorrer o trim, possíveis valores são:

			* 					0 = remove em ambos os lados
			* 					1 = remove caracteres na esquerda
			* 					2 = remove caracteres na direita

*/
String.prototype.trim = function(c, t){
	return c = "[" + (c == undefined ? " " : c.replace(/([\^\]\\-])/g, "\\\$1")) + "]+",
	this.replace(new RegExp((t != 2 ? "^" : "") + c + (t != 1 ? "|" + c + "$" : ""), "g"), "");
};
//-------------------------------------------------------------------------------------
/*
fonte: http://jsfromhell.com/string/pad
String.pad(length: Integer, [substring: String = " "], [type: Integer = 0]): String
	Retorna a string padificada a esquerda, direita ou ambos os lados.
	length
		quantidade de caracteres que a string deverá ter após executar a função
	substring
		string que será concatenada
	type
		especifica em o lado em que deverá ocorrer a concatenação, onde: 0 = esquerda, 1 = direita e 2 = ambos os lados
*/
String.prototype.pad = function(l, s, t){
	return s || (s = " "), (l -= this.length) > 0 ? (s = new Array(Math.ceil(l / s.length)
		+ 1).join(s)).substr(0, t = !t ? l : t == 1 ? 0 : Math.ceil(l / 2))
		+ this + s.substr(0, l - t) : this;
};
//-------------------------------------------------------------------------------------
/*
fonte:
codifica e decodifica strings no formato ROT13 (rotação dos 26 caracteres do alfabeto em 13 posições).
String.rot13(void): String
Codifica/decodifica a string no formato rot13.
*/
String.prototype.rot13 = function(){
	return this.replace(/[a-zA-Z]/g, function(c){
		return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
	});
};
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
/*
Number.formatMoney([floatPoint: Integer = 2], [decimalSep: String = ","], [thousandsSep: String = "."]): String
Retorna o número no formato monetário.
   floatPoint
	   número de casas decimais
	decimalSep
		string que será usada como separador decimal
	thousandsSep
		string que será usada como separador de milhar
*/
Number.prototype.formatMoney = function(c, d, t)
{
	//n = 123456.789
	//n.formatMoney() = 123.456,79
	//n.formatMoney(0) = 123.457
	//n.formatMoney(6) = 123.456,789000
	//n.formatMoney(2, "*", "#") = 123#456*79
	var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
	i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
	+ (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

//-------------------------------------------------------------------------------------
/*
	Date.prototype.format(format: String, [userFunctions: Object = null]): String
		Formata uma data de acordo com uma string de formatação.
	format string de formatação, aceita caracteres especiais, os quais devem ser circundados por "%" (para usar o "%" literalmente, use "%%"),
	os seguintes caracteres são reconhecidos:
			* 					d - dia com 2 dígitos (01-31)
			* 					j - dia (1-31)
			* 					N - dia da semana 1 = segunda, 2 = terça, ... (1-7)
			* 					w - dia da semana 0 = domingo, 1 = segunda, ... (0-6)
			* 					z - dia do ano (1-365)
			* 					W - semana do ano (1-52)
			* 					m - mês com 2 dígitos (01-12)
			* 					n - mês (1-12)
			* 					t - dias no mês (28-31)
			* 					L - ano bissêxto (0 = não, 1 = sim)
			* 					Y - ano com 4 dígitos (Ex. 1979, 2006)
			* 					y - ano com 2 dígitos (Ex. 79, 06)
			* 					a - am ou pm
			* 					A - AM ou PM
			* 					g - hora (1-12)
			* 					G - hora (0-23)
			* 					h - hora (01-12)
			* 					H - hora com dois dígitos (00-23)
			* 					i - minuto com 2 dígitos (00-59)
			* 					s - segundo com 2 dígitos (00-59)
			* 					ms - milesegundos com 3 dígitos (000-999)
			* 					O - Timezone em horas

	userFunctions
	objeto onde as propriedades devem ser nomes de funções do usuário,
	o valor de cada propriedade deve ser uma função que recebe 2 parâmetros, o primeiro
	será o próprio objeto Date e o segundo é o segundo é uma função que recebe
	como parâmetro um dos caracteres especiais definidos acima e retorna seu valor.
*/
Date.prototype.format = function(m, r)
{
	var d = this, a, fix = function(n, c){return (n = n + "").length < c ? new Array(++c - n.length).join("0") + n : n};
	var r = r || {}, f = {j: function(){return d.getDate()}, w: function(){return d.getDay()},
		y: function(){return (d.getFullYear() + "").slice(2)}, Y: function(){return d.getFullYear()},
		n: function(){return d.getMonth() + 1}, m: function(){return fix(f.n(), 2)},
		g: function(){return d.getHours() % 12 || 12}, G: function(){return d.getHours()},
		H: function(){return fix(d.getHours(), 2)}, h: function(){return fix(f.g(), 2)},
		d: function(){return fix(f.j(), 2)}, N: function(){return f.w() + 1},
		i: function(){return fix(d.getMinutes(), 2)}, s: function(){return fix(d.getSeconds(), 2)},
		ms: function(){return fix(d.getMilliseconds(), 3)}, a: function(){return d.getHours() > 11 ? "pm" : "am"},
		A: function(){return f.a().toUpperCase()}, O: function(){return d.getTimezoneOffset() / 60},
		z: function(){return (d - new Date(d.getFullYear() + "/1/1")) / 864e5 >> 0},
		L: function(){var y = f.Y(); return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0},
		t: function(){var n; return (n = d.getMonth() + 1) == 2 ? 28 + f.L() : n & 1 && n < 8 || !(n & 1) && n > 7 ? 31 : 30},
		W: function(){
			var a = f.z(), b = 364 + f.L() - a, nd = (new Date(d.getFullYear() + "/1/1").getDay() || 7) - 1;
			return (b <= 2 && ((d.getDay() || 7) - 1) <= 2 - b) ? 1 :
				(a <= 2 && nd >= 4 && a >= (6 - nd)) ? new Date(d.getFullYear() - 1 + "/12/31").format("%W%") :
				(1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
		}
	}
	return m.replace(/%(.*?)%/g, function(t, s){
		return r[s] ? r[s](d, function(s){return f[s] && f[s]();}) : f[s] ? f[s]() : "%" + (s && s + "%");
	});
}
//-------------------------------------------------------------------------------------
/*
site:http://jsfromhell.com/forms/restrict
Construtor Restrict(form: String)
Gera uma instância de Restrict.
form nome ou id do formulário que receberá as validações
Propriedades
Restrict.mask: Object
Esta propriedade serve para adicionar máscara aos campos e, deve ser usada
da seguinte forma:
instanciaDeRestrict.mask.nomeDoCampoNoFormulario = mascara.
Onde mascara segue as seguintes regras:
A classe substitui cada caracter "#" na máscara pelo que for pressionado
pelo usuário.
Ex: mascara = "##/##/####" (para mascarar uma data)
		* Como o caracter "#" é de uso especial, se você
		 precisar utilizar ele como parte da máscara, basta "comentá-lo"
		 com "\\", ex: "\\#".
		*
			A máscara é aplicada da esquerda para a direita, sendo assim,
			se o campo contiver menos caracteres que a máscara,
			os caracteres "extras" da máscara serão ignorados.
		* 	Se a string contiver mais caracteres que a máscara,
		os caracteres restantes são simplesmente adicionados ao fim da máscara.

Restrict.field: Object
			Esta propriedade serve para filtrar os caracteres que podem ser inseridos no campo.
	Deve ser usada da seguinte forma:
	instanciaDeRestrict.field.nomeDoCampoNoFormulario = filtro.
	Onde filtro segue as seguintes regras:
						O filtro é aplicado apenas caracter que foi pressionado e, ele é de simples manuseio, apenas digite os caracteres que você
						quer permitir.
		  Ex: filtro = "9aA." (permitirá a digitação dos caracteres "9", "a", "A", e ".")
						No entanto, seria trabalhoso digitar todos os caracteres do alfabeto em um campo que deve permitir apenas letras,
						portanto, há expressões regulares de filtragem pré-definidas na classe, são elas:
			  o 					"." = Qualquer caracter
			  o 					"w": Somente A-z, a-z, 0-9 e _
			  o 					"W": Qualquer caracter, exceto: A-z, a-z, 0-9 e _
			  o 					"d": 0-9
			  o 					"D": Qualquer caracter, exceto 0-9
			  o 					"s": Permite espaço em branco, tabulação, quebra de linha, etc (\f\n\r\t\v)
			  o 					"a": Permite somente letras acentuadas
			  o 					"A": Permite qualquer caracter, exceto letras acentuadas
		  Se precisar de mais regras, basta definí-las no código fonte.
		  Para utilizar, basta prefixar o nome da regra com "\\".
		  Ex: filtro = "\\d\\s" (permite números e espaços)
						Também é possível especificar exceções para o filtro usando o caracter "^".
		  Ex: filtro = "\\d^123" (permite 0-9, menos os caractes 1, 2 e 3)
						A barra "\\" e o "^" são considerados caracteres especiais no filtro, se precisar utilizá-los, faça como no exemplo abaixo.
		  Ex: filter = "\\\\" (permite a barra invertida)
		  filter = "\\^" (permite o cincunflexo)
Métodos
Restrict.start(void): void
	Inicia o objeto. Deve ser chamado depois que todas as regras já estiverem devidamente setadas.
Eventos
Restrict.onKeyRefuse: function(field: HTMLInputElement, keyCode: Integer): void
			Este evento é chamado sempre que o usuário digitar um caracter inválido.
	field
		campo que está sendo editado
	keyCode
		código do caracter pressionado
Restrict.onKeyRefuse: function(field: HTMLInputElement, keyCode: Integer): void
	Este evento é chamado sempre que o usuário digitar um caracter válido.
	field
		campo que está sendo editado
	keyCode


*/
Restrict = function(form){
	this.form = form, this.field = {}, this.mask = {};
}
Restrict.field = Restrict.inst = Restrict.c = null;
Restrict.prototype.start = function(){
	var $, __ = document.forms[this.form], s, x, j, c, sp, o = this, l;
	var p = {".":/./, w:/\w/, W:/\W/, d:/\d/, D:/\D/, s:/\s/, a:/[\xc0-\xff]/, A:/[^\xc0-\xff]/};
	for(var _ in $ = this.field)
		if(/text|textarea|password/i.test(__[_].type)){
			x = $[_].split(""), c = j = 0, sp, s = [[],[]];
			for(var i = 0, l = x.length; i < l; i++)
				if(x[i] == "\\" || sp){
					if(sp = !sp) continue;
					s[j][c++] = p[x[i]] || x[i];
				}
				else if(x[i] == "^") c = (j = 1) - 1;
				else s[j][c++] = x[i];
			o.mask[__[_].name] && (__[_].maxLength = o.mask[__[_].name].length);
			__[_].pt = s, addEvent(__[_], "keydown", function(e){
				var r = Restrict.field = e.target;
				if(!o.mask[r.name]) return;
				r.l = r.value.length, Restrict.inst = o; Restrict.c = e.key;
				setTimeout(o.onchanged, r.e = 1);
			});
			addEvent(__[_], "keyup", function(e){
				(Restrict.field = e.target).e = 0;
			});
			addEvent(__[_], "keypress", function(e){
				o.restrict(e) || e.preventDefault();
				var r = Restrict.field = e.target;
				if(!o.mask[r.name]) return;
				if(!r.e){
					r.l = r.value.length, Restrict.inst = o, Restrict.c = e.key || 0;
					setTimeout(o.onchanged, 1);
				}
			});
		}
}
Restrict.prototype.restrict = function(e){
	var o, c = e.key, n = (o = e.target).name, r;
	var has = function(c, r){
		for(var i = r.length; i--;)
			if((r[i] instanceof RegExp && r[i].test(c)) || r[i] == c) return true;
		return false;
	}
	var inRange = function(c){
		return has(c, o.pt[0]) && !has(c, o.pt[1]);
	}
	return (c < 30 || inRange(String.fromCharCode(c))) ?
		(this.onKeyAccept && this.onKeyAccept(o, c), !0) :
		(this.onKeyRefuse && this.onKeyRefuse(o, c),  !1);
}
Restrict.prototype.onchanged = function(){
	var ob = Restrict, si, moz = false, o = ob.field, t, lt = (t = o.value).length, m = ob.inst.mask[o.name];
	if(o.l == o.value.length) return;
	if(si = o.selectionStart) moz = true;
	else if(o.createTextRange){
		var obj = document.selection.createRange(), r = o.createTextRange();
		if(!r.setEndPoint) return false;
		r.setEndPoint("EndToStart", obj); si = r.text.length;
	}
	else return false;
	for(var i in m = m.split(""))
		if(m[i] != "#")
			t = t.replace(m[i] == "\\" ? m[++i] : m[i], "");
	var j = 0, h = "", l = m.length, ini = si == 1, t = t.split("");
	for(i = 0; i < l; i++)
		if(m[i] != "#"){
			if(m[i] == "\\" && (h += m[++i])) continue;
			h += m[i], i + 1 == l && (t[j - 1] += h, h = "");
		}
		else{
			if(!t[j] && !(h = "")) break;
			(t[j] = h + t[j++]) && (h = "");
		}
	o.value = o.maxLength > -1 && o.maxLength < (t = t.join("")).length ? t.slice(0, o.maxLength) : t;
	if(ob.c && ob.c != 46 && ob.c != 8){
		if(si != lt){
			while(m[si] != "#" && m[si]) si++;
			ini && m[0] != "#" && si++;
		}
		else si = o.value.length;
	}
	!moz ? (obj.move("character", si), obj.select()) : o.setSelectionRange(si, si);
}
//-------------------------------------------------------------------------------------
/*
 site: http://jsfromhell.com/forms/selection
 Construtor
Selection(textInput: HTMLInput)
			Gera uma instância de Selection.
	textInput
		referência para um input texto ou textarea
Propriedades da classe
Selection.isSupported: Boolean
	indica se o browser suporta seleção.
Selection.isStandard: Boolean
	indica se o browser suporta os métodos de seleção do Gecko.
Métodos
Selection.getText(void): String
	Retorna o texto contido na seleção.
Selection.setText(text: String): void
			Troca o texto da seleção.
	text
		texto que será colocado no lugar do texto selecionado
Selection.getCaret(void): Object
	Retorna um objeto contendo duas propriedades: start (início da seleção) e end (fim da seleção).
Selection.setCaret(start: Integer, end: Integer): void
			Seta a seleção.
	start
		início da seleção
	end
		fim da seleção
*/
Selection = function(input){
	this.isTA = (this.input = input).nodeName.toLowerCase() == "textarea";
};
with({o: Selection.prototype}){
	o.setCaret = function(start, end){
		var o = this.input;
		if(Selection.isStandard)
			o.setSelectionRange(start, end);
		else if(Selection.isSupported){
			var t = this.input.createTextRange();
			end -= start + o.value.slice(start + 1, end).split("\n").length - 1;
			start -= o.value.slice(0, start).split("\n").length - 1;
			t.move("character", start), t.moveEnd("character", end), t.select();
		}
	};
	o.getCaret = function(){
		var o = this.input, d = document;
		if(Selection.isStandard)
			return {start: o.selectionStart, end: o.selectionEnd};
		else if(Selection.isSupported){
			var s = (this.input.focus(), d.selection.createRange()), r, start, end, value;
			if(s.parentElement() != o)
				return {start: 0, end: 0};
			if(this.isTA ? (r = s.duplicate()).moveToElementText(o) : r = o.createTextRange(), !this.isTA)
				return r.setEndPoint("EndToStart", s), {start: r.text.length, end: r.text.length + s.text.length};
			for(var $ = "[###]"; (value = o.value).indexOf($) + 1; $ += $);
			r.setEndPoint("StartToEnd", s), r.text = $ + r.text, end = o.value.indexOf($);
			s.text = $, start = o.value.indexOf($);
			if(d.execCommand && d.queryCommandSupported("Undo"))
				for(r = 3; --r; d.execCommand("Undo"));
			return o.value = value, this.setCaret(start, end), {start: start, end: end};
		}
		return {start: 0, end: 0};
	};
	o.getText = function(){
		var o = this.getCaret();
		return this.input.value.slice(o.start, o.end);
	};
	o.setText = function(text){
		var o = this.getCaret(), i = this.input, s = i.value;
		i.value = s.slice(0, o.start) + text + s.slice(o.end);
		this.setCaret(o.start += text.length, o.start);
	};
	new function(){
		var d = document, o = d.createElement("input"), s = Selection;
		s.isStandard = "selectionStart" in o;
		try{s.isSupported = s.isStandard || (o = d.selection) && !!o.createRange();} catch(e){}
	};
}
//-------------------------------------------------------------------------------------
/*
Retorna o número no formato monetário.
FONTE:http://jsfromhell.com/forms/format-currency
Jonas Raoni Soares Silva
@ http://jsfromhell.com/number/fmt-money [rev. #2]
Number.fmtMoney([floatPoint: Integer = 2], [decimalSep: String = ","], [thousandsSep: String = "."]): String

    floatPoint
        número de casas decimais
    decimalSep
        string que será usada como separador decimal
    thousandsSep
        string que será usada como separador de milhar
*/
Number.prototype.formatMoney = function(c, d, t){
	var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
	i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
	+ (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
/*
FONTE:http://jsfromhell.com/forms/format-currency
Transforma um input em um campo monetário, permitindo apenas a digitação de números e também formata o campo.

formatCurrency(field: HTMLInput, [floatPoint: Integer = 2], [decimalSep: String = ","], [thousandsSep: String = "."]): String
Formata o input de forma que ele assuma o comportamento de um campo monetário.
	field
		campo que receberá a formatação
	floatPoint
		número de casas decimais
	decimalSep
		string representando o separador decimal
	thousandsSep
		string representando o separador de milhar
	EXEMPLO:
	formatCurrency(document.forms.form.a, 2);
	formatCurrency(document.forms.form.b, 3, " ", "-");
	formatCurrency(document.forms.form.c, 6);

*/
function formatCurrency(o, n, dig, dec){
	new function(c, dig, dec, m){
		addEvent(o, "keypress", function(e, _){
			if((_ = e.key == 45) || e.key > 47 && e.key < 58){
				var o = this, d = 0, n, s, h = o.value.charAt(0) == "-" ? "-" : "",
					l = (s = (o.value.replace(/^(-?)0+/g, "$1") + String.fromCharCode(e.key)).replace(/\D/g, "")).length;
				m + 1 && (o.maxLength = m + (d = o.value.length - l + 1));
				if(m + 1 && l >= m && !_) return false;
				l <= (n = c) && (s = new Array(n - l + 2).join("0") + s);
				for(var i = (l = (s = s.split("")).length) - n; (i -= 3) > 0; s[i - 1] += dig);
				n && n < l && (s[l - ++n] += dec);
				_ ? h ? m + 1 && (o.maxLength = m + d) : s[0] = "-" + s[0] : s[0] = h + s[0];
				o.value = s.join("");
			}
			e.key > 30 && e.preventDefault();
		});
	}(!isNaN(n) ? Math.abs(n) : 2, typeof dig != "string" ? "." : dig, typeof dec != "string" ? "," : dec, o.maxLength);
}
//-------------------------------------------------------------------------------------
/*
Tabulação via tecla enter.
fonte: http://jsfromhell.com/forms/auto-tab
Tabulação automática para inputs com maxlenght setado.
autoTab(form: HTMLFormElement): void
			A função irá adicionar a tabulação automática em todos os inputs que tiverem o atributo maxlenght setado.
	form
		formulário que receberá a tabulação automática
	EXEMPLO:
	autoTab(document.forms.form);
*/
autoTab = function(f){
	var c = 0;
	addEvent(f, "keyup", function(e){
		var i, j, f = (e = e.target).form.elements, l = e.value.length, m = e.maxLength;
		if(c && m > -1 && l >= m){
			for(i = l = f.length; f[--i] != e;);
			for(j = i; (j = (j + 1) % l) != i && (!f[j].type || f[j].disabled || f[j].readOnly || f[j].type.toLowerCase() == "hidden"););
			j != i && f[j].focus();
		}
	});
	addEvent(f, "keypress", function(e){c = e.key;});
};
//-------------------------------------------------------------------------------------
/*

enterAsTab(form: HTMLFormElement, [jumpAlways: Boolean = false]): void
A função irá adicionar tabulação via enter em todos os inputs, exceto selects (pois é necessário utilizar o enter para selecionar uma opção) e textareas (pois o enter fornece quebra de linhas).
Os inputs devem estar dentro de uma tag form e ao chegar no último input o comportamento padrão é voltar para o primeiro ao pressionar enter.
	form
		formulário que receberá a tabulação via enter
	jumpAlways
		se true, o enter irá pular até mesmo selects e textareas
*/
enterAsTab = function(f, a){
	addEvent(f, "keypress", function(e){
		var l, i, f, j, o = e.target;
		if(e.key == 13 && (a || !/textarea|select/i.test(o.type))){
			for(i = l = (f = o.form.elements).length; f[--i] != o;);
			for(j = i; (j = (j + 1) % l) != i && (!f[j].type || f[j].disabled || f[j].readOnly || f[j].type.toLowerCase() == "hidden"););
			e.preventDefault(), j != i && f[j].focus();
		}
	});
};
//-------------------------------------------------------------------------------------
// Limpar formulario com jquery
// ex: 	$('formDin'').clearForm()
// 		$(':input').clearForm()
//-------------------------------------------------------------------------------------
jQuery.fn.clearForm = function()
{
  return this.each(function()
  {
	 var type = this.type, tag = this.tagName.toLowerCase();
	 if (tag == 'form')
	   return jQuery(':input',this).clearForm();
	 if (type == 'text' || type == 'password' || tag == 'textarea')
	   this.value = '';
	 else if (type == 'checkbox' || type == 'radio')
	   this.checked = false;
	 else if (tag == 'select')
	   this.selectedIndex = -1;
	  });
};
/*
Fonte:http://jsfromhell.com/geral/query
Gera uma array associativa com os campos da query string e seus respectivos valores.
Query([href: String = CURRENT_URL]): Object
Retorna uma array associativa, onde os índices são os nomes dos campos na query string. Se houver mais de um campo com o mesmo nome, você pode acessá-los como se fosse uma array.
href=URL que será interpretada, se não for fornecido nenhum valor, o default é a url atual da página
EXEMPLO:
var params = Query();
if(params)
	for(var i in params)
		document.write(i + " = " + params[i] + "<br />");

*/
function Query(s){
	if(!(s = s || location.search)) return null;
	var v, f, i, a = {}, r = /\+/g, u = unescape;
	if(s = s.split("?")[1])
		for(i = (s = s.split("&")).length; i;)
			(v = u((f = s[--i].split("="))[1].replace(r, " ")), a[f[0]] !== undefined)
			&& (a[f[0]] instanceof Array ? a[f[0]] : a[f[0]] = [a[f[0]]]).push(v) || (a[f[0]] = v);
	return a;
}
//-------------------------------------------------------------------------------------------
/*
Esta função executa um codigo javascript delimitado pelas tags: <script> e </script>
*/
var executarJavascript =  function(html) {
	var posInicial = html.indexOf('<script>');
	if( posInicial>=0)
	{
		var posFinal   = html.indexOf('<\/script>');
		var js   = html.substr(posInicial,(posFinal-posInicial)+9);
		var html = html.substr(0,posInicial)+html.substr(posFinal+9)
		re = /<script>/gi;
		js = js.replace(re, 'eval("');
		js = js.replace('<\/script>', '");',"gi");
		try
		{
			eval(js);
		} catch(e){}
	}
}
//---------------------------------------------------------------------------------------------
/*
ex:OnKeyPress="return getCapsLock(event, this);">
*/
function getCapsLock(e,text)
{
	var keyCode=0;
	var shiftKey=false;
	var msg='A tecla Caps Lock está ativa.\nPara evitar que você informe sua senha incorretamente, \nvocê deve pressionar a tecla "Caps Lock" para desativá-la.\nUtilize a tecla "SHIFT" para informar letra(s) em caixa alta.';
	// Internet Explorer 4+
	if (document.all)
	{
	  keyCode=e.keyCode;
	// Netscape 4
	} else if (document.layers)
	{
	  keyCode=e.which;
	// Firefox, Mozilla, Netscape 6
	} else if (document.getElementById) {
	  keyCode=e.which;
	}
	shiftKey=e.shiftKey;
	// Letras Maiúsculas com sem shift mas com caps lock ligado
	if ((keyCode >= 65 && keyCode <= 90) && !shiftKey) {
	  alert(msg);
	  return false;

	// Letras Maiúsculas com shift pressionado e com caps lock ligado
	} else if ((keyCode >= 97 && keyCode <= 122) && shiftKey) {
	  alert(msg);
	  return false;
	}
	return true;
}
/**
* extensao do jquery para recuperar o valor de campos sem a mascara
* @exemple: jQuery('#num_cpf').getValUnmasked()
*
* @param selector
* @param context
*/
jQuery.fn.getValUnmasked = function( arrAddCaracteres ) {
    var sValue = jQuery(this).val();
    //sValue = (sValue !== null) ? sValue.toString().replace( /[\-\.\/\:\_\s]/g, "" ) : '';
    sValue = (sValue !== null) ? sValue.toString().replace( /[\'\[\]\(\)\{\}\<\>\=\+\-\*\/\_\|\~\`\!\?\@\#\$\%\^\&\:\;\,\.]/g, "" ) : '';
    if( arrAddCaracteres ){
        var i;
        var j;
        for(j=0;j<arrAddCaracteres.length;j++){
            i = 0;
            while ( i < sValue.length ){
                sValue = sValue.toString().replace( arrAddCaracteres[j], "" );
                i++;
            }
        }
    }
    return sValue;
};
/**
* Função para validar cpf
* Fonte:http://jsfromhell.com/geral/query
*
* @param value
*/
String.prototype.isCPF = function(){
	var c = this;
	if((c = c.replace(/[^\d]/g,"").split("")).length != 11) return (this.length==0);
	if(new RegExp("^" + c[0] + "{11}$").test(c.join(""))) return false;
	for(var s = 10, n = 0, i = 0; s >= 2; n += c[i++] * s--);
	if(c[9] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
	for(var s = 11, n = 0, i = 0; s >= 2; n += c[i++] * s--);
	if(c[10] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
	return true;
};
/**
* Função para validar cnpj
* Fonte:http://jsfromhell.com/geral/query
*
* @param value
*/
String.prototype.isCNPJ = function(){
	var b = [6,5,4,3,2,9,8,7,6,5,4,3,2], c = this;
	if((c = c.replace(/[^\d]/g,"").split("")).length != 14) return (this.length==0);
	for(var i = 0, n = 0; i < 12; n += c[i] * b[++i]);
	if(c[12] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
	for(var i = 0, n = 0; i <= 12; n += c[i] * b[i++]);
	if(c[13] != (((n %= 11) < 2) ? 0 : 11 - n)) return false;
	return true;
};

// cancelar a tecla backspace do browser para não voltar para a pagina anterior
if( typeof jQuery == 'function')
{
	jQuery(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ( d.tagName.toUpperCase().match(/^(INPUT|TEXT|PASSWORD|TEXTAREA)$/) ) {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }
    if (doPrevent) {
        event.preventDefault();
    }
	});

    // centralizar o objeto na tela
    jQuery.fn.center = function ()
    {
	    this.css("position", "absolute");
	    this.css("top", (jQuery(window).height() - this.height()) / 2 + jQuery(window).scrollTop() + "px");
	    this.css("left", (jQuery(window).width() - this.width()) / 2 + jQuery(window).scrollLeft() + "px");
	    return this;
	}
}

//+ Carlos R. L. Rodrigues
//@ http://jsfromhell.com/number/zero-format [rev. #1]
/**
	Number.zeroFormat(n: Integer, [fill: Boolean = false], [right: Boolean = false]): String
    Retorna o número em forma de string com zeros à esquerda ou à direita.

    n
        quantidade de zeros a ser adicionada
    fill
        se "true", serão adicionados zeros ao número até que se obtenha no mínimo "n" digitos, caso contrário será sempre adicionado a quantidade especificada de zeros
    right
        se "true" os zeros serão concatenados à direita, caso contrário, à esquerda*
* @returns {Number}
*/
Number.prototype.zeroFormat = function(n, f, r){
	return n = new Array((++n, f ? (f = (this + "").length) < n ? n - f : 0 : n)).join(0), r ? this + n : n + this;
};