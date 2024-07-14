/* --------------------------------------------------------------
 add_row_action.js 2016-06-09
 Gambio GmbH
 http://www.gambio.de
 Copyright (c) 2016 Gambio GmbH
 Released under the GNU General Public License (Version 2)
 [http://www.gnu.org/licenses/gpl-2.0.html]
 --------------------------------------------------------------
 */

/**
 * Add a custom row action to the table.
 * 
 * This sample demonstrates the way you can add a custom row action that could be a link or execute a specific 
 * callback on click event. The action will need to be added to the table with every new draw, so be careful 
 * when binding the draw event handler. 
 */
$(function() {
	
	'use strict';
	
	var $table = $('.table-main'); 
	
	// Wait for the table to be initialized. 
	$table.on('init.dt', function() {
		
		function _addRowAction() {
			// Check whether this is the default action. 
			var isDefault = $table.data('defaultRowAction') === 'custom-row-action';
			
			// Iterate through each dropdown widget of the table.
			$table.find('tbody .btn-group.dropdown').each(function(index, dropdown) {
				
				// Get the the current order's data (bound in the <tr> element).  
				var order = $(this).parents('tr').data();
				
				// Add a custom action in the row dropdown element. 
				jse.libs.button_dropdown.addAction($(dropdown), {
					/**
					 * The text to be displayed.
					 *
					 * @type {String}
					 */
					text: 'Custom Row Action - #' + order.id,
					
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
					class: 'custom-row-action',
					
					/**
					 * Add data to the <a> element.
					 *
					 * The "configurationValue" is needed for remembering the user's choice after page reload.
					 *
					 * @type {Object}
					 */
					data: {configurationValue: 'custom-row-action'},
					
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
						alert('Clicked the custom row action for order: ' + order.id);
					}
				});
			});
		}
		
		// Add the custom action on every draw of the table. 
		$table.on('draw.dt', _addRowAction);
		
		// Execute the method for the initial draw.
		_addRowAction(); 
	});
	
}); 