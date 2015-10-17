var pollModule = angular.module('polls', ['chart.js']);

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
            if($scope.data.hasVoted)
                return;

            $scope.data.hasVoted = true;

            $http.post("php/glosuj.php", {id: $scope.data.id, optionID: index})
                .then(function(response) {
                    console.log("vote added", response);
                    $scope.optionsData[index] += 1;
                    $scope.data.options[index].amount += 1;
                    // TODO: display message
                }, function(response) {
                   console.error("error while voting", response);
                });
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