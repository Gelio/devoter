/**
 * Used in the Poll class
 *
 * @class Option
 * @param {String} name
 * @param {Number} amount
 * @constructor
 */

// TODO: refactor this so that it takes an object as a parameter in order to allow for default options

var Option = function(name, amount) {
    this.name = name;
    this.amount = amount;
};