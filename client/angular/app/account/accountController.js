angular.module('app.controllers').controller('accountController', [
    'sessionService', '$scope', function (sessionService, $scope) {
        var self = this;
        sessionService.init();


        $scope.deconnexionAccount  = function() {
            sessionService.delete();
        }
    }
]);