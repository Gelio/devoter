var mainPageModule = angular.module('mainPage', []);

mainPageModule.controller('mainPageCtrl', ['$scope', function($scope) {

}]);

mainPageModule.directive('main', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/main-page.html',
        controller: 'mainPageCtrl'
    };
});