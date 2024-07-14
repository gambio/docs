/**
 * Overload/Extend the jse.libs.orders_overview_columns on document ready event.
 *
 * You can modify the existing column definitions of the jse.libs.orders_overview_columns object
 * or add your own column definition in cooperation with the OrdersOverviewColumns and the respective
 * controller classes.
 */
$(function() {
    'use strict';

    // Be careful to not overwrite existing object definitions.
    jse.libs.orders_overview_columns = jse.libs.orders_overview_columns || {};

	// Custom column definition.
    jse.libs.orders_overview_columns.customTest = {
        data: 'customTest',
        minWidth: '75px',
        widthFactor: 0.9
    };
});