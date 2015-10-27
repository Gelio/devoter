var mainPageModule = angular.module('mainPage', ['parserModule']);

mainPageModule.controller('mainPageCtrl', ['$scope', 'PollParser', function($scope, PollParser) {
    $scope.topPolls = null;

    PollParser.fetchPolls('php/polls-list.php', function(data) {
        $scope.topPolls = data;
    }, function(response) {
        // Error already logged
        // TODO: add proper error display
    }, {limitTo: 3}, false);
}]);

mainPageModule.directive('main', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/main-page.html',
        controller: 'mainPageCtrl'
    };
});