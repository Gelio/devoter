var parserModule = angular.module('parserModule', []);

parserModule.factory('PollParser', ['$http', function($http) {
    var parserFactory = function() {};

    /**
     * Parses poll's option
     * @param optionData
     * @returns {Option}
     */
    parserFactory.parseOption = function(optionData) {
        if(optionData && optionData.name)
            return new Option({id: optionData.id, name: optionData.name, amount: optionData.amount});
        else {
            console.error("error while parsing data, can't find amount or name of the option", optionData);
            throw "Option data missing";
        }
    };

    /**
     * Parses a single poll checking for all parameters and returns it back as an object
     *
     * @param pollData
     * @returns {Poll}
     */
    parserFactory.parsePoll = function(pollData) {
        if(pollData && pollData.name && pollData.id && pollData.options && pollData.expDate) {
            // Parse all options
            var optionsList = [];
            pollData.options.forEach(function(option) {
                optionsList.push(parserFactory.parseOption(option));
            });

            var expDate = new Date(pollData.expDate);
            //expDate.setTime(pollData.expDate*1000);  // number in miliseconds
            //console.log(expDate, pollData.expDate);

            return new Poll({
                id: pollData.id,
                name: pollData.name,
                options: optionsList,
                expDate: expDate.getTime(),
                private: pollData.private || false,
                hasVoted: pollData.hasVoted || false,
                totalVotes: (pollData.totalVotes || undefined)
            });
        }
        else {
            console.error("error while parsing data, missing poll data", pollData);
            throw "Poll data missing";
        }
    };

    /**
     * Parses polls returned from a specific URL. Uses callbacks to return data
     * Returns to callback either a Poll or an array of Poll objects.
     *
     * @param {String} baseUrl      Base URL
     * @param {Function} successCallback
     * @param {Function} errorCallback
     * @param {Object} data         Data to be sent via either GET or POST
     * @param {Boolean} [usePost]   If set to true request will be using POST
     */
    parserFactory.fetchPolls = function(baseUrl, successCallback, errorCallback, data, usePost) {
        var httpRequestConfig = {
            url: baseUrl
        };

        if(usePost) {
            httpRequestConfig.method = "POST";
            httpRequestConfig.data = data;
        }
        else {
            httpRequestConfig.method = "GET";
            httpRequestConfig.params = data;
        }

        console.log(httpRequestConfig);

        $http(httpRequestConfig).then(
            function(response) {
                // Success
                console.log(response);
                var outputData;

                if(Array.isArray(response.data)) {
                    // Array of polls
                    outputData = [];
                    response.data.forEach(function(poll) {
                        outputData.push(parserFactory.parsePoll(poll));
                    });
                }
                else {
                    outputData = parserFactory.parsePoll(response.data);
                }

                successCallback(outputData);
            },
            function(response) {
                // Error
                console.error(response);
                errorCallback(response);
            });
    };

    return parserFactory;
}]);