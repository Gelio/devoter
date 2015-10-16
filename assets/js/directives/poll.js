var pollModule = angular.module('polls', ['chartjs']);

pollModule.controller('pollCtrl', ['$scope', '$http', function($scope, $http) {
    if(!$scope.data)
        console.error('Cannot retrieve information.');
    else {
        // angular-chart.js Chart data
        $scope.optionsData = $scope.data.options.map(function(option) {
            return option.amount;
        });
        $scope.optionsLabels = $scope.data.options.map(function(option) {
            return option.name;
        });

        $scope.addVote = function(index) {
            // TODO: send data to script, change poll's optionsData, update 'hasVoted', display msg
            if($scope.data.hasVoted)
                return;

            //$http.post()
        };
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