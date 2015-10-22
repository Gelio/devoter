/**
 * A class for unifying how polls are represented across the app
 *
 * @class Poll
 * @param {Object} params       Used in order to allow for optional parameters
 * @uses Option
 * @constructor
 */

var Poll = function(params) {
    if(!params)
        params = {};

    this.id = params.id || 0;
    this.name = params.name || '';
    this.options = params.options || [];

    if(this.options.length !== 0) {
        this.options = this.options.map(function(option) {
            option.amount = parseInt(option.amount);
            return option;
        });
    }

    this.expDate = params.expDate || new Date();

    this.hasVoted = params.hasVoted;

    this.private = params.private || false;


    if(params.totalVotes === undefined)
        params.totalVotes = this.options.map(function(option) {
                return option.amount;
            }).reduce(function(last, current) {
                return last+current;
            });


    this.totalVotes = params.totalVotes;
};