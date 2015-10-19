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

    // TODO: proper URL 'php/single-poll.php'
    PollParser.fetchPolls('php/example-data.json', function(poll) {
        $scope.poll = poll[$stateParams.pollID];  // TODO: after adding proper API remove this index
    }, function(response) {
        // Error already printed
        // TODO: proper error handling and message display
    }, {id: $stateParams.pollID}, true);
}]);

viewPollsModule.directive('viewPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/view-poll.html',
        controller: 'viewPollCtrl'
    };
});