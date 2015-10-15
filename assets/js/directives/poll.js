var pollModule = angular.module('polls', ['chartjs']);

pollModule.controller('pollCtrl', ['$scope', function($scope) {
    if(!$scope.data)
        console.error('Cannot retrieve information.');
    else {
        $scope.dataset = $scope.data.options.map(function(option) {
            return {
                value: option.amount,
                label: option.name
            };
        });

        // TODO: install angular-chart.js and configure it
        // http://jtblin.github.io/angular-chart.js/#getting_started
        // catch the 'create' event and resize it like there
        // https://github.com/jtblin/angular-chart.js/issues/74
        
        $scope.dataset.forEach(function(dataset, index) {
            dataset.color = chartColors[index].color;
            dataset.highlight = chartColors[index].highlight;
        });

        console.log($scope.dataset);
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