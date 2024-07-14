/* --------------------------------------------------------------
 add_bulk_column.js 2016-06-09
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2016 Gambio GmbH
 Released under the GNU General Public License (Version 2)
 [http://www.gnu.org/licenses/gpl-2.0.html]
 --------------------------------------------------------------
 */

/**
 * Add bulk action on document ready.
 */
$(function() {
	
	'use strict';
	
	var $table = $('.table-main'); 
	
	// Wait for the table to be initialized. 
	$table.on('init.dt', function() {
		// Check whether this is the default action. 
		var isDefault = $table.data('defaultBulkAction') === 'custom-bulk-action'; 
		
		// Add a custom action in the .bulk-action dropdown element. 
		jse.libs.button_dropdown.addAction($('.bulk-action'), {
			/**
			 * The text to be displayed. 
			 * 
			 * @type {String}
			 */
			text: 'Custom Bulk Action', 
			
			/**
			 * URL for the <a> element.
			 * 
			 * @type {String}
			 */
			href: '#',
			
			/**
			 * Target attribute for <a> element.
			 * 
			 * @type {String}
			 */
			target: '',
			
			/**
			 * Add custom classes to the <a> element.
			 * 
			 * @type {String}
			 */
			class: 'custom-bulk-action',
			
			/**
			 * Add data to the <a> element.
			 * 
			 * The "configurationValue" is needed for remembering the user's choice after page reload.
			 * 
			 * @type {Object}
			 */
			data: {configurationValue: 'custom-bulk-action'},
			
			/**
			 * Whether the action is the default action.
			 * 
			 * @type {Boolean}
			 */
			isDefault: isDefault,
			
			/**
			 * Callback for click event of the <a> element.
			 * 
			 * If you want to disable the normal <a> click behavior do not forget to execute the "e.preventDefault();"
			 * in the callback function. 
			 * 
			 * @type {Function}
			 */
			callback: function(e) {
				e.preventDefault(); 
				
				var orders = []; 
				
				$table.find('tbody input:checked').each(function() {
					orders.push($(this).parents('tr').data('id')); // Row data are bound in the parent <tr> element.
				}); 
				
				alert('Clicked the custom bulk action for orders: ' + orders.join(',')); 
			}  
		});
	});
	
}); 