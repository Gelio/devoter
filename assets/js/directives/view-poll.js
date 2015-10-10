var viewPollsModule = angular.module('viewPoll', ['ui.router']);

viewPollsModule.controller('viewPollCtrl', ['$scope', '$stateParams', function($scope, $stateParams) {

}]);

viewPollsModule.directive('viewPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/view-poll.html',
        controller: 'viewPollCtrl'
    };
});