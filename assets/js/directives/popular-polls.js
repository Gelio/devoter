var popularPollsModule = angular.module('popularPolls', ['parserModule']);

popularPollsModule.controller('popularPollsCtrl', ['$scope', 'PollParser', function($scope, PollParser) {
    $scope.informatyka = "1";


    // TODO: add a proper URL
    $scope.polls = [];
    PollParser.fetchPolls('php/example-data.json', function(data) {
        $scope.polls = data;
    }, function(response) {
        // Error already printed
        // TODO: show error message
    }, {});
}]);

popularPollsModule.directive('popularPolls', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/popular-polls.html',
        controller: 'popularPollsCtrl'
    };
});