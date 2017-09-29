
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

var idleTime 						= 2000; // number of miliseconds until the user is considered idle
var initialSessionTimeoutMessage 	= 'Your session will expire in <span id="sessionTimeoutCountdown"></span>&nbsp;seconds.<br/><br />Click on <b>OK</b> to continue your session.';
var sessionTimeoutCountdownId 		= 'sessionTimeoutCountdown';
var redirectAfter 					= 10; // number of seconds to wait before redirecting the user
var redirectTo 						= 'index.php'; // URL to relocate the user to once they have timed out
var keepAliveURL 					= 'keepAlive.php'; // URL to call to keep the session alive
var expiredMessage 					= 'Your session has expired.  You are being logged out for security reasons.'; // message to show user when the countdown reaches 0
var running 						= false; // var to check if the countdown is running
var timer; // reference to the setInterval timer so it can be stopped
jQuery(document).ready(function() {
	// create the warning window and set autoOpen to false
	var sessionTimeoutWarningDialog = jQuery("#sessionTimeoutWarning");
	jQuery(sessionTimeoutWarningDialog).html(initialSessionTimeoutMessage);
	jQuery(sessionTimeoutWarningDialog).dialog({
		title: 'Session Expiration Warning',
		autoOpen: false,	// set this to false so we can manually open it
		closeOnEscape: false,
		draggable: false,
		width: 460,
		minHeight: 50, 
		modal: true,
		beforeclose: function() { // bind to beforeclose so if the user clicks on the "X" or escape to close the dialog, it will work too
			// stop the timer
			clearInterval(timer);
				
			// stop countdown
			running = false;
			
			// ajax call to keep the server-side session alive
			jQuery.ajax({
			  url: keepAliveURL,
			  async: false
			});
		},
		buttons: {
			OK: function() {
				// close dialog
				jQuery(this).dialog('close');
			}
		},
		resizable: false,
		open: function() {
			// scrollbar fix for IE
			jQuery('body').css('overflow','hidden');
		},
		close: function() {
			// reset overflow
			jQuery('body').css('overflow','auto');
		}
	}); // end of dialog


	// start the idle timer
	jQuery.idleTimer(idleTime);
	
	// bind to idleTimer's idle.idleTimer event
	jQuery(document).bind("idle.idleTimer", function(){
		// if the user is idle and a countdown isn't already running
		if(jQuery.data(document,'idleTimer') === 'idle' && !running){
			var counter = redirectAfter;
			running = true;
			
			// intialisze timer
			jQuery('#'+sessionTimeoutCountdownId).html(redirectAfter);
			// open dialog
			jQuery(sessionTimeoutWarningDialog).dialog('open');
			
			// create a timer that runs every second
			timer = setInterval(function(){
				counter -= 1;
				
				// if the counter is 0, redirect the user
				if(counter === 0) {
					jQuery(sessionTimeoutWarningDialog).html(expiredMessage);
					jQuery(sessionTimeoutWarningDialog).dialog('disable');
					window.location = redirectTo;
				} else {
					jQuery('#'+sessionTimeoutCountdownId).html(counter);
				};
			}, 1000);
		};
	});
});
