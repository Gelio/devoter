var pollModule = angular.module('polls', ['chartjs']);

pollModule.controller('pollCtrl', ['$scope', function($scope) {
    if(!$scope.data)
        console.error('Cannot retrieve information.');
    else {
        $scope.dataset = $scope.data.options.map(function(option) {
            return {
                value: option.amount,
                color: 'red',   // TODO: add proper colors from the config
                highlight: 'blue',
                label: option.name
            };
        });
        // TODO: adding colors to the dataset

        console.log($scope.dataset);
    }

}]);


pollModule.directive('poll', function() {
    return {
        restrict: 'E',
        controller: 'pollCtrl',
        templateUrl: 'assets/templates/poll.html',
        scope: {
            data: '=data'
        }
    };
});