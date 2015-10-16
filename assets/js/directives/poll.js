var pollModule = angular.module('polls', ['chartjs']);

pollModule.controller('pollCtrl', ['$scope', '$timeout', function($scope, $timeout) {
    if(!$scope.data)
        console.error('Cannot retrieve information.');
    else {
        /*$scope.dataset = $scope.data.options.map(function(option) {
            return {
                value: option.amount,
                label: option.name
            };
        });*/

        // angular-chart.js Chart data
        $scope.optionsData = $scope.data.options.map(function(option) {
            return option.amount;
        });
        $scope.optionsLabels = $scope.data.options.map(function(option) {
            return option.name;
        });
        
        /*$scope.dataset.forEach(function(dataset, index) {
            dataset.color = chartColors[index].color;
            dataset.highlight = chartColors[index].highlight;
        });*/
    }

}]);


pollModule.directive('poll', function() {
    return {
        restrict: 'E',
        controller: 'pollCtrl',
        templateUrl: 'assets/templates/poll.html',
        scope: {
            data: '=',
            fullscreen: '='
        }
    };
});