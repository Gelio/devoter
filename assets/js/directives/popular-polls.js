var popularPollsModule = angular.module('popularPolls', []);

popularPollsModule.controller('popularPollsCtrl', ['$scope', function($scope) {

}]);

popularPollsModule.directive('popularPolls', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/popular-polls.html',
        controller: 'popularPollsCtrl'
    };
});