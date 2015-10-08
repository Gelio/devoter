var newPollModule = angular.module('newPoll', []);

newPollModule.controller('newPollCtrl', ['$scope', function($scope) {

}]);

newPollModule.directive('newPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/new-poll.html',
        controller: 'newPollCtrl'
    }
});