angular.module('app.controllers').controller('homeController', [
    'sessionService', function (sessionService) {
        var self = this;
        sessionService.init();

    }
]);