var viewPollsModule = angular.module('viewPoll', ['ui.router']);

viewPollsModule.controller('viewPollCtrl', ['$scope', '$stateParams', function($scope, $stateParams) {
    console.log($stateParams);
    // TODO: fetch poll from external API
    $poll = new Poll(
        $stateParams.pollID,
        "Poll name",
        [
            new Option('A', 10),
            new Option('B', 20),
            new Option('C', 10)
        ],
        'today'
    );
}]);

viewPollsModule.directive('viewPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/view-poll.html',
        controller: 'viewPollCtrl'
    };
});