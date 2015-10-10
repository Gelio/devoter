/**
 * A class fo unifying how polls are represented across the app
 *
 * @class Poll
 * @param {String} name
 * @param {Array} options       An array of Option objects
 * @param {Number} [totalVotes] If not passed as a number then the constructor counts it based on options
 * @uses Option
 * @constructor
 */
var Poll = function(name, options, totalVotes) {
    this.name = name;
    this.options = options;


    if(totalVotes === undefined)
        totalVotes = options.map(function(option) {
                return option.amount;
            }).reduce(function(last, current) {
                return last+current;
            });


    this.totalVotes = totalVotes;
};