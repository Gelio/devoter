var devoter = angular.module('devoter', ['ui.router', 'chartjs', 'chart.js', 'mainPage', 'newPoll', 'popularPolls', 'viewPoll', 'polls']);

devoter.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('main', {
            url: '/',
            template: '<main></main>'
        })
        .state('popular-polls', {
            url: '/popular-polls',
            template: '<popular-polls></popular-polls>'
        })
        .state('new-poll', {
            url: '/new-poll',
            template: '<new-poll></new-poll>'
        })
        .state('view-poll', {
            url: '/poll/{pollID:[0-9]+}',
            template: '<view-poll></view-poll>'
        });
}]);

devoter.filter('percent', function() {
    return function(input) {
        input = input || 0;
        input *= 100;
        if(input - Math.floor(input) !== 0)
            input = Math.floor(input);

        return input/100;
    };
});

angular.element(document).ready(function() {
    angular.bootstrap(document, ['devoter']);
});

// Make charts responsive
//Chart.defaults.global.responsive = true;
Chart.defaults.global.animation = false;
console.log(Chart.defaults.global);