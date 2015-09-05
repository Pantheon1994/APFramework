angular.module('app').config([
    '$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise("home");

        $stateProvider.state('home', {
            url: "/home",
            templateUrl: "client/angular/app/home/home.html",
            controller: 'homeController',
            controllerAs: 'home'
        });

        $stateProvider.state('account', {
            url: "/account",
            templateUrl: "client/angular/app/account/account.html",
            controller: 'accountController',
            controllerAs: 'account'
        });
    }
]);