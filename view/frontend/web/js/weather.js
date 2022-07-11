define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, Component, customerData) {
    'use strict'

    return Component.extend({
        initialize: function() {
            this._super();

            this.weather = customerData.get('weather');
            customerData.reload(['weather'], true);
        }
    })
});
