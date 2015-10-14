var popularPollsModule = angular.module('popularPolls', []);

popularPollsModule.controller('popularPollsCtrl', ['$scope', function($scope) {
    $scope.informatyka = "1";
    $scope.polls = [
        new Poll(0, 'Poll 1', [
                new Option('A', 10),
                new Option('B', 10),
                new Option('C', 20)
            ],
            'today'),
        new Poll(1, 'Poll 2', [
                new Option('A', 40),
                new Option('B', 80),
                new Option('C', 20)
            ],
            'today'),
        new Poll(2, 'Poll 3', [
                new Option('A', 454),
                new Option('B', 564),
                new Option('C', 156)
            ],
            'today')
    ];
    // TODO: pull polls from external API file
}]);

popularPollsModule.directive('popularPolls', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/popular-polls.html',
        controller: 'popularPollsCtrl'
    };
});