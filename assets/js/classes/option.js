/**
 * Used in the Poll class
 *
 * @class Option
 * @param {Object} params   Used in order to allow for optional parameters
 * @constructor
 */

var Option = function(params) {
    if(!params)
        params = {};

    this.name = params.name || "";
    this.amount = params.amount || 0;
};