var mainPageModule = angular.module('mainPage', ['parserModule']);

mainPageModule.controller('mainPageCtrl', ['$scope', 'PollParser', function($scope, PollParser) {
    /*$scope.topPolls = [
        new Poll(0, 'Poll 1', [
                new Option('A', 10),
                new Option('B', 10),
                new Option('C', 20)
            ],
            new Date()),
        new Poll(1, 'Poll 2', [
                new Option('A', 40),
                new Option('B', 80),
                new Option('C', 20)
            ],
            new Date()),
        new Poll(2, 'Poll 3', [
                new Option('A', 454),
                new Option('B', 564),
                new Option('C', 156)
            ],
            new Date())
    ];*/
    $scope.topPolls = null;

    PollParser.fetchPolls('php/example-data.json', function(data) {
        $scope.topPolls = data;
    }, function(response) {
        // Error already logged
        // TODO: add proper error display
    }, {limitTo: 3}, false);   // TODO: Set the last parameter to true
}]);

mainPageModule.directive('main', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/main-page.html',
        controller: 'mainPageCtrl'
    };
});