/*
 * LazyLoad makes it easy and painless to lazily load one or more external
 * JavaScript or CSS files on demand either during or after the rendering of
 * a web page.
 *
 * Supported browsers include Firefox 2, Firefox 3, IE 6 through 8, Safari 3 and
 * 4 (including iPhone), Chrome, and Opera 9 and 10. Other browsers may or may
 * not work and are not officially supported.
 *
 * Visit http://github.com/rgrove/lazyload/ or
 * http://wonko.com/post/lazyload-200-released for more info.
 *
 * Copyright (c) 2009 Ryan Grove <ryan@wonko.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *   * Neither the name of this project nor the names of its contributors may be
 *     used to endorse or promote products derived from this software without
 *     specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @module lazyload
 * @version 2.0.0
*/

LazyLoad=function(){var f=document,g,b={},e={css:[],js:[]},a;function j(l,k){var m=f.createElement(l),d;for(d in k){if(k.hasOwnProperty(d)){m.setAttribute(d,k[d])}}return m}function h(d){var l=b[d];if(!l){return}var m=l.callback,k=l.urls;k.shift();if(!k.length){if(m){m.call(l.scope||window,l.obj)}b[d]=null;if(e[d].length){i(d)}}}function c(){if(a){return}var k=navigator.userAgent,l=parseFloat,d;a={gecko:0,ie:0,opera:0,webkit:0};d=k.match(/AppleWebKit\/(\S*)/);if(d&&d[1]){a.webkit=l(d[1])}else{d=k.match(/MSIE\s([^;]*)/);if(d&&d[1]){a.ie=l(d[1])}else{if((/Gecko\/(\S*)/).test(k)){a.gecko=1;d=k.match(/rv:([^\s\)]*)/);if(d&&d[1]){a.gecko=l(d[1])}}else{if(d=k.match(/Opera\/(\S*)/)){a.opera=l(d[1])}}}}}function i(r,q,s,m,t){var n,o,l,k,d;c();if(q){q=q.constructor===Array?q:[q];if(r==="css"||a.gecko||a.opera){e[r].push({urls:[].concat(q),callback:s,obj:m,scope:t})}else{for(n=0,o=q.length;n<o;++n){e[r].push({urls:[q[n]],callback:n===o-1?s:null,obj:m,scope:t})}}}if(b[r]||!(k=b[r]=e[r].shift())){return}g=g||f.getElementsByTagName("head")[0];q=k.urls;for(n=0,o=q.length;n<o;++n){d=q[n];if(r==="css"){l=j("link",{href:d,rel:"stylesheet",type:"text/css"})}else{l=j("script",{src:d})}if(a.ie){l.onreadystatechange=function(){var p=this.readyState;if(p==="loaded"||p==="complete"){this.onreadystatechange=null;h(r)}}}else{if(r==="css"&&(a.gecko||a.webkit)){setTimeout(function(){h(r)},50*o)}else{l.onload=l.onerror=function(){h(r)}}}g.appendChild(l)}}return{css:function(l,m,k,d){i("css",l,m,k,d)},js:function(l,m,k,d){i("js",l,m,k,d)}}}();
