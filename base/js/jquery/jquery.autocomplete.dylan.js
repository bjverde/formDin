/*
This is modification of Dylan Verheul's jQuery Autcomplete plug-in. I customized his library adding the features I needed and fixing issues I considered bugs.
http://www.pengoworks.com/workshop/jquery/autocomplete.htm
*/

jQuery.autocomplete = function(input, options) {

	// Create a link to self
	var me = this;

	// Create jQuery object for input element
	var $input = jQuery(input).attr("autocomplete", "off");

	// Apply inputClass if necessary
	if (options.inputClass) $input.addClass(options.inputClass);

	// Create results
	var results = document.createElement("div");

	// Create jQuery object for results
	var $results = jQuery(results);
	$results.hide().addClass(options.resultsClass).css("position", "absolute");
	if( options.width > 0 ) $results.css("width", options.width);

	// Add to body element
	jQuery("body").append(results);

	input.autocompleter = me;

	var timeout = null;
	var prev = "";
	var active = -1;
	var cache = {};
	var keyb = false;
	var hasFocus = false;
	var lastKeyPressCode = null;

	// flush cache
	function flushCache(){
		cache = {};
		cache.data = {};
		cache.length = 0;
		// eugenio - limpar para repetir a consulta
		prev ="";
	};

	// flush cache
	flushCache();

	// if there is a data array supplied
	if( options.data != null ){
		var sFirstChar = "", stMatchSets = {}, row = [];

		// no url was specified, we need to adjust the cache length to make sure it fits the local data store
		if( typeof options.url != "string" ) options.cacheLength = 1;

		// loop through the array and create a lookup structure
		for( var i=0; i < options.data.length; i++ ){
			// if row is a string, make an array otherwise just reference the array
			row = ((typeof options.data[i] == "string") ? [options.data[i]] : options.data[i]);

			// if the length is zero, don't add to list
			if( row[0].length > 0 ){
				// get the first character
				sFirstChar = row[0].substring(0, 1);
				// if no lookup array for this character exists, look it up now
				if( !stMatchSets[sFirstChar] ) stMatchSets[sFirstChar] = [];
				// if the match is a string
				stMatchSets[sFirstChar].push(row);
			}
		}
		// add the data items to the cache
		for( var k in stMatchSets ){
			// increase the cache size
			options.cacheLength++;
			// add to the cache
			addToCache(k, stMatchSets[k]);
		}
	}

	$input.keydown(function(e) {
		// track last key pressed
		lastKeyPressCode = e.keyCode;
		switch(e.keyCode) {
			case 38: // up
				e.preventDefault();
				moveSelect(-1);
				break;
			case 40: // down
				e.preventDefault();
				moveSelect(1);
				break;
			case 9:  // tab
			case 13: // return
				if( selectCurrent() ){
					// make sure to blur off the current field
					$input.get(0).blur();
					e.preventDefault();
				}
				break;
			default:
				active = -1;
				if (timeout) clearTimeout(timeout);
				timeout = setTimeout(function(){onChange();}, options.delay);
				break;
		}
	})
	.focus(function(){
		// track whether the field has focus, we shouldn't process any results if the field no longer has focus
		hasFocus = true;
	})
	.blur(function() {
		// track whether the field has focus
		hasFocus = false;
		hideResults();
	});

	hideResultsNow();

	function onChange() {
		// ignore if the following keys are pressed: [del] [shift] [capslock]
		//if( lastKeyPressCode == 46 || (lastKeyPressCode > 8 && lastKeyPressCode < 32) ) return $results.hide();
		if( lastKeyPressCode == 39 || lastKeyPressCode == 37 || lastKeyPressCode == 46 || (lastKeyPressCode > 8 && lastKeyPressCode < 32) ) return $results.hide();
		var v = $input.val();
		if (v == prev) return;
		prev = v;

		if (v.length >= options.minChars) {
			$input.addClass(options.loadingClass);
			requestData(v);
		} else {
			$input.removeClass(options.loadingClass);
			$results.hide();
		}
	};

 	function moveSelect(step) {

		var lis = jQuery("li", results);
		if (!lis) return;

		active += step;

		if (active < 0) {
			active = 0;
		} else if (active >= lis.size()) {
			active = lis.size() - 1;
		}

		lis.removeClass("ac_over");

		jQuery(lis[active]).addClass("ac_over");

		// Weird behaviour in IE
		// if (lis[active] && lis[active].scrollIntoView) {
		// 	lis[active].scrollIntoView(false);
		// }

	};

	function selectCurrent() {
		var li = jQuery("li.ac_over", results)[0];
		if (!li) {
			var $li = jQuery("li", results);
			if (options.selectOnly) {
				if ($li.length == 1) li = $li[0];
			} else if (options.selectFirst) {
				li = $li[0];
			}
		}
		if (li) {
			selectItem(li);
			return true;
		} else {
			return false;
		}
	};

	function selectItem(li) {
		if (!li) {
			li = document.createElement("li");
			li.extra = [];
			li.selectValue = "";
		}
		var v = jQuery.trim(li.selectValue ? li.selectValue : li.innerHTML);
		input.lastSelected = v;
		prev = v;
		$results.html("");
		$input.val(v);
		hideResultsNow();
		//if (options.onItemSelect) setTimeout(function() { options.onItemSelect(li) }, 1);
		if (options.onItemSelect) setTimeout(function() { options.onItemSelect(li,$input.get(0)) }, 1);
	};

	// selects a portion of the input string
	function createSelection(start, end){
		// get a reference to the input element
		var field = $input.get(0);
		if( field.createTextRange ){
			var selRange = field.createTextRange();
			selRange.collapse(true);
			selRange.moveStart("character", start);
			selRange.moveEnd("character", end);
			selRange.select();
		} else if( field.setSelectionRange ){
			field.setSelectionRange(start, end);
		} else {
			if( field.selectionStart ){
				field.selectionStart = start;
				field.selectionEnd = end;
			}
		}
		field.focus();
	};

	/*
	// fills in the input box w/the first match (assumed to be the best match)
	function autoFill(sValue){
		// if the last user key pressed was backspace, don't autofill
		if( lastKeyPressCode != 8 ){
			// fill in the value (keep the case the user has typed)
			$input.val($input.val() + sValue.substring(prev.length));
			// select the portion of the value not typed by the user (so the next character will erase)
			createSelection(prev.length, sValue.length);
		}
	};
      */
	function autoFill(sValue){
		// if the last user key pressed was backspace, don't autofill
		if( lastKeyPressCode != 8 ){
			// fill in the value (keep the case the user has typed)
			// alterado
			var posInicial = $input.val().length;
			$input.val($input.val() + sValue.substring(posInicial));
			// select the portion of the value not typed by the user (so the next character will erase)
			createSelection(posInicial, sValue.length);
		}
	};

	function showResults() {
		// get the position of the input field right now (in case the DOM is shifted)
		var pos = findPos(input);
		// either use the specified width, or autocalculate based on form element
		var iWidth = (options.width > 0) ? options.width : $input.width();
		// reposition
		$results.css({
			width: parseInt(iWidth) + "px",
			top: (pos.y + input.offsetHeight) + "px",
			left: pos.x + "px"
		}).show();
	};

	function hideResults() {
		if (timeout) clearTimeout(timeout);
		timeout = setTimeout(hideResultsNow, 200);
	};

	function hideResultsNow() {
		if (timeout) clearTimeout(timeout);
		$input.removeClass(options.loadingClass);
		if ($results.is(":visible")) {
			$results.hide();
		}
		if (options.mustMatch) {
			var v = $input.val();
			if (v != input.lastSelected) {
				selectItem(null);
			}
		}
	};

	function receiveData(q, data) {

		if (data) {
			$input.removeClass(options.loadingClass);
			results.innerHTML = "";

			// if the field no longer has focus or if there are no matches, do not display the drop down
			if( !hasFocus || data.length == 0 )
			{
				return hideResultsNow();
			}
			if (jQuery.browser.msie) {
				// we put a styled iframe behind the calendar so HTML SELECT elements don't show through
				$results.append(document.createElement('iframe'));
			}
			results.appendChild(dataToDom(data));


			//-----------------------------------------------------------------------------
			// adaptação feita por Luis Eugênio para retirar a mascara antes de procurar campos formatados
			//-----------------------------------------------------------------------------
			var currentVal = q;
			if(options.removeMask || data.length == 1 )
			{
            	q = q.replace(/[^0-9]/g,'');
			}
			//------------------------------------------------------------------------------
			// autofill in the complete box w/the first match as long as the user hasn't entered in more data
			if( options.autoFill && ($input.val() == q ) )
				autoFill(data[0][0]);

			//------------------------------------------------------------------------------
			// adaptacao eugenio para selecionar automaticamente a primeira opção e retornar
			//------------------------------------------------------------------------------
			if(options.removeMask || data.length==1)
			{
				selectCurrent();
				//$input.val(currentVal);
				for( key in data )
				{
					this.value =  data[key];
				}
			}
			else
			{
				showResults();
			}
			//------------------------------------------
			//showResults();

		} else {
			hideResultsNow();
		}
	};

	function parseData(data) {
		if (!data) return null;
		var parsed = [];
		var rows = data.split(options.lineSeparator);
		for (var i=0; i < rows.length; i++) {
			var row = jQuery.trim(rows[i]);
			if ( row ) {
				parsed[parsed.length] = row.split(options.cellSeparator);
			}
		}
		return parsed;
	};

	function dataToDom(data) {
		var ul = document.createElement("ul");
		var num = data.length;

		// limited results to a max number
		if( (options.maxItemsToShow > 0) && (options.maxItemsToShow < num) ) num = options.maxItemsToShow;

		for (var i=0; i < num; i++) {
			var row = data[i];
			if (!row) continue;
			var li = document.createElement("li");
			if( i%2 == 0 )
				jQuery(li).addClass("ac_odd"); //li.className = 'ac_odd'; ou li.setAttribute('ac_odd');
			else
			{
				jQuery(li).addClass("ac_even");
			}
			if (options.formatItem) {
				li.innerHTML = options.formatItem(row, i, num);
				li.selectValue = row[0];
			} else {
				li.innerHTML = row[0];
				li.selectValue = row[0];
			}
			var extra = null;
			if (row.length > 1) {
				extra = [];
				for (var j=1; j < row.length; j++) {
					extra[extra.length] = row[j];
				}
			}
			li.extra = extra;
			ul.appendChild(li);
			jQuery(li).hover(
				function() { jQuery("li", ul).removeClass("ac_over"); jQuery(this).addClass("ac_over"); active = jQuery("li", ul).indexOf(jQuery(this).get(0)); },
				function() { jQuery(this).removeClass("ac_over"); }
			).click(function(e) { e.preventDefault(); e.stopPropagation(); selectItem(this) });
		}
		return ul;
	};

	function requestData(q) {
		//alert( 'Request:'+q);
		// retirado por problema de consultar sem lower() like Lower() no banco
		//if (!options.matchCase)
		//{
			//qlc = q.toLowerCase();
		//}
		if(options.removeMask)
		{
           	q = q.replace(/[^0-9]/g,'');
		}
		var data = options.cacheLength ? loadFromCache(q) : null;
		// recieve the cached data
		if (data)
		{
			//alert('Tem data');
			//alert( data );
			receiveData(q, data);
		// if an AJAX url has been supplied, try loading the data now
		}
		else if( (typeof options.url == "string") && (options.url.length > 0) )
		{
			//alert('Não tem data, vou buscar novamente no banco');
			jQuery.get(makeUrl(q), function(data) {
				if( data )
				{
					//alert( data );
					data = parseData(data);
					addToCache(q, data);
					receiveData(q, data);
				}
				else
				{
					alert(options.messageNotFound);
					if( options.clearOnNotFound )
					{
						input.value='';
					}
				}
			});
		// if there's been no data found, remove the loading class
		}
		else
		{
			//alert(msgNenhumaOpcao);
			alert(options.messageNotFound);
			$input.removeClass(options.loadingClass);
			input.value='';
		}
	};

	function makeUrl(q) {
		var url;
		// eugenio - alteração para detectar ?q ou &q
		if( options.url.indexOf('?')== -1 )
		{
			url = options.url + "?q=" + encodeURI(q);
		}
		else
		{
			url = options.url + "&q=" + encodeURI(q);
		}
		// eugenio - adaptação feita para ler os valores atuais dos campos do formulário que farão parte do filtro
		for( key in options.extraParams)
		{
			if( key.indexOf('_w_') == 0 )
			{
				var campoForm = key.replace('_w_','');
				var aCampoForm = campoForm.split('|');
				if( !aCampoForm[1] )
				{
					aCampoForm[1] = aCampoForm[0];
				}
				if( fwGetObj )
				{
					campoForm = fwGetObj( aCampoForm[0] );
					if( campoForm )
					{
						options.extraParams[key] = campoForm.value;
					}
				}

			}
		}
		for (var i in options.extraParams)
		{
			url += "&" + i + "=" + encodeURI(options.extraParams[i]);
		}
		return url;
	};
/*
"index.php?modulo=base/callbacks/autocomplete.php&ajax=1",
{ ajax:1, delay:1000, minChars:3, matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:fwAutoCompleteSelectItem, onFindValue:fwAutoCompleteFindValue, matchCase:false, maxItemsToShow:50, autoFill:true, selectFirst:true, mustMatch:false, selectOnly:true,removeMask:false,
extraParams:{"tablePackageFunction":"TESTE.PKG_TESTE.SEL_MUNICIPIO","searchField":"NOM_MUNICIPIO","cacheTime":0,"_u_COD_MUNICIPIO":"cod_municipio","_w_cod_uf":jQuery("#cod_uf").get(0).value} });
*/

	function loadFromCache(q) {
		if (!q) return null;

		var qlc = q;
		if ( !options.matchCase )
		{
			qlc = q.toLowerCase();
		}
		if (cache.data[qlc])
			return cache.data[qlc];
		if (options.matchSubset) {
			for (var i = q.length - 1; i >= options.minChars; i--) {
				var qs = q.substr(0, i);
				if ( !options.matchCase )
				{
            		var c = cache.data[qs.toLowerCase()];
				}
				else
				{
            		var c = cache.data[qs];
				}
				if (c) {
					var csub = [];
					for (var j = 0; j < c.length; j++) {
						var x = c[j];
						var x0 = x[0];
						if (matchSubset(x0, q)) {
							csub[csub.length] = x;
						}
					}
					return csub;
				}
			}
		}
		return null;
	};

	function matchSubset(s, sub) {
		if (!options.matchCase)
		{
			s = s.toLowerCase();
			sub = sub.toLowerCase();
		}
		var i = s.indexOf(sub);
		if (i == -1) return false;
		return i == 0 || options.matchContains;
	};

	this.flushCache = function() {
		flushCache();
	};

	this.setExtraParams = function(p) {
		options.extraParams = p;
	};

	this.findValue = function(){
		var q = $input.val();
		//---------------------------------------------------------------
		// adaptação eugenio para remover a máscara dos campos formatados
		//---------------------------------------------------------------
		if(options.removeMask )
		{
           	q = q.replace(/[^0-9]/g,'');
		}
		//------------------------------------------------------------
		// retirado por problema
		//if ( !options.matchCase )
		//{
			//q = q.toLowerCase();
		//}
		var data = options.cacheLength ? loadFromCache(q) : null;
		var result;
		//data=null;
		if (data)
		{
			result = findValueCallback(q, data);
		}
		else if( (typeof options.url == "string") && (options.url.length > 0) )
		{
			jQuery.get(makeUrl(q), function(data)
			{
				data = parseData(data)
				addToCache(q, data);
				result = findValueCallback(q, data);
			});
		} else {
			// no matches
			result = findValueCallback(q, null);
		}
		return result;
	}

	function findValueCallback(q, data){
		if (data) $input.removeClass(options.loadingClass);
		var num = (data) ? data.length : 0;
		var li = null;
		for (var i=0; i < num; i++)
		{
			var row = data[i];
			if( row[0].toLowerCase() == q.toLowerCase() ){
				li = document.createElement("li");
				if (options.formatItem) {
					li.innerHTML = options.formatItem(row, i, num);
					li.selectValue = row[0];
				} else {
					li.innerHTML = row[0];
					li.selectValue = row[0];
				}
				var extra = null;
				if( row.length > 1 ){
					extra = [];
					for (var j=1; j < row.length; j++) {
						extra[extra.length] = row[j];
					}
				}
				li.extra = extra;
			}
		}
		//---------------------------------------------------------------------------------
		// adaptação eugenio para retornar tambem o campo com o segundo parametro da função
		//---------------------------------------------------------------------------------
		if( options.onFindValue )
		{
			setTimeout(function() { options.onFindValue(li,$input.get(0)) }, 1);
			return true
		}
		return false;
	}

	function addToCache(q, data) {
		if (!data || !q || !options.cacheLength) return;
		if (!cache.length || cache.length > options.cacheLength) {
			flushCache();
			cache.length++;
		} else if (!cache[q]) {
			cache.length++;
		}
		if (!options.matchCase)
		{
			cache.data[q.toLowerCase()] = data;
		}
		else
		{
			cache.data[q] = data;
		}
	};

	function findPos(obj) {
		//console.log( obj.offset().top  );
		//console.log( obj.id  );
		var curleft = obj.offsetLeft || 0;
		// eugenio - ajustado problema com campo autocomplente com grupo dentro de grupo
		//var curtop = obj.offsetTop || 0;
		var curtop = jQuery("#"+obj.id).offset().top || 0;
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			//curtop += obj.offsetTop
		}
		return {x:curleft,y:curtop};
	}
}

jQuery.fn.autocomplete = function(url, options, data) {
	// Make sure options exists
	options = options || {};
	// Set url as option
	options.url = url;
	// set some bulk local data
	options.data = ((typeof data == "object") && (data.constructor == Array)) ? data : null;

	// Set default values for required options
	options.inputClass = options.inputClass || "ac_input";
	options.resultsClass = options.resultsClass || "ac_results";
	options.lineSeparator = options.lineSeparator || "\n";
	options.cellSeparator = options.cellSeparator || "|";
	options.minChars = options.minChars || 3;
	options.delay = options.delay || 400;
	options.matchCase = options.matchCase || 0;
	options.matchSubset = options.matchSubset || 1;
	options.matchContains = options.matchContains || 0;
	options.cacheLength = options.cacheLength || 1;
	options.mustMatch = options.mustMatch || 0;
	options.extraParams = options.extraParams || {};
	options.loadingClass = options.loadingClass || "ac_loading";
	options.selectFirst = options.selectFirst || true;
	options.selectOnly = options.selectOnly || true;
	options.maxItemsToShow = options.maxItemsToShow || 30;
	options.autoFill = options.autoFill || true;
	options.width = parseInt(options.width, 10) || 0;
	// eugenio - mais um parametro
	options.removeMask = options.removeMask || false;
	options.messageNotFound = options.messageNotFound || 'Nenhum registro encontrado';
	options.clearOnNotFound = options.clearOnNotFound || false;

	this.each(function() {
		var input = this;
		new jQuery.autocomplete(input, options);
	});

	// Don't break the chain
	return this;
}

jQuery.fn.autocompleteArray = function(data, options) {
	return this.autocomplete(null, options, data);
}

jQuery.fn.indexOf = function(e){
	for( var i=0; i<this.length; i++ ){
		if( this[i] == e ) return i;
	}
	return -1;
};