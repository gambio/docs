/* --------------------------------------------------------------
 preview.js 2015-10-05 gm
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2015 Gambio GmbH
 Released under the GNU General Public License (Version 2)
 [http://www.gnu.org/licenses/gpl-2.0.html]
 -------------------------------------------------------------- */

// Previews the HTML examples.

;(function ($) {
    'use strict';

    $('div[data-preview]').each(function() {
       $(this).load($(this).attr('data-preview')); 
    });

})(jQuery); 