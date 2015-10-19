var popularPollsModule = angular.module('popularPolls', ['parserModule']);

popularPollsModule.controller('popularPollsCtrl', ['$scope', 'PollParser', function($scope, PollParser) {

    // TODO: add a proper URL 'php/all-polls.php'
    $scope.polls = [];
    PollParser.fetchPolls('php/example-data.json', function(data) {
        $scope.polls = data;
    }, function(response) {
        // Error already printed
        // TODO: show error message
    }, {startFrom: 0, limitTo: 20}, false);
}]);

popularPollsModule.directive('popularPolls', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/popular-polls.html',
        controller: 'popularPollsCtrl'
    };
});