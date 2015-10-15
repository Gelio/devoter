var newPollModule = angular.module('newPoll', []);

newPollModule.controller('newPollCtrl', ['$scope', function($scope) {
    $scope.newPoll = {
        name: '',
        options: [],
        private: false,
        expDate: new Date()
    };

    $scope.examplePoll = new Poll(0, "Example name", [
        new Option("Example option 1", 0),
        new Option("Example option 2", 0)
    ]);

    $scope.addNewOption = function() {
        $scope.newPoll.options.push(new Option());
    };

    // TODO: when sending a request convert expDate to UNIX timestamp
}]);

newPollModule.directive('newPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/new-poll.html',
        controller: 'newPollCtrl'
    };
});