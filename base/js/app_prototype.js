
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

// Overide WindowUtilities getPageSize to remove dock height (for maximized windows)
WindowUtilities._oldGetPageSize = WindowUtilities.getPageSize;
WindowUtilities.getPageSize = function() {
  var size = WindowUtilities._oldGetPageSize();
  var dockHeight = $('dock').getHeight();

  size.pageHeight -= dockHeight;
  size.windowHeight -= dockHeight;
  return size;
};


// Overide Windows minimize to move window inside dock
Object.extend(Windows, {
  // Overide minimize function
  minimize: function(id, event) {
    var win = this.getWindow(id)
    if (win && win.visible) {
      // Hide current window
      win.hide();

      // Create a dock element
      var element = document.createElement("span");
      element.className = "dock_icon";
      element.title = 'Restaurar';
      element.style.display = "none";
      element.win = win;
      $('dock').appendChild(element);
      Event.observe(element, "mouseup", Windows.restore);
      $(element).update(win.getTitle());

      new Effect.Appear(element)
    }
    Event.stop(event);
  },

  // Restore function
  restore: function(event) {
    var element = Event.element(event);
    // Show window
    element.win.show();
    //Windows.focus(element.win.getId());
    element.win.toFront();
    // Fade and destroy icon
    new Effect.Fade(element, {afterFinish: function() {element.remove()}})
  }
})

// blur focused window if click on document
Event.observe(document, "click", function(event) {
  var e = Event.element(event);
  var win = e.up(".dialog");
  var dock = e == $('dock') || e.up("#dock");
  if (!win && !dock && Windows.focusedWindow) {
    Windows.blur(Windows.focusedWindow.getId());
  }
})

// Chnage theme callback
var currentTheme = 0;
function changeTheme(event) {
  var index = Event.element(event).selectedIndex;
  if (index == currentTheme)
    return;

  var theme, blurTheme;
  switch (index) {
    case 0:
      theme = "alphacube";
      blurTheme = "blur_os_x";
      break;
    case 1:
      theme = "mac_os_x";
      blurTheme = "blur_os_x";
      break;
    case 2:
      theme = "bluelighting";
      blurTheme = "greylighting";
      break;
    case 3:
      theme = "greenlighting";
      blurTheme = "greylighting";
      break;
  }
  Windows.windows.each(function(win) {
    win.options.focusClassName = theme;
    win.options.blurClassName = blurTheme;
    win.changeClassName(blurTheme)
  });
  Windows.focusedWindow.changeClassName(theme);
  currentTheme = index;
}

// Init webOS
function initWebOS() {
  //$$("#theme select").first().selectedIndex = currentTheme;
  //Event.observe($$("#theme select").first(), "change", changeTheme);
  //----------------------------------------------------------------
  WindowCloseKey.init();
  //----------------------------------------------------------------
}
Event.observe(window, "load", initWebOS);
//---------------------------------------------------------------------
