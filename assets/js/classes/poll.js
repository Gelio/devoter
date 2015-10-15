/**
 * A class fo unifying how polls are represented across the app
 *
 * @class Poll
 * @param {Number} id
 * @param {String} name
 * @param {Array} options       An array of Option objects
 * @param {Date} expDate
 * @param {Number} [totalVotes] If not passed as a number then the constructor counts it based on options
 * @uses Option
 * @constructor
 */

// TODO: add param to indicate whether the user has already voted or not
// TODO: refactor this so that it takes in an object as a parameter to allow for default or limited options
// TODO: then also change it in all functions (probably only in the PollParser factory)
var Poll = function(id, name, options, expDate, totalVotes) {
    this.id = id;
    this.name = name;
    this.options = options;
    this.expDate = expDate;


    if(totalVotes === undefined)
        totalVotes = options.map(function(option) {
                return option.amount;
            }).reduce(function(last, current) {
                return last+current;
            });


    this.totalVotes = totalVotes;
};