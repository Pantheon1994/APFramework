angular.module('app').config([
    '$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {

        $urlRouterProvider.otherwise("/");

        $stateProvider.state('/', {
            url: "/",
            templateUrl: "client/angular/app/start/start.html",
            controller: 'startController',
            controllerAs: 'start'
        });
    }
]);