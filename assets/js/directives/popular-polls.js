var popularPollsModule = angular.module('popularPolls', ['parserModule']);

popularPollsModule.controller('popularPollsCtrl', ['$scope', 'PollParser', function($scope, PollParser) {

    $scope.polls = [];
    PollParser.fetchPolls('php/most-popular.php', function(data) {
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