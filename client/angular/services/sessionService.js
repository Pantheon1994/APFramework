angular.module('app.services').service('sessionService', [
    '$http', '$q', 'ipCookie', '$location', function ($http, $q, ipCookie, $location) {
        var self = this;

        self.init = function() {
            if(!ipCookie('authToken')) {
                $location.path('/home');
            } else {
                $location.path('/account');
            }
        };

        self.delete = function() {
            ipCookie.remove('authToken', { path: '/' });

            // Redirection.
            $location.path('/home');
        }
    }
]);