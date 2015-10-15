angular.module('app.services').service('session', [
    '$http', '$q', 'ipCookie', '$location', function ($http, $q, ipCookie, $location) {

        var self = this;


        self.delete = function() {
            ipCookie.remove('authToken', { path: '/' });
            // Redirection.
            $location.path('/start');
        };

        self.check = function() {
            if(!ipCookie('authToken')) {
                $location.path('/start')
            }
        }

        self.currentUser = function() {
            return ipCookie('authToken');
        }
    }
]);