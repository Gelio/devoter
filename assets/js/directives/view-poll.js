var viewPollsModule = angular.module('viewPoll', ['ui.router']);

viewPollsModule.controller('viewPollCtrl', ['$scope', '$stateParams', 'PollParser', function($scope, $stateParams, PollParser) {
    /*$scope.poll = new Poll(
        $stateParams.pollID,
        "Poll name",
        [
            new Option('A', 10),
            new Option('B', 20),
            new Option('C', 10)
        ],
        new Date()
    );*/
    $scope.poll = null;

    PollParser.fetchPolls('php/example-data.json', function(poll) {
        $scope.poll = poll[0];  // TODO: after adding proper API remove this index
    }, function(response) {
        // Error already printed
        // TODO: proper error handling and message display
    }, {id: $stateParams.pollID});  // TODO: add another parameter set to true, so that it uses POST
}]);

viewPollsModule.directive('viewPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/view-poll.html',
        controller: 'viewPollCtrl'
    };
});