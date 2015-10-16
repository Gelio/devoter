var newPollModule = angular.module('newPoll', []);

newPollModule.controller('newPollCtrl', ['$scope', "$http", function($scope, $http) {
    var currDate = new Date();
    $scope.newPoll = new Poll({
        options: [new Option({}), new Option({})],
        expDate: currDate.getDate() + "-" + (currDate.getMonth()+1) + "-" +
            currDate.getFullYear() + " " + currDate.getHours() + ":" + currDate.getMinutes()
    });

    $scope.examplePoll = new Poll({
        name: "Example name",
        options: [
            new Option({name: "Example option 1"}),
            new Option({name: "Example option 2"})
        ]
    });

    $scope.addNewOption = function() {
        $scope.newPoll.options.push(new Option({}));
    };

    $scope.removeOption = function(index) {
        $scope.newPoll.options.splice(index, 1);
    };

    // TODO: when sending a request convert expDate to UNIX timestamp
    $scope.addNewPost = function() {
        
    };
}]);

newPollModule.directive('newPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/new-poll.html',
        controller: 'newPollCtrl'
    };
});