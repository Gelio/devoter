var viewPollsModule = angular.module('viewPoll', ['ui.router']);

viewPollsModule.controller('viewPollCtrl', ['$scope', '$stateParams', 'PollParser', function($scope, $stateParams, PollParser) {
    $scope.pollURL = window.location.href;
    $scope.poll = null;

    PollParser.fetchPolls('php/show-poll.php', function(poll) {
        $scope.poll = poll;
    }, function(response) {
        // Error already printed
        // TODO: proper error handling and message display
    }, {id: $stateParams.pollID}, false);
}]);

viewPollsModule.directive('viewPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/view-poll.html',
        controller: 'viewPollCtrl'
    };
});