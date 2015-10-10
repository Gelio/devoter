var devoter = angular.module('devoter', ['ui.router', 'chartjs', 'mainPage', 'newPoll', 'popularPolls', 'viewPoll', 'polls']);

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


angular.element(document).ready(function() {
    angular.bootstrap(document, ['devoter']);
});