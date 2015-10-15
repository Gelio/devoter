var newPollModule = angular.module('newPoll', []);

newPollModule.controller('newPollCtrl', ['$scope', function($scope) {
    $scope.newPoll = {
        name: '',
        options: [new Option("", 0), new Option("", 0)],
        private: false,
        expDate: ''
    };

    $scope.examplePoll = new Poll(0, "Example name", [
        new Option("Example option 1", 0),
        new Option("Example option 2", 0)
    ]);

    $scope.addNewOption = function() {
        $scope.newPoll.options.push(new Option());
    };

    $scope.removeOption = function(index) {
        $scope.newPoll.options.splice(index, 1);
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