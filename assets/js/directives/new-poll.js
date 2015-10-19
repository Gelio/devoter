var newPollModule = angular.module('newPoll', []);

function formatToDateTimePicker(date) {
    var day = date.getDate(),
        month = date.getMonth()+ 1,
        year = date.getFullYear(),
        hours = date.getHours(),
        minutes = date.getMinutes();

    if(day < 10)
        day = "0" + day;
    if(month< 10)
        month = "0" + month;
    if(hours< 10)
        hours = "0" + hours;
    if(minutes< 10)
        minutes = "0" + minutes;

    return day + "-" + month + "-" + year + " " + hours + ":" + minutes;
}

newPollModule.controller('newPollCtrl', ['$scope', "$http", function($scope, $http) {
    var currDate = new Date();

    $scope.newPoll = new Poll({
        options: [new Option({}), new Option({})],
        expDate: formatToDateTimePicker(new Date(currDate.getTime() + minPollLength*1000))
    });
    $scope.newPoll.private = false;

    $scope.examplePoll = new Poll({
        name: "Example name",
        options: [
            new Option({name: "Example option 1"}),
            new Option({name: "Example option 2"})
        ]
    });

    $scope.addNewOption = function() {
        $scope.newPoll.options.push(new Option({}));
    };

    $scope.removeOption = function(index) {
        $scope.newPoll.options.splice(index, 1);
    };

    $scope.addNewPoll = function() {
        if($scope.newPollForm.$invalid)
            return;

        var dateSplit = {},
            spaced = $scope.newPoll.expDate.split(' ');
        dateSplit.date = spaced[0].split('-');
        dateSplit.time = spaced[1].split(":");

        $http.post("php/dodaj_ankiete.php", {
            name: $scope.newPoll.name,
            options: $scope.newPoll.options,
            private: $scope.newPoll.private,
            expDate: Math.round(new Date(dateSplit.date[2], dateSplit.date[1], dateSplit.date[0],
                    dateSplit.time[0], dateSplit.time[1], 0, 0).getTime()/1000)
        })
            .then(function(response) {
                console.log('added properly', response);
            }, function(response) {
                console.log('error while adding a poll', response);
            });
    };
}]);

newPollModule.directive('newPoll', function() {
    return {
        restrict: 'E',
        templateUrl: 'assets/templates/new-poll.html',
        controller: 'newPollCtrl'
    };
});